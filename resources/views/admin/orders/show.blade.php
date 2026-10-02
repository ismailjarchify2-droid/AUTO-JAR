@extends('layouts.admin')

@section('title', 'Commande '.$order->reference)
@section('heading', 'Commande '.$order->reference)

@section('content')
<div class="space-y-6">
    <div class="rounded-xl border border-slate-200 bg-white p-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-slate-500">Commande</p>
                <h2 class="text-2xl font-semibold text-slate-800">{{ $order->reference }}</h2>
            </div>
            <span class="rounded-full bg-sky-100 px-3 py-1 text-sm font-medium text-sky-700">{{ $order->status }}</span>
        </div>

        <div class="mt-6 grid gap-6 md:grid-cols-2">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">Informations client</h3>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><span class="font-medium text-slate-700">Nom :</span> {{ $order->customer_name }}</li>
                    <li><span class="font-medium text-slate-700">Téléphone :</span> {{ $order->phone }}</li>
                    <li><span class="font-medium text-slate-700">Email :</span> {{ $order->email ?? '—' }}</li>
                    <li><span class="font-medium text-slate-700">Ville :</span> {{ $order->city }}</li>
                    <li><span class="font-medium text-slate-700">Adresse :</span> {{ $order->address }}</li>
                    <li><span class="font-medium text-slate-700">Commentaire :</span> {{ $order->notes ?? '—' }}</li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-slate-800">Mettre à jour le statut</h3>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="status" class="label-field">Statut</label>
                        <select id="status" name="status" class="input-field">
                            @foreach(['Nouvelle','Confirmée','En préparation','Expédiée','Livrée','Annulée'] as $status)
                                <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6">
        <h3 class="text-lg font-semibold text-slate-800">Produits commandés</h3>
        <div class="mt-4 overflow-hidden rounded-xl border border-slate-200">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3">Produit</th>
                        <th class="px-4 py-3">Qté</th>
                        <th class="px-4 py-3">Prix unitaire</th>
                        <th class="px-4 py-3">Sous-total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $item->product?->name ?? 'Produit inconnu' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ number_format((float) $item->unit_price, 2, ',', ' ') }} DH</td>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ number_format((float) $item->subtotal, 2, ',', ' ') }} DH</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-5 flex items-center justify-between text-lg font-semibold text-slate-800">
            <span>Total</span>
            <span>{{ number_format((float) $order->total, 2, ',', ' ') }} DH</span>
        </div>
    </div>
</div>
@endsection
