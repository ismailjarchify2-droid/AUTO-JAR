@extends('layouts.app')

@section('title', 'Marques de pièces et véhicules | AUTO-JAR')

@section('meta_description', 'Découvrez nos marques de pièces automobiles et les marques de véhicules compatibles au Maroc.')

@section('content')

<div class="mx-auto max-w-7xl px-4 py-10">

    {{-- TITRE --}}
    <div class="mb-10">
        <h1 class="section-title">
            Marques
        </h1>

        <p class="section-sub">
            Marques de pièces et marques automobiles · Maroc
        </p>
    </div>


    {{-- ========================================= --}}
    {{-- MARQUES AUTOMOBILES --}}
    {{-- ========================================= --}}

    <section class="mb-14">

        <div>
            <h2 class="text-xl font-semibold text-slate-800">
                Marques automobiles
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Dacia, Renault, Peugeot, BMW et plus
            </p>
        </div>


        {{-- GRILLE --}}
        <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">

            @forelse($vehicleBrands as $vb)

                <a
                    href="{{ route('modeles.show', $vb) }}"
                    class="card-soft flex min-h-[105px] flex-col items-center justify-center px-3 py-3 text-center transition hover:border-sky-200 hover:text-sky-600"
                >

                    {{-- LOGO --}}
                    <div class="flex h-20 w-full items-center justify-center bg-slate-100">

                        <img
                            src="{{ asset('images/brands/' . $vb->slug . '.png') }}"
                            alt="{{ $vb->name }}"
                            class="h-16 w-auto object-contain"
                        >

                    </div>


                    {{-- NOM --}}
                    <span class="mt-2 text-xs font-semibold text-slate-700">
                        {{ $vb->name }}
                    </span>


                    {{-- MODELES --}}
                    <span class="mt-1 text-[11px] text-slate-400">
                        {{ $vb->models_count }} modèle(s)
                    </span>

                </a>

            @empty

                <div class="card-soft col-span-full p-8 text-center">
                    <p class="text-slate-500">
                        Aucune marque automobile disponible.
                    </p>
                </div>

            @endforelse

        </div>

    </section>



    {{-- ========================================= --}}
    {{-- MARQUES DE PIECES --}}
    {{-- ========================================= --}}

    <section>

        <div class="flex items-end justify-between gap-4">

            <div>
                <h2 class="text-xl font-semibold text-slate-800">
                    Marques de pièces
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    OEM et aftermarket · Prix en DH
                </p>
            </div>

            <a
                href="{{ route('catalogue') }}"
                class="text-sm font-medium text-sky-600 hover:text-sky-700"
            >
                Catalogue complet
            </a>

        </div>


        {{-- GRILLE --}}
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

            @forelse($brands as $brand)

                <a
                    href="{{ route('marques.show', $brand) }}"
                    class="card-soft p-5 transition hover:border-sky-200"
                >

                    <h3 class="font-semibold text-slate-800">
                        {{ $brand->name }}
                    </h3>

                    @if($brand->description)

                        <p class="mt-1 text-sm text-slate-500 line-clamp-2">
                            {{ $brand->description }}
                        </p>

                    @endif

                    <p class="mt-3 text-xs font-medium text-sky-600">
                        {{ $brand->products_count }} pièce(s)
                    </p>

                </a>

            @empty

                <div class="card-soft p-8 text-center sm:col-span-2 lg:col-span-4">
                    <p class="text-slate-500">
                        Aucune marque de pièce disponible pour le moment.
                    </p>
                </div>

            @endforelse

        </div>

    </section>

</div>

@endsection