

## 🛠️ Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

1. **Clone repository ini**:

   ```bash
   git clone https://github.com/skaven-rpl/Materi-PHP-Laravel.git
   cd Materi-PHP-Laravel/SourceCode/sikasus-laravel
   ```

2. **Install dependencies menggunakan Composer**:

   ```bash
   composer install
   ```

3. **Install dependencies frontend menggunakan NPM**:

   ```bash
   npm install && npm run dev
   ```

4. **Salin file `.env.example` menjadi `.env`**:

   ```bash
   cp .env.example .env
   ```

5. **Generate application key**:

   ```bash
   php artisan key:generate
   ```

6. **Konfigurasi database**:

   Edit file `.env` dan sesuaikan konfigurasi database Anda:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=username
   DB_PASSWORD=password
   ```

7. **Migrasi database**:

   Jalankan perintah berikut untuk membuat tabel di database:

   ```bash
   php artisan migrate
   ```

8. **Jalankan server lokal**:

   ```bash
   php artisan serve
   ```

   Akses aplikasi di [http://localhost:8000](http://localhost:8000).

## 📂 Struktur Folder

- `app/`: Berisi logika aplikasi.
- `routes/`: Berisi definisi rute aplikasi.
- `resources/views/`: Berisi file blade template untuk tampilan.
- `public/`: Berisi file yang dapat diakses publik seperti CSS, JS, dan gambar.
