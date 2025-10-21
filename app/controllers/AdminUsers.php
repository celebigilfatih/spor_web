<?php
/**
 * AdminUsers Controller
 * User management for admin panel
 */
class AdminUsers extends Controller
{
    private $adminModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->adminModel = $this->model('AdminModel');
    }

    /**
     * List all users
     */
    public function index()
    {
        $users = $this->adminModel->getAll();
        $stats = $this->adminModel->getStatistics();

        $data = [
            'title' => 'Kullanıcı Yönetimi',
            'users' => $users,
            'stats' => $stats,
            'csrf_token' => $this->generateCSRFToken(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/users/index', $data);
    }

    /**
     * Create new user
     */
    public function create()
    {
        $data = [
            'title' => 'Yeni Kullanıcı Ekle',
            'csrf_token' => $this->generateCSRFToken(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
                $this->view('admin/users/create', $data);
                return;
            }

            $errors = $this->validateUserData($_POST);

            if (empty($errors)) {
                $userData = [
                    'username' => $this->sanitizeInput($_POST['username']),
                    'email' => $this->sanitizeInput($_POST['email']),
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    'full_name' => $this->sanitizeInput($_POST['full_name']),
                    'role' => $this->sanitizeInput($_POST['role'] ?? 'admin'),
                    'status' => $this->sanitizeInput($_POST['status'] ?? 'active')
                ];

                $result = $this->adminModel->create($userData);

                if ($result) {
                    $_SESSION['message'] = 'Kullanıcı başarıyla oluşturuldu!';
                    $this->redirect('admin/users');
                    return;
                } else {
                    $data['error'] = 'Kullanıcı oluşturulurken bir hata oluştu.';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }

            $data['old'] = $_POST;
        }

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/users/create', $data);
    }

    /**
     * Edit user
     */
    public function edit($id = null)
    {
        if (!$id) {
            $_SESSION['error'] = 'Geçersiz kullanıcı ID\'si.';
            $this->redirect('admin/users');
            return;
        }

        $user = $this->adminModel->getById($id);

        if (!$user) {
            $_SESSION['error'] = 'Kullanıcı bulunamadı.';
            $this->redirect('admin/users');
            return;
        }

        // Prevent users from editing super_admin if they are not super_admin
        if ($user['role'] === 'super_admin' && ($_SESSION['admin_role'] ?? 'admin') !== 'super_admin') {
            $_SESSION['error'] = 'Yetkisiz işlem! Super admin kullanıcıları düzenleyemezsiniz.';
            $this->redirect('admin/users');
            return;
        }

        $data = [
            'title' => 'Kullanıcı Düzenle',
            'user' => $user,
            'csrf_token' => $this->generateCSRFToken(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
                $this->view('admin/users/edit', $data);
                return;
            }

            $errors = $this->validateUserData($_POST, $id);

            if (empty($errors)) {
                $userData = [
                    'username' => $this->sanitizeInput($_POST['username']),
                    'email' => $this->sanitizeInput($_POST['email']),
                    'full_name' => $this->sanitizeInput($_POST['full_name']),
                    'role' => $this->sanitizeInput($_POST['role'] ?? 'admin'),
                    'status' => $this->sanitizeInput($_POST['status'] ?? 'active')
                ];

                // Only update password if provided
                if (!empty($_POST['password'])) {
                    if ($_POST['password'] !== $_POST['password_confirm']) {
                        $data['error'] = 'Şifreler eşleşmiyor.';
                        $data['old'] = $_POST;
                        $this->view('admin/users/edit', $data);
                        return;
                    }
                    $userData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }

                $result = $this->adminModel->update($id, $userData);

                if ($result) {
                    $_SESSION['message'] = 'Kullanıcı başarıyla güncellendi!';
                    $this->redirect('admin/users');
                    return;
                } else {
                    $data['error'] = 'Kullanıcı güncellenirken bir hata oluştu.';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }

            $data['old'] = $_POST;
        }

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/users/edit', $data);
    }

    /**
     * Delete user
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/users');
            return;
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
            $this->redirect('admin/users');
            return;
        }

        $id = $_POST['id'] ?? '';

        if (empty($id)) {
            $_SESSION['error'] = 'Geçersiz kullanıcı ID\'si.';
            $this->redirect('admin/users');
            return;
        }

        // Prevent deleting yourself
        if ($id == ($_SESSION['admin_id'] ?? 0)) {
            $_SESSION['error'] = 'Kendi hesabınızı silemezsiniz!';
            $this->redirect('admin/users');
            return;
        }

        // Prevent deleting super_admin if not super_admin
        $user = $this->adminModel->getById($id);
        if ($user && $user['role'] === 'super_admin' && ($_SESSION['admin_role'] ?? 'admin') !== 'super_admin') {
            $_SESSION['error'] = 'Yetkisiz işlem! Super admin kullanıcıları silemezsiniz.';
            $this->redirect('admin/users');
            return;
        }

        $result = $this->adminModel->delete($id);

        if ($result) {
            $_SESSION['message'] = 'Kullanıcı başarıyla silindi!';
        } else {
            $_SESSION['error'] = 'Kullanıcı silinirken bir hata oluştu.';
        }

        $this->redirect('admin/users');
    }

    /**
     * View user details
     */
    public function details($id = null)
    {
        if (!$id) {
            $_SESSION['error'] = 'Geçersiz kullanıcı ID\'si.';
            $this->redirect('admin/users');
            return;
        }

        $user = $this->adminModel->getById($id);

        if (!$user) {
            $_SESSION['error'] = 'Kullanıcı bulunamadı.';
            $this->redirect('admin/users');
            return;
        }

        $data = [
            'title' => 'Kullanıcı Detayları',
            'user' => $user,
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/users/view', $data);
    }

    /**
     * Validate user data
     */
    private function validateUserData($data, $excludeId = null)
    {
        $errors = [];

        // Username validation
        if (empty($data['username'])) {
            $errors[] = 'Kullanıcı adı zorunludur.';
        } elseif (strlen($data['username']) < 3) {
            $errors[] = 'Kullanıcı adı en az 3 karakter olmalıdır.';
        } elseif ($this->adminModel->usernameExists($data['username'], $excludeId)) {
            $errors[] = 'Bu kullanıcı adı zaten kullanılıyor.';
        }

        // Email validation
        if (empty($data['email'])) {
            $errors[] = 'E-posta adresi zorunludur.';
        } elseif (!$this->validateEmail($data['email'])) {
            $errors[] = 'Geçerli bir e-posta adresi giriniz.';
        } elseif ($this->adminModel->emailExists($data['email'], $excludeId)) {
            $errors[] = 'Bu e-posta adresi zaten kullanılıyor.';
        }

        // Password validation (only for create)
        if (!$excludeId) {
            if (empty($data['password'])) {
                $errors[] = 'Şifre zorunludur.';
            } elseif (strlen($data['password']) < 6) {
                $errors[] = 'Şifre en az 6 karakter olmalıdır.';
            } elseif ($data['password'] !== ($data['password_confirm'] ?? '')) {
                $errors[] = 'Şifreler eşleşmiyor.';
            }
        }

        // Full name validation
        if (empty($data['full_name'])) {
            $errors[] = 'Ad Soyad zorunludur.';
        }

        // Role validation
        if (empty($data['role']) || !in_array($data['role'], ['admin', 'super_admin'])) {
            $errors[] = 'Geçersiz rol seçimi.';
        }

        // Status validation
        if (empty($data['status']) || !in_array($data['status'], ['active', 'inactive'])) {
            $errors[] = 'Geçersiz durum seçimi.';
        }

        return $errors;
    }
}
