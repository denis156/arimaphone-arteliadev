# ArimaPhone - Sistem Penjualan iPhone Bekas

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Livewire-3-4E56A6?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire">
  <img src="https://img.shields.io/badge/TailwindCSS-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS">
</p>

<p align="center">
  <a href="https://github.com/denis156/arimaphone-arteliadev/stargazers">
    <img src="https://img.shields.io/github/stars/denis156/arimaphone-arteliadev?style=social" alt="Stars">
  </a>
  <a href="https://github.com/denis156/arimaphone-arteliadev/fork">
    <img src="https://img.shields.io/github/forks/denis156/arimaphone-arteliadev?style=social" alt="Forks">
  </a>
  <a href="https://github.com/denis156/arimaphone-arteliadev/issues">
    <img src="https://img.shields.io/github/issues/denis156/arimaphone-arteliadev" alt="Issues">
  </a>
  <a href="https://github.com/denis156/arimaphone-arteliadev/blob/main/LICENSE">
    <img src="https://img.shields.io/github/license/denis156/arimaphone-arteliadev" alt="License">
  </a>
</p>

<p align="center">
  <a href="https://github.com/denis156/arimaphone-arteliadev/releases">
    <img src="https://img.shields.io/github/v/release/denis156/arimaphone-arteliadev?include_prereleases" alt="Release">
  </a>
  <img src="https://img.shields.io/github/repo-size/denis156/arimaphone-arteliadev" alt="Repo Size">
  <img src="https://img.shields.io/github/last-commit/denis156/arimaphone-arteliadev" alt="Last Commit">
  <img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg" alt="PRs Welcome">
</p>

Platform e-commerce khusus untuk jual beli iPhone bekas yang dikembangkan melalui kolaborasi antara **AStore** dan **ArteliaDev**.

## Tentang Proyek

ArimaPhone adalah aplikasi web modern yang memungkinkan pengguna untuk menjual dan membeli iPhone bekas dengan sistem yang transparan dan terpercaya. Platform ini menyediakan fitur lengkap untuk menilai kondisi iPhone bekas secara detail.

### Fitur Utama

- **Katalog Produk Lengkap** - Sistem katalogisasi iPhone dengan spesifikasi detail
- **Penilaian Kondisi** - Rating kondisi fisik dan fungsional perangkat
- **Tracking Kesehatan Baterai** - Monitoring battery health percentage
- **Riwayat Perbaikan** - Dokumentasi history repair dan service
- **Sistem Pembayaran Fleksibel** - Mendukung COD dan pembayaran online
- **Negosiasi Harga** - Fitur tawar-menawar antara pembeli dan penjual
- **Manajemen Gambar** - Upload multiple images per produk
- **Admin Panel** - Dashboard admin menggunakan Filament

### Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Livewire 3 dengan Alpine.js
- **UI Framework**: TailwindCSS 4 + DaisyUI 5
- **Admin Panel**: Filament 4
- **UI Components**: Mary UI
- **Database**: SQLite (development) / MySQL (production)
- **Icons**: Phosphor Icons
- **Build Tool**: Vite 7

## Instalasi

### Requirements
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- SQLite atau MySQL

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone [repository-url]
   cd arimaphone-arteliadev
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

## Development

### Menjalankan Development Server
```bash
composer run dev
```
Command ini akan menjalankan:
- PHP development server (port 8000)
- Queue worker
- Log monitoring dengan Pail
- Vite development server

### Testing
```bash
composer run test
```

### Code Quality
```bash
./vendor/bin/pint  # Laravel Pint untuk code formatting
```

## Struktur Database

### Tabel Utama
- **users** - Data pengguna (buyer/seller)
- **categories** - Kategori produk iPhone
- **products** - Data produk iPhone bekas
- **product_images** - Gambar-gambar produk
- **orders** - Data pesanan/transaksi

### Fitur Produk
- IMEI tracking
- Storage capacity variants
- Color options
- Battery health percentage
- Physical condition rating
- Functional issues documentation
- Repair history tracking
- Box type (original/substitute/no box)

## Kolaborasi

Proyek ini merupakan hasil kolaborasi antara:

- **AStore** - Partner bisnis dan domain expertise
- **ArteliaDev** - Tim pengembang dan technical implementation

## 🤝 Kontribusi

Kami sangat welcome kontribusi dari komunitas! Proyek ini dibuat dengan semangat open source agar dapat dikembangkan bersama-sama.

### Cara Berkontribusi

1. **Fork** repository ini
2. **Clone** fork kamu: `git clone https://github.com/username-kamu/arimaphone-arteliadev.git`
3. Buat **feature branch**: `git checkout -b feature/AmazingFeature`
4. **Commit** perubahan: `git commit -m 'Add some AmazingFeature'`
5. **Push** ke branch: `git push origin feature/AmazingFeature`
6. Buat **Pull Request**

### Jenis Kontribusi yang Dibutuhkan

- 🐛 **Bug fixes** - Perbaiki bug yang ditemukan
- ✨ **New features** - Tambahkan fitur baru yang berguna
- 📚 **Documentation** - Perbaiki atau tambahkan dokumentasi
- 🎨 **UI/UX improvements** - Perbaikan tampilan dan pengalaman pengguna
- 🔧 **Code refactoring** - Optimasi dan clean code
- 🧪 **Testing** - Tambahkan atau perbaiki unit tests

### Contributors

<a href="https://github.com/denis156/arimaphone-arteliadev/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=denis156/arimaphone-arteliadev" />
</a>

## 💖 Support

Jika proyek ini bermanfaat, jangan lupa untuk:

- ⭐ **Star** repository ini
- 🍴 **Fork** untuk development sendiri
- 📢 **Share** ke teman-teman developer
- 💬 **Diskusi** di Issues untuk ide dan feedback

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT) - lihat file [LICENSE](LICENSE) untuk detail lengkap.

---

<p align="center">
  Dibuat dengan ❤️ oleh kolaborasi <strong>AStore</strong> & <strong>ArteliaDev</strong>
  <br>
  <sub>🚀 Mari berkontribusi untuk ekosistem jual-beli iPhone bekas yang lebih baik!</sub>
</p>
