<?php
/**
 * Veritabanı Konfigürasyonu
 */

// Veritabanı sabitleri
define('DB_HOST', 'localhost');
define('DB_NAME', 'spor_kulubu');
define('DB_USER', 'root');
define('DB_PASS', '');

// Diğer konfigürasyonlar
define('SITE_NAME', 'Spor Kulübü');
define('ADMIN_EMAIL', 'admin@sporkulubu.com');

// Dosya yükleme ayarları
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Sayfalama ayarları
define('POSTS_PER_PAGE', 10);
define('PLAYERS_PER_PAGE', 12);