<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Class\HelperProduct;
use App\Class\HelperWhatsApp;

#[Title('Detail Produk')]
#[Layout('components.layouts.landing-page')]
class ProductDetail extends Component
{
    public $product;
    public $slug;
    public $quantity = 1;
    public $selectedStorage;
    public $selectedColor;
    public $breadcrumbs = [];
    public $mainImage;
    public $slides = [];

    public function mount($slug)
    {
        $this->slug = $slug;

        // Find product by slug or ID
        $this->product = Product::with(['category', 'images', 'seller'])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->where('status', 'available')
            ->first();

        if (!$this->product) {
            abort(404, 'Produk tidak ditemukan');
        }

        // Increment view count
        HelperProduct::incrementViews($this->product);

        // Set breadcrumbs
        $this->breadcrumbs = [
            [
                'label' => 'Produk',
                'link' => '/produk',
                'icon' => 'phosphor.device-mobile',
            ],
            [
                'label' => $this->product->title,
            ],
        ];

        // Set default selections
        $this->selectedStorage = $this->product->storage_capacity;
        $this->selectedColor = $this->product->color;

        // Prepare image data for carousel
        $this->prepareImageData();
    }

    public function incrementQuantity()
    {
        if ($this->quantity < $this->product->stock_quantity) {
            $this->quantity++;
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function selectStorage($storage)
    {
        $this->selectedStorage = $storage;
    }

    public function selectColor($color)
    {
        $this->selectedColor = $color;
    }

    public function openWhatsApp()
    {
        return HelperWhatsApp::redirectToProductWhatsApp($this->product->id);
    }

    protected function prepareImageData()
    {
        if ($this->product->images->count() > 0) {
            $this->mainImage = $this->product->images->where('image_type', 'main')->first() ?? $this->product->images->first();
            
            // Format exactly like Mary UI documentation - only 'image' key required
            $this->slides = $this->product->images->map(function($image) {
                return [
                    'image' => asset('storage/' . $image->image_path),
                ];
            })->toArray();
        }
    }


    public function render()
    {
        return view('livewire.landing-page.product-detail');
    }
}
