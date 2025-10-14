<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-chart-bar"></i> Alt Yapı Kayıt İstatistikleri</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/youth-registrations" class="btn btn-admin-secondary">
            <i class="fas fa-arrow-left"></i> Kayıtlara Dön
        </a>
    </div>
</div>

<div class="row">
    <!-- Genel İstatistikler -->
    <div class="col-md-12">
        <div class="admin-content-card mb-4">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie"></i> Genel İstatistikler</h3>
            </div>
            <div class="card-body">
                <div class="admin-stats-grid">
                    <div class="admin-stat-card">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3>' . $stats['total'] . '</h3>
                            <p>Toplam Kayıt</p>
                        </div>
                    </div>
                    
                    <div class="admin-stat-card">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <h3>' . $stats['pending'] . '</h3>
                            <p>Bekleyen Kayıt</p>
                        </div>
                    </div>
                    
                    <div class="admin-stat-card">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3>' . $stats['approved'] . '</h3>
                            <p>Onaylanan Kayıt</p>
                        </div>
                    </div>
                    
                    <div class="admin-stat-card">
                        <div class="stat-icon bg-danger">
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="stat-content">
                            <h3>' . $stats['rejected'] . '</h3>
                            <p>Reddedilen Kayıt</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';

// Yaş grupları istatistikleri
if (!empty($stats['by_age'])) {
    $content .= '
<div class="row">
    <div class="col-md-6">
        <div class="admin-content-card">
            <div class="card-header">
                <h3><i class="fas fa-birthday-cake"></i> Yaş Grupları</h3>
            </div>
            <div class="card-body">
                <div class="stats-list">';
    
    foreach ($stats['by_age'] as $ageGroup => $count) {
        $percentage = $stats['total'] > 0 ? round(($count / $stats['total']) * 100, 1) : 0;
        $content .= '
                    <div class="stats-item">
                        <div class="stats-label">' . $ageGroup . ' yaş</div>
                        <div class="stats-bar">
                            <div class="stats-progress" style="width: ' . $percentage . '%"></div>
                        </div>
                        <div class="stats-value">' . $count . ' (' . $percentage . '%)</div>
                    </div>';
    }
    
    $content .= '
                </div>
            </div>
        </div>
    </div>';
}

// Aylık kayıt istatistikleri
if (!empty($stats['by_month'])) {
    $content .= '
    <div class="col-md-6">
        <div class="admin-content-card">
            <div class="card-header">
                <h3><i class="fas fa-calendar"></i> Aylık Kayıtlar</h3>
            </div>
            <div class="card-body">
                <div class="stats-list">';
    
    // Son 6 ayı göster
    $months = array_slice($stats['by_month'], -6, 6, true);
    foreach ($months as $month => $count) {
        $monthName = date('F Y', strtotime($month . '-01'));
        $monthNameTr = [
            'January' => 'Ocak', 'February' => 'Şubat', 'March' => 'Mart',
            'April' => 'Nisan', 'May' => 'Mayıs', 'June' => 'Haziran',
            'July' => 'Temmuz', 'August' => 'Ağustos', 'September' => 'Eylül',
            'October' => 'Ekim', 'November' => 'Kasım', 'December' => 'Aralık'
        ];
        
        foreach ($monthNameTr as $en => $tr) {
            $monthName = str_replace($en, $tr, $monthName);
        }
        
        $maxCount = max($stats['by_month']);
        $percentage = $maxCount > 0 ? round(($count / $maxCount) * 100, 1) : 0;
        
        $content .= '
                    <div class="stats-item">
                        <div class="stats-label">' . $monthName . '</div>
                        <div class="stats-bar">
                            <div class="stats-progress" style="width: ' . $percentage . '%"></div>
                        </div>
                        <div class="stats-value">' . $count . '</div>
                    </div>';
    }
    
    $content .= '
                </div>
            </div>
        </div>
    </div>
</div>';
}

// Eğer hiç kayıt yoksa
if ($stats['total'] == 0) {
    $content .= '
<div class="row">
    <div class="col-md-12">
        <div class="admin-content-card">
            <div class="admin-empty-state">
                <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                <h3>Henüz istatistik bulunmuyor</h3>
                <p class="text-muted">Alt yapı kayıtları yapıldıkça istatistikler burada görünecektir.</p>
                <a href="' . BASE_URL . '/youth-registration" class="btn btn-admin-primary mt-3" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Kayıt Formunu Görüntüle
                </a>
            </div>
        </div>
    </div>
</div>';
}

$content .= '
<style>
.admin-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.admin-stat-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    border: 1px solid #e9ecef;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: white;
    font-size: 24px;
}

.stat-icon.bg-primary { background: #007bff; }
.stat-icon.bg-warning { background: #ffc107; }
.stat-icon.bg-success { background: #28a745; }
.stat-icon.bg-danger { background: #dc3545; }

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #333;
}

.stat-content p {
    margin: 0;
    color: #666;
    font-weight: 500;
}

.stats-list {
    space-y: 15px;
}

.stats-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.stats-label {
    width: 120px;
    font-weight: 500;
    color: #333;
}

.stats-bar {
    flex: 1;
    height: 20px;
    background: #e9ecef;
    border-radius: 10px;
    margin: 0 15px;
    overflow: hidden;
}

.stats-progress {
    height: 100%;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-radius: 10px;
    transition: width 0.3s ease;
}

.stats-value {
    width: 80px;
    text-align: right;
    font-weight: 600;
    color: #007bff;
}

@media (max-width: 768px) {
    .admin-stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-item {
        flex-direction: column;
        align-items: stretch;
    }
    
    .stats-label {
        width: 100%;
        margin-bottom: 5px;
    }
    
    .stats-bar {
        margin: 5px 0;
    }
    
    .stats-value {
        width: 100%;
        text-align: left;
    }
}
</style>';

include BASE_PATH . '/app/views/admin/layout.php';
?>