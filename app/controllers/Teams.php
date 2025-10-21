<?php
/**
 * Teams Controller
 * Takımlar ve gruplar için kontrolcü
 */
class Teams extends Controller
{
    private $teamModel;
    private $playerModel;
    private $technicalStaffModel;
    private $settingsModel;

    public function __construct()
    {
        $this->teamModel = $this->model('Team');
        $this->playerModel = $this->model('Player');
        $this->technicalStaffModel = $this->model('TechnicalStaff');
        $this->settingsModel = $this->model('SiteSettings');
    }

    /**
     * Tüm takımları listele
     */
    public function index()
    {
        $data = [
            'title' => 'Takımlarımız',
            'teams' => $this->teamModel->getActiveTeams(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/teams/index', $data);
    }

    /**
     * A Takım sayfası
     */
    public function first()
    {
        $mainTeam = $this->teamModel->getMainTeam();
        
        if (!$mainTeam) {
            $this->redirect('teams');
        }

        $data = [
            'title' => 'A Takım',
            'team' => $mainTeam,
            'players' => $this->playerModel->getByTeam($mainTeam['id']),
            'technical_staff' => $this->technicalStaffModel->getByTeam($mainTeam['id']),
            'team_stats' => $this->teamModel->getTeamStats($mainTeam['id']),
            'recent_matches' => $this->teamModel->getRecentMatches($mainTeam['id'], 5),
            'upcoming_matches' => $this->teamModel->getUpcomingMatches($mainTeam['id'], 5),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/teams/first-team', $data);
    }

    /**
     * Takım detay sayfası
     */
    public function detail($id = null)
    {
        if (!$id) {
            $this->redirect('teams');
        }

        $team = $this->teamModel->getTeamWithPlayers($id);
        
        if (!$team) {
            $this->redirect('teams');
        }

        $data = [
            'title' => $team['name'],
            'team' => $team,
            'technical_staff' => $this->technicalStaffModel->getByTeam($id),
            'team_stats' => $this->teamModel->getTeamStats($id),
            'recent_matches' => $this->teamModel->getRecentMatches($id, 3),
            'upcoming_matches' => $this->teamModel->getUpcomingMatches($id, 3),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/teams/detail', $data);
    }

    /**
     * Oyuncu detay sayfası
     */
    public function player($id = null)
    {
        if (!$id) {
            $this->redirect('teams');
        }

        $player = $this->playerModel->getPlayerWithStats($id);
        
        if (!$player) {
            $this->redirect('teams');
        }

        $data = [
            'title' => $player['name'],
            'player' => $player,
            'related_players' => $this->playerModel->getByPosition($player['position'], $player['team_id']),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/teams/player-detail', $data);
    }

    /**
     * Teknik kadro sayfası
     */
    public function staff()
    {
        $data = [
            'title' => 'Teknik Kadro',
            'staff_groups' => $this->technicalStaffModel->getGroupedStaff(),
            'staff_stats' => $this->technicalStaffModel->getStaffStats(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/teams/staff', $data);
    }
}