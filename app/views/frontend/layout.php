<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : ($site_settings['site_title'] ?? 'Spor Kulübü') ?></title>
    <meta name="description" content="<?= isset($description) ? $description : ($site_settings['site_description'] ?? 'Spor Kulübü Resmi Web Sitesi') ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS inspired by Fenerbahçe -->
    <link href="<?= BASE_URL ?>/css/style.css?v=<?= time() ?>" rel="stylesheet">
    
    <!-- Additional page styles -->
    <?php if (isset($additional_css)): ?>
        <?= $additional_css ?>
    <?php endif; ?>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= !empty($site_settings['site_favicon']) ? BASE_URL . '/uploads/' . $site_settings['site_favicon'] : BASE_URL . '/images/favicon.ico' ?>">
</head>
<body>
    <!-- Header -->
    <header class="header-wrapper">
        <!-- Top Bar -->
        <div class="top-bar px-5">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="contact-info">
                            <span><i class="fas fa-phone"></i> <?= $site_settings['contact_phone'] ?? '+90 (212) 555-0123' ?></span>
                            <span><i class="fas fa-envelope"></i> <?= $site_settings['contact_email'] ?? 'info@sporkulubu.com' ?></span>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="social-links">
                            <?php if (!empty($site_settings['facebook_url'])): ?>
                            <a href="<?= $site_settings['facebook_url'] ?>" class="social-link" target="_blank"><i class="fab fa-facebook"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($site_settings['twitter_url'])): ?>
                            <a href="<?= $site_settings['twitter_url'] ?>" class="social-link" target="_blank"><i class="fab fa-twitter"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($site_settings['instagram_url'])): ?>
                            <a href="<?= $site_settings['instagram_url'] ?>" class="social-link" target="_blank"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($site_settings['youtube_url'])): ?>
                            <a href="<?= $site_settings['youtube_url'] ?>" class="social-link" target="_blank"><i class="fab fa-youtube"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-5">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>">
                    <?php if (!empty($site_settings['site_logo']) && file_exists(BASE_PATH . '/public/uploads/' . $site_settings['site_logo'])): ?>
                    <img src="<?= BASE_URL . '/uploads/' . $site_settings['site_logo'] ?>" alt="<?= $site_settings['site_title'] ?? 'Logo' ?>" height="75" class="me-2">
                    <?php elseif (file_exists(BASE_PATH . '/public/images/logo.png')): ?>
                    <img src="<?= BASE_URL ?>/images/logo.png" alt="Logo" height="50" class="me-2">
                    <?php else: ?>
                    <div class="logo-placeholder bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 50px; height: 50px; font-weight: bold; font-size: 1.5em;">
                        <?= strtoupper(substr($site_settings['site_title'] ?? 'SK', 0, 2)) ?>
                    </div>
                    <?php endif; ?>
                    <span class="fw-bold"><?= strtoupper($site_settings['site_title'] ?? 'SPOR KULÜBÜ') ?></span>
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
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/hakkimizda">Kulüp Hakkında</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/hakkimizda/history">Tarihçe</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/hakkimizda/achievements">Başarılar</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/ateam/squad?tab=board"><i class="fas fa-users-cog me-2"></i>Yönetim Kurulu</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/gruplar">GRUPLAR</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/teknik-kadro">TEKNİK KADRO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/haberler">HABERLER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/iletisim">İLETİŞİM</a>
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
        <div class="container-fluid px-5">
            <div class="row py-5">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-warning mb-3"><?= strtoupper($site_settings['site_title'] ?? 'SPOR KULÜBÜ') ?></h5>
                    <p><?= $site_settings['site_description'] ?? 'Türkiye\'nin en köklü spor kulüplerinden biri olarak, genç yetenekleri keşfetmek ve geliştirmek misyonuyla çalışıyoruz.' ?></p>
                    <div class="social-links mt-3">
                        <?php if (!empty($site_settings['facebook_url'])): ?>
                        <a href="<?= $site_settings['facebook_url'] ?>" class="social-link me-3" target="_blank"><i class="fab fa-facebook fa-lg"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site_settings['twitter_url'])): ?>
                        <a href="<?= $site_settings['twitter_url'] ?>" class="social-link me-3" target="_blank"><i class="fab fa-twitter fa-lg"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site_settings['instagram_url'])): ?>
                        <a href="<?= $site_settings['instagram_url'] ?>" class="social-link me-3" target="_blank"><i class="fab fa-instagram fa-lg"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site_settings['youtube_url'])): ?>
                        <a href="<?= $site_settings['youtube_url'] ?>" class="social-link" target="_blank"><i class="fab fa-youtube fa-lg"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-warning mb-3">HIZLI BAĞLANTILAR</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE_URL ?>" class="footer-link">Ana Sayfa</a></li>
                        <li><a href="<?= BASE_URL ?>/hakkimizda" class="footer-link">Hakkımızda</a></li>
                        <li><a href="<?= BASE_URL ?>/gruplar" class="footer-link">Gruplar</a></li>
                        <li><a href="<?= BASE_URL ?>/a-takimi" class="footer-link">A Takımı</a></li>
                        <li><a href="<?= BASE_URL ?>/haberler" class="footer-link">Haberler</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-warning mb-3">İLETİŞİM</h6>
                    <ul class="list-unstyled contact-info">
                        <li><i class="fas fa-map-marker-alt me-2"></i> <?= $site_settings['contact_address'] ?? 'Spor Caddesi No:123, İstanbul' ?></li>
                        <li><i class="fas fa-phone me-2"></i> <?= $site_settings['contact_phone'] ?? '+90 (212) 555-0123' ?></li>
                        <li><i class="fas fa-envelope me-2"></i> <?= $site_settings['contact_email'] ?? 'info@sporkulubu.com' ?></li>
                        <li><i class="fas fa-clock me-2"></i> Pazartesi-Cuma: 09:00-18:00</li>
                    </ul>
                </div>
                
                <div class="col-lg-3 mb-4">
                    <h6 class="text-warning mb-3">HABERLER</h6>
                    <p>En son haberleri ve gelişmeleri takip edin.</p>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?= date('Y') ?> <?= $site_settings['site_title'] ?? 'Spor Kulübü' ?>. Tüm hakları saklıdır.</p>
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