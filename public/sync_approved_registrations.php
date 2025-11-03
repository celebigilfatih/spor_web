<?php
/**
 * Sync script to create player records from all approved youth registrations
 * Run this once to sync existing approved registrations
 */

require_once '../config/docker.php';
require_once '../core/Database.php';
require_once '../core/Model.php';
require_once '../app/models/Player.php';
require_once '../app/models/YouthGroup.php';

echo "<h2>Sync Approved Registrations to Players</h2>";
echo "<hr>";

// Get all registration files
$registrationsDir = '../data/youth-registrations';
$files = glob($registrationsDir . '/*.json');

echo "<p>Found " . count($files) . " registration files</p>";

$playerModel = new Player();
$processed = 0;
$created = 0;
$skipped = 0;
$errors = 0;

foreach ($files as $file) {
    $data = json_decode(file_get_contents($file), true);
    if (!$data) {
        echo "<p style='color: orange;'>⚠ Could not parse: " . basename($file) . "</p>";
        continue;
    }
    
    $processed++;
    $registrationId = basename($file, '.json');
    $status = $data['status'] ?? 'pending';
    
    echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 10px 0;'>";
    echo "<strong>Registration: " . $registrationId . "</strong><br>";
    echo "Status: <span style='color: " . ($status === 'approved' ? 'green' : ($status === 'pending' ? 'orange' : 'red')) . "'>" . strtoupper($status) . "</span><br>";
    
    if ($status !== 'approved') {
        echo "<em>→ Skipped (not approved)</em>";
        echo "</div>";
        $skipped++;
        continue;
    }
    
    // Extract student info
    $studentName = '';
    if (isset($data['student']['name'])) {
        $studentName = $data['student']['name'];
    } elseif (isset($data['student']['first_name'])) {
        $studentName = $data['student']['first_name'] . ' ' . $data['student']['last_name'];
    } elseif (isset($data['student_name'])) {
        $studentName = $data['student_name'];
    }
    
    $birthDate = $data['student']['birth_date'] ?? $data['student_birth_date'] ?? null;
    $youthGroupId = $data['youth_group_id'] ?? null;
    $photoPath = !empty($data['photo_path']) ? basename($data['photo_path']) : null;
    
    echo "Student: " . htmlspecialchars($studentName) . "<br>";
    echo "Birth Date: " . ($birthDate ?? 'N/A') . "<br>";
    echo "Youth Group ID: " . ($youthGroupId ?? 'N/A') . "<br>";
    
    // Check if player already exists
    $existingPlayer = $playerModel->findBy('name', $studentName);
    $alreadyExists = false;
    
    if (!empty($existingPlayer)) {
        foreach ($existingPlayer as $player) {
            if ($player['birth_date'] === $birthDate && $player['youth_group_id'] == $youthGroupId) {
                $alreadyExists = true;
                echo "<span style='color: blue;'>→ Player already exists (ID: " . $player['id'] . ")</span>";
                $skipped++;
                break;
            }
        }
    }
    
    if ($alreadyExists) {
        echo "</div>";
        continue;
    }
    
    // Create player
    $playerData = [
        'name' => $studentName,
        'jersey_number' => null,
        'position' => 'Orta Saha',
        'team_id' => null,
        'youth_group_id' => $youthGroupId,
        'birth_date' => $birthDate,
        'nationality' => 'Türkiye',
        'photo' => $photoPath,
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    try {
        $playerId = $playerModel->create($playerData);
        if ($playerId) {
            echo "<span style='color: green;'>✓ Player created successfully! ID: " . $playerId . "</span>";
            $created++;
        } else {
            echo "<span style='color: red;'>✗ Failed to create player</span>";
            $error = $playerModel->getLastError();
            if ($error) {
                echo "<br><small>Error: " . htmlspecialchars($error) . "</small>";
            }
            $errors++;
        }
    } catch (Exception $e) {
        echo "<span style='color: red;'>✗ Exception: " . htmlspecialchars($e->getMessage()) . "</span>";
        $errors++;
    }
    
    echo "</div>";
}

echo "<hr>";
echo "<h3>Summary</h3>";
echo "<ul>";
echo "<li>Total registrations processed: <strong>" . $processed . "</strong></li>";
echo "<li>Players created: <strong style='color: green;'>" . $created . "</strong></li>";
echo "<li>Skipped (already exists or not approved): <strong style='color: blue;'>" . $skipped . "</strong></li>";
echo "<li>Errors: <strong style='color: red;'>" . $errors . "</strong></li>";
echo "</ul>";

echo "<p><a href='test_youth_players.php'>→ View Youth Players Database</a></p>";
echo "<p><a href='../admin/players/youth'>→ Go to Youth Players Admin Page</a></p>";
?>
