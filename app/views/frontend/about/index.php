<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">HAKKIMIZDA</h1>
                <p class="lead">Kulübümüzün tarihi, misyonu ve vizyonu hakkında bilgi edinin</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="about-content py-5">
    <div class="container">

        <div class="row">
            <div class="col-lg-12 mb-5">
                <!-- Club Introduction -->
                <div class="content-section mb-5">
                    <h2 class="section-title mb-4">Kulübümüz</h2>
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <p class="lead">1929 yılında kurulan spor kulübümüz, Türkiye\'nin en köklü ve başarılı spor kuruluşlarından biridir.</p>
                            <p>95 yıllık geçmişimizde, binlerce gencin spor hayatına başlamasına vesile olmuş, çok sayıda milli sporcu yetiştirmiş ve ulusal ile uluslararası arenada önemli başarılara imza atmışız.</p>
                            <p>Modern tesislerimiz, deneyimli teknik kadromuz ve güçlü altyapımızla geleceğin yıldızlarını yetiştirmeye devam ediyoruz.</p>
                        </div>
                    </div>
                </div>



                <!-- Values -->
                <div class="content-section mb-5">
                    <h2 class="section-title mb-4">Değerlerimiz</h2>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="value-item text-center">
                                <i class="fas fa-handshake fa-3x text-primary mb-3"></i>
                                <h4>Dürüstlük</h4>
                                <p>Her alanda dürüst ve şeffaf olmayı ilke ediniyoruz.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="value-item text-center">
                                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                                <h4>Takım Ruhu</h4>
                                <p>Birlikte hareket etmenin gücüne inanıyoruz.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="value-item text-center">
                                <i class="fas fa-trophy fa-3x text-primary mb-3"></i>
                                <h4>Mükemmellik</h4>
                                <p>Her zaman en iyiyi hedefliyoruz.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Achievements Section -->
                ' . (isset($achievements) && !empty($achievements) ? 
                    '<div class="content-section">
                        <h2 class="section-title mb-4">Başarılarımız</h2>
                        <div class="achievements-list">
                            ' . implode('', array_map(function($achievement) {
                                return '
                                <div class="achievement-item">
                                    <div class="achievement-year">' . htmlspecialchars($achievement['year'] ?? '') . '</div>
                                    <div class="achievement-details">
                                        <h5>' . htmlspecialchars($achievement['title'] ?? '') . '</h5>
                                        <p>' . htmlspecialchars($achievement['description'] ?? '') . '</p>
                                    </div>
                                </div>';
                            }, $achievements)) . '
                        </div>
                    </div>' : 
                    '<div class="content-section">
                        <h2 class="section-title mb-4">Başarılarımız</h2>
                        <div class="achievements-list">
                            <div class="achievement-item">
                                <div class="achievement-year">2023</div>
                                <div class="achievement-details">
                                    <h5>Bölge Şampiyonluğu</h5>
                                    <p>U-18 takımımız bölge şampiyonluğunu kazandı</p>
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-year">2022</div>
                                <div class="achievement-details">
                                    <h5>Fair Play Ödülü</h5>
                                    <p>Federasyon tarafından fair play ödülüne layık görüldük</p>
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-year">2021</div>
                                <div class="achievement-details">
                                    <h5>Altyapı Başarı Ödülü</h5>
                                    <p>En başarılı altyapı kulübü ödülünü aldık</p>
                                </div>
                            </div>
                        </div>
                    </div>'
                ) . '
            </div>
        </div>
        <div class="row">
         <div class="col-lg-4">
                <!-- Quick Facts -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Hızlı Bilgiler</h3>
                    <ul class="quick-facts">
                        <li><i class="fas fa-calendar-alt text-warning me-2"></i><strong>Kuruluş:</strong> 1929</li>
                        <li><i class="fas fa-users text-warning me-2"></i><strong>Aktif Üye:</strong> 500+</li>
                        <li><i class="fas fa-trophy text-warning me-2"></i><strong>Şampiyonluk:</strong> 25+</li>
                        <li><i class="fas fa-medal text-warning me-2"></i><strong>Milli Sporcu:</strong> 150+</li>
                        <li><i class="fas fa-graduation-cap text-warning me-2"></i><strong>Mezun Sporcu:</strong> 2000+</li>
                    </ul>
                </div>
         </div>
         <div class="col-lg-4">
            <div class="sidebar-widget">
                    <h3 class="widget-title">İletişim Bilgileri</h3>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt text-warning"></i>
                            <div>
                                <strong>Adres:</strong><br>
                                Spor Caddesi No:123<br>
                                Beşiktaş, İstanbul
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone text-warning"></i>
                            <div>
                                <strong>Telefon:</strong><br>
                                +90 (212) 555-0123
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope text-warning"></i>
                            <div>
                                <strong>E-posta:</strong><br>
                                info@sporkulubu.com
                            </div>
                        </div>
3
                    </div>
                </div>
         </div>
         <div class="col-lg-4">
                <div class="sidebar-widget">
                    <h3 class="widget-title">Yönetim</h3>
                    <div class="leadership-list">
                        <div class="leader-item">
                            <img src="' . BASE_URL . '/public/images/president.jpg" alt="Başkan" class="leader-photo">
                            <div class="leader-info">
                                <h5>Ahmet Yılmaz</h5>
                                <p>Kulüp Başkanı</p>
                            </div>
                        </div>
                        <div class="leader-item">
                            <img src="' . BASE_URL . '/public/images/vice-president.jpg" alt="Başkan Yardımcısı" class="leader-photo">
                            <div class="leader-info">
                                <h5>Mehmet Demir</h5>
                                <p>Başkan Yardımcısı</p>
                            </div>
                        </div>
                    </div>
                </div>
         </div>
        </div>
    </div>
</section>

<style>
.mission-vision-card {
    text-align: center;
    padding: 30px 20px;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    height: 100%;
    transition: transform 0.3s ease;
}

.mission-vision-card:hover {
    transform: translateY(-5px);
}

.card-icon {
    margin-bottom: 20px;
}

.card-title {
    color: var(--primary-color);
    font-weight: bold;
    margin-bottom: 15px;
}

.value-item {
    padding: 20px;
    transition: transform 0.3s ease;
}

.value-item:hover {
    transform: translateY(-5px);
}

.achievement-item {
    display: flex;
    margin-bottom: 25px;
    padding: 20px;
    background: #f8fafc;
    border-radius: 10px;
    border-left: 4px solid var(--secondary-color);
}

.achievement-year {
    background: var(--primary-color);
    color: white;
    padding: 10px 15px;
    border-radius: 50px;
    font-weight: bold;
    margin-right: 20px;
    min-width: 80px;
    text-align: center;
}

.achievement-details h5 {
    color: var(--primary-color);
    font-weight: bold;
    margin-bottom: 5px;
}

.quick-facts {
    list-style: none;
    padding: 0;
}

.quick-facts li {
    padding: 10px 0;
    border-bottom: 1px solid #e5e7eb;
}

.quick-facts li:last-child {
    border-bottom: none;
}

.contact-item {
    display: flex;
    margin-bottom: 20px;
}

.contact-item i {
    margin-right: 15px;
    margin-top: 5px;
    font-size: 18px;
}

.leader-item {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.leader-photo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 15px;
}

.leader-info h5 {
    color: var(--primary-color);
    font-weight: bold;
    margin-bottom: 5px;
}

.leader-info p {
    color: var(--text-color);
    margin: 0;
    font-size: 14px;
}
</style>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>