<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">KULLANIM ŞARTLARI</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Kullanım Şartları</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Terms Content -->
<section class="legal-content py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="legal-document">
                    <div class="legal-section">
                        <h2>1. Genel Hükümler</h2>
                        <p>Bu kullanım şartları, Spor Kulübü web sitesini kullanan tüm ziyaretçiler için geçerlidir. Siteyi kullanarak bu şartları kabul etmiş sayılırsınız.</p>
                    </div>

                    <div class="legal-section">
                        <h2>2. Site Kullanımı</h2>
                        <p>Web sitemizi aşağıdaki kurallara uygun olarak kullanmalısıniz:</p>
                        <ul>
                            <li>Yasalara ve düzenlemelere uygun kullanım</li>
                            <li>Başkalarının haklarına saygı gösterme</li>
                            <li>Site güvenliğini tehlikeye atmama</li>
                            <li>Uygunsuz içerik paylaşmama</li>
                            <li>Telif haklarına saygı gösterme</li>
                        </ul>
                    </div>

                    <div class="legal-section">
                        <h2>3. İçerik ve Telif Hakları</h2>
                        <p>Web sitesindeki tüm içerik (metin, görsel, logo, tasarım) Spor Kulübü\'ne aittir veya kullanım lisansına sahiptir. İzinsiz kullanım yasaktır.</p>
                    </div>

                    <div class="legal-section">
                        <h2>4. Yasaklı Faaliyetler</h2>
                        <p>Aşağıdaki faaliyetler kesinlikle yasaktır:</p>
                        <ul>
                            <li>Spam veya istenmeyen e-posta gönderme</li>
                            <li>Virüs veya zararlı yazılım yayma</li>
                            <li>Başkalarının hesaplarını ele geçirme</li>
                            <li>Yanıltıcı bilgi paylaşma</li>
                            <li>Ticari amaçlı izinsiz kullanım</li>
                        </ul>
                    </div>

                    <div class="legal-section">
                        <h2>5. Sorumluluk Reddi</h2>
                        <p>Spor Kulübü, web sitesinin kullanımından doğabilecek zararlardan sorumlu değildir. Site kesintisiz ve hatasız çalışacağına dair garanti verilmez.</p>
                    </div>

                    <div class="legal-section">
                        <h2>6. Gizlilik</h2>
                        <p>Kişisel verilerinizin işlenmesi hakkında detaylı bilgi için Gizlilik Politikamızı inceleyebilirsiniz.</p>
                    </div>

                    <div class="legal-section">
                        <h2>7. Değişiklikler</h2>
                        <p>Bu kullanım şartları önceden haber verilmeksizin değiştirilebilir. Güncel şartlar web sitemizde yayınlanacaktır.</p>
                    </div>

                    <div class="legal-section">
                        <h2>8. Uygulanacak Hukuk</h2>
                        <p>Bu şartlar Türkiye Cumhuriyeti kanunlarına tabidir. Anlaşmazlıklar İstanbul mahkemelerinde çözümlenecektir.</p>
                    </div>

                    <div class="legal-section">
                        <h2>9. İletişim</h2>
                        <p>Kullanım şartları hakkında sorularınız için:</p>
                        <div class="contact-info">
                            <p><strong>E-posta:</strong> info@sporkulubu.com</p>
                            <p><strong>Telefon:</strong> +90 (212) 555-0123</p>
                            <p><strong>Adres:</strong> Spor Caddesi No:123, İstanbul</p>
                        </div>
                        <p><strong>Son Güncelleme:</strong> ' . date('d.m.Y') . '</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>