<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'series',
        'slug',
    ];

    /**
     * Mendapatkan semua produk dalam kategori ini
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'category_id');
    }

    /**
     * Scope untuk mencari berdasarkan nama iPhone
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Scope untuk mencari berdasarkan series
     */
    public function scopeBySeries($query, $series)
    {
        return $query->where('series', $series);
    }

    /**
     * Scope untuk mencari berdasarkan slug
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
