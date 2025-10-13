<?php
/**
 * ATeam Controller
 * A Team (First Team) controller
 */
class ATeam extends Controller
{
    private $playerModel;
    private $teamModel;
    private $matchModel;
    private $settingsModel;

    public function __construct()
    {
        $this->playerModel = $this->model('Player');
        $this->teamModel = $this->model('Team');
        $this->matchModel = $this->model('MatchModel');
        $this->settingsModel = $this->model('SiteSettings');
    }

    /**
     * A Team main page
     */
    public function index()
    {
        $data = [
            'title' => 'A Takımı - ' . $this->settingsModel->getSetting('site_title', 'Spor Kulübü'),
            'players' => $this->playerModel->getATeamPlayers(),
            'team_info' => $this->teamModel->getATeamInfo(),
            'recent_matches' => $this->matchModel->getRecentMatches(5),
            'upcoming_matches' => $this->matchModel->getUpcomingMatches(3),
            'team_stats' => $this->playerModel->getTeamStats('A'),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/ateam/index', $data);
    }

    /**
     * Squad page
     */
    public function squad()
    {
        $data = [
            'title' => 'A Takımı Kadrosu',
            'goalkeepers' => $this->playerModel->getByPosition('Kaleci', 'A'),
            'defenders' => $this->playerModel->getByPosition('Defans', 'A'),
            'midfielders' => $this->playerModel->getByPosition('Orta Saha', 'A'),
            'forwards' => $this->playerModel->getByPosition('Forvet', 'A'),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/ateam/squad', $data);
    }

    /**
     * Player details
     */
    public function player($playerId = null)
    {
        if (!$playerId) {
            $this->redirect('ateam/squad');
        }

        $player = $this->playerModel->findById($playerId);
        if (!$player || $player['team_type'] !== 'A') {
            $this->redirect('ateam/squad');
        }

        $data = [
            'title' => $player['name'] . ' - A Takımı',
            'player' => $player,
            'stats' => $this->playerModel->getPlayerStats($playerId),
            'recent_performances' => $this->playerModel->getRecentPerformances($playerId),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/ateam/player', $data);
    }

    /**
     * Fixtures and results
     */
    public function fixtures()
    {
        $data = [
            'title' => 'Maç Programı - A Takımı',
            'upcoming_matches' => $this->matchModel->getUpcomingMatches(),
            'recent_results' => $this->matchModel->getResults(),
            'league_table' => $this->teamModel->getLeagueStandings(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/ateam/fixtures', $data);
    }
    
    /**
     * Team statistics
     */
    public function stats()
    {
        $data = [
            'title' => 'İstatistikler - A Takımı',
            'season_stats' => $this->teamModel->getSeasonStats('A'),
            'top_scorers' => $this->playerModel->getTopScorers('2024-25', 10),
            'team_performance' => $this->teamModel->getPerformanceStats('A'),
            'recent_form' => $this->matchModel->getRecentForm(10),
            'league_position' => $this->teamModel->getLeaguePosition(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/ateam/stats', $data);
    }
}