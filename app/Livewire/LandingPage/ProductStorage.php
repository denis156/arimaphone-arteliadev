<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage;

use App\Class\HelperProduct;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Produk by Kapasitas')]
#[Layout('components.layouts.landing-page')]
class ProductStorage extends Component
{
    public $storage;
    public $breadcrumbs = [];
    
    public function mount($storage) 
    {
        $this->storage = $storage;
        
        // Cek apakah kapasitas ada di database
        $exists = Product::where('storage_capacity', $storage)
                         ->where('status', 'available')
                         ->exists();
        
        if (!$exists) {
            abort(404, 'Kapasitas tidak ditemukan');
        }
        
        // Set breadcrumbs
        $this->breadcrumbs = [
            [
                'label' => 'Produk',
                'link' => '/produk',
                'icon' => 'phosphor.device-mobile',
            ],
            [
                'label' => 'Kapasitas ' . HelperProduct::formatStorage($storage),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.landing-page.product-storage');
    }
}