<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-user"></i> Kullanıcı Detayları</h1>
    <div>
        <a href="' . BASE_URL . '/admin/users/edit/' . $user['id'] . '" class="btn btn-admin-warning">
            <i class="fas fa-edit"></i> Düzenle
        </a>
        <a href="' . BASE_URL . '/admin/users" class="btn btn-admin-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <!-- User Info Card -->
        <div class="admin-content-card">
            <div class="text-center mb-4">
                <div class="user-avatar-large">
                    ' . strtoupper(substr($user['username'], 0, 2)) . '
                </div>
                <h3 class="mt-3 mb-1">' . htmlspecialchars($user['full_name'] ?? 'N/A') . '</h3>
                <p class="text-muted">@' . htmlspecialchars($user['username']) . '</p>
                
                <div class="mt-3">';
                
$roleLabel = $user['role'] === 'super_admin' ? 
    '<span class="badge badge-danger badge-lg"><i class="fas fa-shield-alt"></i> Süper Admin</span>' : 
    '<span class="badge badge-info badge-lg"><i class="fas fa-user"></i> Admin</span>';

$statusLabel = $user['status'] === 'active' ? 
    '<span class="badge badge-success badge-lg"><i class="fas fa-check-circle"></i> Aktif</span>' : 
    '<span class="badge badge-secondary badge-lg"><i class="fas fa-times-circle"></i> Pasif</span>';

$content .= '
                    ' . $roleLabel . '
                    ' . $statusLabel . '
                </div>
            </div>
            
            <hr>
            
            <div class="user-info-list">
                <div class="user-info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <strong>E-posta</strong>
                        <p>' . htmlspecialchars($user['email']) . '</p>
                    </div>
                </div>
                
                <div class="user-info-item">
                    <i class="fas fa-calendar-plus"></i>
                    <div>
                        <strong>Oluşturulma Tarihi</strong>
                        <p>' . date('d.m.Y H:i', strtotime($user['created_at'])) . '</p>
                    </div>
                </div>
                
                <div class="user-info-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <strong>Son Güncelleme</strong>
                        <p>' . (!empty($user['updated_at']) ? date('d.m.Y H:i', strtotime($user['updated_at'])) : 'Hiç güncellenmedi') . '</p>
                    </div>
                </div>
                
                <div class="user-info-item">
                    <i class="fas fa-sign-in-alt"></i>
                    <div>
                        <strong>Son Giriş</strong>
                        <p>' . (!empty($user['last_login']) ? date('d.m.Y H:i', strtotime($user['last_login'])) : 'Hiç giriş yapmadı') . '</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Account Details -->
        <div class="admin-content-card mb-4">
            <h3 class="card-title"><i class="fas fa-info-circle"></i> Hesap Bilgileri</h3>
            
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="30%">Kullanıcı ID</th>
                        <td>#' . $user['id'] . '</td>
                    </tr>
                    <tr>
                        <th>Kullanıcı Adı</th>
                        <td><strong>' . htmlspecialchars($user['username']) . '</strong></td>
                    </tr>
                    <tr>
                        <th>Ad Soyad</th>
                        <td>' . htmlspecialchars($user['full_name'] ?? 'N/A') . '</td>
                    </tr>
                    <tr>
                        <th>E-posta</th>
                        <td>' . htmlspecialchars($user['email']) . '</td>
                    </tr>
                    <tr>
                        <th>Rol</th>
                        <td>' . $roleLabel . '</td>
                    </tr>
                    <tr>
                        <th>Durum</th>
                        <td>' . $statusLabel . '</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Activity Log -->
        <div class="admin-content-card">
            <h3 class="card-title"><i class="fas fa-history"></i> Aktivite Geçmişi</h3>
            
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker bg-success"></div>
                    <div class="timeline-content">
                        <h4>Hesap Oluşturuldu</h4>
                        <p class="text-muted">' . date('d.m.Y H:i', strtotime($user['created_at'])) . '</p>
                    </div>
                </div>';

if (!empty($user['last_login'])) {
    $content .= '
                <div class="timeline-item">
                    <div class="timeline-marker bg-info"></div>
                    <div class="timeline-content">
                        <h4>Son Giriş</h4>
                        <p class="text-muted">' . date('d.m.Y H:i', strtotime($user['last_login'])) . '</p>
                    </div>
                </div>';
}

if (!empty($user['updated_at']) && $user['updated_at'] !== $user['created_at']) {
    $content .= '
                <div class="timeline-item">
                    <div class="timeline-marker bg-warning"></div>
                    <div class="timeline-content">
                        <h4>Hesap Güncellendi</h4>
                        <p class="text-muted">' . date('d.m.Y H:i', strtotime($user['updated_at'])) . '</p>
                    </div>
                </div>';
}

$content .= '
            </div>
        </div>
    </div>
</div>

<style>
.user-avatar-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 700;
    margin: 0 auto;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.badge-lg {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    margin: 0 0.25rem;
}

.user-info-list {
    margin-top: 1.5rem;
}

.user-info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #e4e4e7;
}

.user-info-item:last-child {
    border-bottom: none;
}

.user-info-item i {
    width: 40px;
    height: 40px;
    border-radius: 0.375rem;
    background: #f4f4f5;
    color: #0ea5e9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.user-info-item strong {
    display: block;
    color: #71717a;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
}

.user-info-item p {
    margin: 0;
    color: #09090b;
    font-weight: 500;
}

.card-title {
    color: #09090b;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e4e4e7;
}

.card-title i {
    color: #0ea5e9;
    margin-right: 0.5rem;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: "";
    position: absolute;
    left: 0.625rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e4e4e7;
}

.timeline-item {
    position: relative;
    padding-bottom: 2rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -1.375rem;
    width: 1.25rem;
    height: 1.25rem;
    border-radius: 50%;
    border: 3px solid white;
}

.timeline-marker.bg-success { background: #22c55e; }
.timeline-marker.bg-info { background: #0ea5e9; }
.timeline-marker.bg-warning { background: #f59e0b; }

.timeline-content h4 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #09090b;
    margin-bottom: 0.25rem;
}

.timeline-content p {
    font-size: 0.875rem;
    margin: 0;
}
</style>';

include BASE_PATH . '/app/views/admin/layout.php';
?>
