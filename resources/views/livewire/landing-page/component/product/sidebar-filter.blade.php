<div class="lg:col-span-1">
    <x-card class="bg-base-100/95 shadow-lg border border-primary/10 sticky top-20">
        {{-- Search Box --}}
        <div class="mb-6">
            <x-input
                label="Cari Produk"
                placeholder="Cari iPhone, warna, kondisi..."
                wire:model.live.debounce.300ms="searchQuery"
                icon="o-magnifying-glass"
            />
        </div>

        {{-- Sort Options --}}
        <div class="mb-6">
            <label class="text-sm font-medium text-base-content/70 mb-2 block">Urutkan</label>
            <select class="select select-bordered w-full select-sm" wire:model.live="sortBy">
                <option value="latest">Terbaru</option>
                <option value="oldest">Terlama</option>
                <option value="price_asc">Harga Terendah</option>
                <option value="price_desc">Harga Tertinggi</option>
                <option value="popular">Terpopuler</option>
            </select>
        </div>

        {{-- Categories --}}
        <div class="mb-6">
            <h3 class="text-lg font-bold text-primary mb-4">Kategori iPhone</h3>
            <div class="space-y-2 max-h-48 overflow-y-auto">
                @forelse($this->categories as $category)
                    <x-checkbox
                        label="{{ App\Class\HelperCategory::getFullName($category) }} ({{ $category->products_count }})"
                        value="{{ $category->id }}"
                        wire:model.live="selectedCategories"
                        right
                    />
                @empty
                    <p class="text-sm text-base-content/50">Belum ada kategori</p>
                @endforelse
            </div>
        </div>

        <div class="divider"></div>

        {{-- Conditions --}}
        <div class="mb-6">
            <h4 class="font-semibold text-primary mb-3">Kondisi</h4>
            <div class="space-y-2">
                @forelse($conditions as $condition)
                    <x-checkbox
                        label="{{ App\Class\HelperProduct::formatCondition($condition) }}"
                        value="{{ $condition }}"
                        wire:model.live="selectedConditions"
                        right
                    />
                @empty
                    <p class="text-sm text-base-content/50">Belum ada data kondisi</p>
                @endforelse
            </div>
        </div>

        <div class="divider"></div>

        {{-- Storage --}}
        <div class="mb-6">
            <h4 class="font-semibold text-primary mb-3">Kapasitas</h4>
            <div class="space-y-2">
                @forelse($storages as $storage)
                    <x-checkbox
                        label="{{ App\Class\HelperProduct::formatStorage($storage) }}"
                        value="{{ $storage }}"
                        wire:model.live="selectedStorages"
                        right
                    />
                @empty
                    <p class="text-sm text-base-content/50">Belum ada data storage</p>
                @endforelse
            </div>
        </div>

        <div class="divider"></div>

        {{-- Colors --}}
        <div class="mb-6">
            <h4 class="font-semibold text-primary mb-3">Warna</h4>
            <div class="space-y-2 max-h-32 overflow-y-auto">
                @forelse($colors as $color)
                    <x-checkbox
                        label="{{ $color }}"
                        value="{{ $color }}"
                        wire:model.live="selectedColors"
                        right
                    />
                @empty
                    <p class="text-sm text-base-content/50">Belum ada data warna</p>
                @endforelse
            </div>
        </div>

        <div class="divider"></div>

        {{-- Price Range --}}
        <div class="mb-6">
            <h4 class="font-semibold text-primary mb-3">Range Harga</h4>
            <div class="space-y-3">
                <div>
                    <label class="text-xs text-base-content/70">Harga Minimum</label>
                    <x-input
                        type="number"
                        wire:model.lazy="priceMin"
                        placeholder="0"
                        class="input-sm"
                    />
                </div>
                <div>
                    <label class="text-xs text-base-content/70">Harga Maksimum</label>
                    <x-input
                        type="number"
                        wire:model.lazy="priceMax"
                        placeholder="50000000"
                        class="input-sm"
                    />
                </div>
            </div>
        </div>

        <div class="divider"></div>

        {{-- Payment Options --}}
        <div class="mb-6">
            <h4 class="font-semibold text-primary mb-3">Metode Pembayaran</h4>
            <div class="space-y-2">
                <x-checkbox
                    label="Terima COD"
                    wire:model.live="acceptCod"
                    right
                />
                <x-checkbox
                    label="Pembayaran Online"
                    wire:model.live="acceptOnlinePayment"
                    right
                />
                <x-checkbox
                    label="Harga Nego"
                    wire:model.live="isNegotiable"
                    right
                />
            </div>
        </div>

        {{-- Reset Button --}}
        <button wire:click="resetFilters" class="btn btn-outline btn-sm btn-block">
            <x-icon name="o-arrow-path" class="w-4 h-4" />
            Reset Filter
        </button>
    </x-card>
</div>
