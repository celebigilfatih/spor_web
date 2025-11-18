<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-handshake"></i> Sponsorlar</h1>
    <p class="text-muted">Sponsor görsellerini ekleyin ve yönetin</p>
</div>

<!-- Mesajlar -->';

if (!empty($message)) {
    $content .= '<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' . htmlspecialchars($message) . '</div>';
}

if (!empty($error)) {
    $content .= '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ' . htmlspecialchars($error) . '</div>';
}

$content .= '
<div class="admin-content-card">
    <div class="row">
        <div class="col-md-4">
            <h3 class="mb-3"><i class="fas fa-plus-circle"></i> Yeni Sponsor Ekle</h3>
            <form action="' . BASE_URL . '/admin/sponsors" method="POST" enctype="multipart/form-data" class="admin-form">
                <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                <div class="admin-form-group">
                    <label class="admin-form-label">Sponsor Görseli</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp" class="admin-form-control" required>
                    <small class="form-text text-muted">Logo görseli (önerilen max yükseklik: 80px)</small>
                </div>
                <div class="admin-form-actions">
                    <button type="submit" class="btn btn-admin-primary"><i class="fas fa-upload"></i> Yükle</button>
                </div>
            </form>
        </div>
        <div class="col-md-8">
            <h3 class="mb-3"><i class="fas fa-images"></i> Mevcut Sponsorlar</h3>
            <div class="sponsors-grid">
                ' . (
                    !empty($sponsors) ? 
                    implode('', array_map(function($s) {
                        return '
                        <div class="sponsor-item">
                            <div class="sponsor-image-wrapper">
                                <img src="' . BASE_URL . '/uploads/' . htmlspecialchars($s['image']) . '" alt="Sponsor" class="sponsor-image">
                            </div>
                            <div class="sponsor-actions">
                                <a href="' . BASE_URL . '/admin/sponsors/delete/' . (int)$s['id'] . '" class="btn btn-admin-danger btn-sm" onclick="return confirm(\'Silmek istediğinize emin misiniz?\')">
                                    <i class="fas fa-trash"></i> Sil
                                </a>
                            </div>
                        </div>';
                    }, $sponsors))
                    : '<div class="text-muted">Henüz sponsor eklenmemiş.</div>'
                ) . '
            </div>
        </div>
    </div>
</div>

<style>
.sponsors-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 16px; }
.sponsor-item { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; display: flex; flex-direction: column; align-items: center; }
.sponsor-image-wrapper { width: 100%; height: 80px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
.sponsor-image { max-width: 100%; max-height: 80px; object-fit: contain; }
.sponsor-actions { margin-top: 8px; }
</style>
' ;

include BASE_PATH . '/app/views/admin/layout.php';
?>