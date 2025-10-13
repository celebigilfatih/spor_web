<?php
/**
 * Debug script to test routing
 */

echo "<h1>Debug: Routing Test</h1>";

// Test URL parsing
if (isset($_GET['url'])) {
    $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    echo "<p><strong>URL:</strong> " . htmlspecialchars($_GET['url']) . "</p>";
    echo "<p><strong>Parsed URL:</strong> " . print_r($url, true) . "</p>";
    
    if (isset($url[0]) && $url[0] === 'admin') {
        echo "<p><strong>Admin Route Detected!</strong></p>";
        
        if (isset($url[1])) {
            echo "<p><strong>Admin Action:</strong> " . htmlspecialchars($url[1]) . "</p>";
            
            if ($url[1] === 'login') {
                echo "<p><strong>Login Action Detected!</strong></p>";
                echo "<p>Should load AdminAuth controller with login method</p>";
                
                // Check if file exists
                $controllerPath = __DIR__ . '/app/controllers/AdminAuth.php';
                if (file_exists($controllerPath)) {
                    echo "<p>✅ AdminAuth.php exists</p>";
                } else {
                    echo "<p>❌ AdminAuth.php not found at: $controllerPath</p>";
                }
            }
        }
    }
} else {
    echo "<p>No URL parameter found</p>";
}

echo "<hr>";
echo "<h2>Quick Links:</h2>";
echo "<a href='?url=admin/login'>Test Admin Login Route</a><br>";
echo "<a href='index.php?url=admin/login'>Test With index.php</a><br>";
echo "<a href='admin/login'>Direct Admin Login</a><br>";

echo "<hr>";
echo "<h2>File Structure Check:</h2>";

$files = [
    'index.php' => __DIR__ . '/index.php',
    'App.php' => __DIR__ . '/core/App.php',
    'AdminAuth.php' => __DIR__ . '/app/controllers/AdminAuth.php',
    'Admin login view' => __DIR__ . '/app/views/admin/auth/login.php'
];

foreach ($files as $name => $path) {
    if (file_exists($path)) {
        echo "<p>✅ $name exists</p>";
    } else {
        echo "<p>❌ $name not found: $path</p>";
    }
}
?>