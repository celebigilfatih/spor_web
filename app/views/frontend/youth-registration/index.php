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

// Başarı mesajı
if (isset($_SESSION['success_message'])) {
    $content .= '<div class="alert alert-success">
        <i class="fas fa-check-circle"></i> ' . htmlspecialchars($_SESSION['success_message']) . '
    </div>';
    unset($_SESSION['success_message']);
}

// Hata mesajları
if (isset($_SESSION['error_messages'])) {
    $content .= '<div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> Lütfen aşağıdaki hataları düzeltin:
        <ul>';
    foreach ($_SESSION['error_messages'] as $error) {
        $content .= '<li>' . htmlspecialchars($error) . '</li>';
    }
    $content .= '</ul></div>';
    unset($_SESSION['error_messages']);
}

$content .= '
            <form id="youthRegistrationForm" method="POST" action="' . BASE_URL . '/youth-registration/submit" enctype="multipart/form-data">
                
                <!-- Öğrenci Bilgileri Bölümü -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-user"></i>
                            Öğrenci Bilgileri
                        </h3>
                        <p class="section-description">Öğrenciye ait temel bilgileri doldurunuz</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_name" class="form-label required">Adı Soyadı</label>
                            <input type="text" class="form-control" id="student_name" name="student_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="first_club" class="form-label">İlk Kulübü</label>
                            <input type="text" class="form-control" id="first_club" name="first_club">
                            <div class="form-text">Daha önce başka bir kulüpte oynadıysa belirtiniz</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label required">Doğum Tarihi</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="birth_place" class="form-label required">Doğum Yeri</label>
                            <input type="text" class="form-control" id="birth_place" name="birth_place" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tc_number" class="form-label required">TC Kimlik No</label>
                            <input type="text" class="form-control" id="tc_number" name="tc_number" maxlength="11" required>
                            <div class="form-text">11 haneli TC kimlik numaranızı giriniz</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="student_photo" class="form-label required">Öğrenci Fotoğrafı</label>
                            <input type="file" class="form-control" id="student_photo" name="student_photo" accept="image/*" required>
                            <div class="form-text">Maksimum 5MB boyutunda olmalıdır</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="father_name" class="form-label required">Baba Adı</label>
                            <input type="text" class="form-control" id="father_name" name="father_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="mother_name" class="form-label required">Anne Adı</label>
                            <input type="text" class="form-control" id="mother_name" name="mother_name" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="school_info" class="form-label required">Okul Bilgisi</label>
                        <input type="text" class="form-control" id="school_info" name="school_info" required>
                        <div class="form-text">Okuduğu okul ve sınıf bilgisi</div>
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
                    
                    <div class="mb-3">
                        <label for="address" class="form-label required">İkametgah Adresi</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label required">E-posta Adresi</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="father_job" class="form-label required">Baba Mesleği</label>
                            <input type="text" class="form-control" id="father_job" name="father_job" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="mother_job" class="form-label required">Anne Mesleği</label>
                        <input type="text" class="form-control" id="mother_job" name="mother_job" required>
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

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("youthRegistrationForm");
    
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
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>