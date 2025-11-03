<?php
// Test script to check youth players in database
require_once '../config/docker.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "<h2>Youth Players Database Check</h2>";
    
    // Check all players
    echo "<h3>All Players:</h3>";
    $stmt = $pdo->query("SELECT id, name, youth_group_id, team_id, status, created_at FROM players ORDER BY created_at DESC LIMIT 20");
    $allPlayers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($allPlayers);
    echo "</pre>";
    
    // Check youth players specifically
    echo "<h3>Youth Players (youth_group_id IS NOT NULL):</h3>";
    $stmt = $pdo->query("SELECT p.*, yg.name as group_name 
                         FROM players p 
                         LEFT JOIN youth_groups yg ON p.youth_group_id = yg.id
                         WHERE p.youth_group_id IS NOT NULL
                         ORDER BY p.created_at DESC");
    $youthPlayers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($youthPlayers);
    echo "</pre>";
    echo "<p><strong>Total youth players: " . count($youthPlayers) . "</strong></p>";
    
    // Check youth groups
    echo "<h3>Youth Groups:</h3>";
    $stmt = $pdo->query("SELECT * FROM youth_groups");
    $youthGroups = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($youthGroups);
    echo "</pre>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
