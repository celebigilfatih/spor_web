<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Başarılar Yönetimi</h1>
                <p class="shadcn-page-description">Kulübün başarılarını yönetin</p>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    ';
    
    if (isset($_SESSION['success'])) {
        $content .= '
        <div class="shadcn-alert shadcn-alert-success mb-6">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <div>' . $_SESSION['success'] . '</div>
        </div>';
        unset($_SESSION['success']);
    }
    
    if (isset($_SESSION['error'])) {
        $content .= '
        <div class="shadcn-alert shadcn-alert-error mb-6">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <div>' . $_SESSION['error'] . '</div>
        </div>';
        unset($_SESSION['error']);
    }

    $content .= '
    <!-- Management Sections -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Trophies -->
        <div class="shadcn-card">
            <div class="shadcn-card-content">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-zinc-900">' . (isset($trophies) && is_array($trophies) ? count($trophies) : 0) . '</h3>
                        <p class="text-sm text-zinc-500">Kupa</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="' . BASE_URL . '/admin/achievements/trophies" class="shadcn-btn shadcn-btn-primary w-full">
                        Yönet
                    </a>
                </div>
            </div>
        </div>

        <!-- Achievements -->
        <div class="shadcn-card">
            <div class="shadcn-card-content">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-zinc-900">' . (isset($achievements) && is_array($achievements) ? count($achievements) : 0) . '</h3>
                        <p class="text-sm text-zinc-500">Başarı</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="' . BASE_URL . '/admin/achievements/achievements" class="shadcn-btn shadcn-btn-primary w-full">
                        Yönet
                    </a>
                </div>
            </div>
        </div>

        <!-- Legends -->
        <div class="shadcn-card">
            <div class="shadcn-card-content">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-zinc-900">' . (isset($legends) && is_array($legends) ? count($legends) : 0) . '</h3>
                        <p class="text-sm text-zinc-500">Efsane</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="' . BASE_URL . '/admin/achievements/legends" class="shadcn-btn shadcn-btn-primary w-full">
                        Yönet
                    </a>
                </div>
            </div>
        </div>

        <!-- Records -->
        <div class="shadcn-card">
            <div class="shadcn-card-content">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-zinc-900">' . (isset($records) && is_array($records) ? count($records) : 0) . '</h3>
                        <p class="text-sm text-zinc-500">Rekor</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="' . BASE_URL . '/admin/achievements/records" class="shadcn-btn shadcn-btn-primary w-full">
                        Yönet
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Items -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Trophies -->
        <div class="shadcn-card">
            <div class="shadcn-card-header">
                <h3 class="shadcn-card-title">Son Eklenen Kupalar</h3>
            </div>
            <div class="shadcn-card-content p-0">
                <div class="overflow-x-auto">
                    <table class="shadcn-table">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Başlık</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>';
    
    if (isset($trophies) && is_array($trophies) && count($trophies) > 0) {
        // Show only first 5 trophies
        $recentTrophies = array_slice($trophies, 0, 5);
        foreach ($recentTrophies as $trophy) {
            $statusClass = $trophy['status'] === 'active' ? 'shadcn-badge-success' : 'shadcn-badge-secondary';
            $statusText = $trophy['status'] === 'active' ? 'Aktif' : 'Pasif';
            
            $content .= '
                            <tr>
                                <td>' . htmlspecialchars($trophy['category']) . '</td>
                                <td>' . htmlspecialchars($trophy['title']) . '</td>
                                <td>
                                    <span class="shadcn-badge ' . $statusClass . '">' . $statusText . '</span>
                                </td>
                            </tr>';
        }
    } else {
        $content .= '
                            <tr>
                                <td colspan="3" class="text-center py-4 text-zinc-500">
                                    Henüz kupa eklenmemiş
                                </td>
                            </tr>';
    }

    $content .= '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Achievements -->
        <div class="shadcn-card">
            <div class="shadcn-card-header">
                <h3 class="shadcn-card-title">Son Eklenen Başarılar</h3>
            </div>
            <div class="shadcn-card-content p-0">
                <div class="overflow-x-auto">
                    <table class="shadcn-table">
                        <thead>
                            <tr>
                                <th>Başlık</th>
                                <th>Kategori</th>
                                <th>Yıl</th>
                            </tr>
                        </thead>
                        <tbody>';
    
    if (isset($achievements) && is_array($achievements) && count($achievements) > 0) {
        // Show only first 5 achievements
        $recentAchievements = array_slice($achievements, 0, 5);
        foreach ($recentAchievements as $achievement) {
            $content .= '
                            <tr>
                                <td>' . htmlspecialchars($achievement['title']) . '</td>
                                <td>' . htmlspecialchars($achievement['category']) . '</td>
                                <td>' . ($achievement['year'] ? $achievement['year'] : '-') . '</td>
                            </tr>';
        }
    } else {
        $content .= '
                            <tr>
                                <td colspan="3" class="text-center py-4 text-zinc-500">
                                    Henüz başarı eklenmemiş
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
</div>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>