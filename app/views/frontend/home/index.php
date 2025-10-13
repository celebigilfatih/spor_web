<?php
$content = '
<!-- Hero Section / Modern Slider -->
<section class="modern-hero-section">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Main Slider Content -->
            <div class="col-lg-8">
                <div id="modernSlider" class="carousel slide h-100" data-bs-ride="carousel">
                    <div class="carousel-inner h-100">
                        ' . (isset($sliders) && !empty($sliders) ? 
                            implode('', array_map(function($slider, $index) {
                                return '
                                <div class="carousel-item h-100 ' . ($index === 0 ? 'active' : '') . '">
                                    <div class="slider-content d-flex align-items-center h-100">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <div class="slider-badge mb-3">
                                                        <i class="fas fa-newspaper me-2"></i>
                                                        TRANSFER HABERLERİ
                                                    </div>
                                                    <h1 class="slider-title mb-4">' . htmlspecialchars($slider['title'] ?? 'Yeni Transferlerimiz Takımımıza Katıldı') . '</h1>
                                                    <p class="slider-description mb-4">' . htmlspecialchars($slider['description'] ?? 'Bu sezon kadromuzu güçlendiren yeni oyuncularımız ilk antrenmanlarına başladı. Teknik direktörümüz ve yönetimimizin onayladığı transferlerle hedeflerimize emin adımlarla ilerliyoruz.') . '</p>
                                                    <button class="btn btn-slider-primary">
                                                        <i class="fas fa-arrow-right me-2"></i>
                                                        Detayları Gör
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }, $sliders, array_keys($sliders))) : 
                            '
                            <div class="carousel-item h-100 active">
                                <div class="slider-content d-flex align-items-center h-100">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <div class="slider-badge mb-3">
                                                    <i class="fas fa-newspaper me-2"></i>
                                                    TRANSFER HABERLERİ
                                                </div>
                                                <h1 class="slider-title mb-4">Yeni Transferlerimiz Takımımıza Katıldı</h1>
                                                <p class="slider-description mb-4">Bu sezon kadromuzu güçlendiren yeni oyuncularımız ilk antrenmanlarına başladı. Teknik direktörümüz ve yönetimimizin onayladığı transferlerle hedeflerimize emin adımlarla ilerliyoruz.</p>
                                                <button class="btn btn-slider-primary">
                                                    <i class="fas fa-arrow-right me-2"></i>
                                                    Detayları Gör
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item h-100">
                                <div class="slider-content d-flex align-items-center h-100">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <div class="slider-badge mb-3">
                                                    <i class="fas fa-trophy me-2"></i>
                                                    SEZON HABERLERİ
                                                </div>
                                                <h1 class="slider-title mb-4">Yeni Sezon Hazırlıkları Başladı</h1>
                                                <p class="slider-description mb-4">2024-25 sezonunda hedefimiz daha üst seviyelere çıkmak. Takımımız yoğun antrenman programıyla sezona hazırlanıyor. Taraftarımızın desteğiyle başarıya ulaşacağız.</p>
                                                <button class="btn btn-slider-primary">
                                                    <i class="fas fa-arrow-right me-2"></i>
                                                    Detayları Gör
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>'
                        ) . '
                    </div>
                    
                    <!-- Navigation Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#modernSlider" data-bs-slide="prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#modernSlider" data-bs-slide="next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    
                    <!-- Indicators -->
                    <div class="carousel-indicators-custom">
                        <button type="button" data-bs-target="#modernSlider" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#modernSlider" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#modernSlider" data-bs-slide-to="2"></button>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar Content -->
            <div class="col-lg-4">
                <div class="hero-sidebar h-100">
                    <!-- Training Program Section -->
                    <div class="sidebar-section">
                        <div class="sidebar-icon">
                            <i class="fas fa-running"></i>
                        </div>
                        <h3 class="sidebar-title">Antrenman Programı</h3>
                        <p class="sidebar-description">Haftalık antrenman programımız ve takım hazırlık sürecimiz hakkında detaylı bilgilere ulaşabilirsiniz.</p>
                        <button class="btn btn-sidebar-outline">
                            Programı Görüntüle
                        </button>
                    </div>
                    
                    <!-- Announcements Section -->
                    <div class="sidebar-section">
                        <div class="sidebar-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h3 class="sidebar-title">Duyurular</h3>
                        <p class="sidebar-description">Kulübümüzden önemli duyurular, etkinlik tarihleri ve taraftar bilgilendirmeleri.</p>
                        <button class="btn btn-sidebar-outline">
                            Tüm Duyurular
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Match Calendar Section -->
<section class="match-calendar-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header mb-4">
                    <h2 class="section-title">MAÇ TAKVİMİ</h2>
                    <a href="' . BASE_URL . '/ateam/fixtures" class="btn btn-outline-primary">Tüm Maçlar</a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Upcoming Matches -->
            <div class="col-lg-6 mb-4">
                <div class="calendar-card upcoming-matches">
                    <div class="calendar-header">
                        <i class="fas fa-calendar-plus"></i>
                        <h3>YAKLAŞAN MAÇLAR</h3>
                    </div>
                    <div class="matches-list">
                        ' . (isset($upcoming_matches) && !empty($upcoming_matches) ? 
                            implode('', array_map(function($match) {
                                return '
                                <div class="match-calendar-item">
                                    <div class="match-date-info">
                                        <div class="match-day">' . date('d', strtotime($match['match_date'] ?? 'now')) . '</div>
                                        <div class="match-month">' . 
                                            ['01' => 'OCA', '02' => 'ŞUB', '03' => 'MAR', '04' => 'NİS', 
                                             '05' => 'MAY', '06' => 'HAZ', '07' => 'TEM', '08' => 'AĞU', 
                                             '09' => 'EYL', '10' => 'EKİ', '11' => 'KAS', '12' => 'ARA'][date('m', strtotime($match['match_date'] ?? 'now'))] . 
                                        '</div>
                                        <div class="match-time">' . date('H:i', strtotime($match['match_date'] ?? 'now')) . '</div>
                                    </div>
                                    <div class="match-teams-info">
                                        <div class="match-teams">
                                            <span class="home-team">' . htmlspecialchars($match['home_team'] ?? 'Ev Sahibi') . '</span>
                                            <span class="vs-text">VS</span>
                                            <span class="away-team">' . htmlspecialchars($match['away_team'] ?? 'Deplasman') . '</span>
                                        </div>
                                        <div class="match-venue">
                                            <i class="fas fa-map-marker-alt"></i>
                                            ' . htmlspecialchars($match['venue'] ?? 'Stadyum') . '
                                        </div>
                                    </div>
                                    <div class="match-status">
                                        <span class="status-badge upcoming">YAKLAŞAN</span>
                                    </div>
                                </div>';
                            }, $upcoming_matches)) : 
                            '
                            <div class="match-calendar-item">
                                <div class="match-date-info">
                                    <div class="match-day">' . date('d', strtotime('+7 days')) . '</div>
                                    <div class="match-month">EKİ</div>
                                    <div class="match-time">19:00</div>
                                </div>
                                <div class="match-teams-info">
                                    <div class="match-teams">
                                        <span class="home-team">Spor Kulübü</span>
                                        <span class="vs-text">VS</span>
                                        <span class="away-team">Rakip Takım</span>
                                    </div>
                                    <div class="match-venue">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Ev Sahası
                                    </div>
                                </div>
                                <div class="match-status">
                                    <span class="status-badge upcoming">YAKLAŞAN</span>
                                </div>
                            </div>
                            <div class="match-calendar-item">
                                <div class="match-date-info">
                                    <div class="match-day">' . date('d', strtotime('+14 days')) . '</div>
                                    <div class="match-month">EKİ</div>
                                    <div class="match-time">16:00</div>
                                </div>
                                <div class="match-teams-info">
                                    <div class="match-teams">
                                        <span class="home-team">Deplasman Takımı</span>
                                        <span class="vs-text">VS</span>
                                        <span class="away-team">Spor Kulübü</span>
                                    </div>
                                    <div class="match-venue">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Deplasman Stadı
                                    </div>
                                </div>
                                <div class="match-status">
                                    <span class="status-badge upcoming">YAKLAŞAN</span>
                                </div>
                            </div>'
                        ) . '
                    </div>
                </div>
            </div>
            
            <!-- Recent Results -->
            <div class="col-lg-6 mb-4">
                <div class="calendar-card recent-results">
                    <div class="calendar-header">
                        <i class="fas fa-calendar-check"></i>
                        <h3>SON SONUÇLAR</h3>
                    </div>
                    <div class="matches-list">
                        ' . (isset($recent_results) && !empty($recent_results) ? 
                            implode('', array_map(function($result) {
                                return '
                                <div class="match-calendar-item">
                                    <div class="match-date-info">
                                        <div class="match-day">' . date('d', strtotime($result['match_date'] ?? 'now')) . '</div>
                                        <div class="match-month">' . 
                                            ['01' => 'OCA', '02' => 'ŞUB', '03' => 'MAR', '04' => 'NİS', 
                                             '05' => 'MAY', '06' => 'HAZ', '07' => 'TEM', '08' => 'AĞU', 
                                             '09' => 'EYL', '10' => 'EKİ', '11' => 'KAS', '12' => 'ARA'][date('m', strtotime($result['match_date'] ?? 'now'))] . 
                                        '</div>
                                        <div class="match-time">MS</div>
                                    </div>
                                    <div class="match-teams-info">
                                        <div class="match-teams">
                                            <span class="home-team">' . htmlspecialchars($result['home_team'] ?? 'Ev') . '</span>
                                            <span class="score-display">' . ($result['home_score'] ?? '0') . ' - ' . ($result['away_score'] ?? '0') . '</span>
                                            <span class="away-team">' . htmlspecialchars($result['away_team'] ?? 'Deplasman') . '</span>
                                        </div>
                                        <div class="match-venue">
                                            <i class="fas fa-map-marker-alt"></i>
                                            ' . htmlspecialchars($result['venue'] ?? 'Stadyum') . '
                                        </div>
                                    </div>
                                    <div class="match-status">
                                        <span class="status-badge finished">BİTTİ</span>
                                    </div>
                                </div>';
                            }, $recent_results)) : 
                            '
                            <div class="match-calendar-item">
                                <div class="match-date-info">
                                    <div class="match-day">' . date('d', strtotime('-7 days')) . '</div>
                                    <div class="match-month">EKİ</div>
                                    <div class="match-time">MS</div>
                                </div>
                                <div class="match-teams-info">
                                    <div class="match-teams">
                                        <span class="home-team">Spor Kulübü</span>
                                        <span class="score-display">2 - 1</span>
                                        <span class="away-team">Rakip Takım</span>
                                    </div>
                                    <div class="match-venue">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Ev Sahası
                                    </div>
                                </div>
                                <div class="match-status">
                                    <span class="status-badge finished">BİTTİ</span>
                                </div>
                            </div>
                            <div class="match-calendar-item">
                                <div class="match-date-info">
                                    <div class="match-day">' . date('d', strtotime('-14 days')) . '</div>
                                    <div class="match-month">EYL</div>
                                    <div class="match-time">MS</div>
                                </div>
                                <div class="match-teams-info">
                                    <div class="match-teams">
                                        <span class="home-team">Deplasman</span>
                                        <span class="score-display">1 - 3</span>
                                        <span class="away-team">Spor Kulübü</span>
                                    </div>
                                    <div class="match-venue">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Deplasman Stadı
                                    </div>
                                </div>
                                <div class="match-status">
                                    <span class="status-badge finished">BİTTİ</span>
                                </div>
                            </div>'
                        ) . '
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats -->
<section class="quick-stats py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6 text-center mb-4">
                <div class="stat-item">
                    <i class="fas fa-trophy fa-3x mb-3 text-warning"></i>
                    <h3 class="fw-bold">25+</h3>
                    <p>Şampiyonluk</p>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4">
                <div class="stat-item">
                    <i class="fas fa-users fa-3x mb-3 text-warning"></i>
                    <h3 class="fw-bold">500+</h3>
                    <p>Aktif Sporcu</p>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4">
                <div class="stat-item">
                    <i class="fas fa-calendar fa-3x mb-3 text-warning"></i>
                    <h3 class="fw-bold">95</h3>
                    <p>Yıllık Tecrübe</p>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4">
                <div class="stat-item">
                    <i class="fas fa-medal fa-3x mb-3 text-warning"></i>
                    <h3 class="fw-bold">150+</h3>
                    <p>Milli Sporcu</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest News & Upcoming Matches -->
<section class="news-matches py-5">
    <div class="container">
        <div class="row">
            <!-- Latest News -->
            <div class="col-lg-8 mb-5">
                <div class="section-header mb-4">
                    <h2 class="section-title">SON HABERLER</h2>
                    <a href="' . BASE_URL . '/news" class="btn btn-outline-primary">Tüm Haberler</a>
                </div>
                
                <div class="row">
                    ' . (isset($latest_news) && !empty($latest_news) ? 
                        implode('', array_map(function($news) {
                            return '
                            <div class="col-md-6 mb-4">
                                <div class="news-card">
                                    <img src="' . BASE_URL . '/public/uploads/' . ($news['image'] ?? 'default-news.jpg') . '" 
                                         class="news-image" alt="' . htmlspecialchars($news['title'] ?? '') . '">
                                    <div class="news-content">
                                        <span class="news-date">' . date('d.m.Y', strtotime($news['created_at'] ?? 'now')) . '</span>
                                        <h4 class="news-title">' . htmlspecialchars($news['title'] ?? '') . '</h4>
                                        <p class="news-excerpt">' . substr(strip_tags($news['content'] ?? ''), 0, 120) . '...</p>
                                        <a href="' . BASE_URL . '/news/view/' . ($news['id'] ?? '') . '" class="btn btn-sm btn-primary">Devamını Oku</a>
                                    </div>
                                </div>
                            </div>';
                        }, $latest_news)) : 
                        '
                        <div class="col-md-6 mb-4">
                            <div class="news-card">
                                <img src="' . BASE_URL . '/public/images/default-news.jpg" class="news-image" alt="Örnek Haber">
                                <div class="news-content">
                                    <span class="news-date">' . date('d.m.Y') . '</span>
                                    <h4 class="news-title">Yeni Sezon Hazırlıkları Başladı</h4>
                                    <p class="news-excerpt">Takımımız yeni sezon hazırlıklarına başladı. Antrenmanlar her gün düzenli olarak devam ediyor...</p>
                                    <a href="' . BASE_URL . '/news" class="btn btn-sm btn-primary">Devamını Oku</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="news-card">
                                <img src="' . BASE_URL . '/public/images/default-news.jpg" class="news-image" alt="Örnek Haber">
                                <div class="news-content">
                                    <span class="news-date">' . date('d.m.Y') . '</span>
                                    <h4 class="news-title">Yeni Transfer Haberi</h4>
                                    <p class="news-excerpt">Kulübümüz yeni sezon için önemli transferler gerçekleştirdi. Detaylar için haberi okuyabilirsiniz...</p>
                                    <a href="' . BASE_URL . '/news" class="btn btn-sm btn-primary">Devamını Oku</a>
                                </div>
                            </div>
                        </div>'
                    ) . '
                </div>
            </div>

            <!-- Upcoming Matches & Results -->
            <div class="col-lg-4">
                <div class="sidebar-widget">
                    <h3 class="widget-title">YAKLAŞAN MAÇLAR</h3>
                    <div class="matches-list">
                        ' . (isset($upcoming_matches) && !empty($upcoming_matches) ? 
                            implode('', array_map(function($match) {
                                return '
                                <div class="match-item">
                                    <div class="match-date">' . date('d.m.Y H:i', strtotime($match['match_date'] ?? 'now')) . '</div>
                                    <div class="match-teams">
                                        <span class="home-team">' . htmlspecialchars($match['home_team'] ?? 'Ev Sahibi') . '</span>
                                        <span class="vs">VS</span>
                                        <span class="away-team">' . htmlspecialchars($match['away_team'] ?? 'Deplasman') . '</span>
                                    </div>
                                    <div class="match-venue">' . htmlspecialchars($match['venue'] ?? 'Stadyum') . '</div>
                                </div>';
                            }, $upcoming_matches)) : 
                            '
                            <div class="match-item">
                                <div class="match-date">' . date('d.m.Y H:i', strtotime('+7 days')) . '</div>
                                <div class="match-teams">
                                    <span class="home-team">Spor Kulübü</span>
                                    <span class="vs">VS</span>
                                    <span class="away-team">Rakip Takım</span>
                                </div>
                                <div class="match-venue">Ev Sahası</div>
                            </div>
                            <div class="match-item">
                                <div class="match-date">' . date('d.m.Y H:i', strtotime('+14 days')) . '</div>
                                <div class="match-teams">
                                    <span class="home-team">Deplasman Takımı</span>
                                    <span class="vs">VS</span>
                                    <span class="away-team">Spor Kulübü</span>
                                </div>
                                <div class="match-venue">Deplasman</div>
                            </div>'
                        ) . '
                    </div>
                </div>

                <div class="sidebar-widget mt-4">
                    <h3 class="widget-title">SON SONUÇLAR</h3>
                    <div class="results-list">
                        ' . (isset($recent_results) && !empty($recent_results) ? 
                            implode('', array_map(function($result) {
                                return '
                                <div class="result-item">
                                    <div class="result-date">' . date('d.m.Y', strtotime($result['match_date'] ?? 'now')) . '</div>
                                    <div class="result-teams">
                                        <span class="home-team">' . htmlspecialchars($result['home_team'] ?? 'Ev') . '</span>
                                        <span class="score">' . ($result['home_score'] ?? '0') . ' - ' . ($result['away_score'] ?? '0') . '</span>
                                        <span class="away-team">' . htmlspecialchars($result['away_team'] ?? 'Deplasman') . '</span>
                                    </div>
                                </div>';
                            }, $recent_results)) : 
                            '
                            <div class="result-item">
                                <div class="result-date">' . date('d.m.Y', strtotime('-7 days')) . '</div>
                                <div class="result-teams">
                                    <span class="home-team">Spor Kulübü</span>
                                    <span class="score">2 - 1</span>
                                    <span class="away-team">Rakip Takım</span>
                                </div>
                            </div>
                            <div class="result-item">
                                <div class="result-date">' . date('d.m.Y', strtotime('-14 days')) . '</div>
                                <div class="result-teams">
                                    <span class="home-team">Deplasman</span>
                                    <span class="score">1 - 3</span>
                                    <span class="away-team">Spor Kulübü</span>
                                </div>
                            </div>'
                        ) . '
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section py-5 bg-warning">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold text-dark mb-3">KULÜBÜMÜZE KATILIN</h2>
                <p class="lead text-dark mb-4">Geleceğin yıldızları olmak için bugün aramıza katılın. Profesyonel antrenörlerimiz ve modern tesislerimizle sizi bekliyoruz.</p>
                <a href="' . BASE_URL . '/groups" class="btn btn-dark btn-lg me-3">Grupları İncele</a>
                <a href="' . BASE_URL . '/home/contact" class="btn btn-outline-dark btn-lg">İletişime Geç</a>
            </div>
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>