<?php
/**
 * AdminPlayers Controller
 * Admin paneli oyuncu yönetimi
 */
class AdminPlayers extends Controller
{
    private $playerModel;
    private $teamModel;
    private $youthGroupModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->playerModel = $this->model('Player');
        $this->teamModel = $this->model('Team');
        $this->youthGroupModel = $this->model('YouthGroup');
    }

    /**
     * Oyuncu listesi
     */
    public function index()
    {
        $data = [
            'title' => 'Oyuncu Yönetimi',
            'players' => $this->playerModel->getAllPlayers(),
            'youth_groups' => $this->youthGroupModel->getActive()
        ];

        $this->view('admin/players/index', $data);
    }

    /**
     * Gençlik oyuncuları listesi
     */
    public function youth()
    {
        error_log("Youth players method called");
        $players = $this->playerModel->getYouthPlayers();
        error_log("Players count: " . (is_array($players) ? count($players) : 'not an array'));
        $youth_groups = $this->youthGroupModel->getActive();
        error_log("Youth groups count: " . (is_array($youth_groups) ? count($youth_groups) : 'not an array'));
        
        $data = [
            'title' => 'Alt Yapı Oyuncuları',
            'players' => $players,
            'youth_groups' => $youth_groups
        ];

        $this->view('admin/players/youth', $data);
    }

    /**
     * Yeni oyuncu ekleme formu
     */
    public function create()
    {
        $data = [
            'title' => 'Yeni Oyuncu Ekle',
            'teams' => $this->teamModel->getActiveTeams(),
            'youth_groups' => $this->youthGroupModel->getActive(),
            'csrf_token' => $this->generateCSRFToken(),
            'message' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->processPlayerForm();
            if ($result['success']) {
                $this->redirect('admin/players');
            } else {
                $data['error'] = $result['message'];
            }
        }

        $this->view('admin/players/create', $data);
    }

    /**
     * Yeni gençlik oyuncusu ekleme formu
     */
    public function createYouth()
    {
        error_log("createYouth method called");
        $data = [
            'title' => 'Yeni Alt Yapı Oyuncusu Ekle',
            'youth_groups' => $this->youthGroupModel->getActive(),
            'csrf_token' => $this->generateCSRFToken(),
            'message' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("createYouth POST request received");
            $result = $this->processYouthPlayerForm();
            if ($result['success']) {
                $this->redirect('admin/players/youth');
            } else {
                $data['error'] = $result['message'];
            }
        }

        $this->view('admin/players/create_youth', $data);
    }

    /**
     * Oyuncu düzenleme
     */
    public function edit($id = null)
    {
        if (!$id) {
            $this->redirect('admin/players');
        }

        $player = $this->playerModel->findById($id);
        if (!$player) {
            $this->redirect('admin/players');
        }

        $data = [
            'title' => 'Oyuncu Düzenle',
            'player' => $player,
            'teams' => $this->teamModel->getActiveTeams(),
            'youth_groups' => $this->youthGroupModel->getActive(),
            'csrf_token' => $this->generateCSRFToken(),
            'message' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->processPlayerForm($id);
            if ($result['success']) {
                $data['message'] = 'Oyuncu başarıyla güncellendi!';
                $data['player'] = $this->playerModel->findById($id);
            } else {
                $data['error'] = $result['message'];
            }
        }

        $this->view('admin/players/edit', $data);
    }

    /**
     * Oyuncu silme
     */
    public function delete($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Geçersiz istek']);
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $this->jsonResponse(['success' => false, 'message' => 'Güvenlik hatası']);
        }

        $player = $this->playerModel->findById($id);
        if (!$player) {
            $this->jsonResponse(['success' => false, 'message' => 'Oyuncu bulunamadı']);
        }

        // Varsa fotoğrafı sil
        if ($player['photo']) {
            $imagePath = UPLOAD_PATH . '/' . $player['photo'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($this->playerModel->delete($id)) {
            $this->jsonResponse(['success' => true, 'message' => 'Oyuncu başarıyla silindi']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Oyuncu silinirken hata oluştu']);
        }
    }

    /**
     * Gençlik oyuncusu düzenleme
     */
    public function editYouth($id = null)
    {
        if (!$id) {
            $this->redirect('admin/players/youth');
        }

        $player = $this->playerModel->findById($id);
        if (!$player || !$player['youth_group_id']) {
            $this->redirect('admin/players/youth');
        }

        $data = [
            'title' => 'Alt Yapı Oyuncusu Düzenle',
            'player' => $player,
            'youth_groups' => $this->youthGroupModel->getActive(),
            'csrf_token' => $this->generateCSRFToken(),
            'message' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->processYouthPlayerForm($id);
            if ($result['success']) {
                $data['message'] = 'Oyuncu başarıyla güncellendi!';
                $data['player'] = $this->playerModel->findById($id);
            } else {
                $data['error'] = $result['message'];
            }
        }

        $this->view('admin/players/edit_youth', $data);
    }

    /**
     * Gençlik oyuncusu silme
     */
    public function deleteYouth($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Geçersiz istek']);
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $this->jsonResponse(['success' => false, 'message' => 'Güvenlik hatası']);
        }

        $player = $this->playerModel->findById($id);
        if (!$player || !$player['youth_group_id']) {
            $this->jsonResponse(['success' => false, 'message' => 'Oyuncu bulunamadı']);
        }

        // Varsa fotoğrafı sil
        if ($player['photo']) {
            $imagePath = UPLOAD_PATH . '/' . $player['photo'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($this->playerModel->delete($id)) {
            $this->jsonResponse(['success' => true, 'message' => 'Oyuncu başarıyla silindi']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Oyuncu silinirken hata oluştu']);
        }
    }

    /**
     * Oyuncu form işleme
     */
    private function processPlayerForm($id = null)
    {
        // Handle full_name field (new format) - matches database 'name' column
        if (isset($_POST['full_name']) && !empty($_POST['full_name'])) {
            $fullName = trim($_POST['full_name']);
        } else {
            // Handle separate first_name and last_name fields (old format)
            $firstName = $this->sanitizeInput($_POST['first_name'] ?? '');
            $lastName = $this->sanitizeInput($_POST['last_name'] ?? '');
            $fullName = trim($firstName . ' ' . $lastName);
        }
        
        $jerseyNumber = (int)($_POST['jersey_number'] ?? 0);
        $position = $this->sanitizeInput($_POST['position'] ?? '');
        $teamId = 1; // A Takım için sabit team_id = 1
        $birthDate = $_POST['birth_date'] ?? '';
        $status = $this->sanitizeInput($_POST['status'] ?? 'active');
        $isCaptain = !empty($_POST['is_captain']) ? 1 : 0;
        $csrf_token = $_POST['csrf_token'] ?? '';

        // CSRF token kontrolü
        if (!$this->validateCSRFToken($csrf_token)) {
            return ['success' => false, 'message' => 'Güvenlik hatası!'];
        }

        // Zorunlu alan kontrolü
        if (empty($fullName) || empty($position)) {
            return ['success' => false, 'message' => 'Ad Soyad ve pozisyon alanları zorunludur!'];
        }

        // Forma numarası kontrolü
        if ($jerseyNumber > 0) {
            if ($this->playerModel->isJerseyNumberTaken($jerseyNumber, $teamId, $id)) {
                return ['success' => false, 'message' => 'Bu forma numarası zaten kullanılıyor!'];
            }
        } else {
            return ['success' => false, 'message' => 'Forma numarası zorunludur!'];
        }
        
        // Doğum tarihi kontrolü
        if (empty($birthDate)) {
            return ['success' => false, 'message' => 'Doğum tarihi zorunludur!'];
        }

        // Veri dizisi hazırla - Match database schema
        $data = [
            'name' => $fullName,  // Database uses 'name' not 'first_name'/'last_name'
            'jersey_number' => $jerseyNumber,
            'position' => $position,
            'team_id' => $teamId,
            'youth_group_id' => null, // A Takım oyuncuları için youth_group_id null
            'birth_date' => $birthDate,
            'status' => $status,
            'is_captain' => $isCaptain
        ];
        
        // Add timestamp based on operation
        if ($id) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        // Fotoğraf yükleme işlemi
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->uploadFile($_FILES['photo'], ['jpg', 'jpeg', 'png']);
            if ($uploadResult['success']) {
                // Eski fotoğrafı sil (düzenleme durumunda)
                if ($id) {
                    $oldPlayer = $this->playerModel->findById($id);
                    if ($oldPlayer && $oldPlayer['photo']) {
                        $oldImagePath = UPLOAD_PATH . '/' . $oldPlayer['photo'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                }
                $data['photo'] = $uploadResult['filename'];
            } else {
                return ['success' => false, 'message' => $uploadResult['message']];
            }
        }

        // Veritabanı işlemi
        if ($id) {
            $result = $this->playerModel->update($id, $data);
        } else {
            $result = $this->playerModel->create($data);
        }

        if ($result) {
            return ['success' => true, 'message' => $id ? 'Oyuncu güncellendi!' : 'Oyuncu eklendi!'];
        } else {
            $errorMsg = $this->playerModel->getLastError();
            return ['success' => false, 'message' => 'Veritabanı hatası!' . ($errorMsg ? ' (' . $errorMsg . ')' : '')];
        }
    }

    /**
     * Gençlik oyuncusu form işleme
     */
    private function processYouthPlayerForm($id = null)
    {
        // Handle full_name field (new format) - matches database 'name' column
        if (isset($_POST['full_name']) && !empty($_POST['full_name'])) {
            $fullName = trim($_POST['full_name']);
        } else {
            // Handle separate first_name and last_name fields (old format)
            $firstName = $this->sanitizeInput($_POST['first_name'] ?? '');
            $lastName = $this->sanitizeInput($_POST['last_name'] ?? '');
            $fullName = trim($firstName . ' ' . $lastName);
        }
        
        $jerseyNumber = (int)($_POST['jersey_number'] ?? 0);
        $position = $this->sanitizeInput($_POST['position'] ?? '');
        $youthGroupId = !empty($_POST['youth_group_id']) ? (int)($_POST['youth_group_id']) : null;
        $birthDate = $_POST['birth_date'] ?? '';
        $status = $this->sanitizeInput($_POST['status'] ?? 'active');
        $csrf_token = $_POST['csrf_token'] ?? '';

        // CSRF token kontrolü
        if (!$this->validateCSRFToken($csrf_token)) {
            return ['success' => false, 'message' => 'Güvenlik hatası!'];
        }

        // Zorunlu alan kontrolü
        if (empty($fullName) || empty($position)) {
            return ['success' => false, 'message' => 'Ad Soyad ve pozisyon alanları zorunludur!'];
        }
        
        // Doğum tarihi kontrolü
        if (empty($birthDate)) {
            return ['success' => false, 'message' => 'Doğum tarihi zorunludur!'];
        }

        // Gençlik grubu seçilmeli
        if (!$youthGroupId) {
            return ['success' => false, 'message' => 'Lütfen oyuncunun ait olduğu gençlik grubunu seçin!'];
        }

        // Veri dizisi hazırla - Match database schema
        $data = [
            'name' => $fullName,  // Database uses 'name' not 'first_name'/'last_name'
            'jersey_number' => $jerseyNumber,
            'position' => $position,
            'youth_group_id' => $youthGroupId,
            'birth_date' => $birthDate,
            'status' => $status
        ];
        
        // Add timestamp based on operation
        if ($id) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        // Fotoğraf yükleme işlemi
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->uploadFile($_FILES['photo'], ['jpg', 'jpeg', 'png']);
            if ($uploadResult['success']) {
                // Eski fotoğrafı sil (düzenleme durumunda)
                if ($id) {
                    $oldPlayer = $this->playerModel->findById($id);
                    if ($oldPlayer && $oldPlayer['photo']) {
                        $oldImagePath = UPLOAD_PATH . '/' . $oldPlayer['photo'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                }
                $data['photo'] = $uploadResult['filename'];
            } else {
                return ['success' => false, 'message' => $uploadResult['message']];
            }
        }

        // Veritabanı işlemi
        if ($id) {
            $result = $this->playerModel->update($id, $data);
        } else {
            $result = $this->playerModel->create($data);
        }

        if ($result) {
            return ['success' => true, 'message' => $id ? 'Oyuncu güncellendi!' : 'Oyuncu eklendi!'];
        } else {
            $errorMsg = $this->playerModel->getLastError();
            return ['success' => false, 'message' => 'Veritabanı hatası!' . ($errorMsg ? ' (' . $errorMsg . ')' : '')];
        }
    }
}