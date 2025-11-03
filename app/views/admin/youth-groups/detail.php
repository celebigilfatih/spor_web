<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="' . BASE_URL . '/admin/youth-groups" class="shadcn-btn shadcn-btn-outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Geri Dön
                </a>
                <div>
                    <h1 class="shadcn-page-title">' . htmlspecialchars($group['name']) . '</h1>
                    <p class="shadcn-page-description">' . htmlspecialchars($group['age_group']) . ' Grup Detayları</p>
                </div>
            </div>
            <a href="' . BASE_URL . '/admin/youth-groups/edit/' . $group['id'] . '" class="shadcn-btn shadcn-btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Düzenle
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Group Photo and Info -->
        <div class="lg:col-span-1">
            <div class="shadcn-card">
                <div class="shadcn-card-header">
                    <h3 class="shadcn-card-title">Grup Fotoğrafı</h3>
                </div>
                <div class="shadcn-card-content">';
                
                if (!empty($group['photo'])) {
                    $content .= '
                    <div style="width: 100%; aspect-ratio: 1; border-radius: 0.5rem; overflow: hidden; background: #f4f4f5; margin-bottom: 1.5rem;">
                        <img src="' . BASE_URL . htmlspecialchars($group['photo']) . '" alt="' . htmlspecialchars($group['name']) . '" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>';
                } else {
                    $content .= '
                    <div style="width: 100%; aspect-ratio: 1; border-radius: 0.5rem; overflow: hidden; background: #f4f4f5; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <svg class="w-20 h-20 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>';
                }
                
                $fillPercentage = $group['max_capacity'] > 0 ? round(($group['current_count'] / $group['max_capacity']) * 100) : 0;
                $fillColor = $fillPercentage >= 90 ? '#ef4444' : ($fillPercentage >= 70 ? '#f59e0b' : '#10b981');
                
                $content .= '
                    <div class="space-y-4">
                        <div>
                            <div class="text-sm text-zinc-500 mb-1">Yaş Grubu</div>
                            <div class="font-semibold text-lg">' . htmlspecialchars($group['age_group']) . '</div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-zinc-500 mb-1">Yaş Aralığı</div>
                            <div class="font-semibold">' . $group['min_age'] . ' - ' . $group['max_age'] . ' yaş</div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-zinc-500 mb-1">Sezon</div>
                            <div class="font-semibold">' . htmlspecialchars($group['season'] ?? '2024-25') . '</div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-zinc-500 mb-1">Doluluk Oranı</div>
                            <div class="flex items-center gap-2 mb-1">
                                <div class="flex-1">
                                    <div class="w-full bg-zinc-200 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all" style="width: ' . $fillPercentage . '%; background-color: ' . $fillColor . ';"></div>
                                    </div>
                                </div>
                                <span class="text-sm font-medium">' . $fillPercentage . '%</span>
                            </div>
                            <div class="text-sm font-medium">' . $group['current_count'] . ' / ' . $group['max_capacity'] . ' oyuncu</div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-zinc-500 mb-1">Durum</div>
                            <div>
                                ' . ($group['status'] === 'active' ? 
                                    '<span class="shadcn-badge" style="background-color: #dcfce7; color: #166534;">Aktif</span>' : 
                                    '<span class="shadcn-badge" style="background-color: #fee2e2; color: #991b1b;">Pasif</span>') . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Coach Info -->
            <div class="shadcn-card" style="margin-top: 1.5rem;">
                <div class="shadcn-card-header">
                    <h3 class="shadcn-card-title">Antrenör Bilgisi</h3>
                </div>
                <div class="shadcn-card-content">
                    <div class="space-y-3">
                        <div>
                            <div class="text-sm text-zinc-500 mb-1">Baş Antrenör</div>
                            <div class="font-semibold">' . htmlspecialchars($group['coach_name'] ?? '-') . '</div>
                        </div>
                        ' . (!empty($group['assistant_coach']) ? '
                        <div>
                            <div class="text-sm text-zinc-500 mb-1">Yardımcı Antrenör</div>
                            <div class="font-semibold">' . htmlspecialchars($group['assistant_coach']) . '</div>
                        </div>' : '') . '
                    </div>
                </div>
            </div>
            
            <!-- Training Schedule -->
            ' . (!empty($group['training_days']) ? '
            <div class="shadcn-card" style="margin-top: 1.5rem;">
                <div class="shadcn-card-header">
                    <h3 class="shadcn-card-title">Antrenman Programı</h3>
                </div>
                <div class="shadcn-card-content">
                    <div class="text-sm">' . nl2br(htmlspecialchars($group['training_days'])) . '</div>
                </div>
            </div>' : '') . '
        </div>
        
        <!-- Players List -->
        <div class="lg:col-span-2">
            <div class="shadcn-card">
                <div class="shadcn-card-header">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="shadcn-card-title">Grup Oyuncuları</h3>
                            <p class="shadcn-card-description">Bu gruptaki tüm oyuncular</p>
                        </div>
                        <a href="' . BASE_URL . '/admin/players/create-youth?group_id=' . $group['id'] . '" class="shadcn-btn shadcn-btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Oyuncu Ekle
                        </a>
                    </div>
                </div>
                <div class="shadcn-card-content" style="padding: 0;">';
                
                if (!empty($players)) {
                    $content .= '
                    <div class="shadcn-table-container">
                        <table class="shadcn-table">
                            <thead>
                                <tr>
                                    <th>Fotoğraf</th>
                                    <th>Ad Soyad</th>
                                    <th>Doğum Tarihi</th>
                                    <th>Pozisyon</th>
                                    <th>Forma No</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>';
                            
                            foreach ($players as $player) {
                                $age = '';
                                if (!empty($player['birth_date'])) {
                                    $birthDate = new DateTime($player['birth_date']);
                                    $now = new DateTime();
                                    $age = $now->diff($birthDate)->y . ' yaş';
                                }
                                
                                $content .= '
                                <tr>
                                    <td>
                                        <div style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; background: #f4f4f5; display: flex; align-items: center; justify-content: center;">';
                                        
                                        if (!empty($player['photo'])) {
                                            $content .= '<img src="' . BASE_URL . '/uploads/' . htmlspecialchars($player['photo']) . '" alt="' . htmlspecialchars($player['name']) . '" style="width: 100%; height: 100%; object-fit: cover;">';
                                        } else {
                                            $content .= '<svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>';
                                        }
                                        
                                        $content .= '
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-medium">' . htmlspecialchars($player['name']) . '</div>
                                    </td>
                                    <td>
                                        <div class="text-sm">' . htmlspecialchars($player['birth_date'] ?? '-') . '</div>
                                        ' . (!empty($age) ? '<div class="text-xs text-zinc-500">' . $age . '</div>' : '') . '
                                    </td>
                                    <td class="text-sm">' . htmlspecialchars($player['position'] ?? '-') . '</td>
                                    <td>
                                        ' . (!empty($player['jersey_number']) ? '<span class="shadcn-badge">' . $player['jersey_number'] . '</span>' : '<span class="text-zinc-400">-</span>') . '
                                    </td>
                                    <td>
                                        ' . ($player['status'] === 'active' ? 
                                            '<span class="shadcn-badge" style="background-color: #dcfce7; color: #166534;">Aktif</span>' : 
                                            '<span class="shadcn-badge" style="background-color: #fee2e2; color: #991b1b;">Pasif</span>') . '
                                    </td>
                                    <td>
                                        <a href="' . BASE_URL . '/admin/players/edit-youth/' . $player['id'] . '" class="shadcn-btn shadcn-btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Düzenle
                                        </a>
                                    </td>
                                </tr>';
                            }
                            
                            $content .= '
                            </tbody>
                        </table>
                    </div>';
                } else {
                    $content .= '
                    <div class="text-center" style="padding: var(--spacing-8);">
                        <svg class="w-16 h-16 mx-auto mb-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <p class="font-medium text-zinc-700 mb-2">Henüz bu grupta oyuncu bulunmamaktadır</p>
                        <p class="text-sm text-zinc-500 mb-4">Gruba oyuncu eklemek için yukarıdaki butonu kullanın</p>
                        <a href="' . BASE_URL . '/admin/players/create-youth?group_id=' . $group['id'] . '" class="shadcn-btn shadcn-btn-primary" style="display: inline-flex;">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            İlk Oyuncuyu Ekle
                        </a>
                    </div>';
                }
                
                $content .= '
                </div>
            </div>
            
            ' . (!empty($group['description']) ? '
            <div class="shadcn-card" style="margin-top: 1.5rem;">
                <div class="shadcn-card-header">
                    <h3 class="shadcn-card-title">Açıklama</h3>
                </div>
                <div class="shadcn-card-content">
                    <p class="text-sm text-zinc-700">' . nl2br(htmlspecialchars($group['description'])) . '</p>
                </div>
            </div>' : '') . '
        </div>
    </div>
</div>

<style>
tr[style*="cursor: pointer"]:hover {
    background-color: #f4f4f5;
}

.space-y-3 > * + * {
    margin-top: 0.75rem;
}

.space-y-4 > * + * {
    margin-top: 1rem;
}
</style>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>
