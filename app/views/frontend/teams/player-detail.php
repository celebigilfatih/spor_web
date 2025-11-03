<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">' . htmlspecialchars($player['name'] ?? 'Oyuncu Detayları') . '</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/teams" class="text-warning">Takımlar</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">' . htmlspecialchars($player['name'] ?? 'Oyuncu') . '</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Player Profile -->
<section class="player-profile py-5">
    <div class="container">
        <div class="row">
            
            <!-- Player Photo and Basic Info -->
            <div class="col-lg-4 mb-5">
                <div class="player-profile-card">
                    <div class="player-photo-large">
                        <img src="' . BASE_URL . '/uploads/' . ($player['photo'] ?? 'default-player.jpg') . '" 
                             alt="' . htmlspecialchars($player['name'] ?? '') . '" class="img-fluid">
                        <div class="jersey-number-large">' . ($player['jersey_number'] ?? 'N/A') . '</div>
                    </div>
                    
                    <div class="player-basic-info">
                        <h2 class="player-name-large">' . htmlspecialchars($player['name'] ?? '') . '</h2>
                        <p class="player-position-large">' . htmlspecialchars($player['position'] ?? '') . '</p>
                        
                        <div class="player-details-grid">
                            <div class="detail-row">
                                <span class="detail-label">Yaş:</span>
                                <span class="detail-value">' . ($player['age'] ?? 'N/A') . '</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Boy:</span>
                                <span class="detail-value">' . ($player['height'] ?? 'N/A') . ' cm</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Ağırlık:</span>
                                <span class="detail-value">' . ($player['weight'] ?? 'N/A') . ' kg</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Uyruk:</span>
                                <span class="detail-value">' . htmlspecialchars($player['nationality'] ?? 'Türkiye') . '</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Forma No:</span>
                                <span class="detail-value">' . ($player['jersey_number'] ?? 'N/A') . '</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Kulübe Katılış:</span>
                                <span class="detail-value">' . ($player['join_date'] ? date('Y', strtotime($player['join_date'])) : 'N/A') . '</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Player Stats and Performance -->
            <div class="col-lg-8">
                
                <!-- Bio Section -->
                ' . (isset($player['bio']) && !empty($player['bio']) ? '
                <div class="bio-section mb-5">
                    <h3 class="section-subtitle">BİYOGRAFİ</h3>
                    <p class="player-bio">' . nl2br(htmlspecialchars($player['bio'])) . '</p>
                </div>
                ' : '') . '

                <!-- Season Stats -->
                <div class="stats-section mb-5">
                    <h3 class="section-subtitle">SEZON İSTATİSTİKLERİ</h3>
                    
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-box">
                                <div class="stat-number">' . ($player['matches_played'] ?? '0') . '</div>
                                <div class="stat-label">Maç</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-box">
                                <div class="stat-number">' . ($player['goals'] ?? '0') . '</div>
                                <div class="stat-label">Gol</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-box">
                                <div class="stat-number">' . ($player['assists'] ?? '0') . '</div>
                                <div class="stat-label">Asist</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-box">
                                <div class="stat-number">' . ($player['yellow_cards'] ?? '0') . '</div>
                                <div class="stat-label">Sarı Kart</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Info -->
                ' . (isset($player['team_name']) ? '
                <div class="team-info-section mb-5">
                    <h3 class="section-subtitle">TAKIM BİLGİLERİ</h3>
                    <div class="team-info-card">
                        <h4>' . htmlspecialchars($player['team_name']) . '</h4>
                        ' . (isset($player['is_captain']) && $player['is_captain'] ? 
                            '<p class="captain-badge"><i class="fas fa-crown text-warning"></i> Kaptan</p>' : 
                            '') . '
                    </div>
                </div>
                ' : '') . '

                <!-- Related Players -->
                ' . (isset($related_players) && !empty($related_players) ? '
                <div class="related-players-section">
                    <h3 class="section-subtitle">AYNI POZİSYONDAKİ OYUNCULAR</h3>
                    
                    <div class="row">
                        ' . implode('', array_slice(array_filter($related_players, function($p) use ($player) {
                            return $p['id'] !== $player['id'];
                        }), 0, 3) ? array_map(function($rp) {
                            return '
                            <div class="col-md-4 mb-4">
                                <a href="' . BASE_URL . '/teams/player/' . $rp['id'] . '" class="player-card">
                                    <div class="player-photo">
                                        <img src="' . BASE_URL . '/uploads/' . ($rp['photo'] ?? 'default-player.jpg') . '" 
                                             alt="' . htmlspecialchars($rp['name'] ?? '') . '" class="img-fluid">
                                        <div class="jersey-number">' . ($rp['jersey_number'] ?? 'N/A') . '</div>
                                    </div>
                                    <div class="player-info">
                                        <h5 class="player-name">' . htmlspecialchars($rp['name'] ?? '') . '</h5>
                                        <p class="player-position">' . htmlspecialchars($rp['position'] ?? '') . '</p>
                                    </div>
                                </a>
                            </div>';
                        }, array_slice(array_filter($related_players, function($p) use ($player) {
                            return $p['id'] !== $player['id'];
                        }), 0, 3)) : []) . '
                    </div>
                </div>
                ' : '') . '

            </div>
        </div>
    </div>
</section>

<style>
.player-profile-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 20px;
}

.player-photo-large {
    position: relative;
    margin-bottom: 20px;
}

.player-photo-large img {
    width: 100%;
    border-radius: 10px;
}

.jersey-number-large {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--primary-color);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: bold;
}

.player-basic-info {
    text-align: center;
}

.player-name-large {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 10px;
}

.player-position-large {
    color: var(--primary-color);
    font-size: 18px;
    margin-bottom: 20px;
}

.player-details-grid {
    margin-top: 20px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.detail-label {
    font-weight: 600;
    color: #666;
}

.detail-value {
    color: #333;
}

.section-subtitle {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 3px solid var(--primary-color);
}

.stat-box {
    background: #f8f9fa;
    padding: 20px;
    text-align: center;
    border-radius: 8px;
}

.stat-number {
    font-size: 36px;
    font-weight: bold;
    color: var(--primary-color);
}

.stat-label {
    font-size: 14px;
    color: #666;
    margin-top: 5px;
}

.bio-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.player-bio {
    line-height: 1.8;
    color: #555;
}

.team-info-card {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
}

.team-info-card h4 {
    margin: 0;
    font-size: 24px;
}

.captain-badge {
    margin-top: 10px;
    font-size: 18px;
}

.player-card {
    display: block;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s;
    text-decoration: none;
}

.player-card:hover {
    transform: translateY(-5px);
}

.player-photo {
    position: relative;
}

.player-photo img {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
}

.jersey-number {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--primary-color);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.player-info {
    padding: 15px;
    text-align: center;
}

.player-name {
    font-size: 16px;
    font-weight: bold;
    margin: 0 0 5px 0;
    color: #333;
}

.player-position {
    font-size: 14px;
    color: #666;
    margin: 0;
}
</style>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>
