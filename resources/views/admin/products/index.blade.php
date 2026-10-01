@extends('layouts.admin')

@section('title', 'Produits')
@section('heading', 'Produits')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
    <form method="GET" class="flex gap-2">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher..." class="input-field w-64">
        <button class="btn-secondary">Filtrer</button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="btn-primary">Nouveau produit</a>
</div>

<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
    <table class="min-w-full text-left text-sm">
        <thead class="border-b border-slate-100 bg-slate-50 text-xs uppercase text-slate-500">
            <tr>
                <th class="px-4 py-3">Produit</th>
                <th class="px-4 py-3">Réf.</th>
                <th class="px-4 py-3">Prix</th>
                <th class="px-4 py-3">Stock</th>
                <th class="px-4 py-3">Statut</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($products as $product)
                <tr>
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $product->name }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $product->reference }}</td>
                    <td class="px-4 py-3">{{ $product->formattedPrice() }}</td>
                    <td class="px-4 py-3">{{ $product->stock }}</td>
                    <td class="px-4 py-3">{{ $product->availabilityLabel() }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-sky-600">Modifier</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="ml-3 text-rose-600">Suppr.</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
