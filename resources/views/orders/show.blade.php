@extends('layouts.app')

@section('title', 'Commande envoyée | AUTO-JAR')
@section('meta_description', 'Votre commande AUTO-JAR a bien été enregistrée.')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-10">
    <div class="card-soft p-8 text-center">
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-3xl text-emerald-600">✓</div>
        <h1 class="text-3xl font-semibold text-slate-800">Commande envoyée avec succès.</h1>
        <p class="mt-3 text-slate-600">Votre commande a été enregistrée avec le numéro <span class="font-semibold text-sky-600">{{ $order->reference }}</span>.</p>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <a href="{{ route('catalogue') }}" class="btn-primary">Continuer mes achats</a>
            <a href="{{ route('home') }}" class="btn-secondary">Retour à l'accueil</a>
        </div>
    </div>

    <div class="mt-8 card-soft p-6">
        <h2 class="text-xl font-semibold text-slate-800">Détails de la commande</h2>
        <div class="mt-5 grid gap-6 md:grid-cols-2">
            <div>
                <p class="text-sm text-slate-500">Client</p>
                <p class="mt-1 font-medium text-slate-800">{{ $order->customer_name }}</p>
                <p class="mt-1 text-sm text-slate-600">{{ $order->phone }}</p>
                <p class="text-sm text-slate-600">{{ $order->email ?? 'Email non fourni' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Adresse</p>
                <p class="mt-1 text-sm text-slate-700">{{ $order->address }}</p>
                <p class="mt-1 text-sm text-slate-700">{{ $order->city }}</p>
            </div>
        </div>

        <div class="mt-8 space-y-4">
            @foreach($order->items as $item)
                <div class="flex items-center justify-between gap-3 border-b border-slate-200 pb-3">
                    <div>
                        <p class="font-medium text-slate-700">{{ $item->product?->name ?? 'Produit supprimé' }}</p>
                        <p class="text-xs text-slate-500">Qté : {{ $item->quantity }}</p>
                    </div>
                    <div class="font-medium text-slate-700">{{ number_format((float) $item->subtotal, 2, ',', ' ') }} DH</div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center justify-between border-t border-slate-200 pt-4 text-lg font-semibold text-slate-800">
            <span>Total</span>
            <span>{{ number_format((float) $order->total, 2, ',', ' ') }} DH</span>
        </div>
    </div>
</div>
@endsection
