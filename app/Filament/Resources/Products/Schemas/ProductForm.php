<?php

declare(strict_types=1);

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use Filament\Support\RawJs;
use App\Class\HelperProduct;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\DateTimePicker;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section 1: Informasi Produk
                Section::make('Informasi Produk')
                    ->description('Data dasar produk termasuk judul, kategori, dan penjual')
                    ->icon('phosphor-device-mobile')
                    ->collapsible()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                            'lg' => 4,
                        ])
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Produk')
                                    ->required()
                                    ->maxLength(255)
                                    ->minLength(5)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                        if ($operation === 'create' && $state) {
                                            $set('slug', HelperProduct::generateSlug($state));
                                        }
                                    })
                                    ->validationMessages([
                                        'required' => 'Judul produk wajib diisi.',
                                        'max' => 'Judul produk tidak boleh lebih dari 255 karakter.',
                                        'min' => 'Judul produk minimal 5 karakter.',
                                    ])
                                    ->placeholder('Contoh: iPhone 15 Pro Max 256GB Space Black')
                                    ->prefixIcon('phosphor-text-aa')
                                    ->columnSpanFull(),

                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->relationship('category', 'name')
                                    ->getOptionLabelFromRecordUsing(fn(Category $record): string => "{$record->name} - {$record->series}")
                                    ->validationMessages([
                                        'required' => 'Kategori wajib dipilih.',
                                    ])
                                    ->prefixIcon('phosphor-tag')
                                    ->columnSpan(2),

                                Select::make('seller_id')
                                    ->label('Penjual')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->relationship('seller', 'name')
                                    ->default(fn() => Auth::id())
                                    ->disabled(fn() => !Auth::user()?->is_admin)
                                    ->validationMessages([
                                        'required' => 'Penjual wajib dipilih.',
                                    ])
                                    ->prefixIcon('phosphor-user')
                                    ->columnSpan(2),

                                RichEditor::make('description')
                                    ->label('Deskripsi')
                                    ->maxLength(1000)
                                    ->validationMessages([
                                        'max' => 'Deskripsi tidak boleh lebih dari 1000 karakter.',
                                    ])
                                    ->toolbarButtons([
                                        'bold', 'italic', 'bulletList', 'orderedList', 'undo', 'redo'
                                    ])
                                    ->placeholder('Deskripsikan kondisi dan detail produk secara lengkap...')
                                    ->columnSpanFull(),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull(),

                // Section 2: Spesifikasi
                Section::make('Spesifikasi')
                    ->description('Spesifikasi teknis dan detail fisik produk')
                    ->icon('phosphor-cpu')
                    ->collapsible()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 1,
                            'lg' => 2,
                        ])
                            ->schema([
                                Select::make('phone_type')
                                    ->label('Tipe HP')
                                    ->required()
                                    ->options([
                                        'Inter' => 'International',
                                        'iBox' => 'iBox (Resmi Indonesia)',
                                        'others' => 'Lainnya',
                                    ])
                                    ->validationMessages([
                                        'required' => 'Tipe HP wajib dipilih.',
                                    ])
                                    ->prefixIcon('phosphor-globe')
                                    ->native(false)
                                    ->columnSpanFull(),

                                Select::make('storage_capacity')
                                    ->label('Kapasitas Storage')
                                    ->required()
                                    ->options([
                                        '32GB' => '32 GB',
                                        '64GB' => '64 GB',
                                        '128GB' => '128 GB',
                                        '256GB' => '256 GB',
                                        '512GB' => '512 GB',
                                        '1TB' => '1 TB',
                                        '2TB' => '2 TB',
                                    ])
                                    ->validationMessages([
                                        'required' => 'Kapasitas storage wajib dipilih.',
                                    ])
                                    ->prefixIcon('phosphor-hard-drive')
                                    ->native(false),

                                TextInput::make('color')
                                    ->label('Warna')
                                    ->required()
                                    ->maxLength(50)
                                    ->validationMessages([
                                        'required' => 'Warna wajib diisi.',
                                        'max' => 'Warna tidak boleh lebih dari 50 karakter.',
                                    ])
                                    ->placeholder('Contoh: Space Black')
                                    ->prefixIcon('phosphor-palette'),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull(),

                // Section 3: Kondisi & Kualitas
                Section::make('Kondisi & Kualitas')
                    ->description('Informasi kondisi fisik dan fungsional produk')
                    ->icon('phosphor-shield-check')
                    ->collapsible()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                            'lg' => 3,
                        ])
                            ->schema([
                                Select::make('condition_rating')
                                    ->label('Rating Kondisi')
                                    ->required()
                                    ->options([
                                        'Like New' => 'Seperti Baru',
                                        'Excellent' => 'Sangat Baik',
                                        'Good' => 'Baik',
                                        'Fair' => 'Cukup',
                                        'Poor' => 'Kurang Baik',
                                    ])
                                    ->validationMessages([
                                        'required' => 'Rating kondisi wajib dipilih.',
                                    ])
                                    ->prefixIcon('phosphor-star'),

                                TextInput::make('battery_health')
                                    ->label('Kesehatan Baterai (%)')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(100)
                                    ->suffix('%')
                                    ->validationMessages([
                                        'numeric' => 'Kesehatan baterai harus berupa angka.',
                                        'min' => 'Kesehatan baterai minimal 1%.',
                                        'max' => 'Kesehatan baterai maksimal 100%.',
                                    ])
                                    ->placeholder('85')
                                    ->prefixIcon('phosphor-battery-high'),

                                ToggleButtons::make('has_been_repaired')
                                    ->label('Pernah Diperbaiki?')
                                    ->required()
                                    ->boolean('Ya', 'Tidak')
                                    ->default(false)
                                    ->inline()
                                    ->validationMessages([
                                        'required' => 'Status perbaikan wajib dipilih.',
                                    ]),

                                RichEditor::make('repair_history')
                                    ->label('Riwayat Perbaikan')
                                    ->maxLength(500)
                                    ->visible(fn(callable $get): bool => $get('has_been_repaired'))
                                    ->validationMessages([
                                        'max' => 'Riwayat perbaikan tidak boleh lebih dari 500 karakter.',
                                    ])
                                    ->toolbarButtons([
                                        'bold', 'italic', 'bulletList', 'orderedList', 'undo', 'redo'
                                    ])
                                    ->placeholder('Jelaskan bagian apa saja yang pernah diperbaiki...')
                                    ->columnSpanFull(),

                                RichEditor::make('physical_condition')
                                    ->label('Kondisi Fisik')
                                    ->maxLength(500)
                                    ->validationMessages([
                                        'max' => 'Kondisi fisik tidak boleh lebih dari 500 karakter.',
                                    ])
                                    ->toolbarButtons([
                                        'bold', 'italic', 'bulletList', 'orderedList', 'undo', 'redo'
                                    ])
                                    ->placeholder('Deskripsikan kondisi fisik seperti goresan, lecet, atau kerusakan...')
                                    ->columnSpanFull(),

                                RichEditor::make('functional_issues')
                                    ->label('Masalah Fungsional')
                                    ->maxLength(500)
                                    ->validationMessages([
                                        'max' => 'Masalah fungsional tidak boleh lebih dari 500 karakter.',
                                    ])
                                    ->toolbarButtons([
                                        'bold', 'italic', 'bulletList', 'orderedList', 'undo', 'redo'
                                    ])
                                    ->placeholder('Jelaskan masalah pada fungsi seperti speaker, kamera, dll (jika ada)...')
                                    ->columnSpanFull(),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull(),

                // Section 4: Harga & Stok
                Section::make('Harga & Stok')
                    ->description('Informasi harga, stok, dan status produk')
                    ->icon('phosphor-money')
                    ->collapsible()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->schema([
                                TextInput::make('price')
                                    ->label('Harga')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->mask(RawJs::make(<<<'JS'
                                        function(value) {
                                            return value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                        }
                                    JS))
                                    ->stripCharacters('.')
                                    ->placeholder('5.000.000')
                                    ->validationMessages([
                                        'required' => 'Harga wajib diisi.',
                                        'numeric' => 'Harga harus berupa angka.',
                                        'min' => 'Harga minimal Rp 1.',
                                    ])
                                    ->prefixIcon('phosphor-money')
                                    ->columnSpanFull(),

                                TextInput::make('stock_quantity')
                                    ->label('Stok')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(1)
                                    ->validationMessages([
                                        'required' => 'Stok wajib diisi.',
                                        'numeric' => 'Stok harus berupa angka.',
                                        'min' => 'Stok minimal 0.',
                                    ])
                                    ->prefixIcon('phosphor-package'),

                                Select::make('status')
                                    ->label('Status Produk')
                                    ->required()
                                    ->options([
                                        'draft' => 'Draft',
                                        'available' => 'Tersedia',
                                        'reserved' => 'Dipesan',
                                        'sold' => 'Terjual',
                                    ])
                                    ->default('available')
                                    ->validationMessages([
                                        'required' => 'Status produk wajib dipilih.',
                                    ])
                                    ->prefixIcon('phosphor-check-circle'),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull(),

                // Section 5: Pembayaran & Unggulan
                Section::make('Pembayaran & Unggulan')
                    ->description('Opsi pembayaran dan unggulan produk')
                    ->icon('phosphor-credit-card')
                    ->collapsible()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->schema([
                                ToggleButtons::make('accept_cod')
                                    ->label('COD?')
                                    ->required()
                                    ->boolean('Ya', 'Tidak')
                                    ->default(true)
                                    ->inline()
                                    ->validationMessages([
                                        'required' => 'Status COD wajib dipilih.',
                                    ]),

                                ToggleButtons::make('is_negotiable')
                                    ->label('Bisa Nego?')
                                    ->required()
                                    ->boolean('Ya', 'Tidak')
                                    ->default(true)
                                    ->inline()
                                    ->validationMessages([
                                        'required' => 'Status nego wajib dipilih.',
                                    ]),

                                ToggleButtons::make('accept_online_payment')
                                    ->label('Bayar Online?')
                                    ->required()
                                    ->boolean('Ya', 'Tidak')
                                    ->default(true)
                                    ->inline()
                                    ->validationMessages([
                                        'required' => 'Status pembayaran online wajib dipilih.',
                                    ]),

                                ToggleButtons::make('is_featured')
                                    ->label('Produk Unggulan?')
                                    ->required()
                                    ->boolean('Ya', 'Tidak')
                                    ->default(false)
                                    ->inline()
                                    ->hidden(fn(): bool => !Auth::user()?->is_admin)
                                    ->disabled(fn(): bool => !Auth::user()?->is_admin)
                                    ->validationMessages([
                                        'required' => 'Status unggulan wajib dipilih.',
                                    ]),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull(),

                // Section 6: Info Tambahan
                Section::make('Info Tambahan')
                    ->description('Informasi tambahan seperti IMEI, box type, dan URL slug')
                    ->icon('phosphor-info')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->schema([
                                TextInput::make('imei')
                                    ->label('IMEI')
                                    ->maxLength(20)
                                    ->regex('/^\d{15}$/')
                                    ->validationMessages([
                                        'max' => 'IMEI tidak boleh lebih dari 20 karakter.',
                                        'regex' => 'IMEI harus 15 digit angka.',
                                    ])
                                    ->placeholder('15 digit angka')
                                    ->prefixIcon('phosphor-identification-badge'),

                                Select::make('box_type')
                                    ->label('Jenis Box')
                                    ->required()
                                    ->options([
                                        'Original' => 'Box Original',
                                        'OEM' => 'Box OEM',
                                        'None' => 'Tanpa Box',
                                    ])
                                    ->validationMessages([
                                        'required' => 'Jenis box wajib dipilih.',
                                    ])
                                    ->prefixIcon('phosphor-package'),

                                TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->maxLength(255)
                                    ->readOnly()
                                    ->helperText('Akan otomatis terisi dari judul produk')
                                    ->prefixIcon('phosphor-link'),

                                TextInput::make('views_count')
                                    ->label('Jumlah Dilihat')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->prefixIcon('phosphor-eye'),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull(),

                // Section 7: Waktu
                Section::make('Waktu')
                    ->description('Informasi waktu pembuatan dan pembaruan produk')
                    ->icon('phosphor-clock')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->schema([
                                DateTimePicker::make('created_at')
                                    ->label('Dibuat Pada')
                                    ->disabled()
                                    ->prefixIcon('phosphor-calendar-plus')
                                    ->native(false)
                                    ->hiddenOn('create'),

                                DateTimePicker::make('updated_at')
                                    ->label('Diperbarui Pada')
                                    ->disabled()
                                    ->prefixIcon('phosphor-calendar-check')
                                    ->native(false)
                                    ->hiddenOn('create'),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull()
                    ->hiddenOn('create'),
            ]);
    }
}
