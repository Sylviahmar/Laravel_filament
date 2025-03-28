Laravel Filament Project Setup Guide

Prerequisites
Before starting, ensure you have the following installed:

1. **PHP 8.1 or later** (PHP 3.9 does not exist; please use the latest stable version.)
2. **Composer** (PHP dependency manager)
3. **MySQL** (Database for Laravel project)

---

Step 1: Install PHP

1. Download PHP (latest stable version) from the [official PHP site](https://www.php.net/downloads.php).
2. Extract the PHP archive.
3. Move the extracted folder to `C:\Program Files\php`.

---

Step 2: Install Composer

1. Download Composer from the [official site](https://getcomposer.org/download/).
2. Follow the installation instructions and ensure Composer is added to your system PATH.

---

Step 3: Configure PHP

1. Open **Notepad** as Administrator.
2. Open the PHP configuration file (`php.ini`) located at `C:\Program Files\php\php.ini`.
3. Enable required PHP extensions by removing the `;` (semicolon) before these lines:
    ```ini
    extension=intl
    extension=fileinfo
    extension=zip
    ```
4. Save and close the file.

---

Step 4: Create a Laravel Project

1. Create a folder for your Laravel project.
2. Open **Command Prompt** and navigate to the project folder using:
    ```sh
    cd "C:\path\to\your\folder"
    ```
3. Create a new Laravel project:
    ```sh
    composer create-project laravel/laravel project-name
    ```
4. Navigate into the project directory:
    ```sh
    cd project-name
    ```

---

Step 5: Install Filament

1. Add Filament dependencies:
    ```sh
    composer require filament/filament:"^3.3" -W
    ```

---

Step 6: Set Up MySQL Database

1. Install **MySQL** if you haven't already.
2. Open the Laravel `.env` file in your project folder.
3. Update the database configuration:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```
4. Save and close the file.

---

Step 7: Migrate the Database
Run the following commands in the terminal:

```sh
php artisan migrate
php artisan config:clear
php artisan cache:clear
```

---

Step 8: Install Filament Admin Panel

1. Run the Filament installation command:
    ```sh
    php artisan filament:install --panels
    ```
2. Create an admin user:
    ```sh
    php artisan make:filament-user
    ```
    - Enter a **username**
    - Enter a **valid email**
    - Enter a **password** (Note: The password input won't be visible, but it is being typed.)

---

Step 9: Start the Laravel Development Server

1. Run the Laravel server:
    ```sh
    php artisan serve
    ```
2. Open the following URL in your browser:
    ```
    http://127.0.0.1:8000
    ```
3. To access the Filament Admin Panel, go to:
    ```
    http://127.0.0.1:8000/admin
    ```
4. Log in using the credentials created in **Step 8**.

---
