<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\VehicleBrand;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featured = Product::query()
            ->active()
            ->with(['brand', 'category'])
            ->where('is_featured', true)
            ->latest()
            
            ->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('sort_order')
            
            ->get();

            $vehicleBrandsCount = VehicleBrand::query()
    ->where('is_active', true)
    ->count();

        $vehicleBrands = VehicleBrand::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->take(18)
            ->get();

        $partBrands = Brand::query()
            ->where('is_active', true)
            ->orderBy('name')
            
            ->get();

       return view('home', compact(
    'featured',
    'categories',
    'vehicleBrands',
    'vehicleBrandsCount',
    'partBrands'
));
}
}