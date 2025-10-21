<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-user-edit"></i> Kullanıcı Düzenle</h1>
    <a href="' . BASE_URL . '/admin/users" class="btn btn-admin-secondary">
        <i class="fas fa-arrow-left"></i> Geri Dön
    </a>
</div>

<div class="admin-content-card">
    <form method="POST" action="' . BASE_URL . '/admin/users/edit/' . $user['id'] . '" class="admin-form" id="editUserForm">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="form-section">
            <h3><i class="fas fa-user"></i> Hesap Bilgileri</h3>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="username" class="admin-form-label required">
                            Kullanıcı Adı <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               class="admin-form-control" 
                               value="' . htmlspecialchars($old['username'] ?? $user['username']) . '"
                               required
                               minlength="3"
                               placeholder="kullanici_adi">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="email" class="admin-form-label required">
                            E-posta Adresi <span class="required">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="admin-form-control" 
                               value="' . htmlspecialchars($old['email'] ?? $user['email']) . '"
                               required
                               placeholder="kullanici@example.com">
                    </div>
                </div>
            </div>
            
            <div class="admin-form-group">
                <label for="full_name" class="admin-form-label required">
                    Ad Soyad <span class="required">*</span>
                </label>
                <input type="text" 
                       id="full_name" 
                       name="full_name" 
                       class="admin-form-control" 
                       value="' . htmlspecialchars($old['full_name'] ?? $user['full_name']) . '"
                       required
                       placeholder="Ahmet Yılmaz">
            </div>
        </div>
        
        <div class="form-section">
            <h3><i class="fas fa-key"></i> Şifre Değiştir (Opsiyonel)</h3>
            <p class="text-muted mb-3">Şifreyi değiştirmek istemiyorsanız boş bırakın.</p>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="password" class="admin-form-label">
                            Yeni Şifre
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="admin-form-control" 
                                   minlength="6"
                                   placeholder="••••••••">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(\'password\')">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">En az 6 karakter olmalıdır.</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="password_confirm" class="admin-form-label">
                            Şifre Tekrar
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   id="password_confirm" 
                                   name="password_confirm" 
                                   class="admin-form-control" 
                                   minlength="6"
                                   placeholder="••••••••">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(\'password_confirm\')">
                                    <i class="fas fa-eye" id="password_confirm-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h3><i class="fas fa-cog"></i> Yetki ve Durum</h3>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="role" class="admin-form-label required">
                            Rol <span class="required">*</span>
                        </label>
                        <select id="role" name="role" class="admin-form-control" required>
                            <option value="admin" ' . (($old['role'] ?? $user['role']) === 'admin' ? 'selected' : '') . '>
                                Admin
                            </option>
                            <option value="super_admin" ' . (($old['role'] ?? $user['role']) === 'super_admin' ? 'selected' : '') . '>
                                Süper Admin
                            </option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="status" class="admin-form-label required">
                            Durum <span class="required">*</span>
                        </label>
                        <select id="status" name="status" class="admin-form-control" required>
                            <option value="active" ' . (($old['status'] ?? $user['status']) === 'active' ? 'selected' : '') . '>
                                Aktif
                            </option>
                            <option value="inactive" ' . (($old['status'] ?? $user['status']) === 'inactive' ? 'selected' : '') . '>
                                Pasif
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="admin-form-actions">
            <button type="submit" class="btn btn-admin-primary">
                <i class="fas fa-save"></i> Değişiklikleri Kaydet
            </button>
            <a href="' . BASE_URL . '/admin/users" class="btn btn-admin-secondary">
                <i class="fas fa-times"></i> İptal
            </a>
        </div>
    </form>
</div>

<style>
.form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e4e4e7;
}

.form-section:last-of-type {
    border-bottom: none;
}

.form-section h3 {
    color: #09090b;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.form-section h3 i {
    color: #0ea5e9;
    margin-right: 0.5rem;
}

.input-group-append .btn {
    border-left: none;
}
</style>

<script>
// Password visibility toggle
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + \'-icon\');
    
    if (field.type === \'password\') {
        field.type = \'text\';
        icon.classList.remove(\'fa-eye\');
        icon.classList.add(\'fa-eye-slash\');
    } else {
        field.type = \'password\';
        icon.classList.remove(\'fa-eye-slash\');
        icon.classList.add(\'fa-eye\');
    }
}

// Form validation
document.getElementById(\'editUserForm\').addEventListener(\'submit\', function(e) {
    const password = document.getElementById(\'password\').value;
    const passwordConfirm = document.getElementById(\'password_confirm\').value;
    
    // Only validate if password is being changed
    if (password || passwordConfirm) {
        if (password !== passwordConfirm) {
            e.preventDefault();
            alert(\'Şifreler eşleşmiyor! Lütfen kontrol edin.\');
            document.getElementById(\'password_confirm\').focus();
            return false;
        }
    }
});
</script>';

include BASE_PATH . '/app/views/admin/layout.php';
?>
