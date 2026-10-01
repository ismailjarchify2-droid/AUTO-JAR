<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartRequest extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'whatsapp',
        'city',
        'vehicle_brand',
        'vehicle_model',
        'vehicle_year',
        'part_name',
        'reference',
        'description',
        'photo',
        'product_id',
        'status',
        'admin_notes',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'En attente',
            'processing' => 'En cours',
            'quoted' => 'Devis envoyé',
            'completed' => 'Terminée',
            'cancelled' => 'Annulée',
            default => $this->status,
        };
    }
}
