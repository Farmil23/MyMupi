Project ini dibuat untuk memenuhi penilaian **UAS** mata kuliah **Pemrograman Web**.

Anggota Kelompok -->
1. Zeta Mardhotillah Ronny (152024047)
2. Farhan Kamil Hermansyah (152024150)
3. Ratu Qolbu Maziah (152024151)

---
# Link Icon

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white)

---

# 🎬 MyMupi — Online Movie Ticket Booking (English UI)

**MyMupi** adalah aplikasi web pemesanan tiket bioskop online berbasis **Laravel**.  
Website ini mensimulasikan pengalaman booking tiket bioskop dari awal sampai akhir: **cari film → pilih showtime → pilih kursi → konfirmasi → dapat e-ticket**.

> 🌍 **Note:** Seluruh tampilan UI dan teks pada website dibuat dalam **Bahasa Inggris** (English UI) untuk memberi kesan lebih profesional dan konsisten.

---

## 📌 Project Overview

MyMupi memiliki dua peran utama:

- **User (Customer)**: Menjelajah film, melihat detail & showtimes, memilih kursi, melakukan booking, melihat tiket yang sudah dibeli, serta mengelola profil.
- **Admin (Cinema Manager)**: Mengelola data master seperti **Movies, Studios, dan Showtimes** melalui halaman admin (CRUD).

Dengan desain bertema cinema (navy–gold–cream), MyMupi fokus pada:
- tampilan modern & konsisten,
- alur booking yang jelas,
- pengalaman pengguna yang nyaman.

---

## ✨ Key Features

### ✅ User Features
- **Authentication**
  - Register & Login
  - Logout
- **Explore Movies**
  - Browse movie list (Now Showing)
  - Search by title
  - Filter by genre
  - Section tambahan **Coming Soon** (film yang belum rilis)
- **Movie Details**
  - View poster, genre, duration, rating
  - Read synopsis
  - View available showtimes
- **Booking Flow**
  - Select showtime
  - Select seats (seat map style bioskop + screen indicator + aisle)
  - Confirm booking
  - Success page menampilkan **E-ticket**
- **My Tickets**
  - Melihat riwayat booking/tiket yang sudah dibeli
- **Showtime Countdown**
  - Countdown “Start In” untuk showtime yang akan dimulai
- **Profile**
  - Edit profile information
  - Update password
  - Upload avatar / profile picture

---

### ✅ Admin Features
- **Movies Management (CRUD)**
  - Create, Read, Update, Delete movie
  - Upload / set poster
- **Studios Management (CRUD)**
  - Create, Read, Update, Delete studio
- **Showtimes Management (CRUD)**
  - Create, Read, Update, Delete showtimes
  - Menghubungkan movie + studio + waktu tayang + harga

---

## 🧠 User Flow (Alur Penggunaan)

**1) Home / Landing Page**
- User melihat film (Now Showing / Coming Soon)
- User bisa search & filter genre

**2) Movie Detail**
- User melihat detail film + daftar showtimes

**3) Booking**
- User memilih showtime
- User memilih kursi (seat map)
- User konfirmasi booking

**4) Ticket**
- Setelah booking berhasil, user mendapat e-ticket
- Ticket tersimpan dan bisa dilihat kembali di **My Tickets**

---

## 🛠️ Tech Stack

- **Backend**: Laravel (PHP)
- **Frontend**: Blade Template + Tailwind CSS (CDN)
- **Interactivity**: JavaScript + AlpineJS
- **Database**: MySQL (Laragon / phpMyAdmin / HeidiSQL)
- **Version Control**: Git & GitHub

---

## 📂 Installation (Local)

### 1) Clone Repository
```bash
git clone https://github.com/Farmil23/MyMupi.git
cd MyMupi
