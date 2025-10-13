<?php
$content = '
<!-- Hero Section / Modern Slider -->
<section class="modern-hero-section">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Main Slider Content -->
            <div class="col-lg-8">
                <div id="modernSlider" class="carousel slide h-100 px-5" data-bs-ride="carousel">
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
                <div class="hero-sidebar h-100 p-4">
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
                                    <div class="post-image">
                                        <img src="/uploads/default-news.jpg" alt="Antrenman" class="img-fluid rounded">
                                    </div>
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
                    
                    <!-- Announcements -->
                    <div class="announcements-card">
                        <div class="card-header d-flex align-items-center mb-3">
                            <i class="fas fa-bullhorn text-warning me-2 fs-4"></i>
                            <h3 class="card-title mb-0">Duyurular</h3>
                            <a href="#" class="ms-auto text-primary small">Tümünü Gör</a>
                        </div>
                        <div class="announcements-list">
                            <div class="announcement-item mb-3 p-3 bg-light rounded">
                                <div class="announcement-badge mb-2">
                                    <span class="badge bg-danger">ÖNEMLİ</span>
                                    <span class="text-muted small ms-2">20 Ekim 2024</span>
                                </div>
                                <h5 class="announcement-title mb-2">Maç Bilet Satışları</h5>
                                <p class="announcement-text mb-0 small">Galatasaray derbisi biletleri yarın saat 10:00\'da satışa çıkacaktır. Üye önceliği uygulanacaktır.</p>
                            </div>
                            
                            <div class="announcement-item mb-3 p-3 bg-light rounded">
                                <div class="announcement-badge mb-2">
                                    <span class="badge bg-info">BİLGİ</span>
                                    <span class="text-muted small ms-2">18 Ekim 2024</span>
                                </div>
                                <h5 class="announcement-title mb-2">Antrenman Saatleri</h5>
                                <p class="announcement-text mb-0 small">Bu hafta antrenmanlarımız saat 16:00\'da başlayacaktır. Taraftarlarımız izleyebilir.</p>
                            </div>
                            
                            <div class="announcement-item p-3 bg-light rounded">
                                <div class="announcement-badge mb-2">
                                    <span class="badge bg-success">ETKİNLİK</span>
                                    <span class="text-muted small ms-2">15 Ekim 2024</span>
                                </div>
                                <h5 class="announcement-title mb-2">Taraftar Buluşması</h5>
                                <p class="announcement-text mb-0 small">25 Ekim Cuma günü saat 19:00\'da kulüp lokalinde taraftar buluşması düzenlenecektir.</p>
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
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header mb-4">
                    <h2 class="section-title">MAÇ TAKVİMİ</h2>
                    <a href="' . BASE_URL . '/ateam/fixtures" class="btn btn-outline-primary">Tüm Maçlar</a>
                </div>
            </div>
        </div>
        
        <!-- Horizontal Match Calendar -->
        <div class="horizontal-match-calendar">
            <div class="match-calendar-nav">
                <button class="nav-btn prev-btn" onclick="scrollMatches(\'left\')">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="nav-filters">
                    <button class="filter-btn active" data-filter="all">Tüm Maçlar</button>
                    <button class="filter-btn" data-filter="upcoming">Yaklaşan</button>
                    <button class="filter-btn" data-filter="finished">Tamamlanan</button>
                </div>
                <button class="nav-btn next-btn" onclick="scrollMatches(\'right\')">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <div class="matches-horizontal-container">
                <div class="matches-horizontal-scroll" id="matchesScroll">
                    <!-- Sample Upcoming Matches -->
                    <div class="horizontal-match-card upcoming" data-type="upcoming">
                        <div class="match-status-indicator">
                            <span class="status-dot upcoming"></span>
                            <span class="status-text">Yaklaşan</span>
                        </div>
                        <div class="match-date-section">
                            <div class="match-day">25</div>
                            <div class="match-month">Ekim</div>
                        </div>
                        <div class="match-time-section">
                            <div class="match-time">20:45</div>
                        </div>
                        <div class="teams-section">
                            <div class="team home-team">
                                <div class="team-logo">
                                    <img src="/uploads/team-logos/fenerbahce.svg" alt="Fenerbahçe" onerror="this.src=\'/uploads/team-logos/default.svg\'">
                                </div>
                                <div class="team-name">Fenerbahçe</div>
                            </div>
                            <div class="vs-section">
                                <div class="vs-text">VS</div>
                            </div>
                            <div class="team away-team">
                                <div class="team-logo">
                                    <img src="/uploads/team-logos/galatasaray.svg" alt="Galatasaray" onerror="this.src=\'/uploads/team-logos/default.svg\'">
                                </div>
                                <div class="team-name">Galatasaray</div>
                            </div>
                        </div>
                        <div class="match-venue-section">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Şükrü Saraçoğlu Stadyumu</span>
                        </div>
                    </div>
                    
                    <div class="horizontal-match-card upcoming" data-type="upcoming">
                        <div class="match-status-indicator">
                            <span class="status-dot upcoming"></span>
                            <span class="status-text">Yaklaşan</span>
                        </div>
                        <div class="match-date-section">
                            <div class="match-day">30</div>
                            <div class="match-month">Ekim</div>
                        </div>
                        <div class="match-time-section">
                            <div class="match-time">19:00</div>
                        </div>
                        <div class="teams-section">
                            <div class="team home-team">
                                <div class="team-logo">
                                    <img src="/uploads/team-logos/besiktas.svg" alt="Beşiktaş" onerror="this.src=\'/uploads/team-logos/default.svg\'">
                                </div>
                                <div class="team-name">Beşiktaş</div>
                            </div>
                            <div class="vs-section">
                                <div class="vs-text">VS</div>
                            </div>
                            <div class="team away-team">
                                <div class="team-logo">
                                    <img src="/uploads/team-logos/fenerbahce.svg" alt="Fenerbahçe" onerror="this.src=\'/uploads/team-logos/default.svg\'">
                                </div>
                                <div class="team-name">Fenerbahçe</div>
                            </div>
                        </div>
                        <div class="match-venue-section">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Vodafone Park</span>
                        </div>
                    </div>
                    
                    <!-- Sample Finished Matches -->
                    <div class="horizontal-match-card finished" data-type="finished">
                        <div class="match-status-indicator">
                            <span class="status-dot finished"></span>
                            <span class="status-text">Tamamlandı</span>
                        </div>
                        <div class="match-date-section">
                            <div class="match-day">20</div>
                            <div class="match-month">Ekim</div>
                        </div>
                        <div class="match-score-section">
                            <div class="final-score">2 - 1</div>
                        </div>
                        <div class="teams-section">
                            <div class="team home-team">
                                <div class="team-logo">
                                    <img src="/uploads/team-logos/fenerbahce.svg" alt="Fenerbahçe" onerror="this.src=\'/uploads/team-logos/default.svg\'">
                                </div>
                                <div class="team-name">Fenerbahçe</div>
                            </div>
                            <div class="vs-section">
                                <div class="vs-text">VS</div>
                            </div>
                            <div class="team away-team">
                                <div class="team-logo">
                                    <img src="/uploads/team-logos/trabzonspor.svg" alt="Trabzonspor" onerror="this.src=\'/uploads/team-logos/default.svg\'">
                                </div>
                                <div class="team-name">Trabzonspor</div>
                            </div>
                        </div>
                        <div class="match-venue-section">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Şükrü Saraçoğlu Stadyumu</span>
                        </div>
                    </div>
                    
                    <div class="horizontal-match-card finished" data-type="finished">
                        <div class="match-status-indicator">
                            <span class="status-dot finished"></span>
                            <span class="status-text">Tamamlandı</span>
                        </div>
                        <div class="match-date-section">
                            <div class="match-day">15</div>
                            <div class="match-month">Ekim</div>
                        </div>
                        <div class="match-score-section">
                            <div class="final-score">3 - 0</div>
                        </div>
                        <div class="teams-section">
                            <div class="team home-team">
                                <div class="team-logo">
                                    <img src="/uploads/team-logos/basaksehir.svg" alt="Başakşehir" onerror="this.src=\'/uploads/team-logos/default.svg\'">
                                </div>
                                <div class="team-name">Başakşehir</div>
                            </div>
                            <div class="vs-section">
                                <div class="vs-text">VS</div>
                            </div>
                            <div class="team away-team">
                                <div class="team-logo">
                                    <img src="/uploads/team-logos/fenerbahce.svg" alt="Fenerbahçe" onerror="this.src=\'/uploads/team-logos/default.svg\'">
                                </div>
                                <div class="team-name">Fenerbahçe</div>
                            </div>
                        </div>
                        <div class="match-venue-section">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Başakşehir Fatih Terim Stadyumu</span>
                        </div>
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
            ' . (isset($news) && !empty($news) ? 
                implode('', array_map(function($article) {
                    return '
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card h-100">
                            <div class="news-image">
                                <img src="' . ($article['image'] ?? '/uploads/default-news.jpg') . '" alt="' . htmlspecialchars($article['title'] ?? 'Haber') . '" class="img-fluid">
                                <div class="news-category">' . htmlspecialchars($article['category'] ?? 'Genel') . '</div>
                            </div>
                            <div class="news-content">
                                <h3 class="news-title">' . htmlspecialchars($article['title'] ?? 'Haber Başlığı') . '</h3>
                                <p class="news-excerpt">' . htmlspecialchars(substr($article['content'] ?? 'Haber içeriği...', 0, 120)) . '...</p>
                                <div class="news-meta">
                                    <span class="news-date">' . date('d.m.Y', strtotime($article['created_at'] ?? 'now')) . '</span>
                                    <a href="' . BASE_URL . '/news/' . ($article['id'] ?? '#') . '" class="read-more">Devamını Oku</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }, array_slice($news, 0, 6))) : 
                '
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="news-card h-100">
                        <div class="news-image">
                            <img src="/uploads/default-news.jpg" alt="Haber" class="img-fluid">
                            <div class="news-category">Transfer</div>
                        </div>
                        <div class="news-content">
                            <h3 class="news-title">Yeni Transferimiz Takımımıza Katıldı</h3>
                            <p class="news-excerpt">Sezonun en önemli transferlerinden biri olan yeni oyuncumuz ilk antrenmanına çıktı...</p>
                            <div class="news-meta">
                                <span class="news-date">20.10.2024</span>
                                <a href="#" class="read-more">Devamını Oku</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="news-card h-100">
                        <div class="news-image">
                            <img src="/uploads/default-news.jpg" alt="Haber" class="img-fluid">
                            <div class="news-category">Maç</div>
                        </div>
                        <div class="news-content">
                            <h3 class="news-title">Galatasaray Derbisi Hazırlıkları</h3>
                            <p class="news-excerpt">Haftanın en önemli maçı için hazırlıklarımız devam ediyor. Teknik direktörümüz açıklamalarda bulundu...</p>
                            <div class="news-meta">
                                <span class="news-date">19.10.2024</span>
                                <a href="#" class="read-more">Devamını Oku</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="news-card h-100">
                        <div class="news-image">
                            <img src="/uploads/default-news.jpg" alt="Haber" class="img-fluid">
                            <div class="news-category">Antrenman</div>
                        </div>
                        <div class="news-content">
                            <h3 class="news-title">Antrenman Kampı Başladı</h3>
                            <p class="news-excerpt">Takımımız yeni sezon hazırlıkları kapsamında antrenman kampına başladı...</p>
                            <div class="news-meta">
                                <span class="news-date">18.10.2024</span>
                                <a href="#" class="read-more">Devamını Oku</a>
                            </div>
                        </div>
                    </div>
                </div>
                '
            ) . '
        </div>
    </div>
</section>

<!-- Include Match Calendar JavaScript -->
<script src="/js/match-calendar.js"></script>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>