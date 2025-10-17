<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">ARAMA SONUÇLARI</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/news" class="text-warning">Haberler</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Arama</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Search Info -->
<section class="search-info py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info mb-0">
                    <i class="fas fa-search me-2"></i>
                    ' . (!empty($keyword) ? 
                        '<strong>"' . htmlspecialchars($keyword) . '"</strong> için <strong>' . (isset($results) ? count($results) : 0) . '</strong> sonuç bulundu.' :
                        'Arama yapmak için bir kelime girin.'
                    ) . '
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Results -->
<section class="search-results py-5">
    <div class="container">
        <div class="row">
            
            <!-- Results List -->
            <div class="col-lg-8 mb-5">
                ' . (!empty($keyword) ? 
                    (isset($results) && !empty($results) ? 
                        '<div class="results-grid">
                            ' . implode('', array_map(function($article) {
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
                                                    ' . substr(strip_tags($article['content'] ?? ''), 0, 200) . '...
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
                            }, $results)) . '
                        </div>' :
                        '<div class="no-results text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h3>Aradığınız kriterlere uygun sonuç bulunamadı</h3>
                            <p class="text-muted mb-4">Farklı kelimeler kullanarak tekrar deneyebilirsiniz.</p>
                            <a href="' . BASE_URL . '/news" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Tüm Haberlere Dön
                            </a>
                        </div>'
                    ) :
                    '<div class="no-search text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h3>Haber araması yapın</h3>
                        <p class="text-muted">Aramak istediğiniz kelimeyi sağ taraftaki arama kutusuna girin.</p>
                    </div>'
                ) . '
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                
                <!-- Search Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">HABER ARAMA</h3>
                    <form action="' . BASE_URL . '/news/search" method="GET">
                        <div class="search-form">
                            <div class="input-group mb-3">
                                <input type="text" name="q" class="form-control" 
                                       placeholder="Haber ara..." 
                                       value="' . htmlspecialchars($keyword ?? '') . '"
                                       required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Başlık veya içerik arama
                        </small>
                    </form>
                </div>

                <!-- Search Tips -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">ARAMA İPUÇLARI</h3>
                    <div class="search-tips p-3 bg-light rounded">
                        <ul class="mb-0 ps-3">
                            <li class="mb-2">
                                <small>Birden fazla kelime arayabilirsiniz</small>
                            </li>
                            <li class="mb-2">
                                <small>Başlık ve içerik aranır</small>
                            </li>
                            <li class="mb-2">
                                <small>En güncel haberler önce gösterilir</small>
                            </li>
                            <li>
                                <small>Maksimum 20 sonuç gösterilir</small>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Categories Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">KATEGORİLER</h3>
                    <div class="list-group">
                        <a href="' . BASE_URL . '/news" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Tüm Haberler
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="' . BASE_URL . '/news/category/haber" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Genel Haberler
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="' . BASE_URL . '/news/category/duyuru" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Duyurular
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="' . BASE_URL . '/news/category/mac_sonucu" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Maç Sonuçları
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Popular Searches -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">POPÜLER ARAMALAR</h3>
                    <div class="popular-searches">
                        <a href="' . BASE_URL . '/news/search?q=maç" class="badge bg-secondary me-2 mb-2">maç</a>
                        <a href="' . BASE_URL . '/news/search?q=galibiyet" class="badge bg-secondary me-2 mb-2">galibiyet</a>
                        <a href="' . BASE_URL . '/news/search?q=transfer" class="badge bg-secondary me-2 mb-2">transfer</a>
                        <a href="' . BASE_URL . '/news/search?q=antrenman" class="badge bg-secondary me-2 mb-2">antrenman</a>
                        <a href="' . BASE_URL . '/news/search?q=kadro" class="badge bg-secondary me-2 mb-2">kadro</a>
                        <a href="' . BASE_URL . '/news/search?q=gol" class="badge bg-secondary me-2 mb-2">gol</a>
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
