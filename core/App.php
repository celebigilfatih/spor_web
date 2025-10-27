<?php
/**
 * Ana Uygulama Sınıfı
 * URL yönlendirme ve controller yönetimi
 */
class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        
        // Debug output
        error_log("[DEBUG] Parsed URL: " . print_r($url, true));
        
        // Admin paneli kontrolü
        if (isset($url[0]) && $url[0] === 'admin') {
            error_log("[DEBUG] Admin route detected");
            $this->handleAdminRoute($url);
        } else {
            error_log("[DEBUG] Frontend route detected");
            $this->handleFrontendRoute($url);
        }
    }

    private function handleAdminRoute($url)
    {
        error_log("[DEBUG] handleAdminRoute called with: " . print_r($url, true));
        
        // Admin controller'ını kontrol et
        if (isset($url[1])) {
            error_log("[DEBUG] Admin action: " . $url[1]);
            // Login işlemi için özel routing
            if ($url[1] === 'login' || $url[1] === 'logout' || $url[1] === 'auth') {
                error_log("[DEBUG] Setting AdminAuth controller");
                $this->controller = 'AdminAuth';
                if ($url[1] === 'login') {
                    $this->method = 'login';
                } elseif ($url[1] === 'logout') {
                    $this->method = 'logout';
                } elseif ($url[1] === 'auth' && isset($url[2])) {
                    // Handle /admin/auth/forgotPassword or /admin/auth/forgot-password
                    if ($url[2] === 'forgotPassword' || $url[2] === 'forgot-password') {
                        $this->method = 'forgotPassword';
                    } elseif ($url[2] === 'profile') {
                        $this->method = 'profile';
                    } else {
                        $this->method = $url[2];
                    }
                    $this->params = array_slice($url, 3);
                } else {
                    $this->method = 'index';
                }
                // URL parametrelerini ayarla
                if ($url[1] !== 'auth') {
                    $this->params = array_slice($url, 2); // /admin/login/... sonrası parametreler
                }
            } else {
                // URL'deki tire işaretlerini camelCase'e çevir
                // youth-registrations -> YouthRegistrations
                $parts = explode('-', $url[1]);
                $controllerName = implode('', array_map('ucfirst', $parts));
                $adminController = 'Admin' . $controllerName;
                
                // Özel durum: YouthRegistrations -> YouthRegistration
                if ($adminController === 'AdminYouthRegistrations') {
                    $adminController = 'AdminYouthRegistration';
                }
                
                error_log("[DEBUG] Looking for admin controller: " . $adminController);
                
                if (file_exists(BASE_PATH . '/app/controllers/' . $adminController . '.php')) {
                    $this->controller = $adminController;
                    // Load controller file to check methods
                    require_once BASE_PATH . '/app/controllers/' . $adminController . '.php';
                    // Method kontrolü
                    if (isset($url[2]) && method_exists($adminController, $url[2])) {
                        $this->method = $url[2];
                        $this->params = array_slice($url, 3); // /admin/news/edit/1 -> [1]
                    } else {
                        $this->method = 'index';
                        $this->params = array_slice($url, 2); // /admin/news/1 -> [1]
                    }
                } else {
                    error_log("[DEBUG] Admin controller not found: " . $adminController);
                    $this->controller = 'AdminDashboard';
                    $this->method = 'index';
                    $this->params = [];
                }
            }
        } else {
            $this->controller = 'AdminDashboard';
            $this->method = 'index';
            $this->params = [];
        }
        
        error_log("[DEBUG] Final controller: " . $this->controller . ", method: " . $this->method . ", params: " . print_r($this->params, true));
        
        // Controller'ı yükle ve çalıştır (sadece henüz yüklenmemişse)
        $controllerFile = BASE_PATH . '/app/controllers/' . $this->controller . '.php';
        if (!class_exists($this->controller)) {
            require_once $controllerFile;
        }
        $controllerInstance = new $this->controller;
        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    private function handleFrontendRoute($url)
    {
        // Frontend controller'ını kontrol et
        if (isset($url[0])) {
            $controller = ucfirst($url[0]);
            
            // Turkish URL aliases (Türkçe URL takma adları)
            $turkishAliases = [
                'hakkimizda' => 'About',
                'hakkımızda' => 'About',
                'haberler' => 'News',
                'gruplar' => 'Groups',
                'a-takimi' => 'ATeam',
                'teknik-kadro' => 'TechnicalStaff',
                'altyapi-kayit' => 'YouthRegistration',
            ];
            
            // Special handling for contact page (iletisim)
            if (strtolower($url[0]) === 'iletisim') {
                $this->controller = 'Home';
                require_once BASE_PATH . '/app/controllers/Home.php';
                $this->method = 'contact';
                $this->params = [];
                $controllerInstance = new $this->controller;
                call_user_func_array([$controllerInstance, $this->method], $this->params);
                return;
            }
            
            // Check if it's a Turkish alias
            if (isset($turkishAliases[strtolower($url[0])])) {
                $controller = $turkishAliases[strtolower($url[0])];
            }
            // Special routing for specific URLs
            elseif ($url[0] === 'technical-staff') {
                $controller = 'TechnicalStaff';
            } elseif ($url[0] === 'ateam') {
                $controller = 'ATeam';
            } elseif ($url[0] === 'youth-registration' || $url[0] === 'altyapi-kayit') {
                $controller = 'YouthRegistration';
            }
            
            if (file_exists(BASE_PATH . '/app/controllers/' . $controller . '.php')) {
                $this->controller = $controller;
                // Load controller file to check methods
                require_once BASE_PATH . '/app/controllers/' . $controller . '.php';
                // Method kontrolü
                if (isset($url[1]) && method_exists($controller, $url[1])) {
                    $this->method = $url[1];
                    $this->params = array_slice($url, 2);
                } else {
                    $this->method = 'index';
                    $this->params = array_slice($url, 1);
                }
            }
        }
        
        // Controller'ı yükle ve çalıştır (sadece henüz yüklenmemişse)
        $controllerFile = BASE_PATH . '/app/controllers/' . $this->controller . '.php';
        if (!class_exists($this->controller)) {
            require_once $controllerFile;
        }
        $controllerInstance = new $this->controller;
        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}