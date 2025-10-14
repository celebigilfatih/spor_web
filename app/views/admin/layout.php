<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Yönetim Paneli</title>
    
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/css/admin.css" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menu">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                    </svg>
                    Spor Kulübü
                </div>
                <p style="color:#71717a;font-size:0.75rem;margin:0;font-weight:500;">Yönetim Paneli</p>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/admin/dashboard" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-layout-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/admin/news" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-newspaper"></i>
                            <span>Haberler</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/admin/players" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-users"></i>
                            <span>Oyuncular</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/admin/teams" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-shield-alt"></i>
                            <span>Takımlar</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/admin/staff" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-user-tie"></i>
                            <span>Teknik Kadro</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/admin/matches" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-calendar"></i>
                            <span>Maçlar</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/admin/youth-registrations" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-user-graduate"></i>
                            <span>Alt Yapı Kayıtları</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/admin/settings" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-cog"></i>
                            <span>Ayarlar</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-content">
            <!-- Header -->
            <header class="admin-header">
                <div class="admin-breadcrumb">
                    <h1 style="font-size:1.5rem;font-weight:600;color:#09090b;margin:0;letter-spacing:-0.025em;"><?php echo $title; ?></h1>
                </div>
                
                <div class="admin-user-menu" style="display:flex;align-items:center;gap:1rem;">
                    <div class="admin-user-info" style="display:flex;align-items:center;gap:0.75rem;padding:0.5rem 0.75rem;background:#fafafa;border-radius:0.375rem;border:1px solid #e4e4e7;">
                        <div class="admin-user-avatar" style="width:32px;height:32px;border-radius:50%;background:#18181b;color:#fafafa;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:0.875rem;">
                            <?php echo strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1)); ?>
                        </div>
                        <span style="color:#09090b;font-weight:500;font-size:0.875rem;">Hoş geldiniz, <?php echo $_SESSION['admin_username'] ?? 'Admin'; ?></span>
                    </div>
                    
                    <div class="admin-actions" style="display:flex;gap:0.5rem;">
                        <a href="<?php echo BASE_URL; ?>" class="btn btn-outline" target="_blank">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            Siteyi Görüntüle
                        </a>
                        <a href="<?php echo BASE_URL; ?>/admin/auth/logout" class="btn btn-admin-danger">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Çıkış
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-main-content">
                <?php if (isset($message) && !empty($message)): ?>
                    <div class="alert alert-success" style="display:flex;align-items:center;gap:0.75rem;padding:1rem;border-radius:0.375rem;margin-bottom:1.5rem;background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;font-size:0.875rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert alert-danger" style="display:flex;align-items:center;gap:0.75rem;padding:1rem;border-radius:0.375rem;margin-bottom:1.5rem;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;font-size:0.875rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php echo $content; ?>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/js/main.js"></script>
    <script src="<?php echo BASE_URL; ?>/js/admin.js"></script>
    <script src="<?php echo BASE_URL; ?>/js/form-enhancements.js"></script>
    <script src="<?php echo BASE_URL; ?>/js/delete-confirmations.js"></script>
    
    <!-- Mobile Navigation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const adminSidebar = document.getElementById('adminSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            if (mobileMenuToggle && adminSidebar && sidebarOverlay) {
                function toggleSidebar() {
                    adminSidebar.classList.toggle('open');
                    sidebarOverlay.classList.toggle('show');
                    document.body.style.overflow = adminSidebar.classList.contains('open') ? 'hidden' : '';
                }
                
                mobileMenuToggle.addEventListener('click', toggleSidebar);
                sidebarOverlay.addEventListener('click', toggleSidebar);
                
                // Close sidebar when clicking on menu items on mobile
                const menuLinks = adminSidebar.querySelectorAll('.sidebar-menu-link');
                menuLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        if (window.innerWidth <= 768) {
                            toggleSidebar();
                        }
                    });
                });
                
                // Handle window resize
                window.addEventListener('resize', () => {
                    if (window.innerWidth > 768) {
                        adminSidebar.classList.remove('open');
                        sidebarOverlay.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                });
            }
            
            // Add active class to current page menu item
            const currentPath = window.location.pathname;
            const menuLinks = document.querySelectorAll('.sidebar-menu-link');
            menuLinks.forEach(link => {
                if (link.getAttribute('href') && currentPath.includes(link.getAttribute('href').split('/').pop())) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>