<?php
// Extract data with defensive handling for both nested and flat structures
$studentFirstName = $registration['student']['first_name'] ?? '';
$studentLastName = $registration['student']['last_name'] ?? '';
$studentName = $registration['student_name'] ?? '';

if (empty($studentFirstName) && !empty($studentName)) {
    // Flat structure - split the name
    $nameParts = explode(' ', $studentName, 2);
    $studentFirstName = $nameParts[0] ?? '';
    $studentLastName = $nameParts[1] ?? '';
}

$studentFullName = trim($studentFirstName . ' ' . $studentLastName);
$studentTC = $registration['student']['tc_number'] ?? $registration['student_tc'] ?? '';
$studentBirthDate = $registration['student']['birth_date'] ?? $registration['student_birth_date'] ?? '';
$studentGender = $registration['student']['gender'] ?? $registration['student_gender'] ?? '';
$studentSchool = $registration['student']['school'] ?? $registration['student_school'] ?? '';
$studentGrade = $registration['student']['grade'] ?? $registration['student_grade'] ?? '';
$studentMedical = $registration['student']['medical_conditions'] ?? $registration['medical_conditions'] ?? '';
$studentAllergies = $registration['student']['allergies'] ?? $registration['allergies'] ?? '';

// Parent data
$parentFirstName = $registration['parent']['first_name'] ?? '';
$parentLastName = $registration['parent']['last_name'] ?? '';
$parentName = $registration['parent_name'] ?? '';

if (empty($parentFirstName) && !empty($parentName)) {
    $nameParts = explode(' ', $parentName, 2);
    $parentFirstName = $nameParts[0] ?? '';
    $parentLastName = $nameParts[1] ?? '';
}

$parentFullName = trim($parentFirstName . ' ' . $parentLastName);
$parentTC = $registration['parent']['tc_number'] ?? $registration['parent_tc'] ?? '';
$parentPhone = $registration['parent']['phone'] ?? $registration['parent_phone'] ?? '';
$parentEmail = $registration['parent']['email'] ?? $registration['parent_email'] ?? '';
$parentAddress = $registration['parent']['address'] ?? $registration['parent_address'] ?? '';
$parentRelationship = $registration['parent']['relationship'] ?? $registration['parent_relationship'] ?? '';

// Emergency contact data
$emergencyFirstName = $registration['emergency']['first_name'] ?? '';
$emergencyLastName = $registration['emergency']['last_name'] ?? '';
$emergencyName = $registration['emergency_contact_name'] ?? '';

if (empty($emergencyFirstName) && !empty($emergencyName)) {
    $nameParts = explode(' ', $emergencyName, 2);
    $emergencyFirstName = $nameParts[0] ?? '';
    $emergencyLastName = $nameParts[1] ?? '';
}

$emergencyFullName = trim($emergencyFirstName . ' ' . $emergencyLastName);
$emergencyPhone = $registration['emergency']['phone'] ?? $registration['emergency_contact_phone'] ?? '';
$emergencyRelationship = $registration['emergency']['relationship'] ?? $registration['emergency_contact_relationship'] ?? '';

// Registration data
$createdAt = $registration['created_at'] ?? $registration['registration_date'] ?? '';
$updatedAt = $registration['updated_at'] ?? '';
$adminNotes = $registration['admin_notes'] ?? '';
$photoPath = $registration['photo_path'] ?? '';

$content = '
<div class="admin-page-header">
    <h1><i class="fas fa-user"></i> Kayıt Detayları</h1>
    <div class="admin-page-actions">
        <a href="' . BASE_URL . '/admin/youth-registrations" class="btn btn-admin-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>
</div>

<div class="row">
    <!-- Öğrenci Bilgileri -->
    <div class="col-md-6">
        <div class="admin-content-card">
            <div class="card-header">
                <h3><i class="fas fa-user"></i> Öğrenci Bilgileri</h3>
            </div>
            <div class="card-body">
                <div class="info-group">
                    <label>Ad Soyad:</label>
                    <p><strong>' . htmlspecialchars($studentFullName) . '</strong></p>
                </div>
                
                <div class="info-group">
                    <label>TC Kimlik No:</label>
                    <p>' . htmlspecialchars($studentTC) . '</p>
                </div>
                
                <div class="info-group">
                    <label>Doğum Tarihi:</label>
                    <p>' . (!empty($studentBirthDate) ? date('d.m.Y', strtotime($studentBirthDate)) : '-') . '</p>
                </div>
                
                <div class="info-group">
                    <label>Yaş:</label>';
                    
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

$content .= '
                    <p>' . ($age ? $age . ' yaş' : '-') . '</p>
                </div>
                
                <div class="info-group">
                    <label>Cinsiyet:</label>
                    <p>' . (!empty($studentGender) ? ($studentGender === 'male' || $studentGender === 'Erkek' ? 'Erkek' : 'Kadın') : '-') . '</p>
                </div>
                
                <div class="info-group">
                    <label>Okul:</label>
                    <p>' . htmlspecialchars($studentSchool) . '</p>
                </div>
                
                <div class="info-group">
                    <label>Sınıf:</label>
                    <p>' . htmlspecialchars($studentGrade) . '</p>
                </div>';

if (!empty($studentMedical)) {
    $content .= '
                <div class="info-group">
                    <label>Sağlık Durumu:</label>
                    <p>' . htmlspecialchars($studentMedical) . '</p>
                </div>';
}

if (!empty($studentAllergies)) {
    $content .= '
                <div class="info-group">
                    <label>Alerjiler:</label>
                    <p>' . htmlspecialchars($studentAllergies) . '</p>
                </div>';
}

$content .= '
            </div>
        </div>
    </div>
    
    <!-- Veli Bilgileri -->
    <div class="col-md-6">
        <div class="admin-content-card">
            <div class="card-header">
                <h3><i class="fas fa-user-tie"></i> Veli Bilgileri</h3>
            </div>
            <div class="card-body">
                <div class="info-group">
                    <label>Ad Soyad:</label>
                    <p><strong>' . htmlspecialchars($parentFullName) . '</strong></p>
                </div>
                
                <div class="info-group">
                    <label>TC Kimlik No:</label>
                    <p>' . htmlspecialchars($parentTC) . '</p>
                </div>
                
                <div class="info-group">
                    <label>Telefon:</label>
                    <p>' . (!empty($parentPhone) ? '<a href="tel:' . htmlspecialchars($parentPhone) . '">' . htmlspecialchars($parentPhone) . '</a>' : '-') . '</p>
                </div>
                
                <div class="info-group">
                    <label>E-posta:</label>
                    <p>' . (!empty($parentEmail) ? '<a href="mailto:' . htmlspecialchars($parentEmail) . '">' . htmlspecialchars($parentEmail) . '</a>' : '-') . '</p>
                </div>
                
                <div class="info-group">
                    <label>Adres:</label>
                    <p>' . htmlspecialchars($parentAddress) . '</p>
                </div>
                
                <div class="info-group">
                    <label>Yakınlık:</label>
                    <p>' . htmlspecialchars($parentRelationship) . '</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Acil Durum İletişim -->
    <div class="col-md-6">
        <div class="admin-content-card">
            <div class="card-header">
                <h3><i class="fas fa-phone"></i> Acil Durum İletişim</h3>
            </div>
            <div class="card-body">
                <div class="info-group">
                    <label>Ad Soyad:</label>
                    <p><strong>' . htmlspecialchars($emergencyFullName) . '</strong></p>
                </div>
                
                <div class="info-group">
                    <label>Telefon:</label>
                    <p>' . (!empty($emergencyPhone) ? '<a href="tel:' . htmlspecialchars($emergencyPhone) . '">' . htmlspecialchars($emergencyPhone) . '</a>' : '-') . '</p>
                </div>
                
                <div class="info-group">
                    <label>Yakınlık:</label>
                    <p>' . htmlspecialchars($emergencyRelationship) . '</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kayıt Durumu ve Notlar -->
    <div class="col-md-6">
        <div class="admin-content-card">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Kayıt Durumu</h3>
            </div>
            <div class="card-body">
                <div class="info-group">
                    <label>Durum:</label>';

$status = $registration['status'] ?? 'pending';
$statusClass = '';
$statusText = '';
$statusIcon = '';

switch ($status) {
    case 'approved':
        $statusClass = 'success';
        $statusText = 'ONAYLANDI';
        $statusIcon = 'check-circle';
        break;
    case 'rejected':
        $statusClass = 'danger';
        $statusText = 'REDDEDİLDİ';
        $statusIcon = 'times-circle';
        break;
    default:
        $statusClass = 'warning';
        $statusText = 'BEKLEMEDE';
        $statusIcon = 'clock';
}

$content .= '
                    <p>
                        <span class="status-badge status-' . $statusClass . '">
                            <i class="fas fa-' . $statusIcon . '"></i>
                            ' . $statusText . '
                        </span>
                    </p>
                </div>
                
                <div class="info-group">
                    <label>Kayıt Tarihi:</label>
                    <p>' . (!empty($createdAt) ? date('d.m.Y H:i', strtotime($createdAt)) : '-') . '</p>
                </div>';

if (!empty($updatedAt)) {
    $content .= '
                <div class="info-group">
                    <label>Son Güncelleme:</label>
                    <p>' . date('d.m.Y H:i', strtotime($updatedAt)) . '</p>
                </div>';
}

if (!empty($adminNotes)) {
    $content .= '
                <div class="info-group">
                    <label>Admin Notları:</label>
                    <p>' . htmlspecialchars($adminNotes) . '</p>
                </div>';
}

$content .= '
                <div class="mt-3">
                    <button type="button" class="btn btn-admin-warning" 
                            onclick="showStatusModal(\'' . $registration['id'] . '\', \'' . $status . '\')">
                        <i class="fas fa-edit"></i> Durumu Güncelle
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>';

// Fotoğraf varsa göster
if (!empty($photoPath)) {
    $content .= '
<div class="row mt-4">
    <div class="col-md-12">
        <div class="admin-content-card">
            <div class="card-header">
                <h3><i class="fas fa-image"></i> Öğrenci Fotoğrafı</h3>
            </div>
            <div class="card-body text-center">
                <img src="' . BASE_URL . htmlspecialchars($photoPath) . '" 
                     alt="Öğrenci Fotoğrafı" 
                     class="img-fluid rounded" 
                     style="max-width: 300px; max-height: 400px;">
            </div>
        </div>
    </div>
</div>';
}

$content .= '
<!-- Durum Güncelleme Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modern-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">
                    <i class="fas fa-edit"></i> Kayıt Durumunu Güncelle
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="' . BASE_URL . '/admin/youth-registrations/updateStatus">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                    <input type="hidden" name="id" id="statusRegistrationId">
                    
                    <div class="form-group">
                        <label for="status" class="form-label-modern">
                            <i class="fas fa-toggle-on"></i> Durum
                        </label>
                        <select name="status" id="status" class="form-control form-control-modern" required>
                            <option value="pending">⏳ Beklemede</option>
                            <option value="approved">✅ Onaylandı</option>
                            <option value="rejected">❌ Reddedildi</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes" class="form-label-modern">
                            <i class="fas fa-sticky-note"></i> Notlar (Opsiyonel)
                        </label>
                        <textarea name="notes" id="notes" class="form-control form-control-modern" rows="4" 
                                  placeholder="Durum değişikliği ile ilgili notlarınızı buraya yazabilirsiniz..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> İptal
                    </button>
                    <button type="submit" class="btn btn-admin-primary">
                        <i class="fas fa-save"></i> Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Modern Modal Styles */
.modal {
    z-index: 9999;
}

.modal-backdrop {
    z-index: 9998;
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: calc(100% - 1rem);
}

.modern-modal {
    border-radius: 16px;
    border: none;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.modern-modal .modal-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 1.5rem;
    border-bottom: none;
}

.modern-modal .modal-header .modal-title {
    font-weight: 700;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modern-modal .modal-header .close {
    color: white;
    opacity: 0.9;
    text-shadow: none;
    font-size: 1.5rem;
    font-weight: 300;
}

.modern-modal .modal-header .close:hover {
    opacity: 1;
}

.modern-modal .modal-body {
    padding: 2rem;
}

.modern-modal .modal-footer {
    padding: 1.5rem;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.form-label-modern {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.form-control-modern {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.form-control-modern:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

/* Modal Animation */
.modal.fade .modal-dialog {
    transform: scale(0.8);
    opacity: 0;
    transition: all 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: scale(1);
    opacity: 1;
}

/* Info Groups Styling */
.info-group {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e2e8f0;
}

.info-group:last-child {
    border-bottom: none;
}

.info-group label {
    font-weight: 600;
    color: #64748b;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
    display: block;
}

.info-group p {
    color: #1e293b;
    font-size: 1rem;
    margin: 0;
}

.info-group p strong {
    font-weight: 700;
    font-size: 1.1rem;
}

.card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 2px solid #e2e8f0;
    padding: 1.25rem 1.5rem;
}

.card-header h3 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-header h3 i {
    color: #3b82f6;
}

.card-body {
    padding: 1.5rem;
}

.admin-content-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
    margin-bottom: 1.5rem;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -0.75rem;
}

.col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
    padding: 0 0.75rem;
    margin-bottom: 1.5rem;
}

.col-md-12 {
    flex: 0 0 100%;
    max-width: 100%;
    padding: 0 0.75rem;
}

.mt-3 {
    margin-top: 1rem;
}

.mt-4 {
    margin-top: 1.5rem;
}

.text-center {
    text-align: center;
}

.img-fluid {
    max-width: 100%;
    height: auto;
}

.rounded {
    border-radius: 8px;
}

@media (max-width: 768px) {
    .col-md-6, .col-md-12 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>

<script>
function showStatusModal(id, currentStatus) {
    document.getElementById("statusRegistrationId").value = id;
    document.getElementById("status").value = currentStatus;
    document.getElementById("notes").value = "";
    $("#statusModal").modal("show");
}
</script>';

include BASE_PATH . '/app/views/admin/layout.php';
?>