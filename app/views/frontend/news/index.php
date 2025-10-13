<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">HABERLER</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Haberler</li>
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
                    <a href="' . BASE_URL . '/news" class="btn btn-outline-primary ' . (!isset($category) ? 'active' : '') . '">
                        Tüm Haberler
                    </a>
                    <a href="' . BASE_URL . '/news/category/haber" class="btn btn-outline-primary ' . (isset($category) && $category === 'haber' ? 'active' : '') . '">
                        Genel Haberler
                    </a>
                    <a href="' . BASE_URL . '/news/category/duyuru" class="btn btn-outline-primary ' . (isset($category) && $category === 'duyuru' ? 'active' : '') . '">
                        Duyurular
                    </a>
                    <a href="' . BASE_URL . '/news/category/mac_sonucu" class="btn btn-outline-primary ' . (isset($category) && $category === 'mac_sonucu' ? 'active' : '') . '">
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
                                            <img src="' . BASE_URL . '/public/uploads/' . ($article['image'] ?? 'default-news.jpg') . '" 
                                                 alt="' . htmlspecialchars($article['title'] ?? '') . '" 
                                                 class="img-fluid rounded">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="news-content">
                                            <div class="news-meta">
                                                <span class="news-date">
                                                    <i class="fas fa-calendar"></i>
                                                    ' . date('d.m.Y', strtotime($article['created_at'] ?? 'now')) . '
                                                </span>
                                                <span class="news-category">
                                                    <i class="fas fa-tag"></i>
                                                    ' . ucfirst($article['category'] ?? 'Haber') . '
                                                </span>
                                            </div>
                                            <h3 class="news-title">
                                                <a href="' . BASE_URL . '/news/detail/' . ($article['slug'] ?? '') . '">
                                                    ' . htmlspecialchars($article['title'] ?? '') . '
                                                </a>
                                            </h3>
                                            <p class="news-excerpt">
                                                ' . substr(strip_tags($article['content'] ?? ''), 0, 150) . '...
                                            </p>
                                            <div class="news-actions">
                                                <a href="' . BASE_URL . '/news/detail/' . ($article['slug'] ?? '') . '" 
                                                   class="btn btn-primary btn-sm">
                                                    Devamını Oku
                                                </a>
                                                <span class="views-count">
                                                    <i class="fas fa-eye"></i>
                                                    ' . ($article['views'] ?? 0) . ' görüntülenme
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>';
                        }, $news)) : 
                        '
                        <div class="col-12">
                            <div class="no-news text-center py-5">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <h3>Henüz haber bulunmamaktadır</h3>
                                <p class="text-muted">Yakında yeni haberler yayınlanacak.</p>
                            </div>
                        </div>'
                    ) . '
                </div>
                
                <!-- Pagination -->
                <nav aria-label="Sayfa navigasyonu">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <span class="page-link">Önceki</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Sonraki</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                
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

                <!-- Featured News -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">ÖNE ÇIKANLAR</h3>
                    <div class="featured-news-list">
                        ' . (isset($featured_news) && !empty($featured_news) ? 
                            implode('', array_map(function($article) {
                                return '
                                <div class="featured-news-item">
                                    <div class="featured-image">
                                        <img src="' . BASE_URL . '/public/uploads/' . ($article['image'] ?? 'default-news.jpg') . '" 
                                             alt="' . htmlspecialchars($article['title'] ?? '') . '">
                                    </div>
                                    <div class="featured-content">
                                        <h5 class="featured-title">
                                            <a href="' . BASE_URL . '/news/detail/' . ($article['slug'] ?? '') . '">
                                                ' . htmlspecialchars($article['title'] ?? '') . '
                                            </a>
                                        </h5>
                                        <span class="featured-date">
                                            ' . date('d.m.Y', strtotime($article['created_at'] ?? 'now')) . '
                                        </span>
                                    </div>
                                </div>';
                            }, $featured_news)) : 
                            '<p class="text-muted">Öne çıkan haber bulunmamaktadır.</p>'
                        ) . '
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">HABER BÜLTENİ</h3>
                    <p>Son haberleri e-posta ile almak için kayıt olun.</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="E-posta adresiniz">
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