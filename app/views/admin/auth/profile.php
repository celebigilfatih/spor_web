<?php
$content = '
<div class="admin-page-header">
    <h1>Profil Düzenleme</h1>
    <div class="admin-breadcrumb">
        <a href="' . BASE_URL . '/admin/dashboard">Dashboard</a>
        <span>/</span>
        <span>Profil</span>
    </div>
</div>

<div class="admin-content-card">
    <form method="POST" action="' . BASE_URL . '/admin/auth/profile">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="form-section">
            <h3>Genel Bilgiler</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="username" class="form-label">Kullanıcı Adı</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           class="form-control" 
                           value="' . htmlspecialchars($admin['username'] ?? '') . '"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">E-posta Adresi</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control" 
                           value="' . htmlspecialchars($admin['email'] ?? '') . '"
                           required>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h3>Şifre Değiştir</h3>
            <p class="form-text">Şifrenizi değiştirmek istemiyorsanız bu alanları boş bırakın.</p>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="current_password" class="form-label">Mevcut Şifre</label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           class="form-control" 
                           placeholder="Mevcut şifrenizi giriniz">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="new_password" class="form-label">Yeni Şifre</label>
                    <input type="password" 
                           id="new_password" 
                           name="new_password" 
                           class="form-control" 
                           placeholder="Yeni şifrenizi giriniz">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password" class="form-label">Yeni Şifre (Tekrar)</label>
                    <input type="password" 
                           id="confirm_password" 
                           name="confirm_password" 
                           class="form-control" 
                           placeholder="Yeni şifrenizi tekrar giriniz">
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-admin-primary">
                <i class="fas fa-save"></i> Profili Güncelle
            </button>
            <a href="' . BASE_URL . '/admin/dashboard" class="btn btn-admin-secondary">
                <i class="fas fa-times"></i> İptal
            </a>
        </div>
    </form>
</div>

<div class="admin-content-card mt-4">
    <h3>Hesap Bilgileri</h3>
    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Kullanıcı Adı:</span>
            <span class="info-value">' . htmlspecialchars($admin['username'] ?? '') . '</span>
        </div>
        <div class="info-item">
            <span class="info-label">E-posta:</span>
            <span class="info-value">' . htmlspecialchars($admin['email'] ?? '') . '</span>
        </div>
        <div class="info-item">
            <span class="info-label">Rol:</span>
            <span class="info-value">' . htmlspecialchars($admin['role'] ?? 'Admin') . '</span>
        </div>
        <div class="info-item">
            <span class="info-label">Son Giriş:</span>
            <span class="info-value">' . ($admin['last_login'] ? date('d.m.Y H:i', strtotime($admin['last_login'])) : 'Bilinmiyor') . '</span>
        </div>
        <div class="info-item">
            <span class="info-label">Kayıt Tarihi:</span>
            <span class="info-value">' . ($admin['created_at'] ? date('d.m.Y H:i', strtotime($admin['created_at'])) : 'Bilinmiyor') . '</span>
        </div>
    </div>
</div>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>