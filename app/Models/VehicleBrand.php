<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class VehicleBrand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (VehicleBrand $brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }

    public function models(): HasMany
    {
        return $this->hasMany(VehicleModel::class);
    }

    public function compatibilities(): HasMany
    {
        return $this->hasMany(ProductVehicleCompatibility::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
