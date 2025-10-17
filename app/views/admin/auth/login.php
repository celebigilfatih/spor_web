<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Yönetim Paneli</title>
    
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/css/admin.css" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-futbol"></i>
                    SPOR KULÜBÜ
                </div>
                <p class="login-subtitle">Yönetim Paneli</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['expired']) && $_GET['expired'] == '1'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-clock"></i>
                    Oturumunuz zaman aşımına uğradı. Lütfen tekrar giriş yapınız.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo BASE_URL; ?>/admin/login" id="adminLoginForm">
                <!-- CSRF Token for security -->
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                
                <!-- Honeypot field for bot protection (hidden from users) -->
                <div style="position: absolute; left: -5000px;" aria-hidden="true">
                    <input type="text" name="website" tabindex="-1" autocomplete="off" value="" placeholder="Leave this field empty">
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> E-posta Adresi
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control" 
                           placeholder="admin@sporkulubu.com"
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Şifre
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control" 
                           placeholder="Şifrenizi giriniz"
                           required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-admin-primary w-100" id="loginButton">
                        <i class="fas fa-sign-in-alt"></i> Giriş Yap
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <small class="text-muted">
                    <i class="fas fa-shield-alt"></i> Güvenli bağlantı ile korunmaktadır
                </small>
            </div>
            
            <div class="text-center mt-3">
                <a href="<?php echo BASE_URL; ?>/admin/auth/forgot-password" class="text-gray">
                    Şifremi Unuttum
                </a>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?php echo BASE_URL; ?>" class="text-gray">
                    <i class="fas fa-arrow-left"></i> Ana Siteye Dön
                </a>
            </div>
        </div>
    </div>

    <!-- Test bilgileri (sadece geliştirme için) -->
    <div style="position: fixed; bottom: 20px; right: 20px; background: rgba(0,0,0,0.8); color: white; padding: 15px; border-radius: 8px; font-size: 12px;">
        <strong>Test Hesabı:</strong><br>
        E-posta: admin@sporkulubu.com<br>
        Şifre: password
    </div>
</body>
</html>