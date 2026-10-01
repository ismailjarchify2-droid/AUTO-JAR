<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('sort_order')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $categorie): View
    {
        abort_unless($categorie->is_active, 404);

        $products = Product::query()
            ->active()
            ->where('category_id', $categorie->id)
            ->with(['brand', 'category'])
            ->latest()
            ->paginate(12);

        return view('categories.show', [
            'category' => $categorie,
            'products' => $products,
        ]);
    }
}
