@extends('layouts.admin')

@section('title', 'Utilisateurs')

@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-semibold text-slate-800">Utilisateurs</h1>
        <p class="mt-1 text-sm text-slate-500">Comptes administrateurs</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-primary shrink-0">Nouvel utilisateur</a>
</div>

<div class="card-soft overflow-x-auto">
    <table class="w-full min-w-[600px] text-left text-sm">
        <thead class="border-b border-slate-100 bg-slate-50 text-xs uppercase text-slate-500">
            <tr>
                <th class="px-4 py-3 font-medium">Nom</th>
                <th class="px-4 py-3 font-medium">Email</th>
                <th class="px-4 py-3 font-medium">Téléphone</th>
                <th class="px-4 py-3 font-medium">Rôle</th>
                <th class="px-4 py-3 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($users as $user)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $user->phone ?: '—' }}</td>
                    <td class="px-4 py-3">
                        @if($user->is_admin)
                            <span class="badge-stock">Admin</span>
                        @else
                            <span class="rounded-md bg-slate-100 px-2 py-0.5 text-xs text-slate-600">Utilisateur</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-sky-600 hover:text-sky-700">Modifier</a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-700">Supprimer</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-slate-500">Aucun utilisateur.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $users->links() }}</div>
@endsection
