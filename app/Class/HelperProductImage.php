<?php

declare(strict_types=1);

namespace App\Class;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class HelperProductImage
{
    /**
     * Upload gambar produk
     */
    public static function uploadImage(UploadedFile $file, int $productId, string $imageType = 'condition', ?string $altText = null, int $sortOrder = 0): ?ProductImage
    {
        try {
            // Generate nama file unik
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = 'products/' . $productId . '/' . $fileName;

            // Upload file
            $uploaded = Storage::disk('public')->putFileAs('products/' . $productId, $file, $fileName);

            if (!$uploaded) {
                return null;
            }

            // Simpan ke database
            return ProductImage::create([
                'product_id' => $productId,
                'image_path' => $filePath,
                'image_type' => $imageType,
                'alt_text' => $altText,
                'sort_order' => $sortOrder,
            ]);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Upload multiple gambar
     */
    public static function uploadMultipleImages(array $files, int $productId, string $imageType = 'condition'): array
    {
        $uploadedImages = [];
        $sortOrder = self::getNextSortOrder($productId);

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $image = self::uploadImage($file, $productId, $imageType, null, $sortOrder);
                if ($image) {
                    $uploadedImages[] = $image;
                    $sortOrder++;
                }
            }
        }

        return $uploadedImages;
    }

    /**
     * Hapus gambar
     */
    public static function deleteImage(ProductImage $image): bool
    {
        try {
            // Hapus file dari storage
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }

            // Hapus record dari database
            $image->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Hapus semua gambar produk
     */
    public static function deleteAllProductImages(int $productId): bool
    {
        try {
            $images = ProductImage::where('product_id', $productId)->get();

            foreach ($images as $image) {
                self::deleteImage($image);
            }

            // Hapus folder produk jika kosong
            $productFolder = 'products/' . $productId;
            if (Storage::disk('public')->exists($productFolder)) {
                $files = Storage::disk('public')->files($productFolder);
                if (empty($files)) {
                    Storage::disk('public')->deleteDirectory($productFolder);
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Mendapatkan URL gambar
     */
    public static function getImageUrl(ProductImage $image): string
    {
        return asset('storage/' . $image->image_path);
    }

    /**
     * Mendapatkan gambar utama produk
     */
    public static function getMainImage(int $productId): ?ProductImage
    {
        return ProductImage::where('product_id', $productId)
                          ->where('image_type', 'main')
                          ->orderBy('sort_order')
                          ->first();
    }

    /**
     * Mendapatkan semua gambar produk berdasarkan tipe
     */
    public static function getImagesByType(int $productId, string $imageType): array
    {
        return ProductImage::where('product_id', $productId)
                          ->where('image_type', $imageType)
                          ->orderBy('sort_order')
                          ->get()
                          ->toArray();
    }

    /**
     * Mendapatkan semua gambar produk
     */
    public static function getAllImages(int $productId): array
    {
        return ProductImage::where('product_id', $productId)
                          ->orderBy('sort_order')
                          ->get()
                          ->toArray();
    }

    /**
     * Update sort order gambar
     */
    public static function updateSortOrder(ProductImage $image, int $newSortOrder): bool
    {
        try {
            $image->update(['sort_order' => $newSortOrder]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Reorder gambar berdasarkan array ID
     */
    public static function reorderImages(array $imageIds): bool
    {
        try {
            foreach ($imageIds as $index => $imageId) {
                ProductImage::where('id', $imageId)
                           ->update(['sort_order' => $index]);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Set gambar sebagai gambar utama
     */
    public static function setAsMainImage(ProductImage $image): bool
    {
        try {
            // Reset semua gambar produk ini menjadi bukan main
            ProductImage::where('product_id', $image->product_id)
                       ->where('image_type', 'main')
                       ->update(['image_type' => 'condition']);

            // Set gambar ini sebagai main
            $image->update(['image_type' => 'main', 'sort_order' => 0]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Mendapatkan sort order selanjutnya
     */
    public static function getNextSortOrder(int $productId): int
    {
        $maxSortOrder = ProductImage::where('product_id', $productId)
                                   ->max('sort_order');

        return $maxSortOrder ? $maxSortOrder + 1 : 0;
    }

    /**
     * Format tipe gambar ke bahasa Indonesia
     */
    public static function formatImageType(string $imageType): string
    {
        $types = [
            'main' => 'Gambar Utama',
            'condition' => 'Kondisi Produk',
            'box' => 'Foto Box',
            'accessories' => 'Aksesoris'
        ];

        return $types[$imageType] ?? $imageType;
    }

    /**
     * Mendapatkan warna badge untuk tipe gambar
     */
    public static function getImageTypeBadgeColor(string $imageType): string
    {
        $colors = [
            'main' => 'primary',
            'condition' => 'success',
            'box' => 'info',
            'accessories' => 'warning'
        ];

        return $colors[$imageType] ?? 'secondary';
    }

    /**
     * Validasi ukuran dan format file
     */
    public static function validateImage(UploadedFile $file): array
    {
        $errors = [];

        // Validasi tipe file
        $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            $errors[] = 'Format file tidak didukung. Gunakan JPG, PNG, atau WebP.';
        }

        // Validasi ukuran file (max 5MB)
        $maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if ($file->getSize() > $maxSize) {
            $errors[] = 'Ukuran file maksimal 5MB.';
        }

        // Validasi dimensi gambar
        $imageInfo = getimagesize($file->getPathname());
        if ($imageInfo) {
            $width = $imageInfo[0];
            $height = $imageInfo[1];

            // Minimal resolusi 300x300
            if ($width < 300 || $height < 300) {
                $errors[] = 'Resolusi gambar minimal 300x300 pixel.';
            }

            // Maksimal resolusi 4000x4000
            if ($width > 4000 || $height > 4000) {
                $errors[] = 'Resolusi gambar maksimal 4000x4000 pixel.';
            }
        }

        return $errors;
    }

    /**
     * Compress gambar jika diperlukan
     */
    public static function compressImage(UploadedFile $file): UploadedFile
    {
        // Implementasi compress gambar bisa ditambahkan di sini
        // Untuk sementara return file asli
        return $file;
    }

    /**
     * Generate thumbnail
     */
    public static function generateThumbnail(ProductImage $image, int $width = 300, int $height = 300): ?string
    {
        try {
            $originalPath = storage_path('app/public/' . $image->image_path);
            $thumbnailPath = 'thumbnails/' . basename($image->image_path);
            $fullThumbnailPath = storage_path('app/public/' . $thumbnailPath);

            // Buat direktori thumbnail jika belum ada
            $thumbnailDir = dirname($fullThumbnailPath);
            if (!is_dir($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }

            // Generate thumbnail menggunakan GD atau Imagick
            // Implementasi thumbnail generation bisa ditambahkan di sini

            return $thumbnailPath;
        } catch (\Exception $e) {
            return null;
        }
    }
}
