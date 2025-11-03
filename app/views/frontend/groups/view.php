<?php
$content = '
<!-- Page Header -->
<section class="corporate-header" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb" style="background: transparent; margin-bottom: 0; padding: 0;">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" style="color: rgba(255,255,255,0.8); text-decoration: none;">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/gruplar" style="color: rgba(255,255,255,0.8); text-decoration: none;">Gruplarımız</a></li>
                        <li class="breadcrumb-item" style="color: #fff;">' . htmlspecialchars($group['age_group']) . '</li>
                    </ol>
                </nav>
                <h1 class="display-5 fw-bold text-white mb-2">' . htmlspecialchars($group['name']) . '</h1>
                <p class="text-white-50 mb-0" style="font-size: 1.1rem;">' . htmlspecialchars($group['age_group']) . ' • ' . $group['current_count'] . '/' . $group['max_capacity'] . ' Sporcu</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="' . BASE_URL . '/gruplar" class="btn btn-light btn-lg" style="border-radius: 8px; padding: 0.75rem 2rem;">
                    <i class="fas fa-arrow-left me-2"></i>Tüm Gruplar
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Group Details -->
<section class="group-details" style="padding: 3rem 0; background: #f8f9fa;">
    <div class="container">
        <!-- Full Width Photo -->
        <div class="group-hero-photo" style="width: 100%; height: 500px; overflow: hidden; position: relative; border-radius: 12px; margin-bottom: 2rem; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
            ' . (!empty($group['photo']) ? 
                '<img src="' . BASE_URL . htmlspecialchars($group['photo']) . '" alt="' . htmlspecialchars($group['name']) . '" style="width: 100%; height: 100%; object-fit: cover;">' :
                '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);">
                    <i class="fas fa-users" style="font-size: 5rem; color: rgba(148, 163, 184, 0.5);"></i>
                </div>') . '
            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); padding: 2.5rem 2rem;">
                <h2 class="text-white fw-bold mb-2" style="font-size: 2.5rem;">' . htmlspecialchars($group['name']) . '</h2>
                <p class="text-white-50 mb-0" style="font-size: 1.1rem;">' . htmlspecialchars($group['age_group']) . ' • ' . $group['current_count'] . '/' . $group['max_capacity'] . ' Sporcu</p>
            </div>
        </div>

        <!-- Info Cards Row -->
        <div class="row mb-4">
            <!-- Coach Info Card -->
            ' . (!empty($group['coach_name']) ? '
            <div class="col-lg-6 mb-4">
                <div class="corporate-card" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); height: 100%;">
                    <h5 style="font-size: 1.1rem; font-weight: 600; color: #1e293b; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid #e2e8f0;">
                        <i class="fas fa-user-tie me-2" style="color: #3b82f6;"></i>Antrenör Kadrosu
                    </h5>
                    <div class="coach-list">
                        <div class="coach-item" style="padding: 1rem; background: #f8fafc; border-radius: 8px; margin-bottom: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-user-tie" style="color: white; font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.25rem;">Baş Antrenör</div>
                                    <div style="font-weight: 600; color: #1e293b; font-size: 1rem;">' . htmlspecialchars($group['coach_name']) . '</div>
                                </div>
                            </div>
                        </div>
                        ' . (!empty($group['assistant_coach']) ? '
                        <div class="coach-item" style="padding: 1rem; background: #f8fafc; border-radius: 8px;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #0891b2, #06b6d4); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-user-friends" style="color: white; font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.25rem;">Yardımcı Antrenör</div>
                                    <div style="font-weight: 600; color: #1e293b; font-size: 1rem;">' . htmlspecialchars($group['assistant_coach']) . '</div>
                                </div>
                            </div>
                        </div>' : '') . '
                    </div>
                </div>
            </div>' : '') . '

            <!-- Training Schedule Card -->
            ' . (!empty($group['training_days']) ? '
            <div class="col-lg-6 mb-4">
                <div class="corporate-card" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); height: 100%;">
                    <h5 style="font-size: 1.1rem; font-weight: 600; color: #1e293b; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid #e2e8f0;">
                        <i class="fas fa-calendar-week me-2" style="color: #f59e0b;"></i>Antrenman Programı
                    </h5>
                    <div class="training-info" style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 1.5rem; border-radius: 8px;">
                        <div style="display: flex; align-items: start; gap: 1rem;">
                            <i class="fas fa-clock" style="color: #d97706; margin-top: 0.25rem; font-size: 1.5rem;"></i>
                            <div style="color: #92400e; line-height: 1.8; font-size: 1rem;">' . nl2br(htmlspecialchars($group['training_days'])) . '</div>
                        </div>
                    </div>
                </div>
            </div>' : '') . '
        </div>

                <!-- Players List Card -->
                <div class="corporate-card" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
                    <div style="padding: 1.5rem 2rem; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                        <h5 style="color: white; font-size: 1.25rem; font-weight: 600; margin: 0;"><i class="fas fa-users me-2"></i>Grup Oyuncuları (' . count($players ?? []) . ')</h5>
                    </div>
                    <div class="p-0">
                        ';

if (!empty($players)) {
    $content .= '
                        <div class="table-responsive">
                            <table class="table mb-0" style="border: none;">
                                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                    <tr>
                                        <th style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 600; color: #64748b; border: none;">Fotoğraf</th>
                                        <th style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 600; color: #64748b; border: none;">Ad Soyad</th>
                                        <th style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 600; color: #64748b; border: none;">Pozisyon</th>
                                        <th style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 600; color: #64748b; border: none;">Forma No</th>
                                        <th style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 600; color: #64748b; border: none;">Doğum Tarihi</th>
                                        <th style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 600; color: #64748b; border: none;">Yaş</th>
                                    </tr>
                                </thead>
                                <tbody>';
    
    foreach ($players as $player) {
        $age = '';
        if (!empty($player['birth_date'])) {
            $birthDate = new DateTime($player['birth_date']);
            $now = new DateTime();
            $age = $now->diff($birthDate)->y;
        }
        
        $content .= '
                                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s ease;" onmouseover="this.style.background=\'#f8fafc\'" onmouseout="this.style.background=\'transparent\'">
                                        <td style="padding: 1.25rem 1.5rem; border: none;">
                                            <div class="player-avatar">';
        
        if (!empty($player['photo'])) {
            $content .= '<img src="' . BASE_URL . '/uploads/' . htmlspecialchars($player['photo']) . '" alt="' . htmlspecialchars($player['name']) . '" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0;">';
        } else {
            $content .= '<div style="width: 48px; height: 48px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                                    <i class="fas fa-user" style="font-size: 1.25rem;"></i>
                                                </div>';
        }
        
        $content .= '
                                            </div>
                                        </td>
                                        <td style="padding: 1.25rem 1.5rem; border: none;">
                                            <strong style="color: #1e293b; font-size: 0.95rem;">' . htmlspecialchars($player['name']) . '</strong>
                                        </td>
                                        <td style="padding: 1.25rem 1.5rem; border: none;">
                                            <span style="background: #f1f5f9; color: #475569; padding: 0.375rem 0.75rem; border-radius: 6px; font-size: 0.875rem; font-weight: 500;">' . htmlspecialchars($player['position'] ?? '-') . '</span>
                                        </td>
                                        <td style="padding: 1.25rem 1.5rem; border: none;">
                                            ' . (!empty($player['jersey_number']) ? 
                                                '<span style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; padding: 0.375rem 0.75rem; border-radius: 6px; font-size: 0.875rem; font-weight: 600;">#' . $player['jersey_number'] . '</span>' : 
                                                '<span style="color: #94a3b8;">-</span>') . '
                                        </td>
                                        <td style="padding: 1.25rem 1.5rem; color: #64748b; font-size: 0.9rem; border: none;">' . htmlspecialchars($player['birth_date'] ?? '-') . '</td>
                                        <td style="padding: 1.25rem 1.5rem; color: #64748b; font-size: 0.9rem; border: none;">' . ($age ? $age . ' yaş' : '-') . '</td>
                                    </tr>';
    }
    
    $content .= '
                                </tbody>
                            </table>
                        </div>';
} else {
    $content .= '
                        <div style="padding: 4rem 2rem; text-center;">
                            <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                                <i class="fas fa-users" style="font-size: 2rem; color: #cbd5e1;"></i>
                            </div>
                            <p style="color: #94a3b8; font-size: 1.1rem; margin: 0;">Bu grupta henüz kayıtlı oyuncu bulunmamaktadır.</p>
                        </div>';
}

$content .= '
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.group-hero-photo {
    position: relative;
    transition: transform 0.3s ease;
}

.group-hero-photo:hover {
    transform: scale(1.01);
}

.corporate-card {
    transition: all 0.3s ease;
}

.corporate-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
}

.table tbody tr:last-child {
    border-bottom: none !important;
}

@media (max-width: 768px) {
    .group-hero-photo {
        height: 300px !important;
        border-radius: 8px !important;
    }
    
    .group-hero-photo h2 {
        font-size: 1.75rem !important;
    }
    
    .table {
        font-size: 0.875rem;
    }
    
    .table th,
    .table td {
        padding: 0.875rem 1rem !important;
    }
}
</style>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>
