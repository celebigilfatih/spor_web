<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">GENÇLİK AKADEMİSİ OYUNCULARI</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/gruplar" class="text-warning">Gruplar</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Oyuncular</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Youth Players Section -->
<section class="youth-players-section py-5">
    <div class="container">
        ' . (isset($players_by_group) && !empty($players_by_group) ? 
            implode('', array_map(function($groupData) {
                $group = $groupData['group'];
                $players = $groupData['players'];
                
                return '
        <!-- Group: ' . htmlspecialchars($group['name']) . ' -->
        <div class="position-group mb-5">
            <h2 class="position-title">
                <i class="fas fa-users text-warning"></i>
                ' . htmlspecialchars($group['name']) . '
            </h2>
            <div class="row">
                ' . (!empty($players) ? 
                    implode('', array_map(function($player) {
                        return '
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="player-card">
                                <div class="player-image">
                                    <img src="' . BASE_URL . '/uploads/' . ($player['photo'] ?? 'default-player.jpg') . '" 
                                         alt="' . htmlspecialchars($player['name'] ?? '') . '">
                                </div>
                                <div class="player-info">
                                    <h4 class="player-name">' . htmlspecialchars($player['name'] ?? '') . '</h4>
                                    <p class="player-position">' . htmlspecialchars($player['position'] ?? 'Pozisyon Belirtilmemiş') . '</p>
                                    <div class="player-details">
                                        <span>Doğum Yılı: ' . (isset($player['birth_date']) ? date('Y', strtotime($player['birth_date'])) : 'N/A') . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }, $players)) : 
                    '<div class="col-12"><p class="text-muted text-center">Bu grupta oyuncu bilgisi bulunmamaktadır.</p></div>'
                ) . '
            </div>
        </div>';
            }, $players_by_group)) : 
            '<div class="col-12">
                <div class="no-players text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h3>Henüz gençlik akademisi oyuncusu bulunmamaktadır</h3>
                    <p class="text-muted">Yakında yeni oyuncular eklenecektir.</p>
                </div>
            </div>'
        ) . '
    </div>
</section>

<style>
.youth-players-section {
    background-color: #f8fafc;
}

.position-group {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.position-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 3px solid #f59e0b;
}

.player-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.player-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}

.player-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.player-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.player-card:hover .player-image img {
    transform: scale(1.05);
}

.player-info {
    padding: 1.5rem;
    text-align: center;
}

.player-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 0.5rem;
}

.player-position {
    color: #f59e0b;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.player-details {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.85rem;
    color: #64748b;
}

.player-details span {
    background: #f1f5f9;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
}

.no-players {
    background: white;
    border-radius: 15px;
    padding: 3rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
</style>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>