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
            // 1. CSRF Token Validation
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (!$this->validateCSRFToken($csrf_token)) {
                $data['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
                $data['csrf_token'] = $this->generateCSRFToken();
                $this->view('admin/auth/login', $data);
                return;
            }

            // 2. Honeypot Validation (Bot Protection)
            if (!$this->validateHoneypot('website')) {
                // Bot detected - log and fake success
                error_log('Bot detected in admin login from IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
                sleep(2); // Delay to confuse bots
                $data['error'] = 'E-posta veya şifre hatalı!'; // Generic error
                $data['csrf_token'] = $this->generateCSRFToken();
                $this->view('admin/auth/login', $data);
                return;
            }

            // 3. Rate Limiting - Strict for admin login
            $rateLimitCheck = $this->checkRateLimit('admin_login', 5, 900); // 5 attempts per 15 minutes
            if (is_array($rateLimitCheck) && !$rateLimitCheck['allowed']) {
                $data['error'] = $rateLimitCheck['message'];
                $data['csrf_token'] = $this->generateCSRFToken();
                $this->view('admin/auth/login', $data);
                return;
            }

            // 4. Sanitize inputs
            $email = $this->sanitizeInputAdvanced($_POST['email'] ?? '', 'email');
            $password = $_POST['password'] ?? ''; // Don't sanitize password

            // 5. Basic validation
            if (empty($email) || empty($password)) {
                $data['error'] = 'E-posta ve şifre alanları zorunludur.';
            }
            // 6. Email format validation
            elseif (!$this->validateEmail($email)) {
                $data['error'] = 'Geçerli bir e-posta adresi giriniz.';
            }
            // 7. Password length check (minimum security)
            elseif (strlen($password) < 4) {
                $data['error'] = 'Şifre en az 4 karakter olmalıdır.';
            }
            else {
                // 8. Check account lockout
                if ($this->isAccountLocked($email)) {
                    $data['error'] = 'Hesabınız geçici olarak kilitlendi. Lütfen 30 dakika sonra tekrar deneyin.';
                } else {
                    // 9. Authenticate user
                    $admin = $this->adminModel->findByEmail($email);
                    
                    if ($admin && $this->adminModel->verifyPassword($password, $admin['password'])) {
                        // Successful login
                        // Clear failed attempts
                        $this->clearFailedAttempts($email);
                        
                        // Regenerate session ID to prevent session fixation
                        session_regenerate_id(true);
                        
                        // Set session variables
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['admin_id'] = $admin['id'];
                        $_SESSION['admin_username'] = $admin['username'];
                        $_SESSION['admin_role'] = $admin['role'];
                        $_SESSION['login_time'] = time();
                        $_SESSION['last_activity'] = time();
                        
                        // Update last login in database
                        $this->adminModel->updateLastLogin($admin['id']);
                        
                        // Log successful login
                        error_log('Admin login successful: ' . $email . ' from IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
                        
                        // Redirect to dashboard
                        $this->redirect('admin/dashboard');
                    } else {
                        // Failed login attempt
                        $this->recordFailedAttempt($email);
                        $remainingAttempts = $this->getRemainingAttempts($email);
                        
                        if ($remainingAttempts > 0) {
                            $data['error'] = 'E-posta veya şifre hatalı! Kalan deneme hakkı: ' . $remainingAttempts;
                        } else {
                            $data['error'] = 'Çok fazla başarısız deneme. Hesabınız 30 dakika süreyle kilitlendi.';
                        }
                        
                        // Log failed attempt
                        error_log('Admin login failed: ' . $email . ' from IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
                    }
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
            // 1. CSRF Token Validation
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (!$this->validateCSRFToken($csrf_token)) {
                $data['error'] = 'Güvenlik hatası!';
                $data['csrf_token'] = $this->generateCSRFToken();
                $this->view('admin/auth/forgot-password', $data);
                return;
            }

            // 2. Honeypot Validation
            if (!$this->validateHoneypot('website')) {
                error_log('Bot detected in forgot password from IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
                sleep(2);
                $data['message'] = 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.'; // Fake success
                $data['csrf_token'] = $this->generateCSRFToken();
                $this->view('admin/auth/forgot-password', $data);
                return;
            }

            // 3. Rate Limiting - Prevent email bombing
            $rateLimitCheck = $this->checkRateLimit('forgot_password', 3, 3600); // 3 attempts per hour
            if (is_array($rateLimitCheck) && !$rateLimitCheck['allowed']) {
                $data['error'] = $rateLimitCheck['message'];
                $data['csrf_token'] = $this->generateCSRFToken();
                $this->view('admin/auth/forgot-password', $data);
                return;
            }

            // 4. Sanitize input
            $email = $this->sanitizeInputAdvanced($_POST['email'] ?? '', 'email');

            if (empty($email)) {
                $data['error'] = 'E-posta adresi zorunludur.';
            }
            elseif (!$this->validateEmail($email)) {
                $data['error'] = 'Geçerli bir e-posta adresi giriniz.';
            }
            else {
                $admin = $this->adminModel->findByEmail($email);
                // Always show success message (don't reveal if email exists)
                $data['message'] = 'Eğer bu e-posta adresi sistemimizde kayıtlıysa, şifre sıfırlama bağlantısı gönderilecektir.';
                
                if ($admin) {
                    // Real implementation: Send email here
                    error_log('Password reset requested for: ' . $email);
                }
            }
        }

        $data['csrf_token'] = $this->generateCSRFToken();
        $this->view('admin/auth/forgot-password', $data);
    }

    /**
     * Check if account is locked due to failed attempts
     */
    private function isAccountLocked($email)
    {
        $key = 'account_lock_' . md5($email);
        
        if (isset($_SESSION[$key])) {
            $lockData = $_SESSION[$key];
            $timeElapsed = time() - $lockData['locked_at'];
            
            // Lock duration: 30 minutes
            if ($timeElapsed < 1800) {
                return true;
            } else {
                // Lock expired, clear it
                unset($_SESSION[$key]);
                $this->clearFailedAttempts($email);
                return false;
            }
        }
        
        return false;
    }

    /**
     * Record failed login attempt
     */
    private function recordFailedAttempt($email)
    {
        $key = 'failed_attempts_' . md5($email);
        
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [
                'count' => 0,
                'first_attempt' => time()
            ];
        }
        
        $_SESSION[$key]['count']++;
        
        // Lock account after 5 failed attempts
        if ($_SESSION[$key]['count'] >= 5) {
            $_SESSION['account_lock_' . md5($email)] = [
                'locked_at' => time(),
                'reason' => 'Too many failed login attempts'
            ];
        }
    }

    /**
     * Get remaining login attempts
     */
    private function getRemainingAttempts($email)
    {
        $key = 'failed_attempts_' . md5($email);
        
        if (!isset($_SESSION[$key])) {
            return 5;
        }
        
        $attempts = $_SESSION[$key]['count'];
        return max(0, 5 - $attempts);
    }

    /**
     * Clear failed login attempts
     */
    private function clearFailedAttempts($email)
    {
        $key = 'failed_attempts_' . md5($email);
        unset($_SESSION[$key]);
        unset($_SESSION['account_lock_' . md5($email)]);
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