<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">BAŞARILARIMIZ</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/about" class="text-warning">Hakkımızda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Başarılar</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Trophy Cabinet -->
<section class="trophy-cabinet py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">KUPA VİTRİNİMİZ</h2>
        
        <div class="row">
            <!-- League Championships -->
            <div class="col-lg-4 mb-5">
                <div class="trophy-category">
                    <div class="trophy-icon">
                        <i class="fas fa-trophy text-warning"></i>
                    </div>
                    <h3 class="trophy-title">LİG ŞAMPİYONLUKLARI</h3>
                    <div class="trophy-count">15</div>
                    <div class="trophy-years">
                        <span class="year-badge">1952</span>
                        <span class="year-badge">1967</span>
                        <span class="year-badge">1973</span>
                        <span class="year-badge">1985</span>
                        <span class="year-badge">1992</span>
                        <span class="year-badge">1998</span>
                        <span class="year-badge">2003</span>
                        <span class="year-badge">2007</span>
                        <span class="year-badge">2012</span>
                        <span class="year-badge">2018</span>
                        <span class="year-badge">2021</span>
                        <span class="year-badge">2022</span>
                        <span class="year-badge">2023</span>
                        <span class="year-badge">2024</span>
                        <span class="year-badge">2025</span>
                    </div>
                </div>
            </div>

            <!-- Cup Victories -->
            <div class="col-lg-4 mb-5">
                <div class="trophy-category">
                    <div class="trophy-icon">
                        <i class="fas fa-medal text-primary"></i>
                    </div>
                    <h3 class="trophy-title">KUPA ZAFERLERİ</h3>
                    <div class="trophy-count">8</div>
                    <div class="trophy-years">
                        <span class="year-badge">1965</span>
                        <span class="year-badge">1978</span>
                        <span class="year-badge">1987</span>
                        <span class="year-badge">1995</span>
                        <span class="year-badge">2005</span>
                        <span class="year-badge">2015</span>
                        <span class="year-badge">2020</span>
                        <span class="year-badge">2023</span>
                    </div>
                </div>
            </div>

            <!-- International Success -->
            <div class="col-lg-4 mb-5">
                <div class="trophy-category">
                    <div class="trophy-icon">
                        <i class="fas fa-globe text-success"></i>
                    </div>
                    <h3 class="trophy-title">ULUSLARARASI BAŞARI</h3>
                    <div class="trophy-count">2</div>
                    <div class="trophy-years">
                        <span class="year-badge">1995</span>
                        <span class="year-badge">2018</span>
                    </div>
                    <p class="trophy-description">
                        Avrupa kupalarında çeyrek final başarısı
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Notable Achievements -->
<section class="notable-achievements py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">ÖNEMLİ BAŞARILAR</h2>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="achievement-content">
                        <h4>En Uzun Galibiyet Serisi</h4>
                        <p class="achievement-stat">18 Maç</p>
                        <p>2022-2023 sezonunda elde ettiğimiz tarihi galibiyet serisi</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-futbol text-primary"></i>
                    </div>
                    <div class="achievement-content">
                        <h4>En Çok Gol Atılan Sezon</h4>
                        <p class="achievement-stat">95 Gol</p>
                        <p>2021-2022 sezonunda lig tarihinde rekor kırdık</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-shield-alt text-success"></i>
                    </div>
                    <div class="achievement-content">
                        <h4>En Az Gol Yenilen Sezon</h4>
                        <p class="achievement-stat">12 Gol</p>
                        <p>Savunma rekorumuz 2020-2021 sezonunda elde edildi</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-users text-info"></i>
                    </div>
                    <div class="achievement-content">
                        <h4>Milli Takım Oyuncuları</h4>
                        <p class="achievement-stat">200+</p>
                        <p>Kulübümüzden çıkan milli takım oyuncusu sayısı</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hall of Fame -->
<section class="hall-of-fame py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">ŞÖHRETLER GALERİSİ</h2>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="legend-card">
                    <div class="legend-photo">
                        <img src="' . BASE_URL . '/public/images/legends/legend1.jpg" 
                             alt="Efsane Oyuncu 1" class="img-fluid rounded-circle">
                    </div>
                    <div class="legend-info">
                        <h4>Mehmet YILDIZ</h4>
                        <p class="legend-position">Forvet</p>
                        <p class="legend-years">1975-1988</p>
                        <div class="legend-stats">
                            <span class="stat">312 Maç</span>
                            <span class="stat">158 Gol</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="legend-card">
                    <div class="legend-photo">
                        <img src="' . BASE_URL . '/public/images/legends/legend2.jpg" 
                             alt="Efsane Oyuncu 2" class="img-fluid rounded-circle">
                    </div>
                    <div class="legend-info">
                        <h4>Ali KAYA</h4>
                        <p class="legend-position">Kaleci</p>
                        <p class="legend-years">1982-1998</p>
                        <div class="legend-stats">
                            <span class="stat">425 Maç</span>
                            <span class="stat">180 Temiz Çık</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="legend-card">
                    <div class="legend-photo">
                        <img src="' . BASE_URL . '/public/images/legends/legend3.jpg" 
                             alt="Efsane Oyuncu 3" class="img-fluid rounded-circle">
                    </div>
                    <div class="legend-info">
                        <h4>Fatih DEMİR</h4>
                        <p class="legend-position">Orta Saha</p>
                        <p class="legend-years">1990-2005</p>
                        <div class="legend-stats">
                            <span class="stat">398 Maç</span>
                            <span class="stat">89 Gol</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="legend-card">
                    <div class="legend-photo">
                        <img src="' . BASE_URL . '/public/images/legends/legend4.jpg" 
                             alt="Efsane Oyuncu 4" class="img-fluid rounded-circle">
                    </div>
                    <div class="legend-info">
                        <h4>Serkan ASLAN</h4>
                        <p class="legend-position">Defans</p>
                        <p class="legend-years">1995-2010</p>
                        <div class="legend-stats">
                            <span class="stat">367 Maç</span>
                            <span class="stat">23 Gol</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Records Section -->
<section class="records-section py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">KULÜP REKORLARİ</h2>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="record-item">
                    <div class="record-icon">
                        <i class="fas fa-bullseye text-danger"></i>
                    </div>
                    <div class="record-content">
                        <h4>En Çok Gol Atan Oyuncu</h4>
                        <p class="record-holder">Mehmet YILDIZ</p>
                        <p class="record-value">158 Gol</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="record-item">
                    <div class="record-icon">
                        <i class="fas fa-hand-paper text-warning"></i>
                    </div>
                    <div class="record-content">
                        <h4>En Çok Maça Çıkan Kaleci</h4>
                        <p class="record-holder">Ali KAYA</p>
                        <p class="record-value">425 Maç</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="record-item">
                    <div class="record-icon">
                        <i class="fas fa-running text-success"></i>
                    </div>
                    <div class="record-content">
                        <h4>En Çok Maça Çıkan Oyuncu</h4>
                        <p class="record-holder">Fatih DEMİR</p>
                        <p class="record-value">398 Maç</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="record-item">
                    <div class="record-icon">
                        <i class="fas fa-trophy text-primary"></i>
                    </div>
                    <div class="record-content">
                        <h4>En Başarılı Kaptan</h4>
                        <p class="record-holder">Serkan ASLAN</p>
                        <p class="record-value">8 Kupa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>