<?php
/**
 * Database Setup Page
 * Bu dosyayı çalıştırarak veritabanı tablolarını oluşturabilirsiniz
 */

// Güvenlik kontrolü - sadece localhost'tan erişilebilir
if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
    die('Bu sayfa sadece localhost\'tan erişilebilir.');
}

require_once '../config/database.php';
require_once '../core/Database.php';

echo '<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veritabanı Kurulumu</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .info { color: #17a2b8; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; border-left: 4px solid #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Veritabanı Kurulumu</h1>';

try {
    $db = new Database();
    
    echo '<p class="success">✓ Veritabanı bağlantısı başarılı!</p>';
    
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
    echo '<p class="success">✓ Admin tablosu oluşturuldu!</p>';
    
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
        echo '<p class="success">✓ Test admin kullanıcısı oluşturuldu!</p>';
    } else {
        echo '<p class="info">ℹ Test admin kullanıcısı zaten mevcut!</p>';
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
    echo '<p class="success">✓ News tablosu oluşturuldu!</p>';
    
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
    echo '<p class="success">✓ Teams tablosu oluşturuldu!</p>';
    
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
    echo '<p class="success">✓ Matches tablosu oluşturuldu!</p>';
    
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
    echo '<p class="success">✓ Players tablosu oluşturuldu!</p>';
    
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
    echo '<p class="success">✓ Technical Staff tablosu oluşturuldu!</p>';
    
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
    echo '<p class="success">✓ Site Settings tablosu oluşturuldu!</p>';
    
    echo '<br><p class="success"><strong>🎉 Veritabanı başarıyla hazırlandı!</strong></p>';
    echo '<div class="info">
        <h3>Admin Paneli Giriş Bilgileri:</h3>
        <pre>
URL: <a href="' . BASE_URL . '/admin/login">' . BASE_URL . '/admin/login</a>
E-posta: admin@sporkulubu.com
Şifre: password
        </pre>
    </div>';
    
    echo '<p><a href="' . BASE_URL . '/admin/login" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Admin Paneline Git</a></p>';
    
} catch (Exception $e) {
    echo '<p class="error">❌ Hata: ' . $e->getMessage() . '</p>';
}

echo '</div></body></html>';

// Güvenlik için dosyayı sil (isteğe bağlı)
// unlink(__FILE__);
?>