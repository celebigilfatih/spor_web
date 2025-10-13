<?php
// Quick database setup script
// Access via: http://localhost:8080/index.php?url=setup

try {
    // Use Docker environment variables
    $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'database';
    $dbname = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'spor_kulubu';
    $username = $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'spor_user';
    $password = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: 'spor_password';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database connection successful!<br>";
    
    // Create admin table
    $sql = "CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'super_admin') DEFAULT 'admin',
        status ENUM('active', 'inactive') DEFAULT 'active',
        last_login TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "✅ Admin table created!<br>";
    
    // Check if admin exists
    $stmt = $pdo->prepare("SELECT id FROM admins WHERE email = ?");
    $stmt->execute(['admin@sporkulubu.com']);
    
    if (!$stmt->fetch()) {
        // Create admin user
        $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admins (username, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['admin', 'admin@sporkulubu.com', $hashedPassword, 'super_admin', 'active']);
        echo "✅ Admin user created!<br>";
    } else {
        echo "ℹ️ Admin user already exists!<br>";
    }
    
    echo "<br><strong>Admin Login Info:</strong><br>";
    echo "URL: <a href='/admin/login'>/admin/login</a><br>";
    echo "Email: admin@sporkulubu.com<br>";
    echo "Password: password<br>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>