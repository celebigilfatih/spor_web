<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-user-tie"></i> Teknik Kadro Üyesi Düzenle</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/staff" class="btn btn-admin-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
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
    <form action="' . BASE_URL . '/admin/staff/edit/' . $staff['id'] . '" method="POST" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="form-grid-2">
            <div class="form-group">
                <label for="name" class="form-label required">
                    <i class="fas fa-user"></i> Ad Soyad
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       class="form-control" 
                       required
                       value="' . htmlspecialchars($staff['name'] ?? '') . '"
                       placeholder="Teknik kadro üyesinin adı ve soyadı">
            </div>
            
            <div class="form-group">
                <label for="position" class="form-label required">
                    <i class="fas fa-briefcase"></i> Pozisyon
                </label>
                <select id="position" name="position" class="form-control" required>
                    <option value="">Pozisyon seçin</option>
                    <option value="Başkan"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Başkan' ? ' selected' : '') . '>Başkan</option>
                    <option value="Başkan Yardımcısı"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Başkan Yardımcısı' ? ' selected' : '') . '>Başkan Yardımcısı</option>
                    <option value="Yönetici"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Yönetici' ? ' selected' : '') . '>Yönetici</option>
                    <option value="Teknik Direktör"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Teknik Direktör' ? ' selected' : '') . '>Teknik Direktör</option>
                    <option value="Teknik Sorumlu"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Teknik Sorumlu' ? ' selected' : '') . '>Teknik Sorumlu</option>
                    <option value="Altyapı Sorumlusu"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Altyapı Sorumlusu' ? ' selected' : '') . '>Altyapı Sorumlusu</option>
                    <option value="Scout"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Scout' ? ' selected' : '') . '>Scout</option>
                    <option value="Baş Antrenör"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Baş Antrenör' ? ' selected' : '') . '>Baş Antrenör</option>
                    <option value="Antrenör"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Antrenör' ? ' selected' : '') . '>Antrenör</option>
                    <option value="Antrenör Yardımcısı"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Antrenör Yardımcısı' ? ' selected' : '') . '>Antrenör Yardımcısı</option>
                    <option value="Takım Doktoru"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Takım Doktoru' ? ' selected' : '') . '>Takım Doktoru</option>
                    <option value="Fizyoterapist"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Fizyoterapist' ? ' selected' : '') . '>Fizyoterapist</option>
                    <option value="Masör"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Masör' ? ' selected' : '') . '>Masör</option>
                    <option value="Kondisyoner"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Kondisyoner' ? ' selected' : '') . '>Kondisyoner</option>
                    <option value="Kaleci Antrenörü"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Kaleci Antrenörü' ? ' selected' : '') . '>Kaleci Antrenörü</option>
                    <option value="Video Analiz Uzmanı"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Video Analiz Uzmanı' ? ' selected' : '') . '>Video Analiz Uzmanı</option>
                    <option value="Psikolog"' . (($staff['position'] ?? $staff['role'] ?? '') === 'Psikolog' ? ' selected' : '') . '>Psikolog</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="experience" class="form-label">
                    <i class="fas fa-clock"></i> Deneyim (Yıl)
                </label>
                <input type="number" 
                       id="experience" 
                       name="experience" 
                       class="form-control" 
                       value="' . htmlspecialchars($staff['experience_years'] ?? '') . '"
                       placeholder="Örn: 15"
                       min="0">
            </div>
            
            <div class="form-group">
                <label for="sort_order" class="form-label">
                    <i class="fas fa-sort-numeric-up"></i> Sıralama
                </label>
                <input type="number" 
                       id="sort_order" 
                       name="sort_order" 
                       class="form-control" 
                       value="' . htmlspecialchars($staff['sort_order'] ?? '0') . '"
                       placeholder="0 (varsayılan)"
                       min="0">
                <small class="form-help">
                    <i class="fas fa-info-circle"></i>
                    Küçük sayılar önce, büyük sayılar sonra gösterilir. (0 = varsayılan)
                </small>
            </div>
            
            <div class="form-group">
                <label for="license" class="form-label">
                    <i class="fas fa-certificate"></i> Lisans/Sertifika
                </label>
                <input type="text" 
                       id="license" 
                       name="license" 
                       class="form-control" 
                       value="' . htmlspecialchars($staff['license_type'] ?? '') . '"
                       placeholder="Örn: UEFA PRO Lisansı">
            </div>
        </div>
            <label for="status" class="form-label">
                <i class="fas fa-toggle-on"></i> Durum
            </label>
            <select id="status" name="status" class="form-control">
                <option value="active"' . (($staff['status'] ?? '') === 'active' ? ' selected' : '') . '>Aktif</option>
                <option value="inactive"' . (($staff['status'] ?? '') === 'inactive' ? ' selected' : '') . '>Pasif</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="photo" class="form-label">
                <i class="fas fa-camera"></i> Fotoğraf
            </label>';

if (!empty($staff['photo'])) {
    $content .= '
            <div class="current-photo mb-3">
                <img src="' . BASE_URL . '/uploads/' . $staff['photo'] . '" 
                     alt="' . htmlspecialchars($staff['name'] ?? '') . '" 
                     class="img-thumbnail" 
                     style="max-width: 150px; max-height: 150px;">
                <p class="text-muted mt-2">Mevcut fotoğraf</p>
            </div>';
}

$content .= '
            <input type="file" 
                   id="photo" 
                   name="photo" 
                   class="form-control" 
                   accept="image/*">
            <small class="form-help">
                <i class="fas fa-info-circle"></i>
                JPG, PNG formatlarında maksimum 2MB boyutunda fotoğraf yükleyebilirsiniz. Boş bırakırsanız mevcut fotoğraf korunur.
            </small>
        </div>
        
        <div class="form-group">
            <label for="bio" class="form-label">
                <i class="fas fa-align-left"></i> Biyografi
            </label>
            <textarea id="bio" 
                      name="bio" 
                      class="form-control" 
                      rows="4"
                      placeholder="Teknik kadro üyesi hakkında kısa bilgi...">' . htmlspecialchars($staff['bio'] ?? '') . '</textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-admin-success">
                <i class="fas fa-save"></i> Güncelle
            </button>
            <a href="' . BASE_URL . '/admin/staff" class="btn btn-admin-secondary">
                <i class="fas fa-times"></i> İptal
            </a>
        </div>
    </form>
</div>';

include BASE_PATH . '/app/views/admin/layout.php';
?>