<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Produk by Metode Pembayaran')]
#[Layout('components.layouts.landing-page')]
class ProductPayment extends Component
{
    public $method;
    public $breadcrumbs = [];
    
    public function mount($method) 
    {
        $this->method = $method;
        
        // Validasi method yang valid
        $validMethods = ['cod', 'online', 'negotiable'];
        if (!in_array($method, $validMethods)) {
            abort(404, 'Metode pembayaran tidak valid');
        }
        
        // Set breadcrumbs berdasarkan method
        $methodLabels = [
            'cod' => 'COD (Bayar di Tempat)',
            'online' => 'Pembayaran Online', 
            'negotiable' => 'Harga Nego'
        ];
        
        $this->breadcrumbs = [
            [
                'label' => 'Produk',
                'link' => '/produk',
                'icon' => 'phosphor.device-mobile',
            ],
            [
                'label' => $methodLabels[$method],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.landing-page.product-payment');
    }
}