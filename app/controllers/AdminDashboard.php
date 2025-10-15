<?php
/**
 * AdminDashboard Controller
 * Admin panel ana sayfa ve yönetim
 */
class AdminDashboard extends Controller
{
    private $newsModel;
    private $playerModel;
    private $teamModel;
    private $matchModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->newsModel = $this->model('NewsModel');
        $this->playerModel = $this->model('Player');
        $this->teamModel = $this->model('Team');
        $this->matchModel = $this->model('MatchModel');
    }

    /**
     * Dashboard ana sayfa
     */
    public function index()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'stats' => $this->getDashboardStats(),
            'recent_news' => $this->newsModel->getPublished(5),
            'upcoming_matches' => $this->matchModel->getUpcomingMatches(5),
            'recent_matches' => $this->matchModel->getRecentMatches(5)
        ];

        $this->view('admin/dashboard/index', $data);
    }

    /**
     * Dashboard istatistiklerini al
     */
    private function getDashboardStats()
    {
        return [
            'total_news' => 5, // Örnek veri
            'total_players' => 25, // Örnek veri  
            'total_teams' => 3, // Örnek veri
            'upcoming_matches' => 8, // Örnek veri
            'recent_views' => 1250 // Örnek veri
        ];
    }

    /**
     * Toplam haber görüntülenme sayısı
     */
    private function getTotalNewsViews()
    {
        $sql = "SELECT SUM(views) as total_views FROM news WHERE status = 'published'";
        $result = $this->newsModel->query($sql);
        return $result ? (int)$result[0]['total_views'] : 0;
    }
}