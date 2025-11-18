<?php
/**
 * Home Controller
 * Ana sayfa kontrolcüsü
 */
class Home extends Controller
{
    private $newsModel;
    private $sliderModel;
    private $matchModel;
    private $playerModel;
    private $settingsModel;
    private $announcementModel;
    private $sponsorModel;

    public function __construct()
    {
        $this->newsModel = $this->model('NewsModel');
        $this->sliderModel = $this->model('Slider');
        $this->matchModel = $this->model('MatchModel');
        $this->playerModel = $this->model('Player');
        $this->settingsModel = $this->model('SiteSettings');
        $this->announcementModel = $this->model('Announcement');
        $this->sponsorModel = $this->model('Sponsor');
    }

    /**
     * Ana sayfa
     */
    public function index()
    {
        $upcoming = $this->matchModel->getUpcomingMatches(5);
        $results = $this->matchModel->getResults(3);
        
        // Debug: Log match data
        error_log("Upcoming matches count: " . (is_array($upcoming) ? count($upcoming) : 0));
        error_log("Recent results count: " . (is_array($results) ? count($results) : 0));
        
        // Get only news (exclude announcements/duyuru)
        $latestNews = $this->newsModel->getPublished(12); // Get more to filter
        $filteredNews = array_filter($latestNews, function($news) {
            return ($news['category'] ?? 'haber') !== 'duyuru';
        });
        $filteredNews = array_values($filteredNews); // Re-index array
        
        $data = [
            'title' => 'Ana Sayfa - ' . $this->settingsModel->getSetting('site_title', 'Spor Kulübü'),
            'sliders' => $this->sliderModel->getActiveSliders(),
            'featured_news' => $this->newsModel->getFeatured(3),
            'latest_news' => array_slice($filteredNews, 0, 8), // Limit to 8
            'announcements' => $this->newsModel->getByCategory('duyuru', 3), // Get announcements from news with 'duyuru' category
            'upcoming_matches' => $upcoming,
            'recent_results' => $results,
            'top_scorers' => $this->playerModel->getTopScorers('2024-25', 5),
            'a_team_players' => $this->playerModel->getATeamPlayers(), // A Takım oyuncuları
            'sponsors' => $this->sponsorModel->getActiveSponsors(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/home/index', $data);
    }

    /**
     * Hakkımızda sayfası
     */
    public function about()
    {
        $aboutModel = $this->model('AboutUs');
        
        $data = [
            'title' => 'Hakkımızda',
            'sections' => $aboutModel->getMainSections(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/about/index', $data);
    }

    /**
     * İletişim sayfası
     */
    public function contact()
    {
        $data = [
            'title' => 'İletişim',
            'contact_info' => $this->settingsModel->getContactSettings(),
            'social_media' => $this->settingsModel->getSocialMediaSettings(),
            'site_settings' => $this->settingsModel->getAllSettings(),
            'message' => '',
            'error' => ''
        ];

        // İletişim formu gönderildi ise
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->sanitizeInput($_POST['name'] ?? '');
            $email = $this->sanitizeInput($_POST['email'] ?? '');
            $subject = $this->sanitizeInput($_POST['subject'] ?? '');
            $message = $this->sanitizeInput($_POST['message'] ?? '');

            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $data['error'] = 'Tüm alanlar zorunludur!';
            }
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Geçerli bir e-posta adresi giriniz!';
            }
            else {
                // Gerçek uygulamada burada e-posta gönderme işlemi yapılır
                $data['message'] = 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.';
                
                // Form verilerini temizle
                $_POST = [];
            }
        }

        $this->view('frontend/home/contact', $data);
    }
}