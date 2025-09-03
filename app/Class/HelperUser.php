<?php

declare(strict_types=1);

namespace App\Class;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Helper class untuk operasi-operasi yang berkaitan dengan User
 * 
 * Class ini berisi method-method static untuk:
 * - Validasi status user (admin, online)
 * - Formatting data user (nama, nomor telepon)
 * - Query user berdasarkan criteria tertentu
 * - Avatar generation dan management
 */
class HelperUser
{
    /**
     * Mengecek apakah user memiliki role administrator
     *
     * @param User|object $user Instance user yang akan dicek
     * @return bool True jika user adalah admin, false jika tidak
     */
    public static function isAdmin($user): bool
    {
        return $user->is_admin ?? false;
    }

    /**
     * Mengecek apakah user sedang dalam status online
     *
     * @param User|object $user Instance user yang akan dicek
     * @return bool True jika user online, false jika offline
     */
    public static function isOnline($user): bool
    {
        return $user->is_online ?? false;
    }

    /**
     * Mendapatkan nama yang akan ditampilkan (display name)
     * 
     * Menggunakan nama user atau fallback ke 'User' jika kosong
     *
     * @param User|object $user Instance user
     * @return string Nama yang akan ditampilkan
     */
    public static function getDisplayName($user): string
    {
        return $user->name ?: 'User';
    }

    /**
     * Mendapatkan koleksi user admin yang sedang dalam status online
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getOnlineAdmins()
    {
        return User::where('is_admin', true)
                   ->where('is_online', true)
                   ->get();
    }

    /**
     * Mendapatkan koleksi user biasa (non-admin) yang sedang online
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getOnlineUsers()
    {
        return User::where('is_admin', false)
                   ->where('is_online', true)
                   ->get();
    }

    /**
     * Memformat nomor telepon Indonesia ke format WhatsApp (62xxxxxxxxx)
     * 
     * Mengubah format 08xxxxxxxxx atau +62xxxxxxxxx menjadi 62xxxxxxxxx
     *
     * @param string|null $phone Nomor telepon yang akan diformat
     * @return string|null Nomor telepon dalam format WhatsApp atau null
     */
    public static function formatWhatsAppNumber(?string $phone): ?string
    {
        if (!$phone) return null;

        // Hapus semua karakter non-digit
        $phone = preg_replace('/\D/', '', $phone);

        // Jika diawali dengan 0, ganti dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Jika belum diawali 62, tambahkan
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Membuat avatar default menggunakan layanan ui-avatars.com dengan fallback lokal
     *
     * Prioritas fallback:
     * 1. UI-Avatars.com dengan nama user (background: hitam, text: hijau)
     * 2. File lokal defaults-avatar.png (jika tersedia)
     * 3. UI-Avatars.com tanpa pengecekan koneksi
     *
     * @param User $user Instance user untuk generate avatar
     * @return string URL avatar default yang bisa digunakan
     */
    public static function generateDefaultAvatar(User $user): string
    {
        // Cek apakah file fallback avatar ada
        $fallbackPath = 'images/defaults-avatar.png';
        if (file_exists(public_path($fallbackPath))) {
            // Coba ui-avatars.com dulu, jika gagal gunakan fallback lokal
            try {
                $name = urlencode($user->name ?? 'User');
                $background = '000000'; // Warna background hitam
                $color = '00c951';      // Warna teks hijau
                $size = 128;            // Ukuran avatar 128px

                $uiAvatarUrl = "https://ui-avatars.com/api/?name={$name}&background={$background}&color={$color}&size={$size}";

                // Test jika URL ui-avatars dapat diakses (sederhana dengan get_headers)
                $headers = @get_headers($uiAvatarUrl);
                if ($headers && strpos($headers[0], '200') !== false) {
                    return $uiAvatarUrl;
                }
            } catch (Exception $e) {
                Log::warning('ui-avatars.com tidak dapat diakses: ' . $e->getMessage());
            }

            // Fallback ke avatar lokal
            return asset($fallbackPath);
        }

        // Jika fallback lokal tidak ada, tetap coba ui-avatars.com
        $name = urlencode($user->name ?? 'User');
        $background = '000000';
        $color = '00c951';
        $size = 128;

        return "https://ui-avatars.com/api/?name={$name}&background={$background}&color={$color}&size={$size}";
    }
}
