<?php

class YouthRegistration extends Controller {
    
    public function index() {
        // Generate CSRF token
        $csrfToken = $this->generateCSRFToken();
        
        // Load site settings for layout
        $settingsModel = $this->model('SiteSettings');
        
        $data = [
            'title' => 'Alt Yapı Kayıt Formu',
            'page' => 'youth-registration',
            'csrf_token' => $csrfToken,
            'success' => isset($_GET['success']) ? true : false,
            'errors' => $_SESSION['form_errors'] ?? [],
            'site_settings' => $settingsModel->getAllSettings()
        ];
        
        // Clear session errors after displaying
        unset($_SESSION['form_errors']);
        
        $this->view('frontend/youth-registration/index', $data);
    }
    
    public function submit() {
        // CRITICAL DEBUG - Write to a test file to see if this method is called
        file_put_contents('/var/www/html/public/SUBMIT_CALLED.txt', 'Submit method was called at ' . date('Y-m-d H:i:s') . "\n" . print_r($_POST, true) . "\n" . print_r($_FILES, true), FILE_APPEND);
        
        // Enable error logging
        error_log('=== YOUTH REGISTRATION SUBMIT STARTED ===');
        error_log('REQUEST_METHOD: ' . $_SERVER['REQUEST_METHOD']);
        error_log('POST DATA: ' . print_r($_POST, true));
        error_log('FILES DATA: ' . print_r($_FILES, true));
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            
            // 1. CSRF Token Validation
            $csrfToken = $_POST['csrf_token'] ?? '';
            error_log('CSRF Token Check - Received: ' . substr($csrfToken, 0, 20) . '...');
            error_log('CSRF Token Check - Session: ' . substr($_SESSION['csrf_token'] ?? '', 0, 20) . '...');
            
            if (!$this->validateCSRFToken($csrfToken)) {
                error_log('CSRF VALIDATION FAILED!');
                $errors[] = 'Güvenlik hatası! Lütfen sayfayı yenileyip tekrar deneyin.';
                $_SESSION['form_errors'] = $errors;
                $this->redirect('youth-registration');
                return;
            }
            error_log('CSRF Token validated successfully');
            
            // 2. Honeypot Validation (Bot Protection)
            error_log('Checking honeypot field: website = ' . ($_POST['website'] ?? 'empty'));
            if (!$this->validateHoneypot('website')) {
                // Bot detected - silently reject
                error_log('BOT DETECTED - Honeypot filled!');
                error_log('Bot detected in youth registration form from IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
                $this->redirect('youth-registration?success=1'); // Fake success to confuse bots
                return;
            }
            error_log('Honeypot check passed');
            
            // 2.5. Math CAPTCHA Validation
            $userAnswer = (int)($_POST['captcha_answer'] ?? -1);
            $correctAnswer = (int)($_SESSION['captcha_answer'] ?? -999);
            
            error_log('CAPTCHA Check - User: ' . $userAnswer . ', Correct: ' . $correctAnswer);
            
            if ($userAnswer !== $correctAnswer) {
                error_log('CAPTCHA VALIDATION FAILED!');
                $errors[] = 'Güvenlik doğrulaması yanlış! Lütfen matematik sorusunu doğru cevaplayın.';
                $_SESSION['form_errors'] = $errors;
                $this->redirect('youth-registration');
                return;
            }
            error_log('CAPTCHA validation passed');
            // Clear used CAPTCHA
            unset($_SESSION['captcha_answer']);
            
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
                'full_name' => $this->sanitizeInput($_POST['student_name'] ?? ''),
                'first_club' => $this->sanitizeInput($_POST['first_club'] ?? ''),
                'birth_date' => $this->sanitizeInput($_POST['birth_date'] ?? ''),
                'birth_place' => $this->sanitizeInput($_POST['birth_place'] ?? ''),
                'tc_number' => preg_replace('/[^0-9]/', '', $_POST['tc_number'] ?? ''),
                'father_name' => $this->sanitizeInput($_POST['father_name'] ?? ''),
                'mother_name' => $this->sanitizeInput($_POST['mother_name'] ?? ''),
                'school_info' => $this->sanitizeInput($_POST['school_info'] ?? ''),
                'student_photo' => $_FILES['student_photo'] ?? null
            ];
            
            $parentData = [
                'parent_name' => $this->sanitizeInput($_POST['parent_name'] ?? ''),
                'parent_phone' => preg_replace('/[^0-9]/', '', $_POST['parent_phone'] ?? ''),
                'address' => $this->sanitizeInput($_POST['address'] ?? ''),
                'father_job' => $this->sanitizeInput($_POST['father_job'] ?? ''),
                'mother_job' => $this->sanitizeInput($_POST['mother_job'] ?? ''),
                'emergency_contact_name' => $this->sanitizeInput($_POST['emergency_contact'] ?? ''),
                'emergency_contact_relation' => $this->sanitizeInput($_POST['emergency_relation'] ?? ''),
                'emergency_contact_phone' => preg_replace('/[^0-9]/', '', $_POST['emergency_phone'] ?? '')
            ];
            
            // 5. Validation
            error_log('Starting form validation...');
            file_put_contents('/var/www/html/public/SUBMIT_CALLED.txt', "\n=== VALIDATION STARTED ===\n", FILE_APPEND);
            
            $validationErrors = $this->validateForm($studentData, $parentData);
            
            file_put_contents('/var/www/html/public/SUBMIT_CALLED.txt', "Validation errors count: " . count($validationErrors) . "\n", FILE_APPEND);
            if (!empty($validationErrors)) {
                file_put_contents('/var/www/html/public/SUBMIT_CALLED.txt', "VALIDATION FAILED:\n" . print_r($validationErrors, true) . "\n", FILE_APPEND);
                error_log('VALIDATION FAILED: ' . print_r($validationErrors, true));
                $_SESSION['form_errors'] = $validationErrors;
                $_SESSION['form_data'] = array_merge($studentData, $parentData);
                $this->redirect('youth-registration');
                return;
            }
            file_put_contents('/var/www/html/public/SUBMIT_CALLED.txt', "Validation passed!\n", FILE_APPEND);
            error_log('Validation passed successfully');
            
            // 6. Process photo upload
            error_log('Starting photo upload...');
            $photoPath = $this->uploadPhoto($studentData['student_photo']);
            
            if ($photoPath) {
                error_log('Photo uploaded successfully: ' . $photoPath);
                $studentData['photo_path'] = $photoPath;
                
                // 7. Save registration
                error_log('Attempting to save registration...');
                if ($this->saveRegistration($studentData, $parentData)) {
                    error_log('Registration saved successfully!');
                    // Clear form data from session
                    unset($_SESSION['form_data']);
                    
                    // Success redirect
                    $_SESSION['success_message'] = 'Başvurunuz başarıyla alındı! En kısa sürede size dönüş yapılacaktır.';
                    error_log('Redirecting to success page...');
                    $this->redirect('youth-registration?success=1');
                } else {
                    error_log('SAVE REGISTRATION FAILED!');
                    $errors[] = 'Kayıt kaydedilirken bir hata oluştu. Lütfen tekrar deneyin.';
                    $_SESSION['form_errors'] = $errors;
                    $_SESSION['form_data'] = array_merge($studentData, $parentData);
                    $this->redirect('youth-registration');
                }
            } else {
                error_log('PHOTO UPLOAD FAILED!');
                $errors[] = 'Fotoğraf yüklenirken bir hata oluştu. Lütfen geçerli bir fotoğraf seçin (JPG, PNG).';
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
        }
        // Age validation removed - admin will verify age when approving registration
        
        if (empty($studentData['birth_place']) || strlen($studentData['birth_place']) < 2) {
            $errors[] = 'Doğum yeri zorunludur.';
        }
        
        // TC Kimlik No validasyonu
        $tcNumber = preg_replace('/[^0-9]/', '', $studentData['tc_number']);
        if (strlen($tcNumber) !== 11) {
            $errors[] = 'TC Kimlik No 11 haneli olmalıdır.';
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
        
        if (empty($parentData['address']) || strlen($parentData['address']) < 5) {
            $errors[] = 'İkametgah adresi en az 5 karakter olmalıdır.';
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
        // Write debug to file
        $debugFile = BASE_PATH . '/public/PHOTO_UPLOAD_DEBUG.txt';
        file_put_contents($debugFile, "Upload started at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        
        if (!$photo || $photo['error'] !== UPLOAD_ERR_OK) {
            file_put_contents($debugFile, "Photo error: " . ($photo['error'] ?? 'No file') . "\n", FILE_APPEND);
            error_log('Photo upload error: ' . ($photo['error'] ?? 'No file'));
            return false;
        }
        
        // File size validation (5MB max)
        $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
        if ($photo['size'] > $maxFileSize) {
            file_put_contents($debugFile, "File too large: " . $photo['size'] . " bytes\n", FILE_APPEND);
            error_log('Photo upload error: File size exceeds 5MB limit');
            return false;
        }
        
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!in_array($photo['type'], $allowedTypes)) {
            file_put_contents($debugFile, "Invalid type: " . $photo['type'] . "\n", FILE_APPEND);
            error_log('Photo upload error: Invalid file type - ' . $photo['type']);
            return false;
        }
        
        // Additional MIME type check using finfo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $photo['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $allowedTypes)) {
            file_put_contents($debugFile, "Invalid MIME type: " . $mimeType . "\n", FILE_APPEND);
            error_log('Photo upload error: Invalid MIME type - ' . $mimeType);
            return false;
        }
        
        // Use absolute path
        $uploadDir = BASE_PATH . '/public/uploads/youth-photos/';
        file_put_contents($debugFile, "Upload dir: $uploadDir\n", FILE_APPEND);
        file_put_contents($debugFile, "Dir exists: " . (is_dir($uploadDir) ? 'YES' : 'NO') . "\n", FILE_APPEND);
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
            file_put_contents($debugFile, "Created directory\n", FILE_APPEND);
        }
        
        file_put_contents($debugFile, "Dir writable: " . (is_writable($uploadDir) ? 'YES' : 'NO') . "\n", FILE_APPEND);
        
        // Sanitize filename and use safe extension
        $fileExtension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            $fileExtension = 'jpg'; // Default to jpg
        }
        
        $fileName = uniqid() . '.' . $fileExtension;
        $uploadPath = $uploadDir . $fileName;
        
        file_put_contents($debugFile, "Upload path: $uploadPath\n", FILE_APPEND);
        file_put_contents($debugFile, "Temp file: " . $photo['tmp_name'] . "\n", FILE_APPEND);
        file_put_contents($debugFile, "Temp file exists: " . (file_exists($photo['tmp_name']) ? 'YES' : 'NO') . "\n", FILE_APPEND);
        
        if (move_uploaded_file($photo['tmp_name'], $uploadPath)) {
            // Return relative path for web access
            $relativePath = '/uploads/youth-photos/' . $fileName;
            file_put_contents($debugFile, "SUCCESS! Relative path: $relativePath\n", FILE_APPEND);
            error_log('Photo uploaded successfully: ' . $relativePath);
            return $relativePath;
        }
        
        file_put_contents($debugFile, "MOVE FAILED!\n", FILE_APPEND);
        error_log('Photo upload error: Failed to move uploaded file');
        return false;
    }
    
    private function saveRegistration($studentData, $parentData) {
        // Save to database-compatible JSON file structure
        $registrationData = [
            'student' => [
                'name' => $studentData['full_name'],
                'birth_date' => $studentData['birth_date'],
                'birth_place' => $studentData['birth_place'],
                'tc_number' => $studentData['tc_number'],
                'father_name' => $studentData['father_name'],
                'mother_name' => $studentData['mother_name'],
                'school_info' => $studentData['school_info'],
                'first_club' => $studentData['first_club'] ?? '',
            ],
            'parent' => [
                'name' => $parentData['parent_name'],
                'phone' => $parentData['parent_phone'],
                'address' => $parentData['address'],
                'father_job' => $parentData['father_job'],
                'mother_job' => $parentData['mother_job'],
            ],
            'emergency' => [
                'contact' => $parentData['emergency_contact_name'],
                'relation' => $parentData['emergency_contact_relation'],
                'phone' => $parentData['emergency_contact_phone'],
            ],
            'youth_group_id' => null,  // Will be assigned by admin later
            'photo_path' => $studentData['photo_path'] ?? '',
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => 'web_form'
        ];
        
        // Ensure directory exists
        $registrationsDir = BASE_PATH . '/data/youth-registrations';
        if (!is_dir($registrationsDir)) {
            mkdir($registrationsDir, 0755, true);
        }
        
        // Save to unique JSON file
        $filename = uniqid('reg_') . '.json';
        $filePath = $registrationsDir . '/' . $filename;
        
        $result = file_put_contents($filePath, json_encode($registrationData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        // Log for debugging
        if ($result === false) {
            error_log('Failed to save youth registration to: ' . $filePath);
            return false;
        }
        
        error_log('Youth registration saved successfully to: ' . $filePath);
        return true;
    }
}