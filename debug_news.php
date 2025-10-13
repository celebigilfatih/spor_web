<?php
// Comprehensive Debug script for testing all admin CRUD operations
require_once 'core/Database.php';

// Start session
session_start();

// Set admin session for testing
$_SESSION['admin'] = [
    'id' => 1,
    'username' => 'admin',
    'email' => 'admin@test.com'
];

echo "<!DOCTYPE html>";
echo "<html><head><title>Admin CRUD Debug</title>";
echo "<style>body{font-family:Arial;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} .warning{color:orange;} hr{margin:20px 0;}</style>";
echo "</head><body>";
echo "<h1>Admin CRUD Operations Debug</h1>";

// Define base URL
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost');
}

echo "<h2>1. Core App Class Test</h2>";
try {
    $app = new App();
    echo "<p class='success'>✓ App class instantiated successfully</p>";
} catch (Exception $e) {
    echo "<p class='error'>✗ App class error: " . $e->getMessage() . "</p>";
}

echo "<h2>2. Database Connection Test</h2>";
try {
    $database = new Database();
    $db = $database->getPDO();
    echo "<p class='success'>✓ Database connection successful</p>";
    
    // Test basic query
    $stmt = $db->query("SELECT 1");
    echo "<p class='success'>✓ Database query test successful</p>";
} catch (Exception $e) {
    echo "<p class='error'>✗ Database error: " . $e->getMessage() . "</p>";
}

echo "<h2>3. Controllers Availability Test</h2>";
$controllers = [
    'AdminNews' => 'app/controllers/AdminNews.php',
    'AdminPlayers' => 'app/controllers/AdminPlayers.php', 
    'AdminTeams' => 'app/controllers/AdminTeams.php',
    'AdminMatches' => 'app/controllers/AdminMatches.php',
    'AdminStaff' => 'app/controllers/AdminStaff.php',
    'AdminSettings' => 'app/controllers/AdminSettings.php'
];

foreach ($controllers as $controllerName => $controllerFile) {
    echo "<h4>Testing $controllerName</h4>";
    
    if (file_exists($controllerFile)) {
        echo "<p class='success'>✓ File exists: $controllerFile</p>";
        
        require_once $controllerFile;
        if (class_exists($controllerName)) {
            echo "<p class='success'>✓ Class $controllerName loaded</p>";
            
            try {
                $controller = new $controllerName();
                echo "<p class='success'>✓ $controllerName instantiated</p>";
                
                // Test CRUD methods
                $methods = ['index', 'add', 'edit', 'delete', 'save'];
                foreach ($methods as $method) {
                    if (method_exists($controller, $method)) {
                        echo "<p class='info'>  ✓ Method '$method' exists</p>";
                    } else {
                        echo "<p class='warning'>  ⚠ Method '$method' missing</p>";
                    }
                }
            } catch (Exception $e) {
                echo "<p class='error'>✗ Error instantiating $controllerName: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p class='error'>✗ Class $controllerName not found in file</p>";
        }
    } else {
        echo "<p class='error'>✗ File not found: $controllerFile</p>";
    }
    echo "<hr>";
}

echo "<h2>4. URL Routing Test</h2>";
$testRoutes = [
    '/admin/news' => 'AdminNews->index',
    '/admin/news/add' => 'AdminNews->add', 
    '/admin/news/edit/1' => 'AdminNews->edit(1)',
    '/admin/news/delete/1' => 'AdminNews->delete(1)',
    '/admin/players' => 'AdminPlayers->index',
    '/admin/players/add' => 'AdminPlayers->add',
    '/admin/teams' => 'AdminTeams->index',
    '/admin/matches' => 'AdminMatches->index',
    '/admin/staff' => 'AdminStaff->index',
    '/admin/settings' => 'AdminSettings->index'
];

foreach ($testRoutes as $route => $expected) {
    echo "<h4>Testing Route: $route</h4>";
    echo "<p class='info'>Expected: $expected</p>";
    
    // Parse URL manually to test routing logic
    $url = trim($route, '/');
    $url = explode('/', $url);
    
    echo "<p class='info'>URL segments: " . implode(' | ', $url) . "</p>";
    
    if (isset($url[0]) && $url[0] === 'admin') {
        if (isset($url[1])) {
            $controller = 'Admin' . ucfirst($url[1]);
            $method = isset($url[2]) ? $url[2] : 'index';
            $params = array_slice($url, 3);
            
            echo "<p class='success'>✓ Parsed - Controller: $controller, Method: $method, Params: [" . implode(', ', $params) . "]</p>";
            
            // Test if controller and method exist
            $controllerFile = "app/controllers/$controller.php";
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                if (class_exists($controller)) {
                    $controllerInstance = new $controller();
                    if (method_exists($controllerInstance, $method)) {
                        echo "<p class='success'>✓ Controller and method are valid</p>";
                    } else {
                        echo "<p class='error'>✗ Method '$method' not found in $controller</p>";
                    }
                } else {
                    echo "<p class='error'>✗ Class '$controller' not found</p>";
                }
            } else {
                echo "<p class='error'>✗ Controller file not found: $controllerFile</p>";
            }
        } else {
            echo "<p class='error'>✗ No admin resource specified</p>";
        }
    } else {
        echo "<p class='error'>✗ Not an admin route</p>";
    }
    echo "<hr>";
}

echo "<h2>5. Session and Security Test</h2>";
if (isset($_SESSION['admin'])) {
    echo "<p class='success'>✓ Admin session is active</p>";
    echo "<p class='info'>Admin ID: " . $_SESSION['admin']['id'] . "</p>";
    echo "<p class='info'>Admin Username: " . $_SESSION['admin']['username'] . "</p>";
} else {
    echo "<p class='error'>✗ No admin session found</p>";
}

// Test CSRF token generation
if (function_exists('generateCSRFToken')) {
    echo "<p class='success'>✓ CSRF token function available</p>";
} else {
    echo "<p class='warning'>⚠ CSRF token function not found</p>";
}

echo "<h2>6. File Permissions Test</h2>";
$directories = [
    'app/controllers',
    'app/views/admin',
    'public/uploads',
    'core'
];

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        if (is_readable($dir)) {
            echo "<p class='success'>✓ Directory readable: $dir</p>";
        } else {
            echo "<p class='error'>✗ Directory not readable: $dir</p>";
        }
        
        if (is_writable($dir)) {
            echo "<p class='success'>✓ Directory writable: $dir</p>";
        } else {
            echo "<p class='warning'>⚠ Directory not writable: $dir</p>";
        }
    } else {
        echo "<p class='error'>✗ Directory not found: $dir</p>";
    }
}

echo "<h2>7. Manual Test Links</h2>";
echo "<p class='info'>Click these links to test CRUD operations manually:</p>";
echo "<ul>";
echo "<li><a href='" . BASE_URL . "/admin/news' target='_blank'>News Management</a></li>";
echo "<li><a href='" . BASE_URL . "/admin/players' target='_blank'>Players Management</a></li>";
echo "<li><a href='" . BASE_URL . "/admin/teams' target='_blank'>Teams Management</a></li>";
echo "<li><a href='" . BASE_URL . "/admin/matches' target='_blank'>Matches Management</a></li>";
echo "<li><a href='" . BASE_URL . "/admin/staff' target='_blank'>Staff Management</a></li>";
echo "<li><a href='" . BASE_URL . "/admin/settings' target='_blank'>Settings Management</a></li>";
echo "</ul>";

echo "<h2>Debug Complete</h2>";
echo "<p class='info'>Check all sections above for any errors or warnings that might be causing CRUD operation failures.</p>";
echo "<p class='warning'>If routing tests pass but CRUD still doesn't work, the issue might be in the front-end JavaScript or form submissions.</p>";
echo "</body></html>";
?>