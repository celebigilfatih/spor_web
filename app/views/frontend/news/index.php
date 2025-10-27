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
                    <a href="' . BASE_URL . '/haberler" class="btn btn-outline-primary ' . (!isset($category) ? 'active' : '') . '">
                        Tüm Haberler
                    </a>
                    <a href="' . BASE_URL . '/haberler/category/haber" class="btn btn-outline-primary ' . (isset($category) && $category === 'haber' ? 'active' : '') . '">
                        Genel Haberler
                    </a>
                    <a href="' . BASE_URL . '/haberler/category/duyuru" class="btn btn-outline-primary ' . (isset($category) && $category === 'duyuru' ? 'active' : '') . '">
                        Duyurular
                    </a>
                    <a href="' . BASE_URL . '/haberler/category/mac_sonucu" class="btn btn-outline-primary ' . (isset($category) && $category === 'mac_sonucu' ? 'active' : '') . '">
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
                    <form action="' . BASE_URL . '/haberler/search" method="GET">
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
                                        <img src="' . BASE_URL . '/uploads/' . ($article['image'] ?? 'default-news.jpg') . '" 
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

                <!-- Match Results -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">SON MAÇ SONUÇLARI</h3>
                    <div class="match-results-list">
                        ' . (isset($recent_results) && !empty($recent_results) ? 
                            implode('', array_map(function($match) {
                                $matchDate = date('d.m.Y', strtotime($match['match_date']));
                                $homeScore = $match['home_score'] ?? '-';
                                $awayScore = $match['away_score'] ?? '-';
                                
                                return '
                                <div class="match-result-item">
                                    <div class="match-date-small">
                                        <i class="fas fa-calendar"></i> ' . $matchDate . '
                                    </div>
                                    <div class="match-teams-score">
                                        <div class="team-row">
                                            <span class="team-name">' . htmlspecialchars($match['home_team']) . '</span>
                                            <span class="score">' . $homeScore . '</span>
                                        </div>
                                        <div class="team-row">
                                            <span class="team-name">' . htmlspecialchars($match['away_team']) . '</span>
                                            <span class="score">' . $awayScore . '</span>
                                        </div>
                                    </div>
                                    ' . (!empty($match['venue']) ? '<div class="match-venue-small"><i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($match['venue']) . '</div>' : '') . '
                                </div>';
                            }, $recent_results)) : 
                            '<p class="text-muted">Henüz maç sonucu bulunmamaktadır.</p>'
                        ) . '
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

<style>
.match-results-list {
    margin-top: 1rem;
}

.match-result-item {
    background: #f8f9fa;
    border-left: 3px solid #1e3a8a;
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.match-result-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.match-date-small {
    font-size: 0.75rem;
    color: #666;
    margin-bottom: 0.5rem;
}

.match-date-small i {
    margin-right: 0.25rem;
}

.match-teams-score {
    margin: 0.5rem 0;
}

.team-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.4rem 0;
    border-bottom: 1px solid #dee2e6;
}

.team-row:last-child {
    border-bottom: none;
}

.team-name {
    font-weight: 600;
    color: #1e3a8a;
    font-size: 0.9rem;
}

.score {
    font-size: 1.1rem;
    font-weight: 700;
    color: #dc3545;
    background: white;
    padding: 0.25rem 0.75rem;
    border-radius: 4px;
    min-width: 35px;
    text-align: center;
}

.match-venue-small {
    font-size: 0.75rem;
    color: #888;
    margin-top: 0.5rem;
    font-style: italic;
}

.match-venue-small i {
    margin-right: 0.25rem;
}
</style>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>