<?php

declare(strict_types=1);

namespace App\Class;

use App\Models\Category;
use Illuminate\Support\Str;

class HelperCategory
{
    /**
     * Mendapatkan semua kategori diurutkan berdasarkan nama dan series
     */
    public static function getAllSorted()
    {
        return Category::orderBy('name', 'desc')
                      ->orderBy('series', 'asc')
                      ->get();
    }

    /**
     * Mendapatkan kategori berdasarkan slug
     */
    public static function findBySlug(string $slug)
    {
        return Category::where('slug', $slug)->first();
    }

    /**
     * Generate slug unik dari nama dan series
     */
    public static function generateSlug(string $name, string $series): string
    {
        $baseSlug = Str::slug($name . ' ' . $series);
        $slug = $baseSlug;
        $counter = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Mendapatkan nama lengkap kategori (iPhone 15 Pro Max)
     */
    public static function getFullName($category): string
    {
        if ($category->series === 'Standard') {
            return $category->name;
        }

        return $category->name . ' ' . $category->series;
    }

    /**
     * Mendapatkan semua kategori iPhone berdasarkan nama saja
     */
    public static function getIphoneModels(): array
    {
        return Category::distinct()
                      ->orderBy('name', 'desc')
                      ->pluck('name')
                      ->toArray();
    }

    /**
     * Mendapatkan semua series dari nama iPhone tertentu
     */
    public static function getSeriesByName(string $name): array
    {
        return Category::where('name', $name)
                      ->orderBy('series', 'asc')
                      ->pluck('series', 'id')
                      ->toArray();
    }

    /**
     * Mengecek apakah kategori memiliki produk
     */
    public static function hasProducts($category): bool
    {
        return $category->products()->exists();
    }

    /**
     * Mendapatkan jumlah produk dalam kategori
     */
    public static function getProductCount($category): int
    {
        return $category->products()->count();
    }

    /**
     * Mendapatkan jumlah produk tersedia dalam kategori
     */
    public static function getAvailableProductCount($category): int
    {
        return $category->products()->where('status', 'available')->count();
    }

    /**
     * Mendapatkan kategori populer berdasarkan jumlah produk
     */
    public static function getPopularCategories(int $limit = 10)
    {
        return Category::withCount('products')
                      ->having('products_count', '>', 0)
                      ->orderBy('products_count', 'desc')
                      ->limit($limit)
                      ->get();
    }

    /**
     * Mendapatkan range harga dalam kategori
     */
    public static function getPriceRange($category): array
    {
        $products = $category->products()->where('status', 'available');

        return [
            'min' => $products->min('price') ?? 0,
            'max' => $products->max('price') ?? 0,
        ];
    }

    /**
     * Format nama kategori untuk SEO
     */
    public static function formatSeoTitle($category): string
    {
        $fullName = self::getFullName($category);
        return $fullName . ' Bekas - Jual Beli iPhone Second';
    }

    /**
     * Format deskripsi kategori untuk SEO
     */
    public static function formatSeoDescription($category): string
    {
        $fullName = self::getFullName($category);
        $productCount = self::getAvailableProductCount($category);

        return "Jual beli {$fullName} bekas berkualitas. Tersedia {$productCount} produk dengan berbagai kondisi dan harga terbaik. Garansi aman dan terpercaya.";
    }
}
