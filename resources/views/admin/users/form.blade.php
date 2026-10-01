@extends('layouts.admin')

@section('title', $user->exists ? 'Modifier l\'utilisateur' : 'Nouvel utilisateur')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-800">{{ $user->exists ? 'Modifier l\'utilisateur' : 'Nouvel utilisateur' }}</h1>
    <p class="mt-1 text-sm text-slate-500">
        <a href="{{ route('admin.users.index') }}" class="text-sky-600 hover:text-sky-700">← Retour à la liste</a>
    </p>
</div>

<form action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}"
      method="POST" class="card-soft max-w-2xl p-6 space-y-5">
    @csrf
    @if($user->exists)
        @method('PUT')
    @endif

    <div>
        <label for="name" class="label-field">Nom <span class="text-rose-500">*</span></label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="input-field" required>
    </div>

    <div>
        <label for="email" class="label-field">Email <span class="text-rose-500">*</span></label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="input-field" required>
    </div>

    <div>
        <label for="phone" class="label-field">Téléphone</label>
        <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="input-field" placeholder="06 XX XX XX XX">
        <p class="mt-1 text-xs text-slate-400">Format Maroc : 06 ou 07</p>
    </div>

    <div>
        <label for="password" class="label-field">
            Mot de passe
            @if($user->exists)
                <span class="font-normal text-slate-400">(laisser vide pour ne pas changer)</span>
            @else
                <span class="text-rose-500">*</span>
            @endif
        </label>
        <input type="password" name="password" id="password" class="input-field" {{ $user->exists ? '' : 'required' }} minlength="8">
    </div>

    <label class="flex items-center gap-2">
        <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin', $user->is_admin ?? false)) class="h-4 w-4 rounded border-slate-300 text-sky-500 focus:ring-sky-300">
        <span class="text-sm text-slate-700">Administrateur (accès au panneau admin)</span>
    </label>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">{{ $user->exists ? 'Enregistrer' : 'Créer' }}</button>
        <a href="{{ route('admin.users.index') }}" class="btn-secondary">Annuler</a>
    </div>
</form>
@endsection
