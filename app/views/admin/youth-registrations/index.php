<?php
$content = '
<div class="youth-registrations-page">
    <!-- Page Header -->
    <div class="page-header-modern">
        <div class="page-header-content">
            <div class="page-title-section">
                <div class="page-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <h1 class="page-title">Alt Yapı Kayıtları</h1>
                    <p class="page-subtitle">Genç oyuncu başvurularını yönetin ve değerlendirin</p>
                </div>
            </div>
            <div class="page-actions">
                <a href="' . BASE_URL . '/youth-registration" class="btn btn-outline" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    Kayıt Formu
                </a>
                <a href="' . BASE_URL . '/admin/youth-registrations/stats" class="btn btn-admin-secondary">
                    <i class="fas fa-chart-bar"></i>
                    İstatistikler
                </a>
            </div>
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
    <div class="empty-state-modern">
        <div class="empty-state-icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <h3 class="empty-state-title">Henüz kayıt bulunmuyor</h3>
        <p class="empty-state-text">Alt yapı kayıt formu doldurulduğunda başvurular burada görünecektir.</p>
        <div class="empty-state-actions">
            <a href="' . BASE_URL . '/youth-registration" class="btn btn-admin-primary" target="_blank">
                <i class="fas fa-plus-circle"></i>
                Kayıt Formunu Görüntüle
            </a>
        </div>
    </div>';
} else {
    // İstatistik kartları
    $totalRegistrations = count($registrations);
    $pendingCount = count(array_filter($registrations, function($r) { return ($r['status'] ?? 'pending') === 'pending'; }));
    $approvedCount = count(array_filter($registrations, function($r) { return ($r['status'] ?? 'pending') === 'approved'; }));
    $rejectedCount = count(array_filter($registrations, function($r) { return ($r['status'] ?? 'pending') === 'rejected'; }));
    
    $content .= '
    <!-- Stats Cards -->
    <div class="stats-grid-modern">
        <div class="stat-card-modern stat-card-primary">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-card-trend">
                    <span class="trend-badge">Toplam</span>
                </div>
            </div>
            <div class="stat-card-body">
                <div class="stat-number">' . $totalRegistrations . '</div>
                <div class="stat-label">Toplam Başvuru</div>
            </div>
        </div>
        
        <div class="stat-card-modern stat-card-warning">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stat-card-trend">
                    <span class="trend-badge trend-warning">İşlemde</span>
                </div>
            </div>
            <div class="stat-card-body">
                <div class="stat-number">' . $pendingCount . '</div>
                <div class="stat-label">Bekleyen Başvuru</div>
            </div>
        </div>
        
        <div class="stat-card-modern stat-card-success">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-card-trend">
                    <span class="trend-badge trend-success">Onaylandı</span>
                </div>
            </div>
            <div class="stat-card-body">
                <div class="stat-number">' . $approvedCount . '</div>
                <div class="stat-label">Kabul Edilen</div>
            </div>
        </div>
        
        <div class="stat-card-modern stat-card-danger">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-card-trend">
                    <span class="trend-badge trend-danger">Reddedildi</span>
                </div>
            </div>
            <div class="stat-card-body">
                <div class="stat-number">' . $rejectedCount . '</div>
                <div class="stat-label">Red Edilen</div>
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
        // Handle both nested and flat data structures
        $studentName = '';
        if (isset($registration['student']['first_name'])) {
            $studentName = htmlspecialchars($registration['student']['first_name'] . ' ' . $registration['student']['last_name']);
        } elseif (isset($registration['student_name'])) {
            $studentName = htmlspecialchars($registration['student_name']);
        }
        
        $age = '';
        $birthDate = $registration['student']['birth_date'] ?? $registration['student_birth_date'] ?? '';
        if (!empty($birthDate)) {
            try {
                $birthDateTime = new DateTime($birthDate);
                $today = new DateTime();
                $age = $today->diff($birthDateTime)->y;
            } catch (Exception $e) {
                $age = '';
            }
        }
        
        $phone = htmlspecialchars($registration['parent']['phone'] ?? $registration['parent_phone'] ?? '');
        $status = $registration['status'] ?? 'pending';
        $createdAt = '';
        $registrationDate = $registration['created_at'] ?? $registration['registration_date'] ?? '';
        if (!empty($registrationDate)) {
            $createdAt = date('d.m.Y H:i', strtotime($registrationDate));
        }
        
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
        
        $tcNumber = $registration['student']['tc_number'] ?? $registration['student_tc'] ?? '';
        if (!empty($tcNumber)) {
            $content .= '
                            <br><small class="text-muted">TC: ' . htmlspecialchars($tcNumber) . '</small>';
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

<style>
/* Modern Youth Registrations Page Styles */
.youth-registrations-page {
    max-width: 100%;
}

.page-header-modern {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.page-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.page-title-section {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.page-icon {
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    backdrop-filter: blur(10px);
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin: 0;
    letter-spacing: -0.025em;
}

.page-subtitle {
    color: rgba(255, 255, 255, 0.9);
    margin: 0.5rem 0 0 0;
    font-size: 1rem;
}

.page-actions {
    display: flex;
    gap: 0.75rem;
}

/* Stats Grid Modern */
.stats-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card-modern {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.stat-card-modern:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.stat-card-primary {
    border-color: #3b82f6;
}

.stat-card-primary:hover {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
}

.stat-card-warning {
    border-color: #f59e0b;
}

.stat-card-warning:hover {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
}

.stat-card-success {
    border-color: #10b981;
}

.stat-card-success:hover {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
}

.stat-card-danger {
    border-color: #ef4444;
}

.stat-card-danger:hover {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
}

.stat-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.stat-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-card-primary .stat-card-icon {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.stat-card-warning .stat-card-icon {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.stat-card-success .stat-card-icon {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.stat-card-danger .stat-card-icon {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.trend-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    background: #e2e8f0;
    color: #475569;
}

.trend-warning {
    background: #fef3c7;
    color: #92400e;
}

.trend-success {
    background: #dcfce7;
    color: #166534;
}

.trend-danger {
    background: #fee2e2;
    color: #991b1b;
}

.stat-card-body {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1;
    margin-bottom: 0.5rem;
    letter-spacing: -0.05em;
}

.stat-label {
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Empty State Modern */
.empty-state-modern {
    background: white;
    border-radius: 12px;
    padding: 4rem 2rem;
    text-align: center;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.empty-state-icon {
    width: 96px;
    height: 96px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: #3b82f6;
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.empty-state-text {
    color: #64748b;
    font-size: 1rem;
    margin-bottom: 2rem;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.empty-state-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

/* Enhanced Table Styles */
.admin-table-wrapper {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
}

.admin-table thead {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.admin-table th {
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-size: 0.75rem;
    color: #475569;
    padding: 1rem 1.5rem;
}

.admin-table td {
    padding: 1rem 1.5rem;
    vertical-align: middle;
}

.admin-table tbody tr:hover {
    background: #f8fafc;
}

.student-info strong {
    color: #1e293b;
    font-weight: 600;
    font-size: 0.95rem;
}

.student-info .text-muted {
    color: #64748b;
    font-size: 0.8rem;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-success {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
    border: 1px solid #86efac;
}

.status-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    border: 1px solid #fcd34d;
}

.status-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border: 1px solid #fca5a5;
}

/* Action Buttons */
.admin-table-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-admin-info {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border: none;
}

.btn-admin-info:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
}

.btn-admin-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border: none;
}

.btn-admin-warning:hover {
    background: linear-gradient(135deg, #d97706, #b45309);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);
}

.btn-admin-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .page-title-section {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .stats-grid-modern {
        grid-template-columns: 1fr;
    }
    
    .admin-table-wrapper {
        overflow-x: auto;
    }
}

/* Modern Modal Styles */
.modal {
    z-index: 9999;
}

.modal-backdrop {
    z-index: 9998;
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: calc(100% - 1rem);
}

.modern-modal {
    border-radius: 16px;
    border: none;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.modern-modal .modal-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 1.5rem;
    border-bottom: none;
}

.modern-modal .modal-header .modal-title {
    font-weight: 700;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modern-modal .modal-header .close {
    color: white;
    opacity: 0.9;
    text-shadow: none;
    font-size: 1.5rem;
    font-weight: 300;
}

.modern-modal .modal-header .close:hover {
    opacity: 1;
}

.modal-header-danger {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;
}

.modern-modal .modal-body {
    padding: 2rem;
}

.modern-modal .modal-footer {
    padding: 1.5rem;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.form-label-modern {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.form-control-modern {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.form-control-modern:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

.alert-warning {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border: 1px solid #fcd34d;
    color: #92400e;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.alert-warning i {
    margin-right: 0.5rem;
}

/* Modal Animation */
.modal.fade .modal-dialog {
    transform: scale(0.8);
    opacity: 0;
    transition: all 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: scale(1);
    opacity: 1;
}
</style>

<!-- Durum Güncelleme Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modern-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">
                    <i class="fas fa-edit"></i> Kayıt Durumunu Güncelle
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="' . BASE_URL . '/admin/youth-registrations/updateStatus">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                    <input type="hidden" name="id" id="statusRegistrationId">
                    
                    <div class="form-group">
                        <label for="status" class="form-label-modern">
                            <i class="fas fa-toggle-on"></i> Durum
                        </label>
                        <select name="status" id="status" class="form-control form-control-modern" required>
                            <option value="pending">⏳ Beklemede</option>
                            <option value="approved">✅ Onaylandı</option>
                            <option value="rejected">❌ Reddedildi</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes" class="form-label-modern">
                            <i class="fas fa-sticky-note"></i> Notlar (Opsiyonel)
                        </label>
                        <textarea name="notes" id="notes" class="form-control form-control-modern" rows="4" 
                                  placeholder="Durum değişikliği ile ilgili notlarınızı buraya yazabilirsiniz..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> İptal
                    </button>
                    <button type="submit" class="btn btn-admin-primary">
                        <i class="fas fa-save"></i> Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Silme Onay Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modern-modal">
            <div class="modal-header modal-header-danger">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle"></i> Kayıt Silme Onayı
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Dikkat!</strong> Bu işlem geri alınamaz.
                </div>
                <p class="mb-2"><strong id="deleteStudentName"></strong> adlı öğrencinin kaydını silmek istediğinizden emin misiniz?</p>
                <p class="text-muted small">Kayıt ve ilgili tüm veriler kalıcı olarak silinecektir.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> İptal
                </button>
                <form method="POST" action="' . BASE_URL . '/admin/youth-registrations/delete" style="display: inline;">
                    <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                    <input type="hidden" name="id" id="deleteRegistrationId">
                    <button type="submit" class="btn btn-admin-danger">
                        <i class="fas fa-trash"></i> Evet, Sil
                    </button>
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