<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">MAÇ PROGRAMI</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/a-takimi" class="text-warning">A Takımı</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Maç Programı</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Fixtures Section -->
<section class="fixtures-section py-5">
    <div class="container">
        <div class="row">
            
            <!-- Upcoming Matches -->
            <div class="col-lg-6 mb-5">
                <h2 class="section-title mb-4">
                    <i class="fas fa-calendar-plus text-success"></i>
                    YAKLAŞAN MAÇLAR
                </h2>
                <div class="matches-list">
                    ' . (isset($upcoming_matches) && !empty($upcoming_matches) ? 
                        implode('', array_map(function($match) {
                            return '
                            <div class="fixture-card upcoming">
                                <div class="match-date">
                                    <div class="day">' . date('d', strtotime($match['match_date'] ?? 'now')) . '</div>
                                    <div class="month-year">
                                        ' . ['01' => 'OCA', '02' => 'ŞUB', '03' => 'MAR', '04' => 'NİS', 
                                             '05' => 'MAY', '06' => 'HAZ', '07' => 'TEM', '08' => 'AĞU', 
                                             '09' => 'EYL', '10' => 'EKİ', '11' => 'KAS', '12' => 'ARA'][date('m', strtotime($match['match_date'] ?? 'now'))] . '
                                        <br>' . date('Y', strtotime($match['match_date'] ?? 'now')) . '
                                    </div>
                                    <div class="time">' . date('H:i', strtotime($match['match_date'] ?? 'now')) . '</div>
                                </div>
                                <div class="match-info">
                                    <div class="competition-type mb-2">
                                        <i class="fas fa-trophy text-warning"></i>
                                        <strong>' . htmlspecialchars($match['match_type'] ?? 'Müsabaka') . (!empty($match['team_category']) ? ' - ' . $match['team_category'] : '') . '</strong>
                                    </div>
                                    <div class="teams">
                                        <div class="home-team">
                                            <span class="team-name">' . htmlspecialchars($match['home_team'] ?? 'Ev Sahibi') . '</span>
                                        </div>
                                        <div class="vs">VS</div>
                                        <div class="away-team">
                                            <span class="team-name">' . htmlspecialchars($match['away_team'] ?? 'Deplasman') . '</span>
                                        </div>
                                    </div>
                                    <div class="venue">
                                        <i class="fas fa-map-marker-alt"></i>
                                        ' . htmlspecialchars($match['venue'] ?? 'Stadyum') . '
                                    </div>
                                </div>
                                <div class="match-status">
                                    <span class="status-badge upcoming">YAKLAŞAN</span>
                                </div>
                            </div>';
                        }, $upcoming_matches)) : 
                        '<div class="text-center"><p class="text-muted">Yaklaşan maç bulunmamaktadır.</p></div>'
                    ) . '
                </div>
            </div>

            <!-- Recent Results -->
            <div class="col-lg-6 mb-5">
                <h2 class="section-title mb-4">
                    <i class="fas fa-calendar-check text-primary"></i>
                    SON SONUÇLAR
                </h2>
                <div class="matches-list">
                    ' . (isset($recent_results) && !empty($recent_results) ? 
                        implode('', array_map(function($result) {
                            return '
                            <div class="fixture-card finished">
                                <div class="match-date">
                                    <div class="day">' . date('d', strtotime($result['match_date'] ?? 'now')) . '</div>
                                    <div class="month-year">
                                        ' . ['01' => 'OCA', '02' => 'ŞUB', '03' => 'MAR', '04' => 'NİS', 
                                             '05' => 'MAY', '06' => 'HAZ', '07' => 'TEM', '08' => 'AĞU', 
                                             '09' => 'EYL', '10' => 'EKİ', '11' => 'KAS', '12' => 'ARA'][date('m', strtotime($result['match_date'] ?? 'now'))] . '
                                        <br>' . date('Y', strtotime($result['match_date'] ?? 'now')) . '
                                    </div>
                                    <div class="result">MS</div>
                                </div>
                                <div class="match-info">
                                    <div class="competition-type mb-2">
                                        <i class="fas fa-trophy text-primary"></i>
                                        <strong>' . htmlspecialchars($result['match_type'] ?? 'Müsabaka') . (!empty($result['team_category']) ? ' - ' . $result['team_category'] : '') . '</strong>
                                    </div>
                                    <div class="teams">
                                        <div class="home-team">
                                            <span class="team-name">' . htmlspecialchars($result['home_team'] ?? 'Ev') . '</span>
                                        </div>
                                        <div class="score">' . ($result['home_score'] ?? '0') . ' - ' . ($result['away_score'] ?? '0') . '</div>
                                        <div class="away-team">
                                            <span class="team-name">' . htmlspecialchars($result['away_team'] ?? 'Deplasman') . '</span>
                                        </div>
                                    </div>
                                    <div class="venue">
                                        <i class="fas fa-map-marker-alt"></i>
                                        ' . htmlspecialchars($result['venue'] ?? 'Stadyum') . '
                                    </div>
                                </div>
                                <div class="match-status">
                                    <span class="status-badge finished">BİTTİ</span>
                                </div>
                            </div>';
                        }, $recent_results)) : 
                        '<div class="text-center"><p class="text-muted">Son sonuç bulunmamaktadır.</p></div>'
                    ) . '
                </div>
            </div>

        </div>
    </div>
</section>

<!-- League Table -->
<section class="league-table-section py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">LİG DURUMU</h2>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="table-responsive">
                    <table class="table table-striped league-table">
                        <thead class="table-dark">
                            <tr>
                                <th>Sıra</th>
                                <th>Takım</th>
                                <th>O</th>
                                <th>G</th>
                                <th>B</th>
                                <th>M</th>
                                <th>A</th>
                                <th>Y</th>
                                <th>Av</th>
                                <th>P</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="our-team">
                                <td><strong>3</strong></td>
                                <td><strong>Spor Kulübü</strong></td>
                                <td>10</td>
                                <td>7</td>
                                <td>2</td>
                                <td>1</td>
                                <td>21</td>
                                <td>8</td>
                                <td>+13</td>
                                <td><strong>23</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">O: Oynanan, G: Galibiyet, B: Beraberlik, M: Mağlubiyet, A: Atılan, Y: Yenilen, Av: Averaj, P: Puan</small>
                </div>
            </div>
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>