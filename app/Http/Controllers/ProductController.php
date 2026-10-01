<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $produit): View
    {
        abort_unless($produit->is_active, 404);

        $produit->load(['brand', 'category', 'images', 'compatibilities.vehicleBrand', 'compatibilities.vehicleModel', 'compatibilities.vehicleYear']);

        $related = Product::query()
            ->active()
            ->where('id', '!=', $produit->id)
            ->where(function ($q) use ($produit) {
                $q->where('category_id', $produit->category_id)
                    ->orWhere('brand_id', $produit->brand_id);
            })
            ->with(['brand', 'category'])
            ->take(4)
            ->get();

        return view('products.show', [
            'product' => $produit,
            'related' => $related,
        ]);
    }
}
