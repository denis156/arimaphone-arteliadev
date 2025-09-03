<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductImages\Pages;

use App\Filament\Resources\ProductImages\ProductImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductImage extends CreateRecord
{
    protected static string $resource = ProductImageResource::class;
}
