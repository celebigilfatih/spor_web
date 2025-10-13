<?php
/**
 * TechnicalStaff Controller
 * Technical staff and coaches controller
 */
class TechnicalStaff extends Controller
{
    private $staffModel;
    private $settingsModel;

    public function __construct()
    {
        $this->staffModel = $this->model('TechnicalStaff');
        $this->settingsModel = $this->model('SiteSettings');
    }

    /**
     * Technical staff main page
     */
    public function index()
    {
        $data = [
            'title' => 'Teknik Kadro - ' . $this->settingsModel->getSetting('site_title', 'Spor Kulübü'),
            'head_coach' => $this->staffModel->getHeadCoach(),
            'assistant_coaches' => $this->staffModel->getAssistantCoaches(),
            'goalkeeping_coaches' => $this->staffModel->getGoalkeepingCoaches(),
            'fitness_coaches' => $this->staffModel->getFitnessCoaches(),
            'medical_staff' => $this->staffModel->getMedicalStaff(),
            'other_staff' => $this->staffModel->getOtherStaff(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/staff/index', $data);
    }

    /**
     * Staff member details
     */
    public function view($staffId = null)
    {
        if (!$staffId) {
            $this->redirect('technical-staff');
        }

        $staff = $this->staffModel->findById($staffId);
        if (!$staff) {
            $this->redirect('technical-staff');
        }

        $data = [
            'title' => $staff['name'] . ' - Teknik Kadro',
            'staff' => $staff,
            'career_history' => $this->staffModel->getCareerHistory($staffId),
            'achievements' => $this->staffModel->getStaffAchievements($staffId),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/staff/view', $data);
    }

    /**
     * Coaching philosophy
     */
    public function philosophy()
    {
        $data = [
            'title' => 'Antrenman Felsefesi - Teknik Kadro',
            'philosophy' => $this->staffModel->getCoachingPhilosophy(),
            'training_methods' => $this->staffModel->getTrainingMethods(),
            'development_programs' => $this->staffModel->getDevelopmentPrograms(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/staff/philosophy', $data);
    }
}