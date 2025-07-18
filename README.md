# ✅ TODOS - Sistem Pengurusan Tugasan (Laravel 12)
**Todos** ialah sistem pengurusan tugasan yang dibina menggunakan Laravel 12. Sistem ini menyokong pengkategorian tugasan, penandaan (tags), dan pengurusan pengguna berasaskan peranan (role-based access control).
> ⚠️ Projek ini dibina sebagai **contoh pembelajaran CRUD menggunakan Laravel**. Ia sesuai digunakan untuk tujuan pembelajaran, latihan, dan penyesuaian asas. Bukan untuk penggunaan produksi secara langsung tanpa pengubahsuaian keselamatan dan pengoptimuman lanjut.

---

## 📦 Fungsi Sistem

-   ✅ Cipta, Kemaskini & Hapus Tugasan
-   ✅ Kategori & Tag untuk tugasan
-   ✅ Role Management: Super Admin, Admin, User
-   ✅ Interface: Livewire + TailwindCSS
-   ✅ Sistem auth Laravel standard
-   ✅ Interface responsif dan moden

## 🧰 Keperluan Sistem

Pastikan mesin anda mempunyai:
- PHP >= 8.2
- Composer
- MySQL atau MariaDB
- Node.js & npm
- Git
- Laravel CLI

---

## 🚀 Langkah Setup Projek

### 1. Clone Projek Ini

```bash
git clone https://github.com/mzm-dev/laravel-todos.git
cd todos
```

### 2. Pasang Dependensi Backend (Composer)

```bash
composer install
```

### 3. Pasang Dependensi Frontend (npm)

```bash
npm install
npm run build
```

### 4. Salin Fail `.env` dan Konfigurasi

```bash
cp .env.example .env
```

> atau rename  `.env.example` kepada `.env`

Edit konfigurasi sambungan pangkalan data dalam `.env`:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todos
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jana Key Aplikasi

```bash
php artisan key:generate
```

### 6. Jalankan Migrasi dan Seeder

```bash
php artisan migrate --seed
```
Ini akan:
-   Mencipta semua jadual
-   Menambah data permulaan termasuk pengguna demo

### 🔐 Akaun Login Lalai (Demo)
| Peranan | Email  | Kata Laluan| Role |
|--|--|--|--|
| Super Admin | super@todo.com | password | Super Admin |
| Admin | admin@todo.com | password |  Admin |
| User| user@todo.com | password |  User|

### 📂 Struktur Projek (Ringkas)

```php
app/
├── Livewire/        # Komponen Livewire
├── Models/          # Model Eloquent
database/
├── migrations/      # Fail migrasi
├── seeders/         # Data permulaan
routes/
├── web.php          # Laluan Web
resources/
├── views/           # Fail Blade (UI)
public/
├── build/           # Asset terhasil dari Vite
```

### 🧪 Perintah Tambahan

```bash
# Reset dan seed semula pangkalan data
php artisan migrate:fresh --seed

# Kosongkan cache
php artisan oonfig:cache
```

## ⚙️ Menjana Komponen Livewire dan Route

Gunakan perintah berikut untuk menjana komponen Livewire:

```bash
php artisan make:livewire NamaKomponen
```

Contoh 1:
```bash
php artisan make:livewire Mohon/MohonIndex
```
Ia akan menjana:
-   `app/Livewire/Mohon/MohonIndex.php`
-   `resources/views/livewire/mohon/mohon-index.blade.php`

Contoh 2:
```bash
php artisan make:livewire Mohon/MohonCreate
```
Ia akan menjana:
-   `app/Livewire/Mohon/MohonCreate.php`
-   `resources/views/livewire/mohon/mohon-create.blade.php`

### 🛣️ Menambah Route Untuk Komponen Livewire

```php
use App\Livewire\Mohon\MohonIndex;

Route::middleware(['auth'])->group(function () {
    Route::get('/mohon', MohonIndex::class)->name('mohon.index');
    Route::get('/mohon/create', MohonCreate::class)->name('mohon.create');
});

```

Jika menggunakan layout

```php
use Livewire\Component;

class MohonIndex extends Component
{
    public function render()
    {
        return view('livewire.mohon.index')
            ->layout('layouts.app'); // Pastikan layout wujud
    }
}
```


## 🚀 Sedia Untuk Production?
Untuk deploy ke production (contoh: VPS, Laravel Forge):

```bash
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```
## 📜 Lesen

Projek ini adalah **Open Source**. Anda bebas untuk menggunakannya bagi tujuan pembelajaran, pembangunan dalaman, atau menyesuaikannya mengikut keperluan organisasi anda.

## 🎨 Kredit Pembangun

Projek ini dibangunkan oleh:

**Zaki Mustafa**  
📧 Email: [mzm@ns.gov.my]  
🔗 GitHub: [https://github.com/mzm-dev](https://github.com/mzm-dev)

Sumbangan dan pembaikan amat dialu-alukan melalui pull request atau cadangan isu di GitHub.
