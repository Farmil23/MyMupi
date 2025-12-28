# Panduan Deployment ke Vercel dengan Neon (PostgreSQL)

Karena Anda memilih **Neon** (Database PostgreSQL), langkah-langkahnya menjadi lebih modern dan mudah.

## 1. Persiapan Kode (Sudah Saya Lakukan)
- `vercel.json`: Sudah saya update agar mendukung **PostgreSQL**.
- `config/database.php`: Laravel bawaan sudah mendukung Postgres, jadi aman.

## 2. Setup Database di Neon.tech
1.  Buka [Neon.tech](https://neon.tech/) dan Sign Up.
2.  Buat **Project Baru**.
3.  Di Dashboard Neon, cari **Connection Details**.
4.  Pilih format **Tools** atau **Laravel** (jika ada) untuk melihat detailnya, atau copy **Connection String** (biasanya berformat `postgres://user:pass@host/db...`).
    - Catat detail berikut:
        - **Host**: (contoh: `ep-cool-cloud-123.aws.neon.tech`)
        - **Database Name**: (contoh: `neondb`)
        - **User**: (contoh: `farhan`)
        - **Password**: (contoh: `abCDE123...`)
        - **Port**: `5432` (Default Postgres)

## 3. Upload ke Vercel
1.  Upload project ini ke **GitHub**.
2.  Buka Dashboard Vercel -> **Add New Project** -> Import Repository.
3.  **Environment Variables (PENTING):**
    Masukkan data ini di settings Vercel:

    | Key | Value |
    | :--- | :--- |
    | `APP_KEY` | (Copy dari .env lokal Anda) |
    | `APP_ENV` | `production` |
    | `APP_DEBUG` | `true` |
    | `APP_URL` | (Biarkan kosong dulu) |
    | **`DB_CONNECTION`** | **`pgsql`** (Wajib ganti ini!) |
    | `DB_HOST` | (Host dari Neon) |
    | `DB_PORT` | `5432` |
    | `DB_DATABASE` | (Nama Database Neon) |
    | `DB_USERNAME` | (User Neon) |
    | `DB_PASSWORD` | (Password Neon) |

4.  Klik **Deploy**.

## 4. Cara Mengisi Data (Migrate & Seed)
Karena Anda pindah dari MySQL (XAMPP) ke PostgreSQL (Neon), file backup `.sql` lama tidak bisa dipakai langsung.
**Cara paling mudah** adalah "menembak" database Neon dari laptop Anda untuk mengisi data awal:

1.  Pastikan project sudah di-deploy di Vercel (meski database masih kosong).
2.  Buka file `.env` di laptop Anda (XAMPP).
3.  **Ubah sementara** bagian Database di `.env` lokal Anda untuk mengarah ke Neon:
    ```env
    DB_CONNECTION=pgsql
    DB_HOST=ep-cool-cloud-123... (Host Neon Anda)
    DB_PORT=5432
    DB_DATABASE=neondb
    DB_USERNAME=...
    DB_PASSWORD=...
    ```
4.  Buka Terminal di project Anda, lalu jalankan:
    ```bash
    php artisan migrate:fresh --seed
    ```
    *Perintah ini akan membuat tabel baru di Neon dan mengisinya dengan data contoh (Film, User Admin) yang ada di folder `database/seeders`.*

5.  Setelah selesai, kembalikan `.env` lokal Anda ke settingan awal (Localhost/MySQL) jika ingin lanjut coding di laptop.

## 5. Cek Hasil
Buka link Vercel Anda. Login dengan akun admin yang ada di seeder (biasanya `admin@example.com` / `password`).
