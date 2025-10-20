<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-cog"></i> Site Ayarları</h1>
    <div class="admin-tabs">
        <a href="' . BASE_URL . '/admin/settings" class="tab-link">Genel</a>
        <a href="' . BASE_URL . '/admin/settings/media" class="tab-link">Medya</a>
        <a href="' . BASE_URL . '/admin/settings/seo" class="tab-link">SEO</a>
        <a href="' . BASE_URL . '/admin/settings/maintenance" class="tab-link active">Bakım</a>
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
    <form action="' . BASE_URL . '/admin/settings/maintenance" method="POST" class="admin-form">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="settings-section">
            <h3><i class="fas fa-tools"></i> Bakım Modu</h3>
            
            <div class="admin-form-group">
                <div class="form-check">
                    <input type="checkbox" 
                           id="maintenance_mode" 
                           name="maintenance_mode" 
                           class="form-check-input" 
                           value="1" ' . (isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == '1' ? 'checked' : '') . '>
                    <label for="maintenance_mode" class="form-check-label">
                        <i class="fas fa-toggle-on"></i> Bakım Modunu Etkinleştir
                    </label>
                </div>
                <small class="form-text text-muted">Siteyi ziyaretçilere kapat ve bakım sayfasını göster</small>
            </div>
            
            <div class="admin-form-group">
                <label for="maintenance_message" class="admin-form-label">
                    <i class="fas fa-comment"></i> Bakım Mesajı
                </label>
                <textarea id="maintenance_message" 
                          name="maintenance_message" 
                          class="admin-form-control" 
                          rows="4"
                          placeholder="Sitemiz şu anda bakımdadır. Kısa süre sonra yeniden hizmetinizdeyiz.">' . htmlspecialchars($settings['maintenance_message'] ?? '') . '</textarea>
                <small class="form-text text-muted">Kullanıcılara gösterilecek bakım mesajı</small>
            </div>
            
            <div class="admin-form-group">
                <label for="maintenance_end_date" class="admin-form-label">
                    <i class="fas fa-calendar"></i> Tahmini Bitiş Tarihi
                </label>
                <input type="datetime-local" 
                       id="maintenance_end_date" 
                       name="maintenance_end_date" 
                       class="admin-form-control" 
                       value="' . htmlspecialchars($settings['maintenance_end_date'] ?? '') . '">
                <small class="form-text text-muted">Bakımın tahmini bitiş zamanı</small>
            </div>
        </div>
        
        <div class="settings-section">
            <h3><i class="fas fa-info-circle"></i> Bilgi</h3>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <div class="alert-content">
                    <p><strong>Bakım modu etkinleştirildiğinde:</strong></p>
                    <ul>
                        <li>Site ziyaretçilerine bakım sayfası gösterilir</li>
                        <li>Yöneticiler siteye normal şekilde erişebilir</li>
                        <li>Yeni içerik eklemeleri ve düzenlemeleri yapılabilir</li>
                    </ul>
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

.form-check {
    margin-bottom: 1rem;
}

.form-check-input {
    margin-right: 0.5rem;
}

.alert-info {
    background-color: #eff6ff;
    border-color: #bfdbfe;
    color: #1e40af;
}

.alert-info i {
    color: #3b82f6;
}
</style>';

include BASE_PATH . '/app/views/admin/layout.php';
?>