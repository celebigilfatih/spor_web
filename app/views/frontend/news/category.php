<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">' . strtoupper($category_name ?? 'HABERLER') . '</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/news" class="text-warning">Haberler</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">' . ($category_name ?? 'Kategori') . '</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- News Categories -->
<section class="news-categories py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="categories-nav">
                    <a href="' . BASE_URL . '/news" class="btn btn-outline-primary">
                        Tüm Haberler
                    </a>
                    <a href="' . BASE_URL . '/news/category/haber" class="btn btn-outline-primary ' . ($category === 'haber' ? 'active' : '') . '">
                        Genel Haberler
                    </a>
                    <a href="' . BASE_URL . '/news/category/duyuru" class="btn btn-outline-primary ' . ($category === 'duyuru' ? 'active' : '') . '">
                        Duyurular
                    </a>
                    <a href="' . BASE_URL . '/news/category/mac_sonucu" class="btn btn-outline-primary ' . ($category === 'mac_sonucu' ? 'active' : '') . '">
                        Maç Sonuçları
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News Content -->
<section class="news-content py-5">
    <div class="container">
        <div class="row">
            
            <!-- Main News List -->
            <div class="col-lg-8 mb-5">
                <div class="news-grid">
                    ' . (isset($news) && !empty($news) ? 
                        implode('', array_map(function($article) {
                            return '
                            <article class="news-article mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="news-image">
                                            <img src="' . BASE_URL . '/uploads/' . ($article['image'] ?? 'default-news.jpg') . '" 
                                                 alt="' . htmlspecialchars($article['title'] ?? '') . '" 
                                                 class="img-fluid rounded">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="news-content">
                                            <div class="news-meta mb-2">
                                                <span class="badge bg-primary me-2">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    ' . date('d.m.Y', strtotime($article['created_at'] ?? 'now')) . '
                                                </span>
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-tag me-1"></i>
                                                    ' . ucfirst($article['category'] ?? 'Haber') . '
                                                </span>
                                            </div>
                                            <h3 class="news-title h5 mb-2">
                                                <a href="' . BASE_URL . '/news/detail/' . ($article['slug'] ?? '') . '" class="text-decoration-none text-dark">
                                                    ' . htmlspecialchars($article['title'] ?? '') . '
                                                </a>
                                            </h3>
                                            <p class="news-excerpt text-muted mb-3">
                                                ' . substr(strip_tags($article['content'] ?? ''), 0, 150) . '...
                                            </p>
                                            <div class="news-actions d-flex justify-content-between align-items-center">
                                                <a href="' . BASE_URL . '/news/detail/' . ($article['slug'] ?? '') . '" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-arrow-right me-1"></i>
                                                    Devamını Oku
                                                </a>
                                                <span class="views-count text-muted small">
                                                    <i class="fas fa-eye me-1"></i>
                                                    ' . ($article['views'] ?? 0) . ' görüntülenme
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-4">
                            </article>';
                        }, $news)) : 
                        '
                        <div class="col-12">
                            <div class="no-news text-center py-5">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <h3>Bu kategoride henüz haber bulunmamaktadır</h3>
                                <p class="text-muted">Yakında yeni haberler yayınlanacak.</p>
                                <a href="' . BASE_URL . '/news" class="btn btn-primary mt-3">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Tüm Haberlere Dön
                                </a>
                            </div>
                        </div>'
                    ) . '
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                
                <!-- Category Info -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">' . strtoupper($category_name ?? 'KATEGORİ') . '</h3>
                    <div class="category-info p-3 bg-light rounded">
                        <p class="mb-2">
                            <i class="fas fa-newspaper text-primary me-2"></i>
                            <strong>Toplam Haber:</strong> ' . (isset($news) ? count($news) : 0) . '
                        </p>
                        <p class="mb-0 text-muted small">
                            Bu kategorideki haberleri görüntülüyorsunuz.
                        </p>
                    </div>
                </div>

                <!-- Search Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">HABER ARAMA</h3>
                    <form action="' . BASE_URL . '/news/search" method="GET">
                        <div class="search-form">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" 
                                       placeholder="Haber ara..." value="' . ($_GET['q'] ?? '') . '">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Categories Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">KATEGORİLER</h3>
                    <div class="list-group">
                        <a href="' . BASE_URL . '/news" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Tüm Haberler
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="' . BASE_URL . '/news/category/haber" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ' . ($category === 'haber' ? 'active' : '') . '">
                            Genel Haberler
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="' . BASE_URL . '/news/category/duyuru" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ' . ($category === 'duyuru' ? 'active' : '') . '">
                            Duyurular
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="' . BASE_URL . '/news/category/mac_sonucu" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ' . ($category === 'mac_sonucu' ? 'active' : '') . '">
                            Maç Sonuçları
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">HABER BÜLTENİ</h3>
                    <p>Son haberleri e-posta ile almak için kayıt olun.</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="E-posta adresiniz" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-envelope me-2"></i>
                            Kayıt Ol
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>
