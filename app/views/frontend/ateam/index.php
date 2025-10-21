<?php
$content = '
<!-- Corporate Team Stylesheet -->
<link rel="stylesheet" href="' . BASE_URL . '/css/corporate-team.css">

<!-- Corporate Page Header -->
<section class="corporate-page-header">
    <div class="container">
        <div class="corporate-breadcrumb">
            <a href="' . BASE_URL . '">Ana Sayfa</a>
            <span class="separator">/</span>
            <span>A Takımı</span>
        </div>
        <div class="corporate-header-content">
            <h1 class="corporate-title">A Takımı</h1>
            <p class="corporate-subtitle">En üst düzeyde mücadele eden, özveri, yetenek ve mükemmellik arayışıyla dolu ilk takımımız</p>
        </div>
    </div>
</section>

<!-- About A Team Section -->
<section class="about-team-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="about-content">
                    <h2 class="about-title">A Takımımız Hakkında</h2>
                    <div class="about-text">
                        <p>A Takımımız, kulübümüzün sportif mükemmeliyetinin zirvesini temsil eder. Elit sporcular ve deneyimli profesyonellerden oluşan ilk takımımız, en yüksek seviyede rekabet eder ve tüm organizasyonumuzun değerlerini, geleneklerini ve hedeflerini temsil eder.</p>
                        
                        <p>Zengin bir başarı geçmişine ve sürekli gelişim taahhüdüne sahip olan A Takımımız, olağanüstü beceri, taktik farkındalık ve takım çalışması sergiler. Her oyuncu benzersiz yetenekler ve özveri getirir, her maçta zafer için çabalayan uyumlu bir ekibe katkıda bulunur.</p>
                        
                        <p>Deneyimli teknik kadromuzun rehberliğinde takım, teknik mükemmellik, fiziksel kondisyon ve zihinsel hazırlığı vurgulayan profesyonel bir antrenman rejimine uyar. Yaklaşımımız, oyuncu gelişimini ve takım performansını en üst düzeye çıkarmak için modern spor bilimini zamana meydan okuyan yöntemlerle birleştirir.</p>
                        
                        <div class="team-values">
                            <div class="value-item">
                                <i class="fas fa-trophy"></i>
                                <span>Rekabette Mükemmellik</span>
                            </div>
                            <div class="value-item">
                                <i class="fas fa-users"></i>
                                <span>Takım Ruhu ve Birlik</span>
                            </div>
                            <div class="value-item">
                                <i class="fas fa-heart"></i>
                                <span>Tutku ve Özveri</span>
                            </div>
                            <div class="value-item">
                                <i class="fas fa-star"></i>
                                <span>Profesyonel Standartlar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-stats-grid">
                    <div class="about-stat-card">
                        <div class="stat-icon-large success">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-number-large">15</div>
                        <div class="stat-label-large">Şampiyonluk</div>
                    </div>
                    <div class="about-stat-card">
                        <div class="stat-icon-large primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number-large">25</div>
                        <div class="stat-label-large">Oyuncu</div>
                    </div>
                    <div class="about-stat-card">
                        <div class="stat-icon-large warning">
                            <i class="fas fa-futbol"></i>
                        </div>
                        <div class="stat-number-large">45</div>
                        <div class="stat-label-large">Bu Sezon Gol</div>
                    </div>
                    <div class="about-stat-card">
                        <div class="stat-icon-large info">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div class="stat-number-large">85</div>
                        <div class="stat-label-large">Yıllık Tarih</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Sections Navigation -->
<section class="team-sections-nav">
    <div class="container">
        <h2 class="corporate-section-title">Takım Bilgileri</h2>

        <div class="corporate-nav-grid">
            <div class="corporate-nav-card">
                <div class="corporate-nav-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Takım Kadrosu</h3>
                <p>Profesyonel sporcularımızla tanışın. Detaylı oyuncu profilleri, istatistikler ve kariyer bilgilerini görüntüleyin.</p>
                <a href="' . BASE_URL . '/ateam/squad" class="corporate-nav-btn">
                    Kadroyu Görüntüle
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="corporate-nav-card">
                <div class="corporate-nav-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <h3>Maç Programı ve Sonuçlar</h3>
                <p>Yaklaşan maçlarımızı kontrol edin ve detaylı istatistiklerle geçmiş performans sonuçlarını inceleyin.</p>
                <a href="' . BASE_URL . '/ateam/fixtures" class="corporate-nav-btn">
                    Programı Görüntüle
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="corporate-nav-card">
                <div class="corporate-nav-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3>Takım İstatistikleri</h3>
                <p>Kapsamlı takım ve oyuncu performans verilerini, analizleri ve içgörüleri keşfedin.</p>
                <a href="' . BASE_URL . '/ateam/stats" class="corporate-nav-btn">
                    İstatistikleri Görüntüle
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Recent Matches -->
<section class="corporate-matches-section">
    <div class="container">
        <h2 class="corporate-section-title">Son Maçlar</h2>
        <div class="row">
            ' . (isset($recent_matches) && !empty($recent_matches) ? 
                implode('', array_map(function($match) {
                    return '
                    <div class="col-lg-6 mb-4">
                        <div class="corporate-match-card">
                            <div class="corporate-match-date">
                                <i class="fas fa-calendar"></i>
                                ' . date('d', strtotime($match['match_date'] ?? 'now')) . ' ' . 
                                    ['01' => 'Ocak', '02' => 'Şubat', '03' => 'Mart', '04' => 'Nisan', 
                                     '05' => 'Mayıs', '06' => 'Haziran', '07' => 'Temmuz', '08' => 'Ağustos', 
                                     '09' => 'Eylül', '10' => 'Ekim', '11' => 'Kasım', '12' => 'Aralık'][date('m', strtotime($match['match_date'] ?? 'now'))] . ' ' . 
                                    date('Y', strtotime($match['match_date'] ?? 'now')) . '
                            </div>
                            <div class="corporate-match-teams">
                                <div class="corporate-team-name">' . htmlspecialchars($match['home_team'] ?? 'Ev Sahibi') . '</div>
                                <div class="corporate-match-score">' . ($match['home_score'] ?? '0') . ' - ' . ($match['away_score'] ?? '0') . '</div>
                                <div class="corporate-team-name">' . htmlspecialchars($match['away_team'] ?? 'Deplasman') . '</div>
                            </div>
                            <div class="corporate-match-venue">
                                <i class="fas fa-map-marker-alt"></i>
                                ' . htmlspecialchars($match['venue'] ?? 'Stadyum') . '
                            </div>
                        </div>
                    </div>';
                }, $recent_matches)) : 
                '
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                        <p class="text-muted" style="font-size: 1.125rem;">Şu anda gösterilecek son maç bulunmamaktadır.</p>
                    </div>
                </div>'
            ) . '
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>