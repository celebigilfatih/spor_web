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
        $this->groupModel = $this->model('GroupModel');
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
            'groups' => $this->groupModel->getActiveGroups(),
            'academy_info' => $this->groupModel->getAcademyInfo(),
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