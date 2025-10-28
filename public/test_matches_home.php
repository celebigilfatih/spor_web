<?php
// Test matches display
define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/core/Database.php';
require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/app/models/MatchModel.php';

$matchModel = new MatchModel();

echo "<h2>Testing Match Data for Homepage</h2>";

echo "<h3>Upcoming Matches:</h3>";
$upcoming = $matchModel->getUpcomingMatches(5);
echo "<pre>";
print_r($upcoming);
echo "</pre>";

echo "<h3>Recent Results:</h3>";
$results = $matchModel->getResults(3);
echo "<pre>";
print_r($results);
echo "</pre>";

echo "<h3>Database NOW():</h3>";
$db = new Database();
$now = $db->query("SELECT NOW() as current_time");
echo "<pre>";
print_r($now);
echo "</pre>";
