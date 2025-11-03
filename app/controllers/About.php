<?php
/**
 * About Controller
 * About Us page controller
 */
class About extends Controller
{
    private $aboutModel;
    private $settingsModel;

    public function __construct()
    {
        $this->aboutModel = $this->model('AboutUs');
        $this->settingsModel = $this->model('SiteSettings');
    }

    /**
     * About Us main page
     */
    public function index()
    {
        // Get all active sections from database
        $sections = $this->aboutModel->getActiveSections();
        
        $data = [
            'title' => 'Hakkımızda - ' . $this->settingsModel->getSetting('site_title', 'Spor Kulübü'),
            'sections' => $sections,
            'history' => $this->aboutModel->getHistory(),
            'achievements' => $this->aboutModel->getAchievements(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/about/index', $data);
    }

    /**
     * Club history page
     */
    public function history()
    {
        $data = [
            'title' => 'Kulüp Tarihi',
            'history' => $this->aboutModel->getHistory(),
            'milestones' => $this->aboutModel->getMilestones(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/about/history', $data);
    }

    /**
     * Achievements page
     */
    public function achievements()
    {
        $data = [
            'title' => 'Başarılarımız',
            'trophies' => $this->aboutModel->getTrophies(),
            'achievements' => $this->aboutModel->getAchievements(),
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/about/achievements', $data);
    }
}