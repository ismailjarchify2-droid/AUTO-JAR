<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVehicleCompatibility;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()->with(['brand', 'category']);

        if ($request->filled('q')) {
            $query->search($request->q);
        }

        $products = $query->latest()->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product,
            'brands' => Brand::query()->orderBy('name')->get(),
            'categories' => Category::query()->orderBy('sort_order')->get(),
            'vehicleBrands' => VehicleBrand::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $product = $this->saveProduct($request, new Product);

        return redirect()->route('admin.products.edit', $product)->with('success', 'Produit créé.');
    }

    public function edit(Product $product): View
    {
        $product->load(['images', 'compatibilities']);

        return view('admin.products.form', [
            'product' => $product,
            'brands' => Brand::query()->orderBy('name')->get(),
            'categories' => Category::query()->orderBy('sort_order')->get(),
            'vehicleBrands' => VehicleBrand::query()->orderBy('name')->get(),
            'vehicleModels' => $product->compatibilities->first()?->vehicle_brand_id
                ? VehicleModel::query()->where('vehicle_brand_id', $product->compatibilities->first()->vehicle_brand_id)->orderBy('name')->get()
                : collect(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->saveProduct($request, $product);

        return redirect()->route('admin.products.edit', $product)->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé.');
    }

    private function saveProduct(Request $request, Product $product): Product
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'reference' => ['required', 'string', 'max:80', 'unique:products,reference,'.($product->id ?? 'NULL')],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'availability' => ['required', 'in:available,out_of_stock,on_order'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'features_text' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:180'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:4096'],
            'gallery.*' => ['nullable', 'image', 'max:4096'],
            'vehicle_brand_id' => ['nullable', 'exists:vehicle_brands,id'],
            'vehicle_model_id' => ['nullable', 'exists:vehicle_models,id'],
            'year_from' => ['nullable', 'integer', 'min:1980', 'max:2100'],
            'year_to' => ['nullable', 'integer', 'min:1980', 'max:2100'],
        ]);

        $features = collect(preg_split('/\r\n|\r|\n/', $data['features_text'] ?? ''))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->all();

        $product->fill([
            'name' => $data['name'],
            'reference' => $data['reference'],
            'brand_id' => $data['brand_id'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'price' => $data['price'],
            'stock' => $data['stock'],
            'availability' => $data['availability'],
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'features' => $features,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
        ]);

        if (! $product->exists || empty($product->slug)) {
            $product->slug = Str::slug($data['name'].'-'.$data['reference']);
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $i => $file) {
                ProductImage::query()->create([
                    'product_id' => $product->id,
                    'path' => $file->store('products', 'public'),
                    'alt' => $product->name,
                    'sort_order' => $i,
                    'is_primary' => false,
                ]);
            }
        }

        if (! empty($data['vehicle_brand_id'])) {
            ProductVehicleCompatibility::query()->updateOrCreate(
                [
                    'product_id' => $product->id,
                    'vehicle_brand_id' => $data['vehicle_brand_id'],
                    'vehicle_model_id' => $data['vehicle_model_id'] ?? null,
                ],
                [
                    'year_from' => $data['year_from'] ?? null,
                    'year_to' => $data['year_to'] ?? null,
                ]
            );
        }

        return $product;
    }
}
