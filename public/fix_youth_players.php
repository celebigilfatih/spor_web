<?php
/**
 * Fix youth players who were created without youth_group_id
 */

require_once '../config/docker.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "<h2>Fix Youth Players</h2>";
    echo "<hr>";
    
    // Find players without youth_group_id and without team_id (not A Takım players)
    $stmt = $pdo->query("
        SELECT id, name, birth_date, youth_group_id, team_id 
        FROM players 
        WHERE youth_group_id IS NULL AND team_id IS NULL
        ORDER BY created_at DESC
    ");
    $playersToFix = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>Found " . count($playersToFix) . " players without youth_group_id:</p>";
    
    if (empty($playersToFix)) {
        echo "<p style='color: green;'>✓ No players need fixing!</p>";
    } else {
        echo "<form method='POST'>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Birth Date</th><th>Assign Youth Group</th></tr>";
        
        // Get youth groups for dropdown
        $groupsStmt = $pdo->query("SELECT id, name, age_group FROM youth_groups WHERE status = 'active' ORDER BY age_group");
        $youthGroups = $groupsStmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($playersToFix as $player) {
            echo "<tr>";
            echo "<td>" . $player['id'] . "</td>";
            echo "<td><strong>" . htmlspecialchars($player['name']) . "</strong></td>";
            echo "<td>" . $player['birth_date'] . "</td>";
            echo "<td>";
            echo "<select name='youth_group[" . $player['id'] . "]' required>";
            echo "<option value=''>-- Select Youth Group --</option>";
            foreach ($youthGroups as $group) {
                echo "<option value='" . $group['id'] . "'>" . htmlspecialchars($group['name']) . " (" . $group['age_group'] . ")</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        echo "<br>";
        echo "<button type='submit' name='fix' style='padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer; font-size: 16px;'>✓ Assign Youth Groups</button>";
        echo "</form>";
    }
    
    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fix'])) {
        echo "<hr><h3>Processing Updates...</h3>";
        
        $updated = 0;
        foreach ($_POST['youth_group'] as $playerId => $youthGroupId) {
            if (!empty($youthGroupId)) {
                $stmt = $pdo->prepare("UPDATE players SET youth_group_id = :youth_group_id WHERE id = :id");
                $stmt->execute([
                    'youth_group_id' => $youthGroupId,
                    'id' => $playerId
                ]);
                
                $playerName = '';
                foreach ($playersToFix as $p) {
                    if ($p['id'] == $playerId) {
                        $playerName = $p['name'];
                        break;
                    }
                }
                
                echo "<p style='color: green;'>✓ Updated player ID $playerId ($playerName) with youth_group_id = $youthGroupId</p>";
                $updated++;
            }
        }
        
        echo "<hr>";
        echo "<h3 style='color: green;'>✓ Success! Updated $updated player(s)</h3>";
        echo "<p><a href='../admin/players/youth' style='padding: 10px 20px; background: #2196F3; color: white; text-decoration: none; display: inline-block; margin-top: 10px;'>→ View Youth Players List</a></p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
