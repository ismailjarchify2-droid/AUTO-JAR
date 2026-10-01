@extends('layouts.admin')

@section('title', 'Demande #'.$partRequest->id)

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-800">Demande #{{ $partRequest->id }}</h1>
    <p class="mt-1 text-sm text-slate-500">
        <a href="{{ route('admin.part-requests.index') }}" class="text-sky-600 hover:text-sky-700">← Retour à la liste</a>
        · Reçue le {{ $partRequest->created_at->format('d/m/Y à H:i') }}
    </p>
</div>

<div class="grid gap-6 lg:grid-cols-[1fr_360px]">
    <div class="space-y-6">
        <section class="card-soft p-6">
            <h2 class="font-semibold text-slate-800">Informations client</h2>
            <dl class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium uppercase text-slate-400">Nom</dt>
                    <dd class="mt-0.5 text-slate-800">{{ $partRequest->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase text-slate-400">Téléphone</dt>
                    <dd class="mt-0.5">
                        <a href="tel:+212{{ ltrim($partRequest->phone, '0') }}" class="text-sky-600 hover:text-sky-700">{{ $partRequest->phone }}</a>
                    </dd>
                </div>
                @if($partRequest->whatsapp)
                    <div>
                        <dt class="text-xs font-medium uppercase text-slate-400">WhatsApp</dt>
                        <dd class="mt-0.5">
                            <a href="https://wa.me/212{{ ltrim(preg_replace('/\D/', '', $partRequest->whatsapp), '0') }}" target="_blank" rel="noopener" class="text-emerald-600 hover:text-emerald-700">{{ $partRequest->whatsapp }}</a>
                        </dd>
                    </div>
                @endif
                <div>
                    <dt class="text-xs font-medium uppercase text-slate-400">Ville</dt>
                    <dd class="mt-0.5 text-slate-800">{{ $partRequest->city }}</dd>
                </div>
            </dl>
        </section>

        <section class="card-soft p-6">
            <h2 class="font-semibold text-slate-800">Pièce demandée</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div>
                    <dt class="text-xs font-medium uppercase text-slate-400">Nom de la pièce</dt>
                    <dd class="mt-0.5 font-medium text-slate-800">{{ $partRequest->part_name }}</dd>
                </div>
                @if($partRequest->reference)
                    <div>
                        <dt class="text-xs font-medium uppercase text-slate-400">Référence</dt>
                        <dd class="mt-0.5 text-slate-800">{{ $partRequest->reference }}</dd>
                    </div>
                @endif
                @if($partRequest->vehicle_brand || $partRequest->vehicle_model || $partRequest->vehicle_year)
                    <div>
                        <dt class="text-xs font-medium uppercase text-slate-400">Véhicule</dt>
                        <dd class="mt-0.5 text-slate-800">{{ $partRequest->vehicle_brand }} {{ $partRequest->vehicle_model }} {{ $partRequest->vehicle_year }}</dd>
                    </div>
                @endif
                @if($partRequest->description)
                    <div>
                        <dt class="text-xs font-medium uppercase text-slate-400">Description</dt>
                        <dd class="mt-0.5 whitespace-pre-line text-slate-600">{{ $partRequest->description }}</dd>
                    </div>
                @endif
                @if($partRequest->product)
                    <div>
                        <dt class="text-xs font-medium uppercase text-slate-400">Produit lié</dt>
                        <dd class="mt-0.5">
                            <a href="{{ route('produits.show', $partRequest->product) }}" target="_blank" class="text-sky-600 hover:text-sky-700">{{ $partRequest->product->name }}</a>
                        </dd>
                    </div>
                @endif
            </dl>

            @if($partRequest->photo)
                <div class="mt-5">
                    <p class="text-xs font-medium uppercase text-slate-400">Photo jointe</p>
                    <img src="{{ asset('storage/'.$partRequest->photo) }}" alt="Photo pièce" class="mt-2 max-h-64 rounded-lg border border-slate-200 object-contain bg-slate-50">
                </div>
            @endif
        </section>
    </div>

    <aside class="space-y-6">
        <section class="card-soft p-6">
            <h2 class="font-semibold text-slate-800">Mettre à jour le statut</h2>
            <form action="{{ route('admin.part-requests.update', $partRequest) }}" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="status" class="label-field">Statut</label>
                    <select name="status" id="status" class="input-field" required>
                        <option value="pending" @selected(old('status', $partRequest->status) === 'pending')>En attente</option>
                        <option value="processing" @selected(old('status', $partRequest->status) === 'processing')>En cours</option>
                        <option value="quoted" @selected(old('status', $partRequest->status) === 'quoted')>Devis envoyé</option>
                        <option value="completed" @selected(old('status', $partRequest->status) === 'completed')>Terminée</option>
                        <option value="cancelled" @selected(old('status', $partRequest->status) === 'cancelled')>Annulée</option>
                    </select>
                </div>

                <div>
                    <label for="admin_notes" class="label-field">Notes internes</label>
                    <textarea name="admin_notes" id="admin_notes" rows="4" class="input-field" placeholder="Notes pour l'équipe…">{{ old('admin_notes', $partRequest->admin_notes) }}</textarea>
                </div>

                <button type="submit" class="btn-primary w-full">Enregistrer</button>
            </form>
        </section>

        <form action="{{ route('admin.part-requests.destroy', $partRequest) }}" method="POST" onsubmit="return confirm('Supprimer cette demande ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-secondary w-full text-rose-600 hover:border-rose-200 hover:text-rose-700">Supprimer la demande</button>
        </form>
    </aside>
</div>
@endsection
