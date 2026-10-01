@extends('layouts.admin')

@section('title', 'Paramètres')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-800">Paramètres du site</h1>
    <p class="mt-1 text-sm text-slate-500">Informations affichées sur le site public</p>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" class="card-soft max-w-3xl p-6 space-y-6">
    @csrf
    @method('PUT')

    <section class="space-y-5">
        <h2 class="font-semibold text-slate-800">Entreprise</h2>

        <div>
            <label for="company_name" class="label-field">Nom de l'entreprise <span class="text-rose-500">*</span></label>
            <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $settings['company_name']) }}" class="input-field" required>
        </div>

        <div>
            <label for="company_tagline" class="label-field">Slogan</label>
            <input type="text" name="company_tagline" id="company_tagline" value="{{ old('company_tagline', $settings['company_tagline']) }}" class="input-field" placeholder="Pièces automobiles au Maroc">
        </div>

        <div>
            <label for="meta_description" class="label-field">Meta description (SEO)</label>
            <textarea name="meta_description" id="meta_description" rows="2" class="input-field">{{ old('meta_description', $settings['meta_description']) }}</textarea>
        </div>
    </section>

    <section class="space-y-5 border-t border-slate-100 pt-6">
        <h2 class="font-semibold text-slate-800">Contact</h2>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="phone" class="label-field">Téléphone fixe (stockage)</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $settings['phone']) }}" class="input-field" placeholder="0522123456">
            </div>
            <div>
                <label for="phone_display" class="label-field">Téléphone fixe (affichage)</label>
                <input type="text" name="phone_display" id="phone_display" value="{{ old('phone_display', $settings['phone_display']) }}" class="input-field" placeholder="05 22 12 34 56">
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="mobile" class="label-field">Mobile (stockage)</label>
                <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $settings['mobile']) }}" class="input-field" placeholder="0612345678">
                <p class="mt-1 text-xs text-slate-400">Format : 06 ou 07</p>
            </div>
            <div>
                <label for="mobile_display" class="label-field">Mobile (affichage)</label>
                <input type="text" name="mobile_display" id="mobile_display" value="{{ old('mobile_display', $settings['mobile_display']) }}" class="input-field" placeholder="06 12 34 56 78">
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="whatsapp" class="label-field">WhatsApp (numéro international sans +)</label>
                <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $settings['whatsapp']) }}" class="input-field" placeholder="212612345678">
            </div>
            <div>
                <label for="whatsapp_display" class="label-field">WhatsApp (affichage)</label>
                <input type="text" name="whatsapp_display" id="whatsapp_display" value="{{ old('whatsapp_display', $settings['whatsapp_display']) }}" class="input-field" placeholder="06 12 34 56 78">
            </div>
        </div>

        <div>
            <label for="email" class="label-field">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $settings['email']) }}" class="input-field" placeholder="contact@pieceauto.ma">
        </div>
    </section>

    <section class="space-y-5 border-t border-slate-100 pt-6">
        <h2 class="font-semibold text-slate-800">Adresse & horaires</h2>

        <div>
            <label for="address" class="label-field">Adresse</label>
            <input type="text" name="address" id="address" value="{{ old('address', $settings['address']) }}" class="input-field" placeholder="123 Bd Zerktouni, Casablanca">
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="city" class="label-field">Ville</label>
                <input type="text" name="city" id="city" value="{{ old('city', $settings['city']) }}" class="input-field" placeholder="Casablanca">
            </div>
            <div>
                <label for="hours" class="label-field">Horaires</label>
                <input type="text" name="hours" id="hours" value="{{ old('hours', $settings['hours']) }}" class="input-field" placeholder="Lun-Sam 09h-19h">
            </div>
        </div>
    </section>

    <div class="flex gap-3 border-t border-slate-100 pt-6">
        <button type="submit" class="btn-primary">Enregistrer les paramètres</button>
    </div>
</form>
@endsection
