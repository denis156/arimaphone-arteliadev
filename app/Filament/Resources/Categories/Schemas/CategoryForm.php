<?php

declare(strict_types=1);

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section 1: Informasi Kategori
                Section::make('Informasi Kategori')
                    ->description('Data kategori produk termasuk nama, seri, dan URL slug')
                    ->icon('phosphor-folder-open')
                    ->collapsible()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Kategori')
                                    ->required()
                                    ->maxLength(255)
                                    ->minLength(2)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, callable $set, callable $get) {
                                        if ($operation === 'create') {
                                            $series = $get('series');
                                            $slugText = $series ? $state . ' ' . $series : $state;
                                            $set('slug', Str::slug($slugText));
                                        }
                                    })
                                    ->validationAttribute('nama kategori')
                                    ->validationMessages([
                                        'required' => 'Nama kategori wajib diisi.',
                                        'max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
                                        'min' => 'Nama kategori minimal 2 karakter.',
                                    ])
                                    ->prefixIcon('phosphor-tag')
                                    ->columnSpanFull(),

                                TextInput::make('series')
                                    ->label('Seri')
                                    ->required()
                                    ->maxLength(100)
                                    ->minLength(1)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, callable $set, callable $get) {
                                        if ($operation === 'create') {
                                            $name = $get('name');
                                            $slugText = $name ? $name . ' ' . $state : $state;
                                            $set('slug', Str::slug($slugText));
                                        }
                                    })
                                    ->validationAttribute('seri')
                                    ->validationMessages([
                                        'required' => 'Seri wajib diisi.',
                                        'max' => 'Seri tidak boleh lebih dari 100 karakter.',
                                        'min' => 'Seri minimal 1 karakter.',
                                    ])
                                    ->placeholder('Contoh: Pro, Pro Max, Basic')
                                    ->prefixIcon('phosphor-device-mobile'),

                                TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                                    ->validationAttribute('URL slug')
                                    ->validationMessages([
                                        'required' => 'URL slug wajib diisi.',
                                        'max' => 'URL slug tidak boleh lebih dari 255 karakter.',
                                        'unique' => 'URL slug sudah ada.',
                                        'regex' => 'URL slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
                                    ])
                                    ->readOnly()
                                    ->helperText('Akan otomatis terisi dari nama kategori dan seri')
                                    ->prefixIcon('phosphor-link'),
                            ])
                    ])
                    ->aside()
                    ->columnSpanFull(),

                // Section 2: Informasi Waktu
                Section::make('Informasi Waktu')
                    ->description('Waktu pembuatan dan pembaruan kategori')
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
