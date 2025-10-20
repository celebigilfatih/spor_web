<?php
// Test JUST the match rendering logic - simplest version

$upcoming_matches = [
    ['home_team' => 'Fenerbahçe', 'away_team' => 'Galatasaray', 'match_date' => '2025-11-11 19:00:00', 'venue' => 'Şükrü Saraçoğlu'],
    ['home_team' => 'Nilüferspor', 'away_team' => 'Yıldırımspor', 'match_date' => '2025-11-11 22:22:00', 'venue' => 'Nil\u00fcfer Stad\u0131'],
    ['home_team' => 'Özlüce', 'away_team' => 'Yeni Karaman', 'match_date' => '2025-11-21 21:00:00', 'venue' => '\u015e\u00fckr\u00fc Sara\u00e7o\u011flu']
];

$recent_results = [];

define('BASE_URL', 'http://localhost:8090');

$months = ['Ocak', '\u015eubat', 'Mart', 'Nisan', 'May\u0131s', 'Haziran', 'Temmuz', 'A\u011fustos', 'Eyl\u00fcl', 'Ekim', 'Kas\u0131m', 'Aral\u0131k'];

echo "<h1>Test Output</h1>";

echo '<div class="matches-horizontal-scroll">';

// Upcoming matches
if (isset($upcoming_matches) && !empty($upcoming_matches)) {
    foreach ($upcoming_matches as $match) {
        $matchDate = strtotime($match['match_date']);
        $day = date('d', $matchDate);
        $month = $months[date('n', $matchDate) - 1];
        $time = date('H:i', $matchDate);
        
        echo '<div class="match-card">';
        echo '<h3>' . htmlspecialchars($match['home_team']) . ' vs ' . htmlspecialchars($match['away_team']) . '</h3>';
        echo '<p>Date: ' . $day . ' ' . $month . ' at ' . $time . '</p>';
        echo '<p>Venue: ' . htmlspecialchars($match['venue']) . '</p>';
        echo '</div>';
    }
}

// Empty state
if ((!isset($upcoming_matches) || empty($upcoming_matches)) && (!isset($recent_results) || empty($recent_results))) {
    echo '<div class="empty">No matches</div>';
}

echo '</div>';

echo "<hr><p>Test completed successfully!</p>";
?>
