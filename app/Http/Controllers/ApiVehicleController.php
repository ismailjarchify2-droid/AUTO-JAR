<?php

namespace App\Http\Controllers;

use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleYear;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiVehicleController extends Controller
{
    public function models(Request $request): JsonResponse
    {
        $request->validate(['vehicle_brand_id' => ['required', 'exists:vehicle_brands,id']]);

        $models = VehicleModel::query()
            ->where('vehicle_brand_id', $request->vehicle_brand_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($models);
    }

    public function years(Request $request): JsonResponse
    {
        $request->validate(['vehicle_model_id' => ['required', 'exists:vehicle_models,id']]);

        $years = VehicleYear::query()
            ->where('vehicle_model_id', $request->vehicle_model_id)
            ->orderByDesc('year')
            ->get(['id', 'year']);

        return response()->json($years);
    }

    public function brands(): JsonResponse
    {
        $brands = VehicleBrand::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($brands);
    }
}
