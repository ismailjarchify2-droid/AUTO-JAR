@extends('layouts.admin')

@section('title', $product->exists ? 'Modifier produit' : 'Nouveau produit')
@section('heading', $product->exists ? 'Modifier produit' : 'Nouveau produit')

@section('content')
<form action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
      method="POST" enctype="multipart/form-data"
      class="max-w-4xl space-y-5 rounded-xl border border-slate-200 bg-white p-6">
    @csrf
    @if($product->exists) @method('PUT') @endif

    @if($errors->any())
        <div class="rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
            <ul class="list-disc pl-4">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label class="label-field">Nom</label>
            <input class="input-field" name="name" value="{{ old('name', $product->name) }}" required>
        </div>
        <div>
            <label class="label-field">Référence</label>
            <input class="input-field" name="reference" value="{{ old('reference', $product->reference) }}" required>
        </div>
        <div>
            <label class="label-field">Prix (DH)</label>
            <input class="input-field" type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
        </div>
        <div>
            <label class="label-field">Marque pièce</label>
            <select class="input-field" name="brand_id">
                <option value="">—</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label-field">Catégorie</label>
            <select class="input-field" name="category_id">
                <option value="">—</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label-field">Stock</label>
            <input class="input-field" type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required>
        </div>
        <div>
            <label class="label-field">Disponibilité</label>
            <select class="input-field" name="availability">
                @foreach(['available'=>'En stock','out_of_stock'=>'Rupture','on_order'=>'Sur commande'] as $val=>$label)
                    <option value="{{ $val }}" @selected(old('availability', $product->availability ?? 'available') === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="sm:col-span-2">
            <label class="label-field">Description courte</label>
            <textarea class="input-field" name="short_description" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
        </div>
        <div class="sm:col-span-2">
            <label class="label-field">Description</label>
            <textarea class="input-field" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="sm:col-span-2">
            <label class="label-field">Caractéristiques (une par ligne)</label>
            <textarea class="input-field" name="features_text" rows="4">{{ old('features_text', is_array($product->features) ? implode("\n", $product->features) : '') }}</textarea>
        </div>
        <div>
            <label class="label-field">Image principale</label>
            <input class="input-field" type="file" name="image" accept="image/*">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="" class="mt-2 h-20 rounded object-cover">
            @endif
        </div>
        <div>
            <label class="label-field">Galerie</label>
            <input class="input-field" type="file" name="gallery[]" accept="image/*" multiple>
        </div>
        <div>
            <label class="label-field">Compatibilité — marque véhicule</label>
            <select class="input-field" name="vehicle_brand_id" id="vehicle_brand">
                <option value="">—</option>
                @foreach($vehicleBrands as $vb)
                    <option value="{{ $vb->id }}">{{ $vb->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label-field">Modèle véhicule</label>
            <select class="input-field" name="vehicle_model_id" id="vehicle_model">
                <option value="">—</option>
            </select>
        </div>
        <div>
            <label class="label-field">Année de</label>
            <input class="input-field" type="number" name="year_from" value="{{ old('year_from') }}">
        </div>
        <div>
            <label class="label-field">Année à</label>
            <input class="input-field" type="number" name="year_to" value="{{ old('year_to') }}">
        </div>
        <div>
            <label class="label-field">Meta title</label>
            <input class="input-field" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}">
        </div>
        <div>
            <label class="label-field">Meta description</label>
            <input class="input-field" name="meta_description" value="{{ old('meta_description', $product->meta_description) }}">
        </div>
    </div>

    <div class="flex flex-wrap gap-4">
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))> Actif</label>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))> Mis en avant</label>
    </div>

    <div class="flex gap-3">
        <button class="btn-primary" type="submit">Enregistrer</button>
        <a href="{{ route('admin.products.index') }}" class="btn-secondary">Annuler</a>
    </div>
</form>
@endsection
