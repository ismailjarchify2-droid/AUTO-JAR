<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="border-b border-slate-100 bg-slate-50">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2 text-xs text-slate-500">
            <p>{{ $siteSettings['city'] }} · {{ $siteSettings['hours'] }}</p>
            <div class="flex items-center gap-4">
                <a href="tel:+212{{ ltrim($siteSettings['mobile'], '0') }}" class="hover:text-sky-600">{{ $siteSettings['mobile_display'] }}</a>
                <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}" target="_blank" rel="noopener" class="font-medium text-emerald-600 hover:text-emerald-700">WhatsApp</a>
            </div>
        </div>
    </div>

    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3">
        <a href="{{ route('home') }}" class="flex items-center">
    <img
        src="{{ asset('images/logo.png') }}"
        alt="AUTO-JAR"
        class="h-20 w-auto object-contain"
    >
</a>

        <nav class="hidden items-center gap-1 lg:flex" aria-label="Navigation principale">
            <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-sky-50 hover:text-sky-600 {{ request()->routeIs('home') ? 'bg-sky-50 text-sky-600' : '' }}">Accueil</a>
            <a href="{{ route('catalogue') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-sky-50 hover:text-sky-600 {{ request()->routeIs('catalogue') ? 'bg-sky-50 text-sky-600' : '' }}">Catalogue</a>
            <a href="{{ route('marques.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-sky-50 hover:text-sky-600">Marques</a>
            <a href="{{ route('categories.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-sky-50 hover:text-sky-600">Catégories</a>
            <a href="{{ route('demande-piece.create') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-sky-50 hover:text-sky-600">Demande de pièce</a>
            <a href="{{ route('about') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-sky-50 hover:text-sky-600">À propos</a>
            <a href="{{ route('contact') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-sky-50 hover:text-sky-600">Contact</a>
        </nav>

        <div class="flex items-center gap-2">
            <form action="{{ route('catalogue') }}" method="GET" class="hidden md:block">
                <label class="sr-only" for="header-search">Recherche</label>
                <input id="header-search" type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher..." class="w-44 rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100 lg:w-56">
            </form>
            <a href="{{ route('login') }}" class="hidden rounded-lg px-3 py-2 text-sm text-slate-500 hover:text-sky-600 sm:inline">Connexion</a>
            <button id="mobile-menu-toggle" type="button" class="rounded-lg border border-slate-200 p-2 text-slate-600 lg:hidden" aria-label="Menu">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden border-t border-slate-100 bg-white lg:hidden">
        <nav class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-3" aria-label="Navigation mobile">
            <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700">Accueil</a>
            <a href="{{ route('catalogue') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700">Catalogue</a>
            <a href="{{ route('marques.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700">Marques</a>
            <a href="{{ route('categories.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700">Catégories</a>
            <a href="{{ route('demande-piece.create') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700">Demande de pièce</a>
            <a href="{{ route('about') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700">À propos</a>
            <a href="{{ route('faq') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700">FAQ</a>
            <a href="{{ route('contact') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700">Contact</a>
            <form action="{{ route('catalogue') }}" method="GET" class="pt-2">
                <input type="search" name="q" placeholder="Rechercher une pièce..." class="input-field">
            </form>
        </nav>
    </div>
</header>
