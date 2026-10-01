<?php

namespace App\Http\Controllers;

use App\Models\PartRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartRequestController extends Controller
{
    public function create(Request $request): View
    {
        $product = null;
        if ($request->filled('produit')) {
            $product = Product::query()->active()->where('slug', $request->produit)->first();
        }

        $cities = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kénitra', 'Tétouan', 'Safi', 'El Jadida'];

        return view('part-requests.create', compact('product', 'cities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:80'],
            'vehicle_brand' => ['nullable', 'string', 'max:80'],
            'vehicle_model' => ['nullable', 'string', 'max:80'],
            'vehicle_year' => ['nullable', 'string', 'max:10'],
            'part_name' => ['required', 'string', 'max:180'],
            'reference' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:2000'],
            'photo' => ['nullable', 'image', 'max:4096'],
            'product_id' => ['nullable', 'exists:products,id'],
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'phone.required' => 'Le téléphone est obligatoire.',
            'city.required' => 'La ville est obligatoire.',
            'part_name.required' => 'Le nom de la pièce est obligatoire.',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('part-requests', 'public');
        }

        $data['status'] = 'pending';

        PartRequest::query()->create($data);

        return redirect()
            ->route('demande-piece.create')
            ->with('success', 'Votre demande a bien été envoyée. Nous vous contactons rapidement par téléphone ou WhatsApp.');
    }
}
