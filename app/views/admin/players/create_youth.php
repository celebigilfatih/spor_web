<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Alt Yapı - Yeni Oyuncu Ekle</h1>
                <p class="shadcn-page-description">Alt yapıya yeni oyuncu eklemek için gerekli bilgileri giriniz</p>
            </div>
            <a href="' . BASE_URL . '/admin/players/youth" class="shadcn-btn shadcn-btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form method="POST" action="' . BASE_URL . '/admin/players/create-youth" class="space-y-6" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                
                <!-- Oyuncu Bilgileri -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Oyuncu Bilgileri</h3>
                        <p class="shadcn-card-description">Oyuncunun temel bilgilerini girin</p>
                    </div>
                    <div class="shadcn-card-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="shadcn-form-group md:col-span-2">
                                <label for="full_name" class="shadcn-label">
                                    Ad Soyad <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="full_name" 
                                       name="full_name" 
                                       class="shadcn-input" 
                                       placeholder="Örn: Fatih Çelebigil"
                                       value="' . htmlspecialchars($_POST['full_name'] ?? '') . '"
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
                                       value="' . htmlspecialchars($_POST['birth_date'] ?? '') . '"
                                       required>
                            </div>

                            <div class="shadcn-form-group">
                                <label for="jersey_number" class="shadcn-label">
                                    Forma Numarası
                                </label>
                                <input type="number" 
                                       id="jersey_number" 
                                       name="jersey_number" 
                                       class="shadcn-input" 
                                       placeholder="10"
                                       min="1" 
                                       max="99"
                                       value="' . htmlspecialchars($_POST['jersey_number'] ?? '') . '">
                                <p class="shadcn-form-hint">1-99 arası numara seçiniz (isteğe bağlı)</p>
                            </div>

                            <div class="shadcn-form-group md:col-span-2">
                                <label for="position" class="shadcn-label">
                                    Pozisyon Bilgisi <span class="text-red-500">*</span>
                                </label>
                                <select id="position" name="position" class="shadcn-select" required>
                                    <option value="">Pozisyon Seçiniz</option>
                                    <option value="Kaleci"' . (($_POST['position'] ?? '') === 'Kaleci' ? ' selected' : '') . '>Kaleci</option>
                                    <option value="Defans"' . (($_POST['position'] ?? '') === 'Defans' ? ' selected' : '') . '>Defans</option>
                                    <option value="Orta Saha"' . (($_POST['position'] ?? '') === 'Orta Saha' ? ' selected' : '') . '>Orta Saha</option>
                                    <option value="Forvet"' . (($_POST['position'] ?? '') === 'Forvet' ? ' selected' : '') . '>Forvet</option>
                                </select>
                            </div>

                            <!-- Youth Group Selection -->
                            <div class="shadcn-form-group md:col-span-2">
                                <label class="shadcn-label">
                                    Gençlik Grubu Atama <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                    <div>
                                        <label for="youth_group_id" class="block text-sm font-medium text-gray-700 mb-1">Gençlik Akademisi</label>
                                        <select id="youth_group_id" name="youth_group_id" class="shadcn-select" required>
                                            <option value="">Grup Seçiniz</option>
                                            ' . (isset($youth_groups) && is_array($youth_groups) ? implode('', array_map(function($group) {
                                                return '<option value="' . $group['id'] . '"' . ((($_POST['youth_group_id'] ?? '') == $group['id']) ? ' selected' : '') . '>' . htmlspecialchars($group['name']) . '</option>';
                                            }, $youth_groups)) : '') . '
                                        </select>
                                    </div>
                                </div>
                                <p class="shadcn-form-hint">Oyuncunun ait olduğu gençlik grubunu seçiniz.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3">
                    <a href="' . BASE_URL . '/admin/players/youth" class="shadcn-btn shadcn-btn-outline">
                        İptal
                    </a>
                    <button type="submit" class="shadcn-btn shadcn-btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Oyuncuyu Kaydet
                    </button>
                </div>
            </form>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="shadcn-info-title">Ad Soyad</p>
                                    <p class="shadcn-info-text">Oyuncunun tam adını giriniz</p>
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
                                    <p class="shadcn-info-title">Doğum Tarihi</p>
                                    <p class="shadcn-info-text">Oyuncunun doğum tarihini seçiniz</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <div class="flex items-start gap-3">
                                <div class="shadcn-info-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="shadcn-info-title">Forma Numarası</p>
                                    <p class="shadcn-info-text">Benzersiz olmalıdır (1-99 arası) - Opsiyonel</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <div class="flex items-start gap-3">
                                <div class="shadcn-info-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="shadcn-info-title">Pozisyon</p>
                                    <p class="shadcn-info-text">Oyuncunun ana pozisyonunu seçiniz</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-blue-900 mb-1">Alt Yapı Oyuncusu</p>
                                    <p class="text-xs text-blue-700">Bu form sadece alt yapı oyuncuları için kullanılır. A Takım oyuncuları için "Oyuncular" bölümünü kullanınız.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
';

include BASE_PATH . '/app/views/admin/layout.php';
?>