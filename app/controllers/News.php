<?php
/**
 * News Controller
 * Haberler ve duyurular için kontrolcü
 */
class News extends Controller
{
    private $newsModel;
    private $settingsModel;

    public function __construct()
    {
        $this->newsModel = $this->model('News');
        $this->settingsModel = $this->model('SiteSettings');
    }

    /**
     * Haber listesi
     */
    public function index($page = 1)
    {
        $perPage = POSTS_PER_PAGE;
        $category = $_GET['kategori'] ?? null;
        
        $data = [
            'title' => 'Haberler',
            'news' => $this->newsModel->getPaginated($page, $perPage, $category),
            'featured_news' => $this->newsModel->getFeatured(3),
            'current_page' => $page,
            'category' => $category,
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/news/index', $data);
    }

    /**
     * Haber detay sayfası
     */
    public function detail($slug = null)
    {
        if (!$slug) {
            $this->redirect('news');
        }

        $news = $this->newsModel->getBySlug($slug);
        
        if (!$news) {
            $this->redirect('news');
        }

        // Görüntülenme sayısını artır
        $this->newsModel->incrementViews($news['id']);

        $data = [
            'title' => $news['title'],
            'news' => $news,
            'related_news' => $this->newsModel->getRelated($news['category'], $news['id'], 4),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/news/detail', $data);
    }

    /**
     * Kategori sayfası
     */
    public function category($category = null)
    {
        if (!$category) {
            $this->redirect('news');
        }

        $categoryNames = [
            'haber' => 'Haberler',
            'duyuru' => 'Duyurular',
            'mac_sonucu' => 'Maç Sonuçları'
        ];

        $data = [
            'title' => $categoryNames[$category] ?? 'Haberler',
            'news' => $this->newsModel->getByCategory($category, 20),
            'category' => $category,
            'category_name' => $categoryNames[$category] ?? 'Haberler',
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/news/category', $data);
    }

    /**
     * Arama
     */
    public function search()
    {
        $keyword = $_GET['q'] ?? '';
        $results = [];
        
        if (!empty($keyword)) {
            $sql = "SELECT * FROM news 
                    WHERE (title LIKE :keyword OR content LIKE :keyword) 
                    AND status = 'published' 
                    ORDER BY published_at DESC 
                    LIMIT 20";
            
            $results = $this->newsModel->db->query($sql, ['keyword' => "%{$keyword}%"]);
        }

        $data = [
            'title' => 'Arama Sonuçları',
            'keyword' => $keyword,
            'results' => $results,
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/news/search', $data);
    }
}