<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Yeni Bölüm Ekle</h1>
                <p class="shadcn-page-description">Hakkımızda sayfasına yeni bölüm ekleyin</p>
            </div>
            <a href="' . BASE_URL . '/admin/about" class="shadcn-btn shadcn-btn-outline">
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
    <form method="POST" action="' . BASE_URL . '/admin/about/create" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Temel Bilgiler -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Temel Bilgiler</h3>
                        <p class="shadcn-card-description">Bölüm bilgilerini girin</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="shadcn-form-group">
                                <label for="section_name" class="shadcn-label">
                                    Bölüm Adı <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="section_name" 
                                       name="section_name" 
                                       class="shadcn-input" 
                                       placeholder="örn: main, history, vision"
                                       value="' . htmlspecialchars($_POST['section_name'] ?? '') . '"
                                       required>
                                <p class="shadcn-form-hint">URL için uygun isim (İngilizce, küçük harf)</p>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="title" class="shadcn-label">
                                    Başlık <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="title" 
                                       name="title" 
                                       class="shadcn-input" 
                                       placeholder="Bölüm başlığı"
                                       value="' . htmlspecialchars($_POST['title'] ?? '') . '"
                                       required>
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

                <!-- İçerik -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">İçerik</h3>
                        <p class="shadcn-card-description">Bölüm içeriğini yazın</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="shadcn-form-group">
                            <label for="content" class="shadcn-label">
                                İçerik <span class="text-red-500">*</span>
                            </label>
                            <textarea id="content" 
                                      name="content" 
                                      class="shadcn-input" 
                                      rows="15" 
                                      style="resize: vertical;"
                                      placeholder="Bölüm içeriğini buraya yazın..." 
                                      required>' . htmlspecialchars($_POST['content'] ?? '') . '</textarea>
                            <p class="shadcn-form-hint">HTML etiketleri kullanabilirsiniz</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3">
                    <a href="' . BASE_URL . '/admin/about" class="shadcn-btn shadcn-btn-outline">
                        İptal
                    </a>
                    <button type="submit" class="shadcn-btn shadcn-btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Bölümü Kaydet
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Image Upload -->
                <div class="shadcn-card mb-6">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Görsel</h3>
                        <p class="shadcn-card-description">Bölüm görseli ekleyin (opsiyonel)</p>
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
                                <p class="shadcn-info-title">Bölüm Adı</p>
                                <p class="shadcn-info-text">Benzersiz olmalı, URL için uygun (örn: main, history, vision)</p>
                            </div>
                            <div class="shadcn-info-item">
                                <p class="shadcn-info-title">Sıra</p>
                                <p class="shadcn-info-text">Düşük numara üstte görünür</p>
                            </div>
                            <div class="shadcn-info-item">
                                <p class="shadcn-info-title">HTML Kullanımı</p>
                                <p class="shadcn-info-text">İçerikte &lt;p&gt;, &lt;strong&gt;, &lt;ul&gt;, &lt;li&gt; etiketlerini kullanabilirsiniz</p>
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
