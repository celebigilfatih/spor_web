<?php
/**
 * Admin About Controller
 * Hakkımızda sayfası yönetimi
 */
class AdminAbout extends Controller
{
    private $aboutModel;

    public function __construct()
    {
        // Check admin authentication
        if (!isset($_SESSION['admin_logged_in'])) {
            $this->redirect('admin/login');
        }

        $this->aboutModel = $this->model('AboutUs');
    }

    /**
     * Liste sayfası
     */
    public function index()
    {
        $sections = $this->aboutModel->getAll();

        $data = [
            'title' => 'Hakkımızda Yönetimi',
            'sections' => $sections,
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/about/index', $data);
    }

    /**
     * Yeni bölüm oluştur
     */
    public function create()
    {
        $data = [
            'title' => 'Yeni Bölüm Ekle',
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/about/create', $data);
                return;
            }

            $formData = [
                'section_name' => $this->sanitizeInput($_POST['section_name'] ?? ''),
                'title' => $this->sanitizeInput($_POST['title'] ?? ''),
                'content' => $_POST['content'] ?? '', // HTML content
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'image' => null
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/uploads/about/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $fileName = uniqid('about_') . '.' . $extension;
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                        $formData['image'] = '/uploads/about/' . $fileName;
                    }
                }
            }

            $errors = $this->aboutModel->validate($formData);

            if (empty($errors)) {
                if ($this->aboutModel->create($formData)) {
                    $_SESSION['success'] = 'Bölüm başarıyla eklendi!';
                    $this->redirect('admin/about');
                } else {
                    $data['error'] = 'Bölüm eklenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/about/create', $data);
    }

    /**
     * Bölüm düzenle
     */
    public function edit($id = null)
    {
        if (!$id) {
            $this->redirect('admin/about');
        }

        $section = $this->aboutModel->findById($id);
        if (!$section) {
            $_SESSION['error'] = 'Bölüm bulunamadı!';
            $this->redirect('admin/about');
        }

        $data = [
            'title' => 'Bölüm Düzenle',
            'section' => $section,
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/about/edit', $data);
                return;
            }

            $formData = [
                'section_name' => $this->sanitizeInput($_POST['section_name'] ?? ''),
                'title' => $this->sanitizeInput($_POST['title'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'image' => $section['image'] // Keep existing image
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/uploads/about/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $fileName = uniqid('about_') . '.' . $extension;
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                        // Delete old image if exists
                        if (!empty($section['image']) && file_exists(BASE_PATH . '/public' . $section['image'])) {
                            unlink(BASE_PATH . '/public' . $section['image']);
                        }
                        $formData['image'] = '/uploads/about/' . $fileName;
                    }
                }
            }

            $errors = $this->aboutModel->validate($formData);

            if (empty($errors)) {
                if ($this->aboutModel->update($id, $formData)) {
                    $_SESSION['success'] = 'Bölüm başarıyla güncellendi!';
                    $this->redirect('admin/about');
                } else {
                    $data['error'] = 'Bölüm güncellenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/about/edit', $data);
    }

    /**
     * Bölüm sil
     */
    public function delete($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/about');
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Geçersiz form gönderimi!';
            $this->redirect('admin/about');
        }

        $section = $this->aboutModel->findById($id);
        if ($section) {
            // Delete image if exists
            if (!empty($section['image']) && file_exists(BASE_PATH . '/public' . $section['image'])) {
                unlink(BASE_PATH . '/public' . $section['image']);
            }

            if ($this->aboutModel->delete($id)) {
                $_SESSION['success'] = 'Bölüm başarıyla silindi!';
            } else {
                $_SESSION['error'] = 'Bölüm silinirken bir hata oluştu!';
            }
        } else {
            $_SESSION['error'] = 'Bölüm bulunamadı!';
        }

        $this->redirect('admin/about');
    }

    /**
     * Durum değiştir
     */
    public function toggleStatus($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Geçersiz istek!']);
            return;
        }

        $section = $this->aboutModel->findById($id);
        if (!$section) {
            echo json_encode(['success' => false, 'message' => 'Bölüm bulunamadı!']);
            return;
        }

        $newStatus = $section['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->aboutModel->update($id, ['status' => $newStatus])) {
            echo json_encode(['success' => true, 'status' => $newStatus]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Durum güncellenemedi!']);
        }
    }
}
