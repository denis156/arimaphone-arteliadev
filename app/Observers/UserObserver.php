<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Hapus avatar lama jika avatar diubah
        if ($user->isDirty('avatar_url') && $user->getOriginal('avatar_url')) {
            Storage::disk('public')->delete($user->getOriginal('avatar_url'));
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Hapus avatar ketika user dihapus
        if ($user->avatar_url) {
            Storage::disk('public')->delete($user->avatar_url);
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
