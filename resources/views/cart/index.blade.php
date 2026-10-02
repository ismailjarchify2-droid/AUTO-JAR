@extends('layouts.app')

@section('title', 'Votre panier | AUTO-JAR')
@section('meta_description', 'Consultez votre panier et finalisez votre commande sur AUTO-JAR.')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.2em] text-sky-600">Panier</p>
            <h1 class="mt-2 text-3xl font-semibold text-slate-800">Votre panier</h1>
        </div>
        @if($items)
            <form action="{{ route('panier.clear') }}" method="POST" onsubmit="return confirm('Vider votre panier ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-secondary">Vider le panier</button>
            </form>
        @endif
    </div>

    @if($items)
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="hidden grid-cols-[1.6fr_1fr_1fr_1fr_0.7fr] gap-4 border-b border-slate-200 bg-slate-50 px-5 py-3 text-sm font-medium text-slate-600 md:grid">
                <span>Produit</span>
                <span>Prix</span>
                <span>Quantité</span>
                <span>Sous-total</span>
                <span>Action</span>
            </div>

            @foreach($items as $item)
                @php $product = $item['product']; @endphp
                <div class="grid gap-4 border-b border-slate-200 px-5 py-5 md:grid-cols-[1.6fr_1fr_1fr_1fr_0.7fr] md:items-center">
                    <div class="flex items-center gap-4">
                        <img src="{{ $product->primaryImageUrl() }}" alt="{{ $product->name }}" class="h-20 w-20 rounded-xl object-cover bg-slate-100">
                        <div>
                            <a href="{{ route('produits.show', $product) }}" class="font-medium text-slate-800 hover:text-sky-600">{{ $product->name }}</a>
                            <p class="mt-1 text-xs text-slate-400">Réf. {{ $product->reference }}</p>
                        </div>
                    </div>

                    <div class="text-sm font-medium text-slate-700">{{ number_format((float) $item['unit_price'], 2, ',', ' ') }} DH</div>

                    <div class="flex items-center justify-start md:justify-center">
                        <div class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50">
                            <form action="{{ route('panier.update', $product) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                <button type="submit" class="px-3 py-2 text-lg text-slate-600 hover:text-sky-600" aria-label="Diminuer quantité">−</button>
                            </form>
                            <span class="min-w-10 text-center text-sm font-medium text-slate-700">{{ $item['quantity'] }}</span>
                            <form action="{{ route('panier.update', $product) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ min($product->stock ?: 99, $item['quantity'] + 1) }}">
                                <button type="submit" class="px-3 py-2 text-lg text-slate-600 hover:text-sky-600" aria-label="Augmenter quantité">+</button>
                            </form>
                        </div>
                    </div>

                    <div class="text-sm font-semibold text-slate-800">{{ number_format((float) $item['subtotal'], 2, ',', ' ') }} DH</div>

                    <div>
                        <form action="{{ route('panier.destroy', $product) }}" method="POST" onsubmit="return confirm('Supprimer ce produit du panier ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-medium text-rose-600 hover:text-rose-700">Supprimer</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex flex-col gap-5 lg:flex-row lg:justify-between">
            <div>
                <a href="{{ route('catalogue') }}" class="btn-secondary">Continuer mes achats</a>
            </div>

            <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between text-sm text-slate-600">
                    <span>Nombre d’articles</span>
                    <span>{{ $count }}</span>
                </div>
                <div class="mt-4 flex items-center justify-between border-t border-slate-200 pt-4 text-lg font-semibold text-slate-800">
                    <span>Total</span>
                    <span>{{ number_format((float) $total, 2, ',', ' ') }} DH</span>
                </div>
                <a href="{{ route('commande.index') }}" class="btn-primary mt-5 w-full justify-center">Passer la commande</a>
            </div>
        </div>
    @else
        <div class="card-soft p-10 text-center">
            <p class="text-lg font-medium text-slate-700">Votre panier est vide.</p>
            <p class="mt-2 text-sm text-slate-500">Ajoutez des pièces pour commencer votre commande.</p>
            <a href="{{ route('catalogue') }}" class="btn-primary mt-6">Continuer mes achats</a>
        </div>
    @endif
</div>
@endsection
