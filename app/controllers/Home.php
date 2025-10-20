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

    public function __construct()
    {
        $this->newsModel = $this->model('NewsModel');
        $this->sliderModel = $this->model('Slider');
        $this->matchModel = $this->model('MatchModel');
        $this->playerModel = $this->model('Player');
        $this->settingsModel = $this->model('SiteSettings');
        $this->announcementModel = $this->model('Announcement');
    }

    /**
     * Ana sayfa
     */
    public function index()
    {
        $data = [
            'title' => 'Ana Sayfa - ' . $this->settingsModel->getSetting('site_title', 'Spor Kulübü'),
            'sliders' => $this->sliderModel->getActiveSliders(),
            'featured_news' => $this->newsModel->getFeatured(3),
            'latest_news' => $this->newsModel->getPublished(6),
            'announcements' => $this->announcementModel->getActive(2),
            'upcoming_matches' => $this->matchModel->getUpcomingMatches(5),
            'recent_results' => $this->matchModel->getResults(3),
            'top_scorers' => $this->playerModel->getTopScorers('2024-25', 5),
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