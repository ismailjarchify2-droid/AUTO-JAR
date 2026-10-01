@extends('layouts.admin')

@section('title', $vehicleBrand->exists ? 'Modifier la marque véhicule' : 'Nouvelle marque véhicule')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-800">{{ $vehicleBrand->exists ? 'Modifier la marque véhicule' : 'Nouvelle marque véhicule' }}</h1>
    <p class="mt-1 text-sm text-slate-500">
        <a href="{{ route('admin.vehicle-brands.index') }}" class="text-sky-600 hover:text-sky-700">← Retour à la liste</a>
    </p>
</div>

<form action="{{ $vehicleBrand->exists ? route('admin.vehicle-brands.update', $vehicleBrand) : route('admin.vehicle-brands.store') }}"
      method="POST" class="card-soft max-w-2xl p-6 space-y-5">
    @csrf
    @if($vehicleBrand->exists)
        @method('PUT')
    @endif

    <div>
        <label for="name" class="label-field">Nom <span class="text-rose-500">*</span></label>
        <input type="text" name="name" id="name" value="{{ old('name', $vehicleBrand->name) }}" class="input-field" required placeholder="Dacia, Renault…">
    </div>

    <label class="flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $vehicleBrand->is_active ?? true)) class="h-4 w-4 rounded border-slate-300 text-sky-500 focus:ring-sky-300">
        <span class="text-sm text-slate-700">Active (visible sur le site)</span>
    </label>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">{{ $vehicleBrand->exists ? 'Enregistrer' : 'Créer' }}</button>
        <a href="{{ route('admin.vehicle-brands.index') }}" class="btn-secondary">Annuler</a>
    </div>
</form>

@if($vehicleBrand->exists)
    <div class="mt-10 grid gap-8 lg:grid-cols-2">
        <section class="card-soft p-6">
            <h2 class="font-semibold text-slate-800">Modèles existants</h2>
            @if($vehicleBrand->models->count())
                <ul class="mt-4 divide-y divide-slate-100">
                    @foreach($vehicleBrand->models as $model)
                        <li class="py-3">
                            <p class="font-medium text-slate-800">{{ $model->name }}</p>
                            @if($model->years->count())
                                <p class="mt-1 text-xs text-slate-400">
                                    Années : {{ $model->years->pluck('year')->sort()->implode(', ') }}
                                </p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-4 text-sm text-slate-500">Aucun modèle pour le moment.</p>
            @endif
        </section>

        <section class="card-soft p-6">
            <h2 class="font-semibold text-slate-800">Ajouter un modèle</h2>
            <form action="{{ route('admin.vehicle-brands.models.store', $vehicleBrand) }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label for="model_name" class="label-field">Nom du modèle <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="model_name" value="{{ old('name') }}" class="input-field" required placeholder="Logan, Clio, 208…">
                </div>
                <div>
                    <label for="years" class="label-field">Années</label>
                    <input type="text" name="years" id="years" value="{{ old('years') }}" class="input-field" placeholder="2018, 2019, 2020, 2021">
                    <p class="mt-1 text-xs text-slate-400">Séparez les années par des virgules</p>
                </div>
                <button type="submit" class="btn-primary">Ajouter le modèle</button>
            </form>
        </section>
    </div>
@endif
@endsection
