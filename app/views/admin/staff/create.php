<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-user-tie"></i> Yeni Teknik Kadro Üyesi Ekle</h1>
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
    <form action="' . BASE_URL . '/admin/staff/create" method="POST" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="row">
            <div class="col-md-6">
                <div class="admin-form-group">
                    <label for="name" class="admin-form-label required">
                        <i class="fas fa-user"></i> Ad Soyad <span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="admin-form-control" 
                           required
                           value="' . htmlspecialchars($_POST['name'] ?? '') . '"
                           placeholder="Teknik kadro üyesinin adı ve soyadı">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="admin-form-group">
                    <label for="position" class="admin-form-label required">
                        <i class="fas fa-briefcase"></i> Pozisyon <span class="required">*</span>
                    </label>
                    <select id="position" name="position" class="admin-form-control" required>
                        <option value="">Pozisyon seçin</option>
                        <option value="Baş Antrenör"' . (($_POST['position'] ?? '') === 'Baş Antrenör' ? ' selected' : '') . '>Baş Antrenör</option>
                        <option value="Antrenör"' . (($_POST['position'] ?? '') === 'Antrenör' ? ' selected' : '') . '>Antrenör</option>
                        <option value="Antrenör Yardımcısı"' . (($_POST['position'] ?? '') === 'Antrenör Yardımcısı' ? ' selected' : '') . '>Antrenör Yardımcısı</option>
                        <option value="Takım Doktoru"' . (($_POST['position'] ?? '') === 'Takım Doktoru' ? ' selected' : '') . '>Takım Doktoru</option>
                        <option value="Fizyoterapist"' . (($_POST['position'] ?? '') === 'Fizyoterapist' ? ' selected' : '') . '>Fizyoterapist</option>
                        <option value="Masör"' . (($_POST['position'] ?? '') === 'Masör' ? ' selected' : '') . '>Masör</option>
                        <option value="Kondisyoner"' . (($_POST['position'] ?? '') === 'Kondisyoner' ? ' selected' : '') . '>Kondisyoner</option>
                        <option value="Kaleci Antrenörü"' . (($_POST['position'] ?? '') === 'Kaleci Antrenörü' ? ' selected' : '') . '>Kaleci Antrenörü</option>
                        <option value="Video Analiz Uzmanı"' . (($_POST['position'] ?? '') === 'Video Analiz Uzmanı' ? ' selected' : '') . '>Video Analiz Uzmanı</option>
                        <option value="Psikolog"' . (($_POST['position'] ?? '') === 'Psikolog' ? ' selected' : '') . '>Psikolog</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="admin-form-group">
                    <label for="experience" class="admin-form-label">
                        <i class="fas fa-clock"></i> Deneyim
                    </label>
                    <input type="text" 
                           id="experience" 
                           name="experience" 
                           class="admin-form-control" 
                           value="' . htmlspecialchars($_POST['experience'] ?? '') . '"
                           placeholder="Örn: 15 yıl">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="admin-form-group">
                    <label for="license" class="admin-form-label">
                        <i class="fas fa-certificate"></i> Lisans/Sertifika
                    </label>
                    <input type="text" 
                           id="license" 
                           name="license" 
                           class="admin-form-control" 
                           value="' . htmlspecialchars($_POST['license'] ?? '') . '"
                           placeholder="Örn: UEFA PRO Lisansı">
                </div>
            </div>
        </div>
        
        <div class="admin-form-group">
            <label for="photo" class="admin-form-label">
                <i class="fas fa-camera"></i> Fotoğraf
            </label>
            <input type="file" 
                   id="photo" 
                   name="photo" 
                   class="admin-form-control" 
                   accept="image/*">
            <small class="admin-form-help">
                <i class="fas fa-info-circle"></i>
                JPG, PNG formatlarında maksimum 2MB boyutunda fotoğraf yükleyebilirsiniz.
            </small>
        </div>
        
        <div class="admin-form-group">
            <label for="bio" class="admin-form-label">
                <i class="fas fa-align-left"></i> Biyografi
            </label>
            <textarea id="bio" 
                      name="bio" 
                      class="admin-form-control" 
                      rows="4"
                      placeholder="Teknik kadro üyesi hakkında kısa bilgi...">' . htmlspecialchars($_POST['bio'] ?? '') . '</textarea>
        </div>
        
        <div class="admin-form-actions">
            <button type="submit" class="btn btn-admin-primary">
                <i class="fas fa-save"></i> Kaydet
            </button>
            <a href="' . BASE_URL . '/admin/staff" class="btn btn-admin-secondary">
                <i class="fas fa-times"></i> İptal
            </a>
        </div>
    </form>
</div>';

include BASE_PATH . '/app/views/admin/layout.php';
?>