<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class SetUserOnlineOnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the login event.
     * Mengubah status user menjadi online ketika login ke Filament admin
     */
    public function handle(Login $event): void
    {
        /** @var User $user */
        $user = $event->user;

        // Pastikan user ada dan merupakan instance User model
        if ($user instanceof User) {
            try {
                // Set status user menjadi online
                $user->update(['is_online' => true]);

                Log::info("User {$user->name} (ID: {$user->id}) status diubah menjadi online setelah login");

            } catch (\Exception $e) {
                Log::error("Error mengubah status user saat login: " . $e->getMessage());
            }
        }
    }
}
