<?php
$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-newspaper"></i> Yeni Haber Ekle</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/news" class="btn btn-admin-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>
</div>

<div class="admin-content-card">
    <form method="POST" action="' . BASE_URL . '/admin/news/create"  enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <!-- Temel Bilgiler -->
         <div class="row"> 
            <div class="col-md-6">
                <div class="admin-form-group">
                    <label for="title" class="admin-form-label required">
                        <i class="fas fa-file-alt"></i> Başlık <span class="required">*</span>
                    </label>
                    <input type="text" 
                        id="title" 
                        name="title" 
                        class="admin-form-control" 
                        placeholder="Haber başlığını giriniz"
                        value="' . htmlspecialchars($_POST['title'] ?? '') . '"
                        required>

                </div>
            </div>
            <div class="col-md-3">
                <div class="admin-form-group">
                    <label for="category" class="admin-form-label">
                        <i class="fas fa-folder"></i> Kategori
                    </label>
                    <select id="category" name="category" class="admin-form-control">
                        <option value="haber"' . (($_POST['category'] ?? 'haber') === 'haber' ? ' selected' : '') . '>Haber</option>
                        <option value="duyuru"' . (($_POST['category'] ?? '') === 'duyuru' ? ' selected' : '') . '>Duyuru</option>
                        <option value="mac_sonucu"' . (($_POST['category'] ?? '') === 'mac_sonucu' ? ' selected' : '') . '>Maç Sonucu</option>
                        <option value="transfer"' . (($_POST['category'] ?? '') === 'transfer' ? ' selected' : '') . '>Transfer</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="admin-form-group">
                    <label for="status" class="admin-form-label">
                        <i class="fas fa-toggle-on"></i> Durum
                    </label>
                    <select id="status" name="status" class="admin-form-control">
                        <option value="draft"' . (($_POST['status'] ?? 'draft') === 'draft' ? ' selected' : '') . '>Taslak</option>
                        <option value="published"' . (($_POST['status'] ?? '') === 'published' ? ' selected' : '') . '>Yayınla</option>
                    </select>
                </div>
            </div>
         </div>



        <div class="admin-form-group">
            <label for="excerpt" class="admin-form-label">
                <i class="fas fa-align-left"></i> Özet
            </label>
            <textarea id="excerpt" 
                      name="excerpt" 
                      class="admin-form-control" 
                      rows="3"
                      placeholder="Haber özetini giriniz (haber listesinde görünecek)">' . htmlspecialchars($_POST['excerpt'] ?? '') . '</textarea>

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
                      placeholder="Haber içeriğini giriniz...">' . htmlspecialchars($_POST['content'] ?? '') . '</textarea>
            <small class="admin-form-help">
                <i class="fas fa-info-circle"></i> Metin biçimlendirme, bağlantı ekleme ve resim yükleme için editör araçlarını kullanın
            </small>
        </div>
        
        <!-- Ayarlar -->
        <div class="row">
            <div class="col-md-6">
                <div class="admin-form-group">
                    <label for="featured_image" class="admin-form-label">
                        <i class="fas fa-image"></i> Kapak Resmi
                    </label>
                    <input type="file" 
                        id="featured_image" 
                        name="featured_image" 
                        class="admin-form-control"
                        accept="image/jpeg,image/png,image/webp,image/gif">
                    <small class="admin-form-help">
                        <i class="fas fa-info-circle"></i> JPG, PNG, WebP, GIF formatlarında maksimum 5MB. Önerilen boyut: 1200x630 piksel
                    </small>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="admin-form-group">
                    <label for="gallery_images" class="admin-form-label">
                        <i class="fas fa-images"></i> Resim Galerisi
                    </label>
                    <input type="file" 
                        id="gallery_images" 
                        name="gallery_images[]" 
                        class="admin-form-control"
                        accept="image/jpeg,image/png,image/webp,image/gif"
                        multiple>
                    <small class="admin-form-help">
                        <i class="fas fa-info-circle"></i> Birden fazla resim seçebilirsiniz. Haberin detay sayfasında galeri olarak gösterilecek.
                    </small>
                    <div id="gallery-preview" class="mt-2" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(100px,1fr));gap:0.5rem;"></div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
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
                           value="' . htmlspecialchars($_POST['priority'] ?? '0') . '">
                    <small class="admin-form-help">
                        <i class="fas fa-info-circle"></i> Daha yüksek değer daha öncelikli
                    </small>
                </div>
            </div>
            
            <div class="col-md-4">
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
                               ' . (isset($_POST['is_featured']) ? 'checked' : '') . '>
                        <label for="is_featured" class="admin-checkbox-label">
                            Öne Çıkan Haber
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kapak Resmi -->


        <!-- Form Actions -->
        <div class="admin-form-actions">
            <button type="submit" class="btn btn-admin-primary">
                <i class="fas fa-save"></i> Haberi Kaydet
            </button>
            <a href="' . BASE_URL . '/admin/news" class="btn btn-admin-secondary">
                <i class="fas fa-times"></i> İptal
            </a>
        </div>
    </form>
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

// Gallery preview
document.getElementById('gallery_images').addEventListener('change', function(e) {
    const preview = document.getElementById('gallery-preview');
    preview.innerHTML = '';
    
    const files = Array.from(e.target.files);
    files.forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const div = document.createElement('div');
                div.style.cssText = 'position:relative;border-radius:6px;overflow:hidden;aspect-ratio:1;';
                div.innerHTML = `
                    <img src="${event.target.result}" style="width:100%;height:100%;object-fit:cover;">
                    <div style="position:absolute;top:4px;right:4px;background:rgba(0,0,0,0.6);color:white;padding:2px 6px;border-radius:4px;font-size:11px;">${index + 1}</div>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
