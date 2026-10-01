@extends('layouts.app')

@section('title', 'FAQ | AUTO-JAR')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-10">
    <h1 class="section-title">FAQ</h1>
    <p class="section-sub">Questions fréquentes sur nos pièces et services au Maroc</p>

    <div class="mt-8 space-y-4">
        @foreach($faqs as $faq)
            <details class="card-soft group p-5">
                <summary class="cursor-pointer list-none font-semibold text-slate-800">{{ $faq['q'] }}</summary>
                <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $faq['a'] }}</p>
            </details>
        @endforeach
    </div>
</div>
@endsection
