{{-- Products List --}}
<div class="lg:col-span-3">
    {{-- Products Grid --}}
    @if($this->getProducts() && $this->getProducts()->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($this->getProducts() as $product)
                <x-card class="bg-base-100/95 shadow-lg border border-primary/10"
                    wire:click="viewProduct('{{ $product->slug ?? $product->id }}')">

                    {{-- Product Image --}}
                    <div class="aspect-square bg-base-200/50 rounded-lg mb-4 overflow-hidden">
                        @if($product->images->count() > 0)
                            @php $mainImage = $product->images->where('image_type', 'main')->first() ?? $product->images->first(); @endphp
                            <img src="{{ asset('storage/' . $mainImage->image_path) }}"
                                alt="{{ $product->title }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
                        @else
                            <div class="w-full h-full flex items-center justify-center text-base-content/50">
                                <x-icon name="o-photo" class="w-16 h-16" />
                            </div>
                        @endif
                    </div>

                    {{-- Product Info --}}
                    <div class="space-y-3">
                        {{-- Title --}}
                        <h3 class="text-lg font-bold text-primary">{{ Str::words($product->title, 4) }}</h3>

                        {{-- Category & Specs --}}
                        <p class="text-sm text-secondary">
                            {{ App\Class\HelperProduct::formatStorage($product->storage_capacity) }} • {{ $product->color }}
                        </p>

                        {{-- Badges --}}
                        <div class="flex items-center gap-2 flex-wrap">
                            {{-- Condition Badge --}}
                            <x-badge
                                value="{{ App\Class\HelperProduct::formatCondition($product->condition_rating) }}"
                                class="badge-{{ App\Class\HelperProduct::getConditionBadgeColor($product->condition_rating) }} badge-sm"
                            />

                            {{-- Featured Badge --}}
                            @if($product->is_featured)
                                <x-badge value="Featured" class="badge-primary badge-sm" />
                            @endif

                            {{-- Negotiable Badge --}}
                            @if($product->is_negotiable)
                                <x-badge value="Nego" class="badge-warning badge-sm" />
                            @endif

                            {{-- COD Badge --}}
                            @if($product->accept_cod)
                                <x-badge value="COD" class="badge-success badge-sm" />
                            @endif
                        </div>

                        {{-- Price --}}
                        <div class="space-y-1">
                            <p class="text-2xl font-bold text-primary">{{ App\Class\HelperProduct::formatPrice($product->price) }}</p>
                        </div>

                        {{-- Battery Health (if available) --}}
                        @if($product->battery_health)
                            <div class="flex items-center gap-2 text-sm">
                                <x-icon name="o-battery-100" class="w-4 h-4 text-{{ App\Class\HelperProduct::getBatteryBadgeColor($product->battery_health) }}" />
                                <span class="text-base-content/70">{{ App\Class\HelperProduct::formatBatteryHealth($product->battery_health) }}</span>
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="space-y-2 pt-2">
                            <button
                                wire:click.stop="viewProduct('{{ $product->slug ?? $product->id }}')"
                                class="btn btn-primary btn-sm w-full">
                                <x-icon name="o-eye" class="w-4 h-4" />
                                Lihat Detail
                            </button>

                            <button
                                wire:click.stop="openWhatsApp({{ $product->id }})"
                                class="btn btn-success btn-outline btn-sm w-full">
                                <x-icon name="o-chat-bubble-left-ellipsis" class="w-4 h-4" />
                                Tanya via WhatsApp
                            </button>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($this->getProducts()->hasPages())
            <div class="mt-8">
                {{ $this->getProducts()->links() }}
            </div>
        @endif

    {{-- Empty State --}}
    @else
        <livewire:landing-page.component.product.cta />
    @endif

    {{-- Products Count Info --}}
    @if($this->getProducts() && $this->getProducts()->count() > 0)
        <div class="text-center mt-8 text-base-content/70">
            <p class="text-sm">
                Menampilkan {{ $this->getProducts()->count() }} dari {{ $this->getProducts()->total() }} produk
            </p>
        </div>
    @endif
</div>
