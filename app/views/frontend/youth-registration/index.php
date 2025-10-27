<?php
$title = 'Alt Yapı Kayıt Formu';
$content = '
<div class="youth-registration-page">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title"><i class="fas fa-user-plus me-3"></i>Alt Yapı Kayıt Formu</h1>
            <p class="page-subtitle">Geleceğin yıldızları için kayıt başvurusu</p>
        </div>
    </div>

    <div class="container">
        <div class="registration-form-container">';

// Hata mesajları
if (isset($_SESSION['form_errors']) && !empty($_SESSION['form_errors'])) {
    $content .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i> Lütfen aşağıdaki hataları düzeltin:
        <ul class="mb-0">';
    foreach ($_SESSION['form_errors'] as $error) {
        $content .= '<li>' . htmlspecialchars($error) . '</li>';
    }
    $content .= '</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    unset($_SESSION['form_errors']);
}

if (isset($_SESSION['error_messages'])) {
    $content .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i> Lütfen aşağıdaki hataları düzeltin:
        <ul class="mb-0">';
    foreach ($_SESSION['error_messages'] as $error) {
        $content .= '<li>' . htmlspecialchars($error) . '</li>';
    }
    $content .= '</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    unset($_SESSION['error_messages']);
}

$content .= '
            <form id="youthRegistrationForm" method="POST" action="' . BASE_URL . '/youth-registration/submit" enctype="multipart/form-data">
                
                <!-- CSRF Token for security -->
                <input type="hidden" name="csrf_token" value="' . (isset($csrf_token) ? $csrf_token : '') . '">
                
                <!-- Honeypot field for bot protection (hidden from users) -->
                <div style="position: absolute; left: -5000px;" aria-hidden="true">
                    <input type="text" name="website" tabindex="-1" autocomplete="off" value="" placeholder="Leave this field empty">
                </div>
                
                <!-- Öğrenci Bilgileri Bölümü -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-user"></i>
                            Öğrenci Bilgileri
                        </h3>
                        <p class="section-description">Öğrenciye ait temel bilgileri doldurunuz</p>
                    </div>
                    
                    <!-- İlk Satır: Ad Soyad, Doğum Yeri, Doğum Tarihi -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="student_name" class="form-label required">Adı Soyadı</label>
                            <input type="text" class="form-control" id="student_name" name="student_name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="birth_place" class="form-label required">Doğum Yeri</label>
                            <input type="text" class="form-control" id="birth_place" name="birth_place" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="birth_date" class="form-label required">Doğum Tarihi</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                        </div>
                    </div>
                    
                    <!-- İkinci Satır: TC Kimlik No, Okul Bilgisi, Öğrenci Fotoğrafı -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tc_number" class="form-label required">TC Kimlik No</label>
                            <input type="text" class="form-control" id="tc_number" name="tc_number" maxlength="11" required>
                            <div class="form-text">11 haneli TC kimlik numaranızı giriniz</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="school_info" class="form-label required">Okul Bilgisi</label>
                            <input type="text" class="form-control" id="school_info" name="school_info" required>
                            <div class="form-text">Okuduğu okul ve sınıf bilgisi</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="student_photo" class="form-label required">Öğrenci Fotoğrafı</label>
                            <input type="file" class="form-control" id="student_photo" name="student_photo" accept="image/*" required>
                            <div class="form-text">Maksimum 5MB boyutunda olmalıdır</div>
                        </div>
                    </div>
                    
                    <!-- Üçüncü Satır: Baba Adı, Anne Adı, İlk Kulübü -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="father_name" class="form-label required">Baba Adı</label>
                            <input type="text" class="form-control" id="father_name" name="father_name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="mother_name" class="form-label required">Anne Adı</label>
                            <input type="text" class="form-control" id="mother_name" name="mother_name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="first_club" class="form-label">İlk Kulübü</label>
                            <input type="text" class="form-control" id="first_club" name="first_club">
                            <div class="form-text">Daha önce başka bir kulüpte oynadıysa belirtiniz</div>
                        </div>
                    </div>
                </div>

                <!-- Veli Bilgileri Bölümü -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-users"></i>
                            Veli Bilgileri
                        </h3>
                        <p class="section-description">Veli/vasi bilgilerini doldurunuz</p>
                    </div>
                    
                    <!-- İlk Satır: Veli Adı Soyadı, GSM Numarası, E-posta -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="parent_name" class="form-label required">Veli Adı Soyadı</label>
                            <input type="text" class="form-control" id="parent_name" name="parent_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="parent_phone" class="form-label required">GSM Numarası</label>
                            <input type="tel" class="form-control" id="parent_phone" name="parent_phone" maxlength="11" required>
                            <div class="form-text">0 olmadan 10 haneli numara giriniz</div>
                        </div>
                    </div>
                    
                    <!-- İkinci Satır: Baba Mesleği, Anne Mesleği -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="father_job" class="form-label required">Baba Mesleği</label>
                            <input type="text" class="form-control" id="father_job" name="father_job" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="mother_job" class="form-label required">Anne Mesleği</label>
                            <input type="text" class="form-control" id="mother_job" name="mother_job" required>
                        </div>
                    </div>
                    
                    <!-- Üçüncü Satır: İkametgah Adresi -->
                    <div class="mb-3">
                        <label for="address" class="form-label required">İkametgah Adresi</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                </div>

                <!-- Acil Durum Bilgileri -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-phone-alt"></i>
                            Acil Durum İletişim Bilgileri
                        </h3>
                        <p class="section-description">Acil durumlarda aranacak kişi bilgileri</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="emergency_contact" class="form-label required">Acil Durumda Aranacak Kişi</label>
                            <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="emergency_relation" class="form-label required">Yakınlık Derecesi</label>
                            <select class="form-select" id="emergency_relation" name="emergency_relation" required>
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
                        <div class="col-md-4 mb-3">
                            <label for="emergency_phone" class="form-label required">Acil Durum GSM</label>
                            <input type="tel" class="form-control" id="emergency_phone" name="emergency_phone" maxlength="11" required>
                        </div>
                    </div>
                </div>

                <!-- Math CAPTCHA for additional security -->
                <div class="form-section" style="background: #fff3cd; border-left: 4px solid #ffc107;">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-shield-alt"></i>
                            Güvenlik Doğrulaması
                        </h3>
                        <p class="section-description">Lütfen aşağıdaki matematik sorusunu cevaplayın</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">';

// Generate random math question
$num1 = rand(1, 10);
$num2 = rand(1, 10);
$operations = ['+', '-'];
$operation = $operations[array_rand($operations)];

if ($operation === '-' && $num1 < $num2) {
    // Ensure no negative results
    $temp = $num1;
    $num1 = $num2;
    $num2 = $temp;
}

$answer = ($operation === '+') ? ($num1 + $num2) : ($num1 - $num2);

// Store answer in session
$_SESSION['captcha_answer'] = $answer;

$content .= '
                            <label for="captcha_answer" class="form-label required">
                                <strong style="font-size: 1.2em;">' . $num1 . ' ' . $operation . ' ' . $num2 . ' = ?</strong>
                            </label>
                            <input type="number" class="form-control" id="captcha_answer" name="captcha_answer" required 
                                   placeholder="Cevabı giriniz" min="0" max="20" style="max-width: 150px; font-size: 1.1em;">
                            <div class="form-text"><i class="fas fa-info-circle"></i> Robot olmadığınızı doğrulayın</div>
                        </div>
                    </div>
                </div>

                <!-- Form Butonları -->
                <div class="form-actions text-center">
                    <button type="submit" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-paper-plane"></i> Başvuruyu Gönder
                    </button>
                    <button type="reset" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-undo"></i> Formu Temizle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="fas fa-check-circle me-2"></i>Başvuru Başarılı!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h4 class="mb-3">Teşekkür Ederiz!</h4>
                <p class="lead mb-2">Başvurunuz başarıyla alındı.</p>
                <p class="text-muted">En kısa sürede sizinle iletişime geçilecektir.</p>
                <hr class="my-4">
                <p class="small text-muted mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    Başvuru durumunuzu takip etmek için size telefon ile ulaşılacaktır.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Kapat
                </button>
            </div>
        </div>
    </div>
</div>';

include BASE_PATH . '/app/views/frontend/layout.php';
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("youthRegistrationForm");
    
    // Show success modal if redirected with success parameter
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === '1') {
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        
        // Remove success parameter from URL after showing modal
        setTimeout(function() {
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        }, 500);
    }
    
    // TC Kimlik No validation
    const tcInput = document.getElementById("tc_number");
    tcInput.addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9]/g, "");
        if (this.value.length > 11) {
            this.value = this.value.slice(0, 11);
        }
    });
    
    // Phone number validation
    const phoneInputs = document.querySelectorAll("input[type=tel]");
    phoneInputs.forEach(function(input) {
        input.addEventListener("input", function() {
            this.value = this.value.replace(/[^0-9]/g, "");
            if (this.value.length > 11) {
                this.value = this.value.slice(0, 11);
            }
        });
    });
    
    // File size validation
    const photoInput = document.getElementById("student_photo");
    photoInput.addEventListener("change", function() {
        const file = this.files[0];
        if (file && file.size > 5 * 1024 * 1024) {
            alert("Fotoğraf boyutu 5MB dan küçük olmalıdır.");
            this.value = "";
        }
    });
    
    // Form submission validation
    form.addEventListener("submit", function(e) {
        const requiredFields = form.querySelectorAll("[required]");
        let isValid = true;
        
        requiredFields.forEach(function(field) {
            if (!field.value.trim()) {
                field.classList.add("is-invalid");
                isValid = false;
            } else {
                field.classList.remove("is-invalid");
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert("Lütfen tüm zorunlu alanları doldurunuz.");
        }
    });
});
</script>