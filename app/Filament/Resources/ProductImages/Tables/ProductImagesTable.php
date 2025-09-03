<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductImages\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ColumnGroup;

class ProductImagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->striped()
            ->columns([
                TextColumn::make('Index')
                    ->label('No.')
                    ->rowIndex()
                    ->alignCenter(),

                // Section 1: Informasi Produk
                ColumnGroup::make('Informasi Produk', [
                    TextColumn::make('product.title')
                        ->label('Nama Produk')
                        ->searchable()
                        ->weight('medium')
                        ->words(3)
                        ->tooltip(fn($record): ?string => $record->product?->title),
                    TextColumn::make('product.category.name')
                        ->label('Kategori')
                        ->badge()
                        ->color('info')
                        ->alignCenter()
                        ->formatStateUsing(fn($record): string =>
                            ($record->product?->category?->name ?? 'N/A') .
                            ($record->product?->category?->series ? ' - ' . $record->product->category->series : '')
                        ),
                ]),

                // Section 2: Detail Gambar
                ColumnGroup::make('Detail Gambar', [
                    ImageColumn::make('image_path')
                        ->label('Preview')
                        ->disk('public')
                        ->imageHeight(40)
                        ->imageWidth(40)
                        ->circular()
                        ->extraAttributes(['class' => 'rounded-lg'])
                        ->tooltip('Klik untuk melihat ukuran penuh'),
                    TextColumn::make('image_type')
                        ->label('Jenis')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'main' => 'success',
                            'condition' => 'primary',
                            'box' => 'warning',
                            'accessories' => 'info',
                            'detail' => 'secondary',
                            default => 'gray',
                        })
                        ->formatStateUsing(fn(string $state): string => match ($state) {
                            'main' => 'Utama',
                            'condition' => 'Kondisi',
                            'box' => 'Box',
                            'accessories' => 'Aksesoris',
                            'detail' => 'Detail',
                            default => ucfirst($state),
                        })
                        ->alignCenter(),
                    TextColumn::make('sort_order')
                        ->label('Urutan')
                        ->numeric()
                        ->sortable()
                        ->badge()
                        ->color('secondary')
                        ->alignCenter()
                        ->tooltip('Urutan tampil gambar'),
                ]),

                // Section 3: SEO & Info
                ColumnGroup::make('SEO & Info', [
                    TextColumn::make('alt_text')
                        ->label('Alt Text')
                        ->searchable()
                        ->words(4)
                        ->tooltip(fn($record): ?string => $record->alt_text)
                        ->placeholder('Tidak ada alt text')
                        ->color(fn($state): string => $state ? 'success' : 'warning'),
                    TextColumn::make('file_size')
                        ->label('Ukuran File')
                        ->getStateUsing(function ($record) {
                            $path = storage_path('app/public/' . $record->image_path);
                            if (file_exists($path)) {
                                $bytes = filesize($path);
                                if ($bytes === false || $bytes === 0) {
                                    return '0 B';
                                }
                                $units = ['B', 'KB', 'MB', 'GB'];
                                $factor = floor(log($bytes, 1024));
                                $factor = min($factor, count($units) - 1);
                                return sprintf("%.1f", $bytes / pow(1024, $factor)) . ' ' . $units[$factor];
                            }
                            return 'N/A';
                        })
                        ->badge()
                        ->color('info')
                        ->alignCenter()
                        ->toggleable(isToggledHiddenByDefault: true),
                ]),

                // Section 4: Waktu
                ColumnGroup::make('Waktu', [
                    TextColumn::make('created_at')
                        ->label('Diupload')
                        ->sortable()
                        ->since()
                        ->badge()
                        ->color('info')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->alignCenter(),
                    TextColumn::make('updated_at')
                        ->label('Diperbarui')
                        ->sortable()
                        ->since()
                        ->badge()
                        ->color('warning')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->alignCenter(),
                ]),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Ubah')
                    ->button()
                    ->color('success')
                    ->icon('phosphor-pencil')
                    ->tooltip('Ubah gambar produk'),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('Buat')
                    ->icon('phosphor-plus-circle')
                    ->tooltip('Buat gambar baru'),
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->icon('phosphor-trash'),
                ]),
            ])
            ->deferLoading()
            ->defaultSort('product_id', direction: 'desc')
            ->emptyStateHeading('Tidak Ada Gambar Produk')
            ->emptyStateDescription('Upload gambar produk untuk memulai.')
            ->emptyStateIcon('phosphor-image');
    }
}
