<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">GRUPLARIMIZ</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Gruplarımız</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Academy Info -->
<section class="academy-info py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <h2 class="section-title">GENÇLİK AKADEMİSİ</h2>
                <p class="lead">Geleceğin yıldızlarını yetiştiren akademimizde, profesyonel futbol eğitimi veriyoruz.</p>
                <p>Deneyimli antrenörlerimiz ve modern tesislerimizle, genç oyuncularımızın hem fiziksel hem de mental gelişimlerine odaklanıyoruz. Futbol becerilerinin yanı sıra disiplin, takım çalışması ve spor ahlakı değerlerini de öğretiyoruz.</p>
                <div class="academy-features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Profesyonel antrenör kadrosu</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Modern spor tesisleri</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Bireysel gelişim programları</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="academy-image">
                    <img src="' . BASE_URL . '/public/images/academy-training.jpg" 
                         alt="Akademi Antrenmanı" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Age Groups -->
<section class="age-groups py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">YAŞ GRUPLARI</h2>
        <div class="row">
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="group-card">
                    <div class="group-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3 class="group-title">U-10</h3>
                    <div class="group-info">
                        <p><strong>Yaş:</strong> 8-10</p>
                        <p><strong>Antrenman:</strong> Hafta 2 gün</p>
                        <p><strong>Süre:</strong> 60 dakika</p>
                        <p><strong>Odak:</strong> Temel beceriler</p>
                    </div>
                    <p class="group-description">
                        Futbol sevgisini aşılayan ve temel motor becerileri geliştiren grup.
                    </p>
                    <a href="' . BASE_URL . '/groups/details/1" class="btn btn-outline-primary">Detaylar</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="group-card">
                    <div class="group-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="group-title">U-12</h3>
                    <div class="group-info">
                        <p><strong>Yaş:</strong> 10-12</p>
                        <p><strong>Antrenman:</strong> Hafta 3 gün</p>
                        <p><strong>Süre:</strong> 75 dakika</p>
                        <p><strong>Odak:</strong> Teknik gelişim</p>
                    </div>
                    <p class="group-description">
                        Futbol becerilerini geliştiren ve takım oyununu öğrenen grup.
                    </p>
                    <a href="' . BASE_URL . '/groups/details/2" class="btn btn-outline-primary">Detaylar</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="group-card">
                    <div class="group-icon">
                        <i class="fas fa-running"></i>
                    </div>
                    <h3 class="group-title">U-14</h3>
                    <div class="group-info">
                        <p><strong>Yaş:</strong> 12-14</p>
                        <p><strong>Antrenman:</strong> Hafta 3 gün</p>
                        <p><strong>Süre:</strong> 90 dakika</p>
                        <p><strong>Odak:</strong> Taktik anlayış</p>
                    </div>
                    <p class="group-description">
                        Taktik bilgisini artıran ve fiziksel gelişimi destekleyen grup.
                    </p>
                    <a href="' . BASE_URL . '/groups/details/3" class="btn btn-outline-primary">Detaylar</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="group-card">
                    <div class="group-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3 class="group-title">U-16</h3>
                    <div class="group-info">
                        <p><strong>Yaş:</strong> 14-16</p>
                        <p><strong>Antrenman:</strong> Hafta 4 gün</p>
                        <p><strong>Süre:</strong> 90 dakika</p>
                        <p><strong>Odak:</strong> Profesyonel hazırlık</p>
                    </div>
                    <p class="group-description">
                        Profesyonel futbola hazırlanan ve yetenek geliştiren grup.
                    </p>
                    <a href="' . BASE_URL . '/groups/details/4" class="btn btn-outline-primary">Detaylar</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="group-card">
                    <div class="group-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3 class="group-title">U-18</h3>
                    <div class="group-info">
                        <p><strong>Yaş:</strong> 16-18</p>
                        <p><strong>Antrenman:</strong> Hafta 5 gün</p>
                        <p><strong>Süre:</strong> 120 dakika</p>
                        <p><strong>Odak:</strong> Elite seviye</p>
                    </div>
                    <p class="group-description">
                        A takımına geçiş için hazırlanan ve elite seviye eğitim alan grup.
                    </p>
                    <a href="' . BASE_URL . '/groups/details/5" class="btn btn-outline-primary">Detaylar</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="group-card">
                    <div class="group-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="group-title">Kız Futbolu</h3>
                    <div class="group-info">
                        <p><strong>Yaş:</strong> 10-16</p>
                        <p><strong>Antrenman:</strong> Hafta 3 gün</p>
                        <p><strong>Süre:</strong> 75 dakika</p>
                        <p><strong>Odak:</strong> Kadın futbolu</p>
                    </div>
                    <p class="group-description">
                        Kız çocukları için özel olarak tasarlanmış futbol programı.
                    </p>
                    <a href="' . BASE_URL . '/groups/details/6" class="btn btn-outline-primary">Detaylar</a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Enrollment Info -->
<section class="enrollment-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-title mb-4">KAYIT BİLGİLERİ</h2>
                <p class="lead mb-4">
                    Akademimize katılmak ve futbol yolculuğuna başlamak için bizimle iletişime geçin.
                </p>
                <div class="enrollment-info">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <i class="fas fa-calendar-alt text-primary"></i>
                                <h5>Kayıt Dönemi</h5>
                                <p>Haziran - Ağustos</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <i class="fas fa-file-alt text-warning"></i>
                                <h5>Gerekli Belgeler</h5>
                                <p>Sağlık raporu, Doğum belgesi</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <i class="fas fa-phone text-success"></i>
                                <h5>İletişim</h5>
                                <p>+90 (212) 123 45 67</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="' . BASE_URL . '/home/contact" class="btn btn-primary btn-lg">
                        <i class="fas fa-envelope me-2"></i>
                        İletişime Geç
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>