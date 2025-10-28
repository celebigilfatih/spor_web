<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-5 fw-bold mb-2">' . htmlspecialchars($news['title'] ?? '') . '</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/haberler" class="text-warning">Haberler</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">' . htmlspecialchars(substr($news['title'] ?? '', 0, 50)) . '...</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- News Detail Content -->
<section class="news-detail-section py-5">
    <div class="container">
        <div class="row">
            
            <!-- Main Content -->
            <div class="col-lg-10 mb-5">
                <article class="news-detail-article">
                    
                    <!-- Featured Image -->
                    ' . (!empty($news['image']) ? '
                    <div class="news-featured-image mb-4">
                        <img src="' . BASE_URL . '/uploads/' . $news['image'] . '" 
                             alt="' . htmlspecialchars($news['title']) . '" 
                             class="img-fluid rounded">
                    </div>
                    ' : '') . '
                    
                    <!-- Article Meta -->
                    <div class="article-meta mb-4 pb-3 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="meta-info d-flex flex-wrap gap-3">
                                    <span class="meta-item">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        ' . date('d F Y, H:i', strtotime($news['published_at'] ?? $news['created_at'])) . '
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        ' . htmlspecialchars($news['author'] ?? 'Spor Kulübü') . '
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-tag text-primary me-2"></i>
                                        ' . htmlspecialchars(ucfirst($news['category'] ?? 'Genel')) . '
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-eye text-primary me-2"></i>
                                        ' . ($news['views'] ?? 0) . ' görüntülenme
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <div class="social-share">
                                    <span class="me-2">Paylaş:</span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=' . urlencode(BASE_URL . '/news/detail/' . $news['slug']) . '" 
                                       target="_blank" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=' . urlencode(BASE_URL . '/news/detail/' . $news['slug']) . '&text=' . urlencode($news['title']) . '" 
                                       target="_blank" class="btn btn-sm btn-outline-info me-1">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://wa.me/?text=' . urlencode($news['title'] . ' - ' . BASE_URL . '/news/detail/' . $news['slug']) . '" 
                                       target="_blank" class="btn btn-sm btn-outline-success">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Article Content -->
                    <div class="article-content">
                        ' . (!empty($news['excerpt']) ? '
                        <div class="article-excerpt mb-4 p-3 bg-light rounded">
                            <p class="lead mb-0">' . nl2br(htmlspecialchars($news['excerpt'])) . '</p>
                        </div>
                        ' : '') . '
                        
                        <div class="article-body">
                            ' . nl2br(htmlspecialchars($news['content'])) . '
                        </div>
                    </div>
                    
                    <!-- Article Tags -->
                    ' . (!empty($news['tags']) ? '
                    <div class="article-tags mt-4 pt-4 border-top">
                        <h5 class="mb-3"><i class="fas fa-tags me-2"></i>Etiketler:</h5>
                        <div class="tags-list">
                            ' . implode('', array_map(function($tag) {
                                return '<span class="badge bg-secondary me-2 mb-2">' . htmlspecialchars(trim($tag)) . '</span>';
                            }, explode(',', $news['tags']))) . '
                        </div>
                    </div>
                    ' : '') . '
                    
                </article>
                
                <!-- Related News -->
                ' . (isset($related_news) && !empty($related_news) ? '
                <div class="related-news mt-5">
                    <h3 class="section-title mb-4">
                        <i class="fas fa-newspaper me-2"></i>
                        İlgili Haberler
                    </h3>
                    <div class="row">
                        ' . implode('', array_map(function($article) {
                            return '
                            <div class="col-md-6 mb-4">
                                <div class="news-card h-100">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <div class="news-image h-100">
                                                <img src="' . BASE_URL . '/uploads/' . ($article['image'] ?? 'default-news.jpg') . '" 
                                                     alt="' . htmlspecialchars($article['title']) . '" 
                                                     class="img-fluid h-100 w-100" style="object-fit: cover;">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="news-content p-3">
                                                <h5 class="news-title mb-2">
                                                    <a href="' . BASE_URL . '/news/detail/' . $article['slug'] . '">
                                                        ' . htmlspecialchars($article['title']) . '
                                                    </a>
                                                </h5>
                                                <div class="news-meta">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        ' . date('d.m.Y', strtotime($article['published_at'] ?? $article['created_at'])) . '
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }, $related_news)) . '
                    </div>
                </div>
                ' : '') . '
            </div>
            
        </div>
    </div>
</section>

<style>
.news-detail-article {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content h2,
.article-content h3,
.article-content h4 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #1e3a8a;
}

.sidebar-widget {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.widget-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1e3a8a;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f0f0f0;
}

.category-item {
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
}

.category-item:hover {
    background-color: #f0f7ff !important;
    color: #1e3a8a;
    transform: translateX(5px);
}

.latest-news-item h6 a {
    text-decoration: none;
    color: #333;
    transition: color 0.3s ease;
}

.latest-news-item h6 a:hover {
    color: #1e3a8a;
}

.newsletter-widget {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
}

.newsletter-widget .widget-title {
    color: white;
    border-bottom-color: rgba(255,255,255,0.2);
}

.social-share a {
    width: 35px;
    height: 35px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 1.5rem 0;
}

.article-excerpt {
    border-left: 4px solid #1e3a8a;
}
</style>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>
