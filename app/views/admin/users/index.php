<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-users-cog"></i> Kullanıcı Yönetimi</h1>
    <a href="' . BASE_URL . '/admin/users/create" class="btn btn-admin-primary">
        <i class="fas fa-plus"></i> Yeni Kullanıcı Ekle
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon bg-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-info">
                <h3>' . ($stats['total'] ?? 0) . '</h3>
                <p>Toplam Kullanıcı</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stats-info">
                <h3>' . ($stats['active'] ?? 0) . '</h3>
                <p>Aktif Kullanıcı</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stats-info">
                <h3>' . ($stats['super_admins'] ?? 0) . '</h3>
                <p>Süper Admin</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon bg-secondary">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="stats-info">
                <h3>' . ($stats['inactive'] ?? 0) . '</h3>
                <p>Pasif Kullanıcı</p>
            </div>
        </div>
    </div>
</div>

<div class="admin-content-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kullanıcı Adı</th>
                    <th>Ad Soyad</th>
                    <th>E-posta</th>
                    <th>Rol</th>
                    <th>Durum</th>
                    <th>Son Giriş</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>';

if (!empty($users)) {
    foreach ($users as $user) {
        $roleLabel = $user['role'] === 'super_admin' ? 
            '<span class="badge badge-danger"><i class="fas fa-shield-alt"></i> Süper Admin</span>' : 
            '<span class="badge badge-info"><i class="fas fa-user"></i> Admin</span>';
        
        $statusLabel = $user['status'] === 'active' ? 
            '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>' : 
            '<span class="badge badge-secondary"><i class="fas fa-times-circle"></i> Pasif</span>';
        
        $lastLogin = !empty($user['last_login']) ? 
            date('d.m.Y H:i', strtotime($user['last_login'])) : 
            '<span class="text-muted">Hiç giriş yapmadı</span>';
        
        $isCurrentUser = $user['id'] == ($_SESSION['admin_id'] ?? 0);
        $isSuperAdmin = $user['role'] === 'super_admin';
        $canEdit = !$isSuperAdmin || ($_SESSION['admin_role'] ?? 'admin') === 'super_admin';
        
        $content .= '
                <tr>
                    <td>#' . htmlspecialchars($user['id']) . '</td>
                    <td><strong>' . htmlspecialchars($user['username']) . '</strong></td>
                    <td>' . htmlspecialchars($user['full_name'] ?? '') . '</td>
                    <td>' . htmlspecialchars($user['email']) . '</td>
                    <td>' . $roleLabel . '</td>
                    <td>' . $statusLabel . '</td>
                    <td>' . $lastLogin . '</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="' . BASE_URL . '/admin/users/details/' . $user['id'] . '" 
                               class="btn btn-info" title="Detaylar">
                                <i class="fas fa-eye"></i>
                            </a>';
        
        if ($canEdit) {
            $content .= '
                            <a href="' . BASE_URL . '/admin/users/edit/' . $user['id'] . '" 
                               class="btn btn-warning" title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </a>';
        }
        
        if (!$isCurrentUser && $canEdit) {
            $content .= '
                            <button type="button" class="btn btn-danger" 
                                    onclick="deleteUser(' . $user['id'] . ', \'' . htmlspecialchars($user['username']) . '\')" 
                                    title="Sil">
                                <i class="fas fa-trash"></i>
                            </button>';
        }
        
        $content .= '
                        </div>
                    </td>
                </tr>';
    }
} else {
    $content .= '
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <p>Henüz kullanıcı bulunmamaktadır.</p>
                    </td>
                </tr>';
}

$content .= '
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" action="' . BASE_URL . '/admin/users/delete" style="display:none;">
    <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
    <input type="hidden" name="id" id="deleteId">
</form>

<style>
.stats-card {
    background: white;
    border-radius: 0.5rem;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stats-icon.bg-primary { background: #0ea5e9; }
.stats-icon.bg-success { background: #22c55e; }
.stats-icon.bg-warning { background: #f59e0b; }
.stats-icon.bg-secondary { background: #6b7280; }

.stats-info h3 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #09090b;
}

.stats-info p {
    margin: 0;
    color: #71717a;
    font-size: 0.875rem;
}

.admin-table thead th {
    background: #fafafa;
    border-bottom: 2px solid #e4e4e7;
    font-weight: 600;
    color: #09090b;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.admin-table tbody tr:hover {
    background: #fafafa;
}

.admin-table .badge {
    font-weight: 500;
    padding: 0.375rem 0.75rem;
}
</style>

<script>
function deleteUser(id, username) {
    if (confirm(\'"\' + username + \'" kullanıcısını silmek istediğinizden emin misiniz?\\n\\nBu işlem geri alınamaz!\')) {
        document.getElementById(\'deleteId\').value = id;
        document.getElementById(\'deleteForm\').submit();
    }
}
</script>';

include BASE_PATH . '/app/views/admin/layout.php';
?>
