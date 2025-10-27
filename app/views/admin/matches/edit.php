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
                <label for="competition" class="admin-form-label">
                    <i class="fas fa-trophy"></i> Müsabaka
                </label>
                <select id="competition" name="competition" class="admin-form-control">
                    <option value="">Müsabaka Seçiniz</option>
                    <option value="Hazırlık Maçı"' . (($match['competition'] ?? '') === 'Hazırlık Maçı' ? ' selected' : '') . '>Hazırlık Maçı</option>
                    <option value="U16 Ligi"' . (($match['competition'] ?? '') === 'U16 Ligi' ? ' selected' : '') . '>U16 Ligi</option>
                    <option value="U15 Ligi"' . (($match['competition'] ?? '') === 'U15 Ligi' ? ' selected' : '') . '>U15 Ligi</option>
                    <option value="U14 Ligi"' . (($match['competition'] ?? '') === 'U14 Ligi' ? ' selected' : '') . '>U14 Ligi</option>
                    <option value="U13 Ligi"' . (($match['competition'] ?? '') === 'U13 Ligi' ? ' selected' : '') . '>U13 Ligi</option>
                    <option value="U12 Ligi"' . (($match['competition'] ?? '') === 'U12 Ligi' ? ' selected' : '') . '>U12 Ligi</option>
                    <option value="U11 Ligi"' . (($match['competition'] ?? '') === 'U11 Ligi' ? ' selected' : '') . '>U11 Ligi</option>
                </select>
                <small class="admin-form-text">Maçın türünü seçiniz.</small>
            </div>

            <div class="admin-form-group">
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