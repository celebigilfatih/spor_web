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
        
        $data = [
            'title' => 'Alt Yapı Kayıtları',
            'registrations' => $registrations,
            'csrf_token' => $this->generateCSRFToken(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/youth-registrations/index', $data);
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
            return strtotime($b['created_at']) - strtotime($a['created_at']);
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
            if (!empty($registration['student']['birth_date'])) {
                $age = date('Y') - date('Y', strtotime($registration['student']['birth_date']));
                $ageGroup = floor($age / 2) * 2 . '-' . (floor($age / 2) * 2 + 1);
                $stats['by_age'][$ageGroup] = ($stats['by_age'][$ageGroup] ?? 0) + 1;
            }

            // Aylık istatistikler
            if (!empty($registration['created_at'])) {
                $month = date('Y-m', strtotime($registration['created_at']));
                $stats['by_month'][$month] = ($stats['by_month'][$month] ?? 0) + 1;
            }
        }

        $data = [
            'title' => 'Alt Yapı Kayıt İstatistikleri',
            'stats' => $stats
        ];

        $this->view('admin/youth-registrations/stats', $data);
    }
}