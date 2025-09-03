<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Users\Widgets\UsersStatsOverview;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            UsersStatsOverview::class,
        ];
    }
}
