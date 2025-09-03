<div class="w-full">
    {{-- Breadcrumb --}}
    <section class="py-4 bg-base-100/90">
        <div class="container mx-auto px-4">
            <x-breadcrumbs :items="$breadcrumbs" separator="o-chevron-right" />
        </div>
    </section>

    {{-- Header Section --}}
    <section class="py-8 bg-base-100/90">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                @php
                    $methodLabels = [
                        'cod' => 'COD (Bayar di Tempat)',
                        'online' => 'Pembayaran Online',
                        'negotiable' => 'Harga Nego'
                    ];

                    $methodDescriptions = [
                        'cod' => 'Produk iPhone yang menerima pembayaran COD (Cash On Delivery). Bayar langsung saat produk sampai di tangan Anda.',
                        'online' => 'Produk iPhone yang menerima pembayaran online melalui transfer bank atau e-wallet. Transaksi aman dan terpercaya.',
                        'negotiable' => 'Produk iPhone dengan harga yang bisa dinegosiasi. Dapatkan harga terbaik sesuai kesepakatan.'
                    ];
                @endphp

                <h1 class="text-4xl lg:text-5xl font-bold text-base-content mb-4">
                    {{ $methodLabels[$method] }}
                </h1>
                <p class="text-secondary max-w-2xl mx-auto">
                    {{ $methodDescriptions[$method] }}
                </p>
            </div>
        </div>
    </section>

    {{-- Products Section --}}
    <section class="py-8 bg-base-100/90">
        <div class="container mx-auto px-4">
            {{-- Products List Component dengan filter payment --}}
            <livewire:landing-page.component.product.list-product :paymentFilter="$method" />
        </div>
    </section>
</div>
