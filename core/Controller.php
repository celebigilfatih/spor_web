<?php
/**
 * Temel Controller Sınıfı
 * Tüm controller'ların miras alacağı ana sınıf
 */
class Controller
{
    /**
     * View dosyasını yükle
     */
    public function view($view, $data = [])
    {
        // Bakım modu kontrolü
        if ($this->isMaintenanceMode() && !$this->isAdminRoute()) {
            // Bakım sayfasını göster
            $settingsModel = $this->model('SiteSettings');
            $maintenanceData = [
                'maintenance_message' => $settingsModel->getSetting('maintenance_message', ''),
                'maintenance_end_date' => $settingsModel->getSetting('maintenance_end_date', ''),
                'contact_email' => $settingsModel->getSetting('contact_email', 'info@sporkulubu.com')
            ];
            
            // Data dizisini değişkenlere çevir
            extract($maintenanceData);
            
            require_once BASE_PATH . '/app/views/frontend/maintenance.php';
            return;
        }
        
        // Data dizisini değişkenlere çevir
        extract($data);
        
        require_once BASE_PATH . '/app/views/' . $view . '.php';
    }

    /**
     * Bakım modu kontrolü
     */
    private function isMaintenanceMode()
    {
        // Admin kullanıcıları bakım modundan etkilenmez
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            return false;
        }
        
        // Site ayarlarını kontrol et
        try {
            $settingsModel = $this->model('SiteSettings');
            $maintenanceMode = $settingsModel->getSetting('maintenance_mode', '0');
            return $maintenanceMode === '1';
        } catch (Exception $e) {
            // Hata durumunda bakım modunu devre dışı bırak
            return false;
        }
    }

    /**
     * Admin route kontrolü
     */
    private function isAdminRoute()
    {
        return strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;
    }

    /**
     * Model yükle
     */
    public function model($model)
    {
        require_once BASE_PATH . '/app/models/' . $model . '.php';
        return new $model();
    }

    /**
     * JSON response gönder
     */
    public function jsonResponse($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    /**
     * Sayfa yönlendirme
     */
    public function redirect($path)
    {
        header('Location: ' . BASE_URL . '/' . $path);
        exit;
    }

    /**
     * Admin girişi kontrolü
     */
    public function requireAdmin()
    {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            $this->redirect('admin/login');
        }
        
        // Check session timeout (30 minutes of inactivity)
        $timeout = 1800; // 30 minutes
        if (isset($_SESSION['last_activity'])) {
            $elapsed = time() - $_SESSION['last_activity'];
            
            if ($elapsed > $timeout) {
                // Session expired
                session_unset();
                session_destroy();
                session_start();
                $_SESSION['session_expired'] = true;
                $this->redirect('admin/login?expired=1');
            }
        }
        
        // Update last activity time
        $_SESSION['last_activity'] = time();
    }

    /**
     * CSRF token oluştur
     */
    public function generateCSRFToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * CSRF token doğrula
     */
    public function validateCSRFToken($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Input temizleme
     * NOT to use htmlspecialchars here - we store raw UTF-8 in database
     * Only encode when displaying in views for XSS protection
     */
    public function sanitizeInput($input)
    {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        // Return empty string for null values to prevent trim() warning
        if ($input === null) {
            return '';
        }
        // Just trim, don't encode - preserve Turkish characters
        // XSS protection will be applied in views with htmlspecialchars()
        return trim($input);
    }

    /**
     * Email doğrulama
     */
    public function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Telefon numarası doğrulama (Basit format)
     */
    public function validatePhone($phone)
    {
        // Türk telefon numaraları için basit validasyon
        $phone = preg_replace('/[^0-9]/', '', $phone);
        return strlen($phone) >= 10 && strlen($phone) <= 11;
    }

    /**
     * Honeypot alanı kontrolü (bot koruması)
     */
    public function validateHoneypot($honeypotField = 'website')
    {
        // Eğer honeypot alanı doldurulmuşsa, bu bir bot'tur
        return empty($_POST[$honeypotField]);
    }

    /**
     * Rate limiting kontrolü
     */
    public function checkRateLimit($action, $maxAttempts = 5, $timeWindow = 3600)
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = 'rate_limit_' . $action . '_' . md5($ip);
        
        // Oturum bazlı rate limiting
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [
                'count' => 0,
                'first_attempt' => time()
            ];
        }
        
        $rateData = $_SESSION[$key];
        $timeElapsed = time() - $rateData['first_attempt'];
        
        // Zaman penceresi geçtiğinde sıfırla
        if ($timeElapsed > $timeWindow) {
            $_SESSION[$key] = [
                'count' => 1,
                'first_attempt' => time()
            ];
            return true;
        }
        
        // Maksimum deneme sayısını kontrol et
        if ($rateData['count'] >= $maxAttempts) {
            $remainingTime = $timeWindow - $timeElapsed;
            return [
                'allowed' => false,
                'remaining_time' => $remainingTime,
                'message' => "Fazla deneme yaptınız. Lütfen " . ceil($remainingTime / 60) . " dakika sonra tekrar deneyin."
            ];
        }
        
        // Deneme sayısını artır
        $_SESSION[$key]['count']++;
        return true;
    }

    /**
     * Gelişmiş input sanitizasyonu
     */
    public function sanitizeInputAdvanced($input, $type = 'text')
    {
        if (is_array($input)) {
            return array_map(function($item) use ($type) {
                return $this->sanitizeInputAdvanced($item, $type);
            }, $input);
        }
        
        // Trim
        $input = trim($input);
        
        switch ($type) {
            case 'email':
                return filter_var($input, FILTER_SANITIZE_EMAIL);
            
            case 'phone':
                return preg_replace('/[^0-9+\(\)\s-]/', '', $input);
            
            case 'number':
                return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
            
            case 'url':
                return filter_var($input, FILTER_SANITIZE_URL);
            
            case 'alphanumeric':
                return preg_replace('/[^a-zA-Z0-9\s]/', '', $input);
            
            case 'text':
            default:
                // XSS koruması için htmlspecialchars
                return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        }
    }

    /**
     * SQL injection korumalı input
     */
    public function sanitizeForDatabase($input)
    {
        // Bu fonksiyon sadece ek bir katman, PDO prepared statements kullanılıyor
        return $this->sanitizeInput($input);
    }

    /**
     * Dosya yükleme işlemi
     */
    public function uploadFile($file, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'])
    {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Dosya yükleme hatası'];
        }

        // Get file extension
        $fileInfo = pathinfo($file['name']);
        $extension = strtolower($fileInfo['extension'] ?? '');
        
        // If no extension, try to detect from MIME type
        if (empty($extension) && isset($file['type'])) {
            $mimeToExt = [
                'image/jpeg' => 'jpg',
                'image/jpg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp',
                'image/avif' => 'avif',
                'image/svg+xml' => 'svg'
            ];
            $extension = $mimeToExt[$file['type']] ?? '';
        }

        if (empty($extension) || !in_array($extension, $allowedTypes)) {
            return ['success' => false, 'message' => 'Geçersiz dosya türü. İzin verilen: ' . implode(', ', $allowedTypes)];
        }

        $fileName = uniqid() . '.' . $extension;
        $uploadPath = UPLOAD_PATH . '/' . $fileName;

        if (!is_dir(UPLOAD_PATH)) {
            mkdir(UPLOAD_PATH, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['success' => true, 'filename' => $fileName];
        }

        return ['success' => false, 'message' => 'Dosya kaydetme hatası'];
    }
}