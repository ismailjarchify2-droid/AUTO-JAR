@extends('layouts.app')

@section('title', 'Finaliser la commande | AUTO-JAR')
@section('meta_description', 'Saisissez vos informations pour passer votre commande AUTO-JAR.')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-10">
    <div class="mb-8">
        <p class="text-sm uppercase tracking-[0.2em] text-sky-600">Commande</p>
        <h1 class="mt-2 text-3xl font-semibold text-slate-800">Finaliser la commande</h1>
    </div>

    <div class="grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
        <form action="{{ route('commande.store') }}" method="POST" class="card-soft space-y-5 p-6">
            @csrf

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="customer_name" class="label-field">Nom complet</label>
                    <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name') }}" class="input-field" required>
                </div>
                <div>
                    <label for="phone" class="label-field">Téléphone</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" class="input-field" required>
                </div>
                <div>
                    <label for="email" class="label-field">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="input-field">
                </div>
                <div>
                    <label for="city" class="label-field">Ville</label>
                    <input id="city" name="city" type="text" value="{{ old('city') }}" class="input-field" required>
                </div>
            </div>

            <div>
                <label for="address" class="label-field">Adresse</label>
                <textarea id="address" name="address" rows="3" class="input-field" required>{{ old('address') }}</textarea>
            </div>

            <div>
                <label for="notes" class="label-field">Commentaire / note</label>
                <textarea id="notes" name="notes" rows="4" class="input-field" placeholder="Informations complémentaires...">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="btn-primary w-full justify-center">Valider ma commande</button>
        </form>

        <aside class="card-soft p-6">
            <h2 class="text-xl font-semibold text-slate-800">Résumé</h2>
            <div class="mt-4 space-y-4">
                @foreach($items as $item)
                    @php $product = $item['product']; @endphp
                    <div class="flex items-center justify-between gap-3 border-b border-slate-200 pb-3">
                        <div>
                            <p class="font-medium text-slate-700">{{ $product->name }}</p>
                            <p class="text-xs text-slate-500">Qté : {{ $item['quantity'] }}</p>
                        </div>
                        <div class="text-sm font-medium text-slate-700">{{ number_format((float) $item['subtotal'], 2, ',', ' ') }} DH</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 flex items-center justify-between text-lg font-semibold text-slate-800">
                <span>Total</span>
                <span>{{ number_format((float) $total, 2, ',', ' ') }} DH</span>
            </div>
        </aside>
    </div>
</div>
@endsection
