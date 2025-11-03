<?php
// Test script to manually create player from approved registration
require_once '../config/docker.php';

// Include necessary files
require_once '../core/Database.php';
require_once '../core/Model.php';
require_once '../app/models/Player.php';

echo "<h2>Manual Player Creation from Registration</h2>";

// Read the approved registration
$registrationFile = '../data/youth-registrations/reg_68ef98b201806.json';
if (!file_exists($registrationFile)) {
    die("Registration file not found!");
}

$registration = json_decode(file_get_contents($registrationFile), true);
echo "<h3>Registration Data:</h3>";
echo "<pre>";
print_r($registration);
echo "</pre>";

// Extract data
$studentName = $registration['student']['name'] ?? '';
$birthDate = $registration['student']['birth_date'] ?? null;
$youthGroupId = $registration['youth_group_id'] ?? null;
$photoPath = !empty($registration['photo_path']) ? basename($registration['photo_path']) : null;

echo "<h3>Extracted Data:</h3>";
echo "Name: " . $studentName . "<br>";
echo "Birth Date: " . $birthDate . "<br>";
echo "Youth Group ID: " . $youthGroupId . "<br>";
echo "Photo: " . ($photoPath ?: 'None') . "<br>";

// Create player
$playerModel = new Player();

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

echo "<h3>Player Data to Insert:</h3>";
echo "<pre>";
print_r($playerData);
echo "</pre>";

try {
    $playerId = $playerModel->create($playerData);
    if ($playerId) {
        echo "<h3 style='color: green;'>✓ Player created successfully! ID: " . $playerId . "</h3>";
    } else {
        echo "<h3 style='color: red;'>✗ Failed to create player</h3>";
        $error = $playerModel->getLastError();
        if ($error) {
            echo "<p>Error: " . $error . "</p>";
        }
    }
} catch (Exception $e) {
    echo "<h3 style='color: red;'>✗ Exception: " . $e->getMessage() . "</h3>";
}

echo "<hr>";
echo "<a href='test_youth_players.php'>Check Youth Players Database</a>";
?>
