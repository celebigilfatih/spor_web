<?php
/**
 * AdminTeams Controller
 * Team management for admin panel
 */
class AdminTeams extends Controller
{
    private $teamModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->teamModel = $this->model('Team');
    }

    /**
     * Teams list
     */
    public function index()
    {
        $data = [
            'title' => 'Takım Yönetimi',
            'teams' => $this->teamModel->getAllTeams(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/teams/index', $data);
    }

    /**
     * Create team form
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            // CSRF token kontrolü (zorunlu güvenlik önlemi)
            if (!$this->validateCSRFToken($csrf_token)) {
                $_SESSION['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
                $this->redirect('admin/teams/create');
                return;
            }
            
            $teamData = [
                'name' => $this->sanitizeInput($_POST['name']),
                'team_type' => $this->sanitizeInput($_POST['category']), // Age group (U21, U19, etc.)
                'description' => $this->sanitizeInput($_POST['description']),
                'status' => 'active'
            ];
            
            // Note: Coach field is ignored for now since DB expects coach_id (foreign key)
            // TODO: Implement proper coach selection from technical_staff table

            if ($this->teamModel->create($teamData)) {
                $_SESSION['message'] = 'Takım başarıyla eklendi!';
                $this->redirect('admin/teams');
            } else {
                $_SESSION['error'] = 'Takım eklenirken bir hata oluştu!';
            }
        }

        $data = [
            'title' => 'Yeni Takım Ekle',
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/teams/create', $data);
    }

    /**
     * Edit team
     */
    public function edit($id = null)
    {
        if (!$id) {
            $this->redirect('admin/teams');
        }

        $team = $this->teamModel->findById($id);
        if (!$team) {
            $_SESSION['error'] = 'Takım bulunamadı!';
            $this->redirect('admin/teams');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            // CSRF token kontrolü (zorunlu güvenlik önlemi)
            if (!$this->validateCSRFToken($csrf_token)) {
                $_SESSION['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
                $this->redirect('admin/teams/edit/' . $id);
                return;
            }
            
            $teamData = [
                'name' => $this->sanitizeInput($_POST['name']),
                'team_type' => $this->sanitizeInput($_POST['category']), // Age group (U21, U19, etc.)
                'description' => $this->sanitizeInput($_POST['description']),
                'status' => $this->sanitizeInput($_POST['status'])
            ];
            
            // Note: Coach field is ignored for now since DB expects coach_id (foreign key)
            // TODO: Implement proper coach selection from technical_staff table

            if ($this->teamModel->update($id, $teamData)) {
                $_SESSION['message'] = 'Takım başarıyla güncellendi!';
                $this->redirect('admin/teams');
            } else {
                $_SESSION['error'] = 'Takım güncellenirken bir hata oluştu!';
            }
        }

        $data = [
            'title' => 'Takım Düzenle',
            'team' => $team,
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/teams/edit', $data);
    }

    /**
     * Delete team
     */
    public function delete($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Geçersiz istek']);
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $this->jsonResponse(['success' => false, 'message' => 'Güvenlik hatası']);
        }

        $team = $this->teamModel->findById($id);
        if (!$team) {
            $this->jsonResponse(['success' => false, 'message' => 'Takım bulunamadı']);
        }

        // Check if there are players in this team
        $playerModel = $this->model('Player');
        $players = $playerModel->getByTeam($id);
        if (!empty($players)) {
            $this->jsonResponse(['success' => false, 'message' => 'Bu takımda oyuncular bulunduğu için silinemez. Önce oyuncuları başka takıma aktarın.']);
        }

        if ($this->teamModel->delete($id)) {
            $this->jsonResponse(['success' => true, 'message' => 'Takım başarıyla silindi']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Takım silinirken hata oluştu']);
        }
    }
}
?>