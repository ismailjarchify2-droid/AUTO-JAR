@extends('layouts.app')

@section('title', ($product->meta_title ?: $product->name.' | AUTO-JAR'))
@section('meta_description', $product->meta_description ?: $product->short_description)

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <nav class="mb-6 text-sm text-slate-400" aria-label="Fil d'Ariane">
        <a href="{{ route('home') }}" class="hover:text-sky-600">Accueil</a>
        <span class="mx-2">/</span>
        <a href="{{ route('catalogue') }}" class="hover:text-sky-600">Catalogue</a>
        @if($product->category)
            <span class="mx-2">/</span>
            <a href="{{ route('categories.show', $product->category) }}" class="hover:text-sky-600">{{ $product->category->name }}</a>
        @endif
        <span class="mx-2">/</span>
        <span class="text-slate-600">{{ $product->name }}</span>
    </nav>

    <div class="grid gap-10 lg:grid-cols-2">
        <div class="card-soft overflow-hidden">
            <img src="{{ $product->primaryImageUrl() }}" alt="{{ $product->name }}" class="aspect-[4/3] w-full object-cover bg-slate-100">
            @if($product->images->count())
                <div class="grid grid-cols-4 gap-2 p-3">
                    @foreach($product->images as $image)
                        <img src="{{ $image->url() }}" alt="{{ $image->alt ?: $product->name }}" class="aspect-square rounded-lg object-cover bg-slate-100">
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <p class="text-sm font-medium uppercase tracking-wide text-sky-600">{{ $product->brand?->name }}</p>
            <h1 class="mt-2 text-3xl font-semibold text-slate-800">{{ $product->name }}</h1>
            <p class="mt-2 text-sm text-slate-400">Référence : <span class="font-medium text-slate-600">{{ $product->reference }}</span></p>

            <div class="mt-4 flex flex-wrap items-center gap-3">
                <p class="text-3xl font-semibold text-slate-800">{{ $product->formattedPrice() }}</p>
                @if($product->availability === 'available')
                    <span class="badge-stock">{{ $product->availabilityLabel() }}</span>
                @elseif($product->availability === 'out_of_stock')
                    <span class="badge-out">{{ $product->availabilityLabel() }}</span>
                @else
                    <span class="badge-order">{{ $product->availabilityLabel() }}</span>
                @endif
            </div>

            <p class="mt-5 text-slate-600">{{ $product->short_description }}</p>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('demande-piece.create', ['produit' => $product->slug]) }}" class="btn-primary">Demander cette pièce</a>
                <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}?text={{ urlencode('Bonjour, je suis intéressé par : '.$product->name.' ('.$product->reference.')') }}"
                   target="_blank" rel="noopener" class="btn-whatsapp">WhatsApp</a>
                <a href="tel:+212{{ ltrim($siteSettings['mobile'], '0') }}" class="btn-secondary">Appeler</a>
            </div>

            @if($product->features)
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-slate-800">Caractéristiques</h2>
                    <ul class="mt-3 space-y-2">
                        @foreach($product->features as $feature)
                            <li class="flex gap-2 text-sm text-slate-600">
                                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-sky-500"></span>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($product->compatibilities->count())
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-slate-800">Compatibilité véhicule</h2>
                    <ul class="mt-3 space-y-2">
                        @foreach($product->compatibilities as $compat)
                            <li class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                                {{ $compat->label() }}
                                @if($compat->notes)
                                    <span class="block text-xs text-slate-400">{{ $compat->notes }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    @if($product->description)
        <section class="mt-12 card-soft p-6">
            <h2 class="text-lg font-semibold text-slate-800">Description</h2>
            <div class="mt-3 whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $product->description }}</div>
        </section>
    @endif

    @if($related->count())
        <section class="mt-12">
            <h2 class="section-title">Produits associés</h2>
            <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($related as $item)
                    @include('partials.product-card', ['product' => $item])
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
