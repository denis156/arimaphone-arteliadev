<section class="py-16 bg-base-100/90">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-primary mb-4">
            Tidak Menemukan Produk yang Dicari?
        </h2>
        <p class="text-secondary mb-8 max-w-2xl mx-auto">
            Coba ubah filter pencarian atau kata kunci Anda, atau hubungi kami langsung untuk konsultasi produk terbaru.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button wire:click="resetFilters" class="btn btn-primary btn-outline btn-lg">
                <x-icon name="o-arrow-path" class="w-5 h-5" />
                Reset Filter
            </button>
            <x-button wire:click="openWhatsApp" class="btn-success btn-lg">
                <x-icon name="c-chat-bubble-left-ellipsis" class="w-5 h-5" />
                Hubungi WhatsApp
            </x-button>
        </div>
    </div>
</section>
