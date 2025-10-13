<?php
/**
 * Admin Authentication Test
 */
session_start();

// Set admin session for testing
$_SESSION['admin_id'] = 1;
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_email'] = 'admin@test.com';

echo "<!DOCTYPE html>";
echo "<html><head><title>Admin Auth Test</title>";
echo "<style>body{font-family:Arial;margin:20px;background:#f5f5f5;} .container{max-width:800px;margin:0 auto;background:white;padding:30px;border-radius:8px;} .success{color:#28a745;} .error{color:#dc3545;} .info{color:#17a2b8;} .test-link{display:block;padding:10px;margin:5px 0;background:#e9ecef;text-decoration:none;color:#495057;border-radius:4px;} .test-link:hover{background:#dee2e6;}</style>";
echo "</head><body>";
echo "<div class='container'>";

echo "<h1>🔐 Admin Authentication Test</h1>";

echo "<h2>Session Status</h2>";
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    echo "<p class='success'>✅ Admin session is active</p>";
    echo "<p class='info'>Admin ID: " . ($_SESSION['admin_id'] ?? 'Not set') . "</p>";
    echo "<p class='info'>Admin Email: " . ($_SESSION['admin_email'] ?? 'Not set') . "</p>";
} else {
    echo "<p class='error'>❌ Admin session not found</p>";
}

echo "<h2>🧪 Test Admin Pages</h2>";
echo "<p class='info'>Click these links to test if admin authentication is working:</p>";

$adminPages = [
    'Dashboard' => '/admin',
    'News List' => '/admin/news',
    'Add News' => '/admin/news/create',
    'Players List' => '/admin/players',
    'Add Player' => '/admin/players/create',
    'Teams List' => '/admin/teams',
    'Add Team' => '/admin/teams/create',
    'Matches List' => '/admin/matches',
    'Staff List' => '/admin/staff',
    'Settings' => '/admin/settings'
];

foreach ($adminPages as $name => $url) {
    echo "<a href='http://localhost:8090$url' target='_blank' class='test-link'>🔗 $name</a>";
}

echo "<h2>📋 CRUD Operation Tests</h2>";
echo "<div style='background:#fff3cd;padding:15px;border-radius:4px;margin:20px 0;'>";
echo "<h4>How to test CRUD operations:</h4>";
echo "<ol>";
echo "<li><strong>Create (C):</strong> Click 'Add' buttons to create new items</li>";
echo "<li><strong>Read (R):</strong> Check if lists display properly</li>";
echo "<li><strong>Update (U):</strong> Click 'Edit' buttons to modify items</li>";
echo "<li><strong>Delete (D):</strong> Click 'Delete' buttons (should show confirmation)</li>";
echo "</ol>";
echo "</div>";

echo "<h2>🔍 Debug Information</h2>";
echo "<p class='info'>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p class='info'>Session ID: " . session_id() . "</p>";
echo "<p class='info'>PHP Version: " . phpversion() . "</p>";

if (function_exists('curl_version')) {
    echo "<p class='success'>✅ cURL is available</p>";
} else {
    echo "<p class='error'>❌ cURL is not available</p>";
}

echo "<hr>";
echo "<h3>🚀 Quick Actions</h3>";
echo "<p><a href='debug_admin.php' target='_blank'>📊 Full System Debug</a></p>";
echo "<p><a href='quick_test.php' target='_blank'>⚡ Quick CRUD Test</a></p>";
echo "<p><a href='http://localhost:8090/admin/login' target='_blank'>🔐 Admin Login Page</a></p>";

echo "</div>";
echo "</body></html>";
?>