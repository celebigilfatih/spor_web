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
        
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="players-tab" data-bs-toggle="tab" data-bs-target="#players" type="button" role="tab" aria-controls="players" aria-selected="true">
                    <i class="fas fa-users"></i> Oyuncular
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="staff-tab" data-bs-toggle="tab" data-bs-target="#staff" type="button" role="tab" aria-controls="staff" aria-selected="false">
                    <i class="fas fa-user-tie"></i> Teknik Kadro
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="board-tab" data-bs-toggle="tab" data-bs-target="#board" type="button" role="tab" aria-controls="board" aria-selected="false">
                    <i class="fas fa-briefcase"></i> Yönetim Kurulu
                </button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content">
            <!-- Players Tab -->
            <div class="tab-pane fade show active" id="players" role="tabpanel" aria-labelledby="players-tab">
        
        ' . (isset($players_by_position) && !empty($players_by_position) ? 
            implode('', array_map(function($position, $players) {
                // Position icon and title mapping
                $position_config = [
                    'Kaleci' => ['icon' => 'fa-hand-paper', 'title' => 'KALECİLER'],
                    'Stoper' => ['icon' => 'fa-shield-alt', 'title' => 'STOPERLER'],
                    'Sol Bek' => ['icon' => 'fa-shield-alt', 'title' => 'SOL BEKLER'],
                    'Sağ Bek' => ['icon' => 'fa-shield-alt', 'title' => 'SAĞ BEKLER'],
                    'Defans' => ['icon' => 'fa-shield-alt', 'title' => 'DEFANS'],
                    'Ön Libero' => ['icon' => 'fa-dot-circle', 'title' => 'ÖN LİBERO'],
                    'Merkez Orta Saha' => ['icon' => 'fa-dot-circle', 'title' => 'MERKEZ ORTA SAHA'],
                    'Orta Saha' => ['icon' => 'fa-dot-circle', 'title' => 'ORTA SAHA'],
                    'Sol Kanat' => ['icon' => 'fa-running', 'title' => 'SOL KANAT'],
                    'Sağ Kanat' => ['icon' => 'fa-running', 'title' => 'SAĞ KANAT'],
                    'Santrafor' => ['icon' => 'fa-bullseye', 'title' => 'SANTRAFORLAR'],
                    'Forvet' => ['icon' => 'fa-bullseye', 'title' => 'FORVETLER']
                ];
                
                $config = $position_config[$position] ?? ['icon' => 'fa-users', 'title' => strtoupper($position)];
                $icon = $config['icon'];
                $title = $config['title'];
                
                // Determine column size based on position
                $col_class = 'col-lg-4';
                if (in_array($position, ['Kaleci', 'Santrafor', 'Forvet'])) {
                    $col_class = 'col-lg-4';
                } elseif (in_array($position, ['Stoper', 'Sol Bek', 'Sağ Bek', 'Defans', 'Merkez Orta Saha', 'Orta Saha'])) {
                    $col_class = 'col-lg-3';
                } else {
                    $col_class = 'col-lg-4';
                }
                
                return '
        <!-- ' . htmlspecialchars($position) . ' -->
        <div class="position-group mb-5">
            <h2 class="position-title">
                <i class="fas ' . $icon . '"></i>
                ' . $title . '
            </h2>
            <div class="row">
                ' . implode('', array_map(function($player) use ($col_class) {
                    return '
                <div class="' . $col_class . ' col-md-6 mb-4">
                    <div class="player-card">
                        <div class="player-image">
                            <img src="' . BASE_URL . '/uploads/' . ($player['photo'] ?? 'default-player.jpg') . '" 
                                 alt="' . htmlspecialchars($player['name'] ?? '') . '">
                            <div class="player-number">' . ($player['jersey_number'] ?? 'N/A') . '</div>
                        </div>
                        <div class="player-info">
                            <h4 class="player-name">' . htmlspecialchars($player['name'] ?? '') . '</h4>
                            <p class="player-position">' . htmlspecialchars($player['position'] ?? '') . '</p>
                            <div class="player-details">
                                <span>Yaş: ' . (isset($player['birth_date']) && $player['birth_date'] ? (new DateTime())->diff(new DateTime($player['birth_date']))->y : 'N/A') . '</span>
                            </div>
                            <a href="' . BASE_URL . '/ateam/player/' . ($player['id'] ?? '') . '" class="btn btn-sm btn-outline-primary">Detaylar</a>
                        </div>
                    </div>
                </div>';
                }, $players)) . '
            </div>
        </div>';
            }, array_keys($players_by_position), $players_by_position)) : 
            '<div class="col-12"><p class="text-muted text-center">Henüz oyuncu bulunmamaktadır.</p></div>'
        ) . '

            </div>
            <!-- End Players Tab -->

            <!-- Technical Staff Tab -->
            <div class="tab-pane fade" id="staff" role="tabpanel" aria-labelledby="staff-tab">
                
                <!-- Head Coach -->
                ' . (isset($head_coach) && $head_coach ? '
                <div class="position-group mb-5">
                    <h2 class="position-title">
                        <i class="fas fa-chalkboard-teacher"></i>
                        TEKNİK DİREKTÖR
                    </h2>
                    <div class="row">
                        <div class="col-lg-6 mx-auto mb-4">
                            <div class="player-card staff-card">
                                <div class="player-image">
                                    <img src="' . BASE_URL . '/uploads/' . ($head_coach['photo'] ?? 'default-staff.jpg') . '" 
                                         alt="' . htmlspecialchars($head_coach['name'] ?? '') . '">
                                </div>
                                <div class="player-info">
                                    <h4 class="player-name">' . htmlspecialchars($head_coach['name'] ?? '') . '</h4>
                                    <p class="player-position">' . htmlspecialchars($head_coach['position'] ?? 'Teknik Direktör') . '</p>
                                    <div class="player-details">
                                        <span><i class="fas fa-certificate"></i> ' . htmlspecialchars($head_coach['license_type'] ?? 'UEFA Pro') . '</span>
                                        <span><i class="fas fa-briefcase"></i> ' . ($head_coach['experience_years'] ?? 'N/A') . ' yıl deneyim</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>' : '') . '

                <!-- Assistant Coaches -->
                ' . (isset($assistant_coaches) && !empty($assistant_coaches) ? '
                <div class="position-group mb-5">
                    <h2 class="position-title">
                        <i class="fas fa-users"></i>
                        ANTRENÖR YARDIMCILARI
                    </h2>
                    <div class="row">
                        ' . implode('', array_map(function($staff) {
                            return '
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="player-card staff-card">
                                    <div class="player-image">
                                        <img src="' . BASE_URL . '/uploads/' . ($staff['photo'] ?? 'default-staff.jpg') . '" 
                                             alt="' . htmlspecialchars($staff['name'] ?? '') . '">
                                    </div>
                                    <div class="player-info">
                                        <h4 class="player-name">' . htmlspecialchars($staff['name'] ?? '') . '</h4>
                                        <p class="player-position">' . htmlspecialchars($staff['position'] ?? '') . '</p>
                                        <div class="player-details">
                                            <span><i class="fas fa-certificate"></i> ' . htmlspecialchars($staff['license_type'] ?? 'N/A') . '</span>
                                            <span><i class="fas fa-briefcase"></i> ' . ($staff['experience_years'] ?? 'N/A') . ' yıl</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }, $assistant_coaches)) . '
                    </div>
                </div>' : '') . '

                <!-- Goalkeeper Coaches -->
                ' . (isset($goalkeeper_coaches) && !empty($goalkeeper_coaches) ? '
                <div class="position-group mb-5">
                    <h2 class="position-title">
                        <i class="fas fa-hand-paper"></i>
                        KALECİ ANTRENÖRLERİ
                    </h2>
                    <div class="row">
                        ' . implode('', array_map(function($staff) {
                            return '
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="player-card staff-card">
                                    <div class="player-image">
                                        <img src="' . BASE_URL . '/uploads/' . ($staff['photo'] ?? 'default-staff.jpg') . '" 
                                             alt="' . htmlspecialchars($staff['name'] ?? '') . '">
                                    </div>
                                    <div class="player-info">
                                        <h4 class="player-name">' . htmlspecialchars($staff['name'] ?? '') . '</h4>
                                        <p class="player-position">' . htmlspecialchars($staff['position'] ?? '') . '</p>
                                        <div class="player-details">
                                            <span><i class="fas fa-certificate"></i> ' . htmlspecialchars($staff['license_type'] ?? 'N/A') . '</span>
                                            <span><i class="fas fa-briefcase"></i> ' . ($staff['experience_years'] ?? 'N/A') . ' yıl</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }, $goalkeeper_coaches)) . '
                    </div>
                </div>' : '') . '

                <!-- Fitness Coaches -->
                ' . (isset($fitness_coaches) && !empty($fitness_coaches) ? '
                <div class="position-group mb-5">
                    <h2 class="position-title">
                        <i class="fas fa-dumbbell"></i>
                        KONDİSYON ANTRENÖRLERİ
                    </h2>
                    <div class="row">
                        ' . implode('', array_map(function($staff) {
                            return '
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="player-card staff-card">
                                    <div class="player-image">
                                        <img src="' . BASE_URL . '/uploads/' . ($staff['photo'] ?? 'default-staff.jpg') . '" 
                                             alt="' . htmlspecialchars($staff['name'] ?? '') . '">
                                    </div>
                                    <div class="player-info">
                                        <h4 class="player-name">' . htmlspecialchars($staff['name'] ?? '') . '</h4>
                                        <p class="player-position">' . htmlspecialchars($staff['position'] ?? '') . '</p>
                                        <div class="player-details">
                                            <span><i class="fas fa-certificate"></i> ' . htmlspecialchars($staff['license_type'] ?? 'N/A') . '</span>
                                            <span><i class="fas fa-briefcase"></i> ' . ($staff['experience_years'] ?? 'N/A') . ' yıl</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }, $fitness_coaches)) . '
                    </div>
                </div>' : '') . '

                <!-- Medical Staff -->
                ' . (isset($medical_staff) && !empty($medical_staff) ? '
                <div class="position-group mb-5">
                    <h2 class="position-title">
                        <i class="fas fa-heartbeat"></i>
                        SAĞLIK PERSONELİ
                    </h2>
                    <div class="row">
                        ' . implode('', array_map(function($staff) {
                            return '
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="player-card staff-card">
                                    <div class="player-image">
                                        <img src="' . BASE_URL . '/uploads/' . ($staff['photo'] ?? 'default-staff.jpg') . '" 
                                             alt="' . htmlspecialchars($staff['name'] ?? '') . '">
                                    </div>
                                    <div class="player-info">
                                        <h4 class="player-name">' . htmlspecialchars($staff['name'] ?? '') . '</h4>
                                        <p class="player-position">' . htmlspecialchars($staff['position'] ?? '') . '</p>
                                        <div class="player-details">
                                            <span><i class="fas fa-certificate"></i> ' . htmlspecialchars($staff['license_type'] ?? 'N/A') . '</span>
                                            <span><i class="fas fa-briefcase"></i> ' . ($staff['experience_years'] ?? 'N/A') . ' yıl</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }, $medical_staff)) . '
                    </div>
                </div>' : '') . '

                <!-- Other Staff -->
                ' . (isset($other_staff) && !empty($other_staff) ? '
                <div class="position-group mb-5">
                    <h2 class="position-title">
                        <i class="fas fa-clipboard-list"></i>
                        DİĞER PERSONEL
                    </h2>
                    <div class="row">
                        ' . implode('', array_map(function($staff) {
                            return '
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="player-card staff-card">
                                    <div class="player-image">
                                        <img src="' . BASE_URL . '/uploads/' . ($staff['photo'] ?? 'default-staff.jpg') . '" 
                                             alt="' . htmlspecialchars($staff['name'] ?? '') . '">
                                    </div>
                                    <div class="player-info">
                                        <h4 class="player-name">' . htmlspecialchars($staff['name'] ?? '') . '</h4>
                                        <p class="player-position">' . htmlspecialchars($staff['position'] ?? '') . '</p>
                                        <div class="player-details">
                                            <span><i class="fas fa-certificate"></i> ' . htmlspecialchars($staff['license_type'] ?? 'N/A') . '</span>
                                            <span><i class="fas fa-briefcase"></i> ' . ($staff['experience_years'] ?? 'N/A') . ' yıl</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }, $other_staff)) . '
                    </div>
                </div>' : '') . '

            </div>
            <!-- End Technical Staff Tab -->

            <!-- Board of Directors Tab -->
            <div class="tab-pane fade" id="board" role="tabpanel" aria-labelledby="board-tab">
                
                <!-- President -->
                ' . (isset($president) && $president ? '
                <div class="position-group mb-5">
                    <h2 class="position-title">
                        <i class="fas fa-crown"></i>
                        BAŞKAN
                    </h2>
                    <div class="row">
                        <div class="col-lg-6 mx-auto mb-4">
                            <div class="player-card staff-card board-card">
                                <div class="player-image">
                                    <img src="' . BASE_URL . '/uploads/' . ($president['photo'] ?? 'default-staff.jpg') . '" 
                                         alt="' . htmlspecialchars($president['name'] ?? '') . '">
                                </div>
                                <div class="player-info">
                                    <h4 class="player-name">' . htmlspecialchars($president['name'] ?? '') . '</h4>
                                    <p class="player-position">' . htmlspecialchars($president['position'] ?? 'Başkan') . '</p>
                                    <div class="player-details">
                                        <span><i class="fas fa-briefcase"></i> ' . ($president['experience_years'] ?? 'N/A') . ' yıl deneyim</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>' : '') . '

                <!-- Vice Presidents -->
                ' . (isset($vice_presidents) && !empty($vice_presidents) ? '
                <div class="position-group mb-5">
                    <h2 class="position-title">
                        <i class="fas fa-user-shield"></i>
                        BAŞKAN YARDIMCILARI
                    </h2>
                    <div class="row">
                        ' . implode('', array_map(function($member) {
                            return '
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="player-card staff-card board-card">
                                    <div class="player-image">
                                        <img src="' . BASE_URL . '/uploads/' . ($member['photo'] ?? 'default-staff.jpg') . '" 
                                             alt="' . htmlspecialchars($member['name'] ?? '') . '">
                                    </div>
                                    <div class="player-info">
                                        <h4 class="player-name">' . htmlspecialchars($member['name'] ?? '') . '</h4>
                                        <p class="player-position">' . htmlspecialchars($member['position'] ?? '') . '</p>
                                        <div class="player-details">
                                            <span><i class="fas fa-briefcase"></i> ' . ($member['experience_years'] ?? 'N/A') . ' yıl</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }, $vice_presidents)) . '
                    </div>
                </div>' : '') . '

                <!-- Board Members -->
                ' . (isset($board_members) && !empty($board_members) ? '
                <div class="position-group mb-5">
                    <h2 class="position-title">
                        <i class="fas fa-users-cog"></i>
                        YÖNETİCİLER
                    </h2>
                    <div class="row">
                        ' . implode('', array_map(function($member) {
                            return '
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="player-card staff-card board-card">
                                    <div class="player-image">
                                        <img src="' . BASE_URL . '/uploads/' . ($member['photo'] ?? 'default-staff.jpg') . '" 
                                             alt="' . htmlspecialchars($member['name'] ?? '') . '">
                                    </div>
                                    <div class="player-info">
                                        <h4 class="player-name">' . htmlspecialchars($member['name'] ?? '') . '</h4>
                                        <p class="player-position">' . htmlspecialchars($member['position'] ?? '') . '</p>
                                        <div class="player-details">
                                            <span><i class="fas fa-briefcase"></i> ' . ($member['experience_years'] ?? 'N/A') . ' yıl</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }, $board_members)) . '
                    </div>
                </div>' : '') . '

            </div>
            <!-- End Board of Directors Tab -->
        </div>
        <!-- End Tabs Content -->

    </div>
</section>

<script>
// Handle tab parameter from URL
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get("tab");
    
    if (tabParam === "board") {
        // Activate board tab
        const boardTab = document.getElementById("board-tab");
        const boardPane = document.getElementById("board");
        const playersTab = document.getElementById("players-tab");
        const playersPane = document.getElementById("players");
        
        if (boardTab && boardPane && playersTab && playersPane) {
            // Deactivate players tab
            playersTab.classList.remove("active");
            playersTab.setAttribute("aria-selected", "false");
            playersPane.classList.remove("show", "active");
            
            // Activate board tab
            boardTab.classList.add("active");
            boardTab.setAttribute("aria-selected", "true");
            boardPane.classList.add("show", "active");
        }
    }
});
</script>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>