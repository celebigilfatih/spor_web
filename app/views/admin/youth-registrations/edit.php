<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Kayıt Düzenle</h1>
                <p class="shadcn-page-description">Alt yapı kayıt bilgilerini güncelleyin</p>
            </div>
            <a href="' . BASE_URL . '/admin/youth-registrations" class="shadcn-btn shadcn-btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </div>';

if (!empty($message)) {
    $content .= '<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' . htmlspecialchars($message) . '</div>';
}

if (!empty($error)) {
    $content .= '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ' . htmlspecialchars($error) . '</div>';
}

$content .= '
    <form method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
        
        <!-- Öğrenci Bilgileri -->
        <div class="shadcn-card">
            <div class="shadcn-card-header">
                <h3 class="shadcn-card-title">Öğrenci Bilgileri</h3>
            </div>
            <div class="shadcn-card-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="shadcn-form-group md:col-span-2">
                        <label for="student_name" class="shadcn-label">
                            Ad Soyad <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="student_name" 
                               name="student_name" 
                               class="shadcn-input" 
                               value="' . htmlspecialchars($registration['student']['name'] ?? '') . '"
                               required>
                    </div>
                    
                    <div class="shadcn-form-group">
                        <label for="birth_date" class="shadcn-label">
                            Doğum Tarihi <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="birth_date" 
                               name="birth_date" 
                               class="shadcn-input"
                               value="' . htmlspecialchars($registration['student']['birth_date'] ?? '') . '"
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
                               value="' . htmlspecialchars($registration['student']['birth_place'] ?? '') . '"
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
                               value="' . htmlspecialchars($registration['student']['tc_number'] ?? '') . '"
                               maxlength="11"
                               required>
                    </div>
                    
                    <div class="shadcn-form-group">
                        <label for="father_name" class="shadcn-label">
                            Baba Adı <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="father_name" 
                               name="father_name" 
                               class="shadcn-input"
                               value="' . htmlspecialchars($registration['student']['father_name'] ?? '') . '"
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
                               value="' . htmlspecialchars($registration['student']['mother_name'] ?? '') . '"
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
                               value="' . htmlspecialchars($registration['student']['school_info'] ?? '') . '"
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
                               value="' . htmlspecialchars($registration['student']['first_club'] ?? '') . '">
                    </div>
                    
                    <div class="shadcn-form-group md:col-span-2">
                        <label for="youth_group_id" class="shadcn-label">
                            Gençlik Grubu <span class="text-red-500">*</span>
                        </label>
                        <select id="youth_group_id" name="youth_group_id" class="shadcn-select" required>
                            <option value="">Grup Seçiniz</option>';
                            
                            if (isset($youth_groups) && is_array($youth_groups)) {
                                foreach ($youth_groups as $group) {
                                    $selected = ($registration['youth_group_id'] ?? 0) == $group['id'] ? ' selected' : '';
                                    $content .= '<option value="' . $group['id'] . '"' . $selected . '>' . htmlspecialchars($group['name']) . ' (' . htmlspecialchars($group['age_group']) . ')</option>';
                                }
                            }
                            
                            $content .= '
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Veli Bilgileri -->
        <div class="shadcn-card">
            <div class="shadcn-card-header">
                <h3 class="shadcn-card-title">Veli Bilgileri</h3>
            </div>
            <div class="shadcn-card-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="shadcn-form-group md:col-span-2">
                        <label for="parent_name" class="shadcn-label">
                            Veli Ad Soyad <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="parent_name" 
                               name="parent_name" 
                               class="shadcn-input"
                               value="' . htmlspecialchars($registration['parent']['name'] ?? '') . '"
                               required>
                    </div>
                    
                    <div class="shadcn-form-group">
                        <label for="parent_phone" class="shadcn-label">
                            GSM <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="parent_phone" 
                               name="parent_phone" 
                               class="shadcn-input"
                               value="' . htmlspecialchars($registration['parent']['phone'] ?? '') . '"
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
                               value="' . htmlspecialchars($registration['parent']['email'] ?? '') . '"
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
                                  required>' . htmlspecialchars($registration['parent']['address'] ?? '') . '</textarea>
                    </div>
                    
                    <div class="shadcn-form-group">
                        <label for="father_job" class="shadcn-label">
                            Baba Meslek
                        </label>
                        <input type="text" 
                               id="father_job" 
                               name="father_job" 
                               class="shadcn-input"
                               value="' . htmlspecialchars($registration['parent']['father_job'] ?? '') . '">
                    </div>
                    
                    <div class="shadcn-form-group">
                        <label for="mother_job" class="shadcn-label">
                            Anne Meslek
                        </label>
                        <input type="text" 
                               id="mother_job" 
                               name="mother_job" 
                               class="shadcn-input"
                               value="' . htmlspecialchars($registration['parent']['mother_job'] ?? '') . '">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Acil Durum Bilgileri -->
        <div class="shadcn-card">
            <div class="shadcn-card-header">
                <h3 class="shadcn-card-title">Acil Durum İletişim</h3>
            </div>
            <div class="shadcn-card-content">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="shadcn-form-group">
                        <label for="emergency_contact" class="shadcn-label">
                            İletişim Kişisi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="emergency_contact" 
                               name="emergency_contact" 
                               class="shadcn-input"
                               value="' . htmlspecialchars($registration['emergency']['contact'] ?? '') . '"
                               required>
                    </div>
                    
                    <div class="shadcn-form-group">
                        <label for="emergency_relation" class="shadcn-label">
                            Yakınlık Derecesi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="emergency_relation" 
                               name="emergency_relation" 
                               class="shadcn-input"
                               value="' . htmlspecialchars($registration['emergency']['relation'] ?? '') . '"
                               required>
                    </div>
                    
                    <div class="shadcn-form-group">
                        <label for="emergency_phone" class="shadcn-label">
                            Telefon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="emergency_phone" 
                               name="emergency_phone" 
                               class="shadcn-input"
                               value="' . htmlspecialchars($registration['emergency']['phone'] ?? '') . '"
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
                Değişiklikleri Kaydet
            </button>
        </div>
    </form>
</div>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>
