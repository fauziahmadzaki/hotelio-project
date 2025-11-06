# 🏨 Hotelio - Sistem Reservasi Hotel Berbasis Web

Hotelio adalah aplikasi manajemen hotel berbasis web yang dikembangkan menggunakan **Laravel 10** dan **Tailwind CSS**, dengan fitur lengkap untuk **admin**, **resepsionis**, dan **tamu** (guest).  
Aplikasi ini dirancang agar mudah digunakan, mobile-friendly, dan memiliki tampilan modern.

---

## 🚀 Fitur Utama

### 👤 Guest (Tamu)
- Melihat daftar kamar yang tersedia  
- Melihat detail kamar beserta fasilitas  
- Melakukan reservasi kamar  
- Melihat daftar reservasi pribadi  
- Melihat detail reservasi & status  

### 🧾 Receptionist
- Melihat dan mengelola daftar reservasi  
- Melihat detail tamu & status pembayaran  
- Mengupdate status check-in / check-out  

### 🛠️ Admin
- Dashboard statistik (jumlah reservasi, total pendapatan, dll)  
- CRUD data kamar (Tambah, Edit, Hapus, Detail)  
- CRUD fasilitas kamar  
- Manajemen pengguna (ubah role: admin, receptionist, user)  

---

## 🧩 Teknologi yang Digunakan

| Teknologi | Deskripsi |
|------------|------------|
| **Laravel 10** | Framework backend utama |
| **Tailwind CSS** | Styling dan layout responsif |
| **Alpine.js** | Interaksi frontend ringan |
| **MySQL** | Database utama |
| **Blade Components** | Template modular dan reusable |
| **Lucide Icons** | Ikon ringan dan modern |
| **Eloquent ORM** | Manajemen relasi antar tabel |

---

## ⚙️ Instalasi dan Setup

### 1️⃣ Clone Repository
```bash
git clone https://github.com/username/hotelio.git
cd hotelio
composer install
npm install
