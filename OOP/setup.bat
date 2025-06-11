@echo off
REM Setup Script for PHP CRUD OOP Application
REM This script helps set up the application and provides instructions

echo ================================================
echo  PHP CRUD Book Management System - OOP Version
echo ================================================
echo.

echo Checking PHP installation...
php --version
if %errorlevel% neq 0 (
    echo ERROR: PHP is not installed or not in PATH
    echo Please install PHP and add it to your system PATH
    pause
    exit /b 1
)

echo.
echo PHP is installed successfully!
echo.

echo Checking MySQL connection...
echo Please ensure MySQL is running before proceeding
echo.

echo Setting up the application...
echo.

echo Current directory: %cd%
echo.

echo ================================================
echo  SETUP INSTRUCTIONS
echo ================================================
echo.
echo 1. DATABASE SETUP:
echo    - Start MySQL server (XAMPP, WAMP, or standalone)
echo    - Create database 'crud' using the following command:
echo      mysql -u root -p -e "CREATE DATABASE crud;"
echo    - Import the database.sql file from the parent directory
echo.
echo 2. CONFIGURE DATABASE CONNECTION:
echo    - Edit config\Database.php
echo    - Update your MySQL credentials if different from defaults
echo.
echo 3. START THE APPLICATION:
echo    - Run: php -S localhost:8000
echo    - Open browser: http://localhost:8000
echo.
echo ================================================
echo  QUICK START
echo ================================================
echo.

set /p choice="Do you want to start the PHP development server now? (y/n): "
if /i "%choice%"=="y" (
    echo.
    echo Starting PHP development server on localhost:8000...
    echo Press Ctrl+C to stop the server
    echo.
    echo Open your browser and go to: http://localhost:8000
    echo.
    php -S localhost:8000
) else (
    echo.
    echo To start the server manually, run:
    echo php -S localhost:8000
    echo.
    echo Then open your browser and go to: http://localhost:8000
)

echo.
echo Setup complete! 
pause
