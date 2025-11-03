<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-zinc-900">Efsane Düzenle</h1>
        <p class="text-sm text-zinc-500 mt-1">Efsane oyuncu bilgilerini güncelleyin</p>
    </div>
    <a href="<?php echo URLROOT; ?>/admin/achievements/legends" class="shadcn-button-outline">
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
            <form action="<?php echo URLROOT; ?>/admin/achievements/editLegend/<?php echo $legend->id; ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="space-y-6">
                    <div>
                        <label for="name" class="shadcn-label">İsim *</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="shadcn-input" 
                            required
                            value="<?php echo htmlspecialchars($legend->name); ?>"
                            placeholder="Örn: Ahmet Yılmaz"
                        >
                        <p class="text-sm text-zinc-500 mt-1">Efsane oyuncunun adı ve soyadı</p>
                    </div>

                    <div>
                        <label for="position" class="shadcn-label">Pozisyon *</label>
                        <input 
                            type="text" 
                            id="position" 
                            name="position" 
                            class="shadcn-input" 
                            required
                            value="<?php echo htmlspecialchars($legend->position); ?>"
                            placeholder="Örn: Kaleci, Forvet, Orta Saha"
                        >
                        <p class="text-sm text-zinc-500 mt-1">Oyuncunun oynadığı pozisyon</p>
                    </div>

                    <div>
                        <label for="years" class="shadcn-label">Yıllar *</label>
                        <input 
                            type="text" 
                            id="years" 
                            name="years" 
                            class="shadcn-input" 
                            required
                            value="<?php echo htmlspecialchars($legend->years); ?>"
                            placeholder="Örn: 1995-2005"
                        >
                        <p class="text-sm text-zinc-500 mt-1">Kulüpte forma giydiği yıllar</p>
                    </div>

                    <div>
                        <label for="stats" class="shadcn-label">İstatistikler *</label>
                        <input 
                            type="text" 
                            id="stats" 
                            name="stats" 
                            class="shadcn-input" 
                            required
                            value="<?php echo htmlspecialchars($legend->stats); ?>"
                            placeholder="Örn: 350 Maç, 120 Gol"
                        >
                        <p class="text-sm text-zinc-500 mt-1">Önemli istatistikler (maç, gol, asist vb.)</p>
                    </div>

                    <div>
                        <label for="bio" class="shadcn-label">Biyografi</label>
                        <textarea 
                            id="bio" 
                            name="bio" 
                            rows="6" 
                            class="shadcn-input"
                            placeholder="Oyuncunun kariyer hikayesi, başarıları ve kulübe katkıları..."
                        ><?php echo htmlspecialchars($legend->bio); ?></textarea>
                        <p class="text-sm text-zinc-500 mt-1">Oyuncunun detaylı biyografisi ve kulüpteki hikayesi</p>
                    </div>

                    <div>
                        <label for="image" class="shadcn-label">Fotoğraf</label>
                        
                        <?php if (!empty($legend->image)): ?>
                            <div class="mb-3">
                                <p class="text-sm font-medium text-zinc-700 mb-2">Mevcut Fotoğraf:</p>
                                <img src="<?php echo URLROOT; ?>/<?php echo htmlspecialchars($legend->image); ?>" 
                                     alt="<?php echo htmlspecialchars($legend->name); ?>" 
                                     class="max-w-xs rounded-lg border border-zinc-200">
                            </div>
                        <?php endif; ?>
                        
                        <input 
                            type="file" 
                            id="image" 
                            name="image" 
                            class="shadcn-input" 
                            accept="image/*"
                            onchange="previewImage(event)"
                        >
                        <p class="text-sm text-zinc-500 mt-1">Yeni fotoğraf yüklemek için seçin (JPG, PNG, max 5MB)</p>
                        
                        <div id="imagePreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-zinc-700 mb-2">Yeni Fotoğraf Önizleme:</p>
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
                                value="<?php echo htmlspecialchars($legend->sort_order); ?>"
                                min="0"
                            >
                            <p class="text-sm text-zinc-500 mt-1">Gösterim sırası (0 = en üstte)</p>
                        </div>

                        <div>
                            <label for="status" class="shadcn-label">Durum</label>
                            <select id="status" name="status" class="shadcn-input">
                                <option value="active" <?php echo ($legend->status == 'active') ? 'selected' : ''; ?>>Aktif</option>
                                <option value="inactive" <?php echo ($legend->status == 'inactive') ? 'selected' : ''; ?>>Pasif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-zinc-200">
                    <a href="<?php echo URLROOT; ?>/admin/achievements/legends" class="shadcn-button-outline">
                        İptal
                    </a>
                    <button type="submit" class="shadcn-button-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Değişiklikleri Kaydet
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
                    <h4 class="font-medium text-zinc-900 mb-1">İsim</h4>
                    <p>Efsane oyuncunun tam adını girin. Bu isim başarılar sayfasında görüntülenecektir.</p>
                </div>
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">Pozisyon</h4>
                    <p>Oyuncunun oynadığı ana pozisyonu belirtin. Örnek: Kaleci, Stoper, Kanat, Forvet.</p>
                </div>
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">Yıllar</h4>
                    <p>Oyuncunun kulüpte aktif olduğu yıl aralığını girin. Format: YYYY-YYYY</p>
                </div>
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">İstatistikler</h4>
                    <p>Oyuncunun öne çıkan istatistiklerini girin. Örnek: "250 Maç, 85 Gol, 40 Asist"</p>
                </div>
                <div>
                    <h4 class="font-medium text-zinc-900 mb-1">Fotoğraf Güncelleme</h4>
                    <p>Yeni fotoğraf seçmezseniz mevcut fotoğraf korunur. Yeni fotoğraf yüklemek için dosya seçin.</p>
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
