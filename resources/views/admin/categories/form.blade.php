@extends('layouts.admin')
@section('title', $category->exists ? 'Modifier catégorie' : 'Nouvelle catégorie')
@section('heading', $category->exists ? 'Modifier catégorie' : 'Nouvelle catégorie')
@section('content')
<form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" class="max-w-xl space-y-4 rounded-xl border bg-white p-6">
@csrf
@if($category->exists) @method('PUT') @endif
<div><label class="label-field">Nom</label><input class="input-field" name="name" value="{{ old('name', $category->name) }}" required></div>
<div><label class="label-field">Description</label><textarea class="input-field" name="description" rows="3">{{ old('description', $category->description) }}</textarea></div>
<div><label class="label-field">Ordre</label><input class="input-field" type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}"></div>
<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))> Active</label>
<button class="btn-primary" type="submit">Enregistrer</button>
</form>
@endsection
