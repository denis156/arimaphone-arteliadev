<section class="hero min-h-dvh"
    style="background-image: url(https://i.pinimg.com/1200x/c2/e9/7f/c2e97ff46d188544c19b6742ff525eba.jpg">
    <div class="hero-overlay bg-primary/20"></div>
    <div class="hero-content text-neutral-content text-center">
        <div class="max-w-3xl">
            {{-- Badges --}}
            <div class="flex justify-center gap-3 mb-6" data-aos="fade-down" data-aos-delay="400">
                <x-badge value="Garansi" class="badge-success badge-lg" />
                <x-badge value="Kendari" class="badge-primary badge-lg" />
                <x-badge value="24 Jam" class="badge-secondary badge-lg" />
            </div>

            <h1 class="mb-5 text-5xl lg:text-6xl font-bold" data-aos="fade-up" data-aos-delay="600">{{ config('app.name') }}</h1>

            {{-- Subtitle --}}
            <h2 class="mb-5 text-xl lg:text-2xl font-semibold text-neutral-content/90" data-aos="fade-up" data-aos-delay="800">
                Toko iPhone & Gadget Terpercaya di Kendari
            </h2>

            <p class="mb-8 text-lg text-neutral-content/80 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="1000">
                Kami menghadirkan produk berkualitas premium dengan garansi resmi Apple Indonesia.
                Melayani pengiriman ke seluruh Indonesia dengan packaging aman dan pelayanan terbaik.
            </p>

            {{-- CTA Buttons --}}
            <div class="grid grid-cols-2 gap-4 max-w-lg mx-auto" data-aos="zoom-in" data-aos-delay="1200">
                <x-button label="Lihat Produk" class="btn-primary btn-sm md:btn-lg" icon="phosphor.apple-logo" link="{{ route('produk') }}" />
                <x-button label="Hubungi WhatsApp" class="btn-success btn-soft btn-sm md:btn-lg"
                    icon="phosphor.whatsapp-logo" />
            </div>
        </div>
    </div>
</section>
