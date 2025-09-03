<section class="py-16 bg-base-100/90">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-primary mb-4" data-aos="fade-up" data-aos-delay="300">Partner & Sponsor</h2>
            <p class="text-secondary" data-aos="fade-up" data-aos-delay="500">Bekerjasama dengan toko toko lain di Kendari</p>
        </div>

        <div class="overflow-hidden" data-aos="fade-up" data-aos-delay="700" x-data="{ scrollPosition: 0 }" x-init="
            let itemWidth = 152; // width of each item (120px + padding + gap)
            let totalItems = 6; // number of unique items
            let totalWidth = itemWidth * totalItems;

            setInterval(() => {
                scrollPosition -= 1;
                if (scrollPosition <= -totalWidth) {
                    scrollPosition = 0;
                }
                $refs.scrollContainer.style.transform = `translateX(${scrollPosition}px)`;
            }, 15)
        ">
            <div x-ref="scrollContainer" class="flex gap-8 items-center" style="width: max-content;">
                {{-- First Set --}}
                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/000000/ffffff?text=Apple" alt="Apple"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/0066cc/ffffff?text=BCA" alt="BCA"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/118EEA/ffffff?text=DANA" alt="DANA"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/FF6B35/ffffff?text=JNE" alt="JNE"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/00B14F/ffffff?text=Grab" alt="Grab"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/00AA13/ffffff?text=Gojek" alt="Gojek"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                {{-- Duplicate Set 1 for Seamless Loop --}}
                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/000000/ffffff?text=Apple" alt="Apple"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/0066cc/ffffff?text=BCA" alt="BCA"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/118EEA/ffffff?text=DANA" alt="DANA"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/FF6B35/ffffff?text=JNE" alt="JNE"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/00B14F/ffffff?text=Grab" alt="Grab"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/00AA13/ffffff?text=Gojek" alt="Gojek"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                {{-- Duplicate Set 2 for Extra Seamless Loop --}}
                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/000000/ffffff?text=Apple" alt="Apple"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/0066cc/ffffff?text=BCA" alt="BCA"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/118EEA/ffffff?text=DANA" alt="DANA"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/FF6B35/ffffff?text=JNE" alt="JNE"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/00B14F/ffffff?text=Grab" alt="Grab"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>

                <div class="flex items-center justify-center p-4 bg-base-200/70 rounded-xl shadow-sm hover:shadow-md transition-all flex-shrink-0">
                    <img src="https://placehold.co/120x60/00AA13/ffffff?text=Gojek" alt="Gojek"
                        class="max-h-12 opacity-70 hover:opacity-100 transition-opacity" />
                </div>
            </div>
        </div>
    </div>
</section>
