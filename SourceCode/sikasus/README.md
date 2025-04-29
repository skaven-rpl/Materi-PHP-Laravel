## 🛠️ Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda menggunakan XAMPP:

1. **Clone repository ini**:

   ```bash
   git clone https://github.com/skaven-rpl/Materi-PHP-Laravel.git
   cd Materi-PHP-Laravel/SourceCode/sikasus
   ```

2. **Pindahkan folder proyek ke direktori XAMPP**:

   Salin folder `sikasus` ke dalam direktori `htdocs` XAMPP Anda.

3. **Buat database di phpMyAdmin**:

   - Buka [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
   - Buat database baru, misalnya `db_sekolah`.

4. **Import file database**:

   - Masuk ke database yang telah dibuat.
   - Klik tab **Import**.
   - Pilih file SQL yang ada di folder `database/` proyek ini (misalnya `db_sekolah.sql`).
   - Klik **Go** untuk mengimpor tabel ke database.

5. **Konfigurasi koneksi database**:

   Edit file `config/database.php` atau file konfigurasi lainnya (jika ada) untuk menyesuaikan dengan pengaturan database Anda:

   ```php
   // Contoh konfigurasi database
   $db_host = 'localhost';
   $db_user = 'root';
   $db_pass = '';
   $db_name = 'db_sekolah';
   ```

6. **Jalankan aplikasi**:

   - Buka browser Anda.
   - Akses aplikasi melalui URL: [http://localhost/sikasus](http://localhost/sikasus).
