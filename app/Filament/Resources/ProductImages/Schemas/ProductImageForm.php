<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductImages\Schemas;

use App\Models\Product;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;

class ProductImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section 1: Upload Gambar
                Section::make('Upload Gambar')
                    ->description('Upload dan konfigurasi gambar produk')
                    ->icon('phosphor-image')
                    ->collapsible()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->schema([
                                Select::make('product_id')
                                    ->label('Produk')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->relationship('product', 'title')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $imageType = $get('image_type');
                                        if ($state && $imageType) {
                                            $product = Product::find($state);
                                            if ($product) {
                                                $imageTypeLabels = [
                                                    'main' => 'tampak utama',
                                                    'condition' => 'kondisi fisik',
                                                    'box' => 'box dan packaging',
                                                    'accessories' => 'aksesoris lengkap',
                                                    'detail' => 'detail khusus',
                                                ];
                                                $altText = $product->title . ' ' . ($imageTypeLabels[$imageType] ?? $imageType);
                                                $set('alt_text', $altText);
                                            }
                                        }
                                    })
                                    ->validationMessages([
                                        'required' => 'Produk wajib dipilih.',
                                    ])
                                    ->prefixIcon('phosphor-device-mobile')
                                    ->columnSpanFull(),

                                FileUpload::make('image_path')
                                    ->label('Gambar Produk')
                                    ->required()
                                    ->image()
                                    ->disk('public')
                                    ->directory('product-images')
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '1:1',
                                        '4:3',
                                        '16:9',
                                    ])
                                    ->maxSize(5120) // 5MB
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->validationMessages([
                                        'required' => 'Gambar produk wajib diupload.',
                                        'image' => 'File harus berupa gambar.',
                                        'max' => 'Ukuran gambar maksimal 5MB.',
                                    ])
                                    ->helperText('Format: JPG, PNG, WebP. Maksimal 5MB.')
                                    ->columnSpanFull(),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull(),

                // Section 2: Informasi Gambar
                Section::make('Informasi Gambar')
                    ->description('Detail dan konfigurasi gambar')
                    ->icon('phosphor-info')
                    ->collapsible()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->schema([
                                Select::make('image_type')
                                    ->label('Jenis Gambar')
                                    ->required()
                                    ->options([
                                        'main' => 'Gambar Utama',
                                        'condition' => 'Kondisi Fisik',
                                        'box' => 'Box & Packaging',
                                        'accessories' => 'Aksesoris',
                                        'detail' => 'Detail Khusus',
                                    ])
                                    ->default('condition')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $productId = $get('product_id');
                                        if ($productId && $state) {
                                            $product = Product::find($productId);
                                            if ($product) {
                                                $imageTypeLabels = [
                                                    'main' => 'tampak utama',
                                                    'condition' => 'kondisi fisik',
                                                    'box' => 'box dan packaging',
                                                    'accessories' => 'aksesoris lengkap',
                                                    'detail' => 'detail khusus',
                                                ];
                                                $altText = $product->title . ' ' . ($imageTypeLabels[$state] ?? $state);
                                                $set('alt_text', $altText);
                                            }
                                        }
                                    })
                                    ->validationMessages([
                                        'required' => 'Jenis gambar wajib dipilih.',
                                    ])
                                    ->prefixIcon('phosphor-tag')
                                    ->native(false)
                                    ->helperText('Pilih jenis gambar sesuai dengan konten yang diupload'),

                                TextInput::make('sort_order')
                                    ->label('Urutan Tampil')
                                    ->required()
                                    ->numeric()
                                    ->maxValue(10)
                                    ->default(0)
                                    ->validationMessages([
                                        'required' => 'Urutan tampil wajib diisi.',
                                        'numeric' => 'Urutan tampil harus berupa angka.',
                                        'max' => 'Urutan tampil maksimal 10.',
                                    ])
                                    ->prefixIcon('phosphor-sort-ascending')
                                    ->placeholder('1')
                                    ->helperText('Angka kecil akan tampil lebih awal'),

                                TextInput::make('alt_text')
                                    ->label('Alt Text (SEO)')
                                    ->maxLength(255)
                                    ->validationMessages([
                                        'max' => 'Alt text tidak boleh lebih dari 255 karakter.',
                                    ])
                                    ->prefixIcon('phosphor-text-aa')
                                    ->placeholder('Akan otomatis terisi dari produk dan jenis gambar...')
                                    ->helperText('Akan otomatis terisi ketika produk dan jenis gambar dipilih')
                                    ->columnSpanFull(),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull(),

                // Section 3: Waktu
                Section::make('Waktu')
                    ->description('Informasi waktu upload dan pembaruan gambar')
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
                                    ->label('Diupload Pada')
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
