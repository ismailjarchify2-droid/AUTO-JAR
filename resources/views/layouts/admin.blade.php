<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Administration') — AUTO-JAR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-700">
<div class="flex min-h-screen">
    <aside class="hidden w-64 shrink-0 border-r border-slate-200 bg-white lg:block">
        <div class="border-b border-slate-100 px-5 py-4">
            <a href="{{ route('admin.dashboard') }}" class="font-[family-name:var(--font-display)] text-lg font-semibold text-slate-800">Admin AUTO-JAR</a>
            <p class="text-xs text-slate-400">Tableau de bord</p>
        </div>
        <nav class="space-y-1 p-3 text-sm">
            @php
                $links = [
                    ['admin.dashboard', 'Tableau de bord'],
                    ['admin.products.index', 'Produits'],
                    ['admin.categories.index', 'Catégories'],
                    ['admin.brands.index', 'Marques pièces'],
                    ['admin.vehicle-brands.index', 'Marques véhicules'],
                    ['admin.orders.index', 'Commandes'],
                    ['admin.part-requests.index', 'Demandes'],
                    ['admin.messages.index', 'Messages'],
                    ['admin.users.index', 'Utilisateurs'],
                    ['admin.settings.edit', 'Paramètres'],
                ];
            @endphp
            @foreach($links as [$route, $label])
                <a href="{{ route($route) }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs(str_replace('.index','.*', str_replace('.edit','.*', $route))) || request()->routeIs($route) ? 'bg-sky-50 font-medium text-sky-700' : 'text-slate-600 hover:bg-slate-50' }}">{{ $label }}</a>
            @endforeach
            <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 text-slate-600 hover:bg-slate-50" target="_blank">Voir le site</a>
            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-rose-600 hover:bg-rose-50">Déconnexion</button>
            </form>
        </nav>
    </aside>

    <div class="flex min-w-0 flex-1 flex-col">
        <header class="flex items-center justify-between border-b border-slate-200 bg-white px-4 py-3 lg:px-8">
            <div>
                <p class="text-sm font-medium text-slate-800">@yield('heading', 'Administration')</p>
                <p class="text-xs text-slate-400">{{ auth()->user()->name ?? '' }}</p>
            </div>
            <a href="{{ route('home') }}" class="text-sm text-sky-600 lg:hidden">Site</a>
        </header>

        @if(session('success'))
            <div class="border-b border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 lg:px-8">{{ session('success') }}</div>
        @endif

        @if(session('error') || $errors->any())
            <div class="border-b border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-700 lg:px-8">
                {{ session('error') ?: $errors->first() }}
            </div>
        @endif

        <main class="flex-1 p-4 lg:p-8">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
