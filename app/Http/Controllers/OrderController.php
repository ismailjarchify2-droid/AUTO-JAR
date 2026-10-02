<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function checkout(): View
    {
        $cart = $this->cartItems();

        if ($cart['items'] === []) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est actuellement vide.');
        }

        return view('orders.checkout', [
            'items' => $cart['items'],
            'total' => $cart['total'],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'city' => ['required', 'string', 'max:120'],
            'address' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = $this->cartItems();

        if ($cart['items'] === []) {
            return redirect()->route('panier.index')->withErrors(['cart' => 'Votre panier est vide.']);
        }

        $order = DB::transaction(function () use ($data, $cart) {
            $total = collect($cart['items'])->sum(fn ($item) => $item['subtotal']);
            $reference = 'AUTOJAR-'.now()->format('Ymd').'-'.str_pad((string) (Order::query()->count() + 1), 5, '0', STR_PAD_LEFT);

            $order = Order::query()->create([
                'reference' => $reference,
                'customer_name' => $data['customer_name'],
                'phone' => $data['phone'],
                'email' => $data['email'] ?? null,
                'city' => $data['city'],
                'address' => $data['address'],
                'notes' => $data['notes'] ?? null,
                'total' => $total,
                'status' => 'Nouvelle',
            ]);

            foreach ($cart['items'] as $item) {
                $product = $item['product'];

                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $item['subtotal'],
                ]);

                if ($product->stock > 0) {
                    $product->stock = max(0, $product->stock - $item['quantity']);
                    $product->availability = $product->stock > 0 ? 'available' : 'out_of_stock';
                    $product->save();
                }
            }

            session()->forget('cart');

            return $order;
        });

        return redirect()->route('commande.show', $order)->with('success', 'Commande envoyée avec succès.');
    }

    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('orders.show', [
            'order' => $order,
        ]);
    }

    private function cartItems(): array
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;

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
            $total += $subtotal;
        }

        return [
            'items' => $items,
            'total' => $total,
        ];
    }
}
