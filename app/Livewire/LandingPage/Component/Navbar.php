<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage\Component;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Computed;

class Navbar extends Component
{
    public bool $showMobileMenu = false;

    #[Computed]
    public function categories()
    {
        return Category::whereHas('products', function ($query) {
                $query->where('status', 'available');
            })
            ->orderBy('name', 'desc')
            ->get();
    }

    #[Computed]
    public function storages()
    {
        return Product::select('storage_capacity')
            ->where('status', 'available')
            ->groupBy('storage_capacity')
            ->orderBy('storage_capacity')
            ->pluck('storage_capacity')
            ->toArray();
    }

    #[Computed]
    public function paymentMethods()
    {
        return [
            ['key' => 'cod', 'label' => 'COD (Bayar di Tempat)'],
            ['key' => 'online', 'label' => 'Pembayaran Online'],
            ['key' => 'negotiable', 'label' => 'Harga Nego'],
        ];
    }

    public function getPageTitle()
    {
        $routeName = request()->route()?->getName();
        $routeParameters = request()->route()?->parameters();

        switch ($routeName) {
            case 'beranda':
                return 'Beranda';
                
            case 'produk':
                return 'Semua Produk';
                
            case 'product-category':
                if (isset($routeParameters['categorySlug'])) {
                    $category = Category::where('slug', $routeParameters['categorySlug'])->first();
                    if ($category) {
                        return "Kategori {$category->name} {$category->series}";
                    }
                }
                return 'Kategori Produk';
                
            case 'product-storage':
                if (isset($routeParameters['storage'])) {
                    return "Kapasitas " . \App\Class\HelperProduct::formatStorage($routeParameters['storage']);
                }
                return 'Kapasitas';
                
            case 'product-payment':
                if (isset($routeParameters['method'])) {
                    $methodLabels = [
                        'cod' => 'COD',
                        'online' => 'Online', 
                        'negotiable' => 'Nego'
                    ];
                    return $methodLabels[$routeParameters['method']] ?? 'Pembayaran';
                }
                return 'Pembayaran';
                
            case 'product-detail':
                // Untuk mobile, cukup tampilkan "Detail" saja
                $isMobile = request()->header('User-Agent') && 
                           (strpos(request()->header('User-Agent'), 'Mobile') !== false);
                
                if ($isMobile) {
                    return 'Detail';
                }
                
                // Untuk desktop, tampilkan dengan nama produk
                if (isset($routeParameters['slug'])) {
                    $product = Product::where('slug', $routeParameters['slug'])
                                     ->orWhere('id', $routeParameters['slug'])
                                     ->first();
                    if ($product) {
                        $title = strlen($product->title) > 30 
                               ? substr($product->title, 0, 30) . '...' 
                               : $product->title;
                        return "Detail {$title}";
                    }
                }
                return 'Detail Produk';
                
            default:
                return ucfirst($routeName ?? 'Halaman');
        }
    }

    public function render()
    {
        return view('livewire.landing-page.component.navbar');
    }
}
