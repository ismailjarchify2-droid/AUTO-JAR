<footer class="mt-16 border-t border-slate-200 bg-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 md:grid-cols-4">
        <div class="md:col-span-1">
           <div class="flex items-center gap-3">
    <img
        src="{{ asset('images/logo.png') }}"
        alt="AUTO-JAR"
        class="h-12 w-auto object-contain"
    >

    <span class="font-[family-name:var(--font-display)] text-lg font-semibold text-slate-800">
        AUTO-JAR
    </span>
</div>
            <p class="mt-3 text-sm text-slate-500">{{ $siteSettings['company_tagline'] }}</p>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-slate-800">Navigation</h3>
            <ul class="mt-3 space-y-2 text-sm text-slate-500">
                <li><a href="{{ route('catalogue') }}" class="hover:text-sky-600">Catalogue</a></li>
                <li><a href="{{ route('marques.index') }}" class="hover:text-sky-600">Marques</a></li>
                <li><a href="{{ route('categories.index') }}" class="hover:text-sky-600">Catégories</a></li>
                <li><a href="{{ route('demande-piece.create') }}" class="hover:text-sky-600">Demande de pièce</a></li>
                <li><a href="{{ route('faq') }}" class="hover:text-sky-600">FAQ</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-slate-800">Contact</h3>
            <ul class="mt-3 space-y-2 text-sm text-slate-500">
                <li>{{ $siteSettings['address'] }}</li>
                <li><a href="tel:+212{{ ltrim($siteSettings['phone'], '0') }}" class="hover:text-sky-600">{{ $siteSettings['phone_display'] }}</a></li>
                <li><a href="tel:+212{{ ltrim($siteSettings['mobile'], '0') }}" class="hover:text-sky-600">{{ $siteSettings['mobile_display'] }}</a></li>
                <li><a href="mailto:{{ $siteSettings['email'] }}" class="hover:text-sky-600">{{ $siteSettings['email'] }}</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-slate-800">Horaires</h3>
            <p class="mt-3 text-sm text-slate-500">{{ $siteSettings['hours'] }}</p>
            <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}" target="_blank" rel="noopener" class="btn-whatsapp mt-4">WhatsApp {{ $siteSettings['whatsapp_display'] }}</a>
        </div>
    </div>
    <div class="border-t border-slate-100">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-4 text-xs text-slate-400 sm:flex-row sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ $siteSettings['company_name'] }}. Tous droits réservés.</p>
            <p>Prix en DH · Maroc · +212</p>
        </div>
    </div>
</footer>
