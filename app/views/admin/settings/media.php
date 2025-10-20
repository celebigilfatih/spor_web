<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-cog"></i> Site Ayarları</h1>
    <div class="admin-tabs">
        <a href="' . BASE_URL . '/admin/settings" class="tab-link">Genel</a>
        <a href="' . BASE_URL . '/admin/settings/media" class="tab-link active">Medya</a>
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
    <form action="' . BASE_URL . '/admin/settings/media" method="POST" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="settings-section">
            <h3><i class="fas fa-image"></i> Logo ve Görseller</h3>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="logo" class="admin-form-label">
                            <i class="fas fa-file-image"></i> Site Logosu
                        </label>
                        <input type="file" 
                               id="logo" 
                               name="logo" 
                               class="admin-form-control" 
                               accept="image/jpeg,image/png">
                        <small class="form-text text-muted">Önerilen boyut: 200x50px (JPG, PNG)</small>
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
                        <label for="favicon" class="admin-form-label">
                            <i class="fas fa-bookmark"></i> Favicon
                        </label>
                        <input type="file" 
                               id="favicon" 
                               name="favicon" 
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