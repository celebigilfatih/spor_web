<?php
/**
 * Admin Achievements Controller
 * Başarılar sayfası yönetimi
 */
class AdminAchievements extends Controller
{
    private $trophiesModel;
    private $achievementsModel;
    private $legendsModel;
    private $recordsModel;

    public function __construct()
    {
        // Check admin authentication
        if (!isset($_SESSION['admin_logged_in'])) {
            $this->redirect('admin/login');
        }

        $this->trophiesModel = $this->model('Trophies');
        $this->achievementsModel = $this->model('Achievements');
        $this->legendsModel = $this->model('Legends');
        $this->recordsModel = $this->model('Records');
    }

    /**
     * Liste sayfası
     */
    public function index()
    {
        $trophies = $this->trophiesModel->getAll();
        $achievements = $this->achievementsModel->getAll();
        $legends = $this->legendsModel->getAll();
        $records = $this->recordsModel->getAll();

        $data = [
            'title' => 'Başarılar Yönetimi',
            'trophies' => $trophies,
            'achievements' => $achievements,
            'legends' => $legends,
            'records' => $records,
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/achievements/index', $data);
    }

    /**
     * Kupa yönetimi
     */
    public function trophies()
    {
        $trophies = $this->trophiesModel->getAll();

        $data = [
            'title' => 'Kupa Yönetimi',
            'trophies' => $trophies,
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/achievements/trophies', $data);
    }

    /**
     * Yeni kupa ekle
     */
    public function createTrophy()
    {
        $data = [
            'title' => 'Yeni Kupa Ekle',
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/achievements/create-trophy', $data);
                return;
            }

            $formData = [
                'category' => $this->sanitizeInput($_POST['category'] ?? ''),
                'title' => $this->sanitizeInput($_POST['title'] ?? ''),
                'count' => (int)($_POST['count'] ?? 0),
                'years' => $this->sanitizeInput($_POST['years'] ?? ''),
                'description' => $this->sanitizeInput($_POST['description'] ?? ''),
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'image' => null
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/uploads/achievements/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $fileName = uniqid('trophy_') . '.' . $extension;
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                        $formData['image'] = '/uploads/achievements/' . $fileName;
                    }
                }
            }

            $errors = $this->trophiesModel->validate($formData);

            if (empty($errors)) {
                if ($this->trophiesModel->create($formData)) {
                    $_SESSION['success'] = 'Kupa başarıyla eklendi!';
                    $this->redirect('admin/achievements/trophies');
                } else {
                    $data['error'] = 'Kupa eklenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/achievements/create-trophy', $data);
    }

    /**
     * Kupa düzenle
     */
    public function editTrophy($id = null)
    {
        if (!$id) {
            $this->redirect('admin/achievements/trophies');
        }

        $trophy = $this->trophiesModel->findById($id);
        if (!$trophy) {
            $_SESSION['error'] = 'Kupa bulunamadı!';
            $this->redirect('admin/achievements/trophies');
        }

        $data = [
            'title' => 'Kupa Düzenle',
            'trophy' => $trophy,
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/achievements/edit-trophy', $data);
                return;
            }

            $formData = [
                'category' => $this->sanitizeInput($_POST['category'] ?? ''),
                'title' => $this->sanitizeInput($_POST['title'] ?? ''),
                'count' => (int)($_POST['count'] ?? 0),
                'years' => $this->sanitizeInput($_POST['years'] ?? ''),
                'description' => $this->sanitizeInput($_POST['description'] ?? ''),
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'image' => $trophy['image'] // Keep existing image
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/uploads/achievements/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $fileName = uniqid('trophy_') . '.' . $extension;
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                        // Delete old image if exists
                        if (!empty($trophy['image']) && file_exists(BASE_PATH . '/public' . $trophy['image'])) {
                            unlink(BASE_PATH . '/public' . $trophy['image']);
                        }
                        $formData['image'] = '/uploads/achievements/' . $fileName;
                    }
                }
            }

            $errors = $this->trophiesModel->validate($formData);

            if (empty($errors)) {
                if ($this->trophiesModel->update($id, $formData)) {
                    $_SESSION['success'] = 'Kupa başarıyla güncellendi!';
                    $this->redirect('admin/achievements/trophies');
                } else {
                    $data['error'] = 'Kupa güncellenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/achievements/edit-trophy', $data);
    }

    /**
     * Kupa sil
     */
    public function deleteTrophy($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/achievements/trophies');
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Geçersiz form gönderimi!';
            $this->redirect('admin/achievements/trophies');
        }

        $trophy = $this->trophiesModel->findById($id);
        if ($trophy) {
            // Delete image if exists
            if (!empty($trophy['image']) && file_exists(BASE_PATH . '/public' . $trophy['image'])) {
                unlink(BASE_PATH . '/public' . $trophy['image']);
            }

            if ($this->trophiesModel->delete($id)) {
                $_SESSION['success'] = 'Kupa başarıyla silindi!';
            } else {
                $_SESSION['error'] = 'Kupa silinirken bir hata oluştu!';
            }
        } else {
            $_SESSION['error'] = 'Kupa bulunamadı!';
        }

        $this->redirect('admin/achievements/trophies');
    }

    /**
     * Başarı yönetimi
     */
    public function achievements()
    {
        $achievements = $this->achievementsModel->getAll();

        $data = [
            'title' => 'Başarı Yönetimi',
            'achievements' => $achievements,
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/achievements/achievements', $data);
    }

    /**
     * Yeni başarı ekle
     */
    public function createAchievement()
    {
        $data = [
            'title' => 'Yeni Başarı Ekle',
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/achievements/create-achievement', $data);
                return;
            }

            $formData = [
                'title' => $this->sanitizeInput($_POST['title'] ?? ''),
                'description' => $this->sanitizeInput($_POST['description'] ?? ''),
                'category' => $this->sanitizeInput($_POST['category'] ?? ''),
                'year' => (int)($_POST['year'] ?? 0),
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'image' => null
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/uploads/achievements/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $fileName = uniqid('achievement_') . '.' . $extension;
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                        $formData['image'] = '/uploads/achievements/' . $fileName;
                    }
                }
            }

            $errors = $this->achievementsModel->validate($formData);

            if (empty($errors)) {
                if ($this->achievementsModel->create($formData)) {
                    $_SESSION['success'] = 'Başarı başarıyla eklendi!';
                    $this->redirect('admin/achievements/achievements');
                } else {
                    $data['error'] = 'Başarı eklenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/achievements/create-achievement', $data);
    }

    /**
     * Başarı düzenle
     */
    public function editAchievement($id = null)
    {
        if (!$id) {
            $this->redirect('admin/achievements/achievements');
        }

        $achievement = $this->achievementsModel->findById($id);
        if (!$achievement) {
            $_SESSION['error'] = 'Başarı bulunamadı!';
            $this->redirect('admin/achievements/achievements');
        }

        $data = [
            'title' => 'Başarı Düzenle',
            'achievement' => $achievement,
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/achievements/edit-achievement', $data);
                return;
            }

            $formData = [
                'title' => $this->sanitizeInput($_POST['title'] ?? ''),
                'description' => $this->sanitizeInput($_POST['description'] ?? ''),
                'category' => $this->sanitizeInput($_POST['category'] ?? ''),
                'year' => (int)($_POST['year'] ?? 0),
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'image' => $achievement['image'] // Keep existing image
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/uploads/achievements/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $fileName = uniqid('achievement_') . '.' . $extension;
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                        // Delete old image if exists
                        if (!empty($achievement['image']) && file_exists(BASE_PATH . '/public' . $achievement['image'])) {
                            unlink(BASE_PATH . '/public' . $achievement['image']);
                        }
                        $formData['image'] = '/uploads/achievements/' . $fileName;
                    }
                }
            }

            $errors = $this->achievementsModel->validate($formData);

            if (empty($errors)) {
                if ($this->achievementsModel->update($id, $formData)) {
                    $_SESSION['success'] = 'Başarı başarıyla güncellendi!';
                    $this->redirect('admin/achievements/achievements');
                } else {
                    $data['error'] = 'Başarı güncellenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/achievements/edit-achievement', $data);
    }

    /**
     * Başarı sil
     */
    public function deleteAchievement($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/achievements/achievements');
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Geçersiz form gönderimi!';
            $this->redirect('admin/achievements/achievements');
        }

        $achievement = $this->achievementsModel->findById($id);
        if ($achievement) {
            // Delete image if exists
            if (!empty($achievement['image']) && file_exists(BASE_PATH . '/public' . $achievement['image'])) {
                unlink(BASE_PATH . '/public' . $achievement['image']);
            }

            if ($this->achievementsModel->delete($id)) {
                $_SESSION['success'] = 'Başarı başarıyla silindi!';
            } else {
                $_SESSION['error'] = 'Başarı silinirken bir hata oluştu!';
            }
        } else {
            $_SESSION['error'] = 'Başarı bulunamadı!';
        }

        $this->redirect('admin/achievements/achievements');
    }

    /**
     * Efsane yönetimi
     */
    public function legends()
    {
        $legends = $this->legendsModel->getAll();

        $data = [
            'title' => 'Efsaneler Yönetimi',
            'legends' => $legends,
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/achievements/legends', $data);
    }

    /**
     * Yeni efsane ekle
     */
    public function createLegend()
    {
        $data = [
            'title' => 'Yeni Efsane Ekle',
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/achievements/create-legend', $data);
                return;
            }

            $formData = [
                'name' => $this->sanitizeInput($_POST['name'] ?? ''),
                'position' => $this->sanitizeInput($_POST['position'] ?? ''),
                'years' => $this->sanitizeInput($_POST['years'] ?? ''),
                'stats' => $this->sanitizeInput($_POST['stats'] ?? ''),
                'bio' => $this->sanitizeInput($_POST['bio'] ?? ''),
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'image' => null
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/uploads/achievements/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $fileName = uniqid('legend_') . '.' . $extension;
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                        $formData['image'] = '/uploads/achievements/' . $fileName;
                    }
                }
            }

            $errors = $this->legendsModel->validate($formData);

            if (empty($errors)) {
                if ($this->legendsModel->create($formData)) {
                    $_SESSION['success'] = 'Efsane başarıyla eklendi!';
                    $this->redirect('admin/achievements/legends');
                } else {
                    $data['error'] = 'Efsane eklenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/achievements/create-legend', $data);
    }

    /**
     * Efsane düzenle
     */
    public function editLegend($id = null)
    {
        if (!$id) {
            $this->redirect('admin/achievements/legends');
        }

        $legend = $this->legendsModel->findById($id);
        if (!$legend) {
            $_SESSION['error'] = 'Efsane bulunamadı!';
            $this->redirect('admin/achievements/legends');
        }

        $data = [
            'title' => 'Efsane Düzenle',
            'legend' => $legend,
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/achievements/edit-legend', $data);
                return;
            }

            $formData = [
                'name' => $this->sanitizeInput($_POST['name'] ?? ''),
                'position' => $this->sanitizeInput($_POST['position'] ?? ''),
                'years' => $this->sanitizeInput($_POST['years'] ?? ''),
                'stats' => $this->sanitizeInput($_POST['stats'] ?? ''),
                'bio' => $this->sanitizeInput($_POST['bio'] ?? ''),
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'image' => $legend['image'] // Keep existing image
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/uploads/achievements/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $fileName = uniqid('legend_') . '.' . $extension;
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                        // Delete old image if exists
                        if (!empty($legend['image']) && file_exists(BASE_PATH . '/public' . $legend['image'])) {
                            unlink(BASE_PATH . '/public' . $legend['image']);
                        }
                        $formData['image'] = '/uploads/achievements/' . $fileName;
                    }
                }
            }

            $errors = $this->legendsModel->validate($formData);

            if (empty($errors)) {
                if ($this->legendsModel->update($id, $formData)) {
                    $_SESSION['success'] = 'Efsane başarıyla güncellendi!';
                    $this->redirect('admin/achievements/legends');
                } else {
                    $data['error'] = 'Efsane güncellenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/achievements/edit-legend', $data);
    }

    /**
     * Efsane sil
     */
    public function deleteLegend($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/achievements/legends');
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Geçersiz form gönderimi!';
            $this->redirect('admin/achievements/legends');
        }

        $legend = $this->legendsModel->findById($id);
        if ($legend) {
            // Delete image if exists
            if (!empty($legend['image']) && file_exists(BASE_PATH . '/public' . $legend['image'])) {
                unlink(BASE_PATH . '/public' . $legend['image']);
            }

            if ($this->legendsModel->delete($id)) {
                $_SESSION['success'] = 'Efsane başarıyla silindi!';
            } else {
                $_SESSION['error'] = 'Efsane silinirken bir hata oluştu!';
            }
        } else {
            $_SESSION['error'] = 'Efsane bulunamadı!';
        }

        $this->redirect('admin/achievements/legends');
    }

    /**
     * Rekor yönetimi
     */
    public function records()
    {
        $records = $this->recordsModel->getAll();

        $data = [
            'title' => 'Rekorlar Yönetimi',
            'records' => $records,
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/achievements/records', $data);
    }

    /**
     * Yeni rekor ekle
     */
    public function createRecord()
    {
        $data = [
            'title' => 'Yeni Rekor Ekle',
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/achievements/create-record', $data);
                return;
            }

            $formData = [
                'title' => $this->sanitizeInput($_POST['title'] ?? ''),
                'holder' => $this->sanitizeInput($_POST['holder'] ?? ''),
                'value' => $this->sanitizeInput($_POST['value'] ?? ''),
                'description' => $this->sanitizeInput($_POST['description'] ?? ''),
                'category' => $this->sanitizeInput($_POST['category'] ?? ''),
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'image' => null
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/uploads/achievements/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $fileName = uniqid('record_') . '.' . $extension;
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                        $formData['image'] = '/uploads/achievements/' . $fileName;
                    }
                }
            }

            $errors = $this->recordsModel->validate($formData);

            if (empty($errors)) {
                if ($this->recordsModel->create($formData)) {
                    $_SESSION['success'] = 'Rekor başarıyla eklendi!';
                    $this->redirect('admin/achievements/records');
                } else {
                    $data['error'] = 'Rekor eklenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/achievements/create-record', $data);
    }

    /**
     * Rekor düzenle
     */
    public function editRecord($id = null)
    {
        if (!$id) {
            $this->redirect('admin/achievements/records');
        }

        $record = $this->recordsModel->findById($id);
        if (!$record) {
            $_SESSION['error'] = 'Rekor bulunamadı!';
            $this->redirect('admin/achievements/records');
        }

        $data = [
            'title' => 'Rekor Düzenle',
            'record' => $record,
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/achievements/edit-record', $data);
                return;
            }

            $formData = [
                'title' => $this->sanitizeInput($_POST['title'] ?? ''),
                'holder' => $this->sanitizeInput($_POST['holder'] ?? ''),
                'value' => $this->sanitizeInput($_POST['value'] ?? ''),
                'description' => $this->sanitizeInput($_POST['description'] ?? ''),
                'category' => $this->sanitizeInput($_POST['category'] ?? ''),
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'image' => $record['image'] // Keep existing image
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/uploads/achievements/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    $fileName = uniqid('record_') . '.' . $extension;
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                        // Delete old image if exists
                        if (!empty($record['image']) && file_exists(BASE_PATH . '/public' . $record['image'])) {
                            unlink(BASE_PATH . '/public' . $record['image']);
                        }
                        $formData['image'] = '/uploads/achievements/' . $fileName;
                    }
                }
            }

            $errors = $this->recordsModel->validate($formData);

            if (empty($errors)) {
                if ($this->recordsModel->update($id, $formData)) {
                    $_SESSION['success'] = 'Rekor başarıyla güncellendi!';
                    $this->redirect('admin/achievements/records');
                } else {
                    $data['error'] = 'Rekor güncellenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/achievements/edit-record', $data);
    }

    /**
     * Rekor sil
     */
    public function deleteRecord($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/achievements/records');
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Geçersiz form gönderimi!';
            $this->redirect('admin/achievements/records');
        }

        $record = $this->recordsModel->findById($id);
        if ($record) {
            // Delete image if exists
            if (!empty($record['image']) && file_exists(BASE_PATH . '/public' . $record['image'])) {
                unlink(BASE_PATH . '/public' . $record['image']);
            }

            if ($this->recordsModel->delete($id)) {
                $_SESSION['success'] = 'Rekor başarıyla silindi!';
            } else {
                $_SESSION['error'] = 'Rekor silinirken bir hata oluştu!';
            }
        } else {
            $_SESSION['error'] = 'Rekor bulunamadı!';
        }

        $this->redirect('admin/achievements/records');
    }
}