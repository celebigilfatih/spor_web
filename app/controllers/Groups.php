<?php
/**
 * Groups Controller
 * Youth and academy groups controller
 */
class Groups extends Controller
{
    private $groupModel;
    private $playerModel;
    private $settingsModel;

    public function __construct()
    {
        $this->groupModel = $this->model('YouthGroup');
        $this->playerModel = $this->model('Player');
        $this->settingsModel = $this->model('SiteSettings');
    }

    /**
     * Groups main page
     */
    public function index()
    {
        $data = [
            'title' => 'Gruplarımız - ' . $this->settingsModel->getSetting('site_title', 'Spor Kulübü'),
            'groups' => $this->groupModel->getActive(),
            'statistics' => $this->groupModel->getStatistics(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/groups/index', $data);
    }

    /**
     * Specific group details
     */
    public function details($groupId = null)
    {
        if (!$groupId) {
            $this->redirect('groups');
        }

        $group = $this->groupModel->findById($groupId);
        if (!$group) {
            $this->redirect('groups');
        }

        $data = [
            'title' => $group['name'] . ' - Gruplarımız',
            'group' => $group,
            'players' => $this->playerModel->getByGroup($groupId),
            'coaches' => $this->groupModel->getGroupCoaches($groupId),
            'training_schedule' => $this->groupModel->getTrainingSchedule($groupId),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/groups/view', $data);
    }

    /**
     * Youth academy players page
     */
    public function players()
    {
        $data = [
            'title' => 'Gençlik Akademisi Oyuncuları - ' . $this->settingsModel->getSetting('site_title', 'Spor Kulübü'),
            'groups' => $this->groupModel->getActive(),
            'players_by_group' => $this->getPlayerByGroups(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/groups/players', $data);
    }

    /**
     * Get players grouped by their youth groups
     */
    private function getPlayerByGroups()
    {
        $groups = $this->groupModel->getActive();
        $playersByGroup = [];
        
        foreach ($groups as $group) {
            $players = $this->playerModel->getByGroup($group['id']);
            if (!empty($players)) {
                $playersByGroup[$group['id']] = [
                    'group' => $group,
                    'players' => $players
                ];
            }
        }
        
        return $playersByGroup;
    }

    /**
     * Academy information
     */
    public function academy()
    {
        $data = [
            'title' => 'Akademi - Gruplarımız',
            'academy_info' => $this->groupModel->getAcademyInfo(),
            'programs' => $this->groupModel->getAcademyPrograms(),
            'enrollment_info' => $this->groupModel->getEnrollmentInfo(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/groups/academy', $data);
    }
}