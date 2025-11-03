<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-zinc-900">Yeni Başarı Ekle</h1>
        <p class="text-sm text-zinc-500 mt-1">Kulüp başarıları listesine yeni başarı ekleyin</p>
    </div>
    <a href="<?php echo URLROOT; ?>/admin/achievements/achievements" class="shadcn-button-outline">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Geri Dön
    </a>
</div>

<?php if (isset($error)): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-start">
        <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
        </svg>
        <div>
            <p class="font-medium">Hata!</p>
            <p class="text-sm mt-1"><?php echo $error; ?></p>
        </div>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="shadcn-card">
            <form action="<?php echo URLROOT; ?>/admin/achievements/createAchievement" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="space-y-6">
                    <div>
                        <label for="title" class="shadcn-label">Başarı Başlığı *</label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            class="shadcn-input" 
                            required
                            value="<?php echo isset($data['title']) ? htmlspecialchars($data['title']) : ''; ?>"
                            placeholder="Örn: Şampiyonluk Şampiyonası Birinci"
                        >
                        <p class="text-sm text-zinc-500 mt-1">Başarının kısa ve açıklayıcı başlığını girin</p>
                    </div>

                    <div>
                        <label for="category" class="shadcn-label">Kategori *</label>
                        <select id="category" name="category" class="shadcn-input" required>
                            <option value="">Kategori Seçin</option>
                            <option value="Şampiyonluk" <?php echo (isset($data['category']) && $data['category'] == 'Şampiyonluk') ? 'selected' : ''; ?>>Şampiyonluk</option>
                            <option value="Kupa" <?php echo (isset($data['category']) && $data['category'] == 'Kupa') ? 'selected' : ''; ?>>Kupa</option>
                            <option value="Turnuva" <?php echo (isset($data['category']) && $data['category'] == 'Turnuva') ? 'selected' : ''; ?>>Turnuva</option>
                            <option value="Ödül" <?php echo (isset($data['category']) && $data['category'] == 'Ödül') ? 'selected' : ''; ?>>Ödül</option>
                            <option value="Diğer" <?php echo (isset($data['category']) && $data['category'] == 'Diğer') ? 'selected' : ''; ?>>Diğer</option>
                        </select>
                    </div>

                    <div>
                        <label for="year" class="shadcn-label">Yıl *</label>
                        <input 
                            type="number" 
                            id="year" 
                            name="year" 
                            class="shadcn-input" 
                            required
                            min="1900"
                            max="2100"
                            value="<?php echo isset($data['year']) ? htmlspecialchars($data['year']) : date('Y'); ?>"
                            placeholder="<?php echo date('Y'); ?>"
                        >
                        <p class="text-sm text-zinc-500 mt-1">Başarının elde edildiği yıl</p>
                    </div>

                    <div>
                        <label for="description" class="shadcn-label">Açıklama</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4" 
                            class="shadcn-input"
                            placeholder="Başarı hakkında detaylı bilgi..."
                        ><?php echo isset($data['description']) ? htmlspecialchars($data['description']) : ''; ?></textarea>
                        <p class="text-sm text-zinc-500 mt-1">Başarı hakkında detaylı açıklama (opsiyonel)</p>
                    </div>

                    <div>
                        <label for="image" class="shadcn-label">Görsel</label>
                        <input 
                            type="file" 
                            id="image" 
                            name="image" 
                            class="shadcn-input" 
                            accept="image/*"
                            onchange="previewImage(event)"
                        >
                        <p class="text-sm text-zinc-500 mt-1">Başarı görseli (JPG, PNG, max 5MB)</p>
                        
                        <div id="imagePreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-zinc-700 mb-2">Görsel Önizleme:</p>
                            <img id="preview" src="" alt="Preview" class="max-w-xs rounded-lg border border-zinc-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="sort_order" class="shadcn-label">Sıralama</label>
                            <input 
                                type="number" 
                                id="sort_order" 
                                name="sort_order" 
                                class="shadcn-input" 
                                value="<?php echo isset($data['sort_order']) ? htmlspecialchars($data['sort_order']) : '0'; ?>"
                                min="0"
                            >
                            <p class="text-sm text-zinc-500 mt-1">Gösterim sırası (0 = en üstte)</p>
                        </div>

                        <div>
                            <label for="status" class="shadcn-label">Durum</label>
                            <select id="status" name="status" class="shadcn-input">
                                <option value="active" <?php echo (!isset($data['status']) || $data['status'] == 'active') ? 'selected' : ''; ?>>Aktif</option>
                                <option value="inactive" <?php echo (isset($data['status']) && $data['status'] == 'inactive') ? 'selected' : ''; ?>>Pasif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-zinc-200">
                    <a href="<?php echo URLROOT; ?>/admin/achievements/achievements" class="shadcn-button-outline">
                        İptal
                    </a>
                    <button type="submit" class="shadcn-button-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Başarıyı Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="shadcn-card">
            <h3 class="text-lg font-medium text-zinc-900 mb-4">Yardım</h3>
            <div class="space-y-4 text-sm text-zinc-600">
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">Başarı Başlığı</h4>
                    <p>Başarının kısa ve öz tanımını girin. Örnek: "Bölgesel Şampiyonluk", "Turnuva Birinciliği"</p>
                </div>
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">Kategori</h4>
                    <p>Başarının türünü seçin. Bu, başarıların gruplandırılmasında kullanılır.</p>
                </div>
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">Görsel</h4>
                    <p>Başarı ile ilgili fotoğraf veya görsel ekleyebilirsiniz. Maksimum dosya boyutu 5MB'dır.</p>
                </div>
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">Sıralama</h4>
                    <p>Küçük sayılar üstte görünür. Aynı kategorideki başarıları sıralamak için kullanın.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        previewDiv.classList.add('hidden');
    }
}
</script>
