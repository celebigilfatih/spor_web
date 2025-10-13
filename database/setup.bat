@echo off
REM Database setup script for Sports Club Website (Windows)
REM This script will create the database and populate it with sample data

echo Setting up Sports Club Database...

REM Database connection variables (using Docker environment)
set DB_HOST=localhost
set DB_PORT=3307
set DB_NAME=spor_web_db
set DB_USER=spor_user
set DB_PASS=spor_pass

echo Waiting for MySQL to be ready...

REM Wait for MySQL to be ready (simple approach)
timeout /t 5 >nul

echo MySQL should be ready. Creating database and tables...

REM Create database if not exists
mysql -h%DB_HOST% -P%DB_PORT% -u%DB_USER% -p%DB_PASS% -e "CREATE DATABASE IF NOT EXISTS %DB_NAME% CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci;"

REM Import schema
echo Importing database schema...
mysql -h%DB_HOST% -P%DB_PORT% -u%DB_USER% -p%DB_PASS% %DB_NAME% < database\schema.sql

if %errorlevel% neq 0 (
    echo Error importing schema!
    pause
    exit /b 1
)

echo Schema imported successfully!

REM Import sample data
echo Importing sample data...
mysql -h%DB_HOST% -P%DB_PORT% -u%DB_USER% -p%DB_PASS% %DB_NAME% < database\sample_data.sql

if %errorlevel% neq 0 (
    echo Error importing sample data!
    pause
    exit /b 1
)

echo Sample data imported successfully!
echo.
echo Database setup completed successfully!
echo.
echo You can now access the website at: http://localhost:8090
echo Admin panel: http://localhost:8090/admin/login
echo Admin credentials: admin / admin123
echo.
echo phpMyAdmin: http://localhost:8091
echo Database credentials: %DB_USER% / %DB_PASS%
echo.
pause