<?php
/**
 * Add photo column to youth_groups table
 */

require_once '../config/docker.php';

// Define BASE_URL if not already defined
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost:8090');
}

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "<h2>Adding photo column to youth_groups table</h2>";
    
    // Check if column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM youth_groups LIKE 'photo'");
    $exists = $stmt->fetch();
    
    if (!$exists) {
        $pdo->exec("ALTER TABLE youth_groups ADD COLUMN photo VARCHAR(255) DEFAULT NULL AFTER description");
        echo "<p style='color: green;'>✓ Photo column added successfully!</p>";
    } else {
        echo "<p style='color: blue;'>ℹ Photo column already exists.</p>";
    }
    
    echo "<p><a href='" . BASE_URL . "/admin/youth-groups'>→ Go to Youth Groups</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
