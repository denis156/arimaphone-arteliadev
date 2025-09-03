<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'product_id',
        'image_path',
        'image_type',
        'alt_text',
        'sort_order',
    ];

    /**
     * Mendapatkan atribut yang harus di-cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    /**
     * Relasi ke produk
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    /**
     * Scope untuk gambar utama
     */
    public function scopeMain($query)
    {
        return $query->where('image_type', 'main');
    }

    /**
     * Scope untuk gambar kondisi
     */
    public function scopeCondition($query)
    {
        return $query->where('image_type', 'condition');
    }

    /**
     * Scope untuk gambar box
     */
    public function scopeBox($query)
    {
        return $query->where('image_type', 'box');
    }

    /**
     * Scope untuk gambar aksesoris
     */
    public function scopeAccessories($query)
    {
        return $query->where('image_type', 'accessories');
    }

    /**
     * Scope untuk urutkan berdasarkan sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
