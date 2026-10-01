<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVehicleCompatibility extends Model
{
    protected $fillable = [
        'product_id',
        'vehicle_brand_id',
        'vehicle_model_id',
        'vehicle_year_id',
        'year_from',
        'year_to',
        'notes',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function vehicleBrand(): BelongsTo
    {
        return $this->belongsTo(VehicleBrand::class);
    }

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function vehicleYear(): BelongsTo
    {
        return $this->belongsTo(VehicleYear::class);
    }

    public function label(): string
    {
        $parts = [$this->vehicleBrand?->name];

        if ($this->vehicleModel) {
            $parts[] = $this->vehicleModel->name;
        }

        if ($this->vehicleYear) {
            $parts[] = (string) $this->vehicleYear->year;
        } elseif ($this->year_from || $this->year_to) {
            $parts[] = trim(($this->year_from ?? '?').' - '.($this->year_to ?? '?'));
        }

        return implode(' ', array_filter($parts));
    }
}
