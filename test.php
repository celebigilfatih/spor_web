<?php
/**
 * Test Dosyası - Temel Fonksiyonları Test Et
 */

// Hata raporlamayı etkinleştir
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Spor Kulübü Web Sitesi - Test Sonuçları</h1>";

// 1. Konfigürasyon Testi
echo "<h2>1. Konfigürasyon Testi</h2>";
require_once 'config/database.php';

$configTests = [
    'DB_HOST' => defined('DB_HOST'),
    'DB_NAME' => defined('DB_NAME'),
    'DB_USER' => defined('DB_USER'),
    'DB_PASS' => defined('DB_PASS'),
    'BASE_PATH' => defined('BASE_PATH'),
    'UPLOAD_PATH' => defined('UPLOAD_PATH')
];

foreach ($configTests as $config => $status) {
    echo $config . ": " . ($status ? "✅ Tanımlı" : "❌ Tanımlı değil") . "<br>";
}

// 2. Dosya Yapısı Testi
echo "<h2>2. Dosya Yapısı Testi</h2>";
$requiredDirs = [
    'app/controllers',
    'app/models',
    'app/views',
    'core',
    'config',
    'database',
    'public/css',
    'public/js',
    'public/uploads'
];

foreach ($requiredDirs as $dir) {
    echo $dir . ": " . (is_dir($dir) ? "✅ Mevcut" : "❌ Mevcut değil") . "<br>";
}

// 3. Core Sınıfları Testi
echo "<h2>3. Core Sınıfları Testi</h2>";
$coreFiles = [
    'core/App.php',
    'core/Controller.php',
    'core/Model.php',
    'core/Database.php'
];

foreach ($coreFiles as $file) {
    echo $file . ": " . (file_exists($file) ? "✅ Mevcut" : "❌ Mevcut değil") . "<br>";
}

// 4. Model Sınıfları Testi
echo "<h2>4. Model Sınıfları Testi</h2>";
$modelFiles = [
    'app/models/Admin.php',
    'app/models/News.php',
    'app/models/Team.php',
    'app/models/Player.php',
    'app/models/TechnicalStaff.php',
    'app/models/SiteSettings.php'
];

foreach ($modelFiles as $file) {
    echo $file . ": " . (file_exists($file) ? "✅ Mevcut" : "❌ Mevcut değil") . "<br>";
}

// 5. Controller Sınıfları Testi
echo "<h2>5. Controller Sınıfları Testi</h2>";
$controllerFiles = [
    'app/controllers/Home.php',
    'app/controllers/News.php',
    'app/controllers/Teams.php',
    'app/controllers/AdminAuth.php',
    'app/controllers/AdminDashboard.php'
];

foreach ($controllerFiles as $file) {
    echo $file . ": " . (file_exists($file) ? "✅ Mevcut" : "❌ Mevcut değil") . "<br>";
}

// 6. CSS ve JS Dosyaları Testi
echo "<h2>6. Frontend Dosyaları Testi</h2>";
$frontendFiles = [
    'public/css/style.css',
    'public/css/admin.css',
    'public/js/main.js'
];

foreach ($frontendFiles as $file) {
    echo $file . ": " . (file_exists($file) ? "✅ Mevcut" : "❌ Mevcut değil") . "<br>";
}

// 7. Veritabanı Bağlantı Testi (opsiyonel)
echo "<h2>7. Veritabanı Bağlantı Testi</h2>";
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    echo "✅ Veritabanı bağlantısı başarılı<br>";
    
    // Tabloları kontrol et
    $tables = ['admins', 'news', 'teams', 'players', 'technical_staff', 'site_settings'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        echo "Tablo '$table': " . ($stmt->rowCount() > 0 ? "✅ Mevcut" : "❌ Mevcut değil") . "<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Veritabanı bağlantı hatası: " . $e->getMessage() . "<br>";
    echo "<em>Not: Veritabanını oluşturmayı ve schema.sql dosyasını çalıştırmayı unutmayın!</em><br>";
}

// 8. Upload Klasörü İzinleri
echo "<h2>8. Upload Klasörü İzinleri</h2>";
$uploadPath = 'public/uploads';
if (is_dir($uploadPath)) {
    $permissions = substr(sprintf('%o', fileperms($uploadPath)), -4);
    echo "Upload klasörü izinleri: $permissions " . 
         (is_writable($uploadPath) ? "✅ Yazılabilir" : "❌ Yazılamaz") . "<br>";
} else {
    echo "❌ Upload klasörü mevcut değil<br>";
}

echo "<h2>✅ Test Tamamlandı!</h2>";
echo "<p><strong>Sonraki Adımlar:</strong></p>";
echo "<ul>";
echo "<li>Veritabanını oluşturun ve schema.sql dosyasını çalıştırın</li>";
echo "<li>config/database.php dosyasında veritabanı bilgilerini güncelleyin</li>";
echo "<li>public/uploads klasörüne yazma izni verin</li>";
echo "<li>Web sunucunuzda mod_rewrite'ın etkin olduğundan emin olun</li>";
echo "<li>Ana sayfayı test edin: <a href='index.php'>index.php</a></li>";
echo "<li>Admin panelini test edin: <a href='index.php?url=admin/login'>admin/login</a></li>";
echo "</ul>";
?>