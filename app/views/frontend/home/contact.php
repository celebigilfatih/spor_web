<?php
// Add custom CSS for FAQ Chatbot
$additional_css = '<link href="' . BASE_URL . '/css/faq-chatbot.css" rel="stylesheet">';

// Add custom JS for FAQ Chatbot
$scripts = ['faq-chatbot.js'];

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
            <!-- FAQ Chatbot -->
            <div class="col-lg-12 mb-5">
                <div class="faq-chatbot-card">
                    <div class="chatbot-header">
                        <div class="d-flex align-items-center">
                            <div class="chatbot-avatar me-3">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div>
                                <h2 class="section-title mb-1">SORU & CEVAP</h2>
                                <p class="text-muted mb-0">Sıkça sorulan soruları görüntüleyin veya soru arayın</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Box -->
                    <div class="chatbot-search mb-4">
                        <div class="search-input-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" 
                                   id="faqSearch" 
                                   class="form-control search-input" 
                                   placeholder="Sorunuzu yazın veya anahtar kelime girin...">
                            <button class="clear-search" id="clearSearch" style="display: none;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Chat Messages Container -->
                    <div class="chatbot-messages" id="chatbotMessages">
                        <!-- Welcome Message -->
                        <div class="message-bubble bot-message">
                            <div class="message-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="message-content">
                                <p>Merhaba! Size nasıl yardımcı olabilirim? Aşağıdaki kategorilerden birini seçebilir veya yukarıdaki arama kutusunu kullanabilirsiniz.</p>
                            </div>
                        </div>
                        
                        <!-- FAQ Categories -->
                        <div class="faq-categories" id="faqCategories">
                            <button class="category-btn" data-category="kayit">
                                <i class="fas fa-user-plus"></i>
                                <span>Kayıt & Üyelik</span>
                            </button>
                            <button class="category-btn" data-category="antrenman">
                                <i class="fas fa-running"></i>
                                <span>Antrenman</span>
                            </button>
                            <button class="category-btn" data-category="ucret">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Ücretler</span>
                            </button>
                            <button class="category-btn" data-category="genel">
                                <i class="fas fa-info-circle"></i>
                                <span>Genel Bilgiler</span>
                            </button>
                        </div>
                        
                        <!-- FAQ Items Container -->
                        <div class="faq-items" id="faqItems"></div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="chatbot-actions mt-4">
                        <button class="btn btn-outline-primary btn-sm" id="resetChat">
                            <i class="fas fa-redo me-2"></i>
                            Başa Dön
                        </button>
                        <div class="text-muted small mt-2">
                            <i class="fas fa-lightbulb me-1"></i>
                            İhtiyacınız olan bilgiyi bulamadınız mı? İletişim bilgilerimizden bize ulaşabilirsiniz.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
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
                    
                    <div class="contact-item">
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
            </div>
            <div class="col-lg-6">
                <div class="social-media-card">
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