<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-calendar"></i> Maç Düzenle</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/matches" class="btn btn-admin-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>
</div>

<div class="admin-content-card">
    <form method="POST" action="' . BASE_URL . '/admin/matches/edit/' . $match['id'] . '" class="admin-form">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="admin-form-group">
                <label for="home_team" class="admin-form-label">
                    <i class="fas fa-home"></i> Ev Sahibi Takım <span class="required">*</span>
                </label>
                <input type="text" 
                       id="home_team" 
                       name="home_team" 
                       class="admin-form-control" 
                       value="' . htmlspecialchars($match['home_team']) . '"
                       placeholder="Örn: Spor Kulübü"
                       required>
                <small class="admin-form-text">Ev sahibi takımın adını giriniz.</small>
            </div>

            <div class="admin-form-group">
                <label for="away_team" class="admin-form-label">
                    <i class="fas fa-plane"></i> Konuk Takım <span class="required">*</span>
                </label>
                <input type="text" 
                       id="away_team" 
                       name="away_team" 
                       class="admin-form-control" 
                       value="' . htmlspecialchars($match['away_team']) . '"
                       placeholder="Örn: Rakip Takım"
                       required>
                <small class="admin-form-text">Konuk takımın adını giriniz.</small>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="admin-form-group">
                <label for="match_date" class="admin-form-label">
                    <i class="fas fa-clock"></i> Maç Tarihi ve Saati <span class="required">*</span>
                </label>
                <input type="datetime-local" 
                       id="match_date" 
                       name="match_date" 
                       class="admin-form-control" 
                       value="' . date('Y-m-d\TH:i', strtotime($match['match_date'])) . '"
                       required>
                <small class="admin-form-text">Maçın oynanacağı tarih ve saati seçiniz.</small>
            </div>

            <div class="admin-form-group">
                <label for="venue" class="admin-form-label">
                    <i class="fas fa-map-marker-alt"></i> Saha
                </label>
                <input type="text" 
                       id="venue" 
                       name="venue" 
                       class="admin-form-control" 
                       value="' . htmlspecialchars($match['venue'] ?? '') . '"
                       placeholder="Örn: Ana Stadyum">
                <small class="admin-form-text">Maçın oynanacağı saha adı.</small>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="admin-form-group">
                <label for="match_type" class="admin-form-label">
                    <i class="fas fa-trophy"></i> Müsabaka Türü <span class="required">*</span>
                </label>
                <select id="match_type" name="match_type" class="admin-form-control" required>
                    <option value="">Müsabaka Türü Seçiniz</option>
                    <option value="Hazırlık Maçı"' . (($match['match_type'] ?? '') === 'Hazırlık Maçı' ? ' selected' : '') . '>Hazırlık Maçı</option>
                    <option value="Lig Maçı"' . (($match['match_type'] ?? '') === 'Lig Maçı' ? ' selected' : '') . '>Lig Maçı</option>
                    <option value="Özel Turnuva Maçı"' . (($match['match_type'] ?? '') === 'Özel Turnuva Maçı' ? ' selected' : '') . '>Özel Turnuva Maçı</option>
                </select>
                <small class="admin-form-text">Maçın türünü seçiniz.</small>
            </div>
            
            <div class="admin-form-group" id="team-category-group" style="display:' . (!empty($match['match_type']) ? 'block' : 'none') . ';">
                <label for="team_category" class="admin-form-label">
                    <i class="fas fa-users"></i> Takım Kategorisi <span class="required">*</span>
                </label>
                <select id="team_category" name="team_category" class="admin-form-control" ' . (!empty($match['match_type']) ? 'required' : '') . '>
                    <option value="">Takım Kategorisi Seçiniz</option>
                    <option value="U5"' . (($match['team_category'] ?? '') === 'U5' ? ' selected' : '') . '>U5</option>
                    <option value="U6"' . (($match['team_category'] ?? '') === 'U6' ? ' selected' : '') . '>U6</option>
                    <option value="U7"' . (($match['team_category'] ?? '') === 'U7' ? ' selected' : '') . '>U7</option>
                    <option value="U8"' . (($match['team_category'] ?? '') === 'U8' ? ' selected' : '') . '>U8</option>
                    <option value="U9"' . (($match['team_category'] ?? '') === 'U9' ? ' selected' : '') . '>U9</option>
                    <option value="U10"' . (($match['team_category'] ?? '') === 'U10' ? ' selected' : '') . '>U10</option>
                    <option value="U11"' . (($match['team_category'] ?? '') === 'U11' ? ' selected' : '') . '>U11</option>
                    <option value="U12"' . (($match['team_category'] ?? '') === 'U12' ? ' selected' : '') . '>U12</option>
                    <option value="U13"' . (($match['team_category'] ?? '') === 'U13' ? ' selected' : '') . '>U13</option>
                    <option value="U14"' . (($match['team_category'] ?? '') === 'U14' ? ' selected' : '') . '>U14</option>
                    <option value="U15"' . (($match['team_category'] ?? '') === 'U15' ? ' selected' : '') . '>U15</option>
                    <option value="U16"' . (($match['team_category'] ?? '') === 'U16' ? ' selected' : '') . '>U16</option>
                    <option value="U17"' . (($match['team_category'] ?? '') === 'U17' ? ' selected' : '') . '>U17</option>
                    <option value="U18"' . (($match['team_category'] ?? '') === 'U18' ? ' selected' : '') . '>U18</option>
                    <option value="A TAKIM"' . (($match['team_category'] ?? '') === 'A TAKIM' ? ' selected' : '') . '>A TAKIM</option>
                </select>
                <small class="admin-form-text">Maçın hangi takım kategorisinde oynandığını seçiniz.</small>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <label for="status" class="admin-form-label">
                    <i class="fas fa-toggle-on"></i> Durum <span class="required">*</span>
                </label>
                <select id="status" name="status" class="admin-form-control" required>
                    <option value="scheduled"' . ($match['status'] === 'scheduled' ? ' selected' : '') . '>Planlandı</option>
                    <option value="finished"' . ($match['status'] === 'finished' ? ' selected' : '') . '>Tamamlandı</option>
                    <option value="postponed"' . ($match['status'] === 'postponed' ? ' selected' : '') . '>Ertelendi</option>
                    <option value="cancelled"' . ($match['status'] === 'cancelled' ? ' selected' : '') . '>İptal Edildi</option>
                </select>
                <small class="admin-form-text">Maçın durumunu seçiniz.</small>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">
                    <i class="fas fa-futbol"></i> Skor
                </label>
                <div class="flex gap-2 items-center">
                    <input type="number" 
                           name="home_score" 
                           class="admin-form-control" 
                           value="' . ($match['home_score'] ?? '') . '"
                           placeholder="0" 
                           min="0"
                           style="flex: 1;">
                    <span class="text-muted">-</span>
                    <input type="number" 
                           name="away_score" 
                           class="admin-form-control" 
                           value="' . ($match['away_score'] ?? '') . '"
                           placeholder="0" 
                           min="0"
                           style="flex: 1;">
                </div>
                <small class="admin-form-text">Maç bitmişse skorları girebilirsiniz.</small>
            </div>
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn btn-admin-primary">
                <i class="fas fa-save"></i> Değişiklikleri Kaydet
            </button>
            <a href="' . BASE_URL . '/admin/matches" class="btn btn-outline">
                <i class="fas fa-times"></i> İptal
            </a>
        </div>
    </form>
</div>

<div class="admin-info-card">
    <div class="admin-info-header">
        <i class="fas fa-info-circle"></i> Maç Bilgileri
    </div>
    <div class="admin-info-content">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <strong>Oluşturma Tarihi:</strong><br>
                <span class="text-muted">' . (isset($match['created_at']) ? date('d.m.Y H:i', strtotime($match['created_at'])) : 'Bilinmiyor') . '</span>
            </div>
            <div>
                <strong>Son Güncelleme:</strong><br>
                <span class="text-muted">' . (isset($match['updated_at']) ? date('d.m.Y H:i', strtotime($match['updated_at'])) : 'Bilinmiyor') . '</span>
            </div>
        </div>
    </div>
</div>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>

<script>
// Müsabaka türüne göre takım kategorisi alanını göster/gizle
document.getElementById('match_type').addEventListener('change', function() {
    const teamCategoryGroup = document.getElementById('team-category-group');
    const teamCategorySelect = document.getElementById('team_category');
    
    if (this.value) {
        // Tüm müsabaka türleri için takım kategorisi göster
        teamCategoryGroup.style.display = 'block';
        teamCategorySelect.required = true;
    } else {
        teamCategoryGroup.style.display = 'none';
        teamCategorySelect.required = false;
        teamCategorySelect.value = '';
    }
});
</script>