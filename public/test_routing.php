<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Routing Test</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #1e1e1e; color: #d4d4d4; }
        h2 { color: #4ec9b0; }
        pre { background: #2d2d2d; padding: 15px; border-left: 3px solid #007acc; }
        .success { color: #4ec9b0; }
        .error { color: #f48771; }
        a { color: #569cd6; }
    </style>
</head>
<body>
    <h1>🔍 Routing Test</h1>
    
    <?php
    define('BASE_PATH', dirname(__DIR__));
    define('BASE_URL', 'http://localhost:8090');
    
    echo "<h2>Test 1: URL Parsing</h2>";
    echo "<pre>";
    
    // Simulate different URLs
    $testUrls = [
        '/youth-registration',
        '/youth-registration/submit',
        '/admin/youth-registrations',
    ];
    
    foreach ($testUrls as $testUrl) {
        echo "\nURL: $testUrl\n";
        $parts = explode('/', trim($testUrl, '/'));
        echo "Parts: " . print_r($parts, true);
        
        if ($parts[0] === 'youth-registration') {
            echo "  Controller: YouthRegistration\n";
            if (isset($parts[1]) && $parts[1] === 'submit') {
                echo "  Method: submit\n";
                echo "  <span class='success'>✅ Should call YouthRegistration->submit()</span>\n";
            } else {
                echo "  Method: index\n";
            }
        }
    }
    
    echo "</pre>";
    
    echo "<h2>Test 2: Controller File Check</h2>";
    echo "<pre>";
    
    $controllerFile = BASE_PATH . '/app/controllers/YouthRegistration.php';
    echo "Controller file: $controllerFile\n";
    echo "Exists: " . (file_exists($controllerFile) ? '<span class="success">✅ Yes</span>' : '<span class="error">❌ No</span>') . "\n";
    
    if (file_exists($controllerFile)) {
        require_once BASE_PATH . '/core/Controller.php';
        require_once BASE_PATH . '/core/Model.php';
        require_once BASE_PATH . '/core/Database.php';
        require_once $controllerFile;
        
        echo "Class exists: " . (class_exists('YouthRegistration') ? '<span class="success">✅ Yes</span>' : '<span class="error">❌ No</span>') . "\n";
        
        if (class_exists('YouthRegistration')) {
            $methods = get_class_methods('YouthRegistration');
            echo "Methods:\n";
            foreach ($methods as $method) {
                $highlight = ($method === 'submit' || $method === 'index') ? '<span class="success">' . $method . '</span>' : $method;
                echo "  - $highlight\n";
            }
            
            echo "\nsubmit method exists: " . (method_exists('YouthRegistration', 'submit') ? '<span class="success">✅ Yes</span>' : '<span class="error">❌ No</span>') . "\n";
        }
    }
    
    echo "</pre>";
    
    echo "<h2>Test 3: Actual POST Test</h2>";
    echo "<pre>";
    echo "Try submitting the form below:\n";
    echo "</pre>";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<pre class='success'>";
        echo "✅ POST Request Received!\n";
        echo "POST Data:\n";
        print_r($_POST);
        echo "</pre>";
    }
    ?>
    
    <form method="POST" action="/youth-registration/submit" style="background: #2d2d2d; padding: 20px; margin: 20px 0;">
        <h3 style="color: #4ec9b0;">Test Form Submit</h3>
        <input type="text" name="test_field" value="Test Value" style="padding: 5px; margin: 10px 0; display: block;">
        <button type="submit" style="background: #007acc; color: white; padding: 10px 20px; border: none; cursor: pointer;">Submit to /youth-registration/submit</button>
    </form>
    
    <hr style="border-color: #444; margin: 30px 0;">
    <p><a href="/youth-registration">← Back to Registration Form</a></p>
    <p><a href="/debug_youth_logs.php">Debug Logs →</a></p>
</body>
</html>
