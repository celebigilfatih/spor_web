<?php

class YouthRegistration extends Controller {
    
    public function index() {
        // Generate CSRF token
        $csrfToken = $this->generateCSRFToken();
        
        // Load youth groups for selection
        $youthGroupModel = $this->model('YouthGroup');
        $youthGroups = $youthGroupModel->getActive();
        
        $data = [
            'title' => 'Alt Yapı Kayıt Formu',
            'page' => 'youth-registration',
            'youth_groups' => $youthGroups,
            'csrf_token' => $csrfToken,
            'success' => isset($_GET['success']) ? true : false,
            'errors' => $_SESSION['form_errors'] ?? []
        ];
        
        // Clear session errors after displaying
        unset($_SESSION['form_errors']);
        
        $this->view('frontend/youth-registration/index', $data);
    }
    
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            
            // 1. CSRF Token Validation
            $csrfToken = $_POST['csrf_token'] ?? '';
            if (!$this->validateCSRFToken($csrfToken)) {
                $errors[] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
                $_SESSION['form_errors'] = $errors;
                $this->redirect('youth-registration');
                return;
            }
            
            // 2. Honeypot Validation (Bot Protection)
            if (!$this->validateHoneypot('website')) {
                // Bot detected - silently reject
                error_log('Bot detected in youth registration form from IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
                $this->redirect('youth-registration?success=1'); // Fake success to confuse bots
                return;
            }
            
            // 3. Rate Limiting
            $rateLimitCheck = $this->checkRateLimit('youth_registration', 3, 1800); // 3 attempts per 30 minutes
            if (is_array($rateLimitCheck) && !$rateLimitCheck['allowed']) {
                $errors[] = $rateLimitCheck['message'];
                $_SESSION['form_errors'] = $errors;
                $this->redirect('youth-registration');
                return;
            }
            
            // 4. Sanitize and collect form data
            $studentData = [
                'full_name' => $this->sanitizeInputAdvanced($_POST['student_name'] ?? '', 'text'),
                'youth_group_id' => $this->sanitizeInputAdvanced($_POST['youth_group_id'] ?? '', 'number'),
                'first_club' => $this->sanitizeInputAdvanced($_POST['first_club'] ?? '', 'text'),
                'birth_date' => $this->sanitizeInputAdvanced($_POST['birth_date'] ?? '', 'text'),
                'birth_place' => $this->sanitizeInputAdvanced($_POST['birth_place'] ?? '', 'text'),
                'tc_number' => $this->sanitizeInputAdvanced($_POST['tc_number'] ?? '', 'number'),
                'father_name' => $this->sanitizeInputAdvanced($_POST['father_name'] ?? '', 'text'),
                'mother_name' => $this->sanitizeInputAdvanced($_POST['mother_name'] ?? '', 'text'),
                'school_info' => $this->sanitizeInputAdvanced($_POST['school_info'] ?? '', 'text'),
                'student_photo' => $_FILES['student_photo'] ?? null
            ];
            
            $parentData = [
                'parent_name' => $this->sanitizeInputAdvanced($_POST['parent_name'] ?? '', 'text'),
                'parent_phone' => $this->sanitizeInputAdvanced($_POST['parent_phone'] ?? '', 'phone'),
                'address' => $this->sanitizeInputAdvanced($_POST['address'] ?? '', 'text'),
                'email' => $this->sanitizeInputAdvanced($_POST['email'] ?? '', 'email'),
                'father_job' => $this->sanitizeInputAdvanced($_POST['father_job'] ?? '', 'text'),
                'mother_job' => $this->sanitizeInputAdvanced($_POST['mother_job'] ?? '', 'text'),
                'emergency_contact_name' => $this->sanitizeInputAdvanced($_POST['emergency_contact'] ?? '', 'text'),
                'emergency_contact_relation' => $this->sanitizeInputAdvanced($_POST['emergency_relation'] ?? '', 'text'),
                'emergency_contact_phone' => $this->sanitizeInputAdvanced($_POST['emergency_phone'] ?? '', 'phone')
            ];
            
            // 5. Validation
            $validationErrors = $this->validateForm($studentData, $parentData);
            
            if (!empty($validationErrors)) {
                $_SESSION['form_errors'] = $validationErrors;
                $_SESSION['form_data'] = array_merge($studentData, $parentData);
                $this->redirect('youth-registration');
                return;
            }
            
            // 6. Process photo upload
            $photoPath = $this->uploadPhoto($studentData['student_photo']);
            
            if ($photoPath) {
                $studentData['photo_path'] = $photoPath;
                
                // 7. Save registration
                $this->saveRegistration($studentData, $parentData);
                
                // Clear form data from session
                unset($_SESSION['form_data']);
                
                // Success redirect
                $this->redirect('youth-registration?success=1');
            } else {
                $errors[] = 'Fotoğraf yüklenirken bir hata oluştu.';
                $_SESSION['form_errors'] = $errors;
                $_SESSION['form_data'] = array_merge($studentData, $parentData);
                $this->redirect('youth-registration');
            }
        } else {
            $this->redirect('youth-registration');
        }
    }
    
    private function validateForm($studentData, $parentData) {
        $errors = [];
        
        // Öğrenci bilgileri validasyonu
        if (empty($studentData['full_name']) || strlen($studentData['full_name']) < 3) {
            $errors[] = 'Öğrenci adı soyadı en az 3 karakter olmalıdır.';
        }
        
        if (empty($studentData['birth_date'])) {
            $errors[] = 'Doğum tarihi zorunludur.';
        } else {
            // Yaş kontrolü (6-21 yaş aralığı)
            $birthDate = new DateTime($studentData['birth_date']);
            $today = new DateTime();
            $age = $today->diff($birthDate)->y;
            
            if ($age < 6 || $age > 21) {
                $errors[] = 'Yaş 6-21 aralığında olmalıdır.';
            }
        }
        
        if (empty($studentData['birth_place']) || strlen($studentData['birth_place']) < 2) {
            $errors[] = 'Doğum yeri zorunludur.';
        }
        
        // TC Kimlik No validasyonu
        $tcNumber = preg_replace('/[^0-9]/', '', $studentData['tc_number']);
        if (strlen($tcNumber) !== 11 || !$this->validateTCKN($tcNumber)) {
            $errors[] = 'Geçerli bir TC Kimlik No giriniz (11 haneli).';
        }
        
        if (empty($studentData['father_name']) || strlen($studentData['father_name']) < 3) {
            $errors[] = 'Baba adı en az 3 karakter olmalıdır.';
        }
        
        if (empty($studentData['mother_name']) || strlen($studentData['mother_name']) < 3) {
            $errors[] = 'Anne adı en az 3 karakter olmalıdır.';
        }
        
        if (empty($studentData['school_info']) || strlen($studentData['school_info']) < 3) {
            $errors[] = 'Okul bilgisi zorunludur.';
        }
        
        if (empty($studentData['student_photo']['name'])) {
            $errors[] = 'Öğrenci fotoğrafı zorunludur.';
        }
        
        // Veli bilgileri validasyonu
        if (empty($parentData['parent_name']) || strlen($parentData['parent_name']) < 3) {
            $errors[] = 'Veli adı soyadı en az 3 karakter olmalıdır.';
        }
        
        if (!$this->validatePhone($parentData['parent_phone'])) {
            $errors[] = 'Geçerli bir GSM numarası giriniz (10-11 hane).';
        }
        
        if (empty($parentData['address']) || strlen($parentData['address']) < 10) {
            $errors[] = 'İkametgah adresi en az 10 karakter olmalıdır.';
        }
        
        if (!$this->validateEmail($parentData['email'])) {
            $errors[] = 'Geçerli bir e-posta adresi giriniz.';
        }
        
        if (empty($parentData['father_job']) || strlen($parentData['father_job']) < 2) {
            $errors[] = 'Baba mesleği zorunludur.';
        }
        
        if (empty($parentData['mother_job']) || strlen($parentData['mother_job']) < 2) {
            $errors[] = 'Anne mesleği zorunludur.';
        }
        
        if (empty($parentData['emergency_contact_name']) || strlen($parentData['emergency_contact_name']) < 3) {
            $errors[] = 'Acil durumda aranacak kişi adı en az 3 karakter olmalıdır.';
        }
        
        if (empty($parentData['emergency_contact_relation'])) {
            $errors[] = 'Acil durumda aranacak kişinin yakınlık derecesi zorunludur.';
        }
        
        if (!$this->validatePhone($parentData['emergency_contact_phone'])) {
            $errors[] = 'Acil durumda aranacak kişinin telefon numarası geçersiz.';
        }
        
        return $errors;
    }
    
    /**
     * TC Kimlik No algoritması ile doğrulama
     */
    private function validateTCKN($tckn) {
        if (strlen($tckn) != 11) return false;
        if ($tckn[0] == '0') return false;
        
        $odd = $tckn[0] + $tckn[2] + $tckn[4] + $tckn[6] + $tckn[8];
        $even = $tckn[1] + $tckn[3] + $tckn[5] + $tckn[7];
        
        $digit10 = (($odd * 7) - $even) % 10;
        $digit11 = ($odd + $even + $tckn[9]) % 10;
        
        return ($digit10 == $tckn[9] && $digit11 == $tckn[10]);
    }
    
    private function uploadPhoto($photo) {
        if (!$photo || $photo['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!in_array($photo['type'], $allowedTypes)) {
            return false;
        }
        
        $uploadDir = 'uploads/youth-photos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileName = uniqid() . '_' . $photo['name'];
        $uploadPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($photo['tmp_name'], $uploadPath)) {
            return $uploadPath;
        }
        
        return false;
    }
    
    private function saveRegistration($studentData, $parentData) {
        // Şimdilik JSON dosyasına kaydet (gerçek uygulamada veritabanına kaydedilecek)
        $registrationData = [
            'id' => uniqid(),
            'registration_date' => date('Y-m-d H:i:s'),
            'student' => $studentData,
            'parent' => $parentData
        ];
        
        $dataFile = 'uploads/youth-registrations.json';
        $existingData = [];
        
        if (file_exists($dataFile)) {
            $existingData = json_decode(file_get_contents($dataFile), true) ?: [];
        }
        
        $existingData[] = $registrationData;
        file_put_contents($dataFile, json_encode($existingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}