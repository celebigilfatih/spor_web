<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Yönetim Paneli</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            /* Shadcn Zinc Color Palette */
            --zinc-50: #fafafa;
            --zinc-100: #f4f4f5;
            --zinc-200: #e4e4e7;
            --zinc-300: #d4d4d8;
            --zinc-400: #a1a1aa;
            --zinc-500: #71717a;
            --zinc-600: #52525b;
            --zinc-700: #3f3f46;
            --zinc-800: #27272a;
            --zinc-900: #18181b;
            --zinc-950: #09090b;
            
            /* Primary */
            --primary: #18181b;
            --primary-foreground: #fafafa;
            
            /* Accent */
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            
            /* Border */
            --border: var(--zinc-200);
            --input: var(--zinc-200);
            
            /* Background */
            --background: var(--zinc-50);
            --foreground: var(--zinc-900);
            
            /* Card */
            --card: #ffffff;
            --card-foreground: var(--zinc-900);
            
            /* Muted */
            --muted: var(--zinc-100);
            --muted-foreground: var(--zinc-500);
            
            /* Destructive */
            --destructive: #ef4444;
            --destructive-foreground: #ffffff;
            
            /* Radius */
            --radius: 0.5rem;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--background);
            color: var(--foreground);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            background: var(--primary);
            color: var(--primary-foreground);
            border-radius: var(--radius);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--foreground);
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }
        
        .login-subtitle {
            font-size: 0.875rem;
            color: var(--muted-foreground);
            font-weight: 400;
        }
        
        /* Alert Styles */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: calc(var(--radius) - 2px);
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: start;
            gap: 0.75rem;
            border: 1px solid;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert i {
            flex-shrink: 0;
            margin-top: 0.125rem;
        }
        
        .alert-destructive {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }
        
        .alert-warning {
            background: #fffbeb;
            border-color: #fde68a;
            color: #92400e;
        }
        
        .alert-content {
            flex: 1;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--foreground);
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            width: 100%;
            height: 2.5rem;
            padding: 0 0.75rem;
            font-size: 0.875rem;
            border: 1px solid var(--input);
            border-radius: calc(var(--radius) - 2px);
            background: var(--background);
            color: var(--foreground);
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            ring: 2px;
            ring-color: var(--primary);
            ring-opacity: 0.2;
        }
        
        .form-control::placeholder {
            color: var(--muted-foreground);
        }
        
        .form-control:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            height: 2.5rem;
            padding: 0 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: calc(var(--radius) - 2px);
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
            text-decoration: none;
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .btn-primary {
            background: var(--primary);
            color: var(--primary-foreground);
        }
        
        .btn-primary:hover:not(:disabled) {
            background: var(--zinc-800);
        }
        
        .btn-primary:active:not(:disabled) {
            transform: scale(0.98);
        }
        
        .w-100 {
            width: 100%;
        }
        
        /* Links */
        .text-link {
            color: var(--foreground);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .text-link:hover {
            color: var(--muted-foreground);
        }
        
        .text-muted {
            color: var(--muted-foreground);
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .text-center {
            text-align: center;
        }
        
        .mt-3 {
            margin-top: 0.75rem;
        }
        
        .mt-4 {
            margin-top: 1rem;
        }
        
        .mt-6 {
            margin-top: 1.5rem;
        }
        
        /* Divider */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 1.5rem 0;
        }
        
        /* Loading State */
        .btn-loading {
            position: relative;
            color: transparent;
        }
        
        .btn-loading::after {
            content: '';
            position: absolute;
            width: 1rem;
            height: 1rem;
            top: 50%;
            left: 50%;
            margin-left: -0.5rem;
            margin-top: -0.5rem;
            border: 2px solid currentColor;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
            color: var(--primary-foreground);
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Development Badge */
        .dev-badge {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            background: var(--zinc-900);
            color: var(--zinc-50);
            padding: 1rem;
            border-radius: var(--radius);
            font-size: 0.75rem;
            line-height: 1.5;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            max-width: 200px;
        }
        
        .dev-badge strong {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--zinc-100);
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .login-card {
                padding: 1.5rem;
            }
            
            .dev-badge {
                display: none;
            }
        }
        
        /* Hidden honeypot */
        .honeypot {
            position: absolute;
            left: -5000px;
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-futbol"></i>
                </div>
                <h1 class="login-title">Hoş Geldiniz</h1>
                <p class="login-subtitle">Devam etmek için giriş yapın</p>
            </div>
            
            <!-- Error Alert -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-destructive">
                    <i class="fas fa-exclamation-circle"></i>
                    <div class="alert-content">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Session Expired Alert -->
            <?php if (isset($_GET['expired']) && $_GET['expired'] == '1'): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-clock"></i>
                    <div class="alert-content">
                        Oturumunuz zaman aşımına uğradı. Lütfen tekrar giriş yapınız.
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Login Form -->
            <form method="POST" action="<?php echo BASE_URL; ?>/admin/login" id="adminLoginForm">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                
                <!-- Honeypot field (hidden from users, for bot protection) -->
                <div class="honeypot" aria-hidden="true">
                    <input type="text" name="website" tabindex="-1" autocomplete="off" value="">
                </div>
                
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email" class="form-label">E-posta</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        placeholder="ornek@sporkulubu.com"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        required
                        autofocus
                    >
                </div>
                
                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="form-label">Şifre</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        placeholder="••••••••"
                        required
                    >
                </div>
                
                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary w-100" id="loginButton">
                        <i class="fas fa-arrow-right"></i>
                        <span>Giriş Yap</span>
                    </button>
                </div>
            </form>
            
            <!-- Forgot Password Link -->
            <div class="text-center mt-4">
                <a href="<?php echo BASE_URL; ?>/admin/auth/forgot-password" class="text-link">
                    <span>Şifremi Unuttum</span>
                </a>
            </div>
            
            <div class="divider"></div>
            
            <!-- Security Notice -->
            <div class="text-center">
                <div class="text-muted">
                    <i class="fas fa-shield-halved"></i>
                    <span>Güvenli bağlantı</span>
                </div>
            </div>
            
            <!-- Back to Site -->
            <div class="text-center mt-6">
                <a href="<?php echo BASE_URL; ?>" class="text-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>Ana Siteye Dön</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Development Test Credentials -->
    <div class="dev-badge">
        <strong>Test Hesabı</strong>
        E-posta: admin@sporkulubu.com<br>
        Şifre: password
    </div>
    
    <script>
        // Form submission loading state
        document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
            const button = document.getElementById('loginButton');
            button.classList.add('btn-loading');
            button.disabled = true;
        });
        
        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    </script>
</body>
</html>