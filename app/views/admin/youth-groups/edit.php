<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Alt Yapı Grubu Düzenle</h1>
                <p class="shadcn-page-description">Grup bilgilerini güncelleyin</p>
            </div>
            <a href="' . BASE_URL . '/admin/youth-groups" class="shadcn-btn shadcn-btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </div>

    <form method="POST" action="' . BASE_URL . '/admin/youth-groups/edit/' . ($group['id'] ?? '') . '" enctype="multipart/form-data" class="space-y-6">
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
                                       value="' . htmlspecialchars($_POST['name'] ?? $group['name'] ?? '') . '"
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="age_group" class="shadcn-label">
                                    Yaş Grubu <span class="text-red-500">*</span>
                                </label>
                                <select id="age_group" name="age_group" class="shadcn-select" required>
                                    <option value="">Seçiniz</option>
                                    <option value="U8"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U8') ? ' selected' : '') . '>U8 (8 yaş altı)</option>
                                    <option value="U9"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U9') ? ' selected' : '') . '>U9 (9 yaş altı)</option>
                                    <option value="U10"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U10') ? ' selected' : '') . '>U10 (10 yaş altı)</option>
                                    <option value="U11"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U11') ? ' selected' : '') . '>U11 (11 yaş altı)</option>
                                    <option value="U12"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U12') ? ' selected' : '') . '>U12 (12 yaş altı)</option>
                                    <option value="U13"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U13') ? ' selected' : '') . '>U13 (13 yaş altı)</option>
                                    <option value="U14"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U14') ? ' selected' : '') . '>U14 (14 yaş altı)</option>
                                    <option value="U15"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U15') ? ' selected' : '') . '>U15 (15 yaş altı)</option>
                                    <option value="U16"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U16') ? ' selected' : '') . '>U16 (16 yaş altı)</option>
                                    <option value="U17"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U17') ? ' selected' : '') . '>U17 (17 yaş altı)</option>
                                    <option value="U18"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U18') ? ' selected' : '') . '>U18 (18 yaş altı)</option>
                                    <option value="U19"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U19') ? ' selected' : '') . '>U19 (19 yaş altı)</option>
                                    <option value="U20"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U20') ? ' selected' : '') . '>U20 (20 yaş altı)</option>
                                    <option value="U21"' . ((($_POST['age_group'] ?? $group['age_group'] ?? '') === 'U21') ? ' selected' : '') . '>U21 (21 yaş altı)</option>
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
                                       value="' . htmlspecialchars($_POST['season'] ?? $group['season'] ?? '2024-25') . '"
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
                                       value="' . htmlspecialchars($_POST['min_age'] ?? $group['min_age'] ?? '') . '"
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
                                       value="' . htmlspecialchars($_POST['max_age'] ?? $group['max_age'] ?? '') . '"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Antrenör Bilgileri -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Antrenör Bilgileri</h3>
                        <p class="shadcn-card-description">Grup antrenörlerini teknik kadrodan seçin</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="shadcn-form-group">
                                <label for="coach_name" class="shadcn-label">
                                    Baş Antrenör
                                </label>
                                <select id="coach_name" 
                                        name="coach_name" 
                                        class="shadcn-select">
                                    <option value="">Seçiniz</option>
                                    ' . (isset($coaches) && is_array($coaches) ? implode('', array_map(function($coach) use ($group) {
                                        $currentValue = $_POST['coach_name'] ?? $group['coach_name'] ?? '';
                                        $selected = ($currentValue === $coach['name']) ? ' selected' : '';
                                        $teamInfo = !empty($coach['team_name']) ? ' (' . htmlspecialchars($coach['team_name']) . ')' : '';
                                        return '<option value="' . htmlspecialchars($coach['name']) . '"' . $selected . '>' . 
                                               htmlspecialchars($coach['name']) . $teamInfo . '</option>';
                                    }, $coaches)) : '') . '
                                </select>
                                <p class="text-xs text-zinc-500" style="margin-top: 0.5rem;">
                                    Aktif antrenörler listeden seçilir
                                </p>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="assistant_coach" class="shadcn-label">
                                    Yardımcı Antrenör
                                </label>
                                <select id="assistant_coach" 
                                        name="assistant_coach" 
                                        class="shadcn-select">
                                    <option value="">Seçiniz</option>
                                    ' . (isset($coaches) && is_array($coaches) ? implode('', array_map(function($coach) use ($group) {
                                        $currentValue = $_POST['assistant_coach'] ?? $group['assistant_coach'] ?? '';
                                        $selected = ($currentValue === $coach['name']) ? ' selected' : '';
                                        $teamInfo = !empty($coach['team_name']) ? ' (' . htmlspecialchars($coach['team_name']) . ')' : '';
                                        return '<option value="' . htmlspecialchars($coach['name']) . '"' . $selected . '>' . 
                                               htmlspecialchars($coach['name']) . $teamInfo . '</option>';
                                    }, $coaches)) : '') . '
                                </select>
                                <p class="text-xs text-zinc-500" style="margin-top: 0.5rem;">
                                    Aktif antrenörler listeden seçilir
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Antrenman Bilgileri -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Antrenman Programı</h3>
                        <p class="shadcn-card-description">Antrenman günleri, saatleri ve saha bilgileri</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div id="training-sessions-container">
                            <!-- Haftalık Antrenman Programı -->
                            <div class="mb-6">
                                <label class="shadcn-label mb-3 block">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Haftalık Antrenman Programı
                                </label>
                                <div class="space-y-3">
                                    <!-- Pazartesi -->
                                    <div class="flex items-center gap-4 p-3 border rounded-lg">
                                        <div class="flex items-center" style="min-width: 120px;">
                                            <input type="checkbox" 
                                                   id="day_monday" 
                                                   name="training_days[]" 
                                                   value="Pazartesi"
                                                   class="shadcn-checkbox mr-2"
                                                   onchange="toggleTimeField(this, \'time_monday\')">
                                            <label for="day_monday" class="text-sm font-medium">Pazartesi</label>
                                        </div>
                                        <input type="time" 
                                               id="time_monday" 
                                               name="training_times[Pazartesi]" 
                                               class="shadcn-input" 
                                               style="max-width: 120px;"
                                               disabled>
                                        <input type="text" 
                                               id="location_monday" 
                                               name="training_locations[Pazartesi]" 
                                               class="shadcn-input flex-1" 
                                               placeholder="Saha / Lokasyon"
                                               disabled>
                                    </div>
                                    
                                    <!-- Salı -->
                                    <div class="flex items-center gap-4 p-3 border rounded-lg">
                                        <div class="flex items-center" style="min-width: 120px;">
                                            <input type="checkbox" 
                                                   id="day_tuesday" 
                                                   name="training_days[]" 
                                                   value="Salı"
                                                   class="shadcn-checkbox mr-2"
                                                   onchange="toggleTimeField(this, \'time_tuesday\')">
                                            <label for="day_tuesday" class="text-sm font-medium">Salı</label>
                                        </div>
                                        <input type="time" 
                                               id="time_tuesday" 
                                               name="training_times[Salı]" 
                                               class="shadcn-input" 
                                               style="max-width: 120px;"
                                               disabled>
                                        <input type="text" 
                                               id="location_tuesday" 
                                               name="training_locations[Salı]" 
                                               class="shadcn-input flex-1" 
                                               placeholder="Saha / Lokasyon"
                                               disabled>
                                    </div>
                                    
                                    <!-- Çarşamba -->
                                    <div class="flex items-center gap-4 p-3 border rounded-lg">
                                        <div class="flex items-center" style="min-width: 120px;">
                                            <input type="checkbox" 
                                                   id="day_wednesday" 
                                                   name="training_days[]" 
                                                   value="Çarşamba"
                                                   class="shadcn-checkbox mr-2"
                                                   onchange="toggleTimeField(this, \'time_wednesday\')">
                                            <label for="day_wednesday" class="text-sm font-medium">Çarşamba</label>
                                        </div>
                                        <input type="time" 
                                               id="time_wednesday" 
                                               name="training_times[Çarşamba]" 
                                               class="shadcn-input" 
                                               style="max-width: 120px;"
                                               disabled>
                                        <input type="text" 
                                               id="location_wednesday" 
                                               name="training_locations[Çarşamba]" 
                                               class="shadcn-input flex-1" 
                                               placeholder="Saha / Lokasyon"
                                               disabled>
                                    </div>
                                    
                                    <!-- Perşembe -->
                                    <div class="flex items-center gap-4 p-3 border rounded-lg">
                                        <div class="flex items-center" style="min-width: 120px;">
                                            <input type="checkbox" 
                                                   id="day_thursday" 
                                                   name="training_days[]" 
                                                   value="Perşembe"
                                                   class="shadcn-checkbox mr-2"
                                                   onchange="toggleTimeField(this, \'time_thursday\')">
                                            <label for="day_thursday" class="text-sm font-medium">Perşembe</label>
                                        </div>
                                        <input type="time" 
                                               id="time_thursday" 
                                               name="training_times[Perşembe]" 
                                               class="shadcn-input" 
                                               style="max-width: 120px;"
                                               disabled>
                                        <input type="text" 
                                               id="location_thursday" 
                                               name="training_locations[Perşembe]" 
                                               class="shadcn-input flex-1" 
                                               placeholder="Saha / Lokasyon"
                                               disabled>
                                    </div>
                                    
                                    <!-- Cuma -->
                                    <div class="flex items-center gap-4 p-3 border rounded-lg">
                                        <div class="flex items-center" style="min-width: 120px;">
                                            <input type="checkbox" 
                                                   id="day_friday" 
                                                   name="training_days[]" 
                                                   value="Cuma"
                                                   class="shadcn-checkbox mr-2"
                                                   onchange="toggleTimeField(this, \'time_friday\')">
                                            <label for="day_friday" class="text-sm font-medium">Cuma</label>
                                        </div>
                                        <input type="time" 
                                               id="time_friday" 
                                               name="training_times[Cuma]" 
                                               class="shadcn-input" 
                                               style="max-width: 120px;"
                                               disabled>
                                        <input type="text" 
                                               id="location_friday" 
                                               name="training_locations[Cuma]" 
                                               class="shadcn-input flex-1" 
                                               placeholder="Saha / Lokasyon"
                                               disabled>
                                    </div>
                                    
                                    <!-- Cumartesi -->
                                    <div class="flex items-center gap-4 p-3 border rounded-lg">
                                        <div class="flex items-center" style="min-width: 120px;">
                                            <input type="checkbox" 
                                                   id="day_saturday" 
                                                   name="training_days[]" 
                                                   value="Cumartesi"
                                                   class="shadcn-checkbox mr-2"
                                                   onchange="toggleTimeField(this, \'time_saturday\')">
                                            <label for="day_saturday" class="text-sm font-medium">Cumartesi</label>
                                        </div>
                                        <input type="time" 
                                               id="time_saturday" 
                                               name="training_times[Cumartesi]" 
                                               class="shadcn-input" 
                                               style="max-width: 120px;"
                                               disabled>
                                        <input type="text" 
                                               id="location_saturday" 
                                               name="training_locations[Cumartesi]" 
                                               class="shadcn-input flex-1" 
                                               placeholder="Saha / Lokasyon"
                                               disabled>
                                    </div>
                                    
                                    <!-- Pazar -->
                                    <div class="flex items-center gap-4 p-3 border rounded-lg">
                                        <div class="flex items-center" style="min-width: 120px;">
                                            <input type="checkbox" 
                                                   id="day_sunday" 
                                                   name="training_days[]" 
                                                   value="Pazar"
                                                   class="shadcn-checkbox mr-2"
                                                   onchange="toggleTimeField(this, \'time_sunday\')">
                                            <label for="day_sunday" class="text-sm font-medium">Pazar</label>
                                        </div>
                                        <input type="time" 
                                               id="time_sunday" 
                                               name="training_times[Pazar]" 
                                               class="shadcn-input" 
                                               style="max-width: 120px;"
                                               disabled>
                                        <input type="text" 
                                               id="location_sunday" 
                                               name="training_locations[Pazar]" 
                                               class="shadcn-input flex-1" 
                                               placeholder="Saha / Lokasyon"
                                               disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                <div class="shadcn-form-group">
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
                                           value="' . htmlspecialchars($_POST['max_capacity'] ?? $group['max_capacity'] ?? '25') . '">
                                </div>

                                <div class="shadcn-form-group">
                                    <label for="status" class="shadcn-label">
                                        Durum
                                </label>
                                <select id="status" name="status" class="shadcn-select">
                                    <option value="active"' . ((($_POST['status'] ?? $group['status'] ?? 'active') === 'active') ? ' selected' : '') . '>Aktif</option>
                                    <option value="inactive"' . ((($_POST['status'] ?? $group['status'] ?? '') === 'inactive') ? ' selected' : '') . '>Pasif</option>
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
                        <div class="shadcn-form-group">
                            <label for="description" class="shadcn-label">
                                Grup Hakkında
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      class="shadcn-input" 
                                      rows="4" 
                                      style="resize: vertical;"
                                      placeholder="Grup hakkında açıklama...">' . htmlspecialchars($_POST['description'] ?? $group['description'] ?? '') . '</textarea>
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
                        Değişiklikleri Kaydet
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Photo Upload -->
                <div class="shadcn-card" style="margin-bottom: 1.5rem;">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Grup Fotoğrafı</h3>
                        <p class="shadcn-card-description">Grup fotoğrafını yükleyin veya değiştirin</p>
                    </div>
                    <div class="shadcn-card-content">';
                    
                    if (!empty($group['photo'])) {
                        $content .= '
                        <div style="margin-bottom: 1rem;">
                            <img src="' . BASE_URL . htmlspecialchars($group['photo']) . '" alt="Mevcut fotoğraf" style="width: 100%; border-radius: 0.5rem; border: 1px solid #e4e4e7;">
                            <p class="text-xs text-zinc-500" style="margin-top: 0.5rem;">Mevcut fotoğraf</p>
                        </div>';
                    }
                    
                    $content .= '
                        <div class="shadcn-form-group">
                            <label for="photo" class="shadcn-label">
                                ' . (!empty($group['photo']) ? 'Yeni Fotoğraf Seçin' : 'Fotoğraf Seçin') . '
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
                            <p class="text-xs font-medium text-zinc-700" style="margin-bottom: 0.5rem;">Yeni fotoğraf önizlemesi:</p>
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
// Preview image function
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

// Toggle time and location fields when day is selected
function toggleTimeField(checkbox, timeId) {
    const timeInput = document.getElementById(timeId);
    const locationInput = document.getElementById(timeId.replace("time_", "location_"));
    
    if (checkbox.checked) {
        timeInput.disabled = false;
        locationInput.disabled = false;
        timeInput.required = true;
    } else {
        timeInput.disabled = true;
        locationInput.disabled = true;
        timeInput.required = false;
        timeInput.value = "";
        locationInput.value = "";
    }
}

// Parse existing training days and pre-fill form
function parseTrainingSchedule() {
    const trainingDays = `<?php echo $group['training_days'] ?? ''; ?>`;
    if (!trainingDays) return;
    
    // Parse format: "Pazartesi 10:00, Perşembe 20:00" or "Pazartesi, Çarşamba, Cuma"
    const days = trainingDays.split(",").map(d => d.trim());
    
    const dayMapping = {
        "Pazartesi": "monday",
        "Salı": "tuesday",
        "Çarşamba": "wednesday",
        "Perşembe": "thursday",
        "Cuma": "friday",
        "Cumartesi": "saturday",
        "Pazar": "sunday"
    };
    
    days.forEach(dayStr => {
        // Try to extract day, time and location
        const parts = dayStr.split(" ");
        const dayName = parts[0];
        const dayKey = dayMapping[dayName];
        
        if (dayKey) {
            const checkbox = document.getElementById(`day_${dayKey}`);
            const timeInput = document.getElementById(`time_${dayKey}`);
            const locationInput = document.getElementById(`location_${dayKey}`);
            
            if (checkbox) {
                checkbox.checked = true;
                timeInput.disabled = false;
                locationInput.disabled = false;
                timeInput.required = true;
                
                // Extract time if present (format: "10:00" or "16:00-18:00")
                if (parts.length > 1) {
                    const timeStr = parts[1];
                    if (timeStr.includes("-")) {
                        // Extract start time from range
                        timeInput.value = timeStr.split("-")[0];
                    } else if (timeStr.match(/\d{1,2}:\d{2}/)) {
                        timeInput.value = timeStr;
                    }
                }
                
                // Extract location if present (after time)
                if (parts.length > 2) {
                    locationInput.value = parts.slice(2).join(" ");
                }
            }
        }
    });
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", parseTrainingSchedule);
</script>
