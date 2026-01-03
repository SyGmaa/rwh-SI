# RWH - Travel Umrah Management System

![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-4-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

## 📋 About The Project

**RWH (Travel Umrah Management System)** is a comprehensive web-based application designed to streamline the operations of an Umrah travel agency. It provides a robust platform for managing pilgrims (Jemaah), departure schedules, tour packages, payments, and document validation.

The system features a powerful admin dashboard that offers real-time insights into key performance metrics such as total pilgrims, financial overview, and upcoming departures.

### 🌟 Key Features

-   **📈 Interactive Dashboard**: Visual analytics using ApexCharts to track monthly/yearly pilgrim counts, revenue, and schedule statistics.
-   **🕋 Package Management**: Create and manage various Umrah packages and package types.
-   **🗓️ Schedule & Departure Management**: Monitor upcoming departure dates, quota availability, and pilgrim registration status.
-   **👥 Pilgrim (Jemaah) Management**:
    -   Detailed pilgrim profiles.
    -   Document tracking (Passport, Visa, etc.) with status indicators (Completed/Incomplete).
    -   Family/Group management.
-   **💰 Financial Management**:
    -   Track payments and remaining balances.
    -   Handle installment plans (Cicilan).
    -   Income reports.
-   **🔐 Role-Based Access Control**: Secure login and management for Admins and Staff (powered by Laravel Jetstream & Sanctum).
-   **📝 Activity Logging**: Comprehensive audit logs to track system usage and changes.

---

## 🛠️ Technology Stack

This project is built using modern web development technologies to ensure performance, security, and scalability.

-   **Backend Framework**: [Laravel 10](https://laravel.com/)
-   **Frontend**: Blade Templates, [Bootstrap 4](https://getbootstrap.com/), [Alpine.js](https://alpinejs.dev/)
-   **Auth & Scaffolding**: [Laravel Jetstream](https://jetstream.laravel.com/) (Livewire stack)
-   **Database**: MySQL
-   **Admin Template**: Otika Bootstrap Admin Template
-   **Additional Libraries**:
    -   `yajra/laravel-datatables`: for advanced table interactions.
    -   `spatie/laravel-permission`: for role and permission management.
    -   `barryvdh/laravel-dompdf`: for generating PDF reports.
    -   `phpoffice/phpspreadsheet`: for Excel exports/imports.
    -   `spatie/laravel-activitylog`: for tracking activity.

---

## 🚀 Getting Started

Follow these steps to set up the project locally.

### Prerequisites

-   PHP >= 8.1
-   Composer
-   MySQL
-   Node.js & NPM

### Installation

1.  **Clone the repository**

    ```bash
    git clone https://github.com/yourusername/project-rwh.git
    cd project-rwh
    ```

2.  **Install PHP Dependencies**

    ```bash
    composer install
    ```

3.  **Install Frontend Dependencies**

    ```bash
    npm install && npm run build
    ```

4.  **Environment Setup**
    Copy the `.env.example` file to create your own `.env` file.

    ```bash
    cp .env.example .env
    ```

    Update the database configuration in `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

5.  **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

6.  **Run Migrations & Seeders**
    Create the database tables and populate them with initial data.

    ```bash
    php artisan migrate --seed
    ```

7.  **Run the Application**
    Start the local development server.
    ```bash
    php artisan serve
    ```
    Access the application at `http://localhost:8000`.

---

## 📂 Project Structure

-   `app/Http/Controllers`: Contains the logic for Dashboard, Pilgrims, Packages, etc.
-   `resources/views`: Blade templates for the UI.
    -   `layouts`: Main application layouts (including Sidebar and Navbar).
    -   `jemaah`, `paket`, `jadwal-keberangkatan`: Feature-specific views.
-   `routes/web.php`: Application routes definition.
-   `public/admin/assets`: Static assets for the admin template (CSS, JS, Images).

## 🛡️ License

This project is proprietary software. Unauthorized copying, modification, distribution, or use of this software is strictly prohibited.

---

_Created with ❤️ for RWH Travel._
