@extends('layouts.app')

@section('title', 'Connexion administrateur')

@section('content')
<div class="mx-auto flex max-w-md flex-col px-4 py-16">
    <h1 class="section-title text-center">Connexion</h1>
    <p class="section-sub text-center">Espace administrateur</p>

    <form action="{{ route('login.store') }}" method="POST" class="card-soft mt-8 space-y-4 p-6">
        @csrf
        @if($errors->any())
            <div class="rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
                {{ $errors->first() }}
            </div>
        @endif
        <div>
            <label class="label-field" for="email">Email</label>
            <input class="input-field" type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div>
            <label class="label-field" for="password">Mot de passe</label>
            <input class="input-field" type="password" name="password" id="password" required>
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-sky-500">
            Se souvenir de moi
        </label>
        <button type="submit" class="btn-primary w-full">Se connecter</button>
        <a href="{{ route('home') }}" class="block text-center text-sm text-slate-500 hover:text-sky-600">Retour au site</a>
    </form>
</div>
@endsection
