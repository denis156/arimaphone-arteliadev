<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'seller_id',
        'category_id',
        'title',
        'description',
        'storage_capacity',
        'color',
        'imei',
        'condition_rating',
        'battery_health',
        'box_type',
        'phone_type',
        'has_been_repaired',
        'repair_history',
        'physical_condition',
        'functional_issues',
        'price',
        'is_negotiable',
        'stock_quantity',
        'status',
        'accept_cod',
        'accept_online_payment',
        'slug',
        'views_count',
        'is_featured',
    ];

    /**
     * Mendapatkan atribut yang harus di-cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'has_been_repaired' => 'boolean',
            'is_negotiable' => 'boolean',
            'accept_cod' => 'boolean',
            'accept_online_payment' => 'boolean',
            'is_featured' => 'boolean',
            'views_count' => 'integer',
            'stock_quantity' => 'integer',
            'battery_health' => 'integer',
        ];
    }

    /**
     * Relasi ke penjual (user)
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Relasi ke kategori
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relasi ke foto-foto produk
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    /**
     * Relasi ke pesanan
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'product_id');
    }

    /**
     * Scope untuk produk tersedia
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available')->where('stock_quantity', '>', 0);
    }

    /**
     * Scope untuk produk featured
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope untuk filter berdasarkan penjual
     */
    public function scopeBySeller(Builder $query, int $sellerId): Builder
    {
        return $query->where('seller_id', $sellerId);
    }

    /**
     * Scope untuk filter berdasarkan kondisi
     */
    public function scopeByCondition(Builder $query, string $condition): Builder
    {
        return $query->where('condition_rating', $condition);
    }

    /**
     * Scope untuk filter berdasarkan range harga
     */
    public function scopeByPriceRange(Builder $query, float $minPrice, float $maxPrice): Builder
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * Scope untuk filter berdasarkan storage
     */
    public function scopeByStorage(Builder $query, string $storage): Builder
    {
        return $query->where('storage_capacity', $storage);
    }

    /**
     * Scope untuk filter berdasarkan warna
     */
    public function scopeByColor(Builder $query, string $color): Builder
    {
        return $query->where('color', $color);
    }

    /**
     * Scope untuk produk yang menerima COD
     */
    public function scopeAcceptCod(Builder $query): Builder
    {
        return $query->where('accept_cod', true);
    }

    /**
     * Scope untuk produk yang menerima pembayaran online
     */
    public function scopeAcceptOnlinePayment(Builder $query): Builder
    {
        return $query->where('accept_online_payment', true);
    }

    /**
     * Scope untuk produk yang bisa dinegosiasi
     */
    public function scopeNegotiable(Builder $query): Builder
    {
        return $query->where('is_negotiable', true);
    }

    /**
     * Scope untuk pencarian berdasarkan keyword
     */
    public function scopeSearch(Builder $query, string $keyword): Builder
    {
        return $query->where(function(Builder $q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('color', 'like', "%{$keyword}%")
              ->orWhere('storage_capacity', 'like', "%{$keyword}%");
        });
    }

    /**
     * Scope untuk urutkan berdasarkan popularitas
     */
    public function scopePopular(Builder $query): Builder
    {
        return $query->orderBy('views_count', 'desc');
    }

    /**
     * Scope untuk urutkan berdasarkan harga terendah
     */
    public function scopeCheapest(Builder $query): Builder
    {
        return $query->orderBy('price', 'asc');
    }

    /**
     * Scope untuk urutkan berdasarkan harga tertinggi
     */
    public function scopeMostExpensive(Builder $query): Builder
    {
        return $query->orderBy('price', 'desc');
    }

    /**
     * Scope untuk urutkan berdasarkan terbaru
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }
}
