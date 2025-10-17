<?php
// Extract data with defensive handling for both nested and flat structures
$studentName = '';
if (isset($registration['student']['name'])) {
    $studentName = $registration['student']['name'];
} elseif (isset($registration['student']['first_name'])) {
    $studentName = trim(($registration['student']['first_name'] ?? '') . ' ' . ($registration['student']['last_name'] ?? ''));
} elseif (isset($registration['student_name'])) {
    $studentName = $registration['student_name'];
}

$studentFullName = $studentName;
$studentTC = $registration['student']['tc_number'] ?? $registration['student_tc'] ?? '';
$studentBirthDate = $registration['student']['birth_date'] ?? $registration['student_birth_date'] ?? '';
$studentBirthPlace = $registration['student']['birth_place'] ?? '';
$studentFatherName = $registration['student']['father_name'] ?? '';
$studentMotherName = $registration['student']['mother_name'] ?? '';
$studentSchool = $registration['student']['school_info'] ?? $registration['student']['school'] ?? $registration['student_school'] ?? '';
$studentFirstClub = $registration['student']['first_club'] ?? '';

// Parent data
$parentName = '';
if (isset($registration['parent']['name'])) {
    $parentName = $registration['parent']['name'];
} elseif (isset($registration['parent']['first_name'])) {
    $parentName = trim(($registration['parent']['first_name'] ?? '') . ' ' . ($registration['parent']['last_name'] ?? ''));
} elseif (isset($registration['parent_name'])) {
    $parentName = $registration['parent_name'];
}

$parentFullName = $parentName;
$parentPhone = $registration['parent']['phone'] ?? $registration['parent_phone'] ?? '';
$parentEmail = $registration['parent']['email'] ?? $registration['parent_email'] ?? '';
$parentAddress = $registration['parent']['address'] ?? $registration['parent_address'] ?? '';
$parentFatherJob = $registration['parent']['father_job'] ?? '';
$parentMotherJob = $registration['parent']['mother_job'] ?? '';

// Emergency contact data
$emergencyName = '';
if (isset($registration['emergency']['contact'])) {
    $emergencyName = $registration['emergency']['contact'];
} elseif (isset($registration['emergency']['first_name'])) {
    $emergencyName = trim(($registration['emergency']['first_name'] ?? '') . ' ' . ($registration['emergency']['last_name'] ?? ''));
} elseif (isset($registration['emergency_contact_name'])) {
    $emergencyName = $registration['emergency_contact_name'];
}

$emergencyFullName = $emergencyName;
$emergencyPhone = $registration['emergency']['phone'] ?? $registration['emergency_contact_phone'] ?? '';
$emergencyRelationship = $registration['emergency']['relation'] ?? $registration['emergency']['relationship'] ?? $registration['emergency_contact_relationship'] ?? '';

// Registration data
$createdAt = $registration['created_at'] ?? $registration['registration_date'] ?? '';
$updatedAt = $registration['updated_at'] ?? '';
$adminNotes = $registration['admin_notes'] ?? '';
$photoPath = $registration['photo_path'] ?? '';
$youthGroupId = $registration['youth_group_id'] ?? 0;
$status = $registration['status'] ?? 'pending';

// Calculate age
$age = '';
if (!empty($studentBirthDate)) {
    try {
        $birthDate = new DateTime($studentBirthDate);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
    } catch (Exception $e) {
        $age = '';
    }
}

// Status configuration
$statusConfig = [
    'approved' => ['class' => 'success', 'text' => 'Onaylandı', 'icon' => 'check-circle'],
    'rejected' => ['class' => 'danger', 'text' => 'Reddedildi', 'icon' => 'times-circle'],
    'pending' => ['class' => 'warning', 'text' => 'Beklemede', 'icon' => 'clock']
];

$currentStatus = $statusConfig[$status] ?? $statusConfig['pending'];

$content = '
<div class="shadcn-page-container">
    <!-- Page Header -->
    <div class="shadcn-page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="shadcn-page-title">Kayıt Detayları</h1>
                <p class="shadcn-page-description">Alt yapı kaydı bilgilerini görüntüle ve düzenle</p>
            </div>
            <div class="flex gap-3">
                <button type="button" class="shadcn-btn shadcn-btn-outline" onclick="showStatusModal()">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Durumu Güncelle
                </button>
                <a href="' . BASE_URL . '/admin/youth-registrations" class="shadcn-btn shadcn-btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Geri Dön
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Öğrenci Bilgileri -->
            <div class="shadcn-card">
                <div class="shadcn-card-header">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="shadcn-card-title">Öğrenci Bilgileri</h3>
                            <p class="shadcn-card-description">Öğrenciye ait temel bilgiler</p>
                        </div>
                        <div class="shadcn-icon-wrapper">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="shadcn-card-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Ad Soyad</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($studentFullName) . '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">TC Kimlik No</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($studentTC) . '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Doğum Tarihi</label>
                            <p class="shadcn-info-value">' . (!empty($studentBirthDate) ? date('d.m.Y', strtotime($studentBirthDate)) : '-') . '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Doğum Yeri</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($studentBirthPlace) . '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Yaş</label>
                            <p class="shadcn-info-value">' . ($age ? $age . ' yaş' : '-') . '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Okul</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($studentSchool) . '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Baba Adı</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($studentFatherName) . '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Anne Adı</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($studentMotherName) . '</p>
                        </div>';

if (!empty($studentFirstClub)) {
    $content .= '
                        <div class="shadcn-info-item md:col-span-2">
                            <label class="shadcn-info-label">İlk Kulübü</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($studentFirstClub) . '</p>
                        </div>';
}

$content .= '
                    </div>
                </div>
            </div>

            <!-- Veli Bilgileri -->
            <div class="shadcn-card">
                <div class="shadcn-card-header">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="shadcn-card-title">Veli Bilgileri</h3>
                            <p class="shadcn-card-description">Veli/vasi iletişim bilgileri</p>
                        </div>
                        <div class="shadcn-icon-wrapper">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="shadcn-card-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Ad Soyad</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($parentFullName) . '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Telefon</label>
                            <p class="shadcn-info-value">';

if (!empty($parentPhone)) {
    $content .= '<a href="tel:' . htmlspecialchars($parentPhone) . '" class="text-blue-600 hover:underline">' . htmlspecialchars($parentPhone) . '</a>';
} else {
    $content .= '-';
}

$content .= '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">E-posta</label>
                            <p class="shadcn-info-value">';

if (!empty($parentEmail)) {
    $content .= '<a href="mailto:' . htmlspecialchars($parentEmail) . '" class="text-blue-600 hover:underline">' . htmlspecialchars($parentEmail) . '</a>';
} else {
    $content .= '-';
}

$content .= '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Baba Mesleği</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($parentFatherJob) . '</p>
                        </div>
                        
                        <div class="shadcn-info-item md:col-span-2">
                            <label class="shadcn-info-label">Anne Mesleği</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($parentMotherJob) . '</p>
                        </div>
                        
                        <div class="shadcn-info-item md:col-span-2">
                            <label class="shadcn-info-label">Adres</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($parentAddress) . '</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acil Durum İletişim -->
            <div class="shadcn-card">
                <div class="shadcn-card-header">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="shadcn-card-title">Acil Durum İletişim</h3>
                            <p class="shadcn-card-description">Acil durumlarda aranacak kişi</p>
                        </div>
                        <div class="shadcn-icon-wrapper">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="shadcn-card-content">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">İsim</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($emergencyFullName) . '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Yakınlık</label>
                            <p class="shadcn-info-value">' . htmlspecialchars($emergencyRelationship) . '</p>
                        </div>
                        
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Telefon</label>
                            <p class="shadcn-info-value">';

if (!empty($emergencyPhone)) {
    $content .= '<a href="tel:' . htmlspecialchars($emergencyPhone) . '" class="text-blue-600 hover:underline">' . htmlspecialchars($emergencyPhone) . '</a>';
} else {
    $content .= '-';
}

$content .= '</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Status Card -->
            <div class="shadcn-card">
                <div class="shadcn-card-header">
                    <h3 class="shadcn-card-title">Kayıt Durumu</h3>
                </div>
                <div class="shadcn-card-content">
                    <div class="text-center py-4">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-' . ($currentStatus['class'] === 'success' ? 'green' : ($currentStatus['class'] === 'danger' ? 'red' : 'yellow')) . '-100 border border-' . ($currentStatus['class'] === 'success' ? 'green' : ($currentStatus['class'] === 'danger' ? 'red' : 'yellow')) . '-300">
                            <svg class="w-5 h-5 text-' . ($currentStatus['class'] === 'success' ? 'green' : ($currentStatus['class'] === 'danger' ? 'red' : 'yellow')) . '-700" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="6"></circle>
                            </svg>
                            <span class="font-semibold text-' . ($currentStatus['class'] === 'success' ? 'green' : ($currentStatus['class'] === 'danger' ? 'red' : 'yellow')) . '-800">' . $currentStatus['text'] . '</span>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mt-4">
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Kayıt Tarihi</label>
                            <p class="shadcn-info-value">' . (!empty($createdAt) ? date('d.m.Y H:i', strtotime($createdAt)) : '-') . '</p>
                        </div>';

if (!empty($updatedAt)) {
    $content .= '
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Son Güncelleme</label>
                            <p class="shadcn-info-value">' . date('d.m.Y H:i', strtotime($updatedAt)) . '</p>
                        </div>';
}

if (!empty($adminNotes)) {
    $content .= '
                        <div class="shadcn-info-item">
                            <label class="shadcn-info-label">Admin Notları</label>
                            <p class="shadcn-info-value text-sm">' . htmlspecialchars($adminNotes) . '</p>
                        </div>';
}

$content .= '
                    </div>
                </div>
            </div>';

// Photo Card
if (!empty($photoPath)) {
    $content .= '
            <div class="shadcn-card">
                <div class="shadcn-card-header">
                    <h3 class="shadcn-card-title">Öğrenci Fotoğrafı</h3>
                </div>
                <div class="shadcn-card-content">
                    <div class="text-center">
                        <img src="' . BASE_URL . htmlspecialchars($photoPath) . '" 
                             alt="Öğrenci Fotoğrafı" 
                             class="rounded-lg shadow-md max-w-full h-auto"
                             style="max-height: 400px;">
                    </div>
                </div>
            </div>';
}

$content .= '
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #18181b 0%, #27272a 100%); color: white; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Kayıt Durumunu Güncelle
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.9;">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" action="' . BASE_URL . '/admin/youth-registrations/updateStatus">
                <div class="modal-body" style="padding: 2rem;">
                    <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                    <input type="hidden" name="id" value="' . $registration['id'] . '">
                    
                    <div class="shadcn-form-group">
                        <label class="shadcn-label">Durum</label>
                        <select name="status" class="shadcn-select" required>
                            <option value="pending"' . ($status === 'pending' ? ' selected' : '') . '>Beklemede</option>
                            <option value="approved"' . ($status === 'approved' ? ' selected' : '') . '>Onaylandı</option>
                            <option value="rejected"' . ($status === 'rejected' ? ' selected' : '') . '>Reddedildi</option>
                        </select>
                    </div>
                    
                    <div class="shadcn-form-group">
                        <label class="shadcn-label">Notlar (Opsiyonel)</label>
                        <textarea name="notes" class="shadcn-input" rows="4" style="resize: vertical;">' . htmlspecialchars($adminNotes) . '</textarea>
                    </div>
                </div>
                <div class="modal-footer" style="background: #fafafa; border-top: 1px solid #e4e4e7;">
                    <button type="button" class="shadcn-btn shadcn-btn-outline" data-dismiss="modal">İptal</button>
                    <button type="submit" class="shadcn-btn shadcn-btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showStatusModal() {
    $("#statusModal").modal("show");
}
</script>';

include BASE_PATH . '/app/views/admin/layout.php';
?>