<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-zinc-900">Yeni Rekor Ekle</h1>
        <p class="text-sm text-zinc-500 mt-1">Kulüp rekorları listesine yeni rekor ekleyin</p>
    </div>
    <a href="<?php echo URLROOT; ?>/admin/achievements/records" class="shadcn-button-outline">
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
            <form action="<?php echo URLROOT; ?>/admin/achievements/createRecord" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="space-y-6">
                    <div>
                        <label for="title" class="shadcn-label">Rekor Başlığı *</label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            class="shadcn-input" 
                            required
                            value="<?php echo isset($data['title']) ? htmlspecialchars($data['title']) : ''; ?>"
                            placeholder="Örn: En Fazla Gol Atan Oyuncu"
                        >
                        <p class="text-sm text-zinc-500 mt-1">Rekorun kısa ve açıklayıcı başlığını girin</p>
                    </div>

                    <div>
                        <label for="holder" class="shadcn-label">Rekor Sahibi *</label>
                        <input 
                            type="text" 
                            id="holder" 
                            name="holder" 
                            class="shadcn-input" 
                            required
                            value="<?php echo isset($data['holder']) ? htmlspecialchars($data['holder']) : ''; ?>"
                            placeholder="Örn: Mehmet Özdemir"
                        >
                        <p class="text-sm text-zinc-500 mt-1">Rekoru elinde bulunduran kişi veya takım</p>
                    </div>

                    <div>
                        <label for="value" class="shadcn-label">Rekor Değeri *</label>
                        <input 
                            type="text" 
                            id="value" 
                            name="value" 
                            class="shadcn-input" 
                            required
                            value="<?php echo isset($data['value']) ? htmlspecialchars($data['value']) : ''; ?>"
                            placeholder="Örn: 156 Gol, 20 Yıl"
                        >
                        <p class="text-sm text-zinc-500 mt-1">Rekorun sayısal veya metinsel değeri</p>
                    </div>

                    <div>
                        <label for="category" class="shadcn-label">Kategori *</label>
                        <select id="category" name="category" class="shadcn-input" required>
                            <option value="">Kategori Seçin</option>
                            <option value="Gol" <?php echo (isset($data['category']) && $data['category'] == 'Gol') ? 'selected' : ''; ?>>Gol</option>
                            <option value="Maç" <?php echo (isset($data['category']) && $data['category'] == 'Maç') ? 'selected' : ''; ?>>Maç</option>
                            <option value="Asist" <?php echo (isset($data['category']) && $data['category'] == 'Asist') ? 'selected' : ''; ?>>Asist</option>
                            <option value="Takım" <?php echo (isset($data['category']) && $data['category'] == 'Takım') ? 'selected' : ''; ?>>Takım</option>
                            <option value="Bireysel" <?php echo (isset($data['category']) && $data['category'] == 'Bireysel') ? 'selected' : ''; ?>>Bireysel</option>
                            <option value="Diğer" <?php echo (isset($data['category']) && $data['category'] == 'Diğer') ? 'selected' : ''; ?>>Diğer</option>
                        </select>
                        <p class="text-sm text-zinc-500 mt-1">Rekorun kategorisi</p>
                    </div>

                    <div>
                        <label for="description" class="shadcn-label">Açıklama</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4" 
                            class="shadcn-input"
                            placeholder="Rekor hakkında detaylı bilgi, tarihi, önemi..."
                        ><?php echo isset($data['description']) ? htmlspecialchars($data['description']) : ''; ?></textarea>
                        <p class="text-sm text-zinc-500 mt-1">Rekor hakkında detaylı açıklama (opsiyonel)</p>
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
                        <p class="text-sm text-zinc-500 mt-1">Rekor ile ilgili görsel (JPG, PNG, max 5MB)</p>
                        
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
                    <a href="<?php echo URLROOT; ?>/admin/achievements/records" class="shadcn-button-outline">
                        İptal
                    </a>
                    <button type="submit" class="shadcn-button-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Rekoru Kaydet
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
                    <h4 class="font-medium text-zinc-900 mb-1">Rekor Başlığı</h4>
                    <p>Rekorun ne olduğunu açıklayan kısa başlık. Örnek: "En Fazla Gol", "En Uzun Süre Forvet"</p>
                </div>
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">Rekor Sahibi</h4>
                    <p>Rekoru elinde bulunduran oyuncu, takım veya kişinin adı.</p>
                </div>
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">Rekor Değeri</h4>
                    <p>Rekorun sayısal değeri. Örnek: "250 Gol", "15 Sezon", "25 Asist"</p>
                </div>
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">Kategori</h4>
                    <p>Rekorun türünü seçin. Bu, rekorların gruplandırılmasında kullanılır.</p>
                </div>
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">Açıklama</h4>
                    <p>Rekorun nasıl kırıldığı, tarihi ve önemi hakkında detaylı bilgi ekleyin.</p>
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
