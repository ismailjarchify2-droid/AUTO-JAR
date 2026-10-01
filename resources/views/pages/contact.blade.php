@extends('layouts.app')

@section('title', 'Contact | AUTO-JAR')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <h1 class="section-title">Contact</h1>
    <p class="section-sub">Parlez à notre équipe à Casablanca et partout au Maroc</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-2">
        <div class="card-soft space-y-4 p-6 text-sm text-slate-600">
            <p><strong class="text-slate-800">Adresse</strong><br>{{ $siteSettings['address'] }}</p>
            <p><strong class="text-slate-800">Téléphone</strong><br>
                <a class="text-sky-600" href="tel:+212{{ ltrim($siteSettings['phone'], '0') }}">{{ $siteSettings['phone_display'] }}</a><br>
                <a class="text-sky-600" href="tel:+212{{ ltrim($siteSettings['mobile'], '0') }}">{{ $siteSettings['mobile_display'] }}</a>
            </p>
            <p><strong class="text-slate-800">WhatsApp</strong><br>
                <a class="text-emerald-600" href="https://wa.me/{{ $siteSettings['whatsapp'] }}" target="_blank" rel="noopener">{{ $siteSettings['whatsapp_display'] }}</a>
            </p>
            <p><strong class="text-slate-800">Email</strong><br>
                <a class="text-sky-600" href="mailto:{{ $siteSettings['email'] }}">{{ $siteSettings['email'] }}</a>
            </p>
            <p><strong class="text-slate-800">Horaires</strong><br>{{ $siteSettings['hours'] }}</p>
        </div>

        <form action="{{ route('contact.store') }}" method="POST" class="card-soft space-y-4 p-6">
            @csrf
            @if($errors->any())
                <div class="rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
                    <ul class="list-disc pl-4">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="label-field" for="name">Nom *</label>
                    <input class="input-field" name="name" id="name" value="{{ old('name') }}" required>
                </div>
                <div>
                    <label class="label-field" for="phone">Téléphone *</label>
                    <input class="input-field" name="phone" id="phone" value="{{ old('phone') }}" placeholder="06 XX XX XX XX" required>
                </div>
                <div>
                    <label class="label-field" for="email">Email</label>
                    <input class="input-field" type="email" name="email" id="email" value="{{ old('email') }}">
                </div>
                <div>
                    <label class="label-field" for="city">Ville</label>
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
            </div>
            <div>
                <label class="label-field" for="subject">Sujet</label>
                <input class="input-field" name="subject" id="subject" value="{{ old('subject') }}">
            </div>
            <div>
                <label class="label-field" for="message">Message *</label>
                <textarea class="input-field" name="message" id="message" rows="5" required>{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="btn-primary">Envoyer</button>
        </form>
    </div>
</div>
@endsection
