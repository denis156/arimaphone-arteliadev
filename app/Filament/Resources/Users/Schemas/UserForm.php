<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Support\Facades\Auth;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section 1: Data Profil
                Section::make('Informasi Pengguna')
                    ->description('Data identitas lengkap pengguna termasuk foto profil, email, dan kontak')
                    ->icon('phosphor-identification-card')
                    ->collapsible()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                            'lg' => 3,
                        ])
                            ->schema([
                                FileUpload::make('avatar_url')
                                    ->label('Foto Profil')
                                    ->image()
                                    ->avatar()
                                    ->directory('avatars')
                                    ->visibility('public')
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                    ->validationAttribute('foto profil')
                                    ->validationMessages([
                                        'image' => 'File harus berupa gambar.',
                                        'max' => 'Ukuran foto profil tidak boleh lebih dari 2MB.',
                                        'mimes' => 'Foto profil harus berformat JPEG, PNG, GIF, atau WebP.',
                                    ])
                                    ->columnSpan(['default' => 1, 'sm' => 1]),

                                Fieldset::make('Akun Pengguna')
                                    ->columns(['default' => 1, 'sm' => 2])
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nama Lengkap')
                                            ->required()
                                            ->maxLength(255)
                                            ->minLength(2)
                                            ->validationAttribute('nama lengkap')
                                            ->validationMessages([
                                                'required' => 'Nama lengkap wajib diisi.',
                                                'max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
                                                'min' => 'Nama lengkap minimal 2 karakter.',
                                            ])
                                            ->prefixIcon('phosphor-user')
                                            ->columnSpanFull(),

                                        TextInput::make('email')
                                            ->label('Email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true)
                                            ->validationAttribute('email')
                                            ->validationMessages([
                                                'required' => 'Email wajib diisi.',
                                                'email' => 'Format email tidak valid.',
                                                'unique' => 'Email sudah terdaftar.',
                                                'max' => 'Email tidak boleh lebih dari 255 karakter.',
                                            ])
                                            ->prefixIcon('phosphor-envelope'),

                                        TextInput::make('phone')
                                            ->label('Nomor Telepon')
                                            ->tel()
                                            ->maxLength(20)
                                            ->minLength(10)
                                            ->regex('/^(\+62|62|0)8[1-9][0-9]{6,11}$/')
                                            ->validationAttribute('nomor telepon')
                                            ->validationMessages([
                                                'max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',
                                                'min' => 'Nomor telepon minimal 10 karakter.',
                                                'regex' => 'Format nomor telepon tidak valid. Gunakan format Indonesia yang benar.',
                                            ])
                                            ->placeholder('Contoh: 08123456789')
                                            ->prefixIcon('phosphor-phone'),

                                        TextInput::make('password')
                                            ->label('Password')
                                            ->password()
                                            ->revealable()
                                            ->required(fn(string $operation): bool => $operation === 'create')
                                            ->minLength(8)
                                            ->maxLength(255)
                                            ->confirmed()
                                            ->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/')
                                            ->dehydrated(fn(?string $state): bool => filled($state))
                                            ->validationAttribute('password')
                                            ->validationMessages([
                                                'required' => 'Password wajib diisi.',
                                                'min' => 'Password minimal 8 karakter.',
                                                'max' => 'Password tidak boleh lebih dari 255 karakter.',
                                                'confirmed' => 'Konfirmasi password tidak cocok.',
                                                'regex' => 'Password harus mengandung minimal 1 huruf kecil, 1 huruf besar, 1 angka, dan 1 karakter khusus.',
                                            ])
                                            ->prefixIcon('phosphor-lock')
                                            ->columnSpanFull(),

                                        TextInput::make('password_confirmation')
                                            ->label('Konfirmasi Password')
                                            ->password()
                                            ->revealable()
                                            ->required(fn(string $operation): bool => $operation === 'create')
                                            ->minLength(8)
                                            ->maxLength(255)
                                            ->dehydrated(fn(?string $state): bool => filled($state))
                                            ->validationAttribute('konfirmasi password')
                                            ->validationMessages([
                                                'required' => 'Konfirmasi password wajib diisi.',
                                                'min' => 'Konfirmasi password minimal 8 karakter.',
                                                'max' => 'Konfirmasi password tidak boleh lebih dari 255 karakter.',
                                            ])
                                            ->prefixIcon('phosphor-lock')
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpan(['default' => 1, 'sm' => 2]),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull(),

                // Section 2: Alamat & Pengaturan Sistem
                Section::make('Alamat & Pengaturan Sistem')
                    ->description('Alamat lengkap pengguna dan pengaturan hak akses sistem')
                    ->icon('phosphor-gear')
                    ->collapsible()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->schema([
                                Textarea::make('address')
                                    ->label('Alamat Lengkap')
                                    ->placeholder('Masukkan alamat lengkap pengguna')
                                    ->rows(4)
                                    ->maxLength(500)
                                    ->validationAttribute('alamat')
                                    ->validationMessages([
                                        'max' => 'Alamat tidak boleh lebih dari 500 karakter.',
                                    ])
                                    ->columnSpanFull(),

                                DateTimePicker::make('email_verified_at')
                                    ->label('Terverifikasi Pada')
                                    ->placeholder('Belum diverifikasi')
                                    ->prefixIcon('phosphor-check-circle')
                                    ->native(false)
                                    ->seconds(false)
                                    ->hidden(fn (): bool => !Auth::user()?->is_admin)
                                    ->disabled(fn (): bool => !Auth::user()?->is_admin),

                                DateTimePicker::make('created_at')
                                    ->label('Terdaftar Sejak')
                                    ->disabled()
                                    ->prefixIcon('phosphor-pencil-line')
                                    ->native(false)
                                    ->hiddenOn('create'),

                                ToggleButtons::make('is_admin')
                                    ->label('Akun Admin?')
                                    ->boolean(trueLabel: 'Ya', falseLabel: 'Tidak')
                                    ->required()
                                    ->default(false)
                                    ->inline(),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull(),
            ]);
    }
}
