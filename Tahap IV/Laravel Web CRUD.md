# Perubahan dan Fitur baru di Laravel

## Pengenalan Laravel 11

**Laravel 11** melanjutkan perbaikan yang dilakukan di **Laravel 10.x** dengan memperkenalkan struktur aplikasi yang disederhanakan, _per-second rate limiting,_ _health_ _routing_, _graceful_ _encryption_ _key_ _rotation_, _queue_ _testing_ _improvements_, [_Resend_](https://resend.com/) _mail_ _transport_, _Prompt_ _validator_ _integration_, _new_ _Artisan_ _commands_, dan masih banyak lagi.

Selain itu, **Laravel** juga merilis sebuah _library_ yang bernama **Laravel Reverb**. _Library_ ini merupakan _server_ _WebSocket_ yang memberikan kemampuan _real_-_time_ yang baik pada aplikasi yang kita buat.

## PHP 8.2

Untuk **PHP** dengan versi `8.1` kini sudah tidak akan bisa digunakan lagi di **Laravel** **11**. Untuk  yang akan memulai membuat _project_ baru di **Laravel** **11**, maka harus menggunakan **PHP** versi `8.2` atau `8.3`.

Berikut ini informasi terkait dukungan **PHP** `8.1` yang dihentikan di Laravel 11.

> [[11.x] Drop PHP 8.1 support](https://github.com/laravel/framework/pull/45526)

## Kerangka Aplikasi yang lebih Sederhana

**Laravel 11** akan memperkenalkan struktur _folder_ yang lebih sederhana. Ketika membuat _project_ baru di **Laravel 11**, _folder_ `app` hanya akan berisi tiga _folder_ utama, yaitu `Http`, `Models`, dan `Providers`, seperti yang terlihat pada ilustrasi berikut.


```
app
├── Http
│   └── Controllers
│       └── Controller.php
├── Models
│   └── User.php
└── Providers
    └── AppServiceProvider.php
```

Struktur aplikasi yang baru ini dirancang untuk memberikan pengalaman yang lebih efisien dan _modern_, sambil tetap mempertahankan banyak konsep yang sudah dikenal oleh pengembang **Laravel** sebelumnya.

> **INFORMASI**: Bagi pengembang yang sebelumnya menggunakan **Laravel** versi `10` atau lebih rendah dan berencana untuk _upgrade_ ke **Laravel** `11`, tidak perlu mengadopsi struktur _project_ baru ini. Struktur _project_ **Laravel** versi lama masih tetap dapat digunakan.

## Tampilan Welcome Screen Baru

Di **Laravel 11**, tampilan _welcome screen_ telah diperbarui, dan kini tampilannya akan terlihat seperti ilustrasi berikut.

>![Foto_hasil](IMG-9.png)


## File Bootstrap Aplikasi

File `bootstrap/app.php` telah diperbarui untuk menjadi kode pertama yang dijalankan dalam aplikasi. Dari _file_ ini, kita kini dapat mengonfigurasi _route_ aplikasi, _middleware_, _service providers_, _exception handling_, dan berbagai pengaturan lainnya. _File_ ini menyatukan berbagai pengaturan aplikasi yang sebelumnya tersebar di berbagai bagian struktur _file_ aplikasi **Laravel**.

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

## Perubahan Route

Pada **Laravel 11**, untuk _default routes_ hanya ada dua _file_, yaitu `console.php` dan `web.php`. Lalu, jika ingin membuat _route_ untuk _REST API_, caranya sangat mudah, cukup jalankan perintah berikut ini.

```bash
php artisan install:api
```

Dengan cara tersebut, _file_ `api.php` akan dibuat di dalam _folder_ `routes`. Begitu pula dengan _route_ _broadcasting_, untuk membuatnya, cukup jalankan perintah berikut ini.

```bash
php artisan install:broadcasting
```

## Perintah Artisan Baru

Perintah Artisan baru telah ditambahkan untuk memudahkan pembuatan _class_, _enum_, _interface_, dan _traits_ sebagai berikut:

```bash
php artisan make:class
php artisan make:enum
php artisan make:interface
php artisan make:trait
```

## Model Cast Improvements

Dulu, untuk mendefinisikan `cast`, kita harus menggunakan sebuah properti, contohnya seperti berikut ini.

```php
protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
];
```

Sekarang, di **Laravel 11**, untuk mendefinisikan `cast`, kita menggunakan sebuah `method`, sehingga hasilnya akan terlihat seperti berikut ini.

```php
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```


## Default Database

Secara _default_, aplikasi **Laravel** yang baru akan menggunakan **SQLite** sebagai database untuk penyimpanan data, serta menggunakan _driver_ database yang sama untuk _session_, _cache_, dan _queue_.

## Laravel Reverb

**[Laravel Reverb](https://reverb.laravel.com/)** menawarkan komunikasi _WebSocket_ _real-time_ yang cepat dan skalabel langsung ke aplikasi **Laravel**, serta menyediakan integrasi dengan _event broadcasting_ **Laravel** yang sudah ada, seperti **Laravel Echo**.

Untuk informasi lebih lanjut tentang **Laravel Reverb**, kunjungi [https://laravel.com/docs/11.x/reverb](https://laravel.com/docs/11.x/reverb).

## Trait Dumpable

Pada **Laravel 11**, semua kelas telah dilengkapi dengan _method_ `dd` atau `dump`. Tujuannya adalah untuk menyederhanakan inti dari _framework_ itu sendiri. Berikut ini adalah contohnya.

```php
class Stringable implements JsonSerializable, ArrayAccess
{
    use Conditionable, Dumpable, Macroable, Tappable;
 
    str('foo')->dd();
    str('foo')->dump();
```

## Migration yang lebih Sederhana

Sekarang di **Laravel 11**, _default migration_ yang disertakan akan disederhanakan, sehingga hanya terdapat 3 _file_ _migration_ saja.

```
database/migrations
├── 0001_01_01_000000_create_users_table.php
├── 0001_01_01_000001_create_cache_table.php
└── 0001_01_01_000002_create_jobs_table.php

0 directories, 3 files
```

## Per-Second Rate Limiting

Pada versi sebelumnya, **Laravel** membatasi _rate limiter_ menjadi `"per menit"`. Kini, di **Laravel 11**, _rate limiting_ mendukung pengaturan `"per detik"`, termasuk untuk permintaan _HTTP_ dan _queued jobs_.

```php
RateLimiter::for('invoices', function (Request $request) {
    return Limit::perSecond(1);
});
```

## Eager Loading Limit

**Laravel 11** akan terintegrasi dengan _package_ yang akan memudahkan pembuatan _query_ dalam _eager loading_. Berikut adalah contohnya.

```php
User::select('id', 'name')->with([
    'articles' => fn($query) => $query->limit(5)
])->get();
```

## Kesimpulan

Bagi pemula, perubahan struktur di **Laravel 11** yang lebih minimalis mungkin terasa mengejutkan jika dibandingkan dengan versi sebelumnya. Namun, hal ini tidak perlu dikhawatirkan, karena inti dari **Laravel** sejak versi 5 hingga saat ini tetap mempertahankan konsep dasar yang sama.



---
# Cara Install dan Menjalankan Laravel 11

## Installasi Composer

Berikut adalah beberapa cara untuk melakukan instalasi **Composer** sesuai dengan sistem operasi yang digunakan:

- **Installation - Linux / Unix / macOS**: [https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- **Installation - Windows**: [https://getcomposer.org/doc/00-intro.md#installation-windows](https://getcomposer.org/doc/00-intro.md#installation-windows)

Untuk memastikan apakah **Composer** berhasil diinstal di komputer, jalankan perintah berikut di terminal/CMD:

```bash
composer
```

>![Foto_hasil](IMG-10.png)


## Membuat Project Laravel 11

> **INFORMASI**: Minimal versi PHP yang digunakan adalah `8.2.`

Langkah pertama, masuklah ke dalam _folder_ tempat Anda ingin menyimpan _project_. Jika menggunakan `XAMPP`, biasanya _folder_ tersebut berada di dalam direktori `htdocs`.

Kemudian, jalankan perintah berikut di dalam terminal atau CMD untuk membuat project **Laravel 11**:

```bash
composer create-project --prefer-dist laravel/laravel:^11.0 laravel-11
```

Perintah ini akan membuat _project_ **Laravel 11** dengan nama `laravel-11`. Tunggu hingga proses instalasi selesai, dan pastikan koneksi internet Anda stabil selama proses ini.
>![Foto_hasil](IMG-11.png)


## Menjalankan Laravel 11

Setelah proses instalasi **Laravel 11** selesai, langkah selanjutnya adalah menguji coba menjalankan _project_ **Laravel**.

1. Pertama, masuk ke dalam _folder_ _project_ yang telah dibuat dengan perintah berikut:
    
    ```bash
    cd laravel-11
    ```
    
    Perintah ini digunakan untuk masuk ke dalam _folder_ _project_ yang bernama `laravel-11`.
    
2. Setelah berhasil masuk ke dalam _project_, jalankan perintah berikut di terminal atau CMD untuk menjalankan _server_ Laravel:
    
    ```bash
    php artisan serve
    ```
    
3. Jika proses berhasil, _project_ **Laravel** akan berjalan di _localhost_ pada port `8000`. Buka _browser_ dan akses [http://localhost:8000](http://localhost:8000/) untuk melihat hasilnya.
    

Jika berhasil, tampilan awal _project_ Laravel akan terlihat seperti berikut.

>![Foto_hasil](IMG-9.png)


## Menjalankan Storage Link

**Laravel** hanya dapat mengakses _file_ yang berada di dalam _folder_ `public`, sementara _file_ atau gambar yang diupload akan disimpan di dalam _folder_ `storage`.

Lalu, bagaimana caranya agar **Laravel** bisa mengakses _file_ yang sudah diupload? Solusinya adalah dengan menggunakan _symlink_ atau _storage link_.

Perintah _storage link_ ini akan membuat sebuah _link_ dari _folder_ `storage` ke _folder_ `public`, sehingga **Laravel** dapat mengakses dan membaca _file_ yang ada di dalam _folder_ `storage` melalui _folder_ `public`.

Untuk membuat _storage link_, jalankan perintah berikut di dalam terminal/CMD, pastikan Anda sudah berada di dalam _project_ **Laravel**:

```bash
php artisan storage:link
```

## Kesimpulan

Dengan mengikuti langkah-langkah di atas, Anda telah mempelajari cara memulai dan menjalankan _project_ baru menggunakan **Laravel 11**. Di artikel berikutnya, kita akan belajar bersama bagaimana cara membuat _Model_ dan _Migration_ di dalam **Laravel 11**.


---


# Membuat Model dan Migration


## Konfigurasi Koneksi Database

Pertama-tama, mari kita konfigurasi koneksi antara **MySQL** dan **Laravel 11**. Proses ini cukup mudah, karena kita hanya perlu mengonfigurasinya di dalam _file_ `.env`.

Silakan buka _file_ `.env`, kemudian cari baris kode berikut ini:

```php
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

kemudian ubah menjadi seperti berikut ini.

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_laravel11
DB_USERNAME=root
DB_PASSWORD=
```

Di atas, pertama-tama ubah konfigurasi `DB_CONNECTION` yang sebelumnya menggunakan `sqlite` menjadi `mysql`.

Selanjutnya, hilangkan tanda `#` pada konfigurasi key, agar _variable_ tersebut diaktifkan. Kemudian, atur nilai `DB_DATABASE` dengan nama database yang ingin digunakan, misalnya `db_laravel_11`.

Untuk `DB_USERNAME`, secara _default_ isikan dengan `root`, dan untuk `DB_PASSWORD`, jika menggunakan **XAMPP**, biarkan kosong (kosongkan bagian tersebut).

## Membuat Model dan Migration

Selanjutnya, mari kita lanjutkan dengan membuat _Model_ dan _Migration_ di dalam **Laravel 11**. Silakan jalankan perintah berikut di terminal/CMD, pastikan Anda sudah berada di dalam direktori _project_ **Laravel**:

```bash
php artisan make:model Product -m
```

Jika perintah di atas berhasil dijalankan, maka kita akan mendapatkan 2 _file_ baru yang berada di dalam _folder_ :

1. `app/Models/Product.php`
2. `database/migrations/2024_01_31_080603_create_products_table.php`

> **INFORMASI** : nama _file_ _Migration_ akan _random_ sesuai dengan tanggal dibuat-nya.

## Menambahkan Field / Kolom di dalam Migration

Setelah _file_ _Migration_ berhasil dibuat, langkah selanjutnya adalah menambahkan _field_ atau kolom di dalamnya. Buka _file_ _migration_ tersebut, kemudian pada fungsi `up`, ubah kode-nya seperti berikut.

database/migrations/2024_01_31_080603_create_products_table.php

```php
public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('image');
        $table->string('title');
        $table->text('description');
        $table->bigInteger('price');
        $table->integer('stock')->default(0);
        $table->timestamps();
    });
}
```

Dari perubahan kode di atas, kita menambahkan 5 _field_, yaitu :

|FIELD / KOLOM|TIPE DATA|OPTION|
|---|---|---|
|`image`|`string`|-|
|`title`|`string`|-|
|`description`|`text`|-|
|`price`|`bigInteger`|-|
|`stock`|`integer`|nilai _default_ `0`|

## Menambahkan Mass Assignment

_Mass_ _Assignment_ merupakan sebuah properti _array_ yang berisi _field_-_field_ yang ada di dalam _table_ / _migration_. _Mass_ _Assignment_ digunakan agar _field_ yang sudah kita tambahkan di dalam _migration_ dapat melakukan manipulasi ke dalam _database_.

Buka _file_ `app/Models/Product.php`, lalu ubah kodenya menjadi seperti berikut.

app/Models/Product.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'title',
        'description',
        'price',
        'stock',
    ];
}
```

Di atas, kita menambahkan properti `$fillable` dengan jenis _array_ dan di dalamnya terdapat _field_/kolom yang sudah kita buat sebelumnya di dalam _file_ _migration_.

## Menjalankan Proses Migrate

Sekarang kita akan belajar bagaimana menjalankan proses _migrate_ di dalam **Laravel**, proses ini akan men-_generate_ _database_ dan _table_ beserta _field_/kolom di dalamnya.

Silahkan  jalankan perintah berikut ini di dalam terminal/CMD dan pastikan sudah berada di dalam _project_ **Laravel**-nya.

```bash
php artisan migrate
```

Jika keluar pertanyaan seperti berikut ini. Itu artinya kita belum memiliki _database_ di dalam **MySQL** dengan nama `db_laravel11` dan apakah kita ingin membuatnya ? Silahkan pilih `Yes` dan **ENTER**.

```bash
WARN  The database 'db_laravel11' does not exist on the 'mysql' connection.  

┌ Would you like to create it? ────────────────────────────────┐
│ ● Yes / ○ No                                                 │
└──────────────────────────────────────────────────────────────┘ 
```

>![Foto_hasil](IMG-12.png)

Dan jika  cek pada **PhpMyAdmin** di [http://localhost/phpmyadmin](http://localhost/phpmyadmin), maka _table_-_table_ akan berhasil di_generate_ berserta _field_-_field_ di dalamnya.

>![Foto_hasil](IMG-13.png)


## Kesimpulan

Sampai disini pembahasan kita terkait bagaimana cara membuat _Model_ dan _Migration_ di dalam **Laravel** **11** dan kita juga belajar menambahkan _field_ dan mass _assignment_ beserta menjalankan proses _migrate_.

Pada artikel berikutnya, kita semua akan belajar bagaimana cara menampilkan data dari _database_ di dalam **Laravel** **11**.

---
# Menampilkan Data dari Database


## Membuat Controller Product

Pertama, kita akan membuat sebuah _controller_ terlebih dahulu, _controller_ ini yang bertugas untuk mengatur semua aksi-aksi di dalam _project_. Dan _controller_ ini akan menghubungkan antara _model_, _view_ dan juga _route_.

Silahkan  jalankan perintah berikut ini di dalam terminal/CMD dan pastikan sudah berada di dalam _project_ **Laravel**-nya.

```bash
php artisan make:controller ProductController
```

Jika perintah di atas berhasil dijalankan, maka kita akan mendapatkan 1 _file_ _controller_ baru yang berada di dalam _folder_ `app/Http/Controllers/ProductController.php`.

Silahkan  buka _file_ tersebut, kemudian ubah semua kode-nya menjadi seperti berikut ini.

**`app/Http/Controllers/ProductController.php`**
```php
<?php

namespace App\Http\Controllers;

//import model product
use App\Models\Product; 

//import return type View
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get all products
        $products = Product::latest()->paginate(10);

        //render view with products
        return view('products.index', compact('products'));
    }
}
```

Dari perubahan kode di atas, pertama kita harus melakukan _import_ _Model_ `Product`.

```php
//import model product
use App\Models\Product; 
```

kemudian kita _import_ juga _return_ _type_ `View`.

```php
//import return type View
use Illuminate\View\View;
```

Setelah itu, di dalam _class_ `ProductController` kita menambahkan sebuah _method_ baru dengan nama `index`.

```php
public function index() : View
{

	//...
	
}
```

Di dalam _method_ tersebut, hal pertama yang kita lakukan adalah memanggil data _products_ dari _database_ melalui _Model_ `Product`.

```php
//get all products
$products = Product::latest()->paginate(10);
```

Setelah data berhasil di dapatkan dan ditampung di dalam _variable_ `$products`, maka langkah berikutnya adalah melakukan _render_ _view_ beserta mengirim data _product_ yang ada di dalam _variable_ `$products`.

```php
//render view with products
return view('products.index', compact('products'));
```

Di atas, kita gunakan `compact` untuk mengirim data dari _controller_ ke dalam _view_.

## Membuat Route Resource Product

Setelah _controller_ berhasil dibuat, maka langkah berikutnya adalah membuat _route_-nya. _Route_ ini akan bertugas sebagai penghubung antara pengguna / _user_ dengan aplikasi. Kurang lebih ilustrasinya seperti berikut ini.

>![Foto_hasil](IMG-14.png)



Silahkan  buka _file_ `routes/web.php`, kemudian ubah kode-nya menjadi seperti berikut ini.

**`routes/web.php`**

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//route resource for products
Route::resource('/products', \App\Http\Controllers\ProductController::class);
```

Di atas, kita membuat sebuah _route_ baru dengan _path_ `/products` dan kita arahkan ke dalam _class_ `ProductController`. Untuk _route_ yang kita buat adalah jenis _resource_, artinya **Laravel** akan secara otomatis menghasilkan _route_-_route_ untuk berbagai operasi **CRUD**, seperti:

|METHOD|PATH|KETERANGAN|
|---|---|---|
|GET|`/products`|Menampilkan semua _products_.|
|GET|`/products/create`|Menampilkan _form_ untuk membuat _product_ baru.|
|POST|`/products`|Menyimpan _product_ baru.|
|GET|`/products/{id}`|Menampilkan _detail_ dari sebuah _product_.|
|GET|`/products/{id}/edit`|Menampilkan _form_ untuk mengedit _product_.|
|PUT/PATCH|`/products/{id}`|Memperbarui _product_ yang ada.|
|DELETE|`/products/{id}`|Menghapus _product_.|

Untuk memastikan apakah _route_-_route_ tersebut sudah di_generate_ oleh **Laravel**,  bisa menjalankan perintah berikut ini di dalam terminal/CMD.

```bash
php artisan route:list
```

>![Foto_hasil](IMG-15.png)


## Membuat View untuk Menampilkan Data

Sekarang kita akan lanjutkan membuat _view_, yang nanti digunakan untuk menampilkan _list_ data _products_ dari _database_.

Silahkan  buat _folder_ baru dengan nama `products` di dalam _folder_ `resources/views`, kemudian di dalam _folder_ `products` tersebut silahkan buat _file_ baru dengan nama `index.blade.php`, kemudian masukkan kode berikut ini di dalamnya.

`resources/views/products/index.blade.php`

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Products - SantriKoding.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">Tutorial Laravel 11 untuk Pemula</h3>
                    <h5 class="text-center"><a href="https://santrikoding.com">www.santrikoding.com</a></h5>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('products.create') }}" class="btn btn-md btn-success mb-3">ADD PRODUCT</a>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">IMAGE</th>
                                    <th scope="col">TITLE</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">STOCK</th>
                                    <th scope="col" style="width: 20%">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage/products/'.$product->image) }}" class="rounded" style="width: 150px">
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ "Rp " . number_format($product->price,2,',','.') }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data Products belum Tersedia.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //message with sweetalert
        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "BERHASIL",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif(session('error'))
            Swal.fire({
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif

    </script>

</body>
</html>
```

Dari penambahan kode di atas, untuk menampilkan data kita akan gunakan direktif `@forelse`.

```php
@forelse ($products as $product)
 
	//tampilkan data
 	
@empty

	//Data products belum Tersedia.
	
@endforelse
```

Untuk _pagination_, kita cukup memanggilnya seperti berikut ini.

```php
{{ $products->links() }}
```

kemudian kita menambahkan kondisi untuk memeriksa sebuah _session_ _flash_, yang nantinya difungsikan untuk menampilkan _alert_ atau notifikasi setelah berhasil melakukan proses _insert_. _update_ dan _delete_ data. Dan library yang kita gunakan adalah `Sweet Alert2`.

```js
<script>
    //message with sweetalert
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>
```


## Uji Coba Menampilkan Data Products

Sekarang silahkan  jalankan _project_-nya dengan mengakses [http://localhost:8000/products](http://localhost:8000/products) di dalam _browser_, jika berhasil maka hasilnya kurang lebih seperti berikut ini.

>![Foto_hasil](IMG-16.png)



Di atas masih menampilkan pesan `Data Products belum Tersedia`, itu karena memang kita masih belum memiliki data apapun di dalam _table_ `products`.

## Kesimpulan

Pada artikel ini kita telah belajar banyak hal, seperti membuat controller beserta _method_-nya, membuat dan memahami _routing_ dan menampilkan data menggunakan _view_.

Pada artikel berikutnya kita semua akan belajar bagaimana cara melakukan proses _insert_ data ke dalam _database_ di **Laravel** **11**.

---
# Insert Data ke Dalam Database

## Menambahkan Method `Create` dan `Store` di Controller

Karena akan membuat proses _insert_ data, maka kita harus menambahkan 2 _method_ baru di dalam _controller_, apa saja _method_ tersebut? berikut ini penjelasannya.

|METHOD|KETERANGAN|
|---|---|
|`create`|Digunakan untuk menampilkan halaman _form_ tambah data|
|`store`|Digunakan untuk _insert_ data ke dalam _database_ dan melakukan _upload_ gambar.|

Silahkan  buka _file_ `app/Http/Controllers/ProductController.php`, kemudian ubah semua kode-nya menjadi seperti berikut ini.

app/Http/Controllers/ProductController.php

```php
<?php

namespace App\Http\Controllers;

//import model product
use App\Models\Product; 

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get all products
        $products = Product::latest()->paginate(10);

        //render view with products
        return view('products.index', compact('products'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        //create product
        Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock
        ]);

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
}
```

Dari perubahan kode di atas, pertama kita _import_ _return_ _type_ `RedirectResponse`.

```php
//import return type redirectResponse
use Illuminate\Http\RedirectResponse;
```

kemudian kita _import_ juga _Http_ _Request_.

```php
//import Http Request
use Illuminate\Http\Request;
```

Setelah itu, di dalam _class_ `ProductController` kita menambahkan 2 _method_ baru:

1. `function create`
2. `function store`

_**Function Create**_

_Method_ ini akan kita gunakan untuk menampilkan halaman _form_ tambah data _product_. Pada _method_ ini kita hanya melakukan _return_ ke dalam sebuah _view_.

```php
public function create(): View
{
    return view('products.create');
}
```

_**Function Store**_

_Method_ ini akan kita gunakan untuk melakukan proses _insert_ data ke dalam _database_ dan juga _upload_ gambar.

```php
public function store(Request $request): RedirectResponse
{

	//...
	
}
```

Di dalam _method_ tersebut, hal pertama yang kita lakukan adalah membuat validasi, yaitu untuk memeriksa apakah data yang dikirimkan sudah sesuai atau belum.

```php
//validate form
$request->validate([
    'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
    'title'         => 'required|min:5',
    'description'   => 'required|min:10',
    'price'         => 'required|numeric',
    'stock'         => 'required|numeric'
]);
```

Dari kode validasi di atas, berikut ini penjelasan lengkapnya.

|KEY|VALIDATION|KETERANGAN|
|---|---|---|
|`image`|required|_field_ wajib diisi.|
||image|_field_ harus berupa gambar|
||mimes:jpeg,jpg,png|_filed_ harus memiliki extensi `jpeg`, `jpg` dan `png`.|
||max:2048|_field_ maksimal berukuran 2048 Mb / 2Mb.|
|`title`|required|_field_ wajib diisi.|
||min:5|_field_ minimal memiliki 5 karakter/huruf.|
|`description`|required|_field_ wajib diisi.|
||min:10|_field_ minimal memiliki 10 karakter/huruf.|
|`price`|requied|_field_ wajib diisi.|
||numeric|_field_ harus berupa angka|
|`stock`|requierd|_field_ wajib diisi.|
||numeric|_field_ harus berupa angka|

Setelah itu, kita melakukan _upload_ gambar menggunakan method `storeAs`.

```php
//upload image
$image = $request->file('image');
$image->storeAs('public/products', $image->hashName());
```

Setelah data berhasil di_upload_, maka langkah selanjutnya adalah melakukan proses _insert_ data ke dalam _database_ menggunakan _Model_ `Product`.

```php
//create product
Product::create([
    'image'         => $image->hashName(),
    'title'         => $request->title,
    'description'   => $request->description,
    'price'         => $request->price,
    'stock'         => $request->stock
]);
```

Jika proses _insert_ data berhasil dilakukan, maka kita akan _redirect_ ke dalam route yang bernama `products.index` dengan mengirimkan sebuah _session_ _flash_ data.

```php
//redirect to index
return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
```

## Membuat View Form Create Product

Setelah berhasil membuat _method_ di dalam _controller_, maka langkah selanjutnya adalah membuat halaman _view_ untuk menampilkan _form_ tambah data _product_.

Silahkan  buat _file_ baru dengan nama `create.blade.php` di dalam _folder_ `resources/views/products`, kemudian masukkan kode berikut ini di dalamnya.

resources/views/products/create.blade.php

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Products - SantriKoding.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        
                            @csrf

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">IMAGE</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            
                                <!-- error message untuk image -->
                                @error('image')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">TITLE</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="Masukkan Judul Product">
                            
                                <!-- error message untuk title -->
                                @error('title')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">DESCRIPTION</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Masukkan Description Product">{{ old('description') }}</textarea>
                            
                                <!-- error message untuk description -->
                                @error('description')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">PRICE</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" placeholder="Masukkan Harga Product">
                                    
                                        <!-- error message untuk price -->
                                        @error('price')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">STOCK</label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock') }}" placeholder="Masukkan Stock Product">
                                    
                                        <!-- error message untuk stock -->
                                        @error('stock')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-md btn-primary me-3">SAVE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script>
</body>
</html>
```

Dari penambahan kode di atas, jika  perhatikan pada bagian _form_ _action_, kita arahkan ke dalam _route_ yang bernama `products.store`. Artinya itu akan memanggil _method_ yang bernama `store` yang berada di dalam _controller_.

```php
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">

	//...
	
</form>
```

Pada bagian _form_ kita tambahkan _attribute_ `enctype="multipart/form-data"`. Ini ditambahkan jika ada sebuah _upload_ file di dalam _form_-nya.

Kemudian di dalam JavaScript,  bisa perhatikan kita melakukan inisialisasi _Rich_ _Text_ Editor menggunakan **CKEdtor**. Dan kita akan terapkan ke dalam _textarea_ yang memiliki _name_ `description`.

```js
<script>
    CKEDITOR.replace('description');
</script>
```

## Uji Coba Insert Data Product

Silahkan  klik _button_ `ADD PRODUCT` pada halaman _products_ _index_ atau bisa juga ke _URL_ berikut ini [http://localhost:8000/products/create](http://localhost:8000/products/create), jika berhasil maka akan menampilkan hasil seperti berikut ini.

>![Foto_hasil](IMG-17.png)

Silahkan klik _button_ `SAVE` tanpa mengisi data apapun, jika berhasil maka akan menampilkan validasi yang kurang lebih serti berikut ini.

>![Foto_hasil](IMG-18.png)

Sekarang, silahkan masukkan data di dalam _form_ dan klik _button_ `SAVE`, jika berhasil maka akan menampilkan hasil seperti berikut ini.

>![Foto_hasil](IMG-19.png)


## Kesimpulan

Pada artikel ini kita telah belajar banyak hal, seperti membuat _method_ `create` dan `store` untuk proses _insert_ data, membuat fungsi _upload_ gambar, membuat halaman _view_ untuk form tambah data _product_.

Pada artikel berikutnya, kita semua akan belajar bagaimana cara menampilkan _detail_ data _product_ berdasarkan ID.

---
# Menampilkan Detail Data By ID

## Menambahkan Method `Show` di Controller

Sekarang kita akan menambahkan 1 _method_ di dalam _controller_ dengan nama `show` dan jika  bertanya, apakah harus dengan nama tersebut? jawabannya adalah iya, karena sebelumnya kita menggunakan _route_ dengan jenis _resource_, maka untuk penamaan _method_-_method_ di dalam _controller_ harus sesuai dengan aturan dari **Laravel**.

Silahkan  buka _file_ `app/Http/Controllers/ProductController.php`, kemudian ubah semua kode-nya menjadi seperti berikut ini.

**`app/Http/Controllers/ProductController.php`**

```php
<?php

namespace App\Http\Controllers;

//import model product
use App\Models\Product; 

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get all products
        $products = Product::latest()->paginate(10);

        //render view with products
        return view('products.index', compact('products'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        //create product
        Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock
        ]);

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
    /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //render view with product
        return view('products.show', compact('product'));
    }
}
```

Dari perubahan kode di atas, kita menambahkan _method_ baru dengan nama `show` dan di dalam parameternya kita berikan _variable_ `$id`.

```php
public function show(string $id): View
{

	//...
	
}
```

Di dalam _method_ di atas, kita akan melakukan _get_ data dari _database_ melalui _Model_ `Product` dengan _method_ `findOrFail`.

```php
//get product by ID
$product = Product::findOrFail($id);
```

Setelah data berhasil didapatkan, selanjutnya adalah dikirimkan ke dalam _view_.

```php
//render view with product
return view('products.show', compact('product'));
```

## Membuat View Detail Data Product

Setelah berhasil menambahkan _method_, maka langkah selanjutnya adalah membuat _view_ untuk menampilkan data-nya.

Silahkan  buat _file_ baru dengan nama `show.blade.php` di dalam _folder_ `resources/views/products`, kemudian masukkan kode berikut ini di dalamnya.

**`resources/views/products/show.blade.php`**

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Products - SantriKoding.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <img src="{{ asset('/storage/products/'.$product->image) }}" class="rounded" style="width: 100%">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h3>{{ $product->title }}</h3>
                        <hr/>
                        <p>{{ "Rp " . number_format($product->price,2,',','.') }}</p>
                        <code>
                            <p>{!! $product->description !!}</p>
                        </code>
                        <hr/>
                        <p>Stock : {{ $product->stock }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

Dari penambahan kode di atas, kita menampilkan _detail_ data-nya dengan cara memanggil objek dari `$product`.

1. **Menampilkan Gambar**
```php
<img src="{{ asset('/storage/products/'.$product->image) }}" class="rounded" style="width: 100%">
```
2. **Menampilkan Title**
```php
{{ $product->title }}
```
3. **Menampilkan Harga**
```php
{{ "Rp " . number_format($product->price,2,',','.') }}
```
Di atas, kita gunakan _function_ `number_format` dari **PHP** untuk memformat harga _product_.  
4. **Menampilkan Description**
```php
{!! $product->description !!}
```
Karena di dalam _description_ terdapat sintaks **HTML**, maka kita harus me-_render_nya menggunakan `{!! !!}`
5. **Menampilkan Stock**
```php
{{ $product->stock }}
```

## Uji Coba Menampilkan Detail Data Product

Silahkan  klik _button_ `SHOW` di data yang  miliki, jika berhasil maka akan menampilkan hasil seperti berikut ini.

>![Foto_hasil](IMG-20.png)

## Kesimpulan

kita semua telah belajar bagaimana cara menampilkan _detail_ data berdasarkan ID, dimana data **ID** tersebut akan diambil dari parameter di dalam _URL_ _browser_.

---
# Edit dan Update Data ke Database

## Menambahkan Method `Edit` dan `Update` di Controller

Pada proses pembuatan _edit_ dan _update_, kita membutuhkan 2 _method_ tambahan di dalam _controller_, _method_ tersebut bernama `edit` dan `update`. Berikut penjelasannya.

|METHOD|KETERANGAN|
|---|---|
|`edit`|Digunakan untuk menampilkan halaman _form_ edit data|
|`update`|Digunakan untuk update data ke dalam _database_ dan melakukan _upload_ gambar (opsional).|

Sekarang, silahkan  buka _file_ `app/Http/Controllers/ProductController.php`, kemudian ubah semua kode-nya menjadi seperti berikut ini.

**`app/Http/Controllers/ProductController.php`**

```php
<?php

namespace App\Http\Controllers;

//import model product
use App\Models\Product; 

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\Request;

//import Http Request
use Illuminate\Http\RedirectResponse;

//import Facades Storage
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get all products
        $products = Product::latest()->paginate(10);

        //render view with products
        return view('products.index', compact('products'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        //create product
        Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock
        ]);

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
    /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //render view with product
        return view('products.show', compact('product'));
    }
    
    /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //render view with product
        return view('products.edit', compact('product'));
    }
        
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $request->validate([
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        //get product by ID
        $product = Product::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            //delete old image
            Storage::delete('public/products/'.$product->image);

            //update product with new image
            $product->update([
                'image'         => $image->hashName(),
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock
            ]);

        } else {

            //update product without image
            $product->update([
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock
            ]);
        }

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
}
```

Dari perubahan kode di atas, pertama kita _import_ _Facades_ `Storage` dari **Laravel**. Ini akan kita gunakan untuk menghapus _file_ gambar _product_ lama saat gambar diperbarui.

```php
//import Facades Storage
use Illuminate\Support\Facades\Storage;
```

kemudian di dalam _class_ `productController`, kita membuat 2 _method_ baru, yaitu:

1. `function edit`
2. `function update`

_**Function Edit**_

_Method_ ini akan kita gunakan untuk menampilkan halaman _form_ _edit_ data product dan di dalam _method_ tersebut terdapat parameter `$id` yang mana isinya akan diambil dari ID yang ada di dalam _URL_ _browser_.

```php
public function edit(string $id): View
{

	//...
	
}
```

Di dalam _method_ tersebut, kita melakukan _get_ data ke dalam _database_ menggunakan _Model_ berdasarkan ID.

```php
//get product by ID
$product = Product::findOrFail($id);
```

Setelah data didapatkan, kita tinggal kirimkan data tersebut ke dalam _view_ menggunakan `compact`.

```php
//render view with product
return view('products.edit', compact('product'));
```

_**Function Update**_

_Method_ ini akan kita gunakan untuk proses _update_ data _product_ ke dalam _database_. Di dalam _method_ ini terdapat 2 parameter, yaitu `$request` dan `$id`.

1. `$request` - digunakan untuk menerima request data yang dikirimkan oleh pengguna melalui _form_.
2. `$id` - merupakan **ID** data _product_ yang akan akan dijadikan acuan _update_ data.

```php
public function update(Request $request, $id): RedirectResponse
{

	//...
	
}
```

Di dalam _method_ di atas, pertama-tama kita membuat sebuah validasi terlebih dahulu.

```php
//validate form
$request->validate([
    'image'         => 'image|mimes:jpeg,jpg,png|max:2048',
    'title'         => 'required|min:5',
    'description'   => 'required|min:10',
    'price'         => 'required|numeric',
    'stock'         => 'required|numeric'
]);
```

Dari penambahan validasi di atas, kurang lebih ini penjelasannya.

|KEY|VALIDATION|KETERANGAN|
|---|---|---|
|`image`|image|_field_ harus berupa gambar|
||mimes:jpeg,jpg,png|_filed_ harus memiliki extensi `jpeg`, `jpg` dan `png`.|
||max:2048|_field_ maksimal berukuran 2048 Mb / 2Mb.|
|`title`|required|_field_ wajib diisi.|
||min:5|_field_ minimal memiliki 5 karakter/huruf.|
|`description`|required|_field_ wajib diisi.|
||min:10|_field_ minimal memiliki 10 karakter/huruf.|
|`price`|requied|_field_ wajib diisi.|
||numeric|_field_ harus berupa angka|
|`stock`|requierd|_field_ wajib diisi.|
||numeric|_field_ harus berupa angka|

Setelah itu, kita melakukan get data ke dalam _database_ menggunakan _Model_ berdasarkan **ID**.

```php
//get product by ID
$product = Product::findOrFail($id);
```

kemudian kita membuat kondisi untuk gambar, jika terdapat _request_ gambar

```php
//check if image is uploaded
if ($request->hasFile('image')) {

	//upload gambar baru
	
	//hapus gambar lama
	
	//update data product dengan gambar baru
	
	
} else {

	//update data product tanpa gambar

}
```

Di atas, jika ada sebuah _request_ dengan nama `image`, maka kita akan melakukan beberapa aksi, yaitu:

1. Upload gambar baru
```php
    //upload new image
    $image = $request->file('image');
    $image->storeAs('public/products', $image->hashName());
```
2. Hapus gambar lama
```php
//delete old image
Storage::delete('public/products/'.$product->image);
```
3. Update data _product_
```php
//update product with new image
$product->update([
	'image'         => $image->hashName(),
	'title'         => $request->title,
	'description'   => $request->description,
	'price'         => $request->price,
	'stock'         => $request->stock
]);
```

Tapi jika request `image` tidak ada, maka kita cukup _update_ data _product_ tanpa gambar.

```php
//update product without image
$product->update([
    'title'         => $request->title,
    'description'   => $request->description,
    'price'         => $request->price,
    'stock'         => $request->stock
]);
```

Setelah itu, kita tinggal _redirect_ ke dalam sebuah _route_ dengan nama `products.index` dengan menambahkan _flash_ data.

```php
//redirect to index
return redirect()->route('products.index')->with(['success' => 'Data Berhasil Diubah!']);
```

## Membuat View Form Edit Data Product

Langkah selanjutnya adalah membuat _view_ untuk menampilkan halaman _form_ _edit_ data _product_. Silahkan  buat _file_ baru dengan nama `edit.blade.php` di dalam _folder_ `resources/views/products`, kemudian masukkan kode berikut ini di dalamnya.

resources/views/products/edit.blade.php

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Products - SantriKoding.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">IMAGE</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            
                                <!-- error message untuk image -->
                                @error('image')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">TITLE</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $product->title) }}" placeholder="Masukkan Judul Product">
                            
                                <!-- error message untuk title -->
                                @error('title')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">DESCRIPTION</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Masukkan Description Product">{{ old('description', $product->description) }}</textarea>
                            
                                <!-- error message untuk description -->
                                @error('description')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">PRICE</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" placeholder="Masukkan Harga Product">
                                    
                                        <!-- error message untuk price -->
                                        @error('price')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">STOCK</label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="Masukkan Stock Product">
                                    
                                        <!-- error message untuk stock -->
                                        @error('stock')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script>
</body>
</html>
```

Pada penambahan kode di atas, untuk mengisi _value_ kita panggil object dari data _product_ di dalam _helper_ `old`. Contohnya seperti berikut.

```php
{{ old('title', $product->title) }}
```

Dan jangan lupa, untuk halaman _form_ edit, pastikan  menambahakn _method_ `PUT` di dalamnya. Ini menandakan bahwa _form_ tersebut adalah _form_ _edit_ data.

```php
@method('PUT')
```

## Uji Coba Edit dan Update Product

Silahkan  klik _button_ `EDIT` di salah satu data yang dimiliki, jika berhasil maka akan menampilkan halaman _edit_ data _product_, kurang lebih seperti berikut ini.

>![Foto_hasil](IMG-22.png)

Silahkan  sesuaikan isinya, kemudian klik _button_ `UPDATE`, jika berhasil maka akan menampilkan halaman seperti berikut ini.

>![Foto_hasil](IMG-21.png)
## Kesimpulan

Pada moudl ini kita telah belajar bagaimana cara membuat proses _edit_ dan _update_ data di **Laravel** **11**, dengan cara menambahkan 2 _method_ di dalam _controller_, yaitu `edit` dan `update` dan membuat halaman _view_ untuk _form_ _edit_-nya.

---
# Delete Data dari Database
## Menambahkan Method `Destroy`

Sekarang kita akan menambahkan _method_ baru di dalam _controller_, method ini yang bertugas melakukan hapus data ke dalam _database_ dan juga menghapus gambar di dalam _project_ **Laravel**.

Silahkan  buka _file_ `app/Http/Controllers/ProductController.php`, kemudian ubah semua kode-nya menjadi seperti berikut ini.

app/Http/Controllers/ProductController.php

```php
<?php

namespace App\Http\Controllers;

//import model product
use App\Models\Product; 

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\Request;

//import Http Request
use Illuminate\Http\RedirectResponse;

//import Facades Storage
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get all products
        $products = Product::latest()->paginate(10);

        //render view with products
        return view('products.index', compact('products'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        //create product
        Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock
        ]);

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
    /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //render view with product
        return view('products.show', compact('product'));
    }
    
    /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //render view with product
        return view('products.edit', compact('product'));
    }
        
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $request->validate([
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        //get product by ID
        $product = Product::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            //delete old image
            Storage::delete('public/products/'.$product->image);

            //update product with new image
            $product->update([
                'image'         => $image->hashName(),
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock
            ]);

        } else {

            //update product without image
            $product->update([
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock
            ]);
        }

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //delete image
        Storage::delete('public/products/'. $product->image);

        //delete product
        $product->delete();

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
```

Dari perubahan kode di atas, kita menambahkan _method_ baru dengan nama `destroy` dan pada parameternya ita berikan `$id`, yang nanti nilainya akn diambil dari _URL_ _browser_.

```php
public function destroy($id): RedirectResponse
{

	//...
	
}
```

Di dalam _method_ tersebut, pertama, kita akan mendari data _product_ berdasarkan ID.

```php
//get product by ID
$product = Product::findOrFail($id);
```

Jika sudah ditemukan, maka kita akan melakukan _delete_ gambar.

```php
//delete image
Storage::delete('public/products/'. $product->image);
```

Setelah gambar berhasil dihapus, langkah selanjutnya adalah menghapus data yang terkait dari _database_.

```php
//delete product
$product->delete();
```

Selanjutnya, dilakukan _redirect_ ke route dengan nama `products.index` sambil mengirimkan data _flash session_.

```php
//redirect to index
return redirect()->route('products.index')->with(['success' => 'Data Berhasil Dihapus!']);
```

## Langkah 2 - Uji Coba Delete Data Product

Klik _button_ `DELETE` pada salah satu data yang tersedia. Jika berhasil, akan muncul _alert_ konfirmasi seperti ilustrasi berikut.

>![Foto_hasil](IMG-23.png)


Jika tombol `OK` diklik, maka data akan terhapus, dan hasilnya akan terlihat seperti pada ilustrasi berikut.

>![Foto_hasil](IMG-24.png)


## Kesimpulan
Pada tahap ini kita telah belajar menambahkan _method_ untuk proses _delete_ data dari _database_ dan menghapus gambar.