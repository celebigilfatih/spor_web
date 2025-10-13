<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">İLETİŞİM</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">İletişim</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8 mb-5">
                <div class="contact-form-card">
                    <h2 class="section-title mb-4">BİZE ULAŞIN</h2>
                    
                    ' . (!empty($message) ? '<div class="alert alert-success">' . $message . '</div>' : '') . '
                    ' . (!empty($error) ? '<div class="alert alert-danger">' . $error . '</div>' : '') . '
                    
                    <form method="POST" action="' . BASE_URL . '/home/contact">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Adınız Soyadınız *</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="' . ($_POST['name'] ?? '') . '" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">E-posta Adresiniz *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="' . ($_POST['email'] ?? '') . '" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Konu *</label>
                            <input type="text" class="form-control" id="subject" name="subject" 
                                   value="' . ($_POST['subject'] ?? '') . '" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Mesajınız *</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required>' . ($_POST['message'] ?? '') . '</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>
                            Mesajı Gönder
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-4">
                <div class="contact-info-card">
                    <h3 class="widget-title mb-4">İLETİŞİM BİLGİLERİ</h3>
                    
                    <div class="contact-item mb-4">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Adres</h5>
                            <p>Spor Kulübü Binası<br>
                            İstanbul, Türkiye 34000</p>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Telefon</h5>
                            <p>+90 (212) 123 45 67<br>
                            +90 (212) 123 45 68</p>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h5>E-posta</h5>
                            <p>info@sporkulubu.com<br>
                            iletisim@sporkulubu.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Çalışma Saatleri</h5>
                            <p>Pazartesi - Cuma: 09:00 - 18:00<br>
                            Cumartesi: 09:00 - 15:00<br>
                            Pazar: Kapalı</p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="social-media-card mt-4">
                    <h3 class="widget-title mb-4">SOSYAL MEDYA</h3>
                    <div class="social-links-large">
                        <a href="#" class="social-link-large facebook">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="#" class="social-link-large twitter">
                            <i class="fab fa-twitter"></i>
                            <span>Twitter</span>
                        </a>
                        <a href="#" class="social-link-large instagram">
                            <i class="fab fa-instagram"></i>
                            <span>Instagram</span>
                        </a>
                        <a href="#" class="social-link-large youtube">
                            <i class="fab fa-youtube"></i>
                            <span>YouTube</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container-fluid p-0">
        <div class="map-placeholder">
            <div class="map-overlay">
                <div class="map-info">
                    <h4>Tesislerimiz</h4>
                    <p>Modern tesislerimizde sizleri ağırlamaktan mutluluk duyarız.</p>
                    <button class="btn btn-warning" onclick="alert(\'Harita özelliği yakında aktif olacak!\')">
                        <i class="fas fa-directions me-2"></i>
                        Yol Tarifi Al
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>