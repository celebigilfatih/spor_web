<?php
// Test the exact rendering logic from the view

$upcoming_matches = [
    [
        'home_team' => 'Fenerbahçe',
        'away_team' => 'Galatasaray',
        'match_date' => '2025-11-11 19:00:00',
        'venue' => 'Şükrü Saraçoğlu'
    ]
];

define('BASE_URL', '');

echo "<h1>Test View Rendering Logic</h1>";

echo "<h2>Test 1: isset and !empty</h2>";
echo "isset: " . (isset($upcoming_matches) ? 'true' : 'false') . "<br>";
echo "!empty: " . (!empty($upcoming_matches) ? 'true' : 'false') . "<br>";
echo "Combined: " . ((isset($upcoming_matches) && !empty($upcoming_matches)) ? 'true' : 'false') . "<br>";

echo "<h2>Test 2: array_map</h2>";
$result = implode('', array_map(function($match) {
    $months = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
    $matchDate = strtotime($match['match_date']);
    $day = date('d', $matchDate);
    $month = $months[date('n', $matchDate) - 1];
    $time = date('H:i', $matchDate);
    
    return '<div>Match: ' . htmlspecialchars($match['home_team']) . ' vs ' . htmlspecialchars($match['away_team']) . ' on ' . $day . ' ' . $month . ' at ' . $time . '</div>';
}, $upcoming_matches));

echo "Result:<br>";
echo $result;

echo "<h2>Test 3: Ternary operator</h2>";
$output = (isset($upcoming_matches) && !empty($upcoming_matches) ? 
    implode('', array_map(function($match) {
        return '<div>MATCH FOUND</div>';
    }, $upcoming_matches)) : 'EMPTY STATE');

echo "Output:<br>";
echo $output;
?>
