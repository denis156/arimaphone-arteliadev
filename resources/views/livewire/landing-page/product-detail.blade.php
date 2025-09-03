<div class="min-h-screen bg-base-100">
    {{-- Breadcrumb --}}
    <div class="container mx-auto px-4 py-4">
        <x-breadcrumbs :items="$breadcrumbs" separator="o-chevron-right" />
    </div>

    {{-- Main Product Section --}}
    <div class="container mx-auto px-4 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            {{-- Product Images --}}
            <div class="space-y-4">
                @if ($product->images->count() > 0)
                    <x-carousel :slides="$slides" class="h-68 md:h-88 lg:h-158 relative">
                        @scope('content', $slide)
                            <div class="w-full h-full flex items-center justify-center bg-base-200/68">
                                <img src="{{ $slide['image'] }}" alt="Gambar produk {{ $loop->index + 1 }}"
                                    class="max-w-full max-h-full object-contain" />
                            </div>
                        @endscope
                    </x-carousel>
                @else
                    <div
                        class="aspect-square rounded-2xl overflow-hidden bg-base-200/50 flex items-center justify-center">
                        <div class="text-center text-base-content/50">
                            <x-icon name="o-photo" class="w-20 h-20 mx-auto mb-4" />
                            <p class="text-lg font-medium">{{ $product->title }}</p>
                            <p class="text-sm">Gambar Produk</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="space-y-6">
                {{-- Product Header --}}
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <span
                            class="badge badge-primary badge-outline">{{ $product->category->name ?? 'iPhone' }}</span>
                        @if ($product->stock_quantity > 0)
                            <span class="badge badge-success badge-outline">Tersedia</span>
                        @else
                            <span class="badge badge-error badge-outline">Habis</span>
                        @endif
                        <span
                            class="badge badge-info badge-outline">{{ App\Class\HelperProduct::formatCondition($product->condition_rating) }}</span>
                    </div>

                    <h1 class="text-2xl lg:text-3xl font-bold text-base-content">{{ $product->title }}</h1>

                    {{-- Views and Condition --}}
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-base-content/70">{{ $product->views_count }} views</span>
                        <span class="text-sm text-base-content/70">Battery:
                            {{ App\Class\HelperProduct::formatBatteryHealth($product->battery_health) }}</span>
                    </div>
                </div>

                {{-- Price --}}
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span
                            class="text-3xl font-bold text-primary">{{ App\Class\HelperProduct::formatPrice($product->price) }}</span>
                        @if ($product->is_negotiable)
                            <span class="badge badge-warning">Nego</span>
                        @endif
                    </div>
                    <p class="text-sm text-base-content/70">
                        {{ $product->is_negotiable ? 'Harga bisa dinegosiasi' : 'Harga sudah termasuk PPN' }}</p>
                </div>

                {{-- Storage & Color Info --}}
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 rounded-lg bg-base-200">
                            <h4 class="font-medium text-sm text-base-content/70">Kapasitas</h4>
                            <p class="font-semibold">
                                {{ App\Class\HelperProduct::formatStorage($product->storage_capacity) }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-base-200">
                            <h4 class="font-medium text-sm text-base-content/70">Warna</h4>
                            <p class="font-semibold">{{ $product->color }}</p>
                        </div>
                    </div>
                </div>

                {{-- Product Specs --}}
                <div class="space-y-3">
                    <h3 class="font-semibold text-base-content">Spesifikasi Produk</h3>
                    <div class="grid grid-cols-1 gap-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-base-content/70">Tipe Box:</span>
                            <span class="font-medium">{{ $product->box_type }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base-content/70">Tipe Phone:</span>
                            <span class="font-medium">{{ $product->phone_type }}</span>
                        </div>
                        @if ($product->imei)
                            <div class="flex justify-between">
                                <span class="text-base-content/70">IMEI:</span>
                                <span class="font-medium font-mono">{{ substr($product->imei, 0, 8) }}***</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-base-content/70">Tersedia:</span>
                            <span class="font-medium">{{ $product->stock_quantity }} unit</span>
                        </div>
                    </div>
                </div>

                {{-- Quantity --}}
                {{-- <div class="space-y-3">
                    <h3 class="font-semibold text-base-content">Jumlah</h3>
                    <div class="flex items-center gap-3">
                        <x-input value="{{ $quantity }}" class="input-sm input-dash w-2" readonly >
                            <x-slot:prepend>
                                <button wire:click="decrementQuantity" class="btn btn-outline join-item btn-sm">-</button>
                            </x-slot:prepend>
                            <x-slot:append>
                                <button wire:click="incrementQuantity" class="btn btn-outline join-item btn-sm">+</button>
                            </x-slot:append>
                        </x-input>
                        <span class="text-sm text-base-content/70">Tersedia {{ $product->stock_quantity }} unit</span>
                    </div>
                </div> --}}

                {{-- Action Buttons --}}
                <div class="space-y-3">
                    <div class="space-y-2">
                        @if ($product->accept_online_payment)
                            <button class="btn btn-primary btn-block" disabled>
                                <x-icon name="o-credit-card" class="w-5 h-5" />
                                Transfer Bank (Hubungi Admin)
                            </button>
                        @endif

                        @if ($product->accept_cod)
                            <button class="btn btn-accent btn-block" disabled>
                                <x-icon name="o-truck" class="w-5 h-5" />
                                COD (Hubungi Admin)
                            </button>
                        @endif
                    </div>

                    <button wire:click="openWhatsApp" class="btn btn-success btn-block">
                        <x-icon name="c-chat-bubble-left-ellipsis" class="w-5 h-5" />
                        Tanya via WhatsApp
                    </button>
                </div>

                {{-- Product Info --}}
                <div class="space-y-2 pt-4 border-t border-primary/25">
                    <div class="flex justify-between">
                        <span class="text-base-content/70">Status:</span>
                        <span class="font-medium">{{ App\Class\HelperProduct::formatStatus($product->status) }}</span>
                    </div>
                    @if ($product->has_been_repaired)
                        <div class="flex justify-between">
                            <span class="text-base-content/70">Pernah Service:</span>
                            <span class="font-medium text-warning">Ya</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Product Details Section --}}
        <div class="mt-16 grid grid-cols-1 lg:grid-cols-2 gap-2 lg:gap-4">
            {{-- Description --}}
            <x-card class="bg-base-100/95 shadow-lg border border-primary/10">
                <x-slot:title>
                    <div class="flex items-center gap-2">
                        <x-icon name="o-document-text" class="w-5 h-5 text-primary" />
                        Deskripsi Produk
                    </div>
                </x-slot:title>

                <div class="text-base-content/80 leading-relaxed">
                    {!! str($product->description ?? 'Tidak ada deskripsi produk.')->sanitizeHtml() !!}
                </div>

                @if ($product->physical_condition)
                    <div class="mt-6">
                        <h4 class="font-semibold text-base-content mb-3">Kondisi Fisik:</h4>
                        <div class="text-base-content/80">{!! str($product->physical_condition)->sanitizeHtml() !!}</div>
                    </div>
                @endif

                @if ($product->repair_history)
                    <div class="mt-6">
                        <h4 class="font-semibold text-base-content mb-3">Riwayat Service:</h4>
                        <div class="text-base-content/80">{!! str($product->repair_history)->sanitizeHtml() !!}</div>
                    </div>
                @endif
            </x-card>

            {{-- Specifications --}}
            <x-card class="bg-base-100/95 shadow-lg border border-primary/10">
                <x-slot:title>
                    <div class="flex items-center gap-2">
                        <x-icon name="o-cog-6-tooth" class="w-5 h-5 text-primary" />
                        Spesifikasi
                    </div>
                </x-slot:title>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col space-y-1">
                        <span class="text-sm text-base-content/70 font-medium">Kategori</span>
                        <span class="text-base-content">{{ $product->category->name ?? 'iPhone' }}
                            {{ $product->category->series ?? '' }}</span>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <span class="text-sm text-base-content/70 font-medium">Storage</span>
                        <span
                            class="text-base-content">{{ App\Class\HelperProduct::formatStorage($product->storage_capacity) }}</span>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <span class="text-sm text-base-content/70 font-medium">Warna</span>
                        <span class="text-base-content">{{ $product->color }}</span>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <span class="text-sm text-base-content/70 font-medium">Kondisi</span>
                        <span
                            class="text-base-content">{{ App\Class\HelperProduct::formatCondition($product->condition_rating) }}</span>
                    </div>
                    @if ($product->battery_health)
                        <div class="flex flex-col space-y-1">
                            <span class="text-sm text-base-content/70 font-medium">Battery Health</span>
                            <span
                                class="text-base-content">{{ App\Class\HelperProduct::formatBatteryHealth($product->battery_health) }}</span>
                        </div>
                    @endif
                    <div class="flex flex-col space-y-1">
                        <span class="text-sm text-base-content/70 font-medium">Box Type</span>
                        <span class="text-base-content">{{ $product->box_type }}</span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('success'))
        <div class="toast toast-top toast-center">
            <div class="alert alert-success">
                <x-icon name="o-check-circle" class="w-5 h-5" />
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
</div>
