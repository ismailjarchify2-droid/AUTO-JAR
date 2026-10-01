@extends('layouts.admin')

@section('title', 'Marques véhicules')

@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-semibold text-slate-800">Marques véhicules</h1>
        <p class="mt-1 text-sm text-slate-500">Dacia, Renault, Peugeot, BMW…</p>
    </div>
    <a href="{{ route('admin.vehicle-brands.create') }}" class="btn-primary shrink-0">Nouvelle marque</a>
</div>

<div class="card-soft overflow-x-auto">
    <table class="w-full min-w-[600px] text-left text-sm">
        <thead class="border-b border-slate-100 bg-slate-50 text-xs uppercase text-slate-500">
            <tr>
                <th class="px-4 py-3 font-medium">Nom</th>
                <th class="px-4 py-3 font-medium">Slug</th>
                <th class="px-4 py-3 font-medium">Modèles</th>
                <th class="px-4 py-3 font-medium">Statut</th>
                <th class="px-4 py-3 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($vehicleBrands as $vehicleBrand)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $vehicleBrand->name }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $vehicleBrand->slug }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $vehicleBrand->models_count }}</td>
                    <td class="px-4 py-3">
                        @if($vehicleBrand->is_active)
                            <span class="badge-stock">Active</span>
                        @else
                            <span class="badge-out">Inactive</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.vehicle-brands.edit', $vehicleBrand) }}" class="text-sky-600 hover:text-sky-700">Modifier</a>
                            <form action="{{ route('admin.vehicle-brands.destroy', $vehicleBrand) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette marque véhicule ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-700">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-slate-500">Aucune marque véhicule.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $vehicleBrands->links() }}</div>
@endsection
