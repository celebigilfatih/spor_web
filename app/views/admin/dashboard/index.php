<?php
// Dashboard içeriği başlangıcı
ob_start();
?>

<!-- Dashboard Cards -->
<div class="dashboard-cards">
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <div class="dashboard-card-icon">
                <i class="fas fa-newspaper"></i>
            </div>
        </div>
        <div class="dashboard-card-number"><?php echo $stats['total_news']; ?></div>
        <div class="dashboard-card-label">Toplam Haber</div>
    </div>
    
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <div class="dashboard-card-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="dashboard-card-number"><?php echo $stats['total_players']; ?></div>
        <div class="dashboard-card-label">Aktif Oyuncu</div>
    </div>
    
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <div class="dashboard-card-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
        </div>
        <div class="dashboard-card-number"><?php echo $stats['total_teams']; ?></div>
        <div class="dashboard-card-label">Takım Sayısı</div>
    </div>
    
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <div class="dashboard-card-icon">
                <i class="fas fa-calendar"></i>
            </div>
        </div>
        <div class="dashboard-card-number"><?php echo $stats['upcoming_matches']; ?></div>
        <div class="dashboard-card-label">Yaklaşan Maç</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Son Haberler -->
    <div class="admin-content-card">
        <div class="admin-page-header">
            <h3 class="text-lg font-semibold mb-0">Son Haberler</h3>
            <a href="<?php echo BASE_URL; ?>/admin/news/create" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Yeni Haber
            </a>
        </div>
        
        <?php if (!empty($recent_news)): ?>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Başlık</th>
                            <th>Kategori</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_news as $news): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars(substr($news['title'], 0, 50)) . (strlen($news['title']) > 50 ? '...' : ''); ?></strong>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $news['category'] === 'haber' ? 'info' : 'warning'; ?>">
                                        <?php echo strtoupper($news['category']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $news['status'] === 'published' ? 'success' : 'secondary'; ?>">
                                        <?php echo $news['status'] === 'published' ? 'YAYINDA' : 'TASLAK'; ?>
                                    </span>
                                </td>
                                <td><?php echo date('d.m.Y', strtotime($news['created_at'])); ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/admin/news/edit/<?php echo $news['id']; ?>" 
                                       class="btn btn-admin-secondary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="admin-empty-state">
                <i class="fas fa-newspaper"></i>
                <h3>Henüz haber bulunmuyor</h3>
                <p>Başlamak için ilk haberinizi ekleyin.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Yaklaşan Maçlar -->
    <div class="admin-content-card">
        <div class="admin-page-header">
            <h3 class="text-lg font-semibold mb-0">Yaklaşan Maçlar</h3>
            <a href="<?php echo BASE_URL; ?>/admin/matches/create" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Yeni Maç
            </a>
        </div>
        
        <?php if (!empty($upcoming_matches)): ?>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Maç</th>
                            <th>Tarih</th>
                            <th>Saha</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($upcoming_matches as $match): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($match['home_team']); ?></strong>
                                    <span class="text-muted">vs</span>
                                    <strong><?php echo htmlspecialchars($match['away_team']); ?></strong>
                                </td>
                                <td><?php echo date('d.m.Y H:i', strtotime($match['match_date'])); ?></td>
                                <td><?php echo htmlspecialchars($match['venue'] ?? '-'); ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/admin/matches/edit/<?php echo $match['id']; ?>" 
                                       class="btn btn-admin-secondary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="admin-empty-state">
                <i class="fas fa-calendar"></i>
                <h3>Yaklaşan maç bulunmuyor</h3>
                <p>Maç programınızı oluşturmak için maç ekleyin.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Son Maç Sonuçları -->
<?php if (!empty($recent_matches)): ?>
<div class="admin-content-card">
    <div class="admin-page-header">
        <h3 class="text-lg font-semibold mb-0">Son Maç Sonuçları</h3>
    </div>
    
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Maç</th>
                    <th>Skor</th>
                    <th>Tarih</th>
                    <th>Lig</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_matches as $match): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($match['home_team']); ?></strong>
                            <span class="text-muted">vs</span>
                            <strong><?php echo htmlspecialchars($match['away_team']); ?></strong>
                        </td>
                        <td>
                            <span class="badge badge-info">
                                <?php echo $match['home_score']; ?> - <?php echo $match['away_score']; ?>
                            </span>
                        </td>
                        <td><?php echo date('d.m.Y', strtotime($match['match_date'])); ?></td>
                        <td><?php echo htmlspecialchars($match['league'] ?? '-'); ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>/admin/matches/edit/<?php echo $match['id']; ?>" 
                               class="btn btn-admin-secondary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Hızlı İşlemler -->
<div class="admin-content-card">
    <div class="admin-page-header">
        <h3 class="text-lg font-semibold mb-0">Hızlı İşlemler</h3>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="<?php echo BASE_URL; ?>/admin/news/create" class="btn btn-admin-primary justify-center">
            <i class="fas fa-plus"></i> Yeni Haber Ekle
        </a>
        <a href="<?php echo BASE_URL; ?>/admin/players/create" class="btn btn-admin-primary justify-center">
            <i class="fas fa-user-plus"></i> Yeni Oyuncu Ekle
        </a>
        <a href="<?php echo BASE_URL; ?>/admin/matches/create" class="btn btn-admin-primary justify-center">
            <i class="fas fa-calendar-plus"></i> Yeni Maç Ekle
        </a>
        <a href="<?php echo BASE_URL; ?>/admin/settings" class="btn btn-admin-secondary justify-center">
            <i class="fas fa-cog"></i> Site Ayarları
        </a>
    </div>
</div>

<?php
// İçerik yakalama ve layout'a geçirme
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>