<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VehicleBrandController extends Controller
{
    public function index(): View
    {
        $vehicleBrands = VehicleBrand::query()->withCount('models')->orderBy('name')->paginate(20);

        return view('admin.vehicle-brands.index', compact('vehicleBrands'));
    }

    public function create(): View
    {
        return view('admin.vehicle-brands.form', ['vehicleBrand' => new VehicleBrand]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120']]);
        VehicleBrand::query()->create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.vehicle-brands.index')->with('success', 'Marque véhicule créée.');
    }

    public function edit(VehicleBrand $vehicleBrand): View
    {
        $vehicleBrand->load(['models.years']);

        return view('admin.vehicle-brands.form', compact('vehicleBrand'));
    }

    public function update(Request $request, VehicleBrand $vehicleBrand): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120']]);
        $vehicleBrand->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.vehicle-brands.index')->with('success', 'Marque véhicule mise à jour.');
    }

    public function destroy(VehicleBrand $vehicleBrand): RedirectResponse
    {
        $vehicleBrand->delete();

        return redirect()->route('admin.vehicle-brands.index')->with('success', 'Marque véhicule supprimée.');
    }

    public function storeModel(Request $request, VehicleBrand $vehicleBrand): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'years' => ['nullable', 'string'],
        ]);

        $model = VehicleModel::query()->create([
            'vehicle_brand_id' => $vehicleBrand->id,
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'is_active' => true,
        ]);

        if (! empty($data['years'])) {
            preg_match_all('/\d{4}/', $data['years'], $matches);
            foreach (array_unique($matches[0] ?? []) as $year) {
                VehicleYear::query()->firstOrCreate([
                    'vehicle_model_id' => $model->id,
                    'year' => (int) $year,
                ]);
            }
        }

        return back()->with('success', 'Modèle ajouté.');
    }
}
