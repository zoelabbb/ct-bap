# 🚀 Laravel 12 User CRUD Management System

> **Sistem manajemen user dengan fitur CRUD lengkap menggunakan Laravel 12, Livewire, dan TailwindCSS**

![Laravel](https://img.shields.io/badge/Laravel-12.20.0-FF2D20?style=for-the-badge&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=for-the-badge&logo=livewire)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css)
![SQLite](https://img.shields.io/badge/SQLite-3.x-003B57?style=for-the-badge&logo=sqlite)

## 📋 Deskripsi Project

Aplikasi web modern untuk manajemen user dengan fitur CRUD (Create, Read, Update, Delete). Dibangun menggunakan Laravel 12 dengan performa dan user experience yang optimal.

### ✨ Key Features

-   🔍 **Advanced Search** - Pencarian real-time dengan debounce
-   📄 **Smart Pagination** - 5 item per halaman dengan query string persistence
-   ⚡ **Performance Monitoring** - Real-time query speed display
-   🛡️ **Business Logic** - Validasi khusus untuk operasi delete
-   📱 **Responsive Design** - Mobile-friendly dengan TailwindCSS
-   🔐 **UUID Primary Keys** - Modern database design
-   📊 **Database Indexing** - Optimized untuk ribuan data

## 🏗️ Tech Stack

### Backend

-   **Laravel 12.20.0** - PHP Framework terbaru
-   **Livewire 3.x** - Full-stack framework untuk Laravel
-   **SQLite** - Lightweight database
-   **Eloquent ORM** - Database abstraction layer

### Frontend

-   **TailwindCSS 3.x** - Utility-first CSS framework
-   **Alpine.js** - Lightweight JavaScript framework
-   **Vite** - Fast build tool
-   **Blade Templates** - Laravel templating engine

### Development Tools

-   **Laravel Artisan** - Command line interface
-   **Laravel Tinker** - Interactive shell
-   **Composer** - Dependency management
-   **NPM** - Package management

## 📊 Database Schema

### Users Table

```sql
Column          Type        Constraints
-----------------------------------------
id              UUID        PRIMARY KEY
name            VARCHAR     NOT NULL (min: 3 chars)
address         VARCHAR     NOT NULL (min: 3 chars)
email           VARCHAR     UNIQUE
password        VARCHAR     HASHED
created_at      TIMESTAMP   INDEXED
updated_at      TIMESTAMP
```

### Database Indexes

```sql
-- Performance optimization indexes
idx_users_name              (name)
idx_users_created_at        (created_at)
idx_users_name_created_at   (name, created_at)
```

## 🎯 Business Logic

### Validation Rules

-   **Name**: Minimum 3 characters, required
-   **Address**: Minimum 3 characters, required
-   **UUID**: Auto-generated untuk setiap user baru

### Delete Protection

```php
// Users dengan nama mengandung huruf "a" atau "A" tidak dapat dihapus
if (stripos($user->name, 'a') !== false) {
    throw new BusinessException('Cannot delete user with "a" in name');
}
```

## 🚀 Installation & Setup

### Prerequisites

-   PHP 8.2+
-   Composer
-   Node.js & NPM
-   SQLite

### 1. Clone & Install

```bash
git clone https://github.com/zoelabbb/ct-bap.git
cd ct-bap
composer install
npm install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup

```bash
# Create SQLite database
touch database/database.sqlite

# Run migrations with indexes
php artisan migrate

# Seed with 1000 sample users
php artisan db:seed
```

### 4. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 5. Start Server

```bash
php artisan serve
```

Aplikasi akan tersedia di: `http://127.0.0.1:8000`

## 🎮 Usage Guide

### User Management Routes

```php
GET  /users              // List all users with search & pagination
GET  /users/create       // Create new user form
GET  /users/{user}/edit  // Edit existing user form
```

### Search & Filter

-   **Real-time Search**: Ketik di search box untuk filter berdasarkan nama
-   **URL Persistence**: Search terms dan halaman tersimpan di URL
-   **Performance**: Query speed ditampilkan real-time

### CRUD Operations

#### Create User

1. Klik "Tambah User"
2. Isi form (nama & alamat minimum 3 karakter)
3. UUID akan auto-generate
4. Submit untuk simpan

#### Search Users

1. Gunakan search box di halaman utama
2. Hasil filter otomatis dengan debounce 300ms
3. Pagination reset ke halaman 1 saat search baru

#### Edit User

1. Klik "Edit" pada user yang diinginkan
2. Form ter-populate dengan data existing
3. Update dan submit

#### Delete User

1. Klik "Hapus" pada user
2. Konfirmasi dengan popup
3. Sistem cek business logic (nama dengan "a/A" tidak bisa dihapus)
4. Flash message untuk feedback

## ⚡ Performance Optimization

### Query Optimization

-   **Select Specific Columns**: Hanya ambil kolom yang diperlukan
-   **Strategic Indexing**: 3 index untuk pattern query yang sering digunakan
-   **Efficient Pagination**: LIMIT/OFFSET dengan index support
-   **Conditional Queries**: Avoid unnecessary WHERE clause

### Performance Metrics

```
With 1,000+ users:
- Normal pagination: ~5ms (EXCELLENT)
- Search pagination: ~35ms (VERY GOOD)
- Memory usage: Optimized with pagination
- Database size: Efficiently indexed
```

## 🏗️ Architecture

### MVC Pattern

```
├── Models/
│   └── User.php                 # Eloquent model with UUID
├── Controllers/
│   └── Livewire/
│       ├── UserIndex.php        # List, search, delete
│       └── UserForm.php         # Create & edit
├── Views/
│   ├── livewire/
│   │   ├── user-index.blade.php
│   │   └── user-form.blade.php
│   └── components/layouts/
│       └── user.blade.php       # Layout template
└── Routes/
    └── web.php                  # Public routes (no auth required)
```

### Database Layer

```
├── Migrations/
│   ├── create_users_table.php   # Main table structure
│   └── add_indexes_to_users_table.php  # Performance indexes
├── Factories/
│   └── UserFactory.php          # Test data generation
└── Seeders/
    ├── UserSeeder.php           # 1000 sample users
    └── DatabaseSeeder.php       # Master seeder
```

## 🔧 Configuration

### Sample Data

-   **1000 Users** dengan Faker data
-   **Berbagai nama** untuk testing search
-   **Mixed data** untuk testing business logic

## 📈 Scalability

### Database Performance

-   ✅ **1,000 users**: <10ms queries
-   ✅ **10,000 users**: <50ms queries
-   ✅ **100,000 users**: <100ms queries
-   ⚠️ **1M+ users**: Perlu additional optimization

### Optimization Recommendations

-   **Redis Caching** untuk frequently accessed data
-   **Database Partitioning** untuk million+ records
-   **CDN** untuk static assets
-   **Load Balancing** untuk high traffic

## 🛡️ Security Features

### Input Validation

-   **Server-side validation** dengan Laravel rules
-   **XSS Protection** dengan Blade escaping
-   **SQL Injection Prevention** dengan Eloquent ORM
-   **CSRF Protection** dengan Laravel tokens

### Data Protection

-   **Mass Assignment Protection** dengan fillable
-   **Password Hashing** dengan bcrypt
-   **UUID Primary Keys** mencegah enumeration attacks

## 📝 Development Notes

### Code Quality

-   **PSR Standards** untuk PHP code style
-   **Single Responsibility** principle
-   **DRY (Don't Repeat Yourself)** pattern
-   **Clean Code** practices

### Best Practices Applied

-   ✅ **Database Indexing** untuk performance
-   ✅ **Query Optimization** untuk scalability
-   ✅ **Component Reusability** untuk maintainability
-   ✅ **Error Handling** untuk reliability
-   ✅ **Performance Monitoring** untuk optimization

## 📞 Support

### Developer Contact

-   **Project**: Laravel User CRUD System - CT BAP
-   **Author**: Alif Ryuu
-   **Email**: alifryuuofficial@gmail.com
-   **Version**: 1.0.0
-   **Created**: July 2025
-   **Laravel Version**: 12.20.0

### Documentation

-   [Laravel Documentation](https://laravel.com/docs)
-   [Livewire Documentation](https://livewire.laravel.com)
-   [TailwindCSS Documentation](https://tailwindcss.com/docs)

---

**Built with ❤️ using Laravel 12 + Livewire + TailwindCSS**

> _"Clean code, optimal performance, modern architecture"_
