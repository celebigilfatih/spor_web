<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Yönetim Paneli</title>
    
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="http://localhost:8090/css/style.css" rel="stylesheet">
    <link href="http://localhost:8090/css/admin.css" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Fallback CSS - Navy Blue Theme -->
    <style>
    body{font-family:'Inter',Arial,sans-serif;margin:0;background:#f1f5f9;color:#1e293b;}
    .admin-layout{display:flex;min-height:100vh;}
    .admin-sidebar{width:256px;background:#1e3c72;color:white;position:fixed;height:100vh;overflow-y:auto;}
    .admin-content{flex:1;margin-left:256px;}
    .admin-header{background:white;padding:1rem 2rem;border-bottom:1px solid #e2e8f0;}
    .admin-main-content{padding:2rem;}
    .sidebar-header{padding:1.5rem;border-bottom:1px solid #2563eb;}
    .sidebar-logo{font-size:1.25rem;font-weight:700;color:#ffd700;margin-bottom:0.5rem;}
    .sidebar-menu{list-style:none;padding:1rem;margin:0;}
    .sidebar-menu-link{display:flex;align-items:center;padding:0.75rem 1rem;color:#e2e8f0;text-decoration:none;border-radius:6px;}
    .sidebar-menu-link:hover{background:#2563eb;color:white;}
    .sidebar-menu-icon{margin-right:0.75rem;width:18px;}
    .btn{padding:0.5rem 1rem;border-radius:6px;text-decoration:none;font-weight:500;}
    .btn-outline{background:transparent;color:#1e3c72;border:1px solid #e2e8f0;}
    .btn-admin-secondary{background:#ffd700;color:#1e293b;}
    .btn-admin-danger{background:#dc2626;color:white;}
    </style>
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
                    <i class="fas fa-futbol"></i>
                    SPOR KULÜBÜ
                </div>
                <p>Yönetim Paneli</p>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="http://localhost:8090/admin/dashboard" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="http://localhost:8090/admin/news" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-newspaper"></i>
                            Haberler
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="http://localhost:8090/admin/players" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-users"></i>
                            Oyuncular
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="http://localhost:8090/admin/teams" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-shield-alt"></i>
                            Takımlar
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="http://localhost:8090/admin/staff" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-user-tie"></i>
                            Teknik Kadro
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="http://localhost:8090/admin/matches" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-calendar"></i>
                            Maçlar
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item">
                        <a href="http://localhost:8090/admin/settings" class="sidebar-menu-link">
                            <i class="sidebar-menu-icon fas fa-cog"></i>
                            Ayarlar
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
                    <h1><?php echo $title; ?></h1>
                </div>
                
                <div class="admin-user-menu">
                    <div class="admin-user-info">
                        <div class="admin-user-avatar">
                            <?php echo strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1)); ?>
                        </div>
                        <span>Hoş geldiniz, <?php echo $_SESSION['admin_username'] ?? 'Admin'; ?></span>
                    </div>
                    
                    <div class="admin-actions">
                        <a href="http://localhost:8090" class="btn btn-outline" target="_blank">
                            <i class="fas fa-external-link-alt"></i> Siteyi Görüntüle
                        </a>
                        <a href="http://localhost:8090/admin/auth/profile" class="btn btn-admin-secondary">
                            <i class="fas fa-user"></i> Profil
                        </a>
                        <a href="http://localhost:8090/admin/auth/logout" class="btn btn-admin-danger">
                            <i class="fas fa-sign-out-alt"></i> Çıkış
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-main-content">
                <?php if (isset($message) && !empty($message)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php echo $content; ?>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
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