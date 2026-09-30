# Sistem Informasi & Absensi Piket Digital
### Rayon Cisarua 5 — SMK Wikrama Bogor (TP 2026/2027)

Aplikasi web modern berbasis **Laravel 11** dan **Filament v3** yang dirancang untuk mengelola penjadwalan piket, pelaporan bukti kebersihan fisik kelas/toilet secara digital, sistem verifikasi berjenjang oleh Penanggung Jawab (PJ), serta otomatisasi denda keterlambatan (Alpa).

---

## 👨‍💻 Pengembang
* **Nama:** Mochammad Fazriel Muliawan
* **Rayon:** Cisarua 5
* **Sekolah:** SMK Wikrama Bogor
* **GitHub:** [@fazril299](https://github.com/fazril299)

---

## 🚀 Fitur Unggulan Sistem

1. **Autentikasi Terpusat & Aman**
   * Login terpadu untuk Siswa dan Pembimbing Rayon (Admin).
   * Pendaftaran akun terpusat oleh Admin demi integritas data rayon.
2. **Manajemen Penjadwalan 1 Minggu (Senin – Jumat)**
   * Pemetaan 34 siswa ke dalam jadwal harian.
   * Pembagian tugas ganda: **Piket Rayon (Ruang Kelas)** dan **Piket WC (Sanitasi)**.
3. **Penunjukan Penanggung Jawab (PJ) Otomatis**
   * Setiap hari memiliki 1 orang PJ yang bertindak sebagai koordinator lapangan.
4. **Pelaporan Digital dengan Bukti Foto**
   * Siswa wajib mengunggah foto fisik kebersihan ruangan sebelum giliran piket dinyatakan selesai.
5. **Verifikasi Berjenjang oleh PJ**
   * Laporan foto bukti siswa diperiksa dan di-ACC langsung oleh PJ hari terkait sebelum status kehadiran disahkan.
6. **Smart Automation: Vonis Alpa & Denda Otomatis**
   * Sistem secara otomatis mendeteksi pergantian hari kalender. Jika siswa tidak melaksanakan piket pada hari gilirannya, sistem langsung mengubah status menjadi **Alpa (Denda Rp 5.000)**.
7. **Admin Panel Notion Minimalist**
   * Panel admin intuitif berbasis Filament v3 dengan palet warna bersih ala Notion untuk mengelola jadwal, master siswa, dan rekapitulasi laporan piket.

---

## 🛠️ Tech Stack

* **Backend Framework:** Laravel 11 (PHP 8.3+)
* **Admin Dashboard:** Filament PHP v3
* **Frontend UI:** Blade, Livewire, Tailwind CSS
* **Database:** MySQL
* **Local Development Environment:** Laragon / PHP Built-in Server

---

## 📦 Panduan Instalasi Lokal

Jika ingin menjalankan proyek ini di komputer lokal:

```bash
# 1. Clone repositori
git clone https://github.com/fazril299/CBT.git
cd CBT

# 2. Instal dependensi PHP & JavaScript
composer install
npm install

# 3. Konfigurasi Environment (.env)
cp .env.example .env
php artisan key:generate

# 4. Migrasi Database beserta Data Seeder Awal
php artisan migrate --seed

# 5. Build Aset Frontend
npm run build

# 6. Jalankan Server Lokal
php artisan serve
```

---

## 📄 Lisensi & Hak Cipta
Dikembangkan untuk keperluan operasional pembinaan kesiswaan Rayon Cisarua 5 SMK Wikrama Bogor.
