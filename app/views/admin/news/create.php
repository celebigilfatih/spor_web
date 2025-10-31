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
                      rows="12"
                      placeholder="Haber içeriğini giriniz..."
                      required>' . htmlspecialchars($_POST['content'] ?? '') . '</textarea>
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
                           value="' . htmlspecialchars($_POST['priority'] ?? '0') . '">
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
