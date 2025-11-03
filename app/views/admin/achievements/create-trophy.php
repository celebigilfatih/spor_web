<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Yeni Kupa Ekle</h1>
                <p class="shadcn-page-description">Kulübün yeni kupasını ekleyin</p>
            </div>
            <a href="' . BASE_URL . '/admin/achievements/trophies" class="shadcn-btn shadcn-btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </div>

    <!-- Error Message -->
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
    <form method="POST" action="' . BASE_URL . '/admin/achievements/create-trophy" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Temel Bilgiler -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Temel Bilgiler</h3>
                        <p class="shadcn-card-description">Kupa bilgilerini girin</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="shadcn-form-group md:col-span-2">
                                <label for="category" class="shadcn-label">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select id="category" name="category" class="shadcn-select" required>
                                    <option value="">Seçiniz</option>
                                    <option value="League"' . (($_POST['category'] ?? '') === 'League' ? ' selected' : '') . '>Lig</option>
                                    <option value="Cup"' . (($_POST['category'] ?? '') === 'Cup' ? ' selected' : '') . '>Kupa</option>
                                    <option value="International"' . (($_POST['category'] ?? '') === 'International' ? ' selected' : '') . '>Uluslararası</option>
                                    <option value="Other"' . (($_POST['category'] ?? '') === 'Other' ? ' selected' : '') . '>Diğer</option>
                                </select>
                            </div>

                            <div class="shadcn-form-group md:col-span-2">
                                <label for="title" class="shadcn-label">
                                    Başlık <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="title" 
                                       name="title" 
                                       class="shadcn-input" 
                                       placeholder="Kupa başlığı"
                                       value="' . htmlspecialchars($_POST['title'] ?? '') . '"
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="count" class="shadcn-label">
                                    Sayı
                                </label>
                                <input type="number" 
                                       id="count" 
                                       name="count" 
                                       class="shadcn-input" 
                                       min="0"
                                       value="' . htmlspecialchars($_POST['count'] ?? '0') . '">
                            </div>

                            <div class="shadcn-form-group">
                                <label for="year" class="shadcn-label">
                                    Yıl
                                </label>
                                <input type="number" 
                                       id="year" 
                                       name="year" 
                                       class="shadcn-input" 
                                       min="1900"
                                       max="2100"
                                       value="' . htmlspecialchars($_POST['year'] ?? '') . '">
                            </div>

                            <div class="shadcn-form-group">
                                <label for="sort_order" class="shadcn-label">
                                    Sıra
                                </label>
                                <input type="number" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       class="shadcn-input" 
                                       min="0"
                                       value="' . htmlspecialchars($_POST['sort_order'] ?? '0') . '">
                            </div>

                            <div class="shadcn-form-group">
                                <label for="status" class="shadcn-label">
                                    Durum
                                </label>
                                <select id="status" name="status" class="shadcn-select">
                                    <option value="active"' . (($_POST['status'] ?? 'active') === 'active' ? ' selected' : '') . '>Aktif</option>
                                    <option value="inactive"' . (($_POST['status'] ?? '') === 'inactive' ? ' selected' : '') . '>Pasif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Açıklama -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Açıklama</h3>
                        <p class="shadcn-card-description">Kupa açıklaması</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="shadcn-form-group">
                            <label for="description" class="shadcn-label">
                                Açıklama
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      class="shadcn-input" 
                                      rows="4" 
                                      style="resize: vertical;"
                                      placeholder="Kupa açıklaması...">' . htmlspecialchars($_POST['description'] ?? '') . '</textarea>
                        </div>
                        
                        <div class="shadcn-form-group">
                            <label for="years" class="shadcn-label">
                                Yıllar
                            </label>
                            <input type="text" 
                                   id="years" 
                                   name="years" 
                                   class="shadcn-input" 
                                   placeholder="Yıllar (virgülle ayırın)"
                                   value="' . htmlspecialchars($_POST['years'] ?? '') . '">
                            <p class="shadcn-form-hint">Yılları virgülle ayırın (örn: 1952, 1967, 1973)</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3">
                    <a href="' . BASE_URL . '/admin/achievements/trophies" class="shadcn-btn shadcn-btn-outline">
                        İptal
                    </a>
                    <button type="submit" class="shadcn-btn shadcn-btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Kupayı Kaydet
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Image Upload -->
                <div class="shadcn-card mb-6">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Görsel</h3>
                        <p class="shadcn-card-description">Kupa görseli ekleyin (opsiyonel)</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="shadcn-form-group">
                            <label for="image" class="shadcn-label">
                                Görsel Seçin
                            </label>
                            <input type="file" 
                                   id="image" 
                                   name="image" 
                                   class="shadcn-input" 
                                   accept="image/*"
                                   onchange="previewImage(event)">
                            <p class="shadcn-form-hint mt-2">
                                JPG, PNG, GIF veya WebP (Max 5MB)
                            </p>
                        </div>
                        <div id="image-preview" style="margin-top: 1rem; display: none;">
                            <img id="preview-img" src="" alt="Preview" style="width: 100%; border-radius: 0.5rem; border: 1px solid #e4e4e7;">
                        </div>
                    </div>
                </div>

                <!-- Help Info -->
                <div class="shadcn-card sticky top-6">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"></path>
                            </svg>
                            Yardımcı Bilgiler
                        </h3>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="space-y-4">
                            <div class="shadcn-info-item">
                                <p class="shadcn-info-title">Kategori</p>
                                <p class="shadcn-info-text">Kupanın kategorisini seçin (Lig, Kupa, Uluslararası)</p>
                            </div>
                            <div class="shadcn-info-item">
                                <p class="shadcn-info-title">Sayı</p>
                                <p class="shadcn-info-text">Kazanılan toplam kupa sayısı</p>
                            </div>
                            <div class="shadcn-info-item">
                                <p class="shadcn-info-title">Yıllar</p>
                                <p class="shadcn-info-text">Kazanılan yılları virgülle ayırarak girin</p>
                            </div>
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