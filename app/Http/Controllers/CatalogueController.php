<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogueController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()
            ->active()
            ->with(['brand', 'category']);

        if ($request->filled('q')) {
            $query->search($request->string('q')->toString());
        }

        if ($request->filled('categorie')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->categorie));
        }

        if ($request->filled('marque')) {
            $query->whereHas('brand', fn ($q) => $q->where('slug', $request->marque));
        }

        if ($request->filled('disponibilite')) {
            $query->where('availability', $request->disponibilite);
        }

        if ($request->filled('prix_min')) {
            $query->where('price', '>=', (float) $request->prix_min);
        }

        if ($request->filled('prix_max')) {
            $query->where('price', '<=', (float) $request->prix_max);
        }

        if ($request->filled('vehicle_brand')) {
            $query->whereHas('compatibilities', function ($q) use ($request) {
                $q->where('vehicle_brand_id', $request->vehicle_brand);

                if ($request->filled('vehicle_model')) {
                    $q->where('vehicle_model_id', $request->vehicle_model);
                }

                if ($request->filled('vehicle_year')) {
                    $year = (int) $request->vehicle_year;
                    $q->where(function ($y) use ($year) {
                        $y->whereHas('vehicleYear', fn ($vy) => $vy->where('year', $year))
                            ->orWhere(function ($range) use ($year) {
                                $range->where(function ($r) use ($year) {
                                    $r->whereNull('year_from')->orWhere('year_from', '<=', $year);
                                })->where(function ($r) use ($year) {
                                    $r->whereNull('year_to')->orWhere('year_to', '>=', $year);
                                });
                            });
                    });
                }
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $sort = $request->get('tri', 'recent');
        match ($sort) {
            'prix_asc' => $query->orderBy('price'),
            'prix_desc' => $query->orderByDesc('price'),
            'nom' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        return view('catalogue.index', [
            'products' => $products,
            'categories' => Category::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'brands' => Brand::query()->where('is_active', true)->orderBy('name')->get(),
            'vehicleBrands' => VehicleBrand::query()->where('is_active', true)->orderBy('name')->get(),
            'vehicleModels' => $request->filled('vehicle_brand')
                ? VehicleModel::query()->where('vehicle_brand_id', $request->vehicle_brand)->where('is_active', true)->orderBy('name')->get()
                : collect(),
            'filters' => $request->all(),
        ]);
    }
}
