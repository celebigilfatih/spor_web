<?php
/**
 * Database Initialization Script
 * Bu dosya veritabanı tablolarını oluşturur ve test verilerini ekler
 */

require_once '../config/database.php';
require_once '../core/Database.php';

try {
    $db = new Database();
    
    echo "Veritabanı bağlantısı başarılı!\n";
    
    // Admin tablosu oluştur
    $createAdminTable = "
    CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'super_admin') DEFAULT 'admin',
        status ENUM('active', 'inactive') DEFAULT 'active',
        last_login TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $db->execute($createAdminTable);
    echo "Admin tablosu oluşturuldu!\n";
    
    // Test admin kullanıcısı oluştur
    $testAdmin = [
        'username' => 'admin',
        'email' => 'admin@sporkulubu.com',
        'password' => password_hash('password', PASSWORD_DEFAULT),
        'role' => 'super_admin',
        'status' => 'active'
    ];
    
    // Mevcut admin var mı kontrol et
    $existingAdmin = $db->query("SELECT id FROM admins WHERE email = ?", [$testAdmin['email']]);
    
    if (!$existingAdmin) {
        $db->execute("INSERT INTO admins (username, email, password, role, status) VALUES (?, ?, ?, ?, ?)", [
            $testAdmin['username'],
            $testAdmin['email'], 
            $testAdmin['password'],
            $testAdmin['role'],
            $testAdmin['status']
        ]);
        echo "Test admin kullanıcısı oluşturuldu!\n";
        echo "Email: admin@sporkulubu.com\n";
        echo "Şifre: password\n";
    } else {
        echo "Test admin kullanıcısı zaten mevcut!\n";
    }
    
    // News tablosu oluştur
    $createNewsTable = "
    CREATE TABLE IF NOT EXISTS news (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        content TEXT NOT NULL,
        excerpt TEXT,
        image VARCHAR(255),
        category ENUM('haber', 'duyuru', 'mac_sonucu') DEFAULT 'haber',
        status ENUM('draft', 'published') DEFAULT 'draft',
        featured BOOLEAN DEFAULT FALSE,
        views INT DEFAULT 0,
        author_id INT,
        published_at TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (author_id) REFERENCES admins(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $db->execute($createNewsTable);
    echo "News tablosu oluşturuldu!\n";
    
    // Teams tablosu oluştur
    $createTeamsTable = "
    CREATE TABLE IF NOT EXISTS teams (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        category ENUM('A', 'B', 'U19', 'U16', 'U14', 'U12') DEFAULT 'A',
        coach VARCHAR(100),
        description TEXT,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $db->execute($createTeamsTable);
    echo "Teams tablosu oluşturuldu!\n";
    
    // Matches tablosu oluştur
    $createMatchesTable = "
    CREATE TABLE IF NOT EXISTS matches (
        id INT AUTO_INCREMENT PRIMARY KEY,
        home_team VARCHAR(100) NOT NULL,
        away_team VARCHAR(100) NOT NULL,
        home_score INT NULL,
        away_score INT NULL,
        match_date DATETIME NOT NULL,
        venue VARCHAR(100),
        competition VARCHAR(100),
        status ENUM('scheduled', 'live', 'finished', 'cancelled') DEFAULT 'scheduled',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $db->execute($createMatchesTable);
    echo "Matches tablosu oluşturuldu!\n";
    
    // Players tablosu oluştur
    $createPlayersTable = "
    CREATE TABLE IF NOT EXISTS players (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        position ENUM('Kaleci', 'Defans', 'Orta Saha', 'Forvet') NOT NULL,
        jersey_number INT,
        age INT,
        height INT,
        weight INT,
        nationality VARCHAR(50) DEFAULT 'Türkiye',
        photo VARCHAR(255),
        team_type ENUM('A', 'B', 'U19', 'U16', 'U14', 'U12') DEFAULT 'A',
        status ENUM('active', 'inactive', 'injured') DEFAULT 'active',
        join_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $db->execute($createPlayersTable);
    echo "Players tablosu oluşturuldu!\n";
    
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
    echo "Technical Staff tablosu oluşturuldu!\n";
    
    // Site Settings tablosu oluştur
    $createSettingsTable = "
    CREATE TABLE IF NOT EXISTS site_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) NOT NULL UNIQUE,
        setting_value TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $db->execute($createSettingsTable);
    echo "Site Settings tablosu oluşturuldu!\n";
    
    echo "\nVeritabanı başarıyla hazırlandı!\n";
    echo "Admin paneline erişmek için: " . BASE_URL . "/admin/login\n";
    echo "Email: admin@sporkulubu.com\n";
    echo "Şifre: password\n";
    
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage() . "\n";
}
?>