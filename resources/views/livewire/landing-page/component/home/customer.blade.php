<section class="py-16 bg-base-200/80">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-primary mb-4" data-aos="fade-up" data-aos-delay="300">Kata Pelanggan Kami</h2>
            <p class="text-secondary" data-aos="fade-up" data-aos-delay="500">Testimoni dari pelanggan yang puas dengan layanan kami</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Review 1 --}}
            <x-card class="bg-base-100/95 shadow-sm text-center border border-primary/10" data-aos="fade-up" data-aos-delay="700">
                <div class="avatar mb-4">
                    <div class="w-16 rounded-full bg-primary/10">
                        <img src="https://placehold.co/64x64/6366f1/ffffff?text=A" alt="Customer" />
                    </div>
                </div>
                <div class="mb-4 flex justify-center">
                    <x-rating wire:model="rating1" class="bg-warning" />
                </div>
                <p class="text-secondary mb-4 italic">
                    "iPhone 15 Pro yang saya beli original dan garansi resmi. Pengiriman ke Makassar cepat dan
                    packaging aman. Recommended!"
                </p>
                <h4 class="font-semibold text-primary">Andi Pratama</h4>
                <p class="text-sm text-secondary">Makassar</p>
            </x-card>

            {{-- Review 2 --}}
            <x-card class="bg-base-100/95 shadow-sm text-center border border-primary/10" data-aos="fade-up" data-aos-delay="900">
                <div class="avatar mb-4">
                    <div class="w-16 rounded-full bg-secondary/10">
                        <img src="https://placehold.co/64x64/ec4899/ffffff?text=S" alt="Customer" />
                    </div>
                </div>
                <div class="mb-4 flex justify-center">
                    <x-rating wire:model="rating2" class="bg-warning" />
                </div>
                <p class="text-secondary mb-4 italic">
                    "Pelayanan ramah dan profesional. Same day delivery di Kendari benar-benar fast response. Terima
                    kasih!"
                </p>
                <h4 class="font-semibold text-primary">Sari Indah</h4>
                <p class="text-sm text-secondary">Kendari</p>
            </x-card>

            {{-- Review 3 --}}
            <x-card class="bg-base-100/95 shadow-sm text-center border border-primary/10" data-aos="fade-up" data-aos-delay="1100">
                <div class="avatar mb-4">
                    <div class="w-16 rounded-full bg-accent/10">
                        <img src="https://placehold.co/64x64/10b981/ffffff?text=R" alt="Customer" />
                    </div>
                </div>
                <div class="mb-4 flex justify-center">
                    <x-rating wire:model="rating3" class="bg-warning" />
                </div>
                <p class="text-secondary mb-4 italic">
                    "Harga kompetitif dan after sales service yang memuaskan. iPhone saya bermasalah langsung
                    ditangani dengan baik."
                </p>
                <h4 class="font-semibold text-primary">Rizky Aditya</h4>
                <p class="text-sm text-secondary">Jakarta</p>
            </x-card>
        </div>

        <div class="text-center mt-8" data-aos="fade-up" data-aos-delay="1300">
            <x-badge value="4.9/5 Rating" class="badge-primary badge-lg" />
            <p class="text-sm text-secondary mt-2">Berdasarkan 150+ ulasan pelanggan</p>
        </div>
    </div>
</section>
