<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">' . htmlspecialchars($player['name'] ?? 'Oyuncu Detayları') . '</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/ateam" class="text-warning">A Takımı</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/ateam/squad" class="text-warning">Kadro</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">' . htmlspecialchars($player['name'] ?? 'Oyuncu') . '</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Player Profile -->
<section class="player-profile py-5">
    <div class="container">
        <div class="row">
            
            <!-- Player Photo and Basic Info -->
            <div class="col-lg-4 mb-5">
                <div class="player-profile-card">
                    <div class="player-photo-large">
                        <img src="' . BASE_URL . '/public/uploads/' . ($player['photo'] ?? 'default-player.jpg') . '" 
                             alt="' . htmlspecialchars($player['name'] ?? '') . '" class="img-fluid">
                        <div class="jersey-number-large">' . ($player['jersey_number'] ?? 'N/A') . '</div>
                    </div>
                    
                    <div class="player-basic-info">
                        <h2 class="player-name-large">' . htmlspecialchars($player['name'] ?? '') . '</h2>
                        <p class="player-position-large">' . htmlspecialchars($player['position'] ?? '') . '</p>
                        
                        <div class="player-details-grid">
                            <div class="detail-row">
                                <span class="detail-label">Yaş:</span>
                                <span class="detail-value">' . ($player['age'] ?? 'N/A') . '</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Kulübe Katılış:</span>
                                <span class="detail-value">' . ($player['join_date'] ?? '2024') . '</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Dominant Ayak:</span>
                                <span class="detail-value">' . ($player['foot'] ?? 'Sağ') . '</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Player Stats and Performance -->
            <div class="col-lg-8">
                
                <!-- Season Stats -->
                <div class="stats-section mb-5">
                    <h3 class="section-subtitle">2024-25 SEZON İSTATİSTİKLERİ</h3>
                    
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-box">
                                <div class="stat-number">' . ($stats['matches'] ?? '15') . '</div>
                                <div class="stat-label">Maç</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-box">
                                <div class="stat-number">' . ($stats['goals'] ?? '8') . '</div>
                                <div class="stat-label">Gol</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-box">
                                <div class="stat-number">' . ($stats['assists'] ?? '5') . '</div>
                                <div class="stat-label">Asist</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-box">
                                <div class="stat-number">' . ($stats['yellow_cards'] ?? '2') . '</div>
                                <div class="stat-label">Sarı Kart</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Chart -->
                <div class="performance-section mb-5">
                    <h3 class="section-subtitle">PERFORMANS ANALİZİ</h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="performance-card">
                                <h4 class="performance-title">
                                    <i class="fas fa-crosshairs text-success"></i>
                                    Hücum
                                </h4>
                                <div class="performance-stats">
                                    <div class="perf-stat">
                                        <span class="perf-label">Şut</span>
                                        <span class="perf-value">' . ($stats['shots'] ?? '32') . '</span>
                                    </div>
                                    <div class="perf-stat">
                                        <span class="perf-label">İsabet Oranı</span>
                                        <span class="perf-value">' . ($stats['shot_accuracy'] ?? '65') . '%</span>
                                    </div>
                                    <div class="perf-stat">
                                        <span class="perf-label">Pas İsabeti</span>
                                        <span class="perf-value">' . ($stats['pass_accuracy'] ?? '78') . '%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="performance-card">
                                <h4 class="performance-title">
                                    <i class="fas fa-shield-alt text-primary"></i>
                                    Savunma
                                </h4>
                                <div class="performance-stats">
                                    <div class="perf-stat">
                                        <span class="perf-label">Top Kesme</span>
                                        <span class="perf-value">' . ($stats['tackles'] ?? '18') . '</span>
                                    </div>
                                    <div class="perf-stat">
                                        <span class="perf-label">Müdahale</span>
                                        <span class="perf-value">' . ($stats['interceptions'] ?? '12') . '</span>
                                    </div>
                                    <div class="perf-stat">
                                        <span class="perf-label">Başarı Oranı</span>
                                        <span class="perf-value">' . ($stats['defensive_success'] ?? '72') . '%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Performances -->
                <div class="recent-performances mb-5">
                    <h3 class="section-subtitle">SON PERFORMANSLAR</h3>
                    
                    <div class="performances-list">
                        ' . (isset($recent_performances) && !empty($recent_performances) ? 
                            implode('', array_map(function($performance) {
                                return '
                                <div class="performance-item">
                                    <div class="match-info">
                                        <div class="match-date">' . date('d.m.Y', strtotime($performance['match_date'] ?? 'now')) . '</div>
                                        <div class="match-opponent">' . htmlspecialchars($performance['opponent'] ?? 'Rakip Takım') . '</div>
                                    </div>
                                    <div class="performance-rating">
                                        <div class="rating-circle rating-' . ($performance['rating'] ?? 7) . '">
                                            ' . ($performance['rating'] ?? '7.5') . '
                                        </div>
                                    </div>
                                    <div class="performance-stats-inline">
                                        <span class="stat-item">' . ($performance['goals'] ?? '0') . ' Gol</span>
                                        <span class="stat-item">' . ($performance['assists'] ?? '0') . ' Asist</span>
                                        <span class="stat-item">' . ($performance['minutes'] ?? '90') . ' Dk</span>
                                    </div>
                                </div>';
                            }, $recent_performances)) : 
                            '
                            <div class="performance-item">
                                <div class="match-info">
                                    <div class="match-date">' . date('d.m.Y', strtotime('-7 days')) . '</div>
                                    <div class="match-opponent">Rakip Takım</div>
                                </div>
                                <div class="performance-rating">
                                    <div class="rating-circle rating-8">8.0</div>
                                </div>
                                <div class="performance-stats-inline">
                                    <span class="stat-item">1 Gol</span>
                                    <span class="stat-item">1 Asist</span>
                                    <span class="stat-item">90 Dk</span>
                                </div>
                            </div>
                            <div class="performance-item">
                                <div class="match-info">
                                    <div class="match-date">' . date('d.m.Y', strtotime('-14 days')) . '</div>
                                    <div class="match-opponent">Diğer Takım</div>
                                </div>
                                <div class="performance-rating">
                                    <div class="rating-circle rating-7">7.5</div>
                                </div>
                                <div class="performance-stats-inline">
                                    <span class="stat-item">0 Gol</span>
                                    <span class="stat-item">2 Asist</span>
                                    <span class="stat-item">85 Dk</span>
                                </div>
                            </div>'
                        ) . '
                    </div>
                </div>

                <!-- Career Highlights -->
                <div class="career-highlights">
                    <h3 class="section-subtitle">KARİYER VURGULARI</h3>
                    
                    <div class="highlights-grid">
                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-trophy text-warning"></i>
                            </div>
                            <div class="highlight-content">
                                <h5>Şampiyonluklar</h5>
                                <p>3 Lig Şampiyonluğu</p>
                            </div>
                        </div>
                        
                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-medal text-primary"></i>
                            </div>
                            <div class="highlight-content">
                                <h5>Bireysel Ödüller</h5>
                                <p>Sezonun En İyi Oyuncusu 2023</p>
                            </div>
                        </div>
                        
                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-flag text-success"></i>
                            </div>
                            <div class="highlight-content">
                                <h5>Milli Takım</h5>
                                <p>15 A Milli Takım Kappı</p>
                            </div>
                        </div>
                        
                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-futbol text-info"></i>
                            </div>
                            <div class="highlight-content">
                                <h5>Kariyer Rekoru</h5>
                                <p>Tek Maçta 4 Gol</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>