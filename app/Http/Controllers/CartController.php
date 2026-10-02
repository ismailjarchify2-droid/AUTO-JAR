<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = $this->cartItems();

        return view('cart.index', [
            'items' => $cart['items'],
            'total' => $cart['total'],
            'count' => $cart['count'],
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::query()->active()->findOrFail($data['product_id']);

        if ($product->availability === 'out_of_stock') {
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce produit est actuellement indisponible.',
                    'cart_count' => $this->cartCount(),
                ], 422);
            }

            return back()->withErrors(['stock' => 'Ce produit est actuellement indisponible.']);
        }

        $quantity = (int) ($data['quantity'] ?? 1);
        $cart = session()->get('cart', []);
        $currentQuantity = (int) ($cart[$product->id] ?? 0);
        $newQuantity = $currentQuantity + $quantity;

        if ($product->stock > 0 && $newQuantity > $product->stock) {
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock insuffisant. Quantité disponible : '.$product->stock,
                    'cart_count' => $this->cartCount(),
                ], 422);
            }

            return back()->withErrors(['stock' => 'Stock insuffisant. Quantité disponible : '.$product->stock]);
        }

        $cart[$product->id] = $newQuantity;
        session()->put('cart', $cart);

        $cartCount = $this->cartCount();

        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté au panier.',
                'cart_count' => $cartCount,
            ]);
        }

        return back()->with('success', 'Produit ajouté au panier.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = session()->get('cart', []);
        $quantity = (int) $data['quantity'];

        if ($product->availability === 'out_of_stock') {
            return back()->withErrors(['stock' => 'Ce produit est actuellement indisponible.']);
        }

        if ($product->stock > 0 && $quantity > $product->stock) {
            return back()->withErrors(['stock' => 'Stock insuffisant. Quantité disponible : '.$product->stock]);
        }

        if ($quantity <= 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = $quantity;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Panier mis à jour.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Produit supprimé du panier.');
    }

    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return back()->with('success', 'Votre panier a été vidé.');
    }

    public function cartItems(): array
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;
        $count = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::query()->active()->find($productId);

            if (! $product) {
                continue;
            }

            $safeQuantity = max(1, (int) $quantity);
            if ($product->availability === 'out_of_stock') {
                continue;
            }

            if ($product->stock > 0 && $safeQuantity > $product->stock) {
                $safeQuantity = $product->stock;
            }

            $subtotal = $product->price * $safeQuantity;

            $items[] = [
                'product' => $product,
                'quantity' => $safeQuantity,
                'unit_price' => $product->price,
                'subtotal' => $subtotal,
            ];

            $count += $safeQuantity;
            $total += $subtotal;
        }

        session()->put('cart', collect($items)->mapWithKeys(fn ($item) => [$item['product']->id => $item['quantity']])->all());

        return [
            'items' => $items,
            'total' => $total,
            'count' => $count,
        ];
    }

    private function cartCount(): int
    {
        $cart = session()->get('cart', []);

        if (! is_array($cart)) {
            return 0;
        }

        return array_sum(array_map(static fn ($quantity) => max(0, (int) $quantity), $cart));
    }
}
