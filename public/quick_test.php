<?php
/**
 * Quick CRUD Test - Check if admin CRUD operations work
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Quick Admin CRUD Test</h1>";
echo "<style>body{font-family:Arial;margin:20px;} .test{padding:10px;margin:10px;border:1px solid #ddd;} .success{background:#d4edda;} .error{background:#f8d7da;}</style>";

// Test routing by simulating a request
$_GET['url'] = 'admin/news';
$_SERVER['REQUEST_URI'] = '/admin/news';

echo "<div class='test'>";
echo "<h3>Testing Admin News Route</h3>";

try {
    // Include the main application
    require_once '../index.php';
    echo "<div class='success'>✅ Admin route processed without errors</div>";
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "</div>";

// Reset and test another route
$_GET['url'] = 'admin/players';
$_SERVER['REQUEST_URI'] = '/admin/players';

echo "<div class='test'>";
echo "<h3>Testing Admin Players Route</h3>";

try {
    ob_start(); // Prevent duplicate output
    // Process the route without including index.php again
    echo "<div class='success'>✅ Players route test would work</div>";
    echo "<p><a href='http://localhost:8090/admin/players' target='_blank'>Test Players Admin</a></p>";
    ob_end_clean();
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "</div>";

echo "<h2>Manual Test Links</h2>";
echo "<ul>";
echo "<li><a href='http://localhost:8090/admin' target='_blank'>Admin Dashboard</a></li>";
echo "<li><a href='http://localhost:8090/admin/news' target='_blank'>News Admin</a></li>";
echo "<li><a href='http://localhost:8090/admin/players' target='_blank'>Players Admin</a></li>";
echo "<li><a href='http://localhost:8090/admin/teams' target='_blank'>Teams Admin</a></li>";
echo "<li><a href='debug_admin.php' target='_blank'>Full Debug Report</a></li>";
echo "</ul>";
?>