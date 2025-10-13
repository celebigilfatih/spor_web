<?php
$content = '
<div class="modern-page-header">
    <div class="page-header-content">
        <div class="header-title-section">
            <div class="header-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div class="header-text">
                <h1>Haber Düzenle</h1>
                <p class="header-subtitle">' . htmlspecialchars($news['title']) . ' haberini düzenleyin</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="' . BASE_URL . '/admin/news" class="btn btn-modern-secondary">
                <i class="fas fa-arrow-left"></i> Geri Dön
            </a>';

if ($news['status'] === 'published') {
    $content .= '
            <a href="' . BASE_URL . '/news/detail/' . ($news['slug'] ?? $news['id']) . '" 
               class="btn btn-modern-info" 
               target="_blank">
                <i class="fas fa-external-link-alt"></i> Haberi Görüntüle
            </a>';
}

$content .= '
        </div>
    </div>
</div>

<div class="modern-form-container">
    <form method="POST" action="' . BASE_URL . '/admin/news/edit/' . $news['id'] . '" class="modern-admin-form" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <!-- Unified Form Card -->
        <div class="modern-form-card unified-form-card">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <h3 class="card-title">Haber Bilgileri</h3>
            </div>
            
            <div class="unified-form-content">
                <!-- Temel Bilgiler Bölümü -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-edit"></i> Temel Bilgiler
                        </h4>
                    </div>
                    
                    <div class="form-fields-grid">
                        <div class="modern-input-group full-width">
                            <label for="title" class="modern-label">
                                <span class="label-text">Başlık</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-heading"></i>
                                </div>
                                <input type="text" 
                                       id="title" 
                                       name="title" 
                                       class="modern-input" 
                                       placeholder="Haber başlığını giriniz"
                                       value="' . htmlspecialchars($_POST['title'] ?? $news['title']) . '"
                                       required>
                            </div>
                        </div>

                        <div class="modern-input-group full-width">
                            <label for="excerpt" class="modern-label">
                                <span class="label-text">Özet</span>
                            </label>
                            <div class="textarea-wrapper">
                                <div class="textarea-icon">
                                    <i class="fas fa-align-left"></i>
                                </div>
                                <textarea id="excerpt" 
                                          name="excerpt" 
                                          class="modern-textarea" 
                                          rows="3"
                                          placeholder="Haber özetini giriniz">' . htmlspecialchars($_POST['excerpt'] ?? $news['excerpt']) . '</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- İçerik Bölümü -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-file-alt"></i> İçerik
                        </h4>
                    </div>
                    
                    <div class="form-fields-grid">
                        <div class="modern-input-group full-width">
                            <label for="content" class="modern-label">
                                <span class="label-text">Haber İçeriği</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="editor-toolbar">
                                <button type="button" onclick="formatText(\'bold\')" class="editor-btn" title="Kalın">
                                    <i class="fas fa-bold"></i>
                                </button>
                                <button type="button" onclick="formatText(\'italic\')" class="editor-btn" title="İtalik">
                                    <i class="fas fa-italic"></i>
                                </button>
                                <button type="button" onclick="insertText(\'\\n\\n\')" class="editor-btn" title="Paragraf">
                                    <i class="fas fa-paragraph"></i>
                                </button>
                                <button type="button" onclick="insertText(\'\\n- \')" class="editor-btn" title="Liste">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                            <div class="textarea-wrapper">
                                <textarea id="content" 
                                          name="content" 
                                          class="modern-textarea content-editor" 
                                          rows="15"
                                          placeholder="Haber içeriğini giriniz..."
                                          required>' . htmlspecialchars($_POST['content'] ?? $news['content']) . '</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Ayarlar Bölümü -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-cogs"></i> Ayarlar ve Görsel
                        </h4>
                    </div>
                    
                    <div class="form-fields-grid">
                        <div class="modern-input-group">
                            <label for="category" class="modern-label">
                                <span class="label-text">Kategori</span>
                            </label>
                            <div class="select-wrapper">
                                <div class="select-icon">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <select id="category" name="category" class="modern-select">
                                    <option value="haber"' . (($_POST['category'] ?? $news['category']) === 'haber' ? ' selected' : '') . '>Haber</option>
                                    <option value="duyuru"' . (($_POST['category'] ?? $news['category']) === 'duyuru' ? ' selected' : '') . '>Duyuru</option>
                                    <option value="mac_sonucu"' . (($_POST['category'] ?? $news['category']) === 'mac_sonucu' ? ' selected' : '') . '>Maç Sonucu</option>
                                    <option value="transfer"' . (($_POST['category'] ?? $news['category']) === 'transfer' ? ' selected' : '') . '>Transfer</option>
                                </select>
                                <div class="select-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <div class="modern-input-group">
                            <label for="status" class="modern-label">
                                <span class="label-text">Durum</span>
                            </label>
                            <div class="select-wrapper">
                                <div class="select-icon">
                                    <i class="fas fa-toggle-on"></i>
                                </div>
                                <select id="status" name="status" class="modern-select">
                                    <option value="draft"' . (($_POST['status'] ?? $news['status']) === 'draft' ? ' selected' : '') . '>Taslak</option>
                                    <option value="published"' . (($_POST['status'] ?? $news['status']) === 'published' ? ' selected' : '') . '>Yayınla</option>
                                    <option value="archived"' . (($_POST['status'] ?? $news['status']) === 'archived' ? ' selected' : '') . '>Arşiv</option>
                                </select>
                                <div class="select-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <div class="modern-input-group file-upload-group">
                            <label for="featured_image" class="modern-label">
                                <span class="label-text">' . (!empty($news['featured_image']) ? 'Yeni Kapak Resmi' : 'Kapak Resmi') . '</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" 
                                       id="featured_image" 
                                       name="featured_image" 
                                       class="file-input"
                                       accept="image/jpeg,image/png,image/webp,image/gif"
                                       data-max-size="5242880">
                                <label for="featured_image" class="file-upload-label">
                                    <div class="file-upload-content">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span class="upload-text">' . (!empty($news['featured_image']) ? 'Yeni Resim Yükle' : 'Kapak Resmi Yükle') . '</span>
                                        <small class="upload-hint">JPG, PNG, WebP, GIF (Max: 5MB)</small>
                                        <div class="upload-progress" style="display: none;">
                                            <div class="progress-bar"></div>
                                        </div>
                                    </div>
                                </label>
                                <div class="file-preview" style="display: none;"></div>
                            </div>';

if (!empty($news['featured_image'])) {
    $content .= '
                            <div class="current-photo-preview">
                                <small class="field-hint">Mevcut kapak resmi:</small>
                                <img src="' . BASE_URL . '/uploads/' . $news['featured_image'] . '" 
                                     alt="Mevcut kapak resmi" 
                                     class="current-photo-thumb">
                            </div>';
}

$content .= '
                        </div>

                        <div class="modern-checkbox-group">
                            <div class="checkbox-wrapper">
                                <input type="checkbox" 
                                       id="is_featured" 
                                       name="is_featured" 
                                       value="1"
                                       class="modern-checkbox"
                                       ' . ((isset($_POST['is_featured']) || $news['is_featured']) ? 'checked' : '') . '>
                                <label for="is_featured" class="checkbox-label">
                                    <div class="checkbox-indicator">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="checkbox-content">
                                        <span class="checkbox-title">
                                            <i class="fas fa-star"></i> Öne Çıkan Haber
                                        </span>
                                        <small class="checkbox-subtitle">Bu haber ana sayfada öne çıkarılsın mı?</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modern-form-actions">
                    <button type="submit" class="btn btn-modern-primary">
                        <i class="fas fa-save"></i>
                        <span>Değişiklikleri Kaydet</span>
                    </button>
                    <a href="' . BASE_URL . '/admin/news" class="btn btn-modern-outline">
                        <i class="fas fa-times"></i>
                        <span>İptal</span>
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modern-info-panel">
    <div class="info-header">
        <div class="info-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <h4>Haber İstatistikleri</h4>
    </div>
    <div class="info-content">
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-eye"></i>
            </div>
            <div class="info-item-text">
                <strong>Görüntülenme:</strong> ' . number_format($news['views'] ?? 0) . '
            </div>
        </div>
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <div class="info-item-text">
                <strong>Oluşturulma:</strong> ' . date('d.m.Y H:i', strtotime($news['created_at'])) . '
            </div>
        </div>
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div class="info-item-text">
                <strong>Son Güncelleme:</strong> ' . date('d.m.Y H:i', strtotime($news['updated_at'])) . '
            </div>
        </div>';

if (!empty($news['published_at'])) {
    $content .= '
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-globe"></i>
            </div>
            <div class="info-item-text">
                <strong>Yayın Tarihi:</strong> ' . date('d.m.Y H:i', strtotime($news['published_at'])) . '
            </div>
        </div>';
}

$content .= '
        <div class="info-item">
            <div class="info-item-icon">
                <i class="fas fa-link"></i>
            </div>
            <div class="info-item-text">
                <strong>URL:</strong> <code>' . htmlspecialchars($news['slug'] ?? '') . '</code>
            </div>
        </div>
    </div>
</div>

<script>
function formatText(format) {
    const textarea = document.getElementById("content");
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    let formattedText = selectedText;
    
    if (format === "bold") {
        formattedText = "**" + selectedText + "**";
    } else if (format === "italic") {
        formattedText = "*" + selectedText + "*";
    }
    
    textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
    textarea.focus();
    textarea.setSelectionRange(start + formattedText.length, start + formattedText.length);
}

function insertText(text) {
    const textarea = document.getElementById("content");
    const start = textarea.selectionStart;
    textarea.value = textarea.value.substring(0, start) + text + textarea.value.substring(start);
    textarea.focus();
    textarea.setSelectionRange(start + text.length, start + text.length);
}
</script>';

include BASE_PATH . '/app/views/admin/layout.php';
?>