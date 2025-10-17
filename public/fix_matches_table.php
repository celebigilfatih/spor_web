<?php
// Fix Matches Table - Add Missing Columns
// Run this once to add missing columns to the matches table
// Access via: http://localhost:8090/fix_matches_table.php

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

echo "<h1>Matches Table Fix - Add Missing Columns</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    .container { max-width: 1200px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    h1 { color: #333; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
    h2 { color: #555; margin-top: 30px; }
    .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin: 10px 0; border-left: 4px solid #28a745; }
    .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin: 10px 0; border-left: 4px solid #dc3545; }
    .warning { background: #fff3cd; color: #856404; padding: 10px; border-radius: 4px; margin: 10px 0; border-left: 4px solid #ffc107; }
    .info { background: #d1ecf1; color: #0c5460; padding: 10px; border-radius: 4px; margin: 10px 0; border-left: 4px solid #17a2b8; }
    table { border-collapse: collapse; width: 100%; margin: 20px 0; }
    th, td { border: 1px solid #ddd; padding: 12px 8px; text-align: left; }
    th { background-color: #4CAF50; color: white; font-weight: bold; }
    tr:nth-child(even) { background-color: #f9f9f9; }
    pre { background: #f4f4f4; padding: 15px; border-radius: 4px; overflow-x: auto; border: 1px solid #ddd; }
    .btn { display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 4px; margin: 10px 5px 10px 0; }
    .btn:hover { background: #45a049; }
    .step { background: #e8f5e9; padding: 15px; margin: 15px 0; border-radius: 4px; border-left: 4px solid #4CAF50; }
</style>";

echo "<div class='container'>";

// Step 1: Check current table structure
echo "<div class='step'>";
echo "<h2>Step 1: Current Table Structure</h2>";
$currentColumns = $db->query("DESCRIBE matches");

if ($currentColumns) {
    echo "<table>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    
    $existingCols = [];
    foreach ($currentColumns as $col) {
        $existingCols[] = $col['Field'];
        echo "<tr>";
        echo "<td><strong>" . htmlspecialchars($col['Field']) . "</strong></td>";
        echo "<td>" . htmlspecialchars($col['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Key']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Default'] ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<div class='error'>❌ Could not read matches table structure!</div>";
    exit;
}
echo "</div>";

// Step 2: Check which columns are missing
echo "<div class='step'>";
echo "<h2>Step 2: Check Missing Columns</h2>";

$requiredColumns = [
    'competition' => [
        'type' => 'VARCHAR(100)',
        'null' => 'YES',
        'default' => 'NULL',
        'comment' => 'Competition type (Liga, Kupa, etc.)',
        'after' => 'venue'
    ],
    'season' => [
        'type' => 'VARCHAR(20)',
        'null' => 'YES',
        'default' => 'NULL',
        'comment' => 'Season (e.g., 2024-2025)',
        'after' => 'status'
    ],
    'created_at' => [
        'type' => 'TIMESTAMP',
        'null' => 'YES',
        'default' => 'CURRENT_TIMESTAMP',
        'comment' => 'Record creation time',
        'after' => 'season'
    ],
    'updated_at' => [
        'type' => 'TIMESTAMP',
        'null' => 'YES',
        'default' => 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        'comment' => 'Record update time',
        'after' => 'created_at'
    ]
];

$missingColumns = [];
foreach ($requiredColumns as $col => $info) {
    if (!in_array($col, $existingCols)) {
        $missingColumns[$col] = $info;
        echo "<div class='warning'>⚠️ Column <strong>$col</strong> is missing - {$info['comment']}</div>";
    } else {
        echo "<div class='success'>✅ Column <strong>$col</strong> exists</div>";
    }
}

if (empty($missingColumns)) {
    echo "<div class='success'><strong>✅ All required columns exist! No changes needed.</strong></div>";
    echo "<p><a href='admin/matches/create' class='btn'>Go to Create Match</a></p>";
    echo "</div></div>";
    exit;
}
echo "</div>";

// Step 3: Add missing columns
echo "<div class='step'>";
echo "<h2>Step 3: Adding Missing Columns</h2>";

$errors = [];
$success = [];

foreach ($missingColumns as $colName => $colInfo) {
    $sql = "ALTER TABLE matches ADD COLUMN $colName {$colInfo['type']} ";
    
    if ($colInfo['null'] === 'YES') {
        $sql .= "NULL ";
    } else {
        $sql .= "NOT NULL ";
    }
    
    if ($colInfo['default'] !== 'NULL') {
        $sql .= "DEFAULT {$colInfo['default']} ";
    }
    
    if (!empty($colInfo['comment'])) {
        $sql .= "COMMENT '{$colInfo['comment']}' ";
    }
    
    if (!empty($colInfo['after'])) {
        $sql .= "AFTER {$colInfo['after']}";
    }
    
    echo "<div class='info'><strong>Executing:</strong><br><pre>" . htmlspecialchars($sql) . "</pre></div>";
    
    $result = $db->execute($sql);
    
    if ($result !== false) {
        $success[] = $colName;
        echo "<div class='success'>✅ Successfully added column: <strong>$colName</strong></div>";
    } else {
        $error = $db->getLastError();
        $errors[] = $colName . ': ' . $error;
        echo "<div class='error'>❌ Failed to add column: <strong>$colName</strong><br>Error: " . htmlspecialchars($error) . "</div>";
    }
}
echo "</div>";

// Step 4: Verify final structure
echo "<div class='step'>";
echo "<h2>Step 4: Final Table Structure</h2>";
$finalColumns = $db->query("DESCRIBE matches");

if ($finalColumns) {
    echo "<table>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    foreach ($finalColumns as $col) {
        $isNew = in_array($col['Field'], $success);
        echo "<tr" . ($isNew ? " style='background: #d4edda;'" : "") . ">";
        echo "<td><strong>" . htmlspecialchars($col['Field']) . "</strong>" . ($isNew ? " <span style='color: green;'>NEW</span>" : "") . "</td>";
        echo "<td>" . htmlspecialchars($col['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Key']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Default'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($col['Extra']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
echo "</div>";

// Summary
echo "<div class='step'>";
echo "<h2>Summary</h2>";

if (!empty($success)) {
    echo "<div class='success'>";
    echo "<strong>✅ Successfully added " . count($success) . " column(s):</strong><br>";
    echo "<ul>";
    foreach ($success as $col) {
        echo "<li>$col</li>";
    }
    echo "</ul>";
    echo "</div>";
}

if (!empty($errors)) {
    echo "<div class='error'>";
    echo "<strong>❌ Failed to add " . count($errors) . " column(s):</strong><br>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo "</div>";
}

if (empty($errors)) {
    echo "<div class='success'>";
    echo "<h3>🎉 Table Fix Complete!</h3>";
    echo "<p>All required columns have been added successfully. You can now create matches without errors.</p>";
    echo "<p><a href='admin/matches/create' class='btn'>Go to Create Match</a> <a href='admin/matches' class='btn'>View All Matches</a></p>";
    echo "</div>";
} else {
    echo "<div class='warning'>";
    echo "<p>Some columns could not be added. Please check the errors above and try again, or add them manually via SQL.</p>";
    echo "</div>";
}
echo "</div>";

echo "</div>";

echo "<hr>";
echo "<p><em>Fix completed at " . date('Y-m-d H:i:s') . "</em></p>";
?>
