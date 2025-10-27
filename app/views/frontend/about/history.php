<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">KULÜP TARİHİ</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/hakkimizda" class="text-warning">Hakkımızda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Tarihçe</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Timeline Section -->
<section class="history-timeline py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title text-center mb-5">95 YILLIK TARİHİMİZ</h2>
                
                <!-- Timeline -->
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">1928</div>
                        <div class="timeline-content">
                            <h3>Kulübün Kuruluşu</h3>
                            <p>Spor Kulübü, futbol sevdalısı gençler tarafından İstanbul\'da kuruldu. İlk başkan Mehmet Bey olarak görev yaptı.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">1935</div>
                        <div class="timeline-content">
                            <h3>İlk Stadyum</h3>
                            <p>Kulübümüzün ilk resmi stadyumu açıldı. 5.000 kişi kapasiteli bu stadyum uzun yıllar evimiz oldu.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">1952</div>
                        <div class="timeline-content">
                            <h3>İlk Şampiyonluk</h3>
                            <p>Kulüp tarihinin ilk büyük başarısı olan şehir şampiyonluğunu kazandık. Bu başarı kulübümüzün yükselişinin başlangıcı oldu.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">1967</div>
                        <div class="timeline-content">
                            <h3>Profesyonel Liga Katılım</h3>
                            <p>Türkiye profesyonel futbol ligine katılarak büyük kulüpler arasındaki yerimizi aldık.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">1978</div>
                        <div class="timeline-content">
                            <h3>Modern Tesis</h3>
                            <p>Günümüzdeki modern tesislerimizin temeli atıldı. Antrenman sahaları ve gençlik akademisi kuruldu.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">1995</div>
                        <div class="timeline-content">
                            <h3>Avrupa Kupalarında</h3>
                            <p>İlk kez Avrupa kupalarında mücadele etme hakkı kazandık ve uluslararası arenada adımızı duyurduk.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">2010</div>
                        <div class="timeline-content">
                            <h3>Gençlik Akademisi Yenilendi</h3>
                            <p>Modern gençlik akademimiz yenilendi ve Türkiye\'nin en iyi gençlik merkezlerinden biri haline geldi.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">2023</div>
                        <div class="timeline-content">
                            <h3>95. Yıl Kutlamaları</h3>
                            <p>Kulübümüzün 95. kuruluş yıldönümünü büyük bir coşkuyla kutladık ve geleceğe umutla bakıyoruz.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Historical Stats -->
<section class="historical-stats py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">TARİHİ İSTATİSTİKLER</h2>
        <div class="row">
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-calendar text-primary"></i>
                    </div>
                    <h3 class="stat-number">95</h3>
                    <p class="stat-label">Yıllık Tecrübe</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-trophy text-warning"></i>
                    </div>
                    <h3 class="stat-number">25</h3>
                    <p class="stat-label">Şampiyonluk</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-users text-success"></i>
                    </div>
                    <h3 class="stat-number">1500+</h3>
                    <p class="stat-label">Yetişen Oyuncu</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-medal text-info"></i>
                    </div>
                    <h3 class="stat-number">200+</h3>
                    <p class="stat-label">Milli Sporcu</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Historical Photos -->
<section class="historical-photos py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">TARİHİ FOTOĞRAFLAR</h2>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="photo-card">
                    <img src="' . BASE_URL . '/public/images/history/1928-foundation.jpg" 
                         alt="1928 Kuruluş" class="img-fluid rounded">
                    <div class="photo-caption">
                        <h5>1928 - Kuruluş</h5>
                        <p>Kulübümüzün kuruluş töreni</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="photo-card">
                    <img src="' . BASE_URL . '/public/images/history/1952-championship.jpg" 
                         alt="1952 Şampiyonluk" class="img-fluid rounded">
                    <div class="photo-caption">
                        <h5>1952 - İlk Şampiyonluk</h5>
                        <p>Tarihi şampiyonluk kupası</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="photo-card">
                    <img src="' . BASE_URL . '/public/images/history/1995-europe.jpg" 
                         alt="1995 Avrupa" class="img-fluid rounded">
                    <div class="photo-caption">
                        <h5>1995 - Avrupa Kupası</h5>
                        <p>İlk Avrupa macerası</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>