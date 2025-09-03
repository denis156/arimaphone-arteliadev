<?php

declare(strict_types=1);

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->poll('10s')
            ->columns([
                TextColumn::make('Index')
                    ->label('No.')
                    ->rowIndex()
                    ->alignCenter(),

                ColumnGroup::make('Informasi Kategori', [
                    TextColumn::make('name')
                        ->label('Nama Kategori')
                        ->searchable()
                        ->sortable()
                        ->weight('medium')
                        ->copyable()
                        ->copyMessage('Nama kategori disalin!')
                        ->copyMessageDuration(1500)
                        ->tooltip('Ketuk untuk copy nama kategori')
                        ->alignCenter(),
                    TextColumn::make('series')
                        ->label('Seri')
                        ->searchable()
                        ->sortable()
                        ->badge()
                        ->color('primary')
                        ->alignCenter(),
                    TextColumn::make('slug')
                        ->label('URL Slug')
                        ->searchable()
                        ->fontFamily('mono')
                        ->size('sm')
                        ->color('gray')
                        ->copyable()
                        ->copyMessage('Slug disalin!')
                        ->copyMessageDuration(1500)
                        ->toggleable(isToggledHiddenByDefault: true),
                ]),

                ColumnGroup::make('Informasi Waktu', [
                    TextColumn::make('created_at')
                        ->label('Dibuat')
                        ->since()
                        ->sortable()
                        ->badge()
                        ->color('info')
                        ->alignCenter()
                        ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('updated_at')
                        ->label('Diperbarui')
                        ->since()
                        ->sortable()
                        ->badge()
                        ->color('warning')
                        ->alignCenter()
                        ->toggleable(isToggledHiddenByDefault: true),
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
                    ->tooltip('Ubah data kategori'),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('Buat')
                    ->icon('phosphor-plus-circle')
                    ->tooltip('Buat kategori baru'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->deferLoading()
            ->emptyStateIcon('phosphor-list-dashes')
            ->defaultSort('created_at', direction: 'desc')
            ->emptyStateHeading('Tidak Ada Data Kategori')
            ->emptyStateDescription('Tambahkan kategori baru untuk mengorganisir produk.');
    }
}
