<?php
/**
 * Admin Youth Groups Controller
 * Alt yapı grupları yönetimi
 */
class AdminYouthGroups extends Controller
{
    private $youthGroupModel;

    public function __construct()
    {
        // Check admin authentication
        if (!isset($_SESSION['admin_logged_in'])) {
            $this->redirect('admin/login');
        }

        $this->youthGroupModel = $this->model('YouthGroup');
    }

    /**
     * Liste sayfası
     */
    public function index()
    {
        $groups = $this->youthGroupModel->getAll();
        $statistics = $this->youthGroupModel->getStatistics();

        $data = [
            'title' => 'Alt Yapı Grupları',
            'groups' => $groups,
            'statistics' => $statistics,
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/youth-groups/index', $data);
    }

    /**
     * Yeni grup oluştur
     */
    public function create()
    {
        $data = [
            'title' => 'Yeni Alt Yapı Grubu Ekle',
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/youth-groups/create', $data);
                return;
            }

            $formData = [
                'name' => $this->sanitizeInput($_POST['name'] ?? ''),
                'age_group' => $this->sanitizeInput($_POST['age_group'] ?? ''),
                'min_age' => (int)($_POST['min_age'] ?? 0),
                'max_age' => (int)($_POST['max_age'] ?? 0),
                'coach_name' => $this->sanitizeInput($_POST['coach_name'] ?? ''),
                'assistant_coach' => $this->sanitizeInput($_POST['assistant_coach'] ?? ''),
                'training_days' => $this->formatTrainingSchedule($_POST['training_days'] ?? [], $_POST['training_times'] ?? []),
                'training_time' => '', // Will be included in training_days
                'max_capacity' => (int)($_POST['max_capacity'] ?? 25),
                'season' => $this->sanitizeInput($_POST['season'] ?? '2024-25'),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'description' => $this->sanitizeInput($_POST['description'] ?? '')
            ];

            $errors = $this->youthGroupModel->validate($formData);

            if (empty($errors)) {
                if ($this->youthGroupModel->create($formData)) {
                    $_SESSION['success'] = 'Alt yapı grubu başarıyla eklendi!';
                    $this->redirect('admin/youth-groups');
                } else {
                    $data['error'] = 'Grup eklenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/youth-groups/create', $data);
    }

    /**
     * Grup düzenle
     */
    public function edit($id = null)
    {
        if (!$id) {
            $this->redirect('admin/youth-groups');
        }

        $group = $this->youthGroupModel->findById($id);
        if (!$group) {
            $_SESSION['error'] = 'Grup bulunamadı!';
            $this->redirect('admin/youth-groups');
        }

        $data = [
            'title' => 'Alt Yapı Grubu Düzenle',
            'group' => $group,
            'csrf_token' => $this->generateCSRFToken()
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Geçersiz form gönderimi!';
                $this->view('admin/youth-groups/edit', $data);
                return;
            }

            $formData = [
                'name' => $this->sanitizeInput($_POST['name'] ?? ''),
                'age_group' => $this->sanitizeInput($_POST['age_group'] ?? ''),
                'min_age' => (int)($_POST['min_age'] ?? 0),
                'max_age' => (int)($_POST['max_age'] ?? 0),
                'coach_name' => $this->sanitizeInput($_POST['coach_name'] ?? ''),
                'assistant_coach' => $this->sanitizeInput($_POST['assistant_coach'] ?? ''),
                'training_days' => $this->formatTrainingSchedule($_POST['training_days'] ?? [], $_POST['training_times'] ?? []),
                'training_time' => '', // Will be included in training_days
                'max_capacity' => (int)($_POST['max_capacity'] ?? 25),
                'season' => $this->sanitizeInput($_POST['season'] ?? '2024-25'),
                'status' => $this->sanitizeInput($_POST['status'] ?? 'active'),
                'description' => $this->sanitizeInput($_POST['description'] ?? '')
            ];

            $errors = $this->youthGroupModel->validate($formData);

            if (empty($errors)) {
                if ($this->youthGroupModel->update($id, $formData)) {
                    $_SESSION['success'] = 'Alt yapı grubu başarıyla güncellendi!';
                    $this->redirect('admin/youth-groups');
                } else {
                    $data['error'] = 'Grup güncellenirken bir hata oluştu!';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }

        $this->view('admin/youth-groups/edit', $data);
    }

    /**
     * Grup sil
     */
    public function delete($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/youth-groups');
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Geçersiz form gönderimi!';
            $this->redirect('admin/youth-groups');
        }

        $group = $this->youthGroupModel->findById($id);
        if (!$group) {
            $_SESSION['error'] = 'Grup bulunamadı!';
            $this->redirect('admin/youth-groups');
        }

        // Check if group has players
        if ($group['current_count'] > 0) {
            $_SESSION['error'] = 'Aktif oyuncusu olan grup silinemez!';
            $this->redirect('admin/youth-groups');
        }

        if ($this->youthGroupModel->delete($id)) {
            $_SESSION['success'] = 'Alt yapı grubu başarıyla silindi!';
        } else {
            $_SESSION['error'] = 'Grup silinirken bir hata oluştu!';
        }

        $this->redirect('admin/youth-groups');
    }

    /**
     * Grup detayları
     */
    public function details($id = null)
    {
        if (!$id) {
            $this->redirect('admin/youth-groups');
        }

        $group = $this->youthGroupModel->findById($id);
        if (!$group) {
            $_SESSION['error'] = 'Grup bulunamadı!';
            $this->redirect('admin/youth-groups');
        }

        $data = [
            'title' => $group['name'],
            'group' => $group
        ];

        $this->view('admin/youth-groups/view', $data);
    }

    /**
     * Format training schedule from checkboxes and times
     */
    private function formatTrainingSchedule($days, $times)
    {
        if (empty($days) || !is_array($days)) {
            return '';
        }

        $schedule = [];
        foreach ($days as $day) {
            $time = $times[$day] ?? '';
            if (!empty($time)) {
                $schedule[] = $day . ' ' . $time;
            } else {
                $schedule[] = $day;
            }
        }

        return implode(', ', $schedule);
    }
}
