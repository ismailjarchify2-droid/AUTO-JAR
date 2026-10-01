<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function models(VehicleBrand $marque): View
    {
        abort_unless($marque->is_active, 404);

        $marque->load(['models' => fn ($q) => $q->where('is_active', true)->orderBy('name')]);

        $products = Product::query()
            ->active()
            ->whereHas('compatibilities', fn ($q) => $q->where('vehicle_brand_id', $marque->id))
            ->with(['brand', 'category'])
            ->latest()
            ->paginate(12);

        return view('vehicles.show', [
            'vehicleBrand' => $marque,
            'products' => $products,
        ]);
    }

    public function modelProducts(VehicleBrand $marque, VehicleModel $modele): View
    {
        abort_unless($marque->is_active && $modele->is_active, 404);
        abort_unless($modele->vehicle_brand_id === $marque->id, 404);

        $products = Product::query()
            ->active()
            ->whereHas('compatibilities', function ($q) use ($marque, $modele) {
                $q->where('vehicle_brand_id', $marque->id)
                    ->where('vehicle_model_id', $modele->id);
            })
            ->with(['brand', 'category'])
            ->latest()
            ->paginate(12);

        return view('vehicles.model', [
            'vehicleBrand' => $marque,
            'vehicleModel' => $modele,
            'products' => $products,
        ]);
    }
}
