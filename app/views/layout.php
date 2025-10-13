<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Spor Kulübü'; ?></title>
    <meta name="description" content="<?php echo $site_settings['site_description'] ?? 'Modern ve dinamik spor kulübü'; ?>">
    
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/css/style.css" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/images/favicon.ico">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <!-- Top Bar -->
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <div class="contact-info">
                            <span><i class="fas fa-phone"></i> <?php echo $site_settings['contact_phone'] ?? '+90 212 123 45 67'; ?></span>
                            <span class="ms-3"><i class="fas fa-envelope"></i> <?php echo $site_settings['contact_email'] ?? 'info@sporkulubu.com'; ?></span>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="social-links">
                            <?php if (isset($site_settings['social_facebook'])): ?>
                                <a href="<?php echo $site_settings['social_facebook']; ?>" target="_blank"><i class="fab fa-facebook"></i></a>
                            <?php endif; ?>
                            <?php if (isset($site_settings['social_twitter'])): ?>
                                <a href="<?php echo $site_settings['social_twitter']; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                            <?php endif; ?>
                            <?php if (isset($site_settings['social_instagram'])): ?>
                                <a href="<?php echo $site_settings['social_instagram']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if (isset($site_settings['social_youtube'])): ?>
                                <a href="<?php echo $site_settings['social_youtube']; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Header -->
        <div class="header-main">
            <div class="container">
                <nav class="navbar">
                    <div class="logo">
                        <a href="<?php echo BASE_URL; ?>"><?php echo $site_settings['site_title'] ?? 'SPOR KULÜBÜ'; ?></a>
                    </div>
                    
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>" class="nav-link">Ana Sayfa</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/home/about" class="nav-link">Hakkımızda</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/teams" class="nav-link">Takımlar</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/teams/first" class="nav-link">A Takım</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/teams/staff" class="nav-link">Teknik Kadro</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/news" class="nav-link">Haberler</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/home/contact" class="nav-link">İletişim</a>
                        </li>
                    </ul>
                    
                    <div class="mobile-menu-toggle">
                        <i class="fas fa-bars"></i>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main">
        <?php echo $content; ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Spor Kulübü</h4>
                    <p><?php echo $site_settings['site_description'] ?? 'Modern ve dinamik spor kulübü olarak gençleri sporla buluşturuyor, başarılı sporcular yetiştiriyoruz.'; ?></p>
                    <div class="social-icons">
                        <?php if (isset($site_settings['social_facebook'])): ?>
                            <a href="<?php echo $site_settings['social_facebook']; ?>" class="social-icon" target="_blank">
                                <i class="fab fa-facebook"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (isset($site_settings['social_twitter'])): ?>
                            <a href="<?php echo $site_settings['social_twitter']; ?>" class="social-icon" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (isset($site_settings['social_instagram'])): ?>
                            <a href="<?php echo $site_settings['social_instagram']; ?>" class="social-icon" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (isset($site_settings['social_youtube'])): ?>
                            <a href="<?php echo $site_settings['social_youtube']; ?>" class="social-icon" target="_blank">
                                <i class="fab fa-youtube"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4>Hızlı Linkler</h4>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>">Ana Sayfa</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/home/about">Hakkımızda</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/teams">Takımlarımız</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/teams/first">A Takım</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/news">Haberler</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/home/contact">İletişim</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Takımlarımız</h4>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>/teams/first">A Takım</a></li>
                        <li><a href="#" onclick="return false;">U19 Takımı</a></li>
                        <li><a href="#" onclick="return false;">U16 Takımı</a></li>
                        <li><a href="#" onclick="return false;">U14 Takımı</a></li>
                        <li><a href="#" onclick="return false;">U12 Takımı</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>İletişim Bilgileri</h4>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> <?php echo $site_settings['contact_address'] ?? 'İstanbul, Türkiye'; ?></li>
                        <li><i class="fas fa-phone"></i> <?php echo $site_settings['contact_phone'] ?? '+90 212 123 45 67'; ?></li>
                        <li><i class="fas fa-envelope"></i> <?php echo $site_settings['contact_email'] ?? 'info@sporkulubu.com'; ?></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo $site_settings['site_title'] ?? 'Spor Kulübü'; ?>. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="<?php echo BASE_URL; ?>/js/main.js"></script>
</body>
</html>