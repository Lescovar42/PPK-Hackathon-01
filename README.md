# Jara - Collaborative Task Management Platform

**Jara** is a lightweight, fast, and secure collaborative task management web platform. Designed for simplicity, it allows individuals and teams to organize tasks, track deadlines, and manage project members efficiently.

---

## 🚀 Core Features

1. **Project & Task Management:** Create projects, add tasks with deadlines, and toggle completion status.
2. **Team Collaboration:** Project Owners can invite members to collaborate and track progress.
3. **System Administration:** Admins can easily manage, add, and remove user accounts.
4. **[NEW] Atomic Deletion:** Secure cascading deletion of projects, tasks, and members using Database Transactions.
5. **[NEW] Robust Security:** Strict role-based authorization (Owner vs. Member) and Prepared Statements to prevent SQL Injection.

---

## 📋 Software Requirements Specification (SRS)

### 1. User Roles (Peran Pengguna)
- **Admin:** Administrator sistem yang bertanggung jawab mengelola (menambah dan menghapus) akun pengguna secara global.
- **Owner (Pemilik Daftar):** Pengguna yang membuat suatu daftar tugas/proyek. Memiliki hak penuh untuk menambah anggota dan menghapus daftar tersebut.
- **Member (Anggota Daftar):** Pengguna yang diundang oleh Owner ke dalam sebuah daftar untuk berkolaborasi, mengerjakan tugas, dan memantau progres penyelesaian.

### 2. Functional Requirements (Kebutuhan Fungsional)
- **FR-1 (Manajemen Tugas):** Sistem memungkinkan pengguna membuat, mengelompokkan, dan mengatur tugas ke dalam daftar proyek. Pengguna dapat menetapkan tenggat waktu (deadline) dan mengubah status tugas menjadi selesai.
- **FR-2 (Manajemen Akun):** Sistem menyediakan antarmuka bagi Admin untuk menambah atau menghapus akun pengguna dari sistem.
- **FR-3 (Otomatisasi Kepemilikan):** Sistem harus secara otomatis menetapkan pengguna yang membuat daftar tugas baru sebagai "Owner" dari daftar tersebut.
- **FR-4 (Hapus Kaskade):** Owner dapat menghapus daftar tugas miliknya. Sistem wajib menghapus daftar tersebut beserta seluruh tugas dan data keanggotaan di dalamnya secara otomatis (kaskade).

### 3. Non-Functional Requirements (Kebutuhan Non-Fungsional)
- **NFR-1 (Atomicity):** Proses penghapusan daftar dan isinya (FR-4) wajib dieksekusi dalam satu Transaksi Database (*Database Transaction*). Jika salah satu proses penghapusan gagal, seluruh perubahan harus dibatalkan (*Rollback*).
- **NFR-2 (Otorisasi):** Sistem harus memvalidasi hak akses sebelum mengeksekusi aksi penting. Permintaan manipulasi data dari pihak yang tidak berwenang (misal: Member mencoba menghapus daftar) wajib ditolak.
- **NFR-3 (Keamanan Data):** Seluruh input dari pengguna wajib divalidasi dengan ketat, dan seluruh interaksi dengan database wajib menggunakan *Prepared Statements* untuk mencegah celah keamanan *SQL Injection*.

---

## 🛠️ Tech Stack

- **Backend:** Laravel (PHP)
- **Database:** SQLite / MySQL
- **Frontend:** Blade Templates, Tailwind CSS

---

## ⚙️ Quick Start & Local Setup (WSoD Prevention)

To avoid the White Screen of Death (WSoD) or database errors, follow these steps exactly:

```bash
# 1. Clone the repository
git clone [https://github.com/Lescovar42/PPK-Hackathon-01.git](https://github.com/Lescovar42/PPK-Hackathon-01.git)
cd PPK-Hackathon-01

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Setup Environment
cp .env.example .env
php artisan key:generate

# 4. Database Setup (Crucial - Resets DB and applies fresh schema)
php artisan migrate:fresh --seed

# 5. Run the server
php artisan serve
```


## 👨‍💻 Sprint: Stabilization & Security (1 Hour)

To prevent Git merge conflicts, the current sprint is strictly divided. **Do not modify files outside your assigned scope.**

| Crew | Focus Area | Core Responsibilities | Assigned Branch |
| :--- | :--- | :--- | :--- |
| **Dev 1** | **Legacy CRUD** | Fix previous WSoD. Ensure Task, Project, and Admin CRUD works. | `fix/legacy-crud` |
| **Dev 2** | **Atomic Actions** | Auto-assign Ownership. Build Atomic Cascade Delete for Projects. | `feat/atomic-delete` |
| **Dev 3** | **Security & Auth** | Implement Auth Middleware (Owner-only actions). Apply Prepared Statements. | `feat/security-auth` |

### 🌿 Git Workflow
1. Start from the main branch after the PM resolves the WSoD.
2. `git checkout -b <your-branch-name>`.
3. Code within your assigned Controllers/Models.
4. Merge sequentially: **Dev 1** ➔ **Dev 2** ➔ **Dev 3**.