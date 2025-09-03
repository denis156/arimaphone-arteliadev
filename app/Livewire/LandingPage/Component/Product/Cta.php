<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage\Component\Product;

use App\Class\HelperWhatsApp;
use Livewire\Component;

class Cta extends Component
{
    public function openWhatsApp()
    {
        return HelperWhatsApp::redirectToConsultation();
    }

    public function resetFilters()
    {
        $this->dispatch('filters-updated', [
            'categories' => [],
            'conditions' => [],
            'storages' => [],
            'colors' => [],
            'priceRange' => ['min' => 0, 'max' => 50000000],
            'acceptCod' => false,
            'acceptOnlinePayment' => false,
            'isNegotiable' => false,
            'searchQuery' => '',
            'sortBy' => 'latest',
        ]);
    }

    public function render()
    {
        return view('livewire.landing-page.component.product.cta');
    }
}