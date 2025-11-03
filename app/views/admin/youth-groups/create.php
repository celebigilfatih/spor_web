<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Yeni Alt Yapı Grubu Ekle</h1>
                <p class="shadcn-page-description">Alt yapı grubu oluşturmak için gerekli bilgileri girin</p>
            </div>
            <a href="' . BASE_URL . '/admin/youth-groups" class="shadcn-btn shadcn-btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </div>

    <form method="POST" action="' . BASE_URL . '/admin/youth-groups/create" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Temel Bilgiler -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Temel Bilgiler</h3>
                        <p class="shadcn-card-description">Grup adı ve yaş bilgileri</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="shadcn-form-group md:col-span-2">
                                <label for="name" class="shadcn-label">
                                    Grup Adı <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       class="shadcn-input" 
                                       placeholder="örn: U15 Yetenek Grubu"
                                       value="' . htmlspecialchars($_POST['name'] ?? '') . '"
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="age_group" class="shadcn-label">
                                    Yaş Grubu <span class="text-red-500">*</span>
                                </label>
                                <select id="age_group" name="age_group" class="shadcn-select" required>
                                    <option value="">Seçiniz</option>
                                    <option value="U8"' . (($_POST['age_group'] ?? '') === 'U8' ? ' selected' : '') . '>U8 (8 yaş altı)</option>
                                    <option value="U9"' . (($_POST['age_group'] ?? '') === 'U9' ? ' selected' : '') . '>U9 (9 yaş altı)</option>
                                    <option value="U10"' . (($_POST['age_group'] ?? '') === 'U10' ? ' selected' : '') . '>U10 (10 yaş altı)</option>
                                    <option value="U11"' . (($_POST['age_group'] ?? '') === 'U11' ? ' selected' : '') . '>U11 (11 yaş altı)</option>
                                    <option value="U12"' . (($_POST['age_group'] ?? '') === 'U12' ? ' selected' : '') . '>U12 (12 yaş altı)</option>
                                    <option value="U13"' . (($_POST['age_group'] ?? '') === 'U13' ? ' selected' : '') . '>U13 (13 yaş altı)</option>
                                    <option value="U14"' . (($_POST['age_group'] ?? '') === 'U14' ? ' selected' : '') . '>U14 (14 yaş altı)</option>
                                    <option value="U15"' . (($_POST['age_group'] ?? '') === 'U15' ? ' selected' : '') . '>U15 (15 yaş altı)</option>
                                    <option value="U16"' . (($_POST['age_group'] ?? '') === 'U16' ? ' selected' : '') . '>U16 (16 yaş altı)</option>
                                    <option value="U17"' . (($_POST['age_group'] ?? '') === 'U17' ? ' selected' : '') . '>U17 (17 yaş altı)</option>
                                    <option value="U18"' . (($_POST['age_group'] ?? '') === 'U18' ? ' selected' : '') . '>U18 (18 yaş altı)</option>
                                    <option value="U19"' . (($_POST['age_group'] ?? '') === 'U19' ? ' selected' : '') . '>U19 (19 yaş altı)</option>
                                    <option value="U20"' . (($_POST['age_group'] ?? '') === 'U20' ? ' selected' : '') . '>U20 (20 yaş altı)</option>
                                    <option value="U21"' . (($_POST['age_group'] ?? '') === 'U21' ? ' selected' : '') . '>U21 (21 yaş altı)</option>
                                </select>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="season" class="shadcn-label">
                                    Sezon <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="season" 
                                       name="season" 
                                       class="shadcn-input" 
                                       placeholder="2024-25"
                                       value="' . htmlspecialchars($_POST['season'] ?? '2024-25') . '"
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="min_age" class="shadcn-label">
                                    Minimum Yaş <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       id="min_age" 
                                       name="min_age" 
                                       class="shadcn-input" 
                                       placeholder="13"
                                       min="5"
                                       max="21"
                                       value="' . htmlspecialchars($_POST['min_age'] ?? '') . '"
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="max_age" class="shadcn-label">
                                    Maksimum Yaş <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       id="max_age" 
                                       name="max_age" 
                                       class="shadcn-input" 
                                       placeholder="15"
                                       min="6"
                                       max="22"
                                       value="' . htmlspecialchars($_POST['max_age'] ?? '') . '"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Antrenör Bilgileri -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Antrenör Bilgileri</h3>
                        <p class="shadcn-card-description">Grup antrenörlerinin bilgileri</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="shadcn-form-group">
                                <label for="coach_name" class="shadcn-label">
                                    Baş Antrenör
                                </label>
                                <input type="text" 
                                       id="coach_name" 
                                       name="coach_name" 
                                       class="shadcn-input" 
                                       placeholder="Antrenör adı"
                                       value="' . htmlspecialchars($_POST['coach_name'] ?? '') . '">
                            </div>

                            <div class="shadcn-form-group">
                                <label for="assistant_coach" class="shadcn-label">
                                    Yardımcı Antrenör
                                </label>
                                <input type="text" 
                                       id="assistant_coach" 
                                       name="assistant_coach" 
                                       class="shadcn-input" 
                                       placeholder="Yardımcı antrenör adı"
                                       value="' . htmlspecialchars($_POST['assistant_coach'] ?? '') . '">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Antrenman Bilgileri -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Antrenman Programı</h3>
                        <p class="shadcn-card-description">Antrenman günleri ve saatleri</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="shadcn-form-group">
                                <label class="shadcn-label">
                                    Antrenman Günleri ve Saatleri
                                </label>
                                <div class="space-y-3" id="training-schedule">
                                    <!-- Pazartesi -->
                                    <div class="flex items-center gap-3 p-3 border border-zinc-200 rounded-lg">
                                        <input type="checkbox" 
                                               id="monday" 
                                               name="training_days[]" 
                                               value="Pazartesi"
                                               class="shadcn-checkbox"
                                               onchange="toggleTimeInputs(this, \'monday-time\')">
                                        <label for="monday" class="flex-1 font-medium cursor-pointer">Pazartesi</label>
                                        <input type="time" 
                                               id="monday-time" 
                                               name="training_times[Pazartesi]" 
                                               class="shadcn-input" 
                                               style="width: 120px; display: none;"
                                               placeholder="09:00">
                                    </div>
                                    
                                    <!-- Salı -->
                                    <div class="flex items-center gap-3 p-3 border border-zinc-200 rounded-lg">
                                        <input type="checkbox" 
                                               id="tuesday" 
                                               name="training_days[]" 
                                               value="Salı"
                                               class="shadcn-checkbox"
                                               onchange="toggleTimeInputs(this, \'tuesday-time\')">
                                        <label for="tuesday" class="flex-1 font-medium cursor-pointer">Salı</label>
                                        <input type="time" 
                                               id="tuesday-time" 
                                               name="training_times[Salı]" 
                                               class="shadcn-input" 
                                               style="width: 120px; display: none;"
                                               placeholder="09:00">
                                    </div>
                                    
                                    <!-- Çarşamba -->
                                    <div class="flex items-center gap-3 p-3 border border-zinc-200 rounded-lg">
                                        <input type="checkbox" 
                                               id="wednesday" 
                                               name="training_days[]" 
                                               value="Çarşamba"
                                               class="shadcn-checkbox"
                                               onchange="toggleTimeInputs(this, \'wednesday-time\')">
                                        <label for="wednesday" class="flex-1 font-medium cursor-pointer">Çarşamba</label>
                                        <input type="time" 
                                               id="wednesday-time" 
                                               name="training_times[Çarşamba]" 
                                               class="shadcn-input" 
                                               style="width: 120px; display: none;"
                                               placeholder="09:00">
                                    </div>
                                    
                                    <!-- Perşembe -->
                                    <div class="flex items-center gap-3 p-3 border border-zinc-200 rounded-lg">
                                        <input type="checkbox" 
                                               id="thursday" 
                                               name="training_days[]" 
                                               value="Perşembe"
                                               class="shadcn-checkbox"
                                               onchange="toggleTimeInputs(this, \'thursday-time\')">
                                        <label for="thursday" class="flex-1 font-medium cursor-pointer">Perşembe</label>
                                        <input type="time" 
                                               id="thursday-time" 
                                               name="training_times[Perşembe]" 
                                               class="shadcn-input" 
                                               style="width: 120px; display: none;"
                                               placeholder="09:00">
                                    </div>
                                    
                                    <!-- Cuma -->
                                    <div class="flex items-center gap-3 p-3 border border-zinc-200 rounded-lg">
                                        <input type="checkbox" 
                                               id="friday" 
                                               name="training_days[]" 
                                               value="Cuma"
                                               class="shadcn-checkbox"
                                               onchange="toggleTimeInputs(this, \'friday-time\')">
                                        <label for="friday" class="flex-1 font-medium cursor-pointer">Cuma</label>
                                        <input type="time" 
                                               id="friday-time" 
                                               name="training_times[Cuma]" 
                                               class="shadcn-input" 
                                               style="width: 120px; display: none;"
                                               placeholder="18:00">
                                    </div>
                                    
                                    <!-- Cumartesi -->
                                    <div class="flex items-center gap-3 p-3 border border-zinc-200 rounded-lg">
                                        <input type="checkbox" 
                                               id="saturday" 
                                               name="training_days[]" 
                                               value="Cumartesi"
                                               class="shadcn-checkbox"
                                               onchange="toggleTimeInputs(this, \'saturday-time\')">
                                        <label for="saturday" class="flex-1 font-medium cursor-pointer">Cumartesi</label>
                                        <input type="time" 
                                               id="saturday-time" 
                                               name="training_times[Cumartesi]" 
                                               class="shadcn-input" 
                                               style="width: 120px; display: none;"
                                               placeholder="10:00">
                                    </div>
                                    
                                    <!-- Pazar -->
                                    <div class="flex items-center gap-3 p-3 border border-zinc-200 rounded-lg">
                                        <input type="checkbox" 
                                               id="sunday" 
                                               name="training_days[]" 
                                               value="Pazar"
                                               class="shadcn-checkbox"
                                               onchange="toggleTimeInputs(this, \'sunday-time\')">
                                        <label for="sunday" class="flex-1 font-medium cursor-pointer">Pazar</label>
                                        <input type="time" 
                                               id="sunday-time" 
                                               name="training_times[Pazar]" 
                                               class="shadcn-input" 
                                               style="width: 120px; display: none;"
                                               placeholder="10:00">
                                    </div>
                                </div>
                                <p class="shadcn-form-hint mt-2">Antrenman günlerini seçin ve her gün için saat belirleyin</p>
                            </div>

                            <div class="shadcn-form-group md:col-span-2">
                                <label for="max_capacity" class="shadcn-label">
                                    Maksimum Kapasite
                                </label>
                                <input type="number" 
                                       id="max_capacity" 
                                       name="max_capacity" 
                                       class="shadcn-input" 
                                       placeholder="25"
                                       min="10"
                                       max="50"
                                       value="' . htmlspecialchars($_POST['max_capacity'] ?? '25') . '">
                            </div>
                            <div class="shadcn-form-group md:col-span-2">
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
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 gap-4">
                        <div class="shadcn-form-group">
                            <label for="description" class="shadcn-label">
                                Grup Hakkında
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      class="shadcn-input" 
                                      rows="4" 
                                      style="resize: vertical;"
                                      placeholder="Grup hakkında açıklama...">' . htmlspecialchars($_POST['description'] ?? '') . '</textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3">
                    <a href="' . BASE_URL . '/admin/youth-groups" class="shadcn-btn shadcn-btn-outline">
                        İptal
                    </a>
                    <button type="submit" class="shadcn-btn shadcn-btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Grubu Kaydet
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Photo Upload -->
                <div class="shadcn-card" style="margin-bottom: 1.5rem;">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Grup Fotoğrafı</h3>
                        <p class="shadcn-card-description">Grup fotoğrafını yükleyin</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="shadcn-form-group">
                            <label for="photo" class="shadcn-label">
                                Fotoğraf Seçin
                            </label>
                            <input type="file" 
                                   id="photo" 
                                   name="photo" 
                                   class="shadcn-input" 
                                   accept="image/*"
                                   onchange="previewImage(event)">
                            <p class="text-xs text-zinc-500" style="margin-top: 0.5rem;">
                                JPG, PNG, GIF veya WebP (Max 5MB)
                            </p>
                        </div>
                        <div id="photo-preview" style="margin-top: 1rem; display: none;">
                            <img id="preview-image" src="" alt="Preview" style="width: 100%; border-radius: 0.5rem; border: 1px solid #e4e4e7;">
                        </div>
                    </div>
                </div>
                
                <!-- Helper Info -->
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
                                <div class="flex items-start gap-3">
                                    <div class="shadcn-info-icon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="shadcn-info-title">Yaş Grupları</p>
                                        <p class="shadcn-info-text">U9, U11, U13, U15, U17, U19, U21 yaş gruplarından birini seçin</p>
                                    </div>
                                </div>
                            </div>

                            <div class="shadcn-info-item">
                                <div class="flex items-start gap-3">
                                    <div class="shadcn-info-icon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="shadcn-info-title">Antrenman Günleri</p>
                                        <p class="shadcn-info-text">Günleri virgülle ayırarak yazın (örn: Pazartesi, Çarşamba)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="shadcn-info-item">
                                <div class="flex items-start gap-3">
                                    <div class="shadcn-info-icon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="shadcn-info-title">Kapasite</p>
                                        <p class="shadcn-info-text">Grubun maksimum oyuncu kapasitesini belirleyin</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>

<script>
function toggleTimeInputs(checkbox, timeInputId) {
    const timeInput = document.getElementById(timeInputId);
    if (checkbox.checked) {
        timeInput.style.display = 'block';
        timeInput.required = true;
    } else {
        timeInput.style.display = 'none';
        timeInput.required = false;
        timeInput.value = '';
    }
}

function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('photo-preview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
