<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">MAÇ SONUÇLARI</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/haberler" class="text-warning">Haberler</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Maç Sonuçları</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- News Categories -->
<section class="news-categories py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="categories-nav">
                    <a href="' . BASE_URL . '/haberler" class="btn btn-outline-primary">
                        Tüm Haberler
                    </a>
                    <a href="' . BASE_URL . '/haberler/category/haber" class="btn btn-outline-primary">
                        Genel Haberler
                    </a>
                    <a href="' . BASE_URL . '/haberler/category/duyuru" class="btn btn-outline-primary">
                        Duyurular
                    </a>
                    <a href="' . BASE_URL . '/haberler/category/mac_sonucu" class="btn btn-outline-primary active">
                        Maç Sonuçları
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Match Results Content -->
<section class="match-results-content py-5">
    <div class="container">
        <div class="row">
            
            <!-- Main Match Results List -->
            <div class="col-lg-8 mb-5">
                <div class="match-results-grid">
                    ' . (isset($matches) && !empty($matches) ? 
                        implode('', array_map(function($match) {
                            $matchDate = date('d F Y', strtotime($match['match_date']));
                            $matchTime = date('H:i', strtotime($match['match_date']));
                            $homeScore = $match['home_score'] ?? '-';
                            $awayScore = $match['away_score'] ?? '-';
                            
                            // Determine result type
                            $resultClass = '';
                            if ($homeScore !== '-' && $awayScore !== '-') {
                                if ($homeScore > $awayScore) {
                                    $resultClass = 'result-win';
                                } elseif ($homeScore < $awayScore) {
                                    $resultClass = 'result-loss';
                                } else {
                                    $resultClass = 'result-draw';
                                }
                            }
                            
                            return '
                            <div class="match-result-card mb-4 ' . $resultClass . '">
                                <div class="match-header">
                                    <div class="match-date-time">
                                        <i class="fas fa-calendar-alt"></i> ' . $matchDate . ' - ' . $matchTime . '
                                    </div>
                                    ' . (!empty($match['competition']) ? '<div class="match-competition"><i class="fas fa-trophy"></i> ' . htmlspecialchars($match['competition']) . '</div>' : '') . '
                                </div>
                                <div class="match-body">
                                    <div class="match-teams">
                                        <div class="team home-team">
                                            <div class="team-name">' . htmlspecialchars($match['home_team']) . '</div>
                                        </div>
                                        <div class="match-score">
                                            <div class="score-display">
                                                <span class="score-home">' . $homeScore . '</span>
                                                <span class="score-separator">-</span>
                                                <span class="score-away">' . $awayScore . '</span>
                                            </div>
                                            <div class="match-status">
                                                <span class="badge bg-success">MS</span>
                                            </div>
                                        </div>
                                        <div class="team away-team">
                                            <div class="team-name">' . htmlspecialchars($match['away_team']) . '</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="match-footer">
                                    <div class="match-venue">
                                        <i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($match['venue']) . '
                                    </div>
                                    ' . (!empty($match['attendance']) ? '<div class="match-attendance"><i class="fas fa-users"></i> ' . number_format($match['attendance']) . ' seyirci</div>' : '') . '
                                </div>
                            </div>';
                        }, $matches)) : 
                        '
                        <div class="col-12">
                            <div class="no-matches text-center py-5">
                                <i class="fas fa-futbol fa-3x text-muted mb-3"></i>
                                <h3>Henüz maç sonucu bulunmamaktadır</h3>
                                <p class="text-muted">Maç sonuçları burada görüntülenecektir.</p>
                                <a href="' . BASE_URL . '/haberler" class="btn btn-primary mt-3">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Tüm Haberlere Dön
                                </a>
                            </div>
                        </div>'
                    ) . '
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                
                <!-- Category Info -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">MAÇ İSTATİSTİKLERİ</h3>
                    <div class="category-info p-3 bg-light rounded">
                        <p class="mb-2">
                            <i class="fas fa-futbol text-primary me-2"></i>
                            <strong>Toplam Maç:</strong> ' . (isset($matches) ? count($matches) : 0) . '
                        </p>
                        <p class="mb-0 text-muted small">
                            Bu sezondaki tüm maç sonuçları.
                        </p>
                    </div>
                </div>

                <!-- Search Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">HABER ARAMA</h3>
                    <form action="' . BASE_URL . '/haberler/search" method="GET">
                        <div class="search-form">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" 
                                       placeholder="Haber ara..." value="' . ($_GET['q'] ?? '') . '">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Categories Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">KATEGORİLER</h3>
                    <div class="list-group">
                        <a href="' . BASE_URL . '/haberler" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Tüm Haberler
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="' . BASE_URL . '/haberler/category/haber" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Genel Haberler
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="' . BASE_URL . '/haberler/category/duyuru" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Duyurular
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="' . BASE_URL . '/haberler/category/mac_sonucu" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active">
                            Maç Sonuçları
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
.match-result-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    border-left: 4px solid #1e3a8a;
}

.match-result-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.match-result-card.result-win {
    border-left-color: #22c55e;
}

.match-result-card.result-loss {
    border-left-color: #ef4444;
}

.match-result-card.result-draw {
    border-left-color: #f59e0b;
}

.match-header {
    background: #f8f9fa;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e9ecef;
}

.match-date-time {
    font-size: 0.9rem;
    color: #666;
    font-weight: 600;
}

.match-date-time i {
    color: #1e3a8a;
    margin-right: 0.5rem;
}

.match-competition {
    font-size: 0.85rem;
    color: #1e3a8a;
    font-weight: 600;
}

.match-competition i {
    color: #fbbf24;
    margin-right: 0.5rem;
}

.match-body {
    padding: 2rem 1rem;
}

.match-teams {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.team {
    flex: 1;
    text-align: center;
}

.home-team {
    text-align: right;
}

.away-team {
    text-align: left;
}

.team-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e3a8a;
}

.match-score {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.score-display {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 2rem;
    font-weight: 700;
}

.score-home,
.score-away {
    color: #1e3a8a;
    min-width: 50px;
    text-align: center;
}

.score-separator {
    color: #cbd5e1;
}

.match-status .badge {
    font-size: 0.7rem;
}

.match-footer {
    background: #f8f9fa;
    padding: 0.75rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #e9ecef;
    font-size: 0.85rem;
    color: #666;
}

.match-venue i,
.match-attendance i {
    margin-right: 0.5rem;
    color: #1e3a8a;
}

@media (max-width: 768px) {
    .match-teams {
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .home-team,
    .away-team {
        text-align: center;
    }
    
    .match-footer {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>
