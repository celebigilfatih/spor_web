<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-cog"></i> Site Ayarları</h1>
    <div class="admin-tabs">
        <a href="' . BASE_URL . '/admin/settings" class="tab-link active">Genel</a>
        <a href="' . BASE_URL . '/admin/settings/media" class="tab-link">Medya</a>
        <a href="' . BASE_URL . '/admin/settings/seo" class="tab-link">SEO</a>
        <a href="' . BASE_URL . '/admin/settings/maintenance" class="tab-link">Bakım</a>
    </div>
</div>

<!-- Mesaj ve Hata Bildirimleri -->';

if (!empty($message)) {
    $content .= '<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' . htmlspecialchars($message) . '</div>';
}

if (!empty($error)) {
    $content .= '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ' . htmlspecialchars($error) . '</div>';
}

$content .= '
<div class="admin-content-card">
    <form action="' . BASE_URL . '/admin/settings" method="POST" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="settings-section">
            <h3><i class="fas fa-image"></i> Logo ve Görseller</h3>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="site_logo" class="admin-form-label">
                            <i class="fas fa-file-image"></i> Site Logosu
                        </label>
                        <input type="file" 
                               id="site_logo" 
                               name="site_logo" 
                               class="admin-form-control" 
                               accept="image/jpeg,image/png,image/svg+xml">
                        <small class="form-text text-muted">Önerilen boyut: 200x50px (JPG, PNG, SVG)</small>
                        ' . (!empty($settings['site_logo']) ? '
                        <div class="mt-2">
                            <img src="' . BASE_URL . '/uploads/' . $settings['site_logo'] . '" alt="Mevcut Logo" style="max-height: 50px;">
                            <p class="text-muted small mt-1">Mevcut logo</p>
                        </div>
                        ' : '') . '
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="site_favicon" class="admin-form-label">
                            <i class="fas fa-bookmark"></i> Favicon
                        </label>
                        <input type="file" 
                               id="site_favicon" 
                               name="site_favicon" 
                               class="admin-form-control" 
                               accept="image/x-icon,image/png">
                        <small class="form-text text-muted">Favicon dosyası (ICO, PNG)</small>
                        ' . (!empty($settings['site_favicon']) ? '
                        <div class="mt-2">
                            <img src="' . BASE_URL . '/uploads/' . $settings['site_favicon'] . '" alt="Mevcut Favicon" style="max-height: 32px;">
                            <p class="text-muted small mt-1">Mevcut favicon</p>
                        </div>
                        ' : '') . '
                    </div>
                </div>
            </div>
        </div>
        
        <div class="settings-section">
            <h3><i class="fas fa-globe"></i> Genel Bilgiler</h3>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="site_title" class="admin-form-label required">
                            <i class="fas fa-heading"></i> Site Başlığı <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="site_title" 
                               name="site_title" 
                               class="admin-form-control" 
                               required
                               value="' . htmlspecialchars($settings['site_title'] ?? 'Spor Kulübü') . '"
                               placeholder="Site başlığını girin">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="club_founded" class="admin-form-label">
                            <i class="fas fa-calendar"></i> Kuruluş Yılı
                        </label>
                        <input type="number" 
                               id="club_founded" 
                               name="club_founded" 
                               class="admin-form-control" 
                               min="1800" 
                               max="2024"
                               value="' . htmlspecialchars($settings['club_founded'] ?? '') . '"
                               placeholder="1907">
                    </div>
                </div>
            </div>
            
            <div class="admin-form-group">
                <label for="site_description" class="admin-form-label">
                    <i class="fas fa-align-left"></i> Site Açıklaması
                </label>
                <textarea id="site_description" 
                          name="site_description" 
                          class="admin-form-control" 
                          rows="3"
                          placeholder="Site hakkında kısa açıklama...">' . htmlspecialchars($settings['site_description'] ?? '') . '</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="club_colors" class="admin-form-label">
                            <i class="fas fa-palette"></i> Kulüp Renkleri
                        </label>
                        <input type="text" 
                               id="club_colors" 
                               name="club_colors" 
                               class="admin-form-control" 
                               value="' . htmlspecialchars($settings['club_colors'] ?? '') . '"
                               placeholder="Sarı-Lacivert">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="stadium_name" class="admin-form-label">
                            <i class="fas fa-building"></i> Stadyum Adı
                        </label>
                        <input type="text" 
                               id="stadium_name" 
                               name="stadium_name" 
                               class="admin-form-control" 
                               value="' . htmlspecialchars($settings['stadium_name'] ?? '') . '"
                               placeholder="Stadyum adı">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="stadium_capacity" class="admin-form-label">
                            <i class="fas fa-users"></i> Stadyum Kapasitesi
                        </label>
                        <input type="number" 
                               id="stadium_capacity" 
                               name="stadium_capacity" 
                               class="admin-form-control" 
                               min="0"
                               value="' . htmlspecialchars($settings['stadium_capacity'] ?? '') . '"
                               placeholder="50000">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="settings-section">
            <h3><i class="fas fa-phone"></i> İletişim Bilgileri</h3>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="contact_email" class="admin-form-label">
                            <i class="fas fa-envelope"></i> E-posta
                        </label>
                        <input type="email" 
                               id="contact_email" 
                               name="contact_email" 
                               class="admin-form-control" 
                               value="' . htmlspecialchars($settings['contact_email'] ?? '') . '"
                               placeholder="info@spor.com">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="contact_phone" class="admin-form-label">
                            <i class="fas fa-phone"></i> Telefon
                        </label>
                        <input type="tel" 
                               id="contact_phone" 
                               name="contact_phone" 
                               class="admin-form-control" 
                               value="' . htmlspecialchars($settings['contact_phone'] ?? '') . '"
                               placeholder="+90 212 123 45 67">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-form-group">
                    <label for="contact_address" class="admin-form-label">
                        <i class="fas fa-map-marker-alt"></i> Adres
                    </label>
                    <textarea id="contact_address" 
                            name="contact_address" 
                            class="admin-form-control" 
                            rows="2"
                            placeholder="Tam adres bilgisi...">' . htmlspecialchars($settings['contact_address'] ?? '') . '</textarea>
                        </div>
                </div>
            </div>
            

        </div>
        
        <div class="settings-section">
            <h3><i class="fas fa-share-alt"></i> Sosyal Medya</h3>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="facebook_url" class="admin-form-label">
                            <i class="fab fa-facebook"></i> Facebook
                        </label>
                        <input type="url" 
                               id="facebook_url" 
                               name="facebook_url" 
                               class="admin-form-control" 
                               value="' . htmlspecialchars($settings['facebook_url'] ?? '') . '"
                               placeholder="https://facebook.com/sporkulubu">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="twitter_url" class="admin-form-label">
                            <i class="fab fa-twitter"></i> Twitter
                        </label>
                        <input type="url" 
                               id="twitter_url" 
                               name="twitter_url" 
                               class="admin-form-control" 
                               value="' . htmlspecialchars($settings['twitter_url'] ?? '') . '"
                               placeholder="https://twitter.com/sporkulubu">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="instagram_url" class="admin-form-label">
                            <i class="fab fa-instagram"></i> Instagram
                        </label>
                        <input type="url" 
                               id="instagram_url" 
                               name="instagram_url" 
                               class="admin-form-control" 
                               value="' . htmlspecialchars($settings['instagram_url'] ?? '') . '"
                               placeholder="https://instagram.com/sporkulubu">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="youtube_url" class="admin-form-label">
                            <i class="fab fa-youtube"></i> YouTube
                        </label>
                        <input type="url" 
                               id="youtube_url" 
                               name="youtube_url" 
                               class="admin-form-control" 
                               value="' . htmlspecialchars($settings['youtube_url'] ?? '') . '"
                               placeholder="https://youtube.com/sporkulubu">
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="admin-form-group">
                        <label for="instagram_access_token" class="admin-form-label">
                            <i class="fab fa-instagram"></i> Instagram Access Token
                            <a href="https://developers.facebook.com/docs/instagram-basic-display-api/getting-started" target="_blank" class="text-info ms-2" title="Token nasıl alınır?">
                                <i class="fas fa-question-circle"></i>
                            </a>
                        </label>
                        <input type="text" 
                               id="instagram_access_token" 
                               name="instagram_access_token" 
                               class="admin-form-control" 
                               value="' . htmlspecialchars($settings['instagram_access_token'] ?? '') . '"
                               placeholder="Instagram Basic Display API Access Token">
                        <small class="form-text text-muted">
                            Instagram postlarınızı sitenizde göstermek için Instagram Basic Display API token’ınızı girin.
                            <a href="' . BASE_URL . '/instagram/clearCache" class="text-primary" onclick="clearInstagramCache(event)">Cache’ı Temizle</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="admin-form-actions">
            <button type="submit" class="btn btn-admin-primary">
                <i class="fas fa-save"></i> Ayarları Kaydet
            </button>
            <button type="reset" class="btn btn-admin-secondary">
                <i class="fas fa-undo"></i> Sıfırla
            </button>
        </div>
    </form>
</div>

<style>
.settings-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.settings-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
}

.settings-section h3 {
    color: var(--primary-navy);
    margin-bottom: 1rem;
    font-size: 1.2rem;
    font-weight: 600;
}

.settings-section h3 i {
    margin-right: 0.5rem;
    color: var(--primary-blue);
}
</style>

<script>
function clearInstagramCache(event) {
    event.preventDefault();
    if (confirm("Instagram cache temizlensin mi?")) {
        fetch("' . BASE_URL . '/instagram/clearCache")
            .then(response => response.json())
            .then(data => {
                alert(data.message || "Cache temizlendi!");
            })
            .catch(error => {
                alert("Hata: " + error.message);
            });
    }
}
</script>';

include BASE_PATH . '/app/views/admin/layout.php';
?>