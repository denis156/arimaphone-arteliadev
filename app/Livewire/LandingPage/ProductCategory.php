<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Kategori Produk')]
#[Layout('components.layouts.landing-page')]
class ProductCategory extends Component
{
    public $categorySlug;
    public $category;
    public $breadcrumbs = [];

    public function mount($categorySlug)
    {
        $this->categorySlug = $categorySlug;

        // Find category by slug
        $this->category = Category::where('slug', $categorySlug)->firstOrFail();

        // Set breadcrumbs
        $this->breadcrumbs = [
            [
                'label' => 'Produk',
                'link' => '/produk',
                'icon' => 'phosphor.device-mobile',
            ],
            [
                'label' => $this->category->name . ' ' . $this->category->series,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.landing-page.product-category');
    }
}
