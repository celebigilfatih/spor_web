<?php
/**
 * AdminSettings Controller
 * Site settings management for admin panel
 */
class AdminSettings extends Controller
{
    private $settingsModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->settingsModel = $this->model('SiteSettings');
    }

    /**
     * Settings main page
     */
    public function index()
    {
        $data = [
            'title' => 'Site Ayarları',
            'settings' => $this->settingsModel->getAllSettings(),
            'csrf_token' => $this->generateCSRFToken(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            // CSRF token kontrolü
            if (!$this->validateCSRFToken($csrf_token)) {
                $data['error'] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
            } else {
                $settings = [
                    'site_title' => $this->sanitizeInput($_POST['site_title']),
                    'site_description' => $this->sanitizeInput($_POST['site_description']),
                    'contact_email' => $this->sanitizeInput($_POST['contact_email']),
                    'contact_phone' => $this->sanitizeInput($_POST['contact_phone']),
                    'contact_address' => $this->sanitizeInput($_POST['contact_address']),
                    'facebook_url' => $this->sanitizeInput($_POST['facebook_url']),
                    'twitter_url' => $this->sanitizeInput($_POST['twitter_url']),
                    'instagram_url' => $this->sanitizeInput($_POST['instagram_url']),
                    'youtube_url' => $this->sanitizeInput($_POST['youtube_url']),
                    'club_founded' => $this->sanitizeInput($_POST['club_founded']),
                    'club_colors' => $this->sanitizeInput($_POST['club_colors']),
                    'stadium_name' => $this->sanitizeInput($_POST['stadium_name']),
                    'stadium_capacity' => $this->sanitizeInput($_POST['stadium_capacity'])
                ];

                // Handle logo upload
                if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = $this->uploadFile($_FILES['site_logo'], ['jpg', 'jpeg', 'png', 'svg']);
                    if ($uploadResult['success']) {
                        $settings['site_logo'] = $uploadResult['filename'];
                    }
                }

                // Handle favicon upload
                if (isset($_FILES['site_favicon']) && $_FILES['site_favicon']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = $this->uploadFile($_FILES['site_favicon'], ['ico', 'png']);
                    if ($uploadResult['success']) {
                        $settings['site_favicon'] = $uploadResult['filename'];
                    }
                }

                $success = true;
                $errorMessages = [];
                foreach ($settings as $key => $value) {
                    try {
                        if (!$this->settingsModel->updateSetting($key, $value)) {
                            $success = false;
                            $errorMessages[] = "Failed to update: $key";
                        }
                    } catch (Exception $e) {
                        $success = false;
                        $errorMessages[] = "Error updating $key: " . $e->getMessage();
                        error_log("Settings update error for $key: " . $e->getMessage());
                    }
                }

                if ($success) {
                    $data['message'] = 'Ayarlar başarıyla güncellendi!';
                    $data['settings'] = $this->settingsModel->getAllSettings(); // Refresh settings
                } else {
                    $data['error'] = 'Ayarlar güncellenirken bir hata oluştu! ' . implode(', ', $errorMessages);
                }
            }
        }

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/settings/index', $data);
    }

    /**
     * Logo and media settings
     */
    public function media()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updates = [];

            // Handle logo upload
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
                $uploadResult = $this->uploadFile($_FILES['logo'], ['jpg', 'jpeg', 'png']);
                if ($uploadResult['success']) {
                    $updates['site_logo'] = $uploadResult['filename'];
                }
            }

            // Handle favicon upload
            if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === 0) {
                $uploadResult = $this->uploadFile($_FILES['favicon'], ['ico', 'png']);
                if ($uploadResult['success']) {
                    $updates['site_favicon'] = $uploadResult['filename'];
                }
            }

            $success = true;
            foreach ($updates as $key => $value) {
                if (!$this->settingsModel->updateSetting($key, $value)) {
                    $success = false;
                    break;
                }
            }

            if ($success && !empty($updates)) {
                $_SESSION['message'] = 'Medya dosyaları başarıyla güncellendi!';
            } elseif (empty($updates)) {
                $_SESSION['error'] = 'Güncellenecek dosya seçilmedi!';
            } else {
                $_SESSION['error'] = 'Dosyalar güncellenirken bir hata oluştu!';
            }
        }

        $data = [
            'title' => 'Medya Ayarları',
            'settings' => $this->settingsModel->getAllSettings(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/settings/media', $data);
    }

    /**
     * SEO settings
     */
    public function seo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $seoSettings = [
                'meta_keywords' => $this->sanitizeInput($_POST['meta_keywords']),
                'meta_description' => $this->sanitizeInput($_POST['meta_description']),
                'google_analytics' => $this->sanitizeInput($_POST['google_analytics']),
                'google_search_console' => $this->sanitizeInput($_POST['google_search_console']),
                'robots_txt' => $this->sanitizeInput($_POST['robots_txt'])
            ];

            $success = true;
            foreach ($seoSettings as $key => $value) {
                if (!$this->settingsModel->updateSetting($key, $value)) {
                    $success = false;
                    break;
                }
            }

            if ($success) {
                $_SESSION['message'] = 'SEO ayarları başarıyla güncellendi!';
            } else {
                $_SESSION['error'] = 'SEO ayarları güncellenirken bir hata oluştu!';
            }
        }

        $data = [
            'title' => 'SEO Ayarları',
            'settings' => $this->settingsModel->getAllSettings(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/settings/seo', $data);
    }

    /**
     * Maintenance mode settings
     */
    public function maintenance()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maintenanceSettings = [
                'maintenance_mode' => isset($_POST['maintenance_mode']) ? '1' : '0',
                'maintenance_message' => $this->sanitizeInput($_POST['maintenance_message']),
                'maintenance_end_date' => $this->sanitizeInput($_POST['maintenance_end_date'])
            ];

            $success = true;
            foreach ($maintenanceSettings as $key => $value) {
                if (!$this->settingsModel->updateSetting($key, $value)) {
                    $success = false;
                    break;
                }
            }

            if ($success) {
                $_SESSION['message'] = 'Bakım modu ayarları başarıyla güncellendi!';
            } else {
                $_SESSION['error'] = 'Bakım modu ayarları güncellenirken bir hata oluştu!';
            }
        }

        $data = [
            'title' => 'Bakım Modu',
            'settings' => $this->settingsModel->getAllSettings(),
            'message' => $_SESSION['message'] ?? '',
            'error' => $_SESSION['error'] ?? ''
        ];

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);

        $this->view('admin/settings/maintenance', $data);
    }
}
?>