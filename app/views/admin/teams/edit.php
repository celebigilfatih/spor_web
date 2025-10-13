<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-shield-alt"></i> Takım Düzenle</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/teams" class="btn btn-admin-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>
</div>

<div class="admin-content-card">
    <form method="POST" action="' . BASE_URL . '/admin/teams/edit/' . $team['id'] . '" class="admin-form">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="admin-form-group">
            <label for="name" class="admin-form-label">
                <i class="fas fa-shield-alt"></i> Takım Adı <span class="required">*</span>
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   class="admin-form-control" 
                   value="' . htmlspecialchars($team['name']) . '"
                   placeholder="Örn: A Takımı, U19 Takımı"
                   required>
            <small class="admin-form-text">Takımın resmi adını giriniz.</small>
        </div>

        <div class="admin-form-group">
            <label for="category" class="admin-form-label">
                <i class="fas fa-layer-group"></i> Kategori <span class="required">*</span>
            </label>
            <select id="category" name="category" class="admin-form-control" required>
                <option value="">Kategori Seçiniz</option>
                <option value="Senior"' . ((($team['team_type'] ?? $team['category'] ?? '') === 'A' || ($team['team_type'] ?? $team['category'] ?? '') === 'Senior') ? ' selected' : '') . '>Senior (A Takımı)</option>
                <option value="U21"' . ((($team['team_type'] ?? $team['category'] ?? '') === 'U21') ? ' selected' : '') . '>U21 (21 Yaş Altı)</option>
                <option value="U19"' . ((($team['team_type'] ?? $team['category'] ?? '') === 'U19') ? ' selected' : '') . '>U19 (19 Yaş Altı)</option>
                <option value="U17"' . ((($team['team_type'] ?? $team['category'] ?? '') === 'U17') ? ' selected' : '') . '>U17 (17 Yaş Altı)</option>
                <option value="U15"' . ((($team['team_type'] ?? $team['category'] ?? '') === 'U15') ? ' selected' : '') . '>U15 (15 Yaş Altı)</option>
                <option value="U13"' . ((($team['team_type'] ?? $team['category'] ?? '') === 'U13') ? ' selected' : '') . '>U13 (13 Yaş Altı)</option>
                <option value="U11"' . ((($team['team_type'] ?? $team['category'] ?? '') === 'U11') ? ' selected' : '') . '>U11 (11 Yaş Altı)</option>
                <option value="U9"' . ((($team['team_type'] ?? $team['category'] ?? '') === 'U9') ? ' selected' : '') . '>U9 (9 Yaş Altı)</option>
            </select>
            <small class="admin-form-text">Takımın yaş kategorisini seçiniz.</small>
        </div>

        <div class="admin-form-group">
            <label for="coach" class="admin-form-label">
                <i class="fas fa-user-tie"></i> Antrenör <span class="text-muted">(Geçici olarak devre dışı)</span>
            </label>
            <input type="text" 
                   id="coach" 
                   name="coach" 
                   class="admin-form-control" 
                   value="' . htmlspecialchars($team['coach_name'] ?? $team['coach'] ?? '') . '"
                   placeholder="Antrenör adı ve soyadı"
                   disabled>
            <small class="admin-form-text">Antrenör seçimi teknik kadro modülü ile entegre edilecek.</small>
        </div>

        <div class="admin-form-group">
            <label for="description" class="admin-form-label">
                <i class="fas fa-align-left"></i> Açıklama
            </label>
            <textarea id="description" 
                      name="description" 
                      class="admin-form-control" 
                      rows="4" 
                      placeholder="Takım hakkında kısa açıklama...">' . htmlspecialchars($team['description'] ?? '') . '</textarea>
            <small class="admin-form-text">Takım hakkında genel bilgiler ve hedefler.</small>
        </div>

        <div class="admin-form-group">
            <label for="status" class="admin-form-label">
                <i class="fas fa-toggle-on"></i> Durum <span class="required">*</span>
            </label>
            <select id="status" name="status" class="admin-form-control" required>
                <option value="active"' . ($team['status'] === 'active' ? ' selected' : '') . '>Aktif</option>
                <option value="inactive"' . ($team['status'] === 'inactive' ? ' selected' : '') . '>Pasif</option>
            </select>
            <small class="admin-form-text">Takımın web sitesindeki görünürlük durumu.</small>
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn btn-admin-primary">
                <i class="fas fa-save"></i> Değişiklikleri Kaydet
            </button>
            <a href="' . BASE_URL . '/admin/teams" class="btn btn-admin-secondary">
                <i class="fas fa-times"></i> İptal
            </a>
        </div>
    </form>
</div>

<div class="admin-info-card">
    <div class="admin-info-header">
        <i class="fas fa-info-circle"></i> Takım Bilgileri
    </div>
    <div class="admin-info-content">
        <div class="row">
            <div class="col-md-6">
                <strong>Oluşturma Tarihi:</strong><br>
                <span class="text-muted">' . (isset($team['created_at']) ? date('d.m.Y H:i', strtotime($team['created_at'])) : 'Bilinmiyor') . '</span>
            </div>
            <div class="col-md-6">
                <strong>Son Güncelleme:</strong><br>
                <span class="text-muted">' . (isset($team['updated_at']) ? date('d.m.Y H:i', strtotime($team['updated_at'])) : 'Bilinmiyor') . '</span>
            </div>
        </div>
    </div>
</div>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>