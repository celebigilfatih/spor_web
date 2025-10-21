<?php
$content = '
<div class="modern-page-header">
    <div class="page-header-content">
        <div class="header-title-section">
            <div class="header-icon">
                <i class="fas fa-user-edit"></i>
            </div>
            <div class="header-text">
                <h1>Oyuncu Düzenle</h1>
                <p class="header-subtitle">' . htmlspecialchars($player['name']) . ' oyuncusunun bilgilerini güncelleyin</p>
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
    <form method="POST" action="' . BASE_URL . '/admin/players/edit/' . $player['id'] . '" class="modern-admin-form" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <!-- Unified Form Card -->
        <div class="modern-form-card unified-form-card">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-user-edit"></i>
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
                            <label for="full_name" class="modern-label">
                                <span class="label-text">Ad Soyad</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="text" 
                                       id="full_name" 
                                       name="full_name" 
                                       class="modern-input" 
                                       placeholder="Oyuncunun tam adı"
                                       value="' . htmlspecialchars($player['name']) . '"
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
                                       value="' . htmlspecialchars($player['birth_date'] ?? '') . '">
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
                                        <span class="upload-text">Fotoğraf Değiştir</span>
                                        <small class="upload-hint">JPG, PNG, WebP (Max: 5MB)</small>
                                        <div class="upload-progress" style="display: none;">
                                            <div class="progress-bar"></div>
                                        </div>
                                    </div>
                                </label>
                                <div class="file-preview" style="display: none;"></div>
                            </div>';
                            
                            if ($player['photo']) {
                                $content .= '
                            <div class="current-photo-preview">
                                <small class="field-hint">Mevcut fotoğraf:</small>
                                <img src="' . BASE_URL . '/uploads/' . $player['photo'] . '" 
                                     alt="Mevcut fotoğraf" 
                                     class="current-photo-thumb">
                            </div>';
                            }
                            
                            $content .= '
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
                            
                            foreach ($teams as $team) {
                                $selected = $player['team_id'] == $team['id'] ? ' selected' : '';
                                $content .= '<option value="' . $team['id'] . '"' . $selected . '>' . htmlspecialchars($team['name']) . '</option>';
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
                                       value="' . htmlspecialchars($player['jersey_number'] ?? '') . '">
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
                                    <option value="Kaleci"' . ($player['position'] === 'Kaleci' ? ' selected' : '') . '>Kaleci</option>
                                    <option value="Defans"' . ($player['position'] === 'Defans' ? ' selected' : '') . '>Defans</option>
                                    <option value="Orta Saha"' . ($player['position'] === 'Orta Saha' ? ' selected' : '') . '>Orta Saha</option>
                                    <option value="Forvet"' . ($player['position'] === 'Forvet' ? ' selected' : '') . '>Forvet</option>
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
                                    <option value="active"' . ($player['status'] === 'active' ? ' selected' : '') . '>Aktif</option>
                                    <option value="injured"' . ($player['status'] === 'injured' ? ' selected' : '') . '>Sakatlık</option>
                                    <option value="suspended"' . ($player['status'] === 'suspended' ? ' selected' : '') . '>Cezalı</option>
                                    <option value="transfer"' . ($player['status'] === 'transfer' ? ' selected' : '') . '>Transfer Listesi</option>
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
                                       ' . ($player['is_captain'] ? 'checked' : '') . '>
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
                        <span>Değişiklikleri Kaydet</span>
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
            <i class="fas fa-info-circle"></i>
        </div>
        <h4>Oyuncu Bilgileri</h4>
    </div>
    <div class="info-content">
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <div class="info-item-text">
                <strong>Oluşturma Tarihi:</strong> ' . (isset($player['created_at']) ? date('d.m.Y H:i', strtotime($player['created_at'])) : 'Bilinmiyor') . '
            </div>
        </div>
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div class="info-item-text">
                <strong>Son Güncelleme:</strong> ' . (isset($player['updated_at']) ? date('d.m.Y H:i', strtotime($player['updated_at'])) : 'Bilinmiyor') . '
            </div>
        </div>
    </div>
</div>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>