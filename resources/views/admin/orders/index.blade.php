@extends('layouts.admin')

@section('title', 'Commandes')
@section('heading', 'Commandes')

@section('content')
<div class="rounded-xl border border-slate-200 bg-white overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3">Commande</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Client</th>
                    <th class="px-4 py-3">Téléphone</th>
                    <th class="px-4 py-3">Ville</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Statut</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $order->reference }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $order->customer_name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $order->phone }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $order->city }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ number_format((float) $order->total, 2, ',', ' ') }} DH</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full bg-sky-100 px-2.5 py-1 text-xs font-medium text-sky-700">{{ $order->status }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-sky-600 hover:text-sky-700">Voir</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-slate-500">Aucune commande pour le moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>
@endsection
