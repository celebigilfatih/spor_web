<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">GİZLİLİK POLİTİKASI</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Gizlilik Politikası</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Privacy Policy Content -->
<section class="legal-content py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="legal-document">
                    <div class="legal-section">
                        <h2>1. Giriş</h2>
                        <p>Bu Gizlilik Politikası, Spor Kulübü ("biz", "bizim" veya "kulüp") tarafından işletilen web sitesinde kişisel verilerinizin nasıl toplandığı, kullanıldığı ve korunduğu hakkında bilgi vermektedir.</p>
                    </div>

                    <div class="legal-section">
                        <h2>2. Toplanan Bilgiler</h2>
                        <p>Web sitemizi ziyaret ettiğinizde aşağıdaki bilgiler toplanabilir:</p>
                        <ul>
                            <li>İletişim bilgileri (ad, e-posta adresi, telefon numarası)</li>
                            <li>Web sitesi kullanım bilgileri</li>
                            <li>Çerez ve benzeri teknolojiler aracılığıyla toplanan bilgiler</li>
                            <li>IP adresi ve tarayıcı bilgileri</li>
                        </ul>
                    </div>

                    <div class="legal-section">
                        <h2>3. Bilgilerin Kullanımı</h2>
                        <p>Toplanan kişisel verileriniz şu amaçlarla kullanılmaktadır:</p>
                        <ul>
                            <li>Size daha iyi hizmet sunmak</li>
                            <li>İletişim taleplerini yanıtlamak</li>
                            <li>Web sitesini geliştirmek ve kişiselleştirmek</li>
                            <li>Yasal yükümlülükleri yerine getirmek</li>
                            <li>Güvenlik ve dolandırıcılık önleme</li>
                        </ul>
                    </div>

                    <div class="legal-section">
                        <h2>4. Bilgi Paylaşımı</h2>
                        <p>Kişisel verileriniz aşağıdaki durumlar dışında üçüncü taraflarla paylaşılmaz:</p>
                        <ul>
                            <li>Yasal zorunluluklar</li>
                            <li>Açık rızanız olması</li>
                            <li>Hizmet sağlayıcılarımızla sınırlı paylaşım</li>
                            <li>Güvenlik ve yasal koruma gerekliliği</li>
                        </ul>
                    </div>

                    <div class="legal-section">
                        <h2>5. Çerezler</h2>
                        <p>Web sitemizde çerezler kullanılmaktadır. Çerezler, web sitesinin işlevselliğini artırmak ve kullanıcı deneyimini iyileştirmek amacıyla kullanılır. Tarayıcı ayarlarından çerezleri devre dışı bırakabilirsiniz.</p>
                    </div>

                    <div class="legal-section">
                        <h2>6. Veri Güvenliği</h2>
                        <p>Kişisel verilerinizin güvenliği bizim için önemlidir. Uygun teknik ve organizasyonel önlemler alarak verilerinizi korumaya çalışıyoruz. Ancak, internet üzerinden veri iletiminin %100 güvenli olmadığını unutmayın.</p>
                    </div>

                    <div class="legal-section">
                        <h2>7. Haklarınız</h2>
                        <p>KVKK kapsamında aşağıdaki haklara sahipsiniz:</p>
                        <ul>
                            <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
                            <li>İşlenen verileriniz hakkında bilgi talep etme</li>
                            <li>Düzeltme veya silme talep etme</li>
                            <li>İşlemeye itiraz etme</li>
                            <li>Veri taşınabilirliği</li>
                        </ul>
                    </div>

                    <div class="legal-section">
                        <h2>8. İletişim</h2>
                        <p>Gizlilik politikası hakkında sorularınız için bizimle iletişime geçebilirsiniz:</p>
                        <div class="contact-info">
                            <p><strong>E-posta:</strong> info@sporkulubu.com</p>
                            <p><strong>Telefon:</strong> +90 (212) 555-0123</p>
                            <p><strong>Adres:</strong> Spor Caddesi No:123, İstanbul</p>
                        </div>
                    </div>

                    <div class="legal-section">
                        <h2>9. Güncellemeler</h2>
                        <p>Bu gizlilik politikası zaman zaman güncellenebilir. Önemli değişiklikler web sitemizde duyurulacaktır.</p>
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