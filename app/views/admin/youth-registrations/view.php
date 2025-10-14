<?php
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
                    <p><strong>' . htmlspecialchars($registration['student']['first_name'] . ' ' . $registration['student']['last_name']) . '</strong></p>
                </div>
                
                <div class="info-group">
                    <label>TC Kimlik No:</label>
                    <p>' . htmlspecialchars($registration['student']['tc_number']) . '</p>
                </div>
                
                <div class="info-group">
                    <label>Doğum Tarihi:</label>
                    <p>' . date('d.m.Y', strtotime($registration['student']['birth_date'])) . '</p>
                </div>
                
                <div class="info-group">
                    <label>Yaş:</label>';
                    
$birthDate = new DateTime($registration['student']['birth_date']);
$today = new DateTime();
$age = $today->diff($birthDate)->y;

$content .= '
                    <p>' . $age . ' yaş</p>
                </div>
                
                <div class="info-group">
                    <label>Cinsiyet:</label>
                    <p>' . ($registration['student']['gender'] === 'male' ? 'Erkek' : 'Kadın') . '</p>
                </div>
                
                <div class="info-group">
                    <label>Okul:</label>
                    <p>' . htmlspecialchars($registration['student']['school']) . '</p>
                </div>
                
                <div class="info-group">
                    <label>Sınıf:</label>
                    <p>' . htmlspecialchars($registration['student']['grade']) . '</p>
                </div>';

if (!empty($registration['student']['medical_conditions'])) {
    $content .= '
                <div class="info-group">
                    <label>Sağlık Durumu:</label>
                    <p>' . htmlspecialchars($registration['student']['medical_conditions']) . '</p>
                </div>';
}

if (!empty($registration['student']['allergies'])) {
    $content .= '
                <div class="info-group">
                    <label>Alerjiler:</label>
                    <p>' . htmlspecialchars($registration['student']['allergies']) . '</p>
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
                    <p><strong>' . htmlspecialchars($registration['parent']['first_name'] . ' ' . $registration['parent']['last_name']) . '</strong></p>
                </div>
                
                <div class="info-group">
                    <label>TC Kimlik No:</label>
                    <p>' . htmlspecialchars($registration['parent']['tc_number']) . '</p>
                </div>
                
                <div class="info-group">
                    <label>Telefon:</label>
                    <p><a href="tel:' . htmlspecialchars($registration['parent']['phone']) . '">' . htmlspecialchars($registration['parent']['phone']) . '</a></p>
                </div>
                
                <div class="info-group">
                    <label>E-posta:</label>
                    <p><a href="mailto:' . htmlspecialchars($registration['parent']['email']) . '">' . htmlspecialchars($registration['parent']['email']) . '</a></p>
                </div>
                
                <div class="info-group">
                    <label>Adres:</label>
                    <p>' . htmlspecialchars($registration['parent']['address']) . '</p>
                </div>
                
                <div class="info-group">
                    <label>Yakınlık:</label>
                    <p>' . htmlspecialchars($registration['parent']['relationship']) . '</p>
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
                    <p><strong>' . htmlspecialchars($registration['emergency']['first_name'] . ' ' . $registration['emergency']['last_name']) . '</strong></p>
                </div>
                
                <div class="info-group">
                    <label>Telefon:</label>
                    <p><a href="tel:' . htmlspecialchars($registration['emergency']['phone']) . '">' . htmlspecialchars($registration['emergency']['phone']) . '</a></p>
                </div>
                
                <div class="info-group">
                    <label>Yakınlık:</label>
                    <p>' . htmlspecialchars($registration['emergency']['relationship']) . '</p>
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
                    <p>' . date('d.m.Y H:i', strtotime($registration['created_at'])) . '</p>
                </div>';

if (!empty($registration['updated_at'])) {
    $content .= '
                <div class="info-group">
                    <label>Son Güncelleme:</label>
                    <p>' . date('d.m.Y H:i', strtotime($registration['updated_at'])) . '</p>
                </div>';
}

if (!empty($registration['admin_notes'])) {
    $content .= '
                <div class="info-group">
                    <label>Admin Notları:</label>
                    <p>' . htmlspecialchars($registration['admin_notes']) . '</p>
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
if (!empty($registration['photo_path'])) {
    $content .= '
<div class="row mt-4">
    <div class="col-md-12">
        <div class="admin-content-card">
            <div class="card-header">
                <h3><i class="fas fa-image"></i> Öğrenci Fotoğrafı</h3>
            </div>
            <div class="card-body text-center">
                <img src="' . BASE_URL . htmlspecialchars($registration['photo_path']) . '" 
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
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kayıt Durumunu Güncelle</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" action="' . BASE_URL . '/admin/youth-registrations/updateStatus">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="' . $csrf_token . '">
                    <input type="hidden" name="id" id="statusRegistrationId">
                    
                    <div class="form-group">
                        <label for="status">Durum:</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="pending">Beklemede</option>
                            <option value="approved">Onaylandı</option>
                            <option value="rejected">Reddedildi</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes">Notlar (Opsiyonel):</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" 
                                  placeholder="Durum değişikliği ile ilgili notlarınızı buraya yazabilirsiniz..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-admin-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

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