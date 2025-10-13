<?php
/**
 * Spor Kulübü Web Sitesi - Ana Giriş Noktası
 * PHP MVC Mimarisi
 */

// Hata raporlamayı etkinleştir (geliştirme için)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Konfigürasyonu yükle
// Docker ortamında mı çalışıyoruz?
if (getenv('DB_HOST') || isset($_ENV['DB_HOST'])) {
    require_once 'config/docker.php';
} else {
    require_once 'config/database.php';
}

// Sabitler
define('BASE_PATH', __DIR__);
define('BASE_URL', 'http://localhost:8090');
define('UPLOAD_PATH', BASE_PATH . '/public/uploads');

// Autoloader
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/app/controllers/',
        BASE_PATH . '/app/models/',
        BASE_PATH . '/core/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Oturum başlat
session_start();

// Ana uygulama sınıfını başlat
$app = new App();