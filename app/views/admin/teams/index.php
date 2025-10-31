<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-shield-alt"></i> Takım Yönetimi</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/teams/create" class="btn btn-admin-primary">
            <i class="fas fa-plus"></i> Yeni Takım Ekle
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

if (empty($teams)) {
    $content .= '
    <div class="admin-empty-state">
        <i class="fas fa-shield-alt fa-4x text-muted mb-3"></i>
        <h3>Henüz takım bulunmuyor</h3>
        <p class="text-muted">Başlamak için ilk takımınızı ekleyin.</p>
        <a href="' . BASE_URL . '/admin/teams/create" class="btn btn-admin-primary mt-3">
            <i class="fas fa-plus"></i> İlk Takımı Ekle
        </a>
    </div>';
} else {
    $content .= '
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><i class="fas fa-shield-alt"></i> Takım Adı</th>
                    <th><i class="fas fa-layer-group"></i> Kategori</th>
                    <th><i class="fas fa-user-tie"></i> Antrenör</th>
                    <th><i class="fas fa-toggle-on"></i> Durum</th>
                    <th><i class="fas fa-calendar-plus"></i> Oluşturma</th>
                    <th><i class="fas fa-cogs"></i> İşlemler</th>
                </tr>
            </thead>
            <tbody>';
            
    if (isset($teams) && is_array($teams)) {
        foreach ($teams as $team) {
            $content .= '
                <tr>
                    <td>
                        <div class="team-info">
                            <strong>' . htmlspecialchars($team['name']) . '</strong>';
        
            if (!empty($team['description'])) {
                $content .= '<br><small class="text-muted">' . htmlspecialchars(substr($team['description'], 0, 50)) . '...</small>';
            }
        
            $content .= '
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-info">' . htmlspecialchars($team['category'] ?? 'Belirtilmemiş') . '</span>
                    </td>
                    <td>' . htmlspecialchars($team['coach'] ?? 'Atanmamış') . '</td>
                    <td>
                        <span class="status-badge status-' . ($team['status'] === 'active' ? 'active' : 'inactive') . '">
                            <i class="fas fa-' . ($team['status'] === 'active' ? 'check-circle' : 'times-circle') . '"></i>
                            ' . ($team['status'] === 'active' ? 'Aktif' : 'Pasif') . '
                        </span>
                    </td>
                    <td>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i>
                            ' . (isset($team['created_at']) ? date('d.m.Y', strtotime($team['created_at'])) : 'Bilinmiyor') . '
                        </small>
                    </td>
                    <td>
                        <div class="admin-action-buttons">
                            <a href="' . BASE_URL . '/admin/teams/edit/' . $team['id'] . '" 
                               class="btn btn-admin-primary btn-sm" 
                               title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteTeam(' . $team['id'] . ')" 
                                    class="btn btn-admin-danger btn-sm" 
                                    title="Sil">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>';
        }
    }

    $content .= '
            </tbody>
        </table>
    </div>
    
    <div class="admin-table-footer">
        <div class="admin-table-info">
            <i class="fas fa-info-circle"></i>
            Toplam ' . (isset($teams) && is_array($teams) ? count($teams) : 0) . ' takım listeleniyor.
        </div>
    </div>';
}

$content .= '
</div>

<script>
function deleteTeam(id) {
    const teamRow = document.querySelector("button[onclick=\'deleteTeam(" + id + ")\']").closest("tr");
    const teamName = teamRow ? (teamRow.querySelector("td:nth-child(2)") ? teamRow.querySelector("td:nth-child(2)").textContent.trim() : "Bu takım") : "Bu takım";
    
    showDeleteConfirmation({
        title: "Takım Silme Onayı",
        message: "Bu takımı kalıcı olarak silmek istediğinizden emin misiniz?",
        submessage: "Bu işlem geri alınamaz ve takıma ait tüm bilgiler silinecektir.",
        itemName: teamName,
        confirmText: "Takımı Sil",
        cancelText: "İptal",
        onConfirm: function(closeModal) {
            const formData = new FormData();
            formData.append("csrf_token", "' . ($_SESSION['csrf_token'] ?? '') . '");
            
            fetch("' . BASE_URL . '/admin/teams/delete/" + id, {
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