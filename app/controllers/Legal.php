<?php
/**
 * Legal Controller
 * Privacy policy, terms of service and legal pages
 */
class Legal extends Controller
{
    private $settingsModel;

    public function __construct()
    {
        $this->settingsModel = $this->model('SiteSettings');
    }

    /**
     * Privacy policy page
     */
    public function privacy()
    {
        $data = [
            'title' => 'Gizlilik Politikası',
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/legal/privacy', $data);
    }

    /**
     * Terms of service page
     */
    public function terms()
    {
        $data = [
            'title' => 'Kullanım Şartları',
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/legal/terms', $data);
    }

    /**
     * Cookie policy page
     */
    public function cookies()
    {
        $data = [
            'title' => 'Çerez Politikası',
            'site_settings' => $this->settingsModel->getAllSettings()
        ];

        $this->view('frontend/legal/cookies', $data);
    }
}
?>