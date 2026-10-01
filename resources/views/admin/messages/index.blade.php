@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-800">Messages de contact</h1>
    <p class="mt-1 text-sm text-slate-500">Messages reçus via le formulaire de contact</p>
</div>

<div class="card-soft overflow-x-auto">
    <table class="w-full min-w-[700px] text-left text-sm">
        <thead class="border-b border-slate-100 bg-slate-50 text-xs uppercase text-slate-500">
            <tr>
                <th class="px-4 py-3 font-medium">Date</th>
                <th class="px-4 py-3 font-medium">Expéditeur</th>
                <th class="px-4 py-3 font-medium">Sujet</th>
                <th class="px-4 py-3 font-medium">Ville</th>
                <th class="px-4 py-3 font-medium">Lu</th>
                <th class="px-4 py-3 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($messages as $message)
                <tr class="hover:bg-slate-50 {{ ! $message->is_read ? 'bg-sky-50/30' : '' }}">
                    <td class="px-4 py-3 text-slate-500">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-slate-800">{{ $message->name }}</p>
                        <p class="text-xs text-slate-400">{{ $message->phone }}</p>
                    </td>
                    <td class="px-4 py-3 text-slate-700">{{ $message->subject ?: '—' }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $message->city ?: '—' }}</td>
                    <td class="px-4 py-3">
                        @if($message->is_read)
                            <span class="text-xs text-slate-400">Lu</span>
                        @else
                            <span class="badge-stock">Non lu</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.messages.show', $message) }}" class="text-sky-600 hover:text-sky-700">Lire</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-slate-500">Aucun message.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $messages->links() }}</div>
@endsection
