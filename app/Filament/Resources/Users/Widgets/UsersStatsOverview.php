<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Widgets;

use App\Class\HelperUser;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UsersStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Cache data untuk performa yang lebih baik
        $stats = Cache::remember('user_stats_overview', 300, function () {
            return [
                'total_users' => User::count(),
                'total_admins' => User::where('is_admin', true)->count(),
                'online_users' => User::where('is_online', true)->count(),
            ];
        });

        // Menggunakan HelperUser untuk mendapatkan admin dan user online
        $onlineAdmins = HelperUser::getOnlineAdmins()->count();
        $onlineUsers = HelperUser::getOnlineUsers()->count();

        return [
            Stat::make('Total Pengguna', number_format($stats['total_users']))
                ->description('Seluruh pengguna terdaftar')
                ->descriptionIcon('phosphor-users-three')
                ->color('primary'),

            Stat::make('Administrator', number_format($stats['total_admins']))
                ->description('dari ' . number_format($stats['total_users']) . ' total pengguna')
                ->descriptionIcon('phosphor-crown')
                ->color('warning'),

            Stat::make('Status Online', number_format($stats['online_users']))
                ->description($onlineAdmins . ' admin, ' . $onlineUsers . ' user biasa')
                ->descriptionIcon('phosphor-cell-signal-full')
                ->color('success'),
        ];
    }
}
