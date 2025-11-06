# 🏨 Hotelio - Sistem Reservasi Hotel Berbasis Web

**Hotelio** adalah aplikasi web untuk manajemen hotel modern yang dikembangkan menggunakan **Laravel 10** dan **Tailwind CSS**.  
Aplikasi ini menyediakan sistem **reservasi kamar**, **pengelolaan pengguna**, dan **manajemen fasilitas** dengan antarmuka yang bersih, responsif, dan mudah digunakan.

---

## 🚀 Fitur Utama

### 👤 Guest (Tamu)
- Melihat daftar kamar yang tersedia  
- Melihat detail kamar dan fasilitas lengkap  
- Melakukan reservasi kamar  
- Melihat daftar reservasi pribadi  
- Melihat detail reservasi dan status  

### 🧾 Receptionist
- Melihat dan mengelola daftar reservasi  
- Mengubah status reservasi (pending, confirmed, check-in, completed, cancelled)  
- Melihat detail tamu dan pemesanan  

### 🛠️ Admin
- Dashboard statistik hotel (jumlah kamar, total reservasi, total pendapatan)  
- CRUD data kamar (Tambah, Edit, Hapus, Detail)  
- CRUD data fasilitas kamar  
- Manajemen pengguna (ubah role: admin, receptionist, user)  
- Kelola semua data reservasi  

---

## 🧩 Teknologi yang Digunakan

| Teknologi | Deskripsi |
|------------|------------|
| **Laravel 10** | Framework backend utama |
| **Tailwind CSS** | Framework CSS utility-first |
| **Alpine.js** | Interaktivitas ringan pada frontend |
| **MySQL** | Database utama |
| **Blade Components** | Komponen UI reusable |
| **Lucide Icons** | Ikon SVG modern |
| **Eloquent ORM** | Manajemen relasi data antar tabel |

---

## ⚙️ Cara Instalasi & Setup

### 1️⃣ Clone Repository
```bash
git clone https://github.com/username/hotelio.git
cd hotelio
2️⃣ Install Dependencies
bash
Copy code
composer install
npm install
3️⃣ Buat File .env
bash
Copy code
cp .env.example .env
Lalu sesuaikan konfigurasi database:

env
Copy code
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotelio_db
DB_USERNAME=root
DB_PASSWORD=
4️⃣ Generate App Key
bash
Copy code
php artisan key:generate
5️⃣ Jalankan Migrasi & Seeder
bash
Copy code
php artisan migrate --seed
Seeder akan membuat:

Admin default:

Email: admin@hotelio.com

Password: password

Contoh kamar dan fasilitas

6️⃣ Jalankan Server
bash
Copy code
php artisan serve
npm run dev
Buka di browser:
👉 http://localhost:8000

📦 Struktur Folder Penting
cpp
Copy code
app/
 ├─ Http/
 │   ├─ Controllers/
 │   │   ├─ AuthController.php
 │   │   ├─ AdminController.php
 │   │   ├─ GuestController.php
 │   │   ├─ ReceptionistController.php
 │   │   ├─ RoomController.php
 │   │   ├─ ReservationController.php
 │   │   └─ FacilityController.php
 │   └─ Requests/
 ├─ Models/
 └─ Views/
     ├─ private/
     │   ├─ admin/
     │   ├─ guest/
     │   └─ receptionist/
     └─ components/
🧱 Database Schema (Ringkasan)
Tabel	Deskripsi
users	Data pengguna (admin, receptionist, user)
rooms	Data kamar hotel
facilities	Daftar fasilitas
facility_room	Pivot antara rooms dan facilities
reservations	Data pemesanan dan status

🔒 Roles & Permissions
Role	Akses
Admin	Semua fitur (CRUD, Manajemen User, Dashboard)
Receptionist	Kelola Reservasi & Check-in/out
User (Guest)	Reservasi dan lihat riwayat

💻 Beberapa Tampilan Utama
🏠 Beranda
Hero Section dengan CTA “Mulai Sekarang”

Tentang Kami (About)

Fasilitas Hotel

Daftar Kamar Tersedia

Kontak & Lokasi

🔑 Autentikasi
Login & Register dengan validasi

Redirect otomatis sesuai role (Admin / Receptionist / User)

📊 Dashboard Admin
Statistik total kamar, pendapatan, dan jumlah pengguna

Menu navigasi cepat (Kamar, Reservasi, Fasilitas, User)

🧾 Reservasi Tamu
Daftar reservasi dengan status

Detail reservasi lengkap (tanggal, harga, status, total)

🧑‍💻 Kontributor
Nama	Peran
[Nama Kamu]	Fullstack Developer

🪶 Lisensi
Proyek ini bersifat open-source dan dilisensikan di bawah MIT License.
Silakan gunakan, ubah, dan kembangkan sesuai kebutuhan Anda.

❤️ Kredit
Dibuat dengan Laravel, TailwindCSS, dan banyak kopi ☕ oleh
Nama Kamu

📸 Preview (Opsional)
Tambahkan screenshot aplikasi kamu di sini agar lebih menarik di GitHub:

markdown
Copy code
![Hotelio Landing Page](public/images/screenshots/landing.png)
![Dashboard Admin](public/images/screenshots/dashboard.png)
![Reservasi User](public/images/screenshots/reservasi.png)
yaml
Copy code

---

