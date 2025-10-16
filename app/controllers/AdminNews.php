<?php
/**
 * AdminNews Controller
 * Admin paneli haber yönetimi
 */
class AdminNews extends Controller
{
    private $newsModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->newsModel = $this->model('NewsModel');
    }

    /**
     * Haber listesi
     */
    public function index()
    {
        $data = [
            'title' => 'Haber Yönetimi',
            'news' => $this->newsModel->findAll('created_at DESC'),
            'csrf_token' => $this->generateCSRFToken(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/news/index', $data);
    }

    /**
     * Yeni haber ekleme formu
     */
    public function create()
    {
        $data = [
            'title' => 'Yeni Haber Ekle',
            'csrf_token' => $this->generateCSRFToken(),
            'message' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->processNewsForm();
            if ($result['success']) {
                $this->redirect('admin/news');
            } else {
                $data['error'] = $result['message'];
            }
        }

        $this->view('admin/news/create', $data);
    }

    /**
     * Haber düzenleme
     */
    public function edit($id = null)
    {
        if (!$id) {
            $_SESSION['error'] = 'Geçersiz haber ID’si';
            $this->redirect('admin/news');
            return;
        }

        $news = $this->newsModel->findById($id);
        if (!$news) {
            $_SESSION['error'] = 'Haber bulunamadı';
            $this->redirect('admin/news');
            return;
        }

        $data = [
            'title' => 'Haber Düzenle',
            'news' => $news,
            'csrf_token' => $this->generateCSRFToken(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->processNewsForm($id);
            if ($result['success']) {
                $_SESSION['message'] = 'Haber başarıyla güncellendi!';
                $this->redirect('admin/news/edit/' . $id);
                return;
            } else {
                $data['error'] = $result['message'];
                // Refresh the news data in case of error
                $data['news'] = $this->newsModel->findById($id);
            }
        }

        $this->view('admin/news/edit', $data);
    }

    /**
     * Haber silme
     */
    public function delete($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Geçersiz istek']);
        }

        if (!$this->validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $this->jsonResponse(['success' => false, 'message' => 'Güvenlik hatası']);
        }

        $news = $this->newsModel->findById($id);
        if (!$news) {
            $this->jsonResponse(['success' => false, 'message' => 'Haber bulunamadı']);
        }

        // Varsa resmi sil
        if ($news['image']) {
            $imagePath = UPLOAD_PATH . '/' . $news['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($this->newsModel->delete($id)) {
            $this->jsonResponse(['success' => true, 'message' => 'Haber başarıyla silindi']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Haber silinirken hata oluştu']);
        }
    }

    /**
     * Haber form işleme
     */
    private function processNewsForm($id = null)
    {
        // Form verilerini al
        $title = $this->sanitizeInput($_POST['title'] ?? '');
        $content = $_POST['content'] ?? ''; // HTML içerik için sanitize etme
        $excerpt = $this->sanitizeInput($_POST['excerpt'] ?? '');
        $category = $this->sanitizeInput($_POST['category'] ?? 'haber');
        $status = $this->sanitizeInput($_POST['status'] ?? 'draft');
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $csrf_token = $_POST['csrf_token'] ?? '';

        // CSRF token kontrolü
        if (!$this->validateCSRFToken($csrf_token)) {
            return ['success' => false, 'message' => 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.'];
        }

        // Zorunlu alan kontrolü
        if (empty($title)) {
            return ['success' => false, 'message' => 'Başlık alanı zorunludur!'];
        }
        
        if (empty($content)) {
            return ['success' => false, 'message' => 'İçerik alanı zorunludur!'];
        }

        // Slug oluştur (sadece yeni haber için)
        $slug = null;
        if (!$id) {
            $slug = $this->newsModel->generateSlug($title);
        }

        // Veri dizisi hazırla
        $data = [
            'title' => $title,
            'content' => $content,
            'excerpt' => $excerpt,
            'category' => $category,
            'status' => $status,
            'is_featured' => $is_featured,  // Match database column name
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Admin bilgisini ekle - author alanı VARCHAR(100)
        if (isset($_SESSION['admin_username'])) {
            $data['author'] = $_SESSION['admin_username'];
        } elseif (isset($_SESSION['admin_email'])) {
            $data['author'] = $_SESSION['admin_email'];
        } else {
            // Varsayılan değer
            $data['author'] = 'Admin';
        }

        // Slug ekle (yeni haber için)
        if ($slug) {
            $data['slug'] = $slug;
        }

        // Yayın tarihi
        if ($status === 'published') {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        // Resim yükleme işlemi
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->uploadFile($_FILES['featured_image'], ['jpg', 'jpeg', 'png', 'gif']);
            if ($uploadResult['success']) {
                // Eski resmi sil (düzenleme durumunda)
                if ($id) {
                    $oldNews = $this->newsModel->findById($id);
                    if ($oldNews && !empty($oldNews['image'])) {
                        $oldImagePath = (defined('UPLOAD_PATH') ? UPLOAD_PATH : BASE_PATH . '/public/uploads') . '/' . $oldNews['image'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                }
                $data['image'] = $uploadResult['filename'];
            } else {
                return ['success' => false, 'message' => 'Resim yükleme hatası: ' . $uploadResult['message']];
            }
        }

        // Veritabanı işlemi
        try {
            if ($id) {
                // Güncelleme
                $result = $this->newsModel->update($id, $data);
                $message = 'Haber başarıyla güncellendi!';
            } else {
                // Yeni kayit ekleme
                if (!isset($data['slug'])) {
                    return ['success' => false, 'message' => 'Slug oluşturma hatası!'];
                }
                $data['created_at'] = date('Y-m-d H:i:s');
                
                // Debug: Log the data being inserted
                error_log('News create data: ' . print_r($data, true));
                
                $result = $this->newsModel->create($data);
                $message = 'Haber başarıyla eklendi!';
                
                // Debug: Log the result
                error_log('News create result: ' . ($result ? 'success' : 'failed'));
            }

            if ($result) {
                return ['success' => true, 'message' => $message];
            } else {
                // Get last database error if available
                $errorInfo = $this->newsModel->getLastError();
                error_log('Database error: ' . ($errorInfo ?? 'Unknown error'));
                return ['success' => false, 'message' => 'Veritabanı kaydetme hatası! ' . ($errorInfo ? 'Hata: ' . $errorInfo : '')];
            }
        } catch (Exception $e) {
            error_log('News form processing error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Bir hata oluştu: ' . $e->getMessage()];
        }
    }
}