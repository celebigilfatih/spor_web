<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Yeni Alt Yapı Kaydı Ekle</h1>
                <p class="shadcn-page-description">Sisteme manuel olarak alt yapı kaydı ekleyin</p>
            </div>
            <a href="' . BASE_URL . '/admin/youth-registrations" class="shadcn-btn shadcn-btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </div>';

// Display errors
if (isset($errors) && !empty($errors)) {
    $content .= '
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <strong class="font-semibold">Hatalar:</strong>
                <ul class="list-disc ml-5 mt-1">';
    foreach ($errors as $error) {
        $content .= '<li>' . htmlspecialchars($error) . '</li>';
    }
    $content .= '
                </ul>
            </div>
        </div>
    </div>';
}

if (isset($error) && !empty($error)) {
    $content .= '
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <span>' . htmlspecialchars($error) . '</span>
        </div>
    </div>';
}

$content .= '

    <form method="POST" action="' . BASE_URL . '/admin/youth-registrations/create" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Öğrenci Bilgileri -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Öğrenci Bilgileri</h3>
                        <p class="shadcn-card-description">Öğrenciye ait temel bilgiler</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="shadcn-form-group">
                                <label for="student_name" class="shadcn-label">
                                    Adı Soyadı <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="student_name" 
                                       name="student_name" 
                                       class="shadcn-input" 
                                       placeholder="Öğrencinin tam adı"
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="youth_group_id" class="shadcn-label">
                                    Alt Yapı Grubu <span class="text-red-500">*</span>
                                </label>
                                <select id="youth_group_id" name="youth_group_id" class="shadcn-select" required>
                                    <option value="">Grup seçiniz</option>';

if (isset($youth_groups) && !empty($youth_groups)) {
    foreach ($youth_groups as $group) {
        $capacity_info = $group['current_count'] . '/' . $group['max_capacity'];
        $is_full = $group['current_count'] >= $group['max_capacity'];
        $disabled = $is_full ? ' disabled' : '';
        $full_text = $is_full ? ' (Dolu)' : '';
        
        $content .= '<option value="' . $group['id'] . '"' . $disabled . '>' . 
                    htmlspecialchars($group['name']) . ' (' . $group['age_group'] . ' - ' . 
                    $group['min_age'] . '-' . $group['max_age'] . ' yaş) - ' . $capacity_info . $full_text . '</option>';
    }
}

$content .= '
                                </select>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="birth_date" class="shadcn-label">
                                    Doğum Tarihi <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       id="birth_date" 
                                       name="birth_date" 
                                       class="shadcn-input" 
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="birth_place" class="shadcn-label">
                                    Doğum Yeri <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="birth_place" 
                                       name="birth_place" 
                                       class="shadcn-input" 
                                       placeholder="Doğum yeri"
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="tc_number" class="shadcn-label">
                                    TC Kimlik No <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="tc_number" 
                                       name="tc_number" 
                                       class="shadcn-input" 
                                       placeholder="11 haneli TC No"
                                       maxlength="11"
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="student_photo" class="shadcn-label">
                                    Fotoğraf
                                </label>
                                <div class="shadcn-file-upload">
                                    <input type="file" 
                                           id="student_photo" 
                                           name="student_photo" 
                                           class="shadcn-file-input"
                                           accept="image/*">
                                    <label for="student_photo" class="shadcn-file-label">
                                        <svg class="w-8 h-8 mb-2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-zinc-700">Fotoğraf Yükle</span>
                                        <span class="text-xs text-zinc-500">JPG, PNG (Max: 5MB)</span>
                                    </label>
                                </div>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="father_name" class="shadcn-label">
                                    Baba Adı <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="father_name" 
                                       name="father_name" 
                                       class="shadcn-input" 
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="mother_name" class="shadcn-label">
                                    Anne Adı <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="mother_name" 
                                       name="mother_name" 
                                       class="shadcn-input" 
                                       required>
                            </div>

                            <div class="shadcn-form-group md:col-span-2">
                                <label for="school_info" class="shadcn-label">
                                    Okul Bilgisi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="school_info" 
                                       name="school_info" 
                                       class="shadcn-input" 
                                       placeholder="Okul adı ve sınıf"
                                       required>
                            </div>

                            <div class="shadcn-form-group md:col-span-2">
                                <label for="first_club" class="shadcn-label">
                                    İlk Kulübü
                                </label>
                                <input type="text" 
                                       id="first_club" 
                                       name="first_club" 
                                       class="shadcn-input" 
                                       placeholder="Daha önce oynadığı kulüp varsa">
                                <p class="shadcn-form-hint">Opsiyonel - Daha önce başka kulüpte oynadıysa yazınız</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Veli Bilgileri -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Veli Bilgileri</h3>
                        <p class="shadcn-card-description">Veli/vasi iletişim bilgileri</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="shadcn-form-group">
                                <label for="parent_name" class="shadcn-label">
                                    Veli Adı Soyadı <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="parent_name" 
                                       name="parent_name" 
                                       class="shadcn-input" 
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="parent_phone" class="shadcn-label">
                                    GSM Numarası <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" 
                                       id="parent_phone" 
                                       name="parent_phone" 
                                       class="shadcn-input" 
                                       placeholder="5xxxxxxxxx"
                                       maxlength="11"
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="email" class="shadcn-label">
                                    E-posta <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="shadcn-input" 
                                       placeholder="ornek@email.com"
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="father_job" class="shadcn-label">
                                    Baba Mesleği <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="father_job" 
                                       name="father_job" 
                                       class="shadcn-input" 
                                       required>
                            </div>

                            <div class="shadcn-form-group md:col-span-2">
                                <label for="mother_job" class="shadcn-label">
                                    Anne Mesleği <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="mother_job" 
                                       name="mother_job" 
                                       class="shadcn-input" 
                                       required>
                            </div>

                            <div class="shadcn-form-group md:col-span-2">
                                <label for="address" class="shadcn-label">
                                    İkametgah Adresi <span class="text-red-500">*</span>
                                </label>
                                <textarea id="address" 
                                          name="address" 
                                          class="shadcn-input" 
                                          rows="3"
                                          style="resize: vertical;"
                                          required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acil Durum Bilgileri -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Acil Durum İletişim</h3>
                        <p class="shadcn-card-description">Acil durumlarda aranacak kişi bilgileri</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="shadcn-form-group">
                                <label for="emergency_contact" class="shadcn-label">
                                    Acil Aranacak Kişi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="emergency_contact" 
                                       name="emergency_contact" 
                                       class="shadcn-input" 
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="emergency_relation" class="shadcn-label">
                                    Yakınlık Derecesi <span class="text-red-500">*</span>
                                </label>
                                <select id="emergency_relation" name="emergency_relation" class="shadcn-select" required>
                                    <option value="">Seçiniz</option>
                                    <option value="anne">Anne</option>
                                    <option value="baba">Baba</option>
                                    <option value="kardes">Kardeş</option>
                                    <option value="teyze">Teyze</option>
                                    <option value="amca">Amca</option>
                                    <option value="hala">Hala</option>
                                    <option value="dayi">Dayı</option>
                                    <option value="dede">Dede</option>
                                    <option value="nine">Nine</option>
                                    <option value="diger">Diğer</option>
                                </select>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="emergency_phone" class="shadcn-label">
                                    Acil GSM <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" 
                                       id="emergency_phone" 
                                       name="emergency_phone" 
                                       class="shadcn-input" 
                                       placeholder="5xxxxxxxxx"
                                       maxlength="11"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3">
                    <a href="' . BASE_URL . '/admin/youth-registrations" class="shadcn-btn shadcn-btn-outline">
                        İptal
                    </a>
                    <button type="submit" class="shadcn-btn shadcn-btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Kaydı Kaydet
                    </button>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-1">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="shadcn-info-title">Zorunlu Alanlar</p>
                                        <p class="shadcn-info-text">Yıldız (*) işareti olan alanlar zorunludur</p>
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
                                        <p class="shadcn-info-title">Yaş Uyumu</p>
                                        <p class="shadcn-info-text">Doğum tarihine göre uygun grubu seçiniz</p>
                                    </div>
                                </div>
                            </div>

                            <div class="shadcn-info-item">
                                <div class="flex items-start gap-3">
                                    <div class="shadcn-info-icon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="shadcn-info-title">Fotoğraf</p>
                                        <p class="shadcn-info-text">Maksimum 5MB, JPG veya PNG formatında</p>
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

<script>
// TC Number validation
document.getElementById("tc_number").addEventListener("input", function() {
    this.value = this.value.replace(/[^0-9]/g, "");
});

// Phone validation
document.querySelectorAll("input[type=tel]").forEach(function(input) {
    input.addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9]/g, "");
    });
});
</script>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>
