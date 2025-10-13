<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">A TAKIMI</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">A Takımı</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Team Stats -->
<section class="team-stats-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-trophy text-warning"></i>
                    </div>
                    <h3 class="stat-number">15</h3>
                    <p class="stat-label">Şampiyonluk</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                    <h3 class="stat-number">25</h3>
                    <p class="stat-label">Oyuncu</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-futbol text-success"></i>
                    </div>
                    <h3 class="stat-number">45</h3>
                    <p class="stat-label">Gol</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-medal text-info"></i>
                    </div>
                    <h3 class="stat-number">85</h3>
                    <p class="stat-label">Yıllık Tecrübe</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Navigation -->
<section class="team-navigation py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="nav-card">
                    <div class="nav-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Kadro</h3>
                    <p>A Takımı oyuncularımızın detaylı bilgileri</p>
                    <a href="' . BASE_URL . '/ateam/squad" class="btn btn-primary">Kadroyu Gör</a>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="nav-card">
                    <div class="nav-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <h3>Maç Programı</h3>
                    <p>Yaklaşan maçlar ve geçmiş sonuçlar</p>
                    <a href="' . BASE_URL . '/ateam/fixtures" class="btn btn-primary">Programı Gör</a>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="nav-card">
                    <div class="nav-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>İstatistikler</h3>
                    <p>Takım ve oyuncu istatistikleri</p>
                    <a href="' . BASE_URL . '/ateam/stats" class="btn btn-primary">İstatistikleri Gör</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Matches -->
<section class="recent-matches py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">SON MAÇLAR</h2>
        <div class="row">
            ' . (isset($recent_matches) && !empty($recent_matches) ? 
                implode('', array_map(function($match) {
                    return '
                    <div class="col-lg-6 mb-4">
                        <div class="match-result-card">
                            <div class="match-date">' . date('d.m.Y', strtotime($match['match_date'] ?? 'now')) . '</div>
                            <div class="match-teams">
                                <div class="team home">
                                    <span class="team-name">' . htmlspecialchars($match['home_team'] ?? 'Ev Sahibi') . '</span>
                                </div>
                                <div class="match-score">
                                    <span class="score">' . ($match['home_score'] ?? '0') . ' - ' . ($match['away_score'] ?? '0') . '</span>
                                </div>
                                <div class="team away">
                                    <span class="team-name">' . htmlspecialchars($match['away_team'] ?? 'Deplasman') . '</span>
                                </div>
                            </div>
                            <div class="match-venue">
                                <i class="fas fa-map-marker-alt"></i>
                                ' . htmlspecialchars($match['venue'] ?? 'Stadyum') . '
                            </div>
                        </div>
                    </div>';
                }, $recent_matches)) : 
                '
                <div class="col-12">
                    <div class="text-center">
                        <p class="text-muted">Henüz maç sonucu bulunmamaktadır.</p>
                    </div>
                </div>'
            ) . '
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>