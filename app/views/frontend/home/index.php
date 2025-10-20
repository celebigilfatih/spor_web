<?php
$content = '
<!-- Hero Section / Modern Slider -->
<section class="modern-hero-section">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Main Slider Content -->
            <div class="col-lg-8">
                <div id="modernSlider" class="carousel slide h-100" data-bs-ride="carousel">
                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators">
                        ' . (isset($latest_news) && !empty($latest_news) ? 
                            implode('', array_map(function($news, $index) {
                                return '<button type="button" data-bs-target="#modernSlider" data-bs-slide-to="' . $index . '" ' . ($index === 0 ? 'class="active" aria-current="true"' : '') . ' aria-label="Slide ' . ($index + 1) . '"></button>';
                            }, array_slice($latest_news, 0, 3), array_keys(array_slice($latest_news, 0, 3)))) : 
                            '<button type="button" data-bs-target="#modernSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>'
                        ) . '
                    </div>
                    
                    <div class="carousel-inner h-100">
                        ' . (isset($latest_news) && !empty($latest_news) ? 
                            implode('', array_map(function($news, $index) {
                                // Get category icon and label
                                $categoryIcons = [
                                    'futbol' => 'fa-futbol',
                                    'basketbol' => 'fa-basketball-ball',
                                    'voleybol' => 'fa-volleyball-ball',
                                    'transfer' => 'fa-exchange-alt',
                                    'alt-yapi' => 'fa-users',
                                    'genel' => 'fa-newspaper'
                                ];
                                $categoryLabels = [
                                    'futbol' => 'FUTBOL HABERLERİ',
                                    'basketbol' => 'BASKETBOL HABERLERİ',
                                    'voleybol' => 'VOLEYBOL HABERLERİ',
                                    'transfer' => 'TRANSFER HABERLERİ',
                                    'alt-yapi' => 'ALT YAPI HABERLERİ',
                                    'genel' => 'GENEL HABERLER'
                                ];
                                
                                $category = strtolower($news['category'] ?? 'genel');
                                $icon = $categoryIcons[$category] ?? 'fa-newspaper';
                                $label = $categoryLabels[$category] ?? 'HABERLER';
                                $excerpt = strip_tags($news['excerpt'] ?? $news['content'] ?? '');
                                $excerpt = substr($excerpt, 0, 180);
                                
                                return '
                                <div class="carousel-item h-100 ' . ($index === 0 ? 'active' : '') . '" style="background: linear-gradient(rgba(30, 58, 138, 0.25), rgba(30, 58, 138, 0.35)), url(' . BASE_URL . '/uploads/' . ($news['image'] ?? 'default-news.jpg') . ') center/cover no-repeat;">
                                    <div class="slider-content d-flex align-items-center h-100">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <div class="slider-badge mb-3">
                                                        <i class="fas ' . $icon . ' me-2"></i>
                                                        ' . $label . '
                                                    </div>
                                                    <h1 class="slider-title mb-4">' . htmlspecialchars($news['title'] ?? 'Haber Başlığı') . '</h1>
                                                    <p class="slider-description mb-4">' . htmlspecialchars($excerpt) . '...</p>
                                                    <a href="' . BASE_URL . '/news/detail/' . ($news['slug'] ?? '#') . '" class="btn btn-slider-primary">
                                                        <i class="fas fa-arrow-right me-2"></i>
                                                        Devamını Oku
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }, array_slice($latest_news, 0, 3), array_keys(array_slice($latest_news, 0, 3)))) : 
                            '
                            <div class="carousel-item h-100 active">
                                <div class="slider-content d-flex align-items-center h-100">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <div class="slider-badge mb-3">
                                                    <i class="fas fa-newspaper me-2"></i>
                                                    HABERLER
                                                </div>
                                                <h1 class="slider-title mb-4">Henüz Haber Bulunmamaktadır</h1>
                                                <p class="slider-description mb-4">Yakında yeni haberler yayınlanacaktır. Takımımızın son gelişmelerinden haberdar olmak için sitemizi takip etmeye devam edin.</p>
                                                <a href="' . BASE_URL . '/news" class="btn btn-slider-primary">
                                                    <i class="fas fa-arrow-right me-2"></i>
                                                    Tüm Haberler
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            '
                        ) . '
                    </div>
                    
                    <!-- Slider Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#modernSlider" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#modernSlider" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            
            <!-- Sidebar Content -->
            <div class="col-lg-4">
                <div class="hero-sidebar h-100">
                    <!-- Announcements -->
                    <div class="announcements-card">
                        <div class="card-header d-flex align-items-center mb-3">
                            <i class="fas fa-bullhorn text-warning me-2 fs-4"></i>
                            <h3 class="card-title mb-0">Duyurular</h3>
                            <a href="#" class="ms-auto text-primary small">Tümünü Gör</a>
                        </div>
                        <div class="announcements-list">
                            ' . (isset($announcements) && !empty($announcements) ? 
                                implode('', array_map(function($announcement) {
                                    $typeBadge = '';
                                    $typeLabel = '';
                                    
                                    switch($announcement['type']) {
                                        case 'important':
                                            $typeBadge = 'bg-danger';
                                            $typeLabel = 'ÖNEMLİ';
                                            break;
                                        case 'info':
                                            $typeBadge = 'bg-info';
                                            $typeLabel = 'BİLGİ';
                                            break;
                                        case 'warning':
                                            $typeBadge = 'bg-warning';
                                            $typeLabel = 'UYARI';
                                            break;
                                        case 'success':
                                            $typeBadge = 'bg-success';
                                            $typeLabel = 'BAŞARILI';
                                            break;
                                        default:
                                            $typeBadge = 'bg-secondary';
                                            $typeLabel = 'BİLGİ';
                                    }
                                    
                                    $publishedDate = date('d M Y', strtotime($announcement['published_at'] ?? $announcement['created_at']));
                                    
                                    return '
                                    <div class="announcement-item mb-3 p-3 bg-light rounded">
                                        <div class="announcement-badge mb-2">
                                            <span class="badge ' . $typeBadge . '">' . $typeLabel . '</span>
                                            <span class="text-muted small ms-2">' . $publishedDate . '</span>
                                        </div>
                                        <h5 class="announcement-title mb-2">' . htmlspecialchars($announcement['title']) . '</h5>
                                        <p class="announcement-text mb-0 small">' . htmlspecialchars($announcement['content']) . '</p>
                                    </div>';
                                }, $announcements)) : 
                                '
                                <div class="announcement-item mb-3 p-3 bg-light rounded text-center">
                                    <p class="text-muted mb-0">Henüz duyuru bulunmamaktadır.</p>
                                </div>'
                            ) . '
                        </div>
                    </div>
                    <!-- Instagram Feed -->
                    <div class="instagram-feed-card mb-4">
                        <div class="card-header d-flex align-items-center mb-3">
                            <i class="fab fa-instagram text-danger me-2 fs-4"></i>
                            <h3 class="card-title mb-0">Instagram</h3>
                            <a href="#" class="ms-auto text-primary small">Tümünü Gör</a>
                        </div>
                        <div class="instagram-posts">
                            <div class="instagram-post mb-3">
                                <div class="post-header d-flex align-items-center mb-2">
                                    <div class="profile-pic me-2">
                                        <img src="/uploads/team-logos/fenerbahce.svg" alt="Kulüp" class="rounded-circle" width="32" height="32">
                                    </div>
                                    <div class="post-info">
                                        <div class="username fw-bold">@sporkulubu</div>
                                        <div class="post-time text-muted small">2 saat önce</div>
                                    </div>
                                </div>
                                <div class="post-content">
                                    <p class="post-text mb-2">🔥 Antrenmanlarımız devam ediyor! Yeni sezon için hazırız 💪 #YeniSezon #Hazırlık</p>

                                    <div class="post-stats mt-2 d-flex text-muted small">
                                        <span class="me-3"><i class="far fa-heart me-1"></i>1.2K</span>
                                        <span><i class="far fa-comment me-1"></i>45</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="instagram-post">
                                <div class="post-header d-flex align-items-center mb-2">
                                    <div class="profile-pic me-2">
                                        <img src="/uploads/team-logos/fenerbahce.svg" alt="Kulüp" class="rounded-circle" width="32" height="32">
                                    </div>
                                    <div class="post-info">
                                        <div class="username fw-bold">@sporkulubu</div>
                                        <div class="post-time text-muted small">1 gün önce</div>
                                    </div>
                                </div>
                                <div class="post-content">
                                    <p class="post-text mb-2">🏆 Galibiyetimizi kutluyoruz! Taraftarımıza teşekkürler 🙏 #Galibiyet #Teşekkürler</p>
                                    <div class="post-stats mt-2 d-flex text-muted small">
                                        <span class="me-3"><i class="far fa-heart me-1"></i>2.8K</span>
                                        <span><i class="far fa-comment me-1"></i>156</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Match Calendar Section -->
<section class="match-calendar-section py-5">
    <div class="container-fluid">
        <div class="row px-5">
            <div class="col-12">

                <div class="section-header mb-4">
                    <h2 class="section-title">MAÇ TAKVİMİ</h2>
                        <div class="nav-filters">
                            <button class="filter-btn active" data-filter="all">Tüm Maçlar</button>
                            <button class="filter-btn" data-filter="upcoming">Yaklaşan</button>
                            <button class="filter-btn" data-filter="finished">Tamamlanan</button>
                        </div>
                </div>
                <!-- Horizontal Match Calendar -->
                <div class="horizontal-match-calendar">
                    <div class="match-calendar-nav">



                    </div>
                    
                    <div class="matches-horizontal-container">
                        <button class="nav-btn prev-btn" onclick="scrollMatches(\'left\')">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="matches-horizontal-scroll" id="matchesScroll">
                            ' . (
                                (isset($upcoming_matches) && !empty($upcoming_matches) ? 
                                    implode('', array_map(function($match) {
                                        $months = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
                                        $matchDate = strtotime($match['match_date']);
                                        $day = date('d', $matchDate);
                                        $month = $months[date('n', $matchDate) - 1];
                                        $time = date('H:i', $matchDate);
                                        return '
                            <div class="horizontal-match-card upcoming" data-type="upcoming">
                                <div class="match-status-indicator">
                                    <span class="status-dot upcoming"></span>
                                    <span class="status-text">Yaklaşan</span>
                                </div>
                                <div class="match-date-section">
                                    <div class="match-day">' . $day . '</div>
                                    <div class="match-month">' . $month . '</div>
                                </div>
                                <div class="match-time-section">
                                    <div class="match-time">' . $time . '</div>
                                </div>
                                <div class="teams-section">
                                    <div class="team home-team">
                                        <div class="team-logo">
                                            <img src="' . BASE_URL . '/uploads/team-logos/' . strtolower(str_replace(' ', '-', $match['home_team'])) . '.svg" alt="' . htmlspecialchars($match['home_team']) . '" onerror="this.src=\'' . BASE_URL . '/uploads/team-logos/default.svg\'">
                                        </div>
                                        <div class="team-name">' . htmlspecialchars($match['home_team']) . '</div>
                                    </div>
                                    <div class="vs-section">
                                        <div class="vs-text">VS</div>
                                    </div>
                                    <div class="team away-team">
                                        <div class="team-logo">
                                            <img src="' . BASE_URL . '/uploads/team-logos/' . strtolower(str_replace(' ', '-', $match['away_team'])) . '.svg" alt="' . htmlspecialchars($match['away_team']) . '" onerror="this.src=\'' . BASE_URL . '/uploads/team-logos/default.svg\'">
                                        </div>
                                        <div class="team-name">' . htmlspecialchars($match['away_team']) . '</div>
                                    </div>
                                </div>
                                <div class="match-venue-section">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>' . htmlspecialchars($match['venue']) . '</span>
                                </div>
                            </div>';
                                    }, $upcoming_matches)) : '') .
                                (isset($recent_results) && !empty($recent_results) ? 
                                    implode('', array_map(function($match) {
                                        $months = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
                                        $matchDate = strtotime($match['match_date']);
                                        $day = date('d', $matchDate);
                                        $month = $months[date('n', $matchDate) - 1];
                                        return '
                            <div class="horizontal-match-card finished" data-type="finished">
                                <div class="match-status-indicator">
                                    <span class="status-dot finished"></span>
                                    <span class="status-text">Tamamlandı</span>
                                </div>
                                <div class="match-date-section">
                                    <div class="match-day">' . $day . '</div>
                                    <div class="match-month">' . $month . '</div>
                                </div>
                                <div class="match-score-section">
                                    <div class="final-score">' . ($match['home_score'] ?? '0') . ' - ' . ($match['away_score'] ?? '0') . '</div>
                                </div>
                                <div class="teams-section">
                                    <div class="team home-team">
                                        <div class="team-logo">
                                            <img src="' . BASE_URL . '/uploads/team-logos/' . strtolower(str_replace(' ', '-', $match['home_team'])) . '.svg" alt="' . htmlspecialchars($match['home_team']) . '" onerror="this.src=\'' . BASE_URL . '/uploads/team-logos/default.svg\'">
                                        </div>
                                        <div class="team-name">' . htmlspecialchars($match['home_team']) . '</div>
                                    </div>
                                    <div class="vs-section">
                                        <div class="vs-text">VS</div>
                                    </div>
                                    <div class="team away-team">
                                        <div class="team-logo">
                                            <img src="' . BASE_URL . '/uploads/team-logos/' . strtolower(str_replace(' ', '-', $match['away_team'])) . '.svg" alt="' . htmlspecialchars($match['away_team']) . '" onerror="this.src=\'' . BASE_URL . '/uploads/team-logos/default.svg\'">
                                        </div>
                                        <div class="team-name">' . htmlspecialchars($match['away_team']) . '</div>
                                    </div>
                                </div>
                                <div class="match-venue-section">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>' . htmlspecialchars($match['venue']) . '</span>
                                </div>
                            </div>';
                                    }, $recent_results)) : '') .
                                ((!isset($upcoming_matches) || empty($upcoming_matches)) && (!isset($recent_results) || empty($recent_results)) ? '
                            <div class="no-matches-message text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Henüz maç bulunmamaktadır</h5>
                                <p class="text-muted">Yeni maçlar eklendiğinde burada görüntülenecektir.</p>
                            </div>' : '')
                            ) . '
                        </div>
                        <button class="nav-btn next-btn" onclick="scrollMatches(\'right\')">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>



<!-- News Section -->
<section class="news-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header mb-4">
                    <h2 class="section-title">SON HABERLER</h2>
                    <a href="' . BASE_URL . '/news" class="btn btn-outline-primary">Tüm Haberler</a>
                </div>
            </div>
        </div>
        
        <div class="row">
            ' . (isset($latest_news) && !empty($latest_news) ? 
                implode('', array_map(function($article) {
                    // Clean excerpt from HTML tags
                    $excerpt = strip_tags($article['excerpt'] ?? $article['content'] ?? '');
                    $excerpt = substr($excerpt, 0, 120);
                    
                    return '
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card h-100">
                            <div class="news-image">
                                <img src="' . BASE_URL . '/uploads/' . ($article['image'] ?? 'default-news.jpg') . '" alt="' . htmlspecialchars($article['title'] ?? 'Haber') . '" class="img-fluid">
                                <div class="news-category">' . htmlspecialchars(ucfirst($article['category'] ?? 'Genel')) . '</div>
                            </div>
                            <div class="news-content">
                                <h3 class="news-title">' . htmlspecialchars($article['title'] ?? 'Haber Başlığı') . '</h3>
                                <p class="news-excerpt">' . htmlspecialchars($excerpt) . '...</p>
                                <div class="news-meta">
                                    <span class="news-date">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        ' . date('d.m.Y', strtotime($article['published_at'] ?? $article['created_at'] ?? 'now')) . '
                                    </span>
                                    <a href="' . BASE_URL . '/news/detail/' . ($article['slug'] ?? '#') . '" class="read-more">
                                        Devamını Oku
                                        <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }, $latest_news)) : 
                '
                <div class="col-12">
                    <div class="no-news text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h3>Henüz haber bulunmamaktadır</h3>
                        <p class="text-muted">Yakında yeni haberler yayınlanacak.</p>
                    </div>
                </div>
                '
            ) . '
        </div>
    </div>
</section>

<!-- Youth Academy Registration Section -->
<section class="youth-registration-section py-5 bg-light">
    <div class="container-fluid px-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="youth-registration-content">
                    <div class="section-badge mb-3">
                        <i class="fas fa-star me-2"></i>
                        GELECEĞE YATIRIM
                    </div>
                    <h2 class="section-title mb-4">Alt Yapı Kayıt Başvuruları Başladı!</h2>
                    <p class="section-description mb-4">
                        Geleceğin yıldızlarını arıyoruz! Kulübümüzün alt yapı takımlarına katılmak isteyen genç yetenekler için kayıt başvuruları başlamıştır. 
                        Profesyonel antrenörlerimiz eşliğinde modern tesislerimizde eğitim alarak futbol kariyerinizi şekillendirebilirsiniz.
                    </p>
                    <div class="youth-features mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="feature-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Profesyonel antrenör kadrosu</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="feature-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Modern antrenman tesisleri</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="feature-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Eğitim desteği programları</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="feature-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Kariyer gelişim fırsatları</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="youth-registration-actions">
                        <a href="' . BASE_URL . '/youth-registration" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-user-plus me-2"></i>
                            Hemen Başvur
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-info-circle me-2"></i>
                            Detaylı Bilgi
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="youth-registration-visual">
                    <div class="youth-stats-card">
                        <div class="stats-header mb-3">
                            <h4 class="stats-title">Alt Yapı İstatistikleri</h4>
                        </div>
                        <div class="stats-grid">
                            <div class="stat-item text-center mb-3">
                                <div class="stat-number">150+</div>
                                <div class="stat-label">Aktif Sporcu</div>
                            </div>
                            <div class="stat-item text-center mb-3">
                                <div class="stat-number">12</div>
                                <div class="stat-label">Yaş Kategorisi</div>
                            </div>
                            <div class="stat-item text-center mb-3">
                                <div class="stat-number">25+</div>
                                <div class="stat-label">Profesyonel Antrenör</div>
                            </div>
                            <div class="stat-item text-center">
                                <div class="stat-number">8</div>
                                <div class="stat-label">Modern Saha</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- Youth Academy Registration Section -->


<!-- Include Match Calendar JavaScript -->
<script src="/js/match-calendar.js"></script>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>