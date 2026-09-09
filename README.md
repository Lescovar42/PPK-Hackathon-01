# Jara - Collaborative Task Management Platform

[![PHP Version](https://img.shields.io/badge/PHP-8.5%2B-777BB4?logo=php&logoColor=white)](https://php.net)
[![Laravel Framework](https://img.shields.io/badge/Laravel-13.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Database](https://img.shields.io/badge/Database-SQLite-003B57?logo=sqlite&logoColor=white)](https://sqlite.org)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

**Jara** is a modern, lightweight collaborative task and project management web platform built on Laravel and SQLite. Engineered for speed, simplicity, and teamwork, Jara enables individuals and distributed teams to organize complex projects, track deliverables against deadlines, monitor real-time completion progress, and administer user access through clear role boundaries.

---

## Table of Contents

- [Overview](#overview)
- [Core Features](#core-features)
  - [1. Task & Project Management](#1-task--project-management)
  - [2. Team Collaboration & Progress Monitoring](#2-team-collaboration--progress-monitoring)
  - [3. System Administration](#3-system-administration)
- [User Roles & Access Matrix](#user-roles--access-matrix)
- [Database Schema & Data Models](#database-schema--data-models)
- [Tech Stack & Prerequisites](#tech-stack--prerequisites)
- [Installation & Local Setup Guide](#installation--local-setup-guide)
- [Modular Architecture & Conflict Prevention](#modular-architecture--conflict-prevention)
- [Team Structure & Feature Allocation](#team-structure--feature-allocation)
- [Testing & Quality Assurance](#testing--quality-assurance)
- [License](#license)

---

## Overview

In fast-paced collaborative environments, teams require clear visibility into project milestones, accountable task ownership, and seamless tracking of progress. **Jara** addresses these challenges by delivering:

- **Centralized Workspaces:** Manage personal tasks and team initiatives within unified, structured projects.
- **Actionable Deadlines:** Prevent delays with explicit deadline tracking and instant task status toggles.
- **Transparent Progress:** Automatic percentage-based progress calculations reflecting completed vs. pending tasks.
- **Role-Governed Collaboration:** Granular separation of duties between System Administrators, Project Owners, and Team Members.
- **Merge-Conflict Resilient Architecture:** Modular routing and decoupled MVC components designed for smooth concurrent multi-developer workflows.

---

## Core Features

### 1. Task & Project Management

- **Project Organization:** Create, view, update, and organize projects into dedicated workspaces with custom metadata.
- **Task List Management:** Create, structure, and categorize tasks under associated projects.
- **Deadline Tracking:** Explicit date and time scheduling for deliverables to support proactive milestone management and overdue alerts.
- **Status Toggle:** Quick status toggling between incomplete and completed states with instant database persistence.

### 2. Team Collaboration & Progress Monitoring

- **Member Assignment:** Project Owners can associate and disassociate team members with specific projects via the `project_user` relationship.
- **Real-Time Progress Metrics:** Automated dynamic calculation of project progress percentage (`progress %`) based on completed tasks:

  $$
  \text{Progress \%} = \left( \frac{\text{Completed Tasks}}{\text{Total Tasks}} \right) \times 100
  $$

  *(Formula: `Progress % = (Completed Tasks / Total Tasks) × 100`)*

  > **Zero-Task Edge Case:** When a project contains zero tasks (`Total Tasks = 0`), the progress percentage safely defaults to `0%` to avoid division by zero errors (`$total > 0 ? round(($completed / $total) * 100) : 0`).

- **Workload & Accountability Visibility:** Clear dashboard representation of active contributors and remaining deliverables per project.

### 3. System Administration

- **User Account Lifecycle:** Administrative dashboard allowing system admins to view, create, update, and delete user accounts.
- **Role & Permission Management:** Centralized assignment and enforcement of user privilege tiers (`admin` vs. standard `user`).
- **Platform Oversight & Governance:** Global visibility into system health, active users, and system-wide project allocations.

---

## User Roles & Access Matrix

Jara implements a hierarchical role and permission structure ensuring operational security and separation of responsibilities:

| Capability / Action | Administrator | Project Owner | Member |
| :--- | :---: | :---: | :---: |
| Access Admin Dashboard (`/admin`) | ✅ Yes | ❌ No | ❌ No |
| Create, List & Delete Users | ✅ Yes | ❌ No | ❌ No |
| Assign & Update User Roles | ✅ Yes | ❌ No | ❌ No |
| Global Project Oversight (All Projects) | ✅ Yes | ❌ No | ❌ No |
| Create New Projects | ✅ Yes | ✅ Yes | ❌ No |
| Edit / Archive Owned Projects | ✅ Yes | ✅ Yes (Owned) | ❌ No |
| Assign / Remove Project Members | ✅ Yes | ✅ Yes (Owned) | ❌ No |
| Create & Assign Tasks | ✅ Yes | ✅ Yes (Owned) | ✅ Yes (Assigned) |
| Toggle Task Status (`is_done`) | ✅ Yes | ✅ Yes (Owned) | ✅ Yes (Assigned) |
| View Project Progress & Tasks | ✅ Yes | ✅ Yes (Owned) | ✅ Yes (Assigned) |

### Role Definitions

- **Administrator (`admin`):** Superuser with platform-wide administrative authority. Responsible for account onboarding, security policies, role elevation, and system auditability.
- **Project Owner (`user` with project ownership):** The creator or designated lead of a project. Possesses full management rights over their project scope, including adding team collaborators, setting schedules, and directing task pipelines.
- **Member (`user` assigned to project):** Active team contributor. Collaborates within assigned projects, creates actionable task items, updates progress, and marks deliverables complete.

---

## Database Schema & Data Models

Jara uses SQLite with Eloquent ORM. To ensure architectural alignment across all feature crews, the entity schemas and relationships are defined below:

| Table | Column | Type | Attributes & Description |
| :--- | :--- | :--- | :--- |
| **`users`** | `id` | `BIGINT` | Primary Key, Auto Increment |
| | `name` | `VARCHAR(255)` | User full name |
| | `email` | `VARCHAR(255)` | Unique user email address |
| | `password` | `VARCHAR(255)` | Bcrypt-hashed password |
| | `role` | `VARCHAR(50)` | Privilege tier: `'admin'` or `'user'` (Default: `'user'`) |
| | `created_at`, `updated_at` | `TIMESTAMP` | Standard Laravel timestamps |
| **`projects`** | `id` | `BIGINT` | Primary Key, Auto Increment |
| | `name` | `VARCHAR(255)` | Project title |
| | `description` | `TEXT` | Nullable project scope description |
| | `owner_id` | `BIGINT` | Foreign Key referencing `users.id` (`onDelete('cascade')`) |
| | `created_at`, `updated_at` | `TIMESTAMP` | Standard Laravel timestamps |
| **`tasks`** | `id` | `BIGINT` | Primary Key, Auto Increment |
| | `project_id` | `BIGINT` | Foreign Key referencing `projects.id` (`onDelete('cascade')`) |
| | `assigned_to` | `BIGINT` | Nullable Foreign Key referencing `users.id` (`onDelete('set null')`) |
| | `title` | `VARCHAR(255)` | Task title / deliverable name |
| | `description` | `TEXT` | Nullable task implementation notes |
| | `deadline` | `DATETIME` | Nullable target completion date and time |
| | `is_done` | `BOOLEAN` | Completion flag (Default: `false`) |
| | `created_at`, `updated_at` | `TIMESTAMP` | Standard Laravel timestamps |
| **`project_user`** | `id` | `BIGINT` | Primary Key, Auto Increment |
| | `project_id` | `BIGINT` | Foreign Key referencing `projects.id` (`onDelete('cascade')`) |
| | `user_id` | `BIGINT` | Foreign Key referencing `users.id` (`onDelete('cascade')`) |
| | `created_at`, `updated_at` | `TIMESTAMP` | Unique constraint on `(project_id, user_id)` |

### Eloquent Model Relationships

- **User Model (`app/Models/User.php`):**
  - `hasMany(Project::class, 'owner_id')` — Projects created/owned by the user.
  - `belongsToMany(Project::class, 'project_user')` — Projects where the user is an assigned collaborator.
  - `hasMany(Task::class, 'assigned_to')` — Tasks specifically assigned to the user.
- **Project Model (`app/Models/Project.php`):**
  - `belongsTo(User::class, 'owner_id')` — Project owner.
  - `belongsToMany(User::class, 'project_user')` — Enrolled project team members.
  - `hasMany(Task::class)` — All tasks belonging to the project workspace.
- **Task Model (`app/Models/Task.php`):**
  - `belongsTo(Project::class)` — Parent project.
  - `belongsTo(User::class, 'assigned_to')` — Assigned assignee.

---

## Tech Stack & Prerequisites

### Technology Stack

- **Backend Framework:** [Laravel 13](https://laravel.com) (PHP Web Application Framework)
- **Language Runtime:** PHP 8.5+ (Command Line & Web Server)
- **Database:** SQLite 3 (Zero-configuration, lightweight transactional engine)
- **Frontend & Templating:** Blade Templating Engine, Tailwind CSS, Vite
- **Package Management:** Composer 2.x (PHP), NPM (Node.js LTS)
- **Testing Suite:** PHPUnit

### Prerequisites

Before running the application, ensure your environment meets the following specifications:

1. **PHP:** Version `>= 8.5` with extensions:
   - `pdo_sqlite`
   - `mbstring`
   - `openssl`
   - `tokenizer`
   - `xml`
   - `ctype`
   - `curl`
2. **Composer:** Version `>= 2.2`
3. **Node.js & NPM:** Node `>= 18.x` and NPM `>= 9.x`
4. **SQLite:** SQLite 3.x installed and accessible

---

## Installation & Local Setup Guide

Follow these step-by-step instructions to clone, configure, and serve the application locally:

### 1. Clone & Navigate to Repository

```bash
git clone https://github.com/Lescovar42/PPK-Hackathon-01.git
cd PPK-Hackathon-01
```

### 2. Install Backend Dependencies

Install required PHP packages using Composer:

```bash
composer install
```

### 3. Initialize Directory Structure (Fresh Clone Setup)

In the initial repository skeleton, core application folders (`Http/`, `Models/`, `Providers/`) reside at root level. To ensure Laravel's PSR-4 class autoloading (`App\` mapping to `app/`) functions seamlessly, organize them into the standard `app/` folder:

**Cross-Platform (PHP CLI - Recommended):**

```bash
php -r "is_dir('app') || mkdir('app'); is_dir('Http') && rename('Http', 'app/Http'); is_dir('Models') && rename('Models', 'app/Models'); is_dir('Providers') && rename('Providers', 'app/Providers');"
composer dump-autoload
```

**macOS / Linux:**

```bash
mkdir -p app && mv Http Models Providers app/
composer dump-autoload
```

**Windows (PowerShell):**

```powershell
New-Item -ItemType Directory -Force -Path app; Move-Item Http, Models, Providers app/ -Force
composer dump-autoload
```

**Windows (Command Prompt / CMD):**

```cmd
if not exist app mkdir app & move Http app\ & move Models app\ & move Providers app\
composer dump-autoload
```

### 4. Configure Environment Variables

Copy the example environment configuration to create your local `.env`:

**Cross-Platform (PHP CLI - Recommended):**

```bash
php -r "file_exists('.env') || copy('.env.example', '.env');"
```

**macOS / Linux:**

```bash
cp .env.example .env
```

**Windows (PowerShell):**

```powershell
Copy-Item .env.example .env
```

**Windows (Command Prompt / CMD):**

```cmd
copy .env.example .env
```

Verify that the database connection in `.env` is configured for SQLite:

```env
DB_CONNECTION=sqlite
# DB_DATABASE is automatically resolved to database/database.sqlite
```

*(Note: In Laravel, leaving `DB_DATABASE` commented out automatically resolves to `database/database.sqlite`)*

### 5. Generate Application Key

Generate the unique encryption key for the application:

```bash
php artisan key:generate
```

### 6. Initialize SQLite Database

Ensure the SQLite database file exists in the `database` folder:

**Cross-Platform (PHP CLI - Recommended):**

```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

**macOS / Linux:**

```bash
touch database/database.sqlite
```

**Windows (PowerShell):**

```powershell
if (-not (Test-Path database/database.sqlite)) {
    New-Item -ItemType File -Path database/database.sqlite -Force
}
```

**Windows (Command Prompt / CMD):**

```cmd
if not exist database\database.sqlite type nul > database\database.sqlite
```

### 7. Run Migrations & Seed Default Data

Execute the database schema migrations and load default seed records:

```bash
php artisan migrate --seed
```

> **Note:** To completely wipe and rebuild the database with clean seed records at any time, run:
>
> ```bash
> php artisan migrate:fresh --seed
> ```

#### Seeded Test Accounts

The starter seeder (`DatabaseSeeder`) provisions the following default test accounts:

| Role | Email | Password | Initial Status |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@jara.test` | `password` | System Admin (`admin`) |
| **Standard User** | `budi@jara.test` | `password` | Team Member / Project Owner (`user`) |
| **Standard User** | `siti@jara.test` | `password` | Team Member / Collaborator (`user`) |

- **Default Password for All Accounts:** `password`
- **Initial Test Data:** Includes 1 sample project with 2 pre-populated dummy tasks.
- *(Note: Seed records are defined in `database/seeders/DatabaseSeeder.php` as part of the starter dataset specification managed by the PM)*

### 8. Install & Compile Frontend Assets

Install Node.js packages and build application assets via Vite:

```bash
npm install
npm run build
```

For active frontend development with Hot Module Replacement (HMR):

```bash
npm run dev
```

### 9. Start the Local Server

You can start the local development environment using either method below:

#### Method A: Concurrent Dev Server (Recommended)

Run the built-in concurrent development script which manages the Laravel application server and Vite asset bundler simultaneously in a single terminal:

```bash
composer run dev
```

*(Alternatively: `php artisan dev`)*

#### Method B: Traditional Dual-Terminal Server

If running processes in separate terminal windows:

**Terminal 1 (Backend Server):**

```bash
php artisan serve
```

**Terminal 2 (Vite Asset Server):**

```bash
npm run dev
```

Once started, the application will be accessible at `http://127.0.0.1:8000` (or `http://localhost:8000`).

---

### Quick Setup Alternative (One-Command Automated)

For rapid developer onboarding, the repository provides an automated Composer setup script that executes dependency installation, environment creation, key generation, database migration, and asset compilation in sequence:

```bash
composer run setup
```

> **Note for Fresh Clones:** Complete [Step 3: Initialize Directory Structure](#3-initialize-directory-structure-fresh-clone-setup) before executing `composer run setup` so that `AppServiceProvider` and core models resolve cleanly during automated key generation and migration.

---

## Modular Architecture & Conflict Prevention

To allow multiple developers to build features simultaneously without Git merge conflicts, Jara utilizes a decoupled routing and controller architecture:

```text
routes/
├── web.php          # Main aggregator & landing route
├── tasks.php        # Developer 1 (Crew 1): Project & Task CRUD
├── collab.php       # Developer 2 (Crew 2): Member Assignment & Progress
└── admin.php        # Developer 3 (Crew 3): User Management & Role Control
```

Each developer operates strictly within their designated route file, controller, and view directory:

- **`routes/web.php`** imports the modular route files cleanly and defensively:

  ```php
  foreach (['tasks.php', 'collab.php', 'admin.php'] as $file) {
      if (file_exists(__DIR__.'/'.$file)) {
          require __DIR__.'/'.$file;
      }
  }
  ```

- **Isolated Controllers:** `app/Http/Controllers/TaskController.php`, `app/Http/Controllers/CollabController.php`, and `app/Http/Controllers/AdminController.php` maintain strict boundaries of concern.
- **Isolated Views:** View templates are grouped under `resources/views/tasks/`, `resources/views/collab/`, and `resources/views/admin/`.
- **Unified Landing Page:** `resources/views/welcome.blade.php` (or `home.blade.php`) provides quick navigation links to `/tasks`, `/collab`, and `/admin`.

---

## Team Structure & Feature Allocation

The engineering team is structured into clear feature areas to guarantee high development velocity and prevent overlapping work:

```text
                      ┌─────────────────────────┐
                      │     Project Manager     │
                      │   (Architecture & QA)   │
                      └────────────┬────────────┘
                                   │
         ┌─────────────────────────┼─────────────────────────┐
         │                         │                         │
         ▼                         ▼                         ▼
┌─────────────────┐       ┌─────────────────┐       ┌─────────────────┐
│   Developer 1   │       │   Developer 2   │       │   Developer 3   │
│ (Crew 1: Tasks) │       │ (Crew 2: Collab)│       │ (Crew 3: Admin) │
└─────────────────┘       └─────────────────┘       └─────────────────┘
```

| Member / Role | Focus Area | Core Responsibilities | Assigned Artifacts |
| :--- | :--- | :--- | :--- |
| **Project Manager (PM)** | Architecture & QA | Project planning, data modeling, cross-crew integration, documentation | `database/migrations/`, `app/Models/`, `database/seeders/`, `README.md` |
| **Developer 1** (Crew 1) | Task & Project Management | Project & task CRUD, deadline tracking, status toggle (`is_done`) | `routes/tasks.php`, `app/Http/Controllers/TaskController.php`, `resources/views/tasks/` |
| **Developer 2** (Crew 2) | Collaboration & Progress | Member assignment & removal, `project_user` logic, progress % calculation | `routes/collab.php`, `app/Http/Controllers/CollabController.php`, `resources/views/collab/` |
| **Developer 3** (Crew 3) | Administration & Access | User account CRUD, role enforcement (`admin` vs `user`), admin security | `routes/admin.php`, `app/Http/Controllers/AdminController.php`, `resources/views/admin/` |

### Detailed Allocation

- **Project Manager (PM - Architecture & QA):**
  - Project planning, schema modeling, and sprint backlog management.
  - Repository structure maintenance (organizing `app/` and autoload paths).
  - Eloquent models: `app/Models/User.php`, `app/Models/Project.php`, `app/Models/Task.php`.
  - Database migrations: `users` (with `role`), `projects`, `tasks`, and `project_user` pivot table.
  - Seed dataset: `database/seeders/DatabaseSeeder.php` with admin, standard users, and sample tasks.
  - Route aggregation in `routes/web.php` and overall documentation maintenance (`README.md`).
- **Developer 1 (Crew 1 - Tasks & Projects):**
  - **Route Endpoints:** Defined in `routes/tasks.php`:
    - `GET /tasks` — List projects and assigned deliverables.
    - `POST /projects` — Create a new project workspace.
    - `PUT /projects/{project}` — Update project title or description.
    - `POST /projects/{project}/tasks` — Create a task with deadline under a project.
    - `PATCH /tasks/{task}/toggle` — Toggle task completion status (`is_done`).
  - **Controller Actions (`app/Http/Controllers/TaskController.php`):**
    - `index()`: Display project workspaces and associated tasks.
    - `storeProject(Request $request)`: Validate and persist a new project owned by current user.
    - `updateProject(Request $request, Project $project)`: Update project attributes.
    - `storeTask(Request $request, Project $project)`: Create a task under a project with deadline.
    - `toggleTask(Task $task)`: Invert and save the `is_done` boolean flag.
  - **Views:** Blade templates inside `resources/views/tasks/`.
- **Developer 2 (Crew 2 - Collaboration & Progress):**
  - **Route Endpoints:** Defined in `routes/collab.php`:
    - `GET /collab` — Collaboration dashboard with team members and progress metrics.
    - `POST /collab/projects/{project}/members` — Add collaborator to a project.
    - `DELETE /collab/projects/{project}/members/{user}` — Remove collaborator from a project.
  - **Controller Actions (`app/Http/Controllers/CollabController.php`):**
    - `index()`: Display collaboration dashboard with member lists and progress metrics.
    - `addMember(Request $request, Project $project)`: Attach user to project via `project_user` pivot.
    - `removeMember(Project $project, User $user)`: Detach user from project via `project_user` pivot.
  - **Metrics Logic:** Dynamic calculation of project completion percentage:
    - Formula: `$total > 0 ? round(($completed / $total) * 100) : 0`
    - Protects against division by zero when a project has no tasks.
  - **Views:** Blade templates inside `resources/views/collab/`.
- **Developer 3 (Crew 3 - Administration & User Control):**
  - **Route Endpoints:** Defined in `routes/admin.php`:
    - `GET /admin` — Administrative user overview and system metrics.
    - `POST /admin/users` — Create and onboard new user accounts.
    - `PATCH /admin/users/{user}/role` — Assign or change user role (`admin` vs `user`).
    - `DELETE /admin/users/{user}` — Remove user accounts and revoke platform access.
  - **Controller Actions (`app/Http/Controllers/AdminController.php`):**
    - `index()`: Administrative dashboard with user list and role indicators.
    - `storeUser(Request $request)`: Validate and create a user account with hashed password.
    - `updateRole(Request $request, User $user)`: Update user privilege tier (`admin` or `user`).
    - `destroyUser(User $user)`: Delete user account with cascading safety checks.
  - **Access Gate:** Enforce `admin` role authorization middleware on all `/admin` routes.
  - **Views:** Blade templates inside `resources/views/admin/`.

---

## Testing & Quality Assurance

### Execute Automated Test Suite

Run tests with PHPUnit via Artisan:

```bash
php artisan test
```

*(Or use the Composer test script: `composer test`)*

To run specific test suites targeting individual feature modules:

```bash
php artisan test --filter=TaskTest
php artisan test --filter=CollabTest
php artisan test --filter=AdminTest
```

### Verify Route Registration

Verify that all modular routes register cleanly and resolve to their respective controllers:

```bash
php artisan route:list
```

Filter routes by feature area:

```bash
php artisan route:list --path=tasks
php artisan route:list --path=collab
php artisan route:list --path=admin
```

### Code Style Standards

Maintain code formatting consistency with Laravel Pint:

**Check Code Style (Dry Run):**

- **macOS / Linux:**

  ```bash
  ./vendor/bin/pint --test
  ```

- **Windows (PowerShell / CMD):**

  ```powershell
  vendor\bin\pint --test
  ```

**Automatically Fix Code Style:**

- **macOS / Linux:**

  ```bash
  ./vendor/bin/pint
  ```

- **Windows (PowerShell / CMD):**

  ```powershell
  vendor\bin\pint
  ```

---

## License

The Jara collaborative task management application is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).
