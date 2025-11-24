<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Alt Yapı Grupları</h1>
                <p class="shadcn-page-description">Kulübümüzün alt yapı gruplarını yönetin</p>
            </div>
            <a href="' . BASE_URL . '/admin/youth-groups/create" class="shadcn-btn shadcn-btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Grup Ekle
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    ' . (isset($statistics) ? '
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="shadcn-card">
            <div class="shadcn-card-content" style="padding: var(--spacing-4);">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-zinc-500 mb-1">Toplam Grup</p>
                        <p class="text-2xl font-bold">' . ($statistics['total_groups'] ?? 0) . '</p>
                    </div>
                    <div class="shadcn-info-icon" style="width: 48px; height: 48px;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="shadcn-card">
            <div class="shadcn-card-content" style="padding: var(--spacing-4);">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-zinc-500 mb-1">Toplam Oyuncu</p>
                        <p class="text-2xl font-bold">' . ($statistics['total_players'] ?? 0) . '</p>
                    </div>
                    <div class="shadcn-info-icon" style="width: 48px; height: 48px;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="shadcn-card">
            <div class="shadcn-card-content" style="padding: var(--spacing-4);">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-zinc-500 mb-1">Toplam Kapasite</p>
                        <p class="text-2xl font-bold">' . ($statistics['total_capacity'] ?? 0) . '</p>
                    </div>
                    <div class="shadcn-info-icon" style="width: 48px; height: 48px;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="shadcn-card">
            <div class="shadcn-card-content" style="padding: var(--spacing-4);">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-zinc-500 mb-1">Aktif Grup</p>
                        <p class="text-2xl font-bold">' . ($statistics['active_groups'] ?? 0) . '</p>
                    </div>
                    <div class="shadcn-info-icon" style="width: 48px; height: 48px;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ' : '') . '

    <!-- Groups Table -->
    <div class="shadcn-card">
        <div class="shadcn-card-header">
            <h3 class="shadcn-card-title">Tüm Gruplar</h3>
            <p class="shadcn-card-description">Alt yapı gruplarının listesi ve detayları</p>
        </div>
        <div class="shadcn-card-content" style="padding: 0;">
            <div class="shadcn-table-container">
                <table class="shadcn-table">
                    <thead>
                        <tr>
                            <th>Fotoğraf</th>
                            <th>Grup Adı</th>
                            <th>Yaş Grubu</th>
                            <th>Antrenör</th>
                            <th>Antrenman</th>
                            <th>Doluluk</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>';

if (isset($groups) && !empty($groups)) {
    foreach ($groups as $group) {
        $fillPercentage = $group['max_capacity'] > 0 ? round(($group['current_count'] / $group['max_capacity']) * 100) : 0;
        $fillColor = $fillPercentage >= 90 ? '#ef4444' : ($fillPercentage >= 70 ? '#f59e0b' : '#10b981');
        
        $content .= '
                        <tr style="cursor: pointer;" onclick="window.location.href=\'' . BASE_URL . '/admin/youth-groups/details/' . $group['id'] . '\';">
                            <td>
                                <div style="width: 60px; height: 60px; border-radius: 0.375rem; overflow: hidden; background: #f4f4f5; display: flex; align-items: center; justify-content: center;">';
                            
                            if (!empty($group['photo'])) {
                                $content .= '<img src="' . BASE_URL . htmlspecialchars($group['photo']) . '" alt="' . htmlspecialchars($group['name']) . '" style="width: 100%; height: 100%; object-fit: cover;">';
                            } else {
                                $content .= '<svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>';
                            }
                            
                            $content .= '
                                </div>
                            </td>
                            <td>
                                <div class="font-medium">' . htmlspecialchars($group['name']) . '</div>
                                <div class="text-xs text-zinc-500">' . htmlspecialchars($group['season'] ?? '2024-25') . '</div>
                            </td>
                            <td>
                                <span class="shadcn-badge" style="background-color: hsl(var(--accent)); color: hsl(var(--foreground));">
                                    ' . htmlspecialchars($group['age_group']) . '
                                </span>
                            </td>
                            <td>
                                <div class="text-sm font-medium">' . htmlspecialchars($group['coach_name'] ?? '-') . '</div>
                                ' . (!empty($group['assistant_coach']) ? '<div class="text-xs text-zinc-500">' . htmlspecialchars($group['assistant_coach']) . '</div>' : '') . '
                            </td>
                            <td class="text-sm">
                                <div>' . htmlspecialchars($group['training_days'] ?? '-') . '</div>
                                <div class="text-xs text-zinc-500">' . htmlspecialchars($group['training_time'] ?? '-') . '</div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1">
                                        <div class="w-full bg-zinc-200 rounded-full h-2">
                                            <div class="h-2 rounded-full transition-all" style="width: ' . $fillPercentage . '%; background-color: ' . $fillColor . ';"></div>
                                        </div>
                                    </div>
                                    <span class="text-xs font-medium">' . $group['current_count'] . '/' . $group['max_capacity'] . '</span>
                                </div>
                            </td>
                            <td>
                                ' . ($group['status'] === 'active' ? 
                                    '<span class="shadcn-badge" style="background-color: #dcfce7; color: #166534;">Aktif</span>' : 
                                    '<span class="shadcn-badge" style="background-color: #fee2e2; color: #991b1b;">Pasif</span>') . '
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="' . BASE_URL . '/admin/youth-groups/edit/' . $group['id'] . '" 
                                       class="shadcn-btn shadcn-btn-outline" 
                                       style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Düzenle
                                    </a>
                                    <form method="POST" action="' . BASE_URL . '/admin/youth-groups/delete/' . $group['id'] . '" style="display: inline;" onsubmit="return confirm(\'Bu grubu silmek istediğinizden emin misiniz?\');">
                                        <input type="hidden" name="csrf_token" value="' . ($csrf_token ?? '') . '">
                                        <button type="submit" class="shadcn-btn" style="padding: 0.375rem 0.75rem; font-size: 0.75rem; background-color: #fee2e2; color: #991b1b; border-color: #fecaca;">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Sil
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>';
    }
} else {
    $content .= '
                        <tr>
                            <td colspan="8" class="text-center" style="padding: var(--spacing-8);">
                                <div class="text-zinc-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <p class="font-medium">Henüz alt yapı grubu bulunmamaktadır</p>
                                    <p class="text-sm mt-2">Yeni grup eklemek için yukarıdaki butonu kullanın</p>
                                </div>
                            </td>
                        </tr>';
}

$content .= '
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.shadcn-table-container {
    overflow-x: auto;
}

.shadcn-table {
    width: 100%;
    border-collapse: collapse;
}

.shadcn-table thead {
    background-color: hsl(var(--muted));
    border-bottom: 1px solid hsl(var(--border));
}

.shadcn-table th {
    padding: 0.75rem 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: hsl(var(--foreground));
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.shadcn-table td {
    padding: 1rem;
    border-bottom: 1px solid hsl(var(--border));
    font-size: 0.875rem;
}

.shadcn-table tbody tr:hover {
    background-color: hsl(var(--accent) / 0.5);
}

.shadcn-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.625rem;
    border-radius: var(--radius-md);
    font-size: 0.75rem;
    font-weight: 500;
}

.text-2xl {
    font-size: 1.5rem;
    line-height: 2rem;
}

.w-6 {
    width: 1.5rem;
}

.h-6 {
    height: 1.5rem;
}

.w-12 {
    width: 3rem;
}

.h-12 {
    height: 3rem;
}

.mx-auto {
    margin-left: auto;
    margin-right: auto;
}

.mb-4 {
    margin-bottom: 1rem;
}

.mt-2 {
    margin-top: 0.5rem;
}
</style>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>
