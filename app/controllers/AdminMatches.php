<?php
/**
 * AdminMatches Controller
 * Match management for admin panel
 */
class AdminMatches extends Controller
{
    private $matchModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->matchModel = $this->model('MatchModel');
    }

    /**
     * Matches list
     */
    public function index()
    {
        $data = [
            'title' => 'Maç Yönetimi',
            'matches' => $this->matchModel->getAllMatches(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/matches/index', $data);
    }

    /**
     * Create match form
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            // CSRF token kontrolü (zorunlu güvenlik önlemi)
            if (!$this->validateCSRFToken($csrf_token)) {
                $_SESSION['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
                $this->redirect('admin/matches/create');
                return;
            }
            
            $matchData = [
                'home_team' => $this->sanitizeInput($_POST['home_team']),
                'away_team' => $this->sanitizeInput($_POST['away_team']),
                'match_date' => $this->sanitizeInput($_POST['match_date']),
                'venue' => $this->sanitizeInput($_POST['venue']),
                'competition' => $this->sanitizeInput($_POST['competition']),
                'home_score' => !empty($_POST['home_score']) ? (int)$_POST['home_score'] : null,
                'away_score' => !empty($_POST['away_score']) ? (int)$_POST['away_score'] : null,
                'status' => $this->sanitizeInput($_POST['status'])
            ];

            if ($this->matchModel->create($matchData)) {
                $_SESSION['message'] = 'Maç başarıyla eklendi!';
                $this->redirect('admin/matches');
            } else {
                $_SESSION['error'] = 'Maç eklenirken bir hata oluştu!';
            }
        }

        $data = [
            'title' => 'Yeni Maç Ekle',
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/matches/create', $data);
    }

    /**
     * Edit match
     */
    public function edit($id = null)
    {
        if (!$id) {
            $this->redirect('admin/matches');
        }

        $match = $this->matchModel->findById($id);
        if (!$match) {
            $_SESSION['error'] = 'Maç bulunamadı!';
            $this->redirect('admin/matches');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            // CSRF token kontrolü (zorunlu güvenlik önlemi)
            if (!$this->validateCSRFToken($csrf_token)) {
                $_SESSION['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
                $this->redirect('admin/matches/edit/' . $id);
                return;
            }
            
            $matchData = [
                'home_team' => $this->sanitizeInput($_POST['home_team']),
                'away_team' => $this->sanitizeInput($_POST['away_team']),
                'match_date' => $this->sanitizeInput($_POST['match_date']),
                'venue' => $this->sanitizeInput($_POST['venue']),
                'competition' => $this->sanitizeInput($_POST['competition']),
                'home_score' => !empty($_POST['home_score']) ? (int)$_POST['home_score'] : null,
                'away_score' => !empty($_POST['away_score']) ? (int)$_POST['away_score'] : null,
                'status' => $this->sanitizeInput($_POST['status'])
            ];

            if ($this->matchModel->update($id, $matchData)) {
                $_SESSION['message'] = 'Maç başarıyla güncellendi!';
                $this->redirect('admin/matches');
            } else {
                $_SESSION['error'] = 'Maç güncellenirken bir hata oluştu!';
            }
        }

        $data = [
            'title' => 'Maç Düzenle',
            'match' => $match,
            'csrf_token' => $this->generateCSRFToken()
        ];

        $this->view('admin/matches/edit', $data);
    }

    /**
     * Delete match
     */
    public function delete($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Geçersiz istek']);
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $this->jsonResponse(['success' => false, 'message' => 'Güvenlik hatası']);
        }

        $match = $this->matchModel->findById($id);
        if (!$match) {
            $this->jsonResponse(['success' => false, 'message' => 'Maç bulunamadı']);
        }

        if ($this->matchModel->delete($id)) {
            $this->jsonResponse(['success' => true, 'message' => 'Maç başarıyla silindi']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Maç silinirken hata oluştu']);
        }
    }

    /**
     * Match fixtures calendar
     */
    public function fixtures()
    {
        $data = [
            'title' => 'Maç Takvimi',
            'upcoming_matches' => $this->matchModel->getUpcomingMatches(20),
            'recent_matches' => $this->matchModel->getResults(20)
        ];

        $this->view('admin/matches/fixtures', $data);
    }
}
?>