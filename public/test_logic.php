<?php
// Test the exact logic from the view

$upcoming_matches = [
    ['home_team' => 'Test1', 'away_team' => 'Test2', 'match_date' => '2025-11-11 19:00:00', 'venue' => 'Stadium'],
    ['home_team' => 'Test3', 'away_team' => 'Test4', 'match_date' => '2025-11-12 20:00:00', 'venue' => 'Arena'],
    ['home_team' => 'Test5', 'away_team' => 'Test6', 'match_date' => '2025-11-13 21:00:00', 'venue' => 'Field']
];

$recent_results = [];

echo "<h1>Logic Test</h1>";

echo "<h2>Conditions:</h2>";
echo "isset(\$upcoming_matches): " . (isset($upcoming_matches) ? 'true' : 'false') . "<br>";
echo "!empty(\$upcoming_matches): " . (!empty($upcoming_matches) ? 'true' : 'false') . "<br>";
echo "isset && !empty: " . ((isset($upcoming_matches) && !empty($upcoming_matches)) ? 'true' : 'false') . "<br>";

echo "<h2>Rendering Test:</h2>";

$output = (
    // Upcoming Matches
    (isset($upcoming_matches) && !empty($upcoming_matches) ? 
        implode('', array_map(function($match) {
            return '<div class="match-card">MATCH: ' . $match['home_team'] . ' vs ' . $match['away_team'] . '</div>';
        }, $upcoming_matches)) : '') .
    
    // Recent Results  
    (isset($recent_results) && !empty($recent_results) ? 
        implode('', array_map(function($match) {
            return '<div class="result-card">RESULT</div>';
        }, $recent_results)) : '') .
    
    // Empty state
    ((!isset($upcoming_matches) || empty($upcoming_matches)) && (!isset($recent_results) || empty($recent_results)) ? '
    <div class="empty">NO MATCHES</div>' : '')
);

echo "Output:<br>";
echo "<pre>" . htmlspecialchars($output) . "</pre>";
echo "<hr>";
echo "Rendered:<br>";
echo $output;
?>
