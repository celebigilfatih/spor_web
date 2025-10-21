<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-users"></i> Oyuncu Yönetimi</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/players/create" class="btn btn-admin-primary">
            <i class="fas fa-plus"></i> Yeni Oyuncu Ekle
        </a>
    </div>
</div>

<!-- Mesaj ve Hata Bildirimleri -->';

if (!empty($message)) {
    $content .= '<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' . htmlspecialchars($message) . '</div>';
}

if (!empty($error)) {
    $content .= '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ' . htmlspecialchars($error) . '</div>';
}

$content .= '
<div class="admin-content-card">';

if (empty($players)) {
    $content .= '
    <div class="admin-empty-state">
        <i class="fas fa-users fa-4x text-muted mb-3"></i>
        <h3>Henüz oyuncu bulunmuyor</h3>
        <p class="text-muted">Başlamak için ilk oyuncunuzu ekleyin.</p>
        <a href="' . BASE_URL . '/admin/players/create" class="btn btn-admin-primary mt-3">
            <i class="fas fa-plus"></i> İlk Oyuncuyu Ekle
        </a>
    </div>';
} else {
    $content .= '
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><i class="fas fa-camera"></i> Fotoğraf</th>
                    <th><i class="fas fa-user"></i> Ad Soyad</th>
                    <th><i class="fas fa-hashtag"></i> Forma No</th>
                    <th><i class="fas fa-map-pin"></i> Pozisyon</th>
                    <th><i class="fas fa-shield-alt"></i> Takım</th>
                    <th><i class="fas fa-calendar"></i> Yaş</th>
                    <th><i class="fas fa-flag"></i> Uyruk</th>
                    <th><i class="fas fa-toggle-on"></i> Durum</th>
                    <th><i class="fas fa-cogs"></i> İşlemler</th>
                </tr>
            </thead>
            <tbody>';
            
    foreach ($players as $player) {
        $content .= '
                <tr>
                    <td>
                        <div class="player-photo">';
        
        if ($player['photo']) {
            $content .= '
                            <img src="' . BASE_URL . '/uploads/' . $player['photo'] . '" 
                                 alt="' . htmlspecialchars($player['name']) . '"
                                 class="w-12 h-12 object-cover rounded-full border">';
        } else {
            $content .= '
                            <div class="w-12 h-12 bg-muted rounded-full flex items-center justify-content-center border">
                                <i class="fas fa-user text-muted"></i>
                            </div>';
        }
        
        $content .= '
                        </div>
                    </td>
                    <td>
                        <div class="player-info">
                            <strong>' . htmlspecialchars($player['name']) . '</strong>';
        
        if (isset($player['is_captain']) && $player['is_captain']) {
            $content .= '
                            <span class="badge badge-warning ml-2">
                                <i class="fas fa-crown"></i> KAPTAN
                            </span>';
        }
        
        $content .= '
                        </div>
                    </td>
                    <td>';
        
        if ($player['jersey_number']) {
            $content .= '
                        <span class="badge badge-info">' . $player['jersey_number'] . '</span>';
        } else {
            $content .= '
                        <span class="text-muted">-</span>';
        }
        
        $content .= '
                    </td>
                    <td>' . htmlspecialchars($player['position']) . '</td>
                    <td>' . htmlspecialchars($player['team_name'] ?? 'Takımsız') . '</td>
                    <td>';
        
        if ($player['birth_date']) {
            $birthDate = new DateTime($player['birth_date']);
            $today = new DateTime();
            $age = $today->diff($birthDate)->y;
            $content .= $age;
        } else {
            $content .= '-';
        }
        
        $content .= '
                    </td>
                    <td>' . htmlspecialchars($player['nationality']) . '</td>
                    <td>
                        <span class="status-badge status-' . ($player['status'] === 'active' ? 'active' : 'inactive') . '">
                            <i class="fas fa-' . ($player['status'] === 'active' ? 'check-circle' : ($player['status'] === 'injured' ? 'heart-broken' : ($player['status'] === 'suspended' ? 'ban' : 'exchange-alt'))) . '"></i>
                            ' . ($player['status'] === 'active' ? 'AKTİF' : ($player['status'] === 'injured' ? 'SAKALI' : ($player['status'] === 'suspended' ? 'CEZALI' : 'TRANSFER'))) . '
                        </span>
                    </td>
                    <td>
                        <div class="admin-action-buttons">
                            <a href="' . BASE_URL . '/teams/player/' . $player['id'] . '" 
                               class="btn btn-admin-secondary btn-sm" 
                               target="_blank" 
                               title="Görüntüle">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="' . BASE_URL . '/admin/players/edit/' . $player['id'] . '" 
                               class="btn btn-admin-primary btn-sm" 
                               title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deletePlayer(' . $player['id'] . ')" 
                                    class="btn btn-admin-danger btn-sm" 
                                    title="Sil">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>';
    }

    $content .= '
            </tbody>
        </table>
    </div>
    
    <div class="admin-table-footer">
        <div class="admin-table-info">
            <i class="fas fa-info-circle"></i>
            Toplam ' . count($players) . ' oyuncu listeleniyor.
        </div>
    </div>';
    
    // Oyuncu İstatistikleri
    if (!empty($players)) {
        $totalPlayers = count($players);
        $activePlayers = count(array_filter($players, function($p) { return $p['status'] === 'active'; }));
        $captains = count(array_filter($players, function($p) { return isset($p['is_captain']) && $p['is_captain']; }));
        $foreigners = count(array_filter($players, function($p) { return isset($p['nationality']) && $p['nationality'] !== 'Türkiye'; }));
        
        $content .= '
    
    <!-- Oyuncu İstatistikleri -->
    <div class="dashboard-cards mt-6">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div class="dashboard-card-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="dashboard-card-number">' . $totalPlayers . '</div>
            <div class="dashboard-card-label">Toplam Oyuncu</div>
        </div>
        
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div class="dashboard-card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="dashboard-card-number">' . $activePlayers . '</div>
            <div class="dashboard-card-label">Aktif Oyuncu</div>
        </div>
        
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div class="dashboard-card-icon">
                    <i class="fas fa-crown"></i>
                </div>
            </div>
            <div class="dashboard-card-number">' . $captains . '</div>
            <div class="dashboard-card-label">Kaptan</div>
        </div>
        
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div class="dashboard-card-icon">
                    <i class="fas fa-globe"></i>
                </div>
            </div>
            <div class="dashboard-card-number">' . $foreigners . '</div>
            <div class="dashboard-card-label">Yabancı Oyuncu</div>
        </div>
    </div>';
    }
}

$content .= '
</div>

<script>
function deletePlayer(id) {
    const playerRow = document.querySelector("button[onclick=\'deletePlayer(" + id + ")\']").closest("tr");
    const playerName = playerRow ? (playerRow.querySelector("td:nth-child(2)") ? playerRow.querySelector("td:nth-child(2)").textContent.trim() : "Bu oyuncu") : "Bu oyuncu";
    const playerTeam = playerRow ? (playerRow.querySelector("td:nth-child(3)") ? playerRow.querySelector("td:nth-child(3)").textContent.trim() : "") : "";
    
    showDeleteConfirmation({
        title: "Oyuncu Silme Onayı",
        message: "Bu oyuncuyu kalıcı olarak silmek istediğinizden emin misiniz?",
        submessage: "Bu işlem geri alınamaz ve oyuncuya ait tüm veriler silinecektir.",
        itemName: playerName,
        itemDetails: playerTeam ? "Takım: " + playerTeam : "",
        confirmText: "Oyuncuyu Sil",
        cancelText: "İptal",
        onConfirm: function(closeModal) {
            const formData = new FormData();
            formData.append("csrf_token", "' . ($_SESSION['csrf_token'] ?? '') . '");
            
            fetch("' . BASE_URL . '/admin/players/delete/" + id, {
                method: "POST",
                body: formData
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                closeModal();
                if (data.success) {
                    showDeleteSuccess(data.message);
                    setTimeout(function() { location.reload(); }, 1500);
                } else {
                    showDeleteError(data.message);
                }
            })
            .catch(function(error) {
                closeModal();
                showDeleteError("Silme işlemi sırasında bir hata oluştu!");
            });
        }
    });
}
</script>';

include BASE_PATH . '/app/views/admin/layout.php';
?>