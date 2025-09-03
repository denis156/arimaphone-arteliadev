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
                <h1 class="text-4xl lg:text-5xl font-bold text-primary mb-4">
                    {{ $category->name }} {{ $category->series }}
                </h1>
                <p class="text-secondary max-w-2xl mx-auto">
                    Koleksi {{ $category->name }} {{ $category->series }} berkualitas premium dengan garansi resmi Apple Indonesia.
                    Semua produk original dan terpercaya.
                </p>
            </div>
        </div>
    </section>

    {{-- Products Section --}}
    <section class="py-8 bg-base-100/90">
        <div class="container mx-auto px-4">
            {{-- Products List Component dengan filter kategori --}}
            <livewire:landing-page.component.product.list-product :categoryFilter="$category->id" />
        </div>
    </section>
</div>
