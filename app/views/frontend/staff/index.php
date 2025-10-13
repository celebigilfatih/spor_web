<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">TEKNİK KADRO</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Teknik Kadro</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Head Coach Section -->
<section class="head-coach-section py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">BAŞ ANTRENÖR</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="head-coach-profile">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-4">
                            <div class="coach-photo">
                                <img src="' . BASE_URL . '/public/images/head-coach.jpg" 
                                     alt="Baş Antrenör" class="img-fluid rounded-circle">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="coach-info">
                                <h3 class="coach-name">Mehmet YILMAZ</h3>
                                <p class="coach-title">Baş Antrenör</p>
                                <div class="coach-details">
                                    <div class="detail-item">
                                        <strong>Yaş:</strong> 45
                                    </div>
                                    <div class="detail-item">
                                        <strong>Deneyim:</strong> 15 yıl
                                    </div>
                                    <div class="detail-item">
                                        <strong>Lisans:</strong> UEFA Pro Lisans
                                    </div>
                                    <div class="detail-item">
                                        <strong>Kulüpteki Süresi:</strong> 3 yıl
                                    </div>
                                </div>
                                <p class="coach-bio">
                                    Deneyimli antrenörümüz Mehmet Yılmaz, 15 yıllık antrenörlük kariyerinde birçok başarıya imza attı. UEFA Pro Lisansına sahip olan antrenörümüz, takım oyununu ve bireysel gelişimi harmanlayan modern futbol anlayışını benimser.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Coaching Staff -->
<section class="coaching-staff py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">ANTRENÖR KADROSU</h2>
        
        <!-- Assistant Coaches -->
        <div class="staff-category mb-5">
            <h3 class="category-title">
                <i class="fas fa-users text-primary"></i>
                Yardımcı Antrenörler
            </h3>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <img src="' . BASE_URL . '/public/images/assistant-coach-1.jpg" 
                                 alt="Yardımcı Antrenör" class="img-fluid rounded">
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">Ali DEMIR</h4>
                            <p class="staff-position">Yardımcı Antrenör</p>
                            <div class="staff-details">
                                <span class="experience">Deneyim: 12 yıl</span>
                                <span class="license">UEFA A Lisans</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <img src="' . BASE_URL . '/public/images/assistant-coach-2.jpg" 
                                 alt="Yardımcı Antrenör" class="img-fluid rounded">
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">Fatih ÖZKAN</h4>
                            <p class="staff-position">Yardımcı Antrenör</p>
                            <div class="staff-details">
                                <span class="experience">Deneyim: 8 yıl</span>
                                <span class="license">UEFA B Lisans</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Goalkeeping Coach -->
        <div class="staff-category mb-5">
            <h3 class="category-title">
                <i class="fas fa-hand-paper text-warning"></i>
                Kaleci Antrenörü
            </h3>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <img src="' . BASE_URL . '/public/images/goalkeeper-coach.jpg" 
                                 alt="Kaleci Antrenörü" class="img-fluid rounded">
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">Emre KAYA</h4>
                            <p class="staff-position">Kaleci Antrenörü</p>
                            <div class="staff-details">
                                <span class="experience">Deneyim: 10 yıl</span>
                                <span class="license">Kaleci Antrenörü Sertifikası</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fitness Coach -->
        <div class="staff-category mb-5">
            <h3 class="category-title">
                <i class="fas fa-dumbbell text-success"></i>
                Kondisyoner
            </h3>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <img src="' . BASE_URL . '/public/images/fitness-coach.jpg" 
                                 alt="Kondisyoner" class="img-fluid rounded">
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">Serkan AKIN</h4>
                            <p class="staff-position">Kondisyoner</p>
                            <div class="staff-details">
                                <span class="experience">Deneyim: 7 yıl</span>
                                <span class="license">Spor Bilimleri Uzmanı</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Staff -->
        <div class="staff-category mb-5">
            <h3 class="category-title">
                <i class="fas fa-medkit text-danger"></i>
                Sağlık Ekibi
            </h3>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <img src="' . BASE_URL . '/public/images/team-doctor.jpg" 
                                 alt="Takım Doktoru" class="img-fluid rounded">
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">Dr. Ahmet ARSLAN</h4>
                            <p class="staff-position">Takım Doktoru</p>
                            <div class="staff-details">
                                <span class="experience">Deneyim: 20 yıl</span>
                                <span class="license">Spor Hekimi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <img src="' . BASE_URL . '/public/images/physiotherapist.jpg" 
                                 alt="Fizyoterapist" class="img-fluid rounded">
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">Gizem YILDIZ</h4>
                            <p class="staff-position">Fizyoterapist</p>
                            <div class="staff-details">
                                <span class="experience">Deneyim: 8 yıl</span>
                                <span class="license">Fizyoterapist</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Philosophy Section -->
<section class="philosophy-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-title mb-4">ANTRENMAN FELSEFEMİZ</h2>
                <p class="lead mb-4">
                    Modern futbol anlayışını benimseyen teknik kadromuz, oyuncularımızın hem bireysel hem de takım halinde gelişimlerine odaklanır.
                </p>
                <div class="philosophy-points">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="philosophy-item">
                                <i class="fas fa-target text-primary"></i>
                                <h5>Hedef Odaklı</h5>
                                <p>Her oyuncumuz için bireysel hedefler belirler ve bu hedeflere ulaşmak için çalışırız.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="philosophy-item">
                                <i class="fas fa-brain text-warning"></i>
                                <h5>Mental Güçlendirme</h5>
                                <p>Fiziksel gelişimin yanı sıra mental dayanıklılığı da artırmaya odaklanırız.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="philosophy-item">
                                <i class="fas fa-hands-helping text-success"></i>
                                <h5>Takım Ruhu</h5>
                                <p>Bireysel yetenekleri takım başarısına dönüştüren antrenman metodları uygularız.</p>
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