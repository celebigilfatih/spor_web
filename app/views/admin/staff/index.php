<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-user-tie"></i> Teknik Kadro Yönetimi</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/staff/create" class="btn btn-admin-primary">
            <i class="fas fa-plus"></i> Yeni Kadro Üyesi Ekle
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

if (empty($staff_members)) {
    $content .= '
    <div class="admin-empty-state">
        <i class="fas fa-user-tie fa-4x text-muted mb-3"></i>
        <h3>Henüz teknik kadro üyesi bulunmuyor</h3>
        <p class="text-muted">Başlamak için ilk kadro üyenizi ekleyin.</p>
        <a href="' . BASE_URL . '/admin/staff/create" class="btn btn-admin-primary mt-3">
            <i class="fas fa-plus"></i> İlk Kadro Üyesini Ekle
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
                    <th><i class="fas fa-briefcase"></i> Pozisyon</th>
                    <th><i class="fas fa-shield-alt"></i> Takım</th>
                    <th><i class="fas fa-clock"></i> Deneyim</th>
                    <th><i class="fas fa-certificate"></i> Lisans</th>
                    <th><i class="fas fa-toggle-on"></i> Durum</th>
                    <th><i class="fas fa-cogs"></i> İşlemler</th>
                </tr>
            </thead>
            <tbody>';
            
    foreach ($staff_members as $staff) {
        $content .= '
                <tr>
                    <td>
                        <div class="staff-photo">';
        
        if ($staff['photo']) {
            $content .= '
                            <img src="' . BASE_URL . '/uploads/' . $staff['photo'] . '" 
                                 alt="' . htmlspecialchars($staff['name'] ?? '') . '"
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
                        <div class="staff-info">
                            <strong>' . htmlspecialchars($staff['name'] ?? '') . '</strong>';
        
        $content .= '
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-info">' . htmlspecialchars($staff['position'] ?? $staff['role'] ?? 'Belirtilmemiş') . '</span>
                    </td>
                    <td>' . htmlspecialchars($staff['team_name'] ?? 'Genel') . '</td>
                    <td>';
        
        if (isset($staff['experience']) && $staff['experience']) {
            $content .= htmlspecialchars((string)$staff['experience']);
        } elseif (isset($staff['experience_years']) && $staff['experience_years']) {
            $content .= $staff['experience_years'] . ' yıl';
        } else {
            $content .= '-';
        }
        
        $content .= '
                    </td>
                    <td>' . htmlspecialchars($staff['license'] ?? '-') . '</td>
                    <td>
                        <span class="status-badge status-' . ($staff['status'] === 'active' ? 'active' : 'inactive') . '">
                            <i class="fas fa-' . ($staff['status'] === 'active' ? 'check-circle' : 'times-circle') . '"></i>
                            ' . ($staff['status'] === 'active' ? 'Aktif' : 'Pasif') . '
                        </span>
                    </td>
                    <td>
                        <div class="admin-action-buttons">
                            <a href="' . BASE_URL . '/admin/staff/edit/' . $staff['id'] . '" 
                               class="btn btn-admin-primary btn-sm" 
                               title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteStaff(' . $staff['id'] . ')" 
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
            Toplam ' . count($staff_members) . ' teknik kadro üyesi listeleniyor.
        </div>
    </div>';
}

$content .= '
</div>

<script>
function deleteStaff(id) {
    const staffRow = document.querySelector("button[onclick=\'deleteStaff(" + id + ")\']").closest("tr");
    const staffName = staffRow ? (staffRow.querySelector("td:nth-child(2)") ? staffRow.querySelector("td:nth-child(2)").textContent.trim() : "Bu teknik kadro üyesi") : "Bu teknik kadro üyesi";
    const staffRole = staffRow ? (staffRow.querySelector("td:nth-child(3)") ? staffRow.querySelector("td:nth-child(3)").textContent.trim() : "") : "";
    
    showDeleteConfirmation({
        title: "Teknik Kadro Silme Onayı",
        message: "Bu teknik kadro üyesini kalıcı olarak silmek istediğinizden emin misiniz?",
        submessage: "Bu işlem geri alınamaz ve üyeye ait tüm bilgiler silinecektir.",
        itemName: staffName,
        itemDetails: staffRole ? "Görev: " + staffRole : "",
        confirmText: "Üyeyi Sil",
        cancelText: "İptal",
        onConfirm: function(closeModal) {
            const formData = new FormData();
            formData.append("csrf_token", "' . ($_SESSION['csrf_token'] ?? '') . '");
            
            fetch("' . BASE_URL . '/admin/staff/delete/" + id, {
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