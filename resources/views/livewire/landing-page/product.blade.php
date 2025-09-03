<div class="w-full">
    {{-- Header Section --}}
    <section class="py-8 bg-base-100/90">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="text-4xl lg:text-5xl font-bold text-base-content mb-4">
                    Semua Produk Kami
                </h1>
                <p class="text-secondary max-w-2xl mx-auto">
                    Koleksi iPhone dan gadget berkualitas premium dengan garansi resmi Apple Indonesia.
                    Semua produk original dan terpercaya.
                </p>
            </div>
        </div>
    </section>

    {{-- Products Grid Section --}}
    <section class="py-8 bg-base-100/90">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                {{-- Sidebar Filter --}}
                <livewire:landing-page.component.product.sidebar-filter />

                <livewire:landing-page.component.product.list-product />
            </div>
        </div>
    </section>
</div>
