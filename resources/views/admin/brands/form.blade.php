@extends('layouts.admin')
@section('title', $brand->exists ? 'Modifier marque' : 'Nouvelle marque')
@section('heading', $brand->exists ? 'Modifier marque' : 'Nouvelle marque')
@section('content')
<form action="{{ $brand->exists ? route('admin.brands.update', $brand) : route('admin.brands.store') }}" method="POST" class="max-w-xl space-y-4 rounded-xl border bg-white p-6">
@csrf
@if($brand->exists) @method('PUT') @endif
<div><label class="label-field">Nom</label><input class="input-field" name="name" value="{{ old('name', $brand->name) }}" required></div>
<div><label class="label-field">Description</label><textarea class="input-field" name="description" rows="3">{{ old('description', $brand->description) }}</textarea></div>
<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $brand->is_active ?? true))> Active</label>
<button class="btn-primary" type="submit">Enregistrer</button>
</form>
@endsection
