<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Spor Kulübü' ?></title>
    <meta name="description" content="<?= isset($description) ? $description : 'Spor Kulübü Resmi Web Sitesi' ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS inspired by Fenerbahçe -->
    <link href="<?= BASE_URL ?>/css/style.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico">
</head>
<body>
    <!-- Header -->
    <header class="header-wrapper">
        <!-- Top Bar -->
        <div class="top-bar bg-navy">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="contact-info">
                            <span><i class="fas fa-phone"></i> +90 (212) 555-0123</span>
                            <span><i class="fas fa-envelope"></i> info@sporkulubu.com</span>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="<?= BASE_URL ?>">
                    <img src="<?= BASE_URL ?>/images/logo.png" alt="Logo" height="50" class="me-2">
                    <span class="fw-bold">SPOR KULÜBÜ</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>">ANA SAYFA</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                HAKKIMIZDA
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/about">Kulüp Hakkında</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/about/history">Tarihçe</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/about/achievements">Başarılar</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/groups">GRUPLAR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/ateam">A TAKIMI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/technical-staff">TEKNİK KADRO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/news">HABERLER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/home/contact">İLETİŞİM</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if (isset($message) && $message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Page Content -->
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="footer bg-dark text-light">
        <div class="container">
            <div class="row py-5">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-warning mb-3">SPOR KULÜBÜ</h5>
                    <p>Türkiye'nin en köklü spor kulüplerinden biri olarak, genç yetenekleri keşfetmek ve geliştirmek misyonuyla çalışıyoruz.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="social-link me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="social-link me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="social-link me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-warning mb-3">HIZLI BAĞLANTILAR</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE_URL ?>" class="footer-link">Ana Sayfa</a></li>
                        <li><a href="<?= BASE_URL ?>/about" class="footer-link">Hakkımızda</a></li>
                        <li><a href="<?= BASE_URL ?>/groups" class="footer-link">Gruplar</a></li>
                        <li><a href="<?= BASE_URL ?>/ateam" class="footer-link">A Takımı</a></li>
                        <li><a href="<?= BASE_URL ?>/news" class="footer-link">Haberler</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-warning mb-3">İLETİŞİM</h6>
                    <ul class="list-unstyled contact-info">
                        <li><i class="fas fa-map-marker-alt me-2"></i> Spor Caddesi No:123, İstanbul</li>
                        <li><i class="fas fa-phone me-2"></i> +90 (212) 555-0123</li>
                        <li><i class="fas fa-envelope me-2"></i> info@sporkulubu.com</li>
                        <li><i class="fas fa-clock me-2"></i> Pazartesi-Cuma: 09:00-18:00</li>
                    </ul>
                </div>
                
                <div class="col-lg-3 mb-4">
                    <h6 class="text-warning mb-3">HABERLER</h6>
                    <p>En son haberleri ve gelişmeleri e-posta ile takip edin.</p>
                    <form class="newsletter-form">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="E-posta adresiniz">
                            <button class="btn btn-warning" type="submit">Abone Ol</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?= date('Y') ?> Spor Kulübü. Tüm hakları saklıdır.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= BASE_URL ?>/legal/privacy" class="footer-link me-3">Gizlilik Politikası</a>
                    <a href="<?= BASE_URL ?>/legal/terms" class="footer-link">Kullanım Şartları</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>/js/main.js"></script>
    
    <!-- Additional page scripts -->
    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= BASE_URL ?>/js/<?= $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>