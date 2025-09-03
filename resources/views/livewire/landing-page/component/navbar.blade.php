<header class="navbar bg-base-100/84 backdrop-blur-sm shadow-sm border-b border-primary/20 sticky top-0 z-50">
    <div class="navbar-start">
        <x-button label="Menu" icon="phosphor.list" class="btn-primary btn-sm sm:btn-md"
            @click="$wire.showMobileMenu = true" responsive />

        <x-drawer wire:model="showMobileMenu" class="bg-base-100/98 w-54 md:w-64 lg:w-84">
            {{-- App Name Header --}}
            <div class="p-4 border-b border-primary/20 mb-4">
                <h3 class="text-xl font-bold text-primary">{{ config('app.name') }}</h3>
                <p class="text-sm text-base-content/70">Toko iPhone Terpercaya</p>
            </div>

            <x-menu activate-by-route active-bg-color="text-primary font-bold">
                <x-menu-item link="{{ route('beranda') }}" title="Beranda" icon="phosphor.house" no-wire-navigate exact />
                <x-menu-item link="{{ route('produk') }}" title="Semua Produk" icon="phosphor.device-mobile" no-wire-navigate />

                {{-- Kategori Sub-menu --}}
                <x-menu-sub title="Kategori" icon="phosphor.list">
                    @forelse($this->categories as $category)
                        <x-menu-item
                            link="{{ route('product-category', $category->slug) }}"
                            title="{{ $category->name }} {{ $category->series }}"
                            no-wire-navigate
                        />
                    @empty
                        <x-menu-item title="Belum ada kategori" />
                    @endforelse
                </x-menu-sub>

                {{-- Kapasitas Sub-menu --}}
                <x-menu-sub title="Kapasitas" icon="phosphor.hard-drives">
                    @forelse($this->storages as $storage)
                        <x-menu-item
                            link="{{ route('product-storage', $storage) }}"
                            title="{{ App\Class\HelperProduct::formatStorage($storage) }}"
                            no-wire-navigate
                        />
                    @empty
                        <x-menu-item title="Belum ada data kapasitas" />
                    @endforelse
                </x-menu-sub>

                {{-- Metode Pembayaran Sub-menu --}}
                <x-menu-sub title="Metode Pembayaran" icon="phosphor.credit-card">
                    @forelse($this->paymentMethods as $method)
                        <x-menu-item
                            link="{{ route('product-payment', $method['key']) }}"
                            title="{{ $method['label'] }}"
                            no-wire-navigate
                        />
                    @empty
                        <x-menu-item title="Belum ada metode pembayaran" />
                    @endforelse
                </x-menu-sub>
            </x-menu>

            <x-slot:actions>
                <x-button icon="phosphor.x" label="Tutup" class="btn-neutral btn-sm sm:btn-md"
                    @click="$wire.showMobileMenu = false" />
            </x-slot:actions>
        </x-drawer>
    </div>
    <div class="navbar-center">
        <p class="text-primary text-md md:text-lg lg:text-xl xl:text-2xl font-semibold">
            {{ $this->getPageTitle() }}
        </p>
    </div>
    <div class="navbar-end">
        <x-button label="Cari..." icon="phosphor.magnifying-glass" class="btn-secondary btn-sm sm:btn-md btn-outline"
            responsive />
    </div>
</header>
