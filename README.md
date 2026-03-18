# Hướng dẫn sử dụng

Sau khi `git clone`, thực hiện các bước sau:

---

## 1. Cài đặt thư viện cần thiết

```bash
composer install
npm install
```

## 2. Cấu hình môi trường

```bash
cp .env.example .env
php artisan key:generate
```

Sau bước này, mở file .env lên và chỉnh sửa thông tin database (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

## 3. Tạo DB & Seeder

```bash
php artisan migrate:fresh --seed
```

## 4. Chạy thử

```bash
// Terminal 1: Chạy laravel
php artisan serve
// Terminal 2: Chạy Tailwind/Vite - Bắt buộc để có giao diện
npm run dev
```

Truy cập vào: 127.0.0.1:8000
