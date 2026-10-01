@extends('layouts.app')

@section('title', 'Catégories de pièces auto | AUTO-JAR')
@section('meta_description', 'Parcourez nos catégories de pièces automobiles : freinage, filtres, suspension, éclairage et plus. Prix en DH au Maroc.')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <div class="mb-10">
        <h1 class="section-title">Catégories</h1>
        <p class="section-sub">Parcourez nos familles de pièces automobiles · Maroc</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($categories as $category)
            <a href="{{ route('categories.show', $category) }}" class="card-soft p-6 transition hover:border-sky-200">
                <h2 class="text-lg font-semibold text-slate-800">{{ $category->name }}</h2>
                @if($category->description)
                    <p class="mt-2 text-sm text-slate-500 line-clamp-3">{{ $category->description }}</p>
                @endif
                <p class="mt-4 text-xs font-medium text-sky-600">{{ $category->products_count }} pièce(s)</p>
            </a>
        @empty
            <div class="card-soft p-10 text-center sm:col-span-2 lg:col-span-3">
                <p class="text-slate-500">Aucune catégorie disponible pour le moment.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
