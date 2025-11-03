<?php
$content = '
<div class="youth-registrations-page">
    <!-- Page Header -->
    <div class="page-header-shadcn">
        <div class="page-header-content-shadcn">
            <div>
                <h1 class="page-title-shadcn">Alt Yapı Kayıtları</h1>
                <p class="page-description-shadcn">Genç oyuncu başvurularını yönetin ve değerlendirin</p>
            </div>
            <div class="page-actions-shadcn">
                <a href="' . BASE_URL . '/admin/youth-registrations/create" class="btn-shadcn btn-primary-shadcn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Yeni Kayıt Ekle
                </a>
                <a href="' . BASE_URL . '/youth-registration" class="btn-shadcn btn-outline-shadcn" target="_blank">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                    Kayıt Formu
                </a>
                <a href="' . BASE_URL . '/admin/youth-registrations/stats" class="btn-shadcn btn-secondary-shadcn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="20" x2="12" y2="10"></line>
                        <line x1="18" y1="20" x2="18" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="16"></line>
                    </svg>
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
                <small class="text-muted" style="font-size: 0.75rem; margin-top: 0.25rem;">Alt yapı oyuncuları listesinde görünür</small>
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
                    <th><i class="fas fa-user"></i> Öğrenci Adı</th>
                    <th><i class="fas fa-users"></i> Grup</th>
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
        if (isset($registration['student']['name'])) {
            // New structure from admin create form
            $studentName = htmlspecialchars($registration['student']['name']);
        } elseif (isset($registration['student']['first_name'])) {
            // Old structure with separate first/last name
            $studentName = htmlspecialchars($registration['student']['first_name'] . ' ' . $registration['student']['last_name']);
        } elseif (isset($registration['student_name'])) {
            // Flat structure
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
        
        // Get youth group info
        $youthGroupId = $registration['youth_group_id'] ?? 0;
        $groupName = '-';
        if ($youthGroupId > 0 && isset($youth_groups[$youthGroupId])) {
            $group = $youth_groups[$youthGroupId];
            $groupName = htmlspecialchars($group['name']) . ' (' . htmlspecialchars($group['age_group']) . ')';
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
                <tr' . ($status === 'approved' ? ' class="approved-row"' : '') . '>
                    <td>
                        <div class="student-info">
                            <strong>' . $studentName . '</strong>';
        
        $tcNumber = $registration['student']['tc_number'] ?? $registration['student_tc'] ?? '';
        if (!empty($tcNumber)) {
            $content .= '
                            <br><small class="text-muted">TC: ' . htmlspecialchars($tcNumber) . '</small>';
        }
        
        // Add indicator for approved registrations
        if ($status === 'approved') {
            $content .= '
                            <br><small class="text-success"><i class="fas fa-user-check"></i> Alt yapı oyuncularında görünür</small>';
        }
        
        $content .= '
                        </div>
                    </td>
                    <td>' . $groupName . '</td>
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
                            
                            <a href="' . BASE_URL . '/admin/youth-registrations/edit/' . $registration['id'] . '" 
                               class="btn btn-sm btn-admin-warning" 
                               title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" class="btn btn-sm btn-admin-secondary" 
                                    onclick="showStatusModal(\'' . $registration['id'] . '\', \'' . $status . '\')" 
                                    title="Durum Değiştir">
                                <i class="fas fa-toggle-on"></i>
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
/* Shadcn Youth Registrations Page Styles */
.youth-registrations-page {
    max-width: 100%;
}

/* Shadcn Page Header */
.page-header-shadcn {
    background: white;
    border: 1px solid #e4e4e7;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.page-header-content-shadcn {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-title-shadcn {
    font-size: 1.5rem;
    font-weight: 600;
    color: #09090b;
    margin: 0 0 0.25rem 0;
    letter-spacing: -0.025em;
}

.page-description-shadcn {
    color: #71717a;
    margin: 0;
    font-size: 0.875rem;
}

.page-actions-shadcn {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

/* Shadcn Buttons */
.btn-shadcn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.15s;
    border: 1px solid transparent;
    cursor: pointer;
}

.btn-outline-shadcn {
    background: white;
    color: #18181b;
    border-color: #e4e4e7;
}

.btn-outline-shadcn:hover {
    background: #f4f4f5;
    color: #18181b;
}

.btn-primary-shadcn {
    background: #18181b;
    color: #fafafa;
}

.btn-primary-shadcn:hover {
    background: #27272a;
}

.btn-secondary-shadcn {
    background: #18181b;
    color: #fafafa;
}

.btn-secondary-shadcn:hover {
    background: #27272a;
}

/* Shadcn Stats Grid */
.stats-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-card-modern {
    background: white;
    border: 1px solid #e4e4e7;
    border-radius: 0.5rem;
    padding: 1.5rem;
    transition: all 0.15s;
}

.stat-card-modern:hover {
    border-color: #d4d4d8;
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
}

.stat-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.stat-card-icon {
    width: 40px;
    height: 40px;
    border-radius: 0.375rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-card-primary .stat-card-icon {
    background: #f4f4f5;
    color: #18181b;
}

.stat-card-warning .stat-card-icon {
    background: #fef3c7;
    color: #92400e;
}

.stat-card-success .stat-card-icon {
    background: #dcfce7;
    color: #166534;
}

.stat-card-danger .stat-card-icon {
    background: #fee2e2;
    color: #991b1b;
}

.trend-badge {
    padding: 0.125rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    background: #f4f4f5;
    color: #71717a;
}

.stat-card-body {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #09090b;
    line-height: 1;
    margin-bottom: 0.25rem;
    letter-spacing: -0.05em;
}

.stat-label {
    color: #71717a;
    font-size: 0.875rem;
    font-weight: 500;
}

/* Empty State Shadcn */
.empty-state-modern {
    background: white;
    border: 1px solid #e4e4e7;
    border-radius: 0.5rem;
    padding: 3rem 2rem;
    text-align: center;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: #f4f4f5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #71717a;
}

.empty-state-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #09090b;
    margin-bottom: 0.5rem;
}

.empty-state-text {
    color: #71717a;
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

/* Shadcn Table */
.admin-table-wrapper {
    background: white;
    border: 1px solid #e4e4e7;
    border-radius: 0.5rem;
    overflow: hidden;
}

.admin-table thead {
    background: #fafafa;
    border-bottom: 1px solid #e4e4e7;
}

.admin-table th {
    font-weight: 500;
    font-size: 0.75rem;
    color: #71717a;
    padding: 0.75rem 1rem;
    text-align: left;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.admin-table td {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #e4e4e7;
    font-size: 0.875rem;
    color: #09090b;
}

.admin-table tbody tr:last-child td {
    border-bottom: none;
}

.admin-table tbody tr:hover {
    background: #fafafa;
}

/* Approved row highlighting */
.approved-row {
    background: #f0fdf4 !important;
}

.approved-row:hover {
    background: #dcfce7 !important;
}

.text-success {
    color: #166534 !important;
    font-weight: 600;
}

.student-info strong {
    color: #09090b;
    font-weight: 600;
}

.student-info .text-muted {
    color: #71717a;
    font-size: 0.75rem;
}

/* Shadcn Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    border: 1px solid;
}

.status-success {
    background: #dcfce7;
    color: #166534;
    border-color: #bbf7d0;
}

.status-warning {
    background: #fef3c7;
    color: #92400e;
    border-color: #fde68a;
}

.status-danger {
    background: #fee2e2;
    color: #991b1b;
    border-color: #fecaca;
}

/* Action Buttons */
.admin-table-actions {
    display: flex;
    gap: 0.375rem;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
}

.btn-admin-info {
    background: #18181b;
    color: white;
    border: none;
}

.btn-admin-info:hover {
    background: #27272a;
}

.btn-admin-warning {
    background: white;
    color: #18181b;
    border: 1px solid #e4e4e7;
}

.btn-admin-warning:hover {
    background: #f4f4f5;
}

.btn-admin-danger {
    background: white;
    color: #ef4444;
    border: 1px solid #e4e4e7;
}

.btn-admin-danger:hover {
    background: #fef2f2;
    border-color: #fecaca;
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

/* Modal Form Focus States - Shadcn Style */
#statusModal select:focus,
#statusModal textarea:focus {
    border-color: #18181b !important;
    box-shadow: 0 0 0 2px rgba(24, 24, 27, 0.1) !important;
    outline: none !important;
}

#statusModal select:hover,
#statusModal textarea:hover {
    border-color: #a1a1aa;
}

#statusModal button[type="submit"]:hover {
    background: #27272a !important;
}

#statusModal button[data-dismiss]:hover {
    background: #f4f4f5 !important;
}

.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5);
}
</style>

<!-- Durum Güncelleme Modal - Shadcn Style -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
        <div class="modal-content" style="border: 1px solid #e4e4e7; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); background: white;">
            <form method="POST" action="' . BASE_URL . '/admin/youth-registrations/updateStatus">
                <div style="padding: 1.5rem; border-bottom: 1px solid #e4e4e7;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #09090b; margin: 0; letter-spacing: -0.025em;">Kayıt Durumunu Güncelle</h3>
                    <p style="color: #71717a; font-size: 0.875rem; margin: 0.25rem 0 0 0;">Başvuru durumunu değiştirin</p>
                </div>
                
                <div style="padding: 1.5rem;">
                    <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                    <input type="hidden" name="id" id="statusRegistrationId">
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label for="status" style="display: block; font-size: 0.875rem; font-weight: 500; color: #09090b; margin-bottom: 0.5rem;">
                            Durum <span style="color: #ef4444;">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="shadcn-select"
                                style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #e4e4e7; border-radius: 0.375rem; font-size: 0.875rem; background: white; color: #09090b; transition: all 0.15s;">
                            <option value="pending">⏳ Beklemede</option>
                            <option value="approved">✅ Onaylandı</option>
                            <option value="rejected">❌ Reddedildi</option>
                        </select>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label for="notes" style="display: block; font-size: 0.875rem; font-weight: 500; color: #09090b; margin-bottom: 0.5rem;">
                            Notlar
                        </label>
                        <textarea name="notes" id="notes" rows="4"
                                  class="shadcn-textarea"
                                  style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #e4e4e7; border-radius: 0.375rem; font-size: 0.875rem; resize: vertical; transition: all 0.15s;"
                                  placeholder="Durum değişikliği ile ilgili notlarınızı buraya yazabilirsiniz..."></textarea>
                    </div>
                    
                    <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 0.375rem; padding: 1rem;">
                        <div style="display: flex; gap: 0.75rem;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <div style="flex: 1;">
                                <p style="font-size: 0.875rem; font-weight: 500; color: #0c4a6e; margin: 0 0 0.25rem 0;">Bilgi</p>
                                <p style="font-size: 0.875rem; color: #075985; margin: 0; line-height: 1.5;">Durumu "Onaylandı" olarak değiştirdiğinizde, öğrenci otomatik olarak alt yapı oyuncuları listesine eklenecektir.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="padding: 1.5rem; background: #fafafa; border-top: 1px solid #e4e4e7; display: flex; gap: 0.75rem; justify-content: flex-end;">
                    <button type="button" class="btn" data-dismiss="modal"
                            style="padding: 0.5rem 1rem; border: 1px solid #e4e4e7; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; background: white; color: #18181b; transition: all 0.15s; cursor: pointer;">
                        İptal
                    </button>
                    <button type="submit" class="btn"
                            style="padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; background: #18181b; color: #fafafa; transition: all 0.15s; cursor: pointer;">
                        Güncelle
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