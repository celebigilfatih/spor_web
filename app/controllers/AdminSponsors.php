<?php
/**
 * Admin Sponsors Controller
 * Sponsor görselleri yönetimi (sadece resim)
 */
class AdminSponsors extends Controller
{
    private $sponsorModel;

    public function __construct()
    {
        $this->sponsorModel = $this->model('Sponsor');
    }

    /**
     * Listele ve yeni sponsor ekle
     */
    public function index()
    {
        $this->requireAdmin();

        $data = [
            'title' => 'Sponsorlar',
            'csrf_token' => $this->generateCSRFToken(),
            'message' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                $data['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
            } else if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $data['error'] = 'Lütfen geçerli bir resim dosyası seçin.';
            } else {
                $uploadResult = $this->uploadFile($_FILES['image'], ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif', 'svg']);
                if ($uploadResult['success']) {
                    // Create sponsor record
                    $imageFile = $uploadResult['filename'];
                    $sortOrder = 0; // default
                    $created = $this->sponsorModel->create([
                        'image' => $imageFile,
                        'status' => 'active',
                        'sort_order' => $sortOrder
                    ]);
                    if ($created) {
                        $data['message'] = 'Sponsor başarıyla eklendi!';
                    } else {
                        $data['error'] = 'Veritabanı hatası: ' . ($this->sponsorModel->getLastError() ?? 'bilinmeyen hata');
                    }
                } else {
                    $data['error'] = $uploadResult['message'] ?? 'Resim yükleme hatası';
                }
            }
        }

        // Fetch all sponsors (active and inactive) for management
        try {
            $list = $this->sponsorModel->findAll('sort_order ASC, id DESC');
        } catch (Exception $e) {
            $list = [];
            $data['error'] = 'Sponsorlar alınamadı: ' . $e->getMessage();
        }

        $data['sponsors'] = $list;
        $this->view('admin/sponsors/index', $data);
    }

    /**
     * Sponsor sil
     */
    public function delete($id = null)
    {
        $this->requireAdmin();
        if (!$id) {
            $this->redirect('admin/sponsors');
        }
        try {
            $this->sponsorModel->delete((int)$id);
            $_SESSION['message'] = 'Sponsor silindi';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Silme hatası: ' . $e->getMessage();
        }
        $this->redirect('admin/sponsors');
    }
}
