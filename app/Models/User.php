<?php

declare(strict_types=1);

namespace App\Models;

use App\Class\HelperUser;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\AvatarProviders\UiAvatarsProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'is_admin',
        'avatar_url',
        'is_online',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mendapatkan atribut yang harus di-cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_online' => 'boolean',
        ];
    }

    // ========================================
    // AVATAR MANAGEMENT - FILAMENT UI
    // ========================================

    /**
     * Mendapatkan URL avatar untuk ditampilkan di interface Filament
     *
     * Prioritas penggunaan avatar:
     * 1. Avatar yang diupload user (tersimpan di storage/public)
     * 2. Custom avatar provider UiAvatarsProvider (jika tersedia)
     * 3. Avatar default dari HelperUser::generateDefaultAvatar()
     *
     * @return string|null URL avatar atau null jika gagal
     */
    public function getFilamentAvatarUrl(): ?string
    {
        // Prioritas 1: Avatar yang diupload user
        if (!empty($this->avatar_url)) {
            $avatarPath = $this->avatar_url;

            if (Storage::disk('public')->exists($avatarPath)) {
                return asset('storage/' . $avatarPath);
            }

            // Log file yang hilang untuk debugging
            Log::warning("Avatar file tidak ditemukan: {$avatarPath} untuk user {$this->id}");
        }

        // Prioritas 2: Custom avatar provider (jika tersedia)
        if (class_exists('App\Services\UiAvatarsProvider')) {
            try {
                return (new UiAvatarsProvider())->get($this);
            } catch (Exception $e) {
                Log::warning('UiAvatarsProvider error: ' . $e->getMessage());
            }
        }

        // Prioritas 3: Avatar default dari ui-avatars.com
        return HelperUser::generateDefaultAvatar($this);
    }

    /**
     * Relasi: Mendapatkan semua produk yang dimiliki user (sebagai penjual)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'seller_id');
    }

    /**
     * Relasi: Mendapatkan semua pesanan dimana user sebagai penjual
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sellerOrders()
    {
        return $this->hasMany('App\Models\Order', 'seller_id');
    }

    /**
     * Query scope: Filter hanya user dengan role admin
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }

    /**
     * Query scope: Filter hanya user yang sedang online
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }

    // ========================================
    // HELPER METHODS - DELEGATE TO HELPERUSER
    // ========================================

    /**
     * Mengecek apakah user memiliki role administrator
     * 
     * Delegasi ke HelperUser::isAdmin()
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return HelperUser::isAdmin($this);
    }

    /**
     * Mengecek apakah user sedang dalam status online
     * 
     * Delegasi ke HelperUser::isOnline()
     *
     * @return bool
     */
    public function isOnline(): bool
    {
        return HelperUser::isOnline($this);
    }

    /**
     * Mendapatkan nama yang akan ditampilkan (display name)
     * 
     * Delegasi ke HelperUser::getDisplayName()
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return HelperUser::getDisplayName($this);
    }

    /**
     * Mendapatkan nomor telepon dalam format WhatsApp (62xxxxxxxxx)
     * 
     * Delegasi ke HelperUser::formatWhatsAppNumber()
     *
     * @return string|null
     */
    public function getWhatsAppNumber(): ?string
    {
        return HelperUser::formatWhatsAppNumber($this->phone);
    }
}
