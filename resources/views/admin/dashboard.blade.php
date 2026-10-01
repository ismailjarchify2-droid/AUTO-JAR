@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('heading', 'Tableau de bord')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
    @foreach([
        ['Produits', $stats['products'], 'admin.products.index'],
        ['En stock', $stats['available'], 'admin.products.index'],
        ['Rupture', $stats['out_of_stock'], 'admin.products.index'],
        ['Demandes', $stats['requests'], 'admin.part-requests.index'],
        ['Demandes en attente', $stats['pending_requests'], 'admin.part-requests.index'],
        ['Messages non lus', $stats['messages'], 'admin.messages.index'],
    ] as [$label, $value, $route])
        <a href="{{ route($route) }}" class="rounded-xl border border-slate-200 bg-white p-5 transition hover:border-sky-200">
            <p class="text-sm text-slate-500">{{ $label }}</p>
            <p class="mt-2 text-3xl font-semibold text-slate-800">{{ $value }}</p>
        </a>
    @endforeach
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="rounded-xl border border-slate-200 bg-white p-5">
        <h2 class="font-semibold text-slate-800">Dernières demandes</h2>
        <ul class="mt-4 divide-y divide-slate-100">
            @forelse($recentRequests as $req)
                <li class="flex items-center justify-between gap-3 py-3 text-sm">
                    <div>
                        <p class="font-medium text-slate-700">{{ $req->part_name }}</p>
                        <p class="text-xs text-slate-400">{{ $req->name }} · {{ $req->city }}</p>
                    </div>
                    <a href="{{ route('admin.part-requests.show', $req) }}" class="text-sky-600">Voir</a>
                </li>
            @empty
                <li class="py-3 text-sm text-slate-400">Aucune demande</li>
            @endforelse
        </ul>
    </div>
    <div class="rounded-xl border border-slate-200 bg-white p-5">
        <h2 class="font-semibold text-slate-800">Derniers messages</h2>
        <ul class="mt-4 divide-y divide-slate-100">
            @forelse($recentMessages as $msg)
                <li class="flex items-center justify-between gap-3 py-3 text-sm">
                    <div>
                        <p class="font-medium text-slate-700">{{ $msg->name }}</p>
                        <p class="text-xs text-slate-400">{{ Str::limit($msg->message, 40) }}</p>
                    </div>
                    <a href="{{ route('admin.messages.show', $msg) }}" class="text-sky-600">Voir</a>
                </li>
            @empty
                <li class="py-3 text-sm text-slate-400">Aucun message</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
