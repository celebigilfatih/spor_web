<?php
// Matches Table Diagnostic Script
// Access via: http://localhost:8090/check_matches_table.php

// Load configuration (Docker environment)
if (getenv('DB_HOST') || isset($_ENV['DB_HOST'])) {
    require_once __DIR__ . '/../config/docker.php';
} else {
    require_once __DIR__ . '/../config/database.php';
}

// Define constants if not already defined
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require_once BASE_PATH . '/core/Database.php';

$db = new Database();

echo "<h1>Matches Table Diagnostic</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; width: 100%; margin: 20px 0; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #4CAF50; color: white; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    pre { background: #f4f4f4; padding: 10px; border-radius: 4px; }
</style>";

// Check if table exists
echo "<h2>1. Table Existence Check</h2>";
$tableCheck = $db->query("SHOW TABLES LIKE 'matches'");
if ($tableCheck && count($tableCheck) > 0) {
    echo "<p class='success'>✓ Table 'matches' exists</p>";
} else {
    echo "<p class='error'>✗ Table 'matches' does NOT exist!</p>";
    echo "<p>Run this SQL to create it:</p>";
    echo "<pre>CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT NULL,
    home_team VARCHAR(255) NOT NULL,
    away_team VARCHAR(255) NOT NULL,
    match_date DATETIME NOT NULL,
    venue VARCHAR(255) NULL,
    competition VARCHAR(100) NULL,
    home_score INT NULL,
    away_score INT NULL,
    status ENUM('scheduled','finished','postponed','cancelled') DEFAULT 'scheduled',
    season VARCHAR(20) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);</pre>";
    exit;
}

// Get table structure
echo "<h2>2. Table Structure</h2>";
$columns = $db->query("DESCRIBE matches");

echo "<table>";
echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
foreach ($columns as $col) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($col['Field']) . "</td>";
    echo "<td>" . htmlspecialchars($col['Type']) . "</td>";
    echo "<td>" . htmlspecialchars($col['Null']) . "</td>";
    echo "<td>" . htmlspecialchars($col['Key']) . "</td>";
    echo "<td>" . htmlspecialchars($col['Default'] ?? 'NULL') . "</td>";
    echo "<td>" . htmlspecialchars($col['Extra']) . "</td>";
    echo "</tr>";
}
echo "</table>";

// Check for required columns
echo "<h2>3. Required Columns Check</h2>";
$requiredColumns = [
    'id' => 'Primary key',
    'home_team' => 'Home team name',
    'away_team' => 'Away team name',
    'match_date' => 'Match date and time',
    'status' => 'Match status',
    'created_at' => 'Creation timestamp',
    'updated_at' => 'Update timestamp'
];

$existingColumns = array_column($columns, 'Field');
$missingColumns = [];

foreach ($requiredColumns as $col => $desc) {
    if (in_array($col, $existingColumns)) {
        echo "<p class='success'>✓ $col - $desc</p>";
    } else {
        echo "<p class='error'>✗ $col - $desc (MISSING!)</p>";
        $missingColumns[] = $col;
    }
}

// Show optional columns status
echo "<h2>4. Optional Columns</h2>";
$optionalColumns = ['team_id', 'venue', 'competition', 'home_score', 'away_score', 'season'];
foreach ($optionalColumns as $col) {
    if (in_array($col, $existingColumns)) {
        echo "<p class='success'>✓ $col (present)</p>";
    } else {
        echo "<p class='warning'>⚠ $col (missing - optional)</p>";
    }
}

// Test insert capability
echo "<h2>5. Insert Test</h2>";
$testData = [
    'home_team' => 'Test Home Team',
    'away_team' => 'Test Away Team',
    'match_date' => date('Y-m-d H:i:s', strtotime('+1 day')),
    'venue' => 'Test Stadium',
    'competition' => 'Test League',
    'status' => 'scheduled',
    'created_at' => date('Y-m-d H:i:s')
];

// Build insert query
$columns_str = implode(', ', array_keys($testData));
$placeholders = ':' . implode(', :', array_keys($testData));
$sql = "INSERT INTO matches ($columns_str) VALUES ($placeholders)";

echo "<p><strong>Test SQL:</strong></p>";
echo "<pre>" . htmlspecialchars($sql) . "</pre>";

echo "<p><strong>Test Data:</strong></p>";
echo "<pre>" . htmlspecialchars(print_r($testData, true)) . "</pre>";

$result = $db->execute($sql, $testData);

if ($result) {
    $insertId = $result;
    echo "<p class='success'>✓ Test insert successful! Inserted ID: $insertId</p>";
    
    // Clean up test data
    $db->execute("DELETE FROM matches WHERE id = :id", ['id' => $insertId]);
    echo "<p class='success'>✓ Test data cleaned up</p>";
} else {
    $error = $db->getLastError();
    echo "<p class='error'>✗ Test insert failed!</p>";
    echo "<p class='error'>Error: " . htmlspecialchars($error) . "</p>";
}

// Show recent matches
echo "<h2>6. Recent Matches (Last 5)</h2>";
$matches = $db->query("SELECT * FROM matches ORDER BY created_at DESC LIMIT 5");
if ($matches && count($matches) > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Home Team</th><th>Away Team</th><th>Match Date</th><th>Status</th><th>Created</th></tr>";
    foreach ($matches as $match) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($match['id']) . "</td>";
        echo "<td>" . htmlspecialchars($match['home_team']) . "</td>";
        echo "<td>" . htmlspecialchars($match['away_team']) . "</td>";
        echo "<td>" . htmlspecialchars($match['match_date']) . "</td>";
        echo "<td>" . htmlspecialchars($match['status']) . "</td>";
        echo "<td>" . htmlspecialchars($match['created_at'] ?? 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>No matches in database yet</p>";
}

// Recommendations
echo "<h2>7. Recommendations</h2>";
if (!empty($missingColumns)) {
    echo "<p class='error'><strong>ACTION REQUIRED:</strong> Add missing columns</p>";
    echo "<p>Run this SQL to add missing columns:</p>";
    echo "<pre>";
    foreach ($missingColumns as $col) {
        switch($col) {
            case 'created_at':
                echo "ALTER TABLE matches ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;\n";
                break;
            case 'updated_at':
                echo "ALTER TABLE matches ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;\n";
                break;
        }
    }
    echo "</pre>";
} else {
    echo "<p class='success'>✓ All required columns present!</p>";
    echo "<p>The matches table is properly configured.</p>";
}

echo "<hr>";
echo "<p><em>Diagnostic completed at " . date('Y-m-d H:i:s') . "</em></p>";
echo "<p><a href='admin/matches'>Go to Admin Matches</a></p>";
?>
