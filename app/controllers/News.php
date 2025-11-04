<?php
/**
 * News Controller
 * Haberler ve duyurular için kontrolcü
 */
class News extends Controller
{
    private $newsModel;
    private $settingsModel;
    private $matchModel;

    public function __construct()
    {
        $this->newsModel = $this->model('NewsModel');
        $this->settingsModel = $this->model('SiteSettings');
        $this->matchModel = $this->model('MatchModel');
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
            'recent_results' => $this->matchModel->getResults(5),
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

        // Galeri resimlerini getir
        $gallery = $this->newsModel->getGalleryImages($news['id']);

        $data = [
            'title' => $news['title'],
            'news' => $news,
            'gallery' => $gallery,
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

        // Special handling for match results category
        if ($category === 'mac_sonucu') {
            $data = [
                'title' => 'Maç Sonuçları',
                'matches' => $this->matchModel->getResults(50),
                'category' => $category,
                'category_name' => 'Maç Sonuçları',
                'site_settings' => $this->settingsModel->getAllSettings()
            ];

            $this->view('frontend/news/match-results', $data);
            return;
        }

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
        $keyword = trim($keyword);
        $results = [];
        
        if (!empty($keyword)) {
            $results = $this->newsModel->search($keyword, 20);
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