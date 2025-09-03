<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage;

use App\Class\HelperCategory;
use App\Class\HelperProduct;
use App\Class\HelperWhatsApp;
use App\Models\Product as ProductModel;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Title('Produk')]
#[Layout('components.layouts.landing-page')]
class Product extends Component
{
    public function render()
    {
        return view('livewire.landing-page.product');
    }
}
