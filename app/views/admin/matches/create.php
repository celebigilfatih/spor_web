<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-calendar"></i> Yeni Maç Ekle</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/matches" class="btn btn-admin-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>
</div>

' . (!empty($error) ? '
<div class="alert alert-danger mb-4">
    <i class="fas fa-exclamation-triangle me-2"></i>
    ' . htmlspecialchars($error) . '
</div>
' : '') . '

<div class="admin-content-card">
    <form method="POST" action="' . BASE_URL . '/admin/matches/create" class="admin-form">
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
                    <option value="Hazırlık Maçı">Hazırlık Maçı</option>
                    <option value="Lig Maçı">Lig Maçı</option>
                    <option value="Özel Turnuva Maçı">Özel Turnuva Maçı</option>
                </select>
                <small class="admin-form-text">Maçın türünü seçiniz.</small>
            </div>
            
            <div class="admin-form-group" id="team-category-group" style="display:none;">
                <label for="team_category" class="admin-form-label">
                    <i class="fas fa-users"></i> Takım Kategorisi <span class="required">*</span>
                </label>
                <select id="team_category" name="team_category" class="admin-form-control">
                    <option value="">Takım Kategorisi Seçiniz</option>
                    <option value="U5">U5</option>
                    <option value="U6">U6</option>
                    <option value="U7">U7</option>
                    <option value="U8">U8</option>
                    <option value="U9">U9</option>
                    <option value="U10">U10</option>
                    <option value="U11">U11</option>
                    <option value="U12">U12</option>
                    <option value="U13">U13</option>
                    <option value="U14">U14</option>
                    <option value="U15">U15</option>
                    <option value="U16">U16</option>
                    <option value="U17">U17</option>
                    <option value="U18">U18</option>
                    <option value="A TAKIM">A TAKIM</option>
                </select>
                <small class="admin-form-text">Maçın hangi takım kategorisinde oynandığını seçiniz.</small>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <label for="status" class="admin-form-label">
                    <i class="fas fa-toggle-on"></i> Durum <span class="required">*</span>
                </label>
                <select id="status" name="status" class="admin-form-control" required>
                    <option value="scheduled">Planlandı</option>
                    <option value="finished">Tamamlandı</option>
                    <option value="postponed">Ertelendi</option>
                    <option value="cancelled">İptal Edildi</option>
                </select>
                <small class="admin-form-text">Maçın durumunu seçiniz.</small>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">
                    <i class="fas fa-futbol"></i> Skor (Opsiyonel)
                </label>
                <div class="flex gap-2 items-center">
                    <input type="number" 
                           name="home_score" 
                           class="admin-form-control" 
                           placeholder="0" 
                           min="0"
                           style="flex: 1;">
                    <span class="text-muted">-</span>
                    <input type="number" 
                           name="away_score" 
                           class="admin-form-control" 
                           placeholder="0" 
                           min="0"
                           style="flex: 1;">
                </div>
                <small class="admin-form-text">Maç bitmişse skorları girebilirsiniz.</small>
            </div>
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn btn-admin-primary">
                <i class="fas fa-save"></i> Maçı Kaydet
            </button>
            <a href="' . BASE_URL . '/admin/matches" class="btn btn-outline">
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
            <li><strong>Ev Sahibi & Konuk Takım:</strong> Takım adlarını tam olarak giriniz.</li>
            <li><strong>Maç Tarihi:</strong> Doğru tarih ve saat seçimi yapınız.</li>
            <li><strong>Saha:</strong> Maçın oynanacağı saha ismini belirtiniz.</li>
            <li><strong>Skor:</strong> Sadece tamamlanan maçlar için skor giriniz.</li>
            <li><strong>Durum:</strong> Maçın mevcut durumunu doğru seçiniz.</li>
        </ul>
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