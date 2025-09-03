<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        // Hapus semua gambar produk ketika produk dihapus
        if ($product->images->count() > 0) {
            foreach ($product->images as $image) {
                if ($image->image_path) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }
        }
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        // Hapus semua gambar produk ketika produk force deleted
        if ($product->images->count() > 0) {
            foreach ($product->images as $image) {
                if ($image->image_path) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }
        }
    }
}