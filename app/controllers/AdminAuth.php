<?php
/**
 * AdminAuth Controller
 * Admin giriş/çıkış işlemleri
 */
class AdminAuth extends Controller
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = $this->model('Admin');
    }

    /**
     * Ana sayfa - giriş sayfasına yönlendir
     */
    public function index()
    {
        $this->redirect('admin/login');
    }

    /**
     * Giriş sayfası
     */
    public function login()
    {
        // Zaten giriş yapmış ise dashboard'a yönlendir
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            $this->redirect('admin/dashboard');
        }

        $data = [
            'title' => 'Admin Girişi',
            'error' => ''
        ];

        // POST isteği ise giriş işlemini gerçekleştir
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $this->sanitizeInput($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $csrf_token = $_POST['csrf_token'] ?? '';

            // CSRF token kontrolü
            if (!$this->validateCSRFToken($csrf_token)) {
                $data['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
            }
            // Email ve şifre kontrolü
            elseif (empty($email) || empty($password)) {
                $data['error'] = 'E-posta ve şifre alanları zorunludur.';
            }
            else {
                // Kullanıcıyı veritabanında ara
                $admin = $this->adminModel->findByEmail($email);
                
                if ($admin && $this->adminModel->verifyPassword($password, $admin['password'])) {
                    // Başarılı giriş
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_role'] = $admin['role'];
                    
                    // Son giriş zamanını güncelle
                    $this->adminModel->updateLastLogin($admin['id']);
                    
                    // Dashboard'a yönlendir
                    $this->redirect('admin/dashboard');
                } else {
                    $data['error'] = 'E-posta veya şifre hatalı!';
                }
            }
        }

        // CSRF token oluştur
        $data['csrf_token'] = $this->generateCSRFToken();

        $this->view('admin/auth/login', $data);
    }

    /**
     * Çıkış işlemi
     */
    public function logout()
    {
        // Oturum verilerini temizle
        session_unset();
        session_destroy();
        
        // Giriş sayfasına yönlendir
        $this->redirect('admin/login');
    }

    /**
     * Şifre sıfırlama (basit implementasyon)
     */
    public function forgotPassword()
    {
        $data = [
            'title' => 'Şifre Sıfırlama',
            'message' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $this->sanitizeInput($_POST['email'] ?? '');
            $csrf_token = $_POST['csrf_token'] ?? '';

            if (!$this->validateCSRFToken($csrf_token)) {
                $data['error'] = 'Güvenlik hatası!';
            }
            elseif (empty($email)) {
                $data['error'] = 'E-posta adresi zorunludur.';
            }
            else {
                $admin = $this->adminModel->findByEmail($email);
                if ($admin) {
                    // Gerçek uygulamada burada e-posta gönderilir
                    $data['message'] = 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.';
                } else {
                    $data['error'] = 'Bu e-posta adresi ile kayıtlı kullanıcı bulunamadı.';
                }
            }
        }

        $data['csrf_token'] = $this->generateCSRFToken();
        $this->view('admin/auth/forgot-password', $data);
    }

    /**
     * Profil düzenleme
     */
    public function profile()
    {
        $this->requireAdmin();

        $data = [
            'title' => 'Profil Düzenleme',
            'message' => '',
            'error' => ''
        ];

        $adminId = $_SESSION['admin_id'];
        $admin = $this->adminModel->findById($adminId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $this->sanitizeInput($_POST['username'] ?? '');
            $email = $this->sanitizeInput($_POST['email'] ?? '');
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $csrf_token = $_POST['csrf_token'] ?? '';

            if (!$this->validateCSRFToken($csrf_token)) {
                $data['error'] = 'Güvenlik hatası!';
            }
            elseif (empty($username) || empty($email)) {
                $data['error'] = 'Kullanıcı adı ve e-posta zorunludur.';
            }
            else {
                $updateData = [
                    'username' => $username,
                    'email' => $email
                ];

                // Şifre değişikliği isteniyorsa
                if (!empty($newPassword)) {
                    if (!$this->adminModel->verifyPassword($currentPassword, $admin['password'])) {
                        $data['error'] = 'Mevcut şifre hatalı!';
                    }
                    elseif ($newPassword !== $confirmPassword) {
                        $data['error'] = 'Yeni şifreler eşleşmiyor!';
                    }
                    elseif (strlen($newPassword) < 6) {
                        $data['error'] = 'Yeni şifre en az 6 karakter olmalıdır!';
                    }
                    else {
                        $updateData['password'] = $this->adminModel->hashPassword($newPassword);
                    }
                }

                if (empty($data['error'])) {
                    if ($this->adminModel->update($adminId, $updateData)) {
                        $data['message'] = 'Profil başarıyla güncellendi!';
                        $_SESSION['admin_username'] = $username;
                        $admin = $this->adminModel->findById($adminId); // Güncel veriyi al
                    } else {
                        $data['error'] = 'Profil güncellenirken hata oluştu!';
                    }
                }
            }
        }

        $data['admin'] = $admin;
        $data['csrf_token'] = $this->generateCSRFToken();
        $this->view('admin/auth/profile', $data);
    }
}