<section class="py-16 bg-base-100/90">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-primary mb-4" data-aos="fade-up" data-aos-delay="300">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-secondary" data-aos="fade-up" data-aos-delay="500">Jawaban untuk pertanyaan umum tentang produk dan layanan kami</p>
        </div>

        <div class="max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="700">
            <x-accordion wire:model="faqGroup" class="space-y-4">

                <x-collapse name="faq2" class="bg-base-200/80 shadow-sm border border-primary/12 rounded-lg">
                    <x-slot:heading class="text-lg font-medium text-primary">
                        Berapa lama waktu pengiriman ke luar Kendari?
                    </x-slot:heading>
                    <x-slot:content>
                        <p class="text-secondary">Untuk Kendari dan sekitarnya: same day delivery. Untuk kota besar
                            lainnya: 1-2 hari kerja. Untuk seluruh Indonesia: 2-5 hari kerja tergantung lokasi.
                            Semua menggunakan packaging khusus yang aman.</p>
                    </x-slot:content>
                </x-collapse>

                <x-collapse name="faq3" class="bg-base-200/80 shadow-sm border border-primary/12 rounded-lg">
                    <x-slot:heading class="text-lg font-medium text-primary">
                        Apakah bisa tukar tambah iPhone lama?
                    </x-slot:heading>
                    <x-slot:content>
                        <p class="text-secondary">Ya, kami menerima program tukar tambah iPhone lama. Tim kami akan
                            menilai kondisi iPhone Anda dan memberikan harga tukar yang fair. Hubungi WhatsApp kami
                            untuk konsultasi lebih lanjut.</p>
                    </x-slot:content>
                </x-collapse>

                <x-collapse name="faq4" class="bg-base-200/80 shadow-sm border border-primary/12 rounded-lg">
                    <x-slot:heading class="text-lg font-medium text-primary">
                        Metode pembayaran apa saja yang tersedia?
                    </x-slot:heading>
                    <x-slot:content>
                        <p class="text-secondary">Kami menerima transfer bank (BCA, Mandiri, BNI, BRI), e-wallet
                            (DANA, OVO, GoPay), dan cicilan 0% dengan kartu kredit. Untuk pembelian di Kendari juga
                            bisa bayar tunai saat terima barang (COD).</p>
                    </x-slot:content>
                </x-collapse>

                <x-collapse name="faq5" class="bg-base-200/80 shadow-sm border border-primary/12 rounded-lg">
                    <x-slot:heading class="text-lg font-medium text-primary">
                        Bagaimana jika iPhone bermasalah setelah pembelian?
                    </x-slot:heading>
                    <x-slot:content>
                        <p class="text-secondary">Kami memberikan layanan after-sales terbaik. Jika ada masalah
                            dalam 7 hari pertama, kami berikan penggantian unit. Untuk masalah garansi, kami bantu
                            proses klaim ke service center Apple resmi atau kami yang mengurusnya untuk Anda.</p>
                    </x-slot:content>
                </x-collapse>

                <x-collapse name="faq6" class="bg-base-200/80 shadow-sm border border-primary/12 rounded-lg">
                    <x-slot:heading class="text-lg font-medium text-primary">
                        Apakah ada diskon atau promo khusus?
                    </x-slot:heading>
                    <x-slot:content>
                        <p class="text-secondary">Ya, kami sering memberikan promo khusus untuk customer setia dan
                            pembelian dalam jumlah tertentu. Follow Instagram dan WhatsApp kami untuk mendapat info
                            promo terbaru. Ada juga promo khusus untuk warga Kendari dan mahasiswa.</p>
                    </x-slot:content>
                </x-collapse>
            </x-accordion>
        </div>
    </div>
</section>
