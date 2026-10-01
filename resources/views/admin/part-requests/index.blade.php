@extends('layouts.admin')

@section('title', 'Demandes de pièces')

@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-semibold text-slate-800">Demandes de pièces</h1>
        <p class="mt-1 text-sm text-slate-500">Demandes clients depuis le site</p>
    </div>
</div>

<form method="GET" action="{{ route('admin.part-requests.index') }}" class="card-soft mb-6 flex flex-col gap-3 p-4 sm:flex-row sm:items-center">
    <label for="status" class="label-field mb-0 shrink-0">Filtrer par statut</label>
    <select name="status" id="status" class="input-field max-w-xs">
        <option value="">Tous</option>
        <option value="pending" @selected(request('status') === 'pending')>En attente</option>
        <option value="processing" @selected(request('status') === 'processing')>En cours</option>
        <option value="quoted" @selected(request('status') === 'quoted')>Devis envoyé</option>
        <option value="completed" @selected(request('status') === 'completed')>Terminée</option>
        <option value="cancelled" @selected(request('status') === 'cancelled')>Annulée</option>
    </select>
    <button type="submit" class="btn-primary shrink-0">Filtrer</button>
    @if(request('status'))
        <a href="{{ route('admin.part-requests.index') }}" class="btn-secondary shrink-0">Effacer</a>
    @endif
</form>

<div class="card-soft overflow-x-auto">
    <table class="w-full min-w-[800px] text-left text-sm">
        <thead class="border-b border-slate-100 bg-slate-50 text-xs uppercase text-slate-500">
            <tr>
                <th class="px-4 py-3 font-medium">Date</th>
                <th class="px-4 py-3 font-medium">Client</th>
                <th class="px-4 py-3 font-medium">Pièce</th>
                <th class="px-4 py-3 font-medium">Véhicule</th>
                <th class="px-4 py-3 font-medium">Ville</th>
                <th class="px-4 py-3 font-medium">Statut</th>
                <th class="px-4 py-3 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($requests as $request)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 text-slate-500">{{ $request->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-slate-800">{{ $request->name }}</p>
                        <p class="text-xs text-slate-400">{{ $request->phone }}</p>
                    </td>
                    <td class="px-4 py-3 text-slate-700">{{ $request->part_name }}</td>
                    <td class="px-4 py-3 text-slate-500">
                        @if($request->vehicle_brand)
                            {{ $request->vehicle_brand }} {{ $request->vehicle_model }} {{ $request->vehicle_year }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $request->city }}</td>
                    <td class="px-4 py-3">
                        <span class="rounded-md bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $request->statusLabel() }}</span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.part-requests.show', $request) }}" class="text-sky-600 hover:text-sky-700">Voir</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-slate-500">Aucune demande.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $requests->links() }}</div>
@endsection
