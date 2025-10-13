<?php
/**
 * Admin CRUD Debug Test
 * Test all admin CRUD operations
 */

// Include the base configuration
require_once '../config/database.php';
require_once '../core/Database.php';

echo "<!DOCTYPE html>";
echo "<html><head><title>Admin CRUD Debug</title>";
echo "<style>body{font-family:Arial;margin:20px;background:#f5f5f5;} .container{max-width:1000px;margin:0 auto;background:white;padding:30px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);} .success{color:#28a745;} .error{color:#dc3545;} .info{color:#17a2b8;} .warning{color:#ffc107;} .test-section{margin:30px 0;padding:20px;border-left:4px solid #007bff;background:#f8f9fa;} .url-test{padding:10px;margin:5px 0;background:#e9ecef;border-radius:4px;} .url-test a{color:#007bff;text-decoration:none;} .url-test a:hover{text-decoration:underline;}</style>";
echo "</head><body>";
echo "<div class='container'>";
echo "<h1>🔧 Admin CRUD Operations Debug</h1>";

// Start session for admin simulation
session_start();
$_SESSION['admin'] = [
    'id' => 1,
    'username' => 'debug_admin',
    'email' => 'debug@test.com'
];

echo "<div class='test-section'>";
echo "<h2>📊 System Status</h2>";

// Test 1: Database Connection
echo "<h3>1. Database Connection Test</h3>";
try {
    $database = new Database();
    echo "<p class='success'>✅ Database connection successful</p>";
    
    // Test a basic query
    $testQuery = $database->query("SELECT 1 as test");
    if ($testQuery) {
        echo "<p class='success'>✅ Database query test successful</p>";
    } else {
        echo "<p class='error'>❌ Database query test failed</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Database error: " . $e->getMessage() . "</p>";
}

// Test 2: Controller Files
echo "<h3>2. Admin Controller Files Test</h3>";
$controllers = [
    'AdminNews' => '../app/controllers/AdminNews.php',
    'AdminPlayers' => '../app/controllers/AdminPlayers.php',
    'AdminTeams' => '../app/controllers/AdminTeams.php',
    'AdminMatches' => '../app/controllers/AdminMatches.php',
    'AdminStaff' => '../app/controllers/AdminStaff.php',
    'AdminSettings' => '../app/controllers/AdminSettings.php'
];

foreach ($controllers as $name => $file) {
    if (file_exists($file)) {
        echo "<p class='success'>✅ $name controller exists</p>";
    } else {
        echo "<p class='error'>❌ $name controller missing: $file</p>";
    }
}

// Test 3: Core Files
echo "<h3>3. Core Framework Files Test</h3>";
$coreFiles = [
    'App.php' => '../core/App.php',
    'Controller.php' => '../core/Controller.php',
    'Database.php' => '../core/Database.php'
];

foreach ($coreFiles as $name => $file) {
    if (file_exists($file)) {
        echo "<p class='success'>✅ $name exists</p>";
    } else {
        echo "<p class='error'>❌ $name missing: $file</p>";
    }
}

// Test 4: Database Tables
echo "<h3>4. Database Tables Test</h3>";
try {
    $tables = ['news', 'players', 'teams', 'matches', 'staff', 'admins', 'settings'];
    
    foreach ($tables as $table) {
        $result = $database->query("SHOW TABLES LIKE '$table'");
        if ($result && count($result) > 0) {
            echo "<p class='success'>✅ Table '$table' exists</p>";
        } else {
            echo "<p class='error'>❌ Table '$table' missing</p>";
        }
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Database table check error: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 5: URL Routing Simulation
echo "<div class='test-section'>";
echo "<h2>🔗 URL Routing Test</h2>";
echo "<p class='info'>Test these URLs manually to verify CRUD operations:</p>";

$testUrls = [
    'Admin Dashboard' => '/admin',
    'News Management' => '/admin/news',
    'Add News' => '/admin/news/add',
    'Players Management' => '/admin/players',
    'Add Player' => '/admin/players/add',
    'Teams Management' => '/admin/teams',
    'Add Team' => '/admin/teams/add',
    'Matches Management' => '/admin/matches',
    'Add Match' => '/admin/matches/add',
    'Staff Management' => '/admin/staff',
    'Add Staff' => '/admin/staff/add',
    'Settings' => '/admin/settings'
];

foreach ($testUrls as $name => $url) {
    echo "<div class='url-test'>";
    echo "<strong>$name:</strong> ";
    echo "<a href='http://localhost:8090$url' target='_blank'>$url</a>";
    echo "</div>";
}

echo "</div>";

// Test 6: Session and Security
echo "<div class='test-section'>";
echo "<h2>🔒 Security Test</h2>";

if (isset($_SESSION['admin'])) {
    echo "<p class='success'>✅ Admin session active</p>";
    echo "<p class='info'>Session ID: " . $_SESSION['admin']['id'] . "</p>";
    echo "<p class='info'>Username: " . $_SESSION['admin']['username'] . "</p>";
} else {
    echo "<p class='error'>❌ No admin session</p>";
}

// Check upload directory
$uploadDir = '../public/uploads';
if (is_dir($uploadDir)) {
    echo "<p class='success'>✅ Upload directory exists</p>";
    if (is_writable($uploadDir)) {
        echo "<p class='success'>✅ Upload directory is writable</p>";
    } else {
        echo "<p class='warning'>⚠️ Upload directory is not writable</p>";
    }
} else {
    echo "<p class='error'>❌ Upload directory missing</p>";
}

echo "</div>";

// JavaScript for automatic testing
echo "<script>";
echo "console.log('Admin CRUD Debug loaded');";
echo "function testUrl(url) {";
echo "  window.open(url, '_blank');";
echo "}";
echo "</script>";

echo "<div class='test-section'>";
echo "<h2>🎯 Next Steps</h2>";
echo "<ol>";
echo "<li><strong>Click the URLs above</strong> to test each admin module</li>";
echo "<li><strong>Check for errors</strong> in browser console and network tab</li>";
echo "<li><strong>Test CRUD operations:</strong>";
echo "<ul>";
echo "<li>Create: Try adding new items</li>";
echo "<li>Read: Verify lists display correctly</li>";
echo "<li>Update: Edit existing items</li>";
echo "<li>Delete: Remove items (with confirmation)</li>";
echo "</ul>";
echo "</li>";
echo "<li><strong>Check database</strong> to confirm changes are saved</li>";
echo "</ol>";
echo "</div>";

echo "<div class='test-section'>";
echo "<h2>❗ Common Issues & Solutions</h2>";
echo "<div class='warning' style='padding:15px;background:#fff3cd;border:1px solid #ffeaa7;border-radius:4px;'>";
echo "<h4>If CRUD operations still don't work:</h4>";
echo "<ol>";
echo "<li><strong>Check routing:</strong> Verify App.php handleAdminRoute() method</li>";
echo "<li><strong>Check controllers:</strong> Ensure methods exist (index, add, edit, delete)</li>";
echo "<li><strong>Check database:</strong> Verify table structure and connections</li>";
echo "<li><strong>Check JavaScript:</strong> Look for AJAX errors in browser console</li>";
echo "<li><strong>Check PHP errors:</strong> Enable error reporting and check logs</li>";
echo "</ol>";
echo "</div>";
echo "</div>";

echo "</div>";
echo "</body></html>";
?>