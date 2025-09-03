<?php

declare(strict_types=1);

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColumnGroup;

class ProductsTable
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
                    TextColumn::make('title')
                        ->label('Judul')
                        ->searchable()
                        ->weight('medium')
                        ->words(3)
                        ->tooltip(fn($record): ?string => $record->title),
                    TextColumn::make('category.name')
                        ->label('Kategori')
                        ->sortable()
                        ->searchable()
                        ->badge()
                        ->color('info')
                        ->alignCenter()
                        ->formatStateUsing(
                            fn($record): string => ($record->category->name ?? 'iPhone') .
                                ($record->category->series ? ' - ' . $record->category->series : '')
                        ),
                    TextColumn::make('seller.name')
                        ->label('Penjual')
                        ->sortable()
                        ->searchable()
                        ->weight('medium')
                        ->copyable()
                        ->copyMessage('Nama penjual disalin!')
                        ->copyMessageDuration(1500)
                        ->tooltip('Ketuk untuk copy nama penjual'),
                ]),

                // Section 2: Spesifikasi
                ColumnGroup::make('Spesifikasi', [
                    TextColumn::make('phone_type')
                        ->label('Tipe HP')
                        ->badge()
                        ->color('success')
                        ->alignCenter()
                        ->formatStateUsing(fn(string $state): string => match ($state) {
                            'Inter' => 'International',
                            'iBox' => 'iBox (Resmi)',
                            'others' => 'Lainnya',
                            default => $state,
                        }),
                    TextColumn::make('storage_capacity')
                        ->label('Storage')
                        ->searchable()
                        ->badge()
                        ->color('primary')
                        ->alignCenter()
                        ->formatStateUsing(
                            fn(string $state): string =>
                            str_replace(['GB', 'TB'], [' GB', ' TB'], $state)
                        ),
                    TextColumn::make('color')
                        ->label('Warna')
                        ->searchable()
                        ->badge()
                        ->color('warning')
                        ->alignCenter(),
                ]),

                // Section 3: Kondisi & Kualitas
                ColumnGroup::make('Kondisi & Kualitas', [
                    TextColumn::make('condition_rating')
                        ->label('Kondisi')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'Like New' => 'success',
                            'Excellent' => 'primary',
                            'Good' => 'info',
                            'Fair' => 'warning',
                            'Poor' => 'danger',
                            default => 'gray',
                        })
                        ->alignCenter()
                        ->formatStateUsing(fn(string $state): string => match ($state) {
                            'Like New' => 'Seperti Baru',
                            'Excellent' => 'Sangat Baik',
                            'Good' => 'Baik',
                            'Fair' => 'Cukup',
                            'Poor' => 'Kurang Baik',
                            default => $state,
                        }),
                    TextColumn::make('battery_health')
                        ->label('Baterai')
                        ->numeric()
                        ->sortable()
                        ->color(fn($state): string => match (true) {
                            $state >= 90 => 'success',
                            $state >= 80 => 'primary',
                            $state >= 70 => 'warning',
                            default => 'danger',
                        })
                        ->badge()
                        ->alignCenter()
                        ->formatStateUsing(fn($state): string => $state ? $state . '%' : 'N/A'),
                    IconColumn::make('has_been_repaired')
                        ->label('Service')
                        ->boolean()
                        ->trueIcon('phosphor-wrench')
                        ->falseIcon('phosphor-check-circle')
                        ->trueColor('warning')
                        ->falseColor('success')
                        ->alignCenter()
                        ->tooltip(fn($state): string => $state ? 'Pernah diperbaiki' : 'Belum pernah diperbaiki'),
                ]),

                // Section 4: Harga & Stok
                ColumnGroup::make('Harga & Stok', [
                    TextColumn::make('price')
                        ->label('Harga')
                        ->money('IDR')
                        ->sortable()
                        ->weight('bold')
                        ->color('success')
                        ->size('md'),
                    TextColumn::make('stock_quantity')
                        ->label('Stok')
                        ->numeric()
                        ->sortable()
                        ->badge()
                        ->color(fn($state): string => match (true) {
                            $state > 5 => 'success',
                            $state > 0 => 'warning',
                            default => 'danger',
                        })
                        ->alignCenter()
                        ->formatStateUsing(fn($state): string => $state . ' unit'),
                    TextColumn::make('status')
                        ->label('Status')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'available' => 'success',
                            'sold' => 'danger',
                            'reserved' => 'warning',
                            'draft' => 'gray',
                            default => 'gray',
                        })
                        ->formatStateUsing(fn(string $state): string => match ($state) {
                            'available' => 'Tersedia',
                            'sold' => 'Terjual',
                            'reserved' => 'Dipesan',
                            'draft' => 'Draft',
                            default => ucfirst($state),
                        })
                        ->alignCenter(),
                ]),

                // Section 5: Pembayaran & Unggulan
                ColumnGroup::make('Pembayaran & Unggulan', [
                    IconColumn::make('accept_cod')
                        ->label('COD')
                        ->boolean()
                        ->trueIcon('phosphor-money')
                        ->falseIcon('phosphor-x-circle')
                        ->trueColor('success')
                        ->falseColor('gray')
                        ->alignCenter()
                        ->tooltip(fn($state): string => $state ? 'Menerima COD' : 'Tidak COD'),
                    IconColumn::make('is_negotiable')
                        ->label('Nego')
                        ->boolean()
                        ->trueIcon('phosphor-handshake')
                        ->falseIcon('phosphor-x-circle')
                        ->trueColor('success')
                        ->falseColor('gray')
                        ->alignCenter()
                        ->tooltip(fn($state): string => $state ? 'Bisa nego' : 'Harga pas'),
                    IconColumn::make('accept_online_payment')
                        ->label('Online')
                        ->boolean()
                        ->trueIcon('phosphor-credit-card')
                        ->falseIcon('phosphor-x-circle')
                        ->trueColor('primary')
                        ->falseColor('gray')
                        ->alignCenter()
                        ->tooltip(fn($state): string => $state ? 'Bayar online' : 'Tidak online'),
                    IconColumn::make('is_featured')
                        ->label('Unggulan')
                        ->boolean()
                        ->trueIcon('phosphor-star-fill')
                        ->falseIcon('phosphor-star')
                        ->trueColor('warning')
                        ->falseColor('gray')
                        ->alignCenter()
                        ->tooltip(fn($state): string => $state ? 'Produk unggulan' : 'Produk biasa'),
                ]),

                // Section 6: Info Tambahan
                ColumnGroup::make('Info Tambahan', [
                    TextColumn::make('imei')
                        ->label('IMEI')
                        ->searchable()
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->fontFamily('mono')
                        ->size('sm')
                        ->copyable()
                        ->copyMessage('IMEI disalin!')
                        ->copyMessageDuration(1500)
                        ->formatStateUsing(fn($state): string => $state ? substr($state, 0, 8) . '***' : 'N/A'),
                    TextColumn::make('box_type')
                        ->label('Box')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->badge()
                        ->color('secondary')
                        ->alignCenter()
                        ->formatStateUsing(fn(string $state): string => match ($state) {
                            'Original' => 'Box Original',
                            'OEM' => 'Box OEM',
                            'None' => 'Tanpa Box',
                            default => $state,
                        }),
                    TextColumn::make('views_count')
                        ->label('Views')
                        ->numeric()
                        ->sortable()
                        ->badge()
                        ->color('info')
                        ->icon('phosphor-eye')
                        ->alignCenter()
                        ->toggleable(isToggledHiddenByDefault: true),
                ]),

                // Section 7: Waktu
                ColumnGroup::make('Waktu', [
                    TextColumn::make('created_at')
                        ->label('Dibuat')
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
                    ->tooltip('Ubah data produk'),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('Buat')
                    ->icon('phosphor-plus-circle')
                    ->tooltip('Buat produk baru'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->deferLoading()
            ->defaultSort('created_at', direction: 'desc')
            ->emptyStateHeading('Tidak Ada Data Produk')
            ->emptyStateDescription('Tambahkan produk baru untuk memulai sistem.')
            ->emptyStateIcon('phosphor-devices')
            ->modifyQueryUsing(function ($query) {
                $user = Auth::user();

                // Jika bukan admin, tampilkan hanya produk milik user tersebut
                if (!$user->is_admin) {
                    $query->where('seller_id', $user->id);
                }
            });
    }
}
