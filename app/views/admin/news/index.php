<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-newspaper"></i> Haber Yönetimi</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/news/create" class="btn btn-admin-primary">
            <i class="fas fa-plus"></i> Yeni Haber Ekle
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

if (empty($news)) {
    $content .= '
    <div class="admin-empty-state">
        <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
        <h3>Henüz haber bulunmuyor</h3>
        <p class="text-muted">Başlamak için ilk haberinizi ekleyin.</p>
        <a href="' . BASE_URL . '/admin/news/create" class="btn btn-admin-primary mt-3">
            <i class="fas fa-plus"></i> İlk Haberi Ekle
        </a>
    </div>';
} else {
    $content .= '
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><i class="fas fa-heading"></i> Başlık</th>
                    <th><i class="fas fa-folder"></i> Kategori</th>
                    <th><i class="fas fa-sort-numeric-up"></i> Öncelik</th>
                    <th><i class="fas fa-toggle-on"></i> Durum</th>
                    <th><i class="fas fa-star"></i> Öne Çıkan</th>
                    <th><i class="fas fa-eye"></i> Görüntülenme</th>
                    <th><i class="fas fa-user"></i> Yazar</th>
                    <th><i class="fas fa-calendar"></i> Tarih</th>
                    <th><i class="fas fa-cogs"></i> İşlemler</th>
                </tr>
            </thead>
            <tbody>';
            
    if (isset($news) && is_array($news)) {
        foreach ($news as $item) {
            $content .= '
                <tr>
                    <td>' . $item['id'] . '</td>
                    <td>
                        <div class="news-title">
                            <strong>' . htmlspecialchars($item['title']) . '</strong>';
        
            if (!empty($item['featured_image'])) {
                $content .= '
                            <span class="badge badge-info ml-2">
                                <i class="fas fa-image"></i> Resim
                            </span>';
            }
        
            $content .= '
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-' . ($item['category'] === 'haber' ? 'info' : ($item['category'] === 'duyuru' ? 'warning' : 'success')) . '">
                            ' . strtoupper($item['category']) . '
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-primary">
                            ' . ($item['priority'] ?? 0) . '
                        </span>
                    </td>
                    <td>
                        <span class="status-badge status-' . ($item['status'] === 'published' ? 'active' : ($item['status'] === 'draft' ? 'inactive' : 'danger')) . '">
                            <i class="fas fa-' . ($item['status'] === 'published' ? 'check-circle' : ($item['status'] === 'draft' ? 'edit' : 'archive')) . '"></i>
                            ' . ($item['status'] === 'published' ? 'YAYINDA' : ($item['status'] === 'draft' ? 'TASLAK' : 'ARŞİV')) . '
                        </span>
                    </td>
                    <td>
                        <div class="text-center">';
        
            if (!empty($item['is_featured'])) {
                $content .= '
                            <i class="fas fa-star text-warning" title="Öne çıkan"></i>';
            } else {
                $content .= '
                            <i class="far fa-star text-muted"></i>';
            }
        
            $content .= '
                        </div>
                    </td>
                    <td>' . number_format($item['views'] ?? 0) . '</td>
                    <td>' . htmlspecialchars($item['author_name'] ?? 'Admin') . '</td>
                    <td>
                        <small class="text-muted">
                            ' . date('d.m.Y H:i', strtotime($item['created_at'])) . '
                        </small>
                    </td>
                    <td>
                        <div class="admin-action-buttons">';
        
            if ($item['status'] === 'published') {
                $content .= '
                            <a href="' . BASE_URL . '/news/detail/' . ($item['slug'] ?? $item['id']) . '" 
                               class="btn btn-admin-secondary btn-sm" 
                               target="_blank" 
                               title="Görüntüle">
                                <i class="fas fa-eye"></i>
                            </a>';
            }
        
            $content .= '
                            <a href="' . BASE_URL . '/admin/news/edit/' . $item['id'] . '" 
                               class="btn btn-admin-primary btn-sm" 
                               title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteNews(' . $item['id'] . ')" 
                                    class="btn btn-admin-danger btn-sm" 
                                    title="Sil">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>';
        }
    }

    $content .= '
            </tbody>
        </table>
    </div>
    
    <div class="admin-table-footer">
        <div class="admin-table-info">
            <i class="fas fa-info-circle"></i>
            Toplam ' . (isset($news) && is_array($news) ? count($news) : 0) . ' haber listeleniyor.
        </div>
    </div>';
}

$content .= '
</div>

<script>
function deleteNews(id) {
    const newsRow = document.querySelector("button[onclick=\'deleteNews(" + id + ")\']").closest("tr");
    const newsTitle = newsRow ? (newsRow.querySelector("td:nth-child(2)") ? newsRow.querySelector("td:nth-child(2)").textContent.trim() : "Bu haber") : "Bu haber";
    
    showDeleteConfirmation({
        title: "Haber Silme Onayı",
        message: "Bu haberi kalıcı olarak silmek istediğinizden emin misiniz?",
        submessage: "Bu işlem geri alınamaz ve habere ait tüm bilgiler silinecektir.",
        itemName: newsTitle,
        confirmText: "Haberi Sil",
        cancelText: "İptal",
        onConfirm: function(closeModal) {
            const formData = new FormData();
            formData.append("csrf_token", "' . ($csrf_token ?? '') . '");
            
            fetch("' . BASE_URL . '/admin/news/delete/" + id, {
                method: "POST",
                body: formData
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                closeModal();
                if (data.success) {
                    showDeleteSuccess(data.message);
                    setTimeout(function() { location.reload(); }, 1500);
                } else {
                    showDeleteError(data.message);
                }
            })
            .catch(function(error) {
                closeModal();
                showDeleteError("Silme işlemi sırasında bir hata oluştu!");
            });
        }
    });
}
</script>';

include BASE_PATH . '/app/views/admin/layout.php';
?>