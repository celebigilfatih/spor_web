<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-shield-alt"></i> Yeni Takım Ekle</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/teams" class="btn btn-admin-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>
</div>

<div class="admin-content-card">
    <form method="POST" action="' . BASE_URL . '/admin/teams/create" class="admin-form">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="admin-form-group">
            <label for="name" class="admin-form-label">
                <i class="fas fa-shield-alt"></i> Takım Adı <span class="required">*</span>
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   class="admin-form-control" 
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
                <option value="Senior">Senior (A Takımı)</option>
                <option value="U21">U21 (21 Yaş Altı)</option>
                <option value="U19">U19 (19 Yaş Altı)</option>
                <option value="U17">U17 (17 Yaş Altı)</option>
                <option value="U15">U15 (15 Yaş Altı)</option>
                <option value="U13">U13 (13 Yaş Altı)</option>
                <option value="U11">U11 (11 Yaş Altı)</option>
                <option value="U9">U9 (9 Yaş Altı)</option>
            </select>
            <small class="admin-form-text">Takımın yaş kategorisini seçiniz.</small>
        </div>

        <div class="admin-form-group">
            <label for="coach" class="admin-form-label">
                <i class="fas fa-user-tie"></i> Antrenör
            </label>
            <input type="text" 
                   id="coach" 
                   name="coach" 
                   class="admin-form-control" 
                   placeholder="Antrenör adı ve soyadı">
            <small class="admin-form-text">Takımın baş antrenörünün adını giriniz.</small>
        </div>

        <div class="admin-form-group">
            <label for="description" class="admin-form-label">
                <i class="fas fa-align-left"></i> Açıklama
            </label>
            <textarea id="description" 
                      name="description" 
                      class="admin-form-control" 
                      rows="4" 
                      placeholder="Takım hakkında kısa açıklama..."></textarea>
            <small class="admin-form-text">Takım hakkında genel bilgiler ve hedefler.</small>
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn btn-admin-primary">
                <i class="fas fa-save"></i> Takımı Kaydet
            </button>
            <a href="' . BASE_URL . '/admin/teams" class="btn btn-admin-secondary">
                <i class="fas fa-times"></i> İptal
            </a>
        </div>
    </form>
</div>

<div class="admin-info-card">
    <div class="admin-info-header">
        <i class="fas fa-info-circle"></i> Bilgi
    </div>
    <div class="admin-info-content">
        <ul>
            <li><strong>Takım Adı:</strong> Takımın resmi adını giriniz. Bu ad web sitesinde görüntülenecektir.</li>
            <li><strong>Kategori:</strong> Yaş grubuna göre kategorisini seçiniz.</li>
            <li><strong>Antrenör:</strong> Takımın sorumlu antrenörünü belirtiniz.</li>
            <li><strong>Açıklama:</strong> Takım hakkında detaylı bilgi verebilirsiniz.</li>
        </ul>
    </div>
</div>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>