<?php

class YouthRegistration extends Controller {
    
    public function index() {
        // Load youth groups for selection
        $youthGroupModel = $this->model('YouthGroup');
        $youthGroups = $youthGroupModel->getActive();
        
        $data = [
            'title' => 'Alt Yapı Kayıt Formu',
            'page' => 'youth-registration',
            'youth_groups' => $youthGroups
        ];
        
        $this->view('frontend/youth-registration/index', $data);
    }
    
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Form verilerini al
            $studentData = [
                'full_name' => $_POST['full_name'] ?? '',
                'first_club' => $_POST['first_club'] ?? '',
                'birth_date' => $_POST['birth_date'] ?? '',
                'birth_place' => $_POST['birth_place'] ?? '',
                'tc_number' => $_POST['tc_number'] ?? '',
                'father_name' => $_POST['father_name'] ?? '',
                'mother_name' => $_POST['mother_name'] ?? '',
                'school_info' => $_POST['school_info'] ?? '',
                'student_photo' => $_FILES['student_photo'] ?? null
            ];
            
            $parentData = [
                'parent_name' => $_POST['parent_name'] ?? '',
                'parent_phone' => $_POST['parent_phone'] ?? '',
                'address' => $_POST['address'] ?? '',
                'email' => $_POST['email'] ?? '',
                'father_job' => $_POST['father_job'] ?? '',
                'mother_job' => $_POST['mother_job'] ?? '',
                'emergency_contact_name' => $_POST['emergency_contact_name'] ?? '',
                'emergency_contact_relation' => $_POST['emergency_contact_relation'] ?? '',
                'emergency_contact_phone' => $_POST['emergency_contact_phone'] ?? ''
            ];
            
            // Validasyon
            $errors = $this->validateForm($studentData, $parentData);
            
            if (empty($errors)) {
                // Fotoğraf yükleme işlemi
                $photoPath = $this->uploadPhoto($studentData['student_photo']);
                
                if ($photoPath) {
                    $studentData['photo_path'] = $photoPath;
                    
                    // Veritabanına kaydet (şimdilik dosyaya kaydet)
                    $this->saveRegistration($studentData, $parentData);
                    
                    // Başarı mesajı ile yönlendir
                    header('Location: ' . BASE_URL . '/youth-registration?success=1');
                    exit;
                } else {
                    $errors[] = 'Fotoğraf yüklenirken bir hata oluştu.';
                }
            }
            
            // Hata varsa formu tekrar göster
            $data = [
                'title' => 'Alt Yapı Kayıt Formu',
                'page' => 'youth-registration',
                'errors' => $errors,
                'student_data' => $studentData,
                'parent_data' => $parentData
            ];
            
            $this->view('frontend/youth-registration/index', $data);
        }
    }
    
    private function validateForm($studentData, $parentData) {
        $errors = [];
        
        // Öğrenci bilgileri validasyonu
        if (empty($studentData['full_name'])) {
            $errors[] = 'Öğrenci adı soyadı zorunludur.';
        }
        
        if (empty($studentData['birth_date'])) {
            $errors[] = 'Doğum tarihi zorunludur.';
        }
        
        if (empty($studentData['birth_place'])) {
            $errors[] = 'Doğum yeri zorunludur.';
        }
        
        if (empty($studentData['tc_number']) || strlen($studentData['tc_number']) !== 11) {
            $errors[] = 'TC Kimlik No 11 haneli olmalıdır.';
        }
        
        if (empty($studentData['father_name'])) {
            $errors[] = 'Baba adı zorunludur.';
        }
        
        if (empty($studentData['mother_name'])) {
            $errors[] = 'Anne adı zorunludur.';
        }
        
        if (empty($studentData['school_info'])) {
            $errors[] = 'Okul bilgisi zorunludur.';
        }
        
        if (empty($studentData['student_photo']['name'])) {
            $errors[] = 'Öğrenci fotoğrafı zorunludur.';
        }
        
        // Veli bilgileri validasyonu
        if (empty($parentData['parent_name'])) {
            $errors[] = 'Veli adı soyadı zorunludur.';
        }
        
        if (empty($parentData['parent_phone']) || strlen($parentData['parent_phone']) < 10) {
            $errors[] = 'Geçerli bir GSM numarası giriniz.';
        }
        
        if (empty($parentData['address'])) {
            $errors[] = 'İkametgah adresi zorunludur.';
        }
        
        if (empty($parentData['email']) || !filter_var($parentData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Geçerli bir e-posta adresi giriniz.';
        }
        
        if (empty($parentData['father_job'])) {
            $errors[] = 'Baba mesleği zorunludur.';
        }
        
        if (empty($parentData['mother_job'])) {
            $errors[] = 'Anne mesleği zorunludur.';
        }
        
        if (empty($parentData['emergency_contact_name'])) {
            $errors[] = 'Acil durumda aranacak kişi adı zorunludur.';
        }
        
        if (empty($parentData['emergency_contact_relation'])) {
            $errors[] = 'Acil durumda aranacak kişinin yakınlık derecesi zorunludur.';
        }
        
        if (empty($parentData['emergency_contact_phone']) || strlen($parentData['emergency_contact_phone']) < 10) {
            $errors[] = 'Acil durumda aranacak kişinin telefon numarası zorunludur.';
        }
        
        return $errors;
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