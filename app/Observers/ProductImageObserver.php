<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageObserver
{
    /**
     * Handle the ProductImage "created" event.
     */
    public function created(ProductImage $productImage): void
    {
        //
    }

    /**
     * Handle the ProductImage "updated" event.
     */
    public function updated(ProductImage $productImage): void
    {
        // Hapus gambar lama jika image_path diubah
        if ($productImage->isDirty('image_path') && $productImage->getOriginal('image_path')) {
            Storage::disk('public')->delete($productImage->getOriginal('image_path'));
        }
    }

    /**
     * Handle the ProductImage "deleted" event.
     */
    public function deleted(ProductImage $productImage): void
    {
        // Hapus file gambar ketika record dihapus
        if ($productImage->image_path) {
            Storage::disk('public')->delete($productImage->image_path);
        }
    }

    /**
     * Handle the ProductImage "restored" event.
     */
    public function restored(ProductImage $productImage): void
    {
        //
    }

    /**
     * Handle the ProductImage "force deleted" event.
     */
    public function forceDeleted(ProductImage $productImage): void
    {
        // Hapus file gambar ketika record force deleted
        if ($productImage->image_path) {
            Storage::disk('public')->delete($productImage->image_path);
        }
    }
}