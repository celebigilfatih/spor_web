<?php
/**
 * Teams Debug Tool
 * Check teams table structure and data
 */
require_once '../config/database.php';
require_once '../core/Database.php';

echo "<!DOCTYPE html>";
echo "<html><head><title>Teams Debug</title>";
echo "<style>body{font-family:Arial;margin:20px;background:#1e3c72;color:white;} .container{max-width:1000px;margin:0 auto;background:#2a5298;padding:30px;border-radius:8px;} .success{color:#90EE90;} .error{color:#FFB6C1;} .info{color:#87CEEB;} .warning{color:#FFD700;} table{width:100%;border-collapse:collapse;margin:20px 0;} th,td{padding:10px;border:1px solid #444;text-align:left;} th{background:#1e3c72;} .field-info{background:#0d1b2a;padding:15px;margin:10px 0;border-radius:4px;}</style>";
echo "</head><body>";
echo "<div class='container'>";

echo "<h1>🔧 Teams Table Debug Tool</h1>";

try {
    $database = new Database();
    echo "<p class='success'>✅ Database connection successful</p>";
    
    // Check table structure
    echo "<h2>📋 Teams Table Structure</h2>";
    $columns = $database->query("DESCRIBE teams");
    
    if ($columns) {
        echo "<table>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td><strong>" . $column['Field'] . "</strong></td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . $column['Key'] . "</td>";
            echo "<td>" . ($column['Default'] ?? 'NULL') . "</td>";
            echo "<td>" . $column['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='error'>❌ Could not get table structure</p>";
    }
    
    // Check existing data
    echo "<h2>📊 Existing Teams Data</h2>";
    $teams = $database->query("SELECT * FROM teams LIMIT 5");
    
    if ($teams && !empty($teams)) {
        echo "<table>";
        $firstTeam = $teams[0];
        echo "<tr>";
        foreach (array_keys($firstTeam) as $field) {
            echo "<th>" . $field . "</th>";
        }
        echo "</tr>";
        
        foreach ($teams as $team) {
            echo "<tr>";
            foreach ($team as $value) {
                echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='warning'>⚠️ No teams found in database</p>";
    }
    
    // Field mapping analysis
    echo "<h2>🔍 Field Mapping Analysis</h2>";
    
    $expectedFields = ['name', 'team_type', 'category', 'coach_id', 'coach_name', 'description', 'status', 'sort_order'];
    $actualFields = array_column($columns, 'Field');
    
    foreach ($expectedFields as $field) {
        echo "<div class='field-info'>";
        if (in_array($field, $actualFields)) {
            echo "<p class='success'>✅ <strong>$field</strong> - Field exists</p>";
        } else {
            echo "<p class='error'>❌ <strong>$field</strong> - Field missing</p>";
            if ($field === 'coach_name') {
                echo "<p class='info'>💡 Run the update SQL script to add this field</p>";
            }
            if ($field === 'sort_order') {
                echo "<p class='info'>💡 Run the update SQL script to add this field</p>";
            }
        }
        echo "</div>";
    }
    
    echo "<h2>🛠️ Solutions</h2>";
    echo "<div style='background:#0d1b2a;padding:20px;border-radius:8px;'>";
    echo "<h3>To fix the undefined 'category' warnings:</h3>";
    echo "<ol>";
    echo "<li><strong>Database fields are mapped correctly</strong> - team_type is used for age groups</li>";
    echo "<li><strong>View fixed</strong> - Now checks both team_type and category fields</li>";
    echo "<li><strong>Controller updated</strong> - Maps form 'category' to database 'team_type'</li>";
    echo "</ol>";
    
    if (!in_array('coach_name', $actualFields)) {
        echo "<h3>To add missing coach_name field:</h3>";
        echo "<p class='warning'>Run the SQL update script:</p>";
        echo "<p><code>mysql -u root -p spor_kulubu < database/update_teams_table.sql</code></p>";
    }
    echo "</div>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>🧪 Test Links</h2>";
echo "<p><a href='http://localhost:8090/admin/teams' target='_blank' style='color:#FFD700;'>Admin Teams List</a></p>";
echo "<p><a href='http://localhost:8090/admin/teams/edit/1' target='_blank' style='color:#FFD700;'>Edit Team #1</a></p>";
echo "<p><a href='debug_admin.php' target='_blank' style='color:#87CEEB;'>Full Admin Debug</a></p>";

echo "</div>";
echo "</body></html>";
?>