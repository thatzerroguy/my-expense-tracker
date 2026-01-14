# Expense Tracker Installation Guide

This repository contains the source code (Models, Controllers, Views, Migrations) for a simple Expense Tracker application. To run this application, you need to integrate these files into a standard Laravel framework structure.

Follow these steps to build and launch the project on your local machine.

## Prerequisites

1.  **XAMPP**: Download and install [XAMPP](https://www.apachefriends.org/index.html). Ensure the **Apache** and **MySQL** modules are running via the XAMPP Control Panel.
2.  **Composer**: Download and install [Composer](https://getcomposer.org/), the dependency manager for PHP.
3.  **PHP**: Ensure PHP is available in your terminal (usually handled by XAMPP, add `C:\xampp\php` to your PATH variable on Windows).

## Step 1: Create a Fresh Laravel Project

Since this repository only contains the custom application code, you need a fresh Laravel installation to provide the framework files.

Open your terminal or command prompt and run:

```bash
composer create-project laravel/laravel my-expense-tracker
```

*This will create a new folder named `my-expense-tracker` with all standard Laravel files.*

## Step 2: Integrate Custom Code

Now, move the files from this folder into your new Laravel project.

1.  **Copy Folders**: Copy the following folders from this directory:
    *   `app`
    *   `database`
    *   `resources`
    *   `routes`
2.  **Paste and Overwrite**: Paste them into the `my-expense-tracker` folder you just created.
    *   **Important**: When asked, choose **"Replace"** or **"Overwrite"** for all conflicting files. This ensures the default routes and views are replaced with the Expense Tracker logic.

## Step 3: Database Setup (XAMPP)

1.  **Open phpMyAdmin**: Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin) in your browser.
2.  **Create Database**:
    *   Click on the **Databases** tab.
    *   Enter the database name: `expense_tracker`
    *   Click **Create**.

## Step 4: Configure Connection

1.  Open the `my-expense-tracker` folder in your code editor (e.g., VS Code).
2.  Find the file named `.env` in the root directory.
3.  Update the database configuration section to match your XAMPP settings:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expense_tracker
DB_USERNAME=root
DB_PASSWORD=
```

*Note: By default, the XAMPP root user has no password. If you set one, add it to `DB_PASSWORD`.*

## Step 5: Initialize the Database

In your terminal, navigate inside your project folder:

```bash
cd my-expense-tracker
```

Run the migrations to create the Users, Incomes, and Expenses tables:

```bash
php artisan migrate
```

## Step 6: Launch the Application

Start the local development server:

```bash
php artisan serve
```

You can now access your Expense Tracker at:
**[http://localhost:8000](http://localhost:8000)**

## Application Features

*   **Sign Up/Login**: Create an account to secure your data.
*   **Dashboard**: View your current balance and recent transactions.
*   **Income & Expenses**: Log financial records with categories.
*   **Recurring**: Use the "Recurring" checkbox to track items that happen daily, weekly, or monthly.