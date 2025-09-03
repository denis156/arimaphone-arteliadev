<?php

use App\Livewire\LandingPage\Home;
use App\Livewire\LandingPage\Product;
use App\Livewire\LandingPage\ProductCategory;
use App\Livewire\LandingPage\ProductStorage;
use App\Livewire\LandingPage\ProductPayment;
use Illuminate\Support\Facades\Route;
use App\Livewire\LandingPage\ProductDetail;

Route::get('/', Home::class)->name('beranda');
Route::get('/produk', Product::class)->name('produk');
Route::get('/kategori/{categorySlug}', ProductCategory::class)->name('product-category');
Route::get('/kapasitas/{storage}', ProductStorage::class)->name('product-storage');
Route::get('/pembayaran/{method}', ProductPayment::class)->name('product-payment');
Route::get('/produk/{slug}', ProductDetail::class)->name('product-detail');
