@extends('layouts.app')

@section('title', 'À propos | AUTO-JAR')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-10">
    <h1 class="section-title">À propos</h1>
    <p class="section-sub">Un partenaire de confiance pour vos pièces automobiles au Maroc</p>

    <div class="card-soft mt-8 space-y-5 p-6 text-slate-600 leading-relaxed">
        <p><strong class="text-slate-800">{{ $siteSettings['company_name'] }}</strong> est une entreprise marocaine spécialisée dans la distribution de pièces automobiles pour les particuliers et les professionnels.</p>
        <p>Nous accompagnons les conducteurs à Casablanca, Rabat, Marrakech, Fès, Tanger, Agadir, Meknès et dans tout le Royaume pour trouver rapidement la bonne pièce, au bon prix, en dirhams (DH).</p>
        <p>Notre catalogue couvre le freinage, les filtres, la suspension, l’allumage, l’éclairage et bien d’autres familles. Si une pièce n’est pas listée, notre équipe la recherche pour vous.</p>
        <p>Contact : {{ $siteSettings['phone_display'] }} · WhatsApp {{ $siteSettings['whatsapp_display'] }} · {{ $siteSettings['address'] }}</p>
    </div>
</div>
@endsection
