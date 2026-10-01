<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'reference',
        'brand_id',
        'category_id',
        'price',
        'stock',
        'availability',
        'short_description',
        'description',
        'features',
        'image',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'features' => 'array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name).'-'.Str::lower(Str::random(4));
            }
        });

        static::saving(function (Product $product) {
            if ($product->stock <= 0 && $product->availability === 'available') {
                $product->availability = 'out_of_stock';
            }
            if ($product->stock > 0 && $product->availability === 'out_of_stock') {
                $product->availability = 'available';
            }
        });
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function compatibilities(): HasMany
    {
        return $this->hasMany(ProductVehicleCompatibility::class);
    }

    public function partRequests(): HasMany
    {
        return $this->hasMany(PartRequest::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('availability', 'available');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        $like = '%'.$term.'%';

        return $query->where(function (Builder $q) use ($like) {
            $q->where('name', 'like', $like)
                ->orWhere('reference', 'like', $like)
                ->orWhere('short_description', 'like', $like)
                ->orWhereHas('brand', fn (Builder $b) => $b->where('name', 'like', $like))
                ->orWhereHas('category', fn (Builder $c) => $c->where('name', 'like', $like));
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isInStock(): bool
    {
        return $this->availability === 'available' && $this->stock > 0;
    }

    public function formattedPrice(): string
    {
        return number_format((float) $this->price, 2, ',', ' ').' DH';
    }

    public function primaryImageUrl(): string
    {
        if ($this->image) {
            return asset('storage/'.$this->image);
        }

        $primary = $this->images->firstWhere('is_primary', true) ?? $this->images->first();

        if ($primary) {
            return asset('storage/'.$primary->path);
        }

        return asset('images/placeholder-product.svg');
    }

    public function availabilityLabel(): string
    {
        return match ($this->availability) {
            'available' => 'En stock',
            'out_of_stock' => 'Rupture de stock',
            'on_order' => 'Sur commande',
            default => $this->availability,
        };
    }
}
