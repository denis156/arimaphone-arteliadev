<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage\Component\Product;

use App\Class\HelperWhatsApp;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ListProduct extends Component
{
    use WithPagination;

    // Filter dari parent (untuk halaman spesifik)
    public $categoryFilter = null;
    public $storageFilter = null;
    public $paymentFilter = null;

    // Filter states yang akan diterima dari parent
    public $selectedCategories = [];
    public $selectedConditions = [];
    public $selectedStorages = [];
    public $selectedColors = [];
    public $priceRange = ['min' => 0, 'max' => 50000000];
    public $acceptCod = false;
    public $acceptOnlinePayment = false;
    public $isNegotiable = false;
    public $sortBy = 'latest';
    public $searchQuery = '';

    #[On('filters-updated')]
    public function updateFilters($filters)
    {
        $this->selectedCategories = $filters['categories'] ?? [];
        $this->selectedConditions = $filters['conditions'] ?? [];
        $this->selectedStorages = $filters['storages'] ?? [];
        $this->selectedColors = $filters['colors'] ?? [];
        $this->priceRange = $filters['priceRange'] ?? ['min' => 0, 'max' => 50000000];
        $this->acceptCod = $filters['acceptCod'] ?? false;
        $this->acceptOnlinePayment = $filters['acceptOnlinePayment'] ?? false;
        $this->isNegotiable = $filters['isNegotiable'] ?? false;
        $this->sortBy = $filters['sortBy'] ?? 'latest';
        $this->searchQuery = $filters['searchQuery'] ?? '';

        $this->resetPage();
    }

    public function openWhatsApp($productId)
    {
        return HelperWhatsApp::redirectToProductWhatsApp($productId);
    }

    public function viewProduct($slug)
    {
        return redirect()->route('product-detail', $slug);
    }

    public function getProductsQuery()
    {
        $query = Product::with(['category', 'images'])
            ->available();

        // Apply specific filters (untuk halaman spesifik)
        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }
        
        if ($this->storageFilter) {
            $query->where('storage_capacity', $this->storageFilter);
        }
        
        if ($this->paymentFilter) {
            switch ($this->paymentFilter) {
                case 'cod':
                    $query->where('accept_cod', true);
                    break;
                case 'online':
                    $query->where('accept_online_payment', true);
                    break;
                case 'negotiable':
                    $query->where('is_negotiable', true);
                    break;
            }
        }

        // Apply filters (hanya jika tidak ada specific filter)
        if (!$this->categoryFilter && !empty($this->selectedCategories)) {
            $query->whereIn('category_id', $this->selectedCategories);
        }

        if (!empty($this->selectedConditions)) {
            $query->whereIn('condition_rating', $this->selectedConditions);
        }

        if (!empty($this->selectedStorages)) {
            $query->whereIn('storage_capacity', $this->selectedStorages);
        }

        if (!empty($this->selectedColors)) {
            $query->whereIn('color', $this->selectedColors);
        }

        if ($this->priceRange['min'] > 0 || $this->priceRange['max'] < 50000000) {
            $query->whereBetween('price', [$this->priceRange['min'], $this->priceRange['max']]);
        }

        if ($this->acceptCod) {
            $query->where('accept_cod', true);
        }

        if ($this->acceptOnlinePayment) {
            $query->where('accept_online_payment', true);
        }

        if ($this->isNegotiable) {
            $query->where('is_negotiable', true);
        }

        if (!empty($this->searchQuery)) {
            $query->search($this->searchQuery);
        }

        return $this->applySorting($query);
    }

    public function applySorting($query)
    {
        switch ($this->sortBy) {
            case 'price_asc':
                return $query->orderBy('price', 'asc');
            case 'price_desc':
                return $query->orderBy('price', 'desc');
            case 'popular':
                return $query->orderBy('views_count', 'desc');
            case 'oldest':
                return $query->orderBy('created_at', 'asc');
            default: // latest
                return $query->orderBy('created_at', 'desc');
        }
    }

    public function getProducts()
    {
        return $this->getProductsQuery()->paginate(12);
    }

    public function render()
    {
        return view('livewire.landing-page.component.product.list-product');
    }
}
