<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">A TAKIMI KADROSU</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/a-takimi" class="text-warning">A Takımı</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Kadro</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Squad Section -->
<section class="squad-section py-5">
    <div class="container">
        
        <!-- Goalkeepers -->
        <div class="position-group mb-5">
            <h2 class="position-title">
                <i class="fas fa-hand-paper text-warning"></i>
                KALECİLER
            </h2>
            <div class="row">
                ' . (isset($goalkeepers) && !empty($goalkeepers) ? 
                    implode('', array_map(function($player) {
                        return '
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="player-card">
                                <div class="player-image">
                                    <img src="' . BASE_URL . '/uploads/' . ($player['photo'] ?? 'default-player.jpg') . '" 
                                         alt="' . htmlspecialchars($player['name'] ?? '') . '">
                                    <div class="player-number">' . ($player['jersey_number'] ?? 'N/A') . '</div>
                                </div>
                                <div class="player-info">
                                    <h4 class="player-name">' . htmlspecialchars($player['name'] ?? '') . '</h4>
                                    <p class="player-position">Kaleci</p>
                                    <div class="player-details">
                                        <span>Yaş: ' . ($player['age'] ?? 'N/A') . '</span>
                                        <span>Boy: ' . ($player['height'] ?? 'N/A') . ' cm</span>
                                    </div>
                                    <a href="' . BASE_URL . '/ateam/player/' . ($player['id'] ?? '') . '" class="btn btn-sm btn-outline-primary">Detaylar</a>
                                </div>
                            </div>
                        </div>';
                    }, $goalkeepers)) : 
                    '<div class="col-12"><p class="text-muted text-center">Kaleci bilgisi bulunmamaktadır.</p></div>'
                ) . '
            </div>
        </div>

        <!-- Defenders -->
        <div class="position-group mb-5">
            <h2 class="position-title">
                <i class="fas fa-shield-alt text-primary"></i>
                DEFANS
            </h2>
            <div class="row">
                ' . (isset($defenders) && !empty($defenders) ? 
                    implode('', array_map(function($player) {
                        return '
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="player-card">
                                <div class="player-image">
                                    <img src="' . BASE_URL . '/uploads/' . ($player['photo'] ?? 'default-player.jpg') . '" 
                                         alt="' . htmlspecialchars($player['name'] ?? '') . '">
                                    <div class="player-number">' . ($player['jersey_number'] ?? 'N/A') . '</div>
                                </div>
                                <div class="player-info">
                                    <h4 class="player-name">' . htmlspecialchars($player['name'] ?? '') . '</h4>
                                    <p class="player-position">Defans</p>
                                    <div class="player-details">
                                        <span>Yaş: ' . ($player['age'] ?? 'N/A') . '</span>
                                        <span>Boy: ' . ($player['height'] ?? 'N/A') . ' cm</span>
                                    </div>
                                    <a href="' . BASE_URL . '/ateam/player/' . ($player['id'] ?? '') . '" class="btn btn-sm btn-outline-primary">Detaylar</a>
                                </div>
                            </div>
                        </div>';
                    }, $defenders)) : 
                    '<div class="col-12"><p class="text-muted text-center">Defans oyuncusu bilgisi bulunmamaktadır.</p></div>'
                ) . '
            </div>
        </div>

        <!-- Midfielders -->
        <div class="position-group mb-5">
            <h2 class="position-title">
                <i class="fas fa-dot-circle text-success"></i>
                ORTA SAHA
            </h2>
            <div class="row">
                ' . (isset($midfielders) && !empty($midfielders) ? 
                    implode('', array_map(function($player) {
                        return '
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="player-card">
                                <div class="player-image">
                                    <img src="' . BASE_URL . '/uploads/' . ($player['photo'] ?? 'default-player.jpg') . '" 
                                         alt="' . htmlspecialchars($player['name'] ?? '') . '">
                                    <div class="player-number">' . ($player['jersey_number'] ?? 'N/A') . '</div>
                                </div>
                                <div class="player-info">
                                    <h4 class="player-name">' . htmlspecialchars($player['name'] ?? '') . '</h4>
                                    <p class="player-position">Orta Saha</p>
                                    <div class="player-details">
                                        <span>Yaş: ' . ($player['age'] ?? 'N/A') . '</span>
                                        <span>Boy: ' . ($player['height'] ?? 'N/A') . ' cm</span>
                                    </div>
                                    <a href="' . BASE_URL . '/ateam/player/' . ($player['id'] ?? '') . '" class="btn btn-sm btn-outline-primary">Detaylar</a>
                                </div>
                            </div>
                        </div>';
                    }, $midfielders)) : 
                    '<div class="col-12"><p class="text-muted text-center">Orta saha oyuncusu bilgisi bulunmamaktadır.</p></div>'
                ) . '
            </div>
        </div>

        <!-- Forwards -->
        <div class="position-group mb-5">
            <h2 class="position-title">
                <i class="fas fa-bullseye text-danger"></i>
                FORVET
            </h2>
            <div class="row">
                ' . (isset($forwards) && !empty($forwards) ? 
                    implode('', array_map(function($player) {
                        return '
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="player-card">
                                <div class="player-image">
                                    <img src="' . BASE_URL . '/uploads/' . ($player['photo'] ?? 'default-player.jpg') . '" 
                                         alt="' . htmlspecialchars($player['name'] ?? '') . '">
                                    <div class="player-number">' . ($player['jersey_number'] ?? 'N/A') . '</div>
                                </div>
                                <div class="player-info">
                                    <h4 class="player-name">' . htmlspecialchars($player['name'] ?? '') . '</h4>
                                    <p class="player-position">Forvet</p>
                                    <div class="player-details">
                                        <span>Yaş: ' . ($player['age'] ?? 'N/A') . '</span>
                                        <span>Boy: ' . ($player['height'] ?? 'N/A') . ' cm</span>
                                    </div>
                                    <a href="' . BASE_URL . '/ateam/player/' . ($player['id'] ?? '') . '" class="btn btn-sm btn-outline-primary">Detaylar</a>
                                </div>
                            </div>
                        </div>';
                    }, $forwards)) : 
                    '<div class="col-12"><p class="text-muted text-center">Forvet oyuncusu bilgisi bulunmamaktadır.</p></div>'
                ) . '
            </div>
        </div>

    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>