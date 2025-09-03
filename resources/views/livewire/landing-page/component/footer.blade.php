<footer class="footer footer-horizontal footer-center bg-base-200/90 text-base-content rounded-2xl shadow-lg p-10 border border-primary/15">
  <nav class="grid grid-flow-col">
    <x-button class="btn-sm btn-link link-primary link-hover" link="{{ route('beranda') }}">Beranda</x-button>
    <x-button class="btn-sm btn-link link-primary link-hover" link="{{ route('produk') }}">Semua Produk</x-button>
  </nav>
  <nav>
    <div class="grid grid-flow-col gap-4">
      <a href="#" class="text-secondary hover:text-primary transition-colors">
        <x-icon name="phosphor.instagram-logo" class="h-6 w-6" />
      </a>
      <a href="#" class="text-secondary hover:text-primary transition-colors">
        <x-icon name="phosphor.whatsapp-logo" class="h-6 w-6" />
      </a>
      <a href="#" class="text-secondary hover:text-primary transition-colors">
        <x-icon name="phosphor.facebook-logo" class="h-6 w-6" />
      </a>
      <a href="#" class="text-secondary hover:text-primary transition-colors">
        <x-icon name="phosphor.tiktok-logo" class="h-6 w-6" />
      </a>
    </div>
  </nav>
  <aside>
    <p class="text-sm text-secondary">
      Copyright © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </p>
  </aside>
</footer>
