# 🛍️ Stack N Shop - Elite E-commerce Dashboard

Stack N Shop is a high-fidelity, professional-grade SaaS dashboard built with PHP and integrated with the DummyJSON API. It features a modern glassmorphism aesthetic, dual-theme support, and advanced interactive components.

![Version](https://img.shields.io/badge/version-2.0.0-blueviolet)
![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue)
![Theme](https://img.shields.io/badge/Theme-Light%2FDark-success)

<img width="1907" height="943" alt="image" src="https://github.com/user-attachments/assets/aed31a04-bc31-460c-9479-32a245ddbcc8" />

## ✨ Features

- **Elite UI/UX**: Premium glassmorphism design with fluid typography and SaaS tokens.
- **Dual-Theme System**: Seamlessly toggle between Light and Dark modes with persistent settings.
- **Command Palette (Cmd+K)**: Instant search and quick actions keyboard-driven interface.
- **Dynamic Analytics**: Real-time sales and distribution charts powered by ApexCharts.
- **Magnetic Glow Cards**: Interactive product cards with cursor-tracking glow effects.
- **Offcanvas Cart**: Slide-in shopping basket for frictionless browsing.
- **Global Catalog**: Real-time search, category filtering, and "Quick View" product modals.
- **Secure Auth**: Full registration and login system with password hashing and session management.

## 🛠️ Technology Stack

- **Backend**: PHP 8.1+
- **Database**: MySQL (MariaDB)
- **Frontend**: Vanilla JavaScript (ES6+), CSS3 (Custom Design System), HTML5
- **Frameworks**: Bootstrap 5.3 (Grid & Utilities only)
- **APIs**: [DummyJSON](https://dummyjson.com/)
- **Charts**: [ApexCharts](https://apexcharts.com/)

---

## 🚀 Setup Instructions (XAMPP & phpMyAdmin)

Follow these steps to get the project running locally on your machine.

### 1. Prerequisites
- Install [XAMPP](https://www.apachefriends.org/download.html) (Apache & MySQL).

### 2. Project Placement
1.  Download or clone this repository.
2.  Copy the project folder (`StacknShop`) into your XAMPP installation's `htdocs` directory:
    - Path usually: `C:\xampp\htdocs\StacknShop`

### 3. Database Setup (phpMyAdmin)
1.  Open XAMPP Control Panel and start **Apache** and **MySQL**.
2.  Open your browser and go to `http://localhost/phpmyadmin/`.
3.  Create a new database named `dummyjson_webapp`.
4.  Click on the newly created database and go to the **Import** tab.
5.  Choose the SQL file located in the project at: `database/dummyjson_webapp.sql`.
6.  Click **Go** to execute the import.

### 4. Configuration
1.  Open `config/database.php` in your text editor.
2.  Ensure the database credentials match your XAMPP settings (default is usually `root` with no password).

```php
// config/database.php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dummyjson_webapp');
```

### 5. Run the Application
1.  Open your browser.
2.  Navigate to `http://localhost/StacknShop/`.
3.  Register a new account and start exploring!

---

## ⌨️ Shortcuts
- **`Cmd + K` / `Ctrl + K`**: Open Command Palette.
- **`T`** (inside Palette): Quick toggle theme.
- **`Esc`**: Close Modals/Palette.

## 📄 License
This project is for educational purposes as part of the Stack N Shop portfolio.
