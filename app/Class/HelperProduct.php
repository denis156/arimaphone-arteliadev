<?php

declare(strict_types=1);

namespace App\Class;

use App\Models\Product;
use Illuminate\Support\Str;

class HelperProduct
{
    /**
     * Generate slug unik dari judul produk
     */
    public static function generateSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Format harga ke format Rupiah
     */
    public static function formatPrice($price): string
    {
        // Convert to float if it's a string
        if (is_string($price)) {
            $price = (float) $price;
        }
        
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    /**
     * Format kondisi produk ke bahasa yang lebih friendly
     */
    public static function formatCondition(string $condition): string
    {
        $conditions = [
            'Like New' => 'Seperti Baru',
            'Excellent' => 'Sangat Baik',
            'Good' => 'Baik',
            'Fair' => 'Cukup',
            'Poor' => 'Kurang Baik'
        ];

        return $conditions[$condition] ?? $condition;
    }

    /**
     * Mendapatkan warna badge untuk kondisi
     */
    public static function getConditionBadgeColor(string $condition): string
    {
        $colors = [
            'Like New' => 'success',
            'Excellent' => 'primary',
            'Good' => 'info',
            'Fair' => 'warning',
            'Poor' => 'danger'
        ];

        return $colors[$condition] ?? 'secondary';
    }

    /**
     * Format storage capacity
     */
    public static function formatStorage(string $storage): string
    {
        return str_replace('GB', ' GB', str_replace('TB', ' TB', $storage));
    }

    /**
     * Format battery health
     */
    public static function formatBatteryHealth(?int $batteryHealth): string
    {
        if (!$batteryHealth) return 'Tidak diketahui';

        if ($batteryHealth >= 90) return $batteryHealth . '% (Sangat Baik)';
        if ($batteryHealth >= 80) return $batteryHealth . '% (Baik)';
        if ($batteryHealth >= 70) return $batteryHealth . '% (Cukup)';

        return $batteryHealth . '% (Perlu Perhatian)';
    }

    /**
     * Mendapatkan warna badge untuk battery health
     */
    public static function getBatteryBadgeColor(?int $batteryHealth): string
    {
        if (!$batteryHealth) return 'secondary';

        if ($batteryHealth >= 90) return 'success';
        if ($batteryHealth >= 80) return 'primary';
        if ($batteryHealth >= 70) return 'warning';

        return 'danger';
    }

    /**
     * Format status produk
     */
    public static function formatStatus(string $status): string
    {
        $statuses = [
            'available' => 'Tersedia',
            'sold' => 'Terjual',
            'pending' => 'Pending',
            'draft' => 'Draft'
        ];

        return $statuses[$status] ?? $status;
    }

    /**
     * Mendapatkan warna badge untuk status
     */
    public static function getStatusBadgeColor(string $status): string
    {
        $colors = [
            'available' => 'success',
            'sold' => 'secondary',
            'pending' => 'warning',
            'draft' => 'info'
        ];

        return $colors[$status] ?? 'secondary';
    }

    /**
     * Increment view count
     */
    public static function incrementViews($product): void
    {
        $product->increment('views_count');
    }

    /**
     * Mengecek apakah produk tersedia
     */
    public static function isAvailable($product): bool
    {
        return $product->status === 'available' && $product->stock_quantity > 0;
    }

    /**
     * Mengecek apakah produk bisa dipesan
     */
    public static function canBeOrdered($product): bool
    {
        return self::isAvailable($product);
    }

    /**
     * Mendapatkan foto utama produk
     */
    public static function getMainImage($product): ?string
    {
        $mainImage = $product->images()->where('image_type', 'main')->first();

        if ($mainImage) {
            return asset('storage/' . $mainImage->image_path);
        }

        // Fallback ke gambar pertama
        $firstImage = $product->images()->orderBy('sort_order')->first();
        if ($firstImage) {
            return asset('storage/' . $firstImage->image_path);
        }

        // Default placeholder
        return asset('images/product-placeholder.jpg');
    }

    /**
     * Mendapatkan semua foto produk
     */
    public static function getAllImages($product): array
    {
        return $product->images()
                      ->orderBy('sort_order')
                      ->get()
                      ->map(function($image) {
                          return asset('storage/' . $image->image_path);
                      })
                      ->toArray();
    }

    /**
     * Generate judul SEO untuk produk
     */
    public static function generateSeoTitle($product): string
    {
        $categoryName = $product->category->name ?? '';
        $series = $product->category->series ?? '';
        $storage = $product->storage_capacity;
        $condition = self::formatCondition($product->condition_rating);

        $fullCategoryName = $series !== 'Standard' ? $categoryName . ' ' . $series : $categoryName;

        return "{$fullCategoryName} {$storage} {$condition} - {$product->title}";
    }

    /**
     * Generate deskripsi SEO untuk produk
     */
    public static function generateSeoDescription($product): string
    {
        $price = self::formatPrice($product->price);
        $condition = self::formatCondition($product->condition_rating);
        $storage = self::formatStorage($product->storage_capacity);

        return "Jual {$product->title} kondisi {$condition} {$storage} dengan harga {$price}. " .
               ($product->is_negotiable ? 'Harga bisa nego. ' : '') .
               "Garansi aman dan terpercaya di ArteliaeDev x ArimaPhone.";
    }

    /**
     * Mendapatkan produk serupa
     */
    public static function getSimilarProducts($product, int $limit = 6)
    {
        return Product::where('id', '!=', $product->id)
                     ->where('category_id', $product->category_id)
                     ->where('status', 'available')
                     ->limit($limit)
                     ->get();
    }

    /**
     * Mendapatkan produk terpopuler
     */
    public static function getPopularProducts(int $limit = 8)
    {
        return Product::available()
                     ->orderBy('views_count', 'desc')
                     ->limit($limit)
                     ->get();
    }

    /**
     * Mendapatkan produk terbaru
     */
    public static function getLatestProducts(int $limit = 8)
    {
        return Product::available()
                     ->orderBy('created_at', 'desc')
                     ->limit($limit)
                     ->get();
    }

    /**
     * Mendapatkan produk featured
     */
    public static function getFeaturedProducts(int $limit = 8)
    {
        return Product::available()
                     ->featured()
                     ->orderBy('created_at', 'desc')
                     ->limit($limit)
                     ->get();
    }

    /**
     * Menandai produk sebagai terjual
     */
    public static function markAsSold($product): void
    {
        $product->update([
            'status' => 'sold',
            'stock_quantity' => 0
        ]);
    }

    /**
     * Mengembalikan produk ke status tersedia
     */
    public static function markAsAvailable($product, int $quantity = 1): void
    {
        $product->update([
            'status' => 'available',
            'stock_quantity' => $quantity
        ]);
    }


    /**
     * Generate WhatsApp message untuk produk
     */
    public static function generateWhatsAppMessage($product): string
    {
        $message = "Halo, saya tertarik dengan produk:\n\n";
        $message .= "*{$product->title}*\n";
        $message .= "Harga: " . self::formatPrice($product->price) . "\n";
        $message .= "Storage: " . self::formatStorage($product->storage_capacity) . "\n";
        $message .= "Warna: {$product->color}\n";
        $message .= "Kondisi: " . self::formatCondition($product->condition_rating) . "\n\n";
        $message .= "Apakah produk ini masih tersedia?\n\n";
        $message .= "Link: " . route('product-detail', $product->slug ?? $product->id);

        return urlencode($message);
    }
}
