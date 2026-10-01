@extends('layouts.app')

@section('title', 'Demande de pièce | AUTO-JAR')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-10">
    <h1 class="section-title">Vous ne trouvez pas votre pièce ?</h1>
    <p class="section-sub">Remplissez le formulaire. Nous vous recontactons par téléphone ou WhatsApp.</p>

    @if($errors->any())
        <div class="mt-6 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <ul class="list-disc space-y-1 pl-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($product)
        <div class="mt-6 rounded-lg border border-sky-100 bg-sky-50 p-4 text-sm text-slate-700">
            Demande pour : <strong>{{ $product->name }}</strong> ({{ $product->reference }})
        </div>
    @endif

    <form action="{{ route('demande-piece.store') }}" method="POST" enctype="multipart/form-data" class="card-soft mt-8 space-y-5 p-6">
        @csrf
        @if($product)
            <input type="hidden" name="product_id" value="{{ $product->id }}">
        @endif

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="label-field" for="name">Nom *</label>
                <input class="input-field" type="text" name="name" id="name" value="{{ old('name') }}" required>
            </div>
            <div>
                <label class="label-field" for="phone">Téléphone *</label>
                <input class="input-field" type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="06 XX XX XX XX" required>
            </div>
            <div>
                <label class="label-field" for="whatsapp">WhatsApp</label>
                <input class="input-field" type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}" placeholder="07 XX XX XX XX">
            </div>
            <div>
    <label class="label-field" for="city">Ville *</label>
    <input
        type="text"
        class="input-field"
        name="city"
        id="city"
        value="{{ old('city') }}"
        placeholder="Ex. Casablanca, Rabat, Marrakech..."
        required
    >
</div>
            <div>
                <label class="label-field" for="vehicle_brand">Marque véhicule</label>
                <input class="input-field" type="text" name="vehicle_brand" id="vehicle_brand" value="{{ old('vehicle_brand') }}" placeholder="Dacia, Renault...">
            </div>
            <div>
                <label class="label-field" for="vehicle_model">Modèle</label>
                <input class="input-field" type="text" name="vehicle_model" id="vehicle_model" value="{{ old('vehicle_model') }}" placeholder="Logan, Clio...">
            </div>
            <div>
                <label class="label-field" for="vehicle_year">Année</label>
                <input class="input-field" type="text" name="vehicle_year" id="vehicle_year" value="{{ old('vehicle_year') }}" placeholder="2019">
            </div>
            <div>
                <label class="label-field" for="part_name">Nom de la pièce *</label>
                <input class="input-field" type="text" name="part_name" id="part_name" value="{{ old('part_name', $product?->name) }}" required>
            </div>
            <div class="sm:col-span-2">
                <label class="label-field" for="reference">Référence</label>
                <input class="input-field" type="text" name="reference" id="reference" value="{{ old('reference', $product?->reference) }}">
            </div>
            <div class="sm:col-span-2">
                <label class="label-field" for="description">Description</label>
                <textarea class="input-field" name="description" id="description" rows="4">{{ old('description') }}</textarea>
            </div>
            <div class="sm:col-span-2">
                <label class="label-field" for="photo">Photo</label>
                <input class="input-field" type="file" name="photo" id="photo" accept="image/*">
            </div>
        </div>
        <button type="submit" class="btn-primary">Envoyer la demande</button>
    </form>
</div>
@endsection
