<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-calendar"></i> Maç Yönetimi</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/matches/create" class="btn btn-admin-primary">
            <i class="fas fa-plus"></i> Yeni Maç Ekle
        </a>
        <a href="' . BASE_URL . '/admin/matches/fixtures" class="btn btn-outline">
            <i class="fas fa-calendar-alt"></i> Maç Takvimi
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

if (empty($matches)) {
    $content .= '
    <div class="admin-empty-state">
        <i class="fas fa-calendar fa-4x text-muted mb-3"></i>
        <h3>Henüz maç bulunmuyor</h3>
        <p class="text-muted">Başlamak için ilk maçınızı ekleyin.</p>
        <a href="' . BASE_URL . '/admin/matches/create" class="btn btn-admin-primary mt-3">
            <i class="fas fa-plus"></i> İlk Maçı Ekle
        </a>
    </div>';
} else {
    $content .= '
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><i class="fas fa-home"></i> Ev Sahibi</th>
                    <th><i class="fas fa-plane"></i> Konuk</th>
                    <th><i class="fas fa-clock"></i> Tarih & Saat</th>
                    <th><i class="fas fa-map-marker-alt"></i> Saha</th>
                    <th><i class="fas fa-trophy"></i> Müsabaka</th>
                    <th><i class="fas fa-scoreboard"></i> Skor</th>
                    <th><i class="fas fa-toggle-on"></i> Durum</th>
                    <th><i class="fas fa-cogs"></i> İşlemler</th>
                </tr>
            </thead>
            <tbody>';
            
    foreach ($matches as $match) {
        $content .= '
                <tr>
                    <td>
                        <div class="team-info">
                            <strong>' . htmlspecialchars($match['home_team']) . '</strong>
                        </div>
                    </td>
                    <td>
                        <div class="team-info">
                            <strong>' . htmlspecialchars($match['away_team']) . '</strong>
                        </div>
                    </td>
                    <td>
                        <div class="match-datetime">
                            <strong>' . date('d.m.Y', strtotime($match['match_date'])) . '</strong><br>
                            <small class="text-muted">' . date('H:i', strtotime($match['match_date'])) . '</small>
                        </div>
                    </td>
                    <td>' . htmlspecialchars($match['venue'] ?? 'Belirtilmemiş') . '</td>
                    <td>
                        <span class="badge badge-info">' . htmlspecialchars($match['competition'] ?? 'Liga') . '</span>
                    </td>
                    <td>';
        
        if ($match['status'] === 'finished' && !is_null($match['home_score']) && !is_null($match['away_score'])) {
            $content .= '
                        <span class="badge badge-success">
                            <i class="fas fa-futbol"></i>
                            ' . $match['home_score'] . ' - ' . $match['away_score'] . '
                        </span>';
        } elseif ($match['status'] === 'scheduled') {
            $content .= '
                        <span class="badge badge-warning">
                            <i class="fas fa-clock"></i>
                            Oynanacak
                        </span>';
        } else {
            $content .= '
                        <span class="badge badge-secondary">
                            <i class="fas fa-minus"></i>
                            -
                        </span>';
        }
        
        $content .= '
                    </td>
                    <td>
                        <span class="status-badge status-' . ($match['status'] === 'scheduled' ? 'active' : ($match['status'] === 'finished' ? 'success' : 'inactive')) . '">
                            <i class="fas fa-' . ($match['status'] === 'scheduled' ? 'clock' : ($match['status'] === 'finished' ? 'check-circle' : 'pause-circle')) . '"></i>
                            ' . ($match['status'] === 'scheduled' ? 'Planlı' : ($match['status'] === 'finished' ? 'Tamamlandı' : 'Ertelendi')) . '
                        </span>
                    </td>
                    <td>
                        <div class="admin-action-buttons">
                            <a href="' . BASE_URL . '/admin/matches/edit/' . $match['id'] . '" 
                               class="btn btn-admin-primary btn-sm" 
                               title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteMatch(' . $match['id'] . ')" 
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
            Toplam ' . count($matches) . ' maç listeleniyor.
        </div>
    </div>';
}

$content .= '
</div>

<script>
function deleteMatch(id) {
    const matchRow = document.querySelector("button[onclick=\'deleteMatch(" + id + ")\']").closest("tr");
    const matchInfo = matchRow ? (matchRow.querySelector("td:nth-child(2)") ? matchRow.querySelector("td:nth-child(2)").textContent.trim() : "Bu maç") : "Bu maç";
    
    showDeleteConfirmation({
        title: "Maç Silme Onayı",
        message: "Bu maçı kalıcı olarak silmek istediğinizden emin misiniz?",
        submessage: "Bu işlem geri alınamaz ve maça ait tüm bilgiler silinecektir.",
        itemName: matchInfo,
        confirmText: "Maçı Sil",
        cancelText: "İptal",
        onConfirm: function(closeModal) {
            const formData = new FormData();
            formData.append("csrf_token", "' . ($_SESSION['csrf_token'] ?? '') . '");
            
            fetch("' . BASE_URL . '/admin/matches/delete/" + id, {
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