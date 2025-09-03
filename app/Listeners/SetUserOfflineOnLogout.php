<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;

class SetUserOfflineOnLogout
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the logout event.
     * Mengubah status user menjadi offline ketika logout dari Filament admin
     */
    public function handle(Logout $event): void
    {
        /** @var User $user */
        $user = $event->user;

        // Pastikan user ada dan merupakan instance User model
        if ($user instanceof User) {
            try {
                // Set status user menjadi offline
                $user->update(['is_online' => false]);

                Log::info("User {$user->name} (ID: {$user->id}) status diubah menjadi offline setelah logout");

            } catch (\Exception $e) {
                Log::error("Error mengubah status user saat logout: " . $e->getMessage());
            }
        }
    }
}
