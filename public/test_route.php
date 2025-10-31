<?php
// Simple test script to check routing
require_once '../config/docker.php';
require_once '../core/Database.php';
require_once '../core/Model.php';
require_once '../core/Controller.php';
require_once '../app/models/Player.php';
require_once '../app/models/YouthGroup.php';
require_once '../app/controllers/AdminPlayers.php';

echo "Testing AdminPlayers controller...\n";

// Create instances
$controller = new AdminPlayers();

echo "Controller created\n";

// Test if the youth method exists
if (method_exists($controller, 'youth')) {
    echo "Youth method exists\n";
} else {
    echo "Youth method does not exist\n";
}

// Test the getYouthPlayers method directly
require_once '../app/models/Player.php';
$playerModel = new Player();
$players = $playerModel->getYouthPlayers();

echo "Players count: " . (is_array($players) ? count($players) : 'not an array') . "\n";

// Test the getActive method directly
require_once '../app/models/YouthGroup.php';
$youthGroupModel = new YouthGroup();
$youthGroups = $youthGroupModel->getActive();

echo "Youth groups count: " . (is_array($youthGroups) ? count($youthGroups) : 'not an array') . "\n";
?>