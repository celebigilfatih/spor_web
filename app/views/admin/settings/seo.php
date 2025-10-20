<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-cog"></i> Site Ayarları</h1>
    <div class="admin-tabs">
        <a href="' . BASE_URL . '/admin/settings" class="tab-link">Genel</a>
        <a href="' . BASE_URL . '/admin/settings/media" class="tab-link">Medya</a>
        <a href="' . BASE_URL . '/admin/settings/seo" class="tab-link active">SEO</a>
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
    <form action="' . BASE_URL . '/admin/settings/seo" method="POST" class="admin-form">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="settings-section">
            <h3><i class="fas fa-search"></i> SEO Ayarları</h3>
            
            <div class="admin-form-group">
                <label for="meta_keywords" class="admin-form-label">
                    <i class="fas fa-tags"></i> Meta Anahtar Kelimeler
                </label>
                <input type="text" 
                       id="meta_keywords" 
                       name="meta_keywords" 
                       class="admin-form-control" 
                       value="' . htmlspecialchars($settings['meta_keywords'] ?? '') . '"
                       placeholder="anahtar,kelime,liste,şeklinde">
                <small class="form-text text-muted">Virgülle ayrılmış anahtar kelimeler</small>
            </div>
            
            <div class="admin-form-group">
                <label for="meta_description" class="admin-form-label">
                    <i class="fas fa-align-left"></i> Meta Açıklama
                </label>
                <textarea id="meta_description" 
                          name="meta_description" 
                          class="admin-form-control" 
                          rows="4"
                          maxlength="160"
                          placeholder="Site açıklaması (en fazla 160 karakter)">' . htmlspecialchars($settings['meta_description'] ?? '') . '</textarea>
                <small class="form-text text-muted">Arama motorlarında görünecek açıklama</small>
            </div>
        </div>
        
        <div class="settings-section">
            <h3><i class="fas fa-chart-line"></i> Analiz ve Takip</h3>
            
            <div class="admin-form-group">
                <label for="google_analytics" class="admin-form-label">
                    <i class="fab fa-google"></i> Google Analytics Kodu
                </label>
                <input type="text" 
                       id="google_analytics" 
                       name="google_analytics" 
                       class="admin-form-control" 
                       value="' . htmlspecialchars($settings['google_analytics'] ?? '') . '"
                       placeholder="GA-TRACKING-ID">
                <small class="form-text text-muted">Google Analytics izleme kodu (GA4 formatında)</small>
            </div>
            
            <div class="admin-form-group">
                <label for="google_search_console" class="admin-form-label">
                    <i class="fab fa-google"></i> Google Search Console
                </label>
                <input type="text" 
                       id="google_search_console" 
                       name="google_search_console" 
                       class="admin-form-control" 
                       value="' . htmlspecialchars($settings['google_search_console'] ?? '') . '"
                       placeholder="Doğrulama kodu">
                <small class="form-text text-muted">Google Search Console doğrulama kodu</small>
            </div>
        </div>
        
        <div class="settings-section">
            <h3><i class="fas fa-robot"></i> Robots.txt</h3>
            
            <div class="admin-form-group">
                <label for="robots_txt" class="admin-form-label">
                    <i class="fas fa-file-code"></i> Robots.txt İçeriği
                </label>
                <textarea id="robots_txt" 
                          name="robots_txt" 
                          class="admin-form-control" 
                          rows="6"
                          placeholder="User-agent: *
Disallow: /admin/
Allow: /">' . htmlspecialchars($settings['robots_txt'] ?? '') . '</textarea>
                <small class="form-text text-muted">robots.txt dosyası için içerik</small>
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
</style>';

include BASE_PATH . '/app/views/admin/layout.php';
?>