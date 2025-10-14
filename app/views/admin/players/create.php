<?php
$content = '
<div class="modern-page-header">
    <div class="page-header-content">
        <div class="header-title-section">
            <div class="header-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="header-text">
                <h1>Yeni Oyuncu Ekle</h1>
                <p class="header-subtitle">Takıma yeni oyuncu eklemek için gerekli bilgileri giriniz</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="' . BASE_URL . '/admin/players" class="btn btn-modern-secondary">
                <i class="fas fa-arrow-left"></i> Geri Dön
            </a>
        </div>
    </div>
</div>

<div class="modern-form-container">
    <form method="POST" action="' . BASE_URL . '/admin/players/create" class="modern-admin-form" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <!-- Unified Form Card -->
        <div class="modern-form-card unified-form-card">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3 class="card-title">Oyuncu Bilgileri</h3>
            </div>
            
            <div class="unified-form-content">
                <!-- Kişisel Bilgiler Bölümü -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-user"></i> Kişisel Bilgiler
                        </h4>
                    </div>
                    
                    <div class="form-fields-grid">
                        <div class="modern-input-group">
                            <label for="first_name" class="modern-label">
                                <span class="label-text">Ad</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="text" 
                                       id="first_name" 
                                       name="first_name" 
                                       class="modern-input" 
                                       placeholder="Oyuncunun adı"
                                       value="' . htmlspecialchars($_POST['first_name'] ?? '') . '"
                                       required>
                            </div>
                        </div>

                        <div class="modern-input-group">
                            <label for="last_name" class="modern-label">
                                <span class="label-text">Soyad</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="text" 
                                       id="last_name" 
                                       name="last_name" 
                                       class="modern-input" 
                                       placeholder="Oyuncunun soyadı"
                                       value="' . htmlspecialchars($_POST['last_name'] ?? '') . '"
                                       required>
                            </div>
                        </div>
                        
                        <div class="modern-input-group">
                            <label for="birth_date" class="modern-label">
                                <span class="label-text">Doğum Tarihi</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <input type="date" 
                                       id="birth_date" 
                                       name="birth_date" 
                                       class="modern-input"
                                       value="' . htmlspecialchars($_POST['birth_date'] ?? '') . '">
                            </div>
                        </div>

                        <div class="modern-input-group file-upload-group">
                            <label for="photo" class="modern-label">
                                <span class="label-text">Fotoğraf</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" 
                                       id="photo" 
                                       name="photo" 
                                       class="file-input"
                                       accept="image/jpeg,image/png,image/webp"
                                       data-max-size="5242880">
                                <label for="photo" class="file-upload-label">
                                    <div class="file-upload-content">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span class="upload-text">Fotoğraf Yükle</span>
                                        <small class="upload-hint">JPG, PNG, WebP (Max: 5MB)</small>
                                        <div class="upload-progress" style="display: none;">
                                            <div class="progress-bar"></div>
                                        </div>
                                    </div>
                                </label>
                                <div class="file-preview" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Takım Bilgileri Bölümü -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-shield-alt"></i> Takım Bilgileri
                        </h4>
                    </div>
                    
                    <div class="form-fields-grid">
                        <div class="modern-input-group">
                            <label for="team_id" class="modern-label">
                                <span class="label-text">Takım</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="select-wrapper">
                                <div class="select-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <select id="team_id" name="team_id" class="modern-select" required>
                                    <option value="">Takım Seçiniz</option>';
                            
                            if (is_array($teams)) {
                                foreach ($teams as $team) {
                                    $selected = ($_POST['team_id'] ?? '') == $team['id'] ? ' selected' : '';
                                    $content .= '<option value="' . $team['id'] . '"' . $selected . '>' . htmlspecialchars($team['name']) . '</option>';
                                }
                            }
                            
                            $content .= '
                                </select>
                                <div class="select-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <div class="modern-input-group">
                            <label for="jersey_number" class="modern-label">
                                <span class="label-text">Forma Numarası</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <input type="number" 
                                       id="jersey_number" 
                                       name="jersey_number" 
                                       class="modern-input" 
                                       placeholder="10"
                                       min="1" 
                                       max="99"
                                       value="' . htmlspecialchars($_POST['jersey_number'] ?? '') . '">
                            </div>
                            <small class="field-hint">1-99 arası numara seçiniz</small>
                        </div>

                        <div class="modern-input-group">
                            <label for="position" class="modern-label">
                                <span class="label-text">Pozisyon</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="select-wrapper">
                                <div class="select-icon">
                                    <i class="fas fa-map-pin"></i>
                                </div>
                                <select id="position" name="position" class="modern-select" required>
                                    <option value="">Pozisyon Seçiniz</option>
                                    <option value="Kaleci"' . (($_POST['position'] ?? '') === 'Kaleci' ? ' selected' : '') . '>Kaleci</option>
                                    <option value="Defans"' . (($_POST['position'] ?? '') === 'Defans' ? ' selected' : '') . '>Defans</option>
                                    <option value="Orta Saha"' . (($_POST['position'] ?? '') === 'Orta Saha' ? ' selected' : '') . '>Orta Saha</option>
                                    <option value="Forvet"' . (($_POST['position'] ?? '') === 'Forvet' ? ' selected' : '') . '>Forvet</option>
                                </select>
                                <div class="select-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <div class="modern-input-group">
                            <label for="status" class="modern-label">
                                <span class="label-text">Durum</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="select-wrapper">
                                <div class="select-icon">
                                    <i class="fas fa-toggle-on"></i>
                                </div>
                                <select id="status" name="status" class="modern-select" required>
                                    <option value="active"' . (($_POST['status'] ?? 'active') === 'active' ? ' selected' : '') . '>Aktif</option>
                                    <option value="injured"' . (($_POST['status'] ?? '') === 'injured' ? ' selected' : '') . '>Sakatlık</option>
                                    <option value="suspended"' . (($_POST['status'] ?? '') === 'suspended' ? ' selected' : '') . '>Cezalı</option>
                                    <option value="transfer"' . (($_POST['status'] ?? '') === 'transfer' ? ' selected' : '') . '>Transfer Listesi</option>
                                </select>
                                <div class="select-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <div class="modern-checkbox-group">
                            <div class="checkbox-wrapper">
                                <input type="checkbox" 
                                       id="is_captain" 
                                       name="is_captain" 
                                       value="1"
                                       class="modern-checkbox"
                                       ' . (isset($_POST['is_captain']) ? 'checked' : '') . '>
                                <label for="is_captain" class="checkbox-label">
                                    <div class="checkbox-indicator">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="checkbox-content">
                                        <span class="checkbox-title">
                                            <i class="fas fa-crown"></i> Takım Kaptanı
                                        </span>
                                        <small class="checkbox-subtitle">Bu oyuncu takım kaptanı mı?</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modern-form-actions">
                    <button type="submit" class="btn btn-modern-primary">
                        <i class="fas fa-save"></i>
                        <span>Oyuncuyu Kaydet</span>
                    </button>
                    <a href="' . BASE_URL . '/admin/players" class="btn btn-modern-outline">
                        <i class="fas fa-times"></i>
                        <span>İptal</span>
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modern-info-panel">
    <div class="info-header">
        <div class="info-icon">
            <i class="fas fa-lightbulb"></i>
        </div>
        <h4>Yardımcı Bilgiler</h4>
    </div>
    <div class="info-content">
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="info-item-text">
                <strong>Ad & Soyad:</strong> Oyuncunun tam adını giriniz.
            </div>
        </div>
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="info-item-text">
                <strong>Takım:</strong> Oyuncunun hangi takımda olduğunu seçiniz.
            </div>
        </div>
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-hashtag"></i>
            </div>
            <div class="info-item-text">
                <strong>Forma Numarası:</strong> Benzersiz olmalıdır (aynı takımda).
            </div>
        </div>
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-map-pin"></i>
            </div>
            <div class="info-item-text">
                <strong>Pozisyon:</strong> Oyuncunun ana pozisyonunu seçiniz.
            </div>
        </div>
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-camera"></i>
            </div>
            <div class="info-item-text">
                <strong>Fotoğraf:</strong> Tercihen 400x400 piksel, JPG, PNG veya WebP format.
            </div>
        </div>
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="info-item-text">
                <strong>Doğum Tarihi:</strong> Oyuncunun yaşını hesaplamak için kullanılır.
            </div>
        </div>
    </div>
</div>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>