<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Kupa Yönetimi</h1>
                <p class="shadcn-page-description">Kulübün kupalarını yönetin</p>
            </div>
            <a href="' . BASE_URL . '/admin/achievements/create-trophy" class="shadcn-btn shadcn-btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Kupa Ekle
            </a>
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
    <!-- Trophies Table -->
    <div class="shadcn-card">
        <div class="shadcn-card-header">
            <h3 class="shadcn-card-title">Kupalar</h3>
            <p class="shadcn-card-description">Tüm kupalar</p>
        </div>
        <div class="shadcn-card-content p-0">
            <div class="overflow-x-auto">
                <table class="shadcn-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 15%;">Kategori</th>
                            <th style="width: 25%;">Başlık</th>
                            <th style="width: 10%;">Sayı</th>
                            <th style="width: 25%;">Yıllar</th>
                            <th style="width: 5%;">Sıra</th>
                            <th style="width: 10%;">Durum</th>
                            <th style="width: 15%;">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>';

    if (isset($trophies) && is_array($trophies) && count($trophies) > 0) {
        foreach ($trophies as $trophy) {
            $statusClass = $trophy['status'] === 'active' ? 'shadcn-badge-success' : 'shadcn-badge-secondary';
            $statusText = $trophy['status'] === 'active' ? 'Aktif' : 'Pasif';
            
            // Limit years display
            $yearsDisplay = strlen($trophy['years']) > 30 ? substr($trophy['years'], 0, 30) . '...' : $trophy['years'];
            
            $content .= '
                        <tr>
                            <td>' . $trophy['id'] . '</td>
                            <td><strong>' . htmlspecialchars($trophy['category']) . '</strong></td>
                            <td>' . htmlspecialchars($trophy['title']) . '</td>
                            <td class="text-center">' . $trophy['count'] . '</td>
                            <td class="text-sm text-zinc-600">' . htmlspecialchars($yearsDisplay) . '</td>
                            <td class="text-center">' . $trophy['sort_order'] . '</td>
                            <td>
                                <span class="shadcn-badge ' . $statusClass . '">' . $statusText . '</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="' . BASE_URL . '/admin/achievements/edit-trophy/' . $trophy['id'] . '" 
                                       class="shadcn-btn-icon shadcn-btn-icon-primary" 
                                       title="Düzenle">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button type="button" 
                                            onclick="deleteTrophy(' . $trophy['id'] . ', \'' . htmlspecialchars($trophy['title']) . '\')" 
                                            class="shadcn-btn-icon shadcn-btn-icon-danger" 
                                            title="Sil">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>';
        }
    } else {
        $content .= '
                        <tr>
                            <td colspan="8" class="text-center py-8 text-zinc-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-lg font-medium">Henüz kupa eklenmemiş</p>
                                <p class="text-sm mt-2">Yeni kupa eklemek için yukarıdaki butonu kullanın</p>
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

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="shadcn-modal" style="display: none;">
    <div class="shadcn-modal-overlay" onclick="closeDeleteModal()"></div>
    <div class="shadcn-modal-content">
        <div class="shadcn-modal-header">
            <h3 class="shadcn-modal-title">Kupayı Sil</h3>
            <button onclick="closeDeleteModal()" class="shadcn-modal-close">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="shadcn-modal-body">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-lg font-medium text-zinc-900 mb-2">Bu işlem geri alınamaz!</p>
                    <p class="text-zinc-600"><strong id="deleteTrophyName"></strong> kupasını silmek istediğinizden emin misiniz?</p>
                </div>
            </div>
        </div>
        <div class="shadcn-modal-footer">
            <button onclick="closeDeleteModal()" class="shadcn-btn shadcn-btn-outline">İptal</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                <button type="submit" class="shadcn-btn shadcn-btn-danger">Evet, Sil</button>
            </form>
        </div>
    </div>
</div>

<script>
function deleteTrophy(id, name) {
    document.getElementById("deleteTrophyName").textContent = name;
    document.getElementById("deleteForm").action = "' . BASE_URL . '/admin/achievements/delete-trophy/" + id;
    document.getElementById("deleteModal").style.display = "flex";
}

function closeDeleteModal() {
    document.getElementById("deleteModal").style.display = "none";
}
</script>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>