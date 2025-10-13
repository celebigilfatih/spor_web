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
                <p class="login-subtitle">Şifre Sıfırlama</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($message)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo BASE_URL; ?>/admin/auth/forgot-password">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                
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
                    <small class="form-text">Şifre sıfırlama bağlantısı bu adrese gönderilecektir.</small>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-admin-primary w-100">
                        <i class="fas fa-paper-plane"></i> Sıfırlama Bağlantısı Gönder
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <a href="<?php echo BASE_URL; ?>/admin/login" class="text-gray">
                    <i class="fas fa-arrow-left"></i> Giriş Sayfasına Dön
                </a>
            </div>
        </div>
    </div>
</body>
</html>