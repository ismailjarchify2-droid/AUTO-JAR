@extends('layouts.app')

@section('title', 'Catalogue pièces automobiles | AUTO-JAR')
@section('meta_description', 'Parcourez notre catalogue de pièces auto au Maroc. Filtrez par marque, modèle, année et catégorie.')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <div class="mb-8">
        <h1 class="section-title">Catalogue</h1>
        <p class="section-sub">Pièces automobiles · Prix en DH · Stock Maroc</p>
    </div>

    <div class="grid gap-8 lg:grid-cols-[280px_1fr]">
        <aside class="card-soft h-fit p-5">
            <h2 class="text-sm font-semibold text-slate-800">Filtres</h2>
            <form method="GET" action="{{ route('catalogue') }}" class="mt-4 space-y-4">
                <div>
                    <label class="label-field" for="q">Recherche</label>
                    <input type="search" name="q" id="q" value="{{ $filters['q'] ?? '' }}" class="input-field" placeholder="Plaquette BMW, BP-12345...">
                </div>
                <div>
                    <label class="label-field" for="categorie">Catégorie</label>
                    <select name="categorie" id="categorie" class="input-field">
                        <option value="">Toutes</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" @selected(($filters['categorie'] ?? '') === $cat->slug)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label-field" for="marque">Marque de pièce</label>
                    <select name="marque" id="marque" class="input-field">
                        <option value="">Toutes</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->slug }}" @selected(($filters['marque'] ?? '') === $brand->slug)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
    <label class="label-field" for="vehicle_brand">Marque véhicule</label>
    <input
        type="text"
        name="vehicle_brand"
        id="vehicle_brand"
        value="{{ $filters['vehicle_brand'] ?? '' }}"
        class="input-field"
        placeholder="Ex. BMW, Peugeot, Renault..."
    >
</div>
               <div>
    <label class="label-field" for="vehicle_model">Modèle</label>
    <input
        type="text"
        name="vehicle_model"
        id="vehicle_model"
        value="{{ $filters['vehicle_model'] ?? '' }}"
        class="input-field"
        placeholder="Ex. X5, Golf 7, Clio..."
    >
</div>
                <div>
                    <label class="label-field" for="vehicle_year">Année</label>
                    <input type="number" name="vehicle_year" id="vehicle_year" value="{{ $filters['vehicle_year'] ?? '' }}" class="input-field" placeholder="2019" min="1990" max="2030">
                </div>
                <div>
                    <label class="label-field" for="disponibilite">Disponibilité</label>
                    <select name="disponibilite" id="disponibilite" class="input-field">
                        <option value="">Toutes</option>
                        <option value="available" @selected(($filters['disponibilite'] ?? '') === 'available')>En stock</option>
                        <option value="out_of_stock" @selected(($filters['disponibilite'] ?? '') === 'out_of_stock')>Rupture</option>
                        <option value="on_order" @selected(($filters['disponibilite'] ?? '') === 'on_order')>Sur commande</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="label-field" for="prix_min">Prix min</label>
                        <input type="number" name="prix_min" id="prix_min" value="{{ $filters['prix_min'] ?? '' }}" class="input-field" min="0">
                    </div>
                    <div>
                        <label class="label-field" for="prix_max">Prix max</label>
                        <input type="number" name="prix_max" id="prix_max" value="{{ $filters['prix_max'] ?? '' }}" class="input-field" min="0">
                    </div>
                </div>
                <div>
                    <label class="label-field" for="tri">Tri</label>
                    <select name="tri" id="tri" class="input-field">
                        <option value="recent" @selected(($filters['tri'] ?? 'recent') === 'recent')>Plus récent</option>
                        <option value="prix_asc" @selected(($filters['tri'] ?? '') === 'prix_asc')>Prix croissant</option>
                        <option value="prix_desc" @selected(($filters['tri'] ?? '') === 'prix_desc')>Prix décroissant</option>
                        <option value="nom" @selected(($filters['tri'] ?? '') === 'nom')>Nom A-Z</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary w-full">Appliquer</button>
                <a href="{{ route('catalogue') }}" class="btn-secondary w-full">Réinitialiser</a>
            </form>
        </aside>

        <div>
            <p class="mb-4 text-sm text-slate-500">{{ $products->total() }} résultat(s)</p>
            @if($products->count())
                <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="mt-8">{{ $products->links() }}</div>
            @else
                <div class="card-soft p-10 text-center">
                    <p class="text-slate-600">Aucune pièce trouvée.</p>
                    <a href="{{ route('demande-piece.create') }}" class="btn-primary mt-4">Demander cette pièce</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
