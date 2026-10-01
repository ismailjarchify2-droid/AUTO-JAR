@extends('layouts.app')

@section('title', $vehicleBrand->name.' | Modèles et pièces | AUTO-JAR')
@section('meta_description', 'Pièces automobiles compatibles '.$vehicleBrand->name.' au Maroc. Parcourez les modèles et le catalogue. Prix en DH.')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <nav class="mb-6 text-sm text-slate-400" aria-label="Fil d'Ariane">
        <a href="{{ route('home') }}" class="hover:text-sky-600">Accueil</a>
        <span class="mx-2">/</span>
        <a href="{{ route('marques.index') }}" class="hover:text-sky-600">Marques</a>
        <span class="mx-2">/</span>
        <span class="text-slate-600">{{ $vehicleBrand->name }}</span>
    </nav>

    <div class="mb-8">
        <p class="text-sm font-semibold uppercase tracking-wider text-sky-600">Marque automobile</p>
        <h1 class="section-title mt-1">{{ $vehicleBrand->name }}</h1>
        <p class="section-sub">Sélectionnez un modèle ou parcourez les pièces compatibles</p>
    </div>

    @if($vehicleBrand->models->count())
        <section class="mb-12">
            <h2 class="text-lg font-semibold text-slate-800">Modèles {{ $vehicleBrand->name }}</h2>
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                @foreach($vehicleBrand->models as $model)
                    <a href="{{ route('modeles.produits', [$vehicleBrand, $model]) }}"
                       class="card-soft flex items-center justify-center px-3 py-4 text-center text-sm font-semibold text-slate-700 transition hover:border-sky-200 hover:text-sky-600">
                        {{ $model->name }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section>
        <h2 class="text-lg font-semibold text-slate-800">Pièces compatibles {{ $vehicleBrand->name }}</h2>
        <p class="mt-1 mb-6 text-sm text-slate-500">{{ $products->total() }} pièce(s) trouvée(s)</p>

        @if($products->count())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
            <div class="mt-8">{{ $products->links() }}</div>
        @else
            <div class="card-soft p-10 text-center">
                <p class="text-slate-600">Aucune pièce compatible {{ $vehicleBrand->name }} pour le moment.</p>
                <a href="{{ route('demande-piece.create') }}" class="btn-primary mt-4">Demander une pièce</a>
            </div>
        @endif
    </section>
</div>
@endsection
