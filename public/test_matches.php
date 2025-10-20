<?php
/**
 * Test script to verify matches are loading
 */

// Load configuration
require_once __DIR__ . '/../config/docker.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../app/models/MatchModel.php';

echo "<h1>Match Model Test</h1>";

try {
    $matchModel = new MatchModel();
    
    echo "<h2>Upcoming Matches (getUpcomingMatches):</h2>";
    $upcoming = $matchModel->getUpcomingMatches(5);
    echo "<pre>";
    print_r($upcoming);
    echo "</pre>";
    echo "<p><strong>Count: " . count($upcoming) . "</strong></p>";
    
    echo "<hr>";
    
    echo "<h2>Finished Matches (getResults):</h2>";
    $results = $matchModel->getResults(5);
    echo "<pre>";
    print_r($results);
    echo "</pre>";
    echo "<p><strong>Count: " . count($results) . "</strong></p>";
    
    echo "<hr>";
    
    echo "<h2>All Matches (getAllMatches):</h2>";
    $all = $matchModel->getAllMatches();
    echo "<pre>";
    print_r($all);
    echo "</pre>";
    echo "<p><strong>Count: " . count($all) . "</strong></p>";
    
} catch (Exception $e) {
    echo "<div style='color: red; padding: 20px; border: 2px solid red;'>";
    echo "<h2>Error:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}

echo "<hr>";
echo "<p><a href='/'>Go to Homepage</a> | <a href='/admin/matches'>Go to Admin Matches</a></p>";
?>
