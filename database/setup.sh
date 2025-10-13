#!/bin/bash

# Database setup script for Sports Club Website
# This script will create the database and populate it with sample data

echo "Setting up Sports Club Database..."

# Database connection variables (using Docker environment)
DB_HOST="localhost"
DB_PORT="3307"
DB_NAME="spor_web_db"
DB_USER="spor_user"
DB_PASS="spor_pass"

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
until mysql -h${DB_HOST} -P${DB_PORT} -u${DB_USER} -p${DB_PASS} -e "SELECT 1" &>/dev/null; do
    echo "MySQL is not ready yet. Waiting..."
    sleep 2
done

echo "MySQL is ready. Creating database and tables..."

# Create database if not exists
mysql -h${DB_HOST} -P${DB_PORT} -u${DB_USER} -p${DB_PASS} -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci;"

# Import schema
echo "Importing database schema..."
mysql -h${DB_HOST} -P${DB_PORT} -u${DB_USER} -p${DB_PASS} ${DB_NAME} < database/schema.sql

if [ $? -eq 0 ]; then
    echo "Schema imported successfully!"
else
    echo "Error importing schema!"
    exit 1
fi

# Import sample data
echo "Importing sample data..."
mysql -h${DB_HOST} -P${DB_PORT} -u${DB_USER} -p${DB_PASS} ${DB_NAME} < database/sample_data.sql

if [ $? -eq 0 ]; then
    echo "Sample data imported successfully!"
else
    echo "Error importing sample data!"
    exit 1
fi

echo "Database setup completed successfully!"
echo ""
echo "You can now access the website at: http://localhost:8090"
echo "Admin panel: http://localhost:8090/admin/login"
echo "Admin credentials: admin / admin123"
echo ""
echo "phpMyAdmin: http://localhost:8091"
echo "Database credentials: ${DB_USER} / ${DB_PASS}"