<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ColumnGroup;
use Illuminate\Support\Facades\Auth;

class UsersTable
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

                ColumnGroup::make('Informasi Pengguna', [
                    ImageColumn::make('avatar_url')
                        ->label('Foto')
                        ->circular()
                        ->getStateUsing(fn($record) => $record->getFilamentAvatarUrl())
                        ->toggleable(isToggledHiddenByDefault: false)
                        ->alignCenter(),
                    TextColumn::make('name')
                        ->label('Nama Lengkap')
                        ->searchable()
                        ->sortable()
                        ->weight('medium')
                        ->copyable()
                        ->copyMessage('Nama disalin!')
                        ->copyMessageDuration(1500)
                        ->tooltip('Ketuk untuk copy nama'),
                    TextColumn::make('email')
                        ->label('Email')
                        ->searchable()
                        ->sortable()
                        ->fontFamily('mono')
                        ->size('sm')
                        ->color('info')
                        ->copyable()
                        ->copyMessage('Email disalin!')
                        ->copyMessageDuration(1500)
                        ->tooltip('Ketuk untuk copy email'),
                    TextColumn::make('phone')
                        ->label('Nomor Telepon')
                        ->searchable()
                        ->placeholder('Tidak ada')
                        ->toggleable()
                        ->fontFamily('mono')
                        ->size('sm')
                        ->copyable()
                        ->copyMessage('Nomor telepon disalin!')
                        ->copyMessageDuration(1500)
                        ->tooltip('Ketuk untuk copy nomor telepon'),
                ]),

                ColumnGroup::make('Alamat & Pengaturan Sistem', [
                    TextColumn::make('address')
                        ->label('Alamat')
                        ->searchable()
                        ->words(3)
                        ->placeholder('Tidak ada alamat')
                        ->tooltip(fn($record): ?string => $record->address)
                        ->toggleable(isToggledHiddenByDefault: true),
                    IconColumn::make('is_admin')
                        ->label('Admin')
                        ->boolean()
                        ->trueIcon('phosphor-crown-simple')
                        ->falseIcon('phosphor-user')
                        ->trueColor('warning')
                        ->falseColor('gray')
                        ->alignCenter(),
                    IconColumn::make('is_online')
                        ->label('Online')
                        ->boolean()
                        ->trueIcon('phosphor-circle-fill')
                        ->falseIcon('phosphor-circle')
                        ->trueColor('success')
                        ->falseColor('gray')
                        ->alignCenter()
                        ->tooltip(fn($record): string => $record->is_online ? 'Online' : 'Offline'),
                    TextColumn::make('created_at')
                        ->label('Terdaftar')
                        ->since()
                        ->sortable()
                        ->badge()
                        ->color('info')
                        ->alignCenter(),
                    TextColumn::make('email_verified_at')
                        ->label('Terverifikasi')
                        ->since()
                        ->sortable()
                        ->placeholder('Belum diverifikasi')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->badge()
                        ->color('success')
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
                    ->tooltip('Ubah data pengguna'),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('Buat')
                    ->icon('phosphor-plus-circle')
                    ->tooltip('Buat pengguna baru'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->deferLoading()
            ->emptyStateIcon('phosphor-users-three')
            ->defaultSort('created_at', direction: 'desc')
            ->emptyStateHeading('Tidak Ada Data Pengguna')
            ->modifyQueryUsing(fn($query) => $query->where('id', '!=', Auth::id()))
            ->emptyStateDescription('Tambahkan pengguna baru untuk memulai sistem.');
    }
}
