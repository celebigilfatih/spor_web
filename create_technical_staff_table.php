<?php
/**
 * Create Technical Staff Table Migration
 */

// Load configuration
if (getenv('DB_HOST') || isset($_ENV['DB_HOST'])) {
    require_once 'config/docker.php';
} else {
    require_once 'config/database.php';
}

require_once 'core/Database.php';

try {
    $db = new Database();
    
    echo "Creating technical_staff table...\n";
    
    // Technical Staff tablosu oluştur
    $createTechnicalStaffTable = "
    CREATE TABLE IF NOT EXISTS technical_staff (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        position VARCHAR(100) NOT NULL,
        experience VARCHAR(100),
        license VARCHAR(100),
        bio TEXT,
        photo VARCHAR(255),
        team_id INT NULL,
        role VARCHAR(100),
        experience_years INT,
        sort_order INT DEFAULT 0,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $db->execute($createTechnicalStaffTable);
    echo "✓ Technical staff table created successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
