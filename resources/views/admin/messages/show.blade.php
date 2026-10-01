@extends('layouts.admin')

@section('title', 'Message #'.$message->id)

@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-semibold text-slate-800">{{ $message->subject ?: 'Message sans sujet' }}</h1>
        <p class="mt-1 text-sm text-slate-500">
            <a href="{{ route('admin.messages.index') }}" class="text-sky-600 hover:text-sky-700">← Retour à la liste</a>
            · Reçu le {{ $message->created_at->format('d/m/Y à H:i') }}
        </p>
    </div>
    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Supprimer ce message ?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-secondary text-rose-600 hover:border-rose-200 hover:text-rose-700">Supprimer</button>
    </form>
</div>

<div class="card-soft max-w-3xl p-6">
    <dl class="grid gap-4 text-sm sm:grid-cols-2">
        <div>
            <dt class="text-xs font-medium uppercase text-slate-400">Nom</dt>
            <dd class="mt-0.5 font-medium text-slate-800">{{ $message->name }}</dd>
        </div>
        <div>
            <dt class="text-xs font-medium uppercase text-slate-400">Téléphone</dt>
            <dd class="mt-0.5">
                <a href="tel:+212{{ ltrim($message->phone, '0') }}" class="text-sky-600 hover:text-sky-700">{{ $message->phone }}</a>
            </dd>
        </div>
        @if($message->email)
            <div>
                <dt class="text-xs font-medium uppercase text-slate-400">Email</dt>
                <dd class="mt-0.5">
                    <a href="mailto:{{ $message->email }}" class="text-sky-600 hover:text-sky-700">{{ $message->email }}</a>
                </dd>
            </div>
        @endif
        @if($message->city)
            <div>
                <dt class="text-xs font-medium uppercase text-slate-400">Ville</dt>
                <dd class="mt-0.5 text-slate-800">{{ $message->city }}</dd>
            </div>
        @endif
    </dl>

    <div class="mt-6 border-t border-slate-100 pt-6">
        <h2 class="text-xs font-medium uppercase text-slate-400">Message</h2>
        <div class="mt-3 whitespace-pre-line text-slate-700 leading-relaxed">{{ $message->message }}</div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-100 pt-6">
        <a href="tel:+212{{ ltrim($message->phone, '0') }}" class="btn-primary">Appeler</a>
        @if($message->email)
            <a href="mailto:{{ $message->email }}" class="btn-secondary">Répondre par email</a>
        @endif
    </div>
</div>
@endsection
