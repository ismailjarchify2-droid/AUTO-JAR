<article class="card-soft group overflow-hidden transition hover:border-sky-200">
    <a href="{{ route('produits.show', $product) }}" class="block">
        <div class="aspect-[4/3] overflow-hidden bg-slate-100">
            <img src="{{ $product->primaryImageUrl() }}"
                 alt="{{ $product->name }}"
                 class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                 loading="lazy">
        </div>
        <div class="p-4">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-sky-600">{{ $product->brand?->name }}</p>
                    <h3 class="mt-1 text-sm font-semibold text-slate-800 line-clamp-2">{{ $product->name }}</h3>
                </div>
            </div>
            <p class="mt-1 text-xs text-slate-400">Réf. {{ $product->reference }}</p>
            <div class="mt-3 flex items-center justify-between">
                <p class="text-base font-semibold text-slate-800">{{ $product->formattedPrice() }}</p>
                @if($product->availability === 'available')
                    <span class="badge-stock">En stock</span>
                @elseif($product->availability === 'out_of_stock')
                    <span class="badge-out">Rupture</span>
                @else
                    <span class="badge-order">Sur commande</span>
                @endif
            </div>
        </div>
    </a>
    <div class="p-4 pt-0">
        <form action="{{ route('panier.ajouter') }}" method="POST" class="js-add-to-cart-form" data-cart-add>
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn-primary w-full">Ajouter au panier</button>
        </form>
    </div>
</article>
