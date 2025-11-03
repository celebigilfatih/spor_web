<?php
$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Alt Yapı Oyuncusu Düzenle</h1>
                <p class="shadcn-page-description">' . htmlspecialchars($player['name']) . ' oyuncusunun bilgilerini güncelleyin</p>
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
            <form method="POST" action="' . BASE_URL . '/admin/players/edit-youth/' . $player['id'] . '" class="space-y-6" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                
                <!-- Oyuncu Bilgileri -->
                <div class="shadcn-card">
                    <div class="shadcn-card-header">
                        <h3 class="shadcn-card-title">Oyuncu Bilgileri</h3>
                        <p class="shadcn-card-description">Oyuncunun temel bilgilerini düzenleyin</p>
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
                                       value="' . htmlspecialchars($player['name']) . '"
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
                                       value="' . htmlspecialchars($player['birth_date'] ?? '') . '"
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
                                       value="' . htmlspecialchars($player['jersey_number'] ?? '') . '">
                                <p class="shadcn-form-hint">1-99 arası numara seçiniz (isteğe bağlı)</p>
                            </div>

                            <div class="shadcn-form-group md:col-span-2">
                                <label for="position" class="shadcn-label">
                                    Pozisyon Bilgisi <span class="text-red-500">*</span>
                                </label>
                                <select id="position" name="position" class="shadcn-select" required>
                                    <option value="">Pozisyon Seçiniz</option>
                                    <option value="Kaleci"' . ($player['position'] === 'Kaleci' ? ' selected' : '') . '>Kaleci</option>
                                    <option value="Defans"' . ($player['position'] === 'Defans' ? ' selected' : '') . '>Defans</option>
                                    <option value="Orta Saha"' . ($player['position'] === 'Orta Saha' ? ' selected' : '') . '>Orta Saha</option>
                                    <option value="Forvet"' . ($player['position'] === 'Forvet' ? ' selected' : '') . '>Forvet</option>
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
                                            <option value="">Grup Seçiniz</option>';
                                            
                                            if (isset($youth_groups) && is_array($youth_groups)) {
                                                foreach ($youth_groups as $group) {
                                                    $selected = $player['youth_group_id'] == $group['id'] ? ' selected' : '';
                                                    $content .= '<option value="' . $group['id'] . '"' . $selected . '>' . htmlspecialchars($group['name']) . '</option>';
                                                }
                                            }
                                            
                                            $content .= '
                                        </select>
                                    </div>
                                </div>
                                <p class="shadcn-form-hint">Oyuncunun ait olduğu gençlik grubunu seçiniz.</p>
                            </div>

                            <div class="shadcn-form-group md:col-span-2">
                                <label for="status" class="shadcn-label">
                                    Durum <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" class="shadcn-select" required>
                                    <option value="active"' . ($player['status'] === 'active' ? ' selected' : '') . '>Aktif</option>
                                    <option value="injured"' . ($player['status'] === 'injured' ? ' selected' : '') . '>Sakatlık</option>
                                    <option value="suspended"' . ($player['status'] === 'suspended' ? ' selected' : '') . '>Cezalı</option>
                                    <option value="inactive"' . ($player['status'] === 'inactive' ? ' selected' : '') . '>Pasif</option>
                                </select>
                            </div>

                            <!-- Photo Upload -->
                            <div class="shadcn-form-group md:col-span-2">
                                <label for="photo" class="shadcn-label">
                                    Fotoğraf
                                </label>
                                <input type="file" 
                                       id="photo" 
                                       name="photo" 
                                       class="shadcn-input"
                                       accept="image/jpeg,image/png,image/webp">
                                <p class="shadcn-form-hint">JPG, PNG, WebP (Max: 5MB)</p>
                                ';
                                
                                if ($player['photo']) {
                                    $content .= '
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600 mb-2">Mevcut fotoğraf:</p>
                                    <img src="' . BASE_URL . '/uploads/' . $player['photo'] . '" 
                                         alt="Mevcut fotoğraf" 
                                         class="w-24 h-24 object-cover rounded-lg border">
                                </div>';
                                }
                                
                                $content .= '
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
                        Değişiklikleri Kaydet
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1">
            <div class="shadcn-card sticky top-6">
                <div class="shadcn-card-header">
                    <h3 class="shadcn-card-title flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Oyuncu Bilgileri
                    </h3>
                </div>
                <div class="shadcn-card-content">
                    <div class="space-y-4">
                        <div class="shadcn-info-item">
                            <div class="flex items-start gap-3">
                                <div class="shadcn-info-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="shadcn-info-title">Oluşturma Tarihi</p>
                                    <p class="shadcn-info-text">' . (isset($player['created_at']) ? date('d.m.Y H:i', strtotime($player['created_at'])) : 'Bilinmiyor') . '</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <div class="flex items-start gap-3">
                                <div class="shadcn-info-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="shadcn-info-title">Son Güncelleme</p>
                                    <p class="shadcn-info-text">' . (isset($player['updated_at']) ? date('d.m.Y H:i', strtotime($player['updated_at'])) : 'Bilinmiyor') . '</p>
                                </div>
                            </div>
                        </div>

                        <div class="shadcn-info-item">
                            <div class="flex items-start gap-3">
                                <div class="shadcn-info-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="shadcn-info-title">Oyuncu ID</p>
                                    <p class="shadcn-info-text">#' . $player['id'] . '</p>
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
                                    <p class="text-xs text-blue-700">Bu form sadece alt yapı oyuncuları için kullanılır. Forma numarası isteğe bağlıdır.</p>
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