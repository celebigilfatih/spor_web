<?php
/**
 * AdminStaff Controller
 * Staff management for admin panel
 */
class AdminStaff extends Controller
{
    private $staffModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->staffModel = $this->model('TechnicalStaffModel');
    }

    /**
     * Staff list
     */
    public function index()
    {
        $data = [
            'title' => 'Teknik Kadro Yönetimi',
            'staff_members' => $this->staffModel->getAllStaff(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/staff/index', $data);
    }

    /**
     * Create staff member form
     */
    public function create()
    {
        $data = [
            'title' => 'Yeni Teknik Kadro Üyesi Ekle',
            'csrf_token' => $this->generateCSRFToken(),
            'message' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            // CSRF token kontrolü
            if (!$this->validateCSRFToken($csrf_token)) {
                $data['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
            } else {
                $staffData = [
                    'name' => $this->sanitizeInput($_POST['name']),
                    'position' => $this->sanitizeInput($_POST['position']),
                    'role' => $this->sanitizeInput($_POST['position']), // Same as position for compatibility
                    'experience' => $this->sanitizeInput($_POST['experience']),
                    'license' => $this->sanitizeInput($_POST['license']),
                    'bio' => $this->sanitizeInput($_POST['bio']),
                    'status' => 'active'
                ];

                // Handle photo upload
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                    $uploadResult = $this->uploadFile($_FILES['photo'], ['jpg', 'jpeg', 'png']);
                    if ($uploadResult['success']) {
                        $staffData['photo'] = $uploadResult['filename'];
                    }
                }

                $result = $this->staffModel->create($staffData);
                if ($result) {
                    $_SESSION['message'] = 'Teknik kadro üyesi başarıyla eklendi!';
                    $this->redirect('admin/staff');
                } else {
                    $dbError = $this->staffModel->getLastError();
                    $data['error'] = 'Teknik kadro üyesi eklenirken bir hata oluştu!';
                    if ($dbError) {
                        $data['error'] .= ' (' . $dbError . ')';
                    }
                }
            }
        }

        $this->view('admin/staff/create', $data);
    }

    /**
     * Edit staff member
     */
    public function edit($id = null)
    {
        if (!$id) {
            $this->redirect('admin/staff');
        }

        $staff = $this->staffModel->findById($id);
        if (!$staff) {
            $_SESSION['error'] = 'Teknik kadro üyesi bulunamadı!';
            $this->redirect('admin/staff');
        }

        $data = [
            'title' => 'Teknik Kadro Üyesi Düzenle',
            'staff' => $staff,
            'csrf_token' => $this->generateCSRFToken(),
            'message' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            // CSRF token kontrolü
            if (!$this->validateCSRFToken($csrf_token)) {
                $data['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
            } else {
                $staffData = [
                    'name' => $this->sanitizeInput($_POST['name']),
                    'position' => $this->sanitizeInput($_POST['position']),
                    'role' => $this->sanitizeInput($_POST['position']), // Same as position for compatibility
                    'experience' => $this->sanitizeInput($_POST['experience']),
                    'license' => $this->sanitizeInput($_POST['license']),
                    'bio' => $this->sanitizeInput($_POST['bio']),
                    'status' => $this->sanitizeInput($_POST['status'])
                ];

                // Handle photo upload
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                    $uploadResult = $this->uploadFile($_FILES['photo'], ['jpg', 'jpeg', 'png']);
                    if ($uploadResult['success']) {
                        $staffData['photo'] = $uploadResult['filename'];
                    }
                }

                if ($this->staffModel->update($id, $staffData)) {
                    $data['message'] = 'Teknik kadro üyesi başarıyla güncellendi!';
                    $data['staff'] = $this->staffModel->findById($id);
                } else {
                    $data['error'] = 'Teknik kadro üyesi güncellenirken bir hata oluştu!';
                }
            }
        }

        $this->view('admin/staff/edit', $data);
    }

    /**
     * Delete staff member
     */
    public function delete($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Geçersiz istek']);
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $this->jsonResponse(['success' => false, 'message' => 'Güvenlik hatası']);
        }

        $staff = $this->staffModel->findById($id);
        if (!$staff) {
            $this->jsonResponse(['success' => false, 'message' => 'Teknik kadro üyesi bulunamadı']);
        }

        // Varsa fotoğrafı sil
        if ($staff['photo']) {
            $imagePath = UPLOAD_PATH . '/' . $staff['photo'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($this->staffModel->delete($id)) {
            $this->jsonResponse(['success' => true, 'message' => 'Teknik kadro üyesi başarıyla silindi']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Teknik kadro üyesi silinirken hata oluştu']);
        }
    }
}
?>