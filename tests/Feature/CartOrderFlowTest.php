<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartOrderFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_same_product_is_grouped_in_cart(): void
    {
        $product = Product::create([
            'name' => 'Plaquette de frein avant',
            'slug' => 'plaquette-de-frein-avant',
            'reference' => 'PF-001',
            'price' => 199.00,
            'stock' => 10,
            'availability' => 'available',
            'is_active' => true,
        ]);

        $this->post(route('panier.ajouter'), ['product_id' => $product->id, 'quantity' => 1]);
        $this->post(route('panier.ajouter'), ['product_id' => $product->id, 'quantity' => 1]);

        $this->assertSame(2, session('cart.' . $product->id, 0));
    }

    public function test_cart_counter_reflects_total_quantity_and_persisted_cart(): void
    {
        $productA = Product::create([
            'name' => 'Plaquette de frein arrière',
            'slug' => 'plaquette-de-frein-arriere',
            'reference' => 'PA-020',
            'price' => 140.00,
            'stock' => 8,
            'availability' => 'available',
            'is_active' => true,
        ]);

        $productB = Product::create([
            'name' => 'Bougie d’allumage',
            'slug' => 'bougie-d-allumage',
            'reference' => 'BA-030',
            'price' => 85.00,
            'stock' => 5,
            'availability' => 'available',
            'is_active' => true,
        ]);

        $this->post(route('panier.ajouter'), ['product_id' => $productA->id, 'quantity' => 1]);
        $this->post(route('panier.ajouter'), ['product_id' => $productB->id, 'quantity' => 1]);
        $this->post(route('panier.ajouter'), ['product_id' => $productA->id, 'quantity' => 1]);

        $this->assertSame(3, array_sum(session('cart', [])));

        $this->get(route('panier.index'))
            ->assertOk()
            ->assertSee('Panier (3)');
    }

    public function test_order_is_created_from_cart_and_persists_in_database(): void
    {
        $product = Product::create([
            'name' => 'Filtre à huile',
            'slug' => 'filtre-a-huile',
            'reference' => 'FO-010',
            'price' => 149.00,
            'stock' => 12,
            'availability' => 'available',
            'is_active' => true,
        ]);

        session(['cart' => [$product->id => 2]]);

        $response = $this->post(route('commande.store'), [
            'customer_name' => 'Youssef El Idrissi',
            'phone' => '0612345678',
            'email' => 'client@example.com',
            'city' => 'Casablanca',
            'address' => '12 Rue des Fleurs',
            'notes' => 'Livraison rapide',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Youssef El Idrissi',
            'email' => 'client@example.com',
            'total' => 298.00,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 149.00,
            'subtotal' => 298.00,
        ]);
        $this->assertEmpty(session('cart', []));
    }
}
