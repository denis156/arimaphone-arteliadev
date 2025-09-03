<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage\Component\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class SidebarFilter extends Component
{
    public $conditions = [];
    public $storages = [];
    public $colors = [];
    public $searchQuery = '';
    public $sortBy = 'latest';
    
    // Filter selections
    public $selectedCategories = [];
    public $selectedConditions = [];
    public $selectedStorages = [];
    public $selectedColors = [];
    public $priceMin = 0;
    public $priceMax = 50000000;
    public $acceptCod = false;
    public $acceptOnlinePayment = false;
    public $isNegotiable = false;

    public function mount()
    {
        $this->loadFilterOptions();
    }

    public function loadFilterOptions()
    {
        $this->loadConditions();
        $this->loadStorages();
        $this->loadColors();
    }

    // Computed property untuk categories - tidak berubah saat re-render
    #[Computed]
    public function categories()
    {
        return Category::select('categories.*', DB::raw('
            (SELECT COUNT(*) FROM products 
             WHERE products.category_id = categories.id 
             AND products.status = "available") as products_count
        '))->orderBy('name', 'desc')->get();
    }

    public function loadConditions()
    {
        $this->conditions = Product::select('condition_rating')
            ->where('status', 'available')
            ->groupBy('condition_rating')
            ->pluck('condition_rating')
            ->toArray();
    }

    public function loadStorages()
    {
        $this->storages = Product::select('storage_capacity')
            ->where('status', 'available')
            ->groupBy('storage_capacity')
            ->orderBy('storage_capacity')
            ->pluck('storage_capacity')
            ->toArray();
    }

    public function loadColors()
    {
        $this->colors = Product::select('color')
            ->where('status', 'available')
            ->groupBy('color')
            ->orderBy('color')
            ->pluck('color')
            ->toArray();
    }

    public function updatedSelectedCategories()
    {
        $this->applyFilters();
    }

    public function updatedSelectedConditions()
    {
        $this->applyFilters();
    }

    public function updatedSelectedStorages()
    {
        $this->applyFilters();
    }

    public function updatedSelectedColors()
    {
        $this->applyFilters();
    }

    public function updatedPriceMin()
    {
        $this->applyFilters();
    }

    public function updatedPriceMax()
    {
        $this->applyFilters();
    }

    public function updatedAcceptCod()
    {
        $this->applyFilters();
    }

    public function updatedAcceptOnlinePayment()
    {
        $this->applyFilters();
    }

    public function updatedIsNegotiable()
    {
        $this->applyFilters();
    }

    public function updatedSearchQuery()
    {
        $this->applyFilters();
    }

    public function updatedSortBy()
    {
        $this->applyFilters();
    }

    public function applyFilters()
    {
        $filters = [
            'categories' => $this->selectedCategories,
            'conditions' => $this->selectedConditions,
            'storages' => $this->selectedStorages,
            'colors' => $this->selectedColors,
            'priceRange' => ['min' => $this->priceMin, 'max' => $this->priceMax],
            'acceptCod' => $this->acceptCod,
            'acceptOnlinePayment' => $this->acceptOnlinePayment,
            'isNegotiable' => $this->isNegotiable,
            'searchQuery' => $this->searchQuery,
            'sortBy' => $this->sortBy,
        ];

        $this->dispatch('filters-updated', $filters);
    }

    public function resetFilters()
    {
        $this->selectedCategories = [];
        $this->selectedConditions = [];
        $this->selectedStorages = [];
        $this->selectedColors = [];
        $this->priceMin = 0;
        $this->priceMax = 50000000;
        $this->acceptCod = false;
        $this->acceptOnlinePayment = false;
        $this->isNegotiable = false;
        $this->searchQuery = '';
        $this->sortBy = 'latest';

        $this->applyFilters();
    }

    #[On('filters-updated')]
    public function handleFiltersUpdated($filters)
    {
        $this->selectedCategories = $filters['categories'] ?? [];
        $this->selectedConditions = $filters['conditions'] ?? [];
        $this->selectedStorages = $filters['storages'] ?? [];
        $this->selectedColors = $filters['colors'] ?? [];
        $this->priceMin = $filters['priceRange']['min'] ?? 0;
        $this->priceMax = $filters['priceRange']['max'] ?? 50000000;
        $this->acceptCod = $filters['acceptCod'] ?? false;
        $this->acceptOnlinePayment = $filters['acceptOnlinePayment'] ?? false;
        $this->isNegotiable = $filters['isNegotiable'] ?? false;
        $this->searchQuery = $filters['searchQuery'] ?? '';
        $this->sortBy = $filters['sortBy'] ?? 'latest';
    }

    public function render()
    {
        return view('livewire.landing-page.component.product.sidebar-filter');
    }
}
