<?php
// Test Youth Registration Form Submission
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', 'http://localhost:8090');
define('UPLOAD_PATH', BASE_PATH . '/public/uploads');

session_start();

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/core/Database.php';
require_once BASE_PATH . '/config/docker.php';
require_once BASE_PATH . '/app/controllers/YouthRegistration.php';

echo "<h1>🧪 Youth Registration Form Test</h1>";
echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;} .success{color:green;} .error{color:red;} pre{background:#f5f5f5;padding:10px;border-radius:5px;}</style>";

// Simulate form submission
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = [
    'csrf_token' => $_SESSION['csrf_token'] ?? '',
    'student_name' => 'Test Öğrenci',
    'youth_group_id' => '8',
    'first_club' => 'Test Kulübü',
    'birth_date' => '2010-01-15',
    'birth_place' => 'İstanbul',
    'tc_number' => '12345678901',
    'father_name' => 'Test Baba',
    'mother_name' => 'Test Anne',
    'school_info' => 'Test İlkokulu 5. Sınıf',
    'parent_name' => 'Test Veli',
    'parent_phone' => '5551234567',
    'address' => 'Test Mahallesi Test Sokak No:1 Test/İSTANBUL',
    'email' => 'test@test.com',
    'father_job' => 'Mühendis',
    'mother_job' => 'Öğretmen',
    'emergency_contact' => 'Test Acil Kişi',
    'emergency_relation' => 'amca',
    'emergency_phone' => '5559876543'
];

// Create a test image file
$testImagePath = BASE_PATH . '/public/test_photo.jpg';
if (!file_exists($testImagePath)) {
    // Create a simple test image
    $img = imagecreatetruecolor(200, 200);
    $bgColor = imagecolorallocate($img, 255, 255, 255);
    $textColor = imagecolorallocate($img, 0, 0, 0);
    imagefill($img, 0, 0, $bgColor);
    imagestring($img, 5, 50, 90, 'TEST PHOTO', $textColor);
    imagejpeg($img, $testImagePath, 90);
    imagedestroy($img);
}

// Simulate file upload
$_FILES['student_photo'] = [
    'name' => 'test_photo.jpg',
    'type' => 'image/jpeg',
    'tmp_name' => $testImagePath,
    'error' => UPLOAD_ERR_OK,
    'size' => filesize($testImagePath)
];

echo "<h2>📝 Test Data:</h2>";
echo "<pre>";
echo "Student: " . $_POST['student_name'] . "\n";
echo "Birth Date: " . $_POST['birth_date'] . "\n";
echo "TC No: " . $_POST['tc_number'] . "\n";
echo "Parent: " . $_POST['parent_name'] . "\n";
echo "Phone: " . $_POST['parent_phone'] . "\n";
echo "Email: " . $_POST['email'] . "\n";
echo "</pre>";

try {
    // Generate CSRF token first
    $controller = new YouthRegistration();
    
    // Get the token
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('generateCSRFToken');
    $method->setAccessible(true);
    $_POST['csrf_token'] = $method->invoke($controller);
    
    echo "<h2>🔄 Submitting Form...</h2>";
    
    // Capture output
    ob_start();
    $controller->submit();
    $output = ob_get_clean();
    
    // Check results
    echo "<h2>📊 Results:</h2>";
    
    // Check if registration file was created
    $registrationsDir = BASE_PATH . '/data/youth-registrations';
    $files = glob($registrationsDir . '/reg_*.json');
    
    if (!empty($files)) {
        $latestFile = end($files);
        $data = json_decode(file_get_contents($latestFile), true);
        
        echo "<p class='success'>✅ Registration saved successfully!</p>";
        echo "<p><strong>File:</strong> " . basename($latestFile) . "</p>";
        echo "<h3>Registration Data:</h3>";
        echo "<pre>" . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
        
        // Check photo
        if (!empty($data['photo_path'])) {
            $photoFullPath = BASE_PATH . '/public' . $data['photo_path'];
            if (file_exists($photoFullPath)) {
                echo "<p class='success'>✅ Photo uploaded successfully!</p>";
                echo "<p><strong>Photo:</strong> " . $data['photo_path'] . "</p>";
                echo "<img src='" . $data['photo_path'] . "' style='max-width:200px;border:1px solid #ccc;'>";
            } else {
                echo "<p class='error'>❌ Photo file not found: " . $photoFullPath . "</p>";
            }
        }
    } else {
        echo "<p class='error'>❌ No registration files found!</p>";
        echo "<p>Directory: " . $registrationsDir . "</p>";
        
        // Check permissions
        if (is_dir($registrationsDir)) {
            $perms = substr(sprintf('%o', fileperms($registrationsDir)), -4);
            echo "<p>Permissions: " . $perms . "</p>";
            echo "<p>Writable: " . (is_writable($registrationsDir) ? 'Yes' : 'No') . "</p>";
        } else {
            echo "<p class='error'>Directory does not exist!</p>";
        }
    }
    
    // Check session messages
    if (isset($_SESSION['success_message'])) {
        echo "<p class='success'>✅ Success Message: " . $_SESSION['success_message'] . "</p>";
    }
    if (isset($_SESSION['form_errors'])) {
        echo "<p class='error'>❌ Form Errors:</p><ul>";
        foreach ($_SESSION['form_errors'] as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

echo "<hr>";
echo "<h2>🔗 Links:</h2>";
echo "<p><a href='/youth-registration'>📝 Go to Registration Form</a></p>";
echo "<p><a href='/admin/youth-registrations'>👤 Go to Admin Panel</a></p>";
?>
