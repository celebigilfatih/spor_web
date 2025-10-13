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
                <label for="competition" class="admin-form-label">
                    <i class="fas fa-trophy"></i> Müsabaka
                </label>
                <select id="competition" name="competition" class="admin-form-control">
                    <option value="">Müsabaka Seçiniz</option>
                    <option value="Liga">Liga</option>
                    <option value="Kupa">Kupa</option>
                    <option value="Hazırlık">Hazırlık Maçı</option>
                    <option value="Play-off">Play-off</option>
                    <option value="Şampiyonlar Ligi">Şampiyonlar Ligi</option>
                    <option value="UEFA Kupası">UEFA Kupası</option>
                    <option value="Süper Kupa">Süper Kupa</option>
                </select>
                <small class="admin-form-text">Maçın türünü seçiniz.</small>
            </div>

            <div class="admin-form-group">
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