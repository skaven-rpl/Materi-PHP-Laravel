# Menginstal Laravel 11

Langkah pertama adalah memastikan bahwa **Composer** telah terinstal di komputer. **Composer** digunakan untuk mengelola dependensi dalam proyek **Laravel**.

Kemudian, buka terminal atau command prompt, lalu jalankan perintah berikut untuk membuat proyek Laravel baru:

```bash
composer create-project laravel/laravel sikasus-laravel
```

Perintah ini akan membuat folder proyek baru bernama **sikasus-laravel** yang berisi instalasi **Laravel 11**. Tunggu hingga proses instalasi selesai.

Setelah instalasi selesai, pindah ke dalam folder proyek menggunakan perintah berikut:

```bash
cd sikasus-laravel
```

Langkah berikutnya adalah menjalankan server pengembangan bawaan **Laravel** untuk memastikan instalasi berhasil. Jalankan perintah berikut:

```bash
php artisan serve
```

Jika berhasil, Anda akan mendapatkan URL seperti `http://127.0.0.1:8000` yang dapat dibuka di browser untuk melihat tampilan awal proyek **Laravel 11**.

---

# Konfigurasi Proyek Laravel

Langkah selanjutnya adalah mengatur konfigurasi database proyek. Buka file `.env` yang terdapat di dalam folder proyek menggunakan editor teks pilihan Anda.

Cari bagian pengaturan database, kemudian sesuaikan konfigurasi menjadi seperti berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_laravel_sikasus
DB_USERNAME=root
DB_PASSWORD=
```

Penyesuaian ini memastikan proyek **Laravel** terhubung ke database **MySQL** dengan nama `db_laravel_sikasus`. Pastikan database tersebut sudah dibuat sebelumnya di **phpMyAdmin** atau **MySQL CLI**.

Setelah selesai mengatur file `.env`, simpan perubahan. Kemudian, jalankan perintah berikut untuk menghasilkan kunci aplikasi:

```bash
php artisan key:generate
```

Perintah ini akan membuat kunci enkripsi aplikasi dan menyimpannya di file `.env`. Kunci ini digunakan untuk menjaga keamanan data aplikasi.
# Membuat Model dan Migration
## Konfigurasi Koneksi Database
## Membuat Model dan Migration
## Menambahkan Kolom di Dalam Migration
## Menambahkan Mass Assignment
## Menjalankan Proses Migrate
# Menerapkan Autentikasi
## Membuat Controller `Auth`

## Membuat View untuk Menampilkan Halaman Login
## Membut Fungsi Login
# Membuat Middleware
# Membuat Blade Layout

# Menampilkan Data `Kasus` dari Database
## Membuat Controller `Kasus`
## Membuat View untuk Menampilkan `Kasus`
# Menambahkan `Kasus` ke Dalam Database
##  Menambahkan Method Create dan Store di Controller 
## Membuat View Form Create `Kasus`
# Edit dan Update `Kasus` ke Database
## Menambahkan Method Edit dan Update di Controller
## Membuat View Form Edit `Kasus`
# Delete `Kasus` dari Database
## Menambahkan Method Destroy

# Menampilkan Data `Siswa` dari Database
## Membuat Controller `Siswa`
## Membuat View untuk Menampilkan `Siswa`
# Menambahkan `Siswa` ke Dalam Database
##  Menambahkan Method Create dan Store di Controller 
## Membuat View Form Create `Siswa`
# Edit dan Update `Siswa` ke Database
## Menambahkan Method Edit dan Update di Controller
## Membuat View Form Edit `Siswa`
# Delete `Siswa` dari Database
## Menambahkan Method Destroy

# Menampilkan Data `Walikelas` dari Database
## Membuat Controller `Walikelas`
## Membuat View untuk Menampilkan `Walikelas`
# Menambahkan `Walikelas` ke Dalam Database
##  Menambahkan Method Create dan Store di Controller 
## Membuat View Form Create `Walikelas`
# Edit dan Update `Walikelas` ke Database
## Menambahkan Method Edit dan Update di Controller
## Membuat View Form Edit `Walikelas`
# Delete `Walikelas` dari Database
## Menambahkan Method Destroy

# Menampilkan Data `Kelas` dari Database
## Membuat Controller `Kelas`
## Membuat View untuk Menampilkan `Kelas`
# Menambahkan `Kelas` ke Dalam Database
##  Menambahkan Method Create dan Store di Controller 
## Membuat View Form Create `Kelas`
# Edit dan Update `Kelas` ke Database
## Menambahkan Method Edit dan Update di Controller
## Membuat View Form Edit `Kelas`
# Delete `Kelas` dari Database
## Menambahkan Method Destroy






































































































# Menampilkan Data `Siswa` dari Database

## Membuat Controller `Siswa`
## Membuat View untuk Menampilkan `Siswa`
# Menambahkan `Siswa` ke Dalam Database
# Edit dan Update `Siswa` ke Database
# Delete `Siswa` dari Database
# Menampilkan Data `Walikelas` dari Database

## Membuat Controller `Walikelas`
## Membuat View untuk Menampilkan `Walikelas`
# Menambahkan `Walikelas` ke Dalam Database
# Edit dan Update `Walikelas` ke Database
# Delete `Walikelas` dari Database
# Menampilkan Data Kelas dari Database

## Membuat Controller Kelas
## Membuat View untuk Menampilkan Kelas
# Menambahkan Kelas ke Dalam Database
# Edit dan Update Kelas ke Database
# Delete Kelas dari Database