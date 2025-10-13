<?php
/**
 * Docker için Veritabanı Konfigürasyonu
 * Environment variables kullanarak Docker container'larından değerleri alır
 */

// Docker environment variables'dan veritabanı bilgilerini al
define('DB_HOST', $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'database');
define('DB_NAME', $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'spor_kulubu');
define('DB_USER', $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'spor_user');
define('DB_PASS', $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: 'spor_password');

// Diğer konfigürasyonlar
define('SITE_NAME', 'Spor Kulübü');
define('ADMIN_EMAIL', 'admin@sporkulubu.com');

// Dosya yükleme ayarları
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB (Docker'da artırdık)
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Sayfalama ayarları
define('POSTS_PER_PAGE', 10);
define('PLAYERS_PER_PAGE', 12);

// Redis konfigürasyonu (isteğe bağlı)
define('REDIS_HOST', $_ENV['REDIS_HOST'] ?? getenv('REDIS_HOST') ?: 'redis');
define('REDIS_PORT', $_ENV['REDIS_PORT'] ?? getenv('REDIS_PORT') ?: 6379);

// Environment detection
define('ENVIRONMENT', $_ENV['ENVIRONMENT'] ?? getenv('ENVIRONMENT') ?: 'development');
define('DEBUG_MODE', ENVIRONMENT === 'development');

// Log ayarları
define('LOG_ERRORS', true);
define('LOG_PATH', '/var/log/spor_kulubu.log');

// Session ayarları
define('SESSION_LIFETIME', 3600); // 1 saat

// Cache ayarları
define('CACHE_ENABLED', ENVIRONMENT === 'production');
define('CACHE_DURATION', 3600); // 1 saat