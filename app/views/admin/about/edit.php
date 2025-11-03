<?php
$content = '
<div class="shadcn-page-container">
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Bölüm Düzenle</h1>
                <p class="shadcn-page-description">Hakkımızda bölümünü düzenleyin</p>
            </div>
            <a href="' . BASE_URL . '/admin/about" class="shadcn-btn shadcn-btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </div>
    ';
    
    if (isset($error)) {
        $content .= '
        <div class="shadcn-alert shadcn-alert-error mb-6">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <div>' . $error . '</div>
        </div>';
    }

    $content .= '
    <form method="POST" action="' . BASE_URL . '/admin/about/edit/' . ($section['id'] ?? '') . '" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Temel Bilgiler</h3>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="shadcn-form-group">
                                <label for="section_name" class="shadcn-label">Bölüm Adı <span class="text-red-500">*</span></label>
                                <input type="text" id="section_name" name="section_name" class="shadcn-input" 
                                       value="' . htmlspecialchars($_POST['section_name'] ?? $section['section_name'] ?? '') . '" required>
                            </div>
                            <div class="shadcn-form-group">
                                <label for="title" class="shadcn-label">Başlık <span class="text-red-500">*</span></label>
                                <input type="text" id="title" name="title" class="shadcn-input" 
                                       value="' . htmlspecialchars($_POST['title'] ?? $section['title'] ?? '') . '" required>
                            </div>
                            <div class="shadcn-form-group">
                                <label for="sort_order" class="shadcn-label">Sıra</label>
                                <input type="number" id="sort_order" name="sort_order" class="shadcn-input" 
                                       value="' . htmlspecialchars($_POST['sort_order'] ?? $section['sort_order'] ?? '0') . '">
                            </div>
                            <div class="shadcn-form-group">
                                <label for="status" class="shadcn-label">Durum</label>
                                <select id="status" name="status" class="shadcn-select">
                                    <option value="active"' . ((($_POST['status'] ?? $section['status'] ?? 'active') === 'active') ? ' selected' : '') . '>Aktif</option>
                                    <option value="inactive"' . ((($_POST['status'] ?? $section['status'] ?? '') === 'inactive') ? ' selected' : '') . '>Pasif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">İçerik</h3>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="shadcn-form-group">
                            <label for="content" class="shadcn-label">İçerik <span class="text-red-500">*</span></label>
                            <textarea id="content" name="content" class="shadcn-input" rows="15" style="resize: vertical;" required>' . htmlspecialchars($_POST['content'] ?? $section['content'] ?? '') . '</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="' . BASE_URL . '/admin/about" class="shadcn-btn shadcn-btn-outline">İptal</a>
                    <button type="submit" class="shadcn-btn shadcn-btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Değişiklikleri Kaydet
                    </button>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="shadcn-card mb-6">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Görsel</h3>
                    </div>
                    <div class="shadcn-card-content">';
                    
                    if (!empty($section['image'])) {
                        $content .= '
                        <div style="margin-bottom: 1rem;">
                            <img src="' . BASE_URL . htmlspecialchars($section['image']) . '" alt="Mevcut görsel" style="width: 100%; border-radius: 0.5rem; border: 1px solid #e4e4e7;">
                            <p class="text-xs text-zinc-500" style="margin-top: 0.5rem;">Mevcut görsel</p>
                        </div>';
                    }
                    
                    $content .= '
                        <div class="shadcn-form-group">
                            <label for="image" class="shadcn-label">' . (!empty($section['image']) ? 'Yeni Görsel Seçin' : 'Görsel Seçin') . '</label>
                            <input type="file" id="image" name="image" class="shadcn-input" accept="image/*" onchange="previewImage(event)">
                            <p class="shadcn-form-hint mt-2">JPG, PNG, GIF veya WebP (Max 5MB)</p>
                        </div>
                        <div id="image-preview" style="margin-top: 1rem; display: none;">
                            <p class="text-xs font-medium text-zinc-700 mb-2">Yeni görsel önizlemesi:</p>
                            <img id="preview-img" src="" alt="Preview" style="width: 100%; border-radius: 0.5rem; border: 1px solid #e4e4e7;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("preview-img").src = e.target.result;
            document.getElementById("image-preview").style.display = "block";
        }
        reader.readAsDataURL(file);
    }
}
</script>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>
