<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductImages;

use BackedEnum;
use Filament\Tables\Table;
use App\Models\ProductImage;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Resources\ProductImages\Pages\EditProductImage;
use App\Filament\Resources\ProductImages\Pages\ListProductImages;
use App\Filament\Resources\ProductImages\Pages\CreateProductImage;
use App\Filament\Resources\ProductImages\Schemas\ProductImageForm;
use App\Filament\Resources\ProductImages\Tables\ProductImagesTable;

class ProductImageResource extends Resource
{
    protected static ?string $model = ProductImage::class;

    protected static ?int $navigationSort = 1;
    protected static int $globalSearchResultsLimit = 5;

    protected static ?string $slug = 'gambar-produk';
    protected static ?string $modelLabel = 'Gambar Produk';
    protected static ?string $pluralModelLabel = 'Manajemen Gambar Produk';
    protected static ?string $navigationLabel = 'Manajemen Gambar Produk';
    // protected static string | UnitEnum | null $navigationGroup = 'Master Data';
    protected static string | BackedEnum | null $navigationIcon = 'phosphor-images';

    public static function form(Schema $schema): Schema
    {
        return ProductImageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductImagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductImages::route('/'),
            'create' => CreateProductImage::route('/create'),
            'edit' => EditProductImage::route('/{record}/edit'),
        ];
    }
}
