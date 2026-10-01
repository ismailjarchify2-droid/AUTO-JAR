@extends('layouts.admin')
@section('title', 'Catégories')
@section('heading', 'Catégories')
@section('content')
<div class="mb-4 flex justify-end"><a href="{{ route('admin.categories.create') }}" class="btn-primary">Nouvelle catégorie</a></div>
<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
<table class="min-w-full text-sm">
<thead class="border-b bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-4 py-3 text-left">Nom</th><th class="px-4 py-3">Ordre</th><th class="px-4 py-3"></th></tr></thead>
<tbody class="divide-y">
@foreach($categories as $category)
<tr>
<td class="px-4 py-3 font-medium">{{ $category->name }}</td>
<td class="px-4 py-3 text-center">{{ $category->sort_order }}</td>
<td class="px-4 py-3 text-right">
<a href="{{ route('admin.categories.edit', $category) }}" class="text-sky-600">Modifier</a>
<form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ?')">@csrf @method('DELETE')<button class="ml-3 text-rose-600">Suppr.</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="mt-4">{{ $categories->links() }}</div>
@endsection
