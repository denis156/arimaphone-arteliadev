<?php

declare(strict_types=1);

namespace App\Filament\Resources\Products;

use UnitEnum;
use BackedEnum;
use App\Models\Product;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Products\Tables\ProductsTable;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?int $navigationSort = 1;
    protected static int $globalSearchResultsLimit = 5;

    protected static ?string $slug = 'produk';
    protected static ?string $modelLabel = 'Produk';
    protected static ?string $pluralModelLabel = 'Manajemen Produk';
    protected static ?string $navigationLabel = 'Manajemen Produk';
    // protected static string | UnitEnum | null $navigationGroup = 'Master Data';
    protected static string | BackedEnum | null $navigationIcon = 'phosphor-devices';

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
