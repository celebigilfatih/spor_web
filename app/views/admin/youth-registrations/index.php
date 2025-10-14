<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-users"></i> Alt Yapı Kayıtları</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/youth-registrations/stats" class="btn btn-admin-secondary">
            <i class="fas fa-chart-bar"></i> İstatistikler
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

if (empty($registrations)) {
    $content .= '
    <div class="admin-empty-state">
        <i class="fas fa-users fa-4x text-muted mb-3"></i>
        <h3>Henüz kayıt bulunmuyor</h3>
        <p class="text-muted">Alt yapı kayıt formu doldurulduğunda kayıtlar burada görünecektir.</p>
        <a href="' . BASE_URL . '/youth-registration" class="btn btn-admin-primary mt-3" target="_blank">
            <i class="fas fa-external-link-alt"></i> Kayıt Formunu Görüntüle
        </a>
    </div>';
} else {
    // İstatistik kartları
    $totalRegistrations = count($registrations);
    $pendingCount = count(array_filter($registrations, function($r) { return ($r['status'] ?? 'pending') === 'pending'; }));
    $approvedCount = count(array_filter($registrations, function($r) { return ($r['status'] ?? 'pending') === 'approved'; }));
    $rejectedCount = count(array_filter($registrations, function($r) { return ($r['status'] ?? 'pending') === 'rejected'; }));
    
    $content .= '
    <div class="admin-stats-grid mb-4">
        <div class="admin-stat-card">
            <div class="stat-icon bg-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>' . $totalRegistrations . '</h3>
                <p>Toplam Kayıt</p>
            </div>
        </div>
        
        <div class="admin-stat-card">
            <div class="stat-icon bg-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>' . $pendingCount . '</h3>
                <p>Bekleyen</p>
            </div>
        </div>
        
        <div class="admin-stat-card">
            <div class="stat-icon bg-success">
                <i class="fas fa-check"></i>
            </div>
            <div class="stat-content">
                <h3>' . $approvedCount . '</h3>
                <p>Onaylanan</p>
            </div>
        </div>
        
        <div class="admin-stat-card">
            <div class="stat-icon bg-danger">
                <i class="fas fa-times"></i>
            </div>
            <div class="stat-content">
                <h3>' . $rejectedCount . '</h3>
                <p>Reddedilen</p>
            </div>
        </div>
    </div>
    
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><i class="fas fa-user"></i> Öğrenci Adı</th>
                    <th><i class="fas fa-birthday-cake"></i> Yaş</th>
                    <th><i class="fas fa-phone"></i> Telefon</th>
                    <th><i class="fas fa-toggle-on"></i> Durum</th>
                    <th><i class="fas fa-calendar"></i> Kayıt Tarihi</th>
                    <th><i class="fas fa-cogs"></i> İşlemler</th>
                </tr>
            </thead>
            <tbody>';
            
    foreach ($registrations as $registration) {
        $studentName = htmlspecialchars($registration['student']['first_name'] . ' ' . $registration['student']['last_name']);
        $age = '';
        if (!empty($registration['student']['birth_date'])) {
            $birthDate = new DateTime($registration['student']['birth_date']);
            $today = new DateTime();
            $age = $today->diff($birthDate)->y;
        }
        $phone = htmlspecialchars($registration['parent']['phone'] ?? '');
        $status = $registration['status'] ?? 'pending';
        $createdAt = date('d.m.Y H:i', strtotime($registration['created_at']));
        
        $statusClass = '';
        $statusText = '';
        $statusIcon = '';
        
        switch ($status) {
            case 'approved':
                $statusClass = 'success';
                $statusText = 'ONAYLANDI';
                $statusIcon = 'check-circle';
                break;
            case 'rejected':
                $statusClass = 'danger';
                $statusText = 'REDDEDİLDİ';
                $statusIcon = 'times-circle';
                break;
            default:
                $statusClass = 'warning';
                $statusText = 'BEKLEMEDE';
                $statusIcon = 'clock';
        }
        
        $content .= '
                <tr>
                    <td>' . htmlspecialchars($registration['id']) . '</td>
                    <td>
                        <div class="student-info">
                            <strong>' . $studentName . '</strong>';
        
        if (!empty($registration['student']['tc_number'])) {
            $content .= '
                            <br><small class="text-muted">TC: ' . htmlspecialchars($registration['student']['tc_number']) . '</small>';
        }
        
        $content .= '
                        </div>
                    </td>
                    <td>' . ($age ? $age . ' yaş' : '-') . '</td>
                    <td>' . $phone . '</td>
                    <td>
                        <span class="status-badge status-' . $statusClass . '">
                            <i class="fas fa-' . $statusIcon . '"></i>
                            ' . $statusText . '
                        </span>
                    </td>
                    <td>' . $createdAt . '</td>
                    <td>
                        <div class="admin-table-actions">
                            <a href="' . BASE_URL . '/admin/youth-registrations/viewRegistration/' . $registration['id'] . '" 
                               class="btn btn-sm btn-admin-info" title="Detayları Görüntüle">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            <button type="button" class="btn btn-sm btn-admin-warning" 
                                    onclick="showStatusModal(\'' . $registration['id'] . '\', \'' . $status . '\')" 
                                    title="Durumu Güncelle">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <button type="button" class="btn btn-sm btn-admin-danger" 
                                    onclick="confirmDelete(\'' . $registration['id'] . '\', \'' . $studentName . '\')" 
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
    </div>';
}

$content .= '
</div>

<!-- Durum Güncelleme Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kayıt Durumunu Güncelle</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" action="' . BASE_URL . '/admin/youth-registrations/updateStatus">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                    <input type="hidden" name="id" id="statusRegistrationId">
                    
                    <div class="form-group">
                        <label for="status">Durum:</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="pending">Beklemede</option>
                            <option value="approved">Onaylandı</option>
                            <option value="rejected">Reddedildi</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes">Notlar (Opsiyonel):</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" 
                                  placeholder="Durum değişikliği ile ilgili notlarınızı buraya yazabilirsiniz..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-admin-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Silme Onay Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kayıt Silme Onayı</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bu kaydı silmek istediğinizden emin misiniz?</p>
                <p><strong id="deleteStudentName"></strong> adlı öğrencinin kaydı kalıcı olarak silinecektir.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                <form method="POST" action="' . BASE_URL . '/admin/youth-registrations/delete" style="display: inline;">
                    <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                    <input type="hidden" name="id" id="deleteRegistrationId">
                    <button type="submit" class="btn btn-admin-danger">Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showStatusModal(id, currentStatus) {
    document.getElementById("statusRegistrationId").value = id;
    document.getElementById("status").value = currentStatus;
    document.getElementById("notes").value = "";
    $("#statusModal").modal("show");
}

function confirmDelete(id, studentName) {
    document.getElementById("deleteRegistrationId").value = id;
    document.getElementById("deleteStudentName").textContent = studentName;
    $("#deleteModal").modal("show");
}
</script>';

include BASE_PATH . '/app/views/admin/layout.php';
?>