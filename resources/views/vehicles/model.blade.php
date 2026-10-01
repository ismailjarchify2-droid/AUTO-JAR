@extends('layouts.app')

@section('title', $vehicleBrand->name.' '.$vehicleModel->name.' | Pièces auto | AUTO-JAR')
@section('meta_description', 'Pièces automobiles pour '.$vehicleBrand->name.' '.$vehicleModel->name.' au Maroc. Prix en DH, stock et livraison.')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <nav class="mb-6 text-sm text-slate-400" aria-label="Fil d'Ariane">
        <a href="{{ route('home') }}" class="hover:text-sky-600">Accueil</a>
        <span class="mx-2">/</span>
        <a href="{{ route('marques.index') }}" class="hover:text-sky-600">Marques</a>
        <span class="mx-2">/</span>
        <a href="{{ route('modeles.show', $vehicleBrand) }}" class="hover:text-sky-600">{{ $vehicleBrand->name }}</a>
        <span class="mx-2">/</span>
        <span class="text-slate-600">{{ $vehicleModel->name }}</span>
    </nav>

    <div class="mb-8">
        <p class="text-sm font-semibold uppercase tracking-wider text-sky-600">{{ $vehicleBrand->name }}</p>
        <h1 class="section-title mt-1">{{ $vehicleModel->name }}</h1>
        <p class="section-sub">Pièces compatibles · Prix en DH · Maroc</p>
    </div>

    <p class="mb-6 text-sm text-slate-500">{{ $products->total() }} pièce(s) trouvée(s)</p>

    @if($products->count())
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
    @else
        <div class="card-soft p-10 text-center">
            <p class="text-slate-600">Aucune pièce pour {{ $vehicleBrand->name }} {{ $vehicleModel->name }} pour le moment.</p>
            <a href="{{ route('demande-piece.create') }}" class="btn-primary mt-4">Demander une pièce</a>
        </div>
    @endif
</div>
@endsection
