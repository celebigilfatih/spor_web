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
        // Data dizisini değişkenlere çevir
        extract($data);
        
        require_once BASE_PATH . '/app/views/' . $view . '.php';
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
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            $this->redirect('admin/login');
        }
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
     */
    public function sanitizeInput($input)
    {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Dosya yükleme işlemi
     */
    public function uploadFile($file, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'])
    {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Dosya yükleme hatası'];
        }

        $fileInfo = pathinfo($file['name']);
        $extension = strtolower($fileInfo['extension']);

        if (!in_array($extension, $allowedTypes)) {
            return ['success' => false, 'message' => 'Geçersiz dosya türü'];
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