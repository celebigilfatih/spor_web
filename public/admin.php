<?php
/**
 * Admin Direct Access Test
 * This bypasses the routing system to test admin functionality
 */

// Include the framework
require_once '../index.php';

// Check if we want to initialize database
if (isset($_GET['setup'])) {
    try {
        // Use Docker environment variables
        $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'database';
        $dbname = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'spor_kulubu';
        $username = $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'spor_user';
        $password = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: 'spor_password';
        
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
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
        
        // Check if admin exists
        $stmt = $pdo->prepare("SELECT id FROM admins WHERE email = ?");
        $stmt->execute(['admin@sporkulubu.com']);
        
        if (!$stmt->fetch()) {
            // Create admin user
            $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admins (username, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(['admin', 'admin@sporkulubu.com', $hashedPassword, 'super_admin', 'active']);
            echo "✅ Database setup complete!<br>";
        } else {
            echo "ℹ️ Database already set up!<br>";
        }
        
        echo "<p><a href='admin.php'>Go to Admin Login</a></p>";
        exit;
        
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage();
        exit;
    }
}

session_start();

// Simple login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($email && $password) {
        try {
            $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'database';
            $dbname = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'spor_kulubu';
            $username = $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'spor_user';
            $dbpass = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: 'spor_password';
            
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ? AND status = 'active'");
            $stmt->execute([$email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_role'] = $admin['role'];
                
                // Update last login
                $stmt = $pdo->prepare("UPDATE admins SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
                $stmt->execute([$admin['id']]);
                
                header('Location: admin.php?page=dashboard');
                exit;
            } else {
                $error = 'Geçersiz giriş bilgileri!';
            }
        } catch (Exception $e) {
            $error = 'Veritabanı hatası: ' . $e->getMessage();
        }
    } else {
        $error = 'Lütfen tüm alanları doldurun!';
    }
}

// Check if logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: admin.php');
        exit;
    }
    
    // Show admin dashboard
    echo '<!DOCTYPE html>
    <html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel - Spor Kulübü</title>
        <link href="css/style.css" rel="stylesheet">
        <link href="css/admin.css" rel="stylesheet">
        <style>
            body { font-family: Arial, sans-serif; margin: 0; background: #f5f5f5; }
            .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
            .header { background: #1e3a8a; color: white; padding: 20px; text-align: center; }
            .dashboard { background: white; padding: 30px; border-radius: 8px; margin-top: 20px; }
            .success { color: #28a745; font-size: 18px; margin-bottom: 20px; }
            .info { background: #e3f2fd; padding: 15px; border-radius: 4px; margin: 10px 0; }
            .logout { background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>🏆 Spor Kulübü Admin Paneli</h1>
            <p>Hoş geldiniz, ' . htmlspecialchars($_SESSION['admin_username']) . '</p>
        </div>
        <div class="container">
            <div class="dashboard">
                <div class="success">✅ Admin paneli başarıyla çalışıyor!</div>
                
                <h2>🎯 Sistem Durumu</h2>
                <div class="info">
                    <strong>✅ Veritabanı:</strong> Bağlantı başarılı<br>
                    <strong>✅ Oturum:</strong> Aktif<br>
                    <strong>✅ Yetki:</strong> ' . htmlspecialchars($_SESSION['admin_role']) . '<br>
                    <strong>✅ Kullanıcı:</strong> ' . htmlspecialchars($_SESSION['admin_username']) . '
                </div>
                
                <h2>🚀 Sonraki Adımlar</h2>
                <p>Admin paneli başarıyla çalışıyor. Şimdi MVC routing sistemini düzeltip tam admin panelini aktive edebiliriz.</p>
                
                <h2>🔧 Test Links</h2>
                <ul>
                    <li><a href="/">Ana Sayfa</a></li>
                    <li><a href="admin.php?logout=1" class="logout">Çıkış Yap</a></li>
                </ul>
                
                <h2>📊 Önerilen Admin URLs</h2>
                <ul>
                    <li><code>/admin/login</code> - Giriş sayfası</li>
                    <li><code>/admin/dashboard</code> - Ana dashboard</li>
                    <li><code>/admin/news</code> - Haber yönetimi</li>
                    <li><code>/admin/players</code> - Oyuncu yönetimi</li>
                    <li><code>/admin/teams</code> - Takım yönetimi</li>
                    <li><code>/admin/matches</code> - Maç yönetimi</li>
                    <li><code>/admin/settings</code> - Ayarlar</li>
                </ul>
            </div>
        </div>
    </body>
    </html>';
    exit;
}

// Show login form
echo '<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi - Spor Kulübü</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #1e3a8a, #3b82f6); margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); max-width: 400px; width: 100%; }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo h1 { color: #1e3a8a; margin: 0; font-size: 2rem; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        .btn { background: #1e3a8a; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        .btn:hover { background: #2563eb; }
        .error { background: #fecaca; color: #dc2626; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        .info { background: #dbeafe; color: #2563eb; padding: 10px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; }
        .setup-link { text-align: center; margin-top: 20px; }
        .setup-link a { color: #1e3a8a; text-decoration: none; }
        .setup-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>⚽ Spor Kulübü</h1>
            <p>Admin Paneli</p>
        </div>
        
        ' . (isset($error) ? '<div class="error">' . htmlspecialchars($error) . '</div>' : '') . '
        
        <div class="info">
            <strong>Test Hesabı:</strong><br>
            E-posta: admin@sporkulubu.com<br>
            Şifre: password
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">E-posta Adresi</label>
                <input type="email" id="email" name="email" value="admin@sporkulubu.com" required>
            </div>
            
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" value="password" required>
            </div>
            
            <button type="submit" class="btn">Giriş Yap</button>
        </form>
        
        <div class="setup-link">
            <a href="admin.php?setup=1">Veritabanını Kur</a>
        </div>
    </div>
</body>
</html>';
?>