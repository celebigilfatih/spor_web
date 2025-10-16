<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">GRUPLARIMIZ</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Gruplarımız</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Academy Info -->
<section class="academy-info py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <h2 class="section-title">GENÇLİK AKADEMİSİ</h2>
                <p class="lead">Geleceğin yıldızlarını yetiştiren akademimizde, profesyonel futbol eğitimi veriyoruz.</p>
                <p>Deneyimli antrenörlerimiz ve modern tesislerimizle, genç oyuncularımızın hem fiziksel hem de mental gelişimlerine odaklanıyoruz. Futbol becerilerinin yanı sıra disiplin, takım çalışması ve spor ahlakı değerlerini de öğretiyoruz.</p>
                <div class="academy-features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Profesyonel antrenör kadrosu</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Modern spor tesisleri</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Bireysel gelişim programları</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="academy-image">
                    <img src="' . BASE_URL . '/public/images/academy-training.jpg" 
                         alt="Akademi Antrenmanı" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Age Groups -->
<section class="age-groups py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">YAŞ GRUPLARI</h2>
        ' . (isset($statistics) && $statistics ? '
        <div class="row mb-5">
            <div class="col-md-3 mb-3">
                <div class="stat-card text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3 class="stat-number">' . ($statistics['active_groups'] ?? 0) . '</h3>
                    <p class="stat-label">Aktif Grup</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card text-center">
                    <i class="fas fa-user-friends fa-3x text-success mb-3"></i>
                    <h3 class="stat-number">' . ($statistics['total_players'] ?? 0) . '</h3>
                    <p class="stat-label">Toplam Sporcu</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card text-center">
                    <i class="fas fa-clipboard-list fa-3x text-warning mb-3"></i>
                    <h3 class="stat-number">' . ($statistics['total_capacity'] ?? 0) . '</h3>
                    <p class="stat-label">Toplam Kapasite</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card text-center">
                    <i class="fas fa-percentage fa-3x text-info mb-3"></i>
                    <h3 class="stat-number">' . ($statistics['total_capacity'] > 0 ? round(($statistics['total_players'] / $statistics['total_capacity']) * 100) : 0) . '%</h3>
                    <p class="stat-label">Doluluk Oranı</p>
                </div>
            </div>
        </div>
        ' : '') . '
        <div class="row">
            ' . (isset($groups) && !empty($groups) ? 
                implode('', array_map(function($group) {
                    // Icon based on age group
                    $icon = 'fa-users';
                    if (strpos($group['age_group'], 'U10') !== false || strpos($group['age_group'], 'U11') !== false) {
                        $icon = 'fa-child';
                    } elseif (strpos($group['age_group'], 'U12') !== false || strpos($group['age_group'], 'U13') !== false) {
                        $icon = 'fa-users';
                    } elseif (strpos($group['age_group'], 'U14') !== false || strpos($group['age_group'], 'U15') !== false) {
                        $icon = 'fa-running';
                    } elseif (strpos($group['age_group'], 'U16') !== false || strpos($group['age_group'], 'U17') !== false) {
                        $icon = 'fa-medal';
                    } else {
                        $icon = 'fa-trophy';
                    }
                    
                    // Calculate training days count
                    $trainingDays = $group['training_days'] ?? 'Belirtilmemiş';
                    $daysCount = substr_count($trainingDays, ',') + 1;
                    if (strpos(strtolower($trainingDays), 'her gün') !== false) {
                        $daysCount = 7;
                    }
                    
                    // Capacity percentage
                    $capacityPercent = $group['max_capacity'] > 0 ? round(($group['current_count'] / $group['max_capacity']) * 100) : 0;
                    $capacityClass = $capacityPercent >= 90 ? 'danger' : ($capacityPercent >= 70 ? 'warning' : 'success');
                    
                    return '
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="group-card">
                    <div class="group-icon">
                        <i class="fas ' . $icon . '"></i>
                    </div>
                    <h3 class="group-title">' . htmlspecialchars($group['age_group']) . '</h3>
                    <h5 class="group-name text-muted mb-3">' . htmlspecialchars($group['name']) . '</h5>
                    <div class="group-info">
                        <p><strong>Yaş:</strong> ' . $group['min_age'] . '-' . $group['max_age'] . '</p>
                        <p><strong>Antrenman:</strong> Hafta ' . $daysCount . ' gün</p>
                        <p><strong>Günler:</strong> ' . htmlspecialchars($trainingDays) . '</p>
                        ' . (!empty($group['training_time']) ? '<p><strong>Saat:</strong> ' . htmlspecialchars($group['training_time']) . '</p>' : '') . '
                    </div>
                    ' . (!empty($group['coach_name']) ? '<p class="coach-info"><i class="fas fa-user-tie me-2"></i><strong>Antrenör:</strong> ' . htmlspecialchars($group['coach_name']) . '</p>' : '') . '
                    <div class="capacity-info mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Doluluk</span>
                            <span><strong>' . $group['current_count'] . ' / ' . $group['max_capacity'] . '</strong></span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-' . $capacityClass . '" role="progressbar" style="width: ' . $capacityPercent . '%" aria-valuenow="' . $capacityPercent . '" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    ' . (!empty($group['description']) ? '<p class="group-description mt-3">' . htmlspecialchars($group['description']) . '</p>' : '') . '
                    <a href="' . BASE_URL . '/youth-registration" class="btn btn-outline-primary mt-3">Kayit Ol</a>
                </div>
            </div>';
                }, $groups)) : 
                '<div class="col-12"><div class="alert alert-info text-center">Henüz aktif grup bulunmamaktadır.</div></div>'
            ) . '
        </div>
    </div>
</section>

<!-- Enrollment Info -->
<section class="enrollment-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-title mb-4">KAYIT BİLGİLERİ</h2>
                <p class="lead mb-4">
                    Akademimize katılmak ve futbol yolculuğuna başlamak için bizimle iletişime geçin.
                </p>
                <div class="enrollment-info">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <i class="fas fa-calendar-alt text-primary"></i>
                                <h5>Kayıt Dönemi</h5>
                                <p>Haziran - Ağustos</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <i class="fas fa-file-alt text-warning"></i>
                                <h5>Gerekli Belgeler</h5>
                                <p>Sağlık raporu, Doğum belgesi</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <i class="fas fa-phone text-success"></i>
                                <h5>İletişim</h5>
                                <p>+90 (212) 123 45 67</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="' . BASE_URL . '/home/contact" class="btn btn-primary btn-lg">
                        <i class="fas fa-envelope me-2"></i>
                        İletişime Geç
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.stat-card {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 0;
    font-weight: 500;
}

.group-card {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.group-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.group-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
}

.group-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 0.5rem;
    text-align: center;
}

.group-name {
    text-align: center;
    font-size: 1rem;
    min-height: 30px;
}

.group-info {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.group-info p {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.group-info p:last-child {
    margin-bottom: 0;
}

.group-description {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.6;
    flex-grow: 1;
}

.coach-info {
    background: #e8f4f8;
    padding: 0.75rem;
    border-radius: 6px;
    font-size: 0.9rem;
    margin-top: 1rem;
}

.capacity-info {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
}

.capacity-info .progress {
    height: 8px;
    border-radius: 10px;
}

.academy-features .feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.academy-features .feature-item i {
    margin-right: 1rem;
    font-size: 1.3rem;
}

.info-item {
    padding: 1.5rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.info-item i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.info-item h5 {
    color: #1e3a8a;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.info-item p {
    color: #666;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .stat-number {
        font-size: 2rem;
    }
    
    .group-title {
        font-size: 1.5rem;
    }
}
</style>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>