<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-edit"></i> Haber Düzenle</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/news" class="btn btn-admin-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>';

if ($news['status'] === 'published') {
    $content .= '
        <a href="' . BASE_URL . '/news/detail/' . ($news['slug'] ?? $news['id']) . '" 
           class="btn btn-admin-outline" 
           target="_blank">
            <i class="fas fa-external-link-alt"></i> Haberi Görüntüle
        </a>';
}

$content .= '
    </div>
</div>

<div class="admin-content-card">
    <form method="POST" action="' . BASE_URL . '/admin/news/edit/' . $news['id'] . '" class="admin-form" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <!-- Temel Bilgiler -->
        <div class="admin-form-group">
            <label for="title" class="admin-form-label required">
                <i class="fas fa-heading"></i> Başlık <span class="required">*</span>
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   class="admin-form-control" 
                   placeholder="Haber başlığını giriniz"
                   value="' . htmlspecialchars($_POST['title'] ?? $news['title']) . '"
                   required>
            <small class="admin-form-help">
                <i class="fas fa-info-circle"></i> SEO için açıklayıcı ve çekici bir başlık yazın
            </small>
        </div>

        <div class="admin-form-group">
            <label for="excerpt" class="admin-form-label">
                <i class="fas fa-align-left"></i> Özet
            </label>
            <textarea id="excerpt" 
                      name="excerpt" 
                      class="admin-form-control" 
                      rows="3"
                      placeholder="Haber özetini giriniz (haber listesinde görünecek)">' . htmlspecialchars($_POST['excerpt'] ?? $news['excerpt']) . '</textarea>
            <small class="admin-form-help">
                <i class="fas fa-info-circle"></i> Haber listelerinde gösterilecek kısa açıklama
            </small>
        </div>

        <!-- Haber İçeriği -->
        <div class="admin-form-group">
            <label for="content" class="admin-form-label required">
                <i class="fas fa-file-alt"></i> Haber İçeriği <span class="required">*</span>
            </label>
            <textarea id="content" 
                      name="content" 
                      class="admin-form-control" 
                      rows="20"
                      placeholder="Haber içeriğini giriniz..."
                      required>' . htmlspecialchars($_POST['content'] ?? $news['content']) . '</textarea>
            <small class="admin-form-help">
                <i class="fas fa-info-circle"></i> Metin biçimlendirme, bağlantı ekleme ve resim yükleme için editör araçlarını kullanın
            </small>
        </div>
        
        <!-- Ayarlar -->
        <div class="row">
            <div class="col-md-3">
                <div class="admin-form-group">
                    <label for="category" class="admin-form-label">
                        <i class="fas fa-folder"></i> Kategori
                    </label>
                    <select id="category" name="category" class="admin-form-control">
                        <option value="haber"' . (($_POST['category'] ?? $news['category']) === 'haber' ? ' selected' : '') . '>Haber</option>
                        <option value="duyuru"' . (($_POST['category'] ?? $news['category']) === 'duyuru' ? ' selected' : '') . '>Duyuru</option>
                        <option value="mac_sonucu"' . (($_POST['category'] ?? $news['category']) === 'mac_sonucu' ? ' selected' : '') . '>Maç Sonucu</option>
                        <option value="transfer"' . (($_POST['category'] ?? $news['category']) === 'transfer' ? ' selected' : '') . '>Transfer</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="admin-form-group">
                    <label for="status" class="admin-form-label">
                        <i class="fas fa-toggle-on"></i> Durum
                    </label>
                    <select id="status" name="status" class="admin-form-control">
                        <option value="draft"' . (($_POST['status'] ?? $news['status']) === 'draft' ? ' selected' : '') . '>Taslak</option>
                        <option value="published"' . (($_POST['status'] ?? $news['status']) === 'published' ? ' selected' : '') . '>Yayınla</option>
                        <option value="archived"' . (($_POST['status'] ?? $news['status']) === 'archived' ? ' selected' : '') . '>Arşiv</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="admin-form-group">
                    <label for="priority" class="admin-form-label">
                        <i class="fas fa-sort-numeric-up"></i> Öncelik
                    </label>
                    <input type="number" 
                           id="priority" 
                           name="priority" 
                           class="admin-form-control" 
                           min="0" 
                           max="999" 
                           value="' . htmlspecialchars($_POST['priority'] ?? $news['priority'] ?? '0') . '">
                    <small class="admin-form-help">
                        <i class="fas fa-info-circle"></i> Daha yüksek değer daha öncelikli
                    </small>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="admin-form-group">
                    <label class="admin-form-label">
                        <i class="fas fa-star"></i> Özellikler
                    </label>
                    <div class="admin-checkbox-wrapper">
                        <input type="checkbox" 
                               id="is_featured" 
                               name="is_featured" 
                               value="1"
                               class="admin-checkbox"
                               ' . ((isset($_POST['is_featured']) || $news['is_featured']) ? 'checked' : '') . '>
                        <label for="is_featured" class="admin-checkbox-label">
                            Öne Çıkan Haber
                        </label>
                    </div>
                    <small class="admin-form-help">
                        <i class="fas fa-info-circle"></i> Ana sayfada özel olarak vurgulanır
                    </small>
                </div>
            </div>
        </div>

        <!-- Kapak Resmi -->
        <div class="admin-form-group">
            <label for="featured_image" class="admin-form-label">
                <i class="fas fa-image"></i> ' . (!empty($news['featured_image']) ? 'Yeni Kapak Resmi' : 'Kapak Resmi') . '
            </label>
            <input type="file" 
                   id="featured_image" 
                   name="featured_image" 
                   class="admin-form-control"
                   accept="image/jpeg,image/png,image/webp,image/gif">';

if (!empty($news['featured_image'])) {
    $content .= '
            <div class="mt-2">
                <small class="admin-form-help">Mevcut kapak resmi:</small>
                <div class="mt-1">
                    <img src="' . BASE_URL . '/uploads/' . $news['featured_image'] . '" 
                         alt="Mevcut kapak resmi" 
                         class="img-thumbnail" 
                         style="max-width: 200px; max-height: 150px;">
                </div>
            </div>';
}

$content .= '
            <small class="admin-form-help">
                <i class="fas fa-info-circle"></i> JPG, PNG, WebP, GIF formatlarında maksimum 5MB. Önerilen boyut: 1200x630 piksel
            </small>
        </div>

        <!-- Form Actions -->
        <div class="admin-form-actions">
            <button type="submit" class="btn btn-admin-primary">
                <i class="fas fa-save"></i> Değişiklikleri Kaydet
            </button>
            <a href="' . BASE_URL . '/admin/news" class="btn btn-admin-secondary">
                <i class="fas fa-times"></i> İptal
            </a>
        </div>
    </form>
</div>

<!-- Haber İstatistikleri -->
<div class="admin-content-card mt-4">
    <h5><i class="fas fa-chart-line"></i> Haber İstatistikleri</h5>
    <div class="row">
        <div class="col-md-3">
            <div class="admin-stat-card">
                <div class="admin-stat-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="admin-stat-content">
                    <div class="admin-stat-value">' . number_format($news['views'] ?? 0) . '</div>
                    <div class="admin-stat-label">Görüntülenme</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stat-card">
                <div class="admin-stat-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <div class="admin-stat-content">
                    <div class="admin-stat-value">' . date('d.m.Y', strtotime($news['created_at'])) . '</div>
                    <div class="admin-stat-label">Oluşturulma</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stat-card">
                <div class="admin-stat-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="admin-stat-content">
                    <div class="admin-stat-value">' . date('d.m.Y', strtotime($news['updated_at'])) . '</div>
                    <div class="admin-stat-label">Son Güncelleme</div>
                </div>
            </div>
        </div>';

if (!empty($news['published_at'])) {
    $content .= '
        <div class="col-md-3">
            <div class="admin-stat-card">
                <div class="admin-stat-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="admin-stat-content">
                    <div class="admin-stat-value">' . date('d.m.Y', strtotime($news['published_at'])) . '</div>
                    <div class="admin-stat-label">Yayın Tarihi</div>
                </div>
            </div>
        </div>';
}

$content .= '
    </div>
    <div class="mt-3">
        <small class="text-muted">
            <i class="fas fa-link"></i> Haber URL: <code>' . htmlspecialchars($news['slug'] ?? '') . '</code>
        </small>
    </div>
</div>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>

<!-- TinyMCE Rich Text Editor -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js"></script>
<script>
(function() {
    // Wait for TinyMCE to load
    setTimeout(function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#content',
                height: 500,
                menubar: 'file edit view insert format tools table help',
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor removeformat | code help',
                content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6; }',
                branding: false,
                promotion: false,
                images_upload_url: '<?php echo BASE_URL; ?>/admin/news/upload-image',
                automatic_uploads: true,
                images_upload_handler: function (blobInfo, success, failure) {
                    var xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '<?php echo BASE_URL; ?>/admin/news/upload-image');
                    
                    xhr.onload = function() {
                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        
                        var json;
                        try {
                            json = JSON.parse(xhr.responseText);
                        } catch (e) {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        
                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        
                        success(json.location);
                    };
                    
                    xhr.onerror = function () {
                        failure('Image upload failed');
                    };
                    
                    var formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    formData.append('csrf_token', '<?php echo $csrf_token ?? ""; ?>');
                    xhr.send(formData);
                },
                setup: function(editor) {
                    // Add custom validation on form submit
                    editor.on('init', function() {
                        var form = document.querySelector('form');
                        if (form) {
                            form.addEventListener('submit', function(e) {
                                var content = tinymce.get('content').getContent();
                                if (!content || content.trim() === '') {
                                    e.preventDefault();
                                    alert('Haber içeriği zorunludur!');
                                    tinymce.get('content').focus();
                                    return false;
                                }
                            });
                        }
                    });
                }
            });
            console.log('✅ TinyMCE başarıyla yüklendi!');
        } else {
            console.error('❌ TinyMCE yüklenemedi');
        }
    }, 200);
})();
</script>