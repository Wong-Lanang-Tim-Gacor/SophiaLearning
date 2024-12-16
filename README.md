# 🚀 Step By Step Setup: SophiaLearning

## Backend Application 🖥️

### 1️⃣ Clone Repository

Mulai dengan meng-clone repository **Backend**:

```bash
git clone https://github.com/Wong-Lanang-Tim-Gacor/SophiaLearning
```

### 2️⃣ Masuk ke Folder Project

Masuk ke dalam folder **SophiaLearning**:

```bash
cd SophiaLearning
```

### 3️⃣ Install Dependencies

Install semua dependencies yang diperlukan:

```bash
composer install
```

### 4️⃣ Konfigurasi `.env` File

Buat file `.env` dengan cara mengganti nama file `.env.example` menjadi `.env`.

```bash
cp .env.example .env
```

### 5️⃣ Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi berikut untuk database dan file storage:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sophia-learning
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

### 6️⃣ Jalankan Perintah Setup

Setelah file `.env` terkonfigurasi, buka terminal dan jalankan perintah berikut untuk menyiapkan aplikasi:

```bash
php artisan key:generate 
php artisan storage:link
php artisan migrate:fresh --seed
```

### 7️⃣ Jalankan Server

Setelah setup selesai, jalankan server dengan perintah berikut:

```bash
php artisan serve
```

---

## Frontend Application 🌐

### 1️⃣ Clone Repository

Clone repository **Frontend**:

```bash
git clone https://github.com/Wong-Lanang-Tim-Gacor/SophiaLearning-FE
```

### 2️⃣ Masuk ke Folder Frontend

Masuk ke dalam folder **SophiaLearning-FE**:

```bash
cd SophiaLearning-FE
```

### 3️⃣ Install Dependencies

Install semua dependencies yang dibutuhkan dengan salah satu dari dua pilihan berikut:

```bash
npm install   # jika menggunakan npm
yarn install  # jika menggunakan yarn
```

### 4️⃣ Konfigurasi `Constant.jsx`

Sesuaikan URL API dan lokasi file assets sesuai dengan server backend yang Anda gunakan. Buka file `src/Utils/Constant.jsx` dan ubah:

```jsx
export const BASE_API = 'https://api.yourdomain.com/api'  // ganti sesuai dengan server backend
export const ASSETS_URL = 'https://api.yourdomain.com/storage/' // ganti dengan URL server Anda
```

### 5️⃣ Jalankan Server Frontend

Sekarang jalankan server frontend:

```bash
npm run dev
```

---

## 🚧 Troubleshooting

- **Masalah Database**: Pastikan konfigurasi database di `.env` sudah benar dan MySQL sudah berjalan.
- **Masalah Dependency**: Jika ada error saat instalasi dependency, coba jalankan `composer update` atau `npm update` terlebih dahulu.
- **Masalah Server**: Jika server tidak berjalan, pastikan port yang digunakan tidak bentrok dengan aplikasi lain.

---

💬 **Pertanyaan atau Masalah?**  
Buka [issues page](https://github.com/Wong-Lanang-Tim-Gacor/SophiaLearning/issues) dan ajukan pertanyaan Anda!
