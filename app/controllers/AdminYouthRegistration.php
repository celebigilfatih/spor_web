<?php
/**
 * AdminYouthRegistration Controller
 * Admin paneli alt yapı kayıt yönetimi
 */
class AdminYouthRegistration extends Controller
{
    public function __construct()
    {
        $this->requireAdmin();
    }

    /**
     * Alt yapı kayıt listesi
     */
    public function index()
    {
        $registrations = $this->getRegistrations();
        
        // Load youth groups for display
        $youthGroupModel = $this->model('YouthGroup');
        $youthGroups = $youthGroupModel->getAll();
        
        // Create a mapping of group ID to group data
        $groupsById = [];
        foreach ($youthGroups as $group) {
            $groupsById[$group['id']] = $group;
        }
        
        $data = [
            'title' => 'Alt Yapı Kayıtları',
            'registrations' => $registrations,
            'youth_groups' => $groupsById,
            'csrf_token' => $this->generateCSRFToken(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/youth-registrations/index', $data);
    }

    /**
     * Yeni kayıt ekleme formu
     */
    public function create()
    {
        // Load youth groups for selection
        $youthGroupModel = $this->model('YouthGroup');
        $youthGroups = $youthGroupModel->getActive();
        
        $data = [
            'title' => 'Yeni Alt Yapı Kaydı Ekle',
            'youth_groups' => $youthGroups,
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Güvenlik hatası. Lütfen tekrar deneyin.';
                $this->view('admin/youth-registrations/create', $data);
                return;
            }

            $errors = $this->validateRegistrationData($_POST);
            
            if (empty($errors)) {
                // Handle photo upload
                $photoPath = '';
                if (isset($_FILES['student_photo']) && $_FILES['student_photo']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = $this->uploadFile($_FILES['student_photo'], ['jpg', 'jpeg', 'png', 'webp']);
                    if ($uploadResult['success']) {
                        $photoPath = '/uploads/' . $uploadResult['filename'];
                    } else {
                        $errors[] = 'Fotoğraf yüklenirken hata oluştu: ' . $uploadResult['message'];
                    }
                }

                if (empty($errors)) {
                    $registrationData = [
                        'student' => [
                            'name' => $this->sanitizeInput($_POST['student_name'] ?? ''),
                            'birth_date' => $this->sanitizeInput($_POST['birth_date'] ?? ''),
                            'birth_place' => $this->sanitizeInput($_POST['birth_place'] ?? ''),
                            'tc_number' => $this->sanitizeInput($_POST['tc_number'] ?? ''),
                            'father_name' => $this->sanitizeInput($_POST['father_name'] ?? ''),
                            'mother_name' => $this->sanitizeInput($_POST['mother_name'] ?? ''),
                            'school_info' => $this->sanitizeInput($_POST['school_info'] ?? ''),
                            'first_club' => $this->sanitizeInput($_POST['first_club'] ?? ''),
                        ],
                        'parent' => [
                            'name' => $this->sanitizeInput($_POST['parent_name'] ?? ''),
                            'phone' => $this->sanitizeInput($_POST['parent_phone'] ?? ''),
                            'address' => $this->sanitizeInput($_POST['address'] ?? ''),
                            'email' => $this->sanitizeInput($_POST['email'] ?? ''),
                            'father_job' => $this->sanitizeInput($_POST['father_job'] ?? ''),
                            'mother_job' => $this->sanitizeInput($_POST['mother_job'] ?? ''),
                        ],
                        'emergency' => [
                            'contact' => $this->sanitizeInput($_POST['emergency_contact'] ?? ''),
                            'relation' => $this->sanitizeInput($_POST['emergency_relation'] ?? ''),
                            'phone' => $this->sanitizeInput($_POST['emergency_phone'] ?? ''),
                        ],
                        'youth_group_id' => (int)($_POST['youth_group_id'] ?? 0),
                        'photo_path' => $photoPath,
                        'status' => 'pending',
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => 'admin'
                    ];

                    if ($this->saveRegistration($registrationData)) {
                        $_SESSION['message'] = 'Kayıt başarıyla eklendi!';
                        $this->redirect('admin/youth-registrations');
                        return;
                    } else {
                        $data['error'] = 'Kayıt eklenirken bir hata oluştu.';
                    }
                }
            }
            
            $data['errors'] = $errors;
        }

        $this->view('admin/youth-registrations/create', $data);
    }

    /**
     * Kayıt detaylarını görüntüle
     */
    public function viewRegistration($id = null)
    {
        if (!$id) {
            $_SESSION['error'] = 'Geçersiz kayıt ID\'si.';
            $this->redirect('admin/youth-registrations');
            return;
        }

        $registration = $this->getRegistrationById($id);
        
        if (!$registration) {
            $_SESSION['error'] = 'Kayıt bulunamadı.';
            $this->redirect('admin/youth-registrations');
            return;
        }

        $data = [
            'title' => 'Kayıt Detayları',
            'registration' => $registration,
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/youth-registrations/view', $data);
    }

    /**
     * Kayıt durumunu güncelle
     */
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/youth-registrations');
            return;
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Güvenlik hatası. Lütfen tekrar deneyin.';
            $this->redirect('admin/youth-registrations');
            return;
        }

        $id = $_POST['id'] ?? '';
        $status = $_POST['status'] ?? '';
        $notes = $_POST['notes'] ?? '';

        if (empty($id) || empty($status)) {
            $_SESSION['error'] = 'Gerekli alanlar eksik.';
            $this->redirect('admin/youth-registrations');
            return;
        }

        if ($this->updateRegistrationStatus($id, $status, $notes)) {
            $_SESSION['message'] = 'Kayıt durumu başarıyla güncellendi.';
        } else {
            $_SESSION['error'] = 'Kayıt durumu güncellenirken bir hata oluştu.';
        }

        $this->redirect('admin/youth-registrations');
    }

    /**
     * Kayıt sil
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/youth-registrations');
            return;
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Güvenlik hatası. Lütfen tekrar deneyin.';
            $this->redirect('admin/youth-registrations');
            return;
        }

        $id = $_POST['id'] ?? '';

        if (empty($id)) {
            $_SESSION['error'] = 'Geçersiz kayıt ID\'si.';
            $this->redirect('admin/youth-registrations');
            return;
        }

        if ($this->deleteRegistration($id)) {
            $_SESSION['message'] = 'Kayıt başarıyla silindi.';
        } else {
            $_SESSION['error'] = 'Kayıt silinirken bir hata oluştu.';
        }

        $this->redirect('admin/youth-registrations');
    }

    /**
     * Tüm kayıtları getir
     */
    private function getRegistrations()
    {
        $registrationsDir = BASE_PATH . '/data/youth-registrations';
        $registrations = [];

        if (!is_dir($registrationsDir)) {
            return $registrations;
        }

        $files = glob($registrationsDir . '/*.json');
        
        foreach ($files as $file) {
            $data = json_decode(file_get_contents($file), true);
            if ($data) {
                $data['id'] = basename($file, '.json');
                $data['file_path'] = $file;
                $registrations[] = $data;
            }
        }

        // Tarihe göre sırala (en yeni önce)
        usort($registrations, function($a, $b) {
            $dateA = $a['created_at'] ?? $a['registration_date'] ?? '1970-01-01';
            $dateB = $b['created_at'] ?? $b['registration_date'] ?? '1970-01-01';
            return strtotime($dateB) - strtotime($dateA);
        });

        return $registrations;
    }

    /**
     * ID'ye göre kayıt getir
     */
    private function getRegistrationById($id)
    {
        $filePath = BASE_PATH . '/data/youth-registrations/' . $id . '.json';
        
        if (!file_exists($filePath)) {
            return null;
        }

        $data = json_decode(file_get_contents($filePath), true);
        if ($data) {
            $data['id'] = $id;
            $data['file_path'] = $filePath;
        }

        return $data;
    }

    /**
     * Kayıt durumunu güncelle
     */
    private function updateRegistrationStatus($id, $status, $notes = '')
    {
        $registration = $this->getRegistrationById($id);
        
        if (!$registration) {
            return false;
        }

        $registration['status'] = $status;
        $registration['admin_notes'] = $notes;
        $registration['updated_at'] = date('Y-m-d H:i:s');

        $filePath = BASE_PATH . '/data/youth-registrations/' . $id . '.json';
        
        return file_put_contents($filePath, json_encode($registration, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
    }

    /**
     * Kayıt sil
     */
    private function deleteRegistration($id)
    {
        $filePath = BASE_PATH . '/data/youth-registrations/' . $id . '.json';
        
        if (!file_exists($filePath)) {
            return false;
        }

        // Fotoğraf varsa sil
        $registration = $this->getRegistrationById($id);
        if ($registration && !empty($registration['photo_path'])) {
            $photoPath = BASE_PATH . '/public' . $registration['photo_path'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        return unlink($filePath);
    }

    /**
     * Kayıt istatistikleri
     */
    public function stats()
    {
        $registrations = $this->getRegistrations();
        
        $stats = [
            'total' => count($registrations),
            'pending' => 0,
            'approved' => 0,
            'rejected' => 0,
            'by_age' => [],
            'by_month' => []
        ];

        foreach ($registrations as $registration) {
            // Durum istatistikleri
            $status = $registration['status'] ?? 'pending';
            if (isset($stats[$status])) {
                $stats[$status]++;
            }

            // Yaş istatistikleri
            $birthDate = $registration['student']['birth_date'] ?? null;
            if (!empty($birthDate)) {
                $age = date('Y') - date('Y', strtotime($birthDate));
                $ageGroup = floor($age / 2) * 2 . '-' . (floor($age / 2) * 2 + 1);
                $stats['by_age'][$ageGroup] = ($stats['by_age'][$ageGroup] ?? 0) + 1;
            }

            // Aylık istatistikler
            $createdAt = $registration['created_at'] ?? $registration['registration_date'] ?? null;
            if (!empty($createdAt)) {
                $month = date('Y-m', strtotime($createdAt));
                $stats['by_month'][$month] = ($stats['by_month'][$month] ?? 0) + 1;
            }
        }

        $data = [
            'title' => 'Alt Yapı Kayıt İstatistikleri',
            'stats' => $stats
        ];

        $this->view('admin/youth-registrations/stats', $data);
    }

    /**
     * Validate registration data
     */
    private function validateRegistrationData($data)
    {
        $errors = [];

        // Student info validation
        if (empty($data['student_name'])) {
            $errors[] = 'Öğrenci adı zorunludur.';
        }

        if (empty($data['birth_date'])) {
            $errors[] = 'Doğum tarihi zorunludur.';
        }

        if (empty($data['birth_place'])) {
            $errors[] = 'Doğum yeri zorunludur.';
        }

        if (empty($data['tc_number']) || strlen($data['tc_number']) !== 11) {
            $errors[] = 'TC Kimlik No 11 haneli olmalıdır.';
        }

        if (empty($data['father_name'])) {
            $errors[] = 'Baba adı zorunludur.';
        }

        if (empty($data['mother_name'])) {
            $errors[] = 'Anne adı zorunludur.';
        }

        if (empty($data['school_info'])) {
            $errors[] = 'Okul bilgisi zorunludur.';
        }

        // Parent info validation
        if (empty($data['parent_name'])) {
            $errors[] = 'Veli adı zorunludur.';
        }

        if (empty($data['parent_phone']) || strlen($data['parent_phone']) < 10) {
            $errors[] = 'Geçerli bir GSM numarası giriniz.';
        }

        if (empty($data['address'])) {
            $errors[] = 'İkametgah adresi zorunludur.';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Geçerli bir e-posta adresi giriniz.';
        }

        // Youth group validation
        if (empty($data['youth_group_id'])) {
            $errors[] = 'Alt yapı grubu seçmelisiniz.';
        }

        return $errors;
    }

    /**
     * Save registration to file
     */
    private function saveRegistration($data)
    {
        $registrationsDir = BASE_PATH . '/data/youth-registrations';
        
        if (!is_dir($registrationsDir)) {
            mkdir($registrationsDir, 0755, true);
        }

        $filename = uniqid('reg_') . '.json';
        $filePath = $registrationsDir . '/' . $filename;

        return file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
    }
}