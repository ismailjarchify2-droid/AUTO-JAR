<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('name')
            ->get();

        $vehicleBrands = VehicleBrand::query()
            ->where('is_active', true)
            ->withCount('models')
            ->orderBy('name')
            ->get();

        return view('brands.index', compact('brands', 'vehicleBrands'));
    }

    public function show(Brand $marque): View
    {
        abort_unless($marque->is_active, 404);

        $products = Product::query()
            ->active()
            ->where('brand_id', $marque->id)
            ->with(['brand', 'category'])
            ->latest()
            ->paginate(12);

        return view('brands.show', [
            'brand' => $marque,
            'products' => $products,
        ]);
    }
}
