<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Formu Test</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>🧪 Basit Test Kayıt Formu</h1>
    
    <?php
    session_start();
    define('BASE_PATH', dirname(__DIR__));
    require_once BASE_PATH . '/core/Controller.php';
    
    $controller = new Controller();
    $csrf_token = $controller->generateCSRFToken();
    
    if (isset($_SESSION['success_message'])) {
        echo '<div class="success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
        unset($_SESSION['success_message']);
    }
    
    if (isset($_SESSION['form_errors'])) {
        echo '<div class="error"><ul>';
        foreach ($_SESSION['form_errors'] as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul></div>';
        unset($_SESSION['form_errors']);
    }
    ?>
    
    <form method="POST" action="/youth-registration/submit" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        
        <h2>Öğrenci Bilgileri</h2>
        
        <div class="form-group">
            <label>Adı Soyadı *</label>
            <input type="text" name="student_name" required value="Ahmet Yılmaz">
        </div>
        
        <div class="form-group">
            <label>İlk Kulübü</label>
            <input type="text" name="first_club" value="Test Kulübü">
        </div>
        
        <div class="form-group">
            <label>Doğum Tarihi *</label>
            <input type="date" name="birth_date" required value="2012-05-15">
        </div>
        
        <div class="form-group">
            <label>Doğum Yeri *</label>
            <input type="text" name="birth_place" required value="Bursa">
        </div>
        
        <div class="form-group">
            <label>TC Kimlik No *</label>
            <input type="text" name="tc_number" required maxlength="11" value="12345678901">
        </div>
        
        <div class="form-group">
            <label>Baba Adı *</label>
            <input type="text" name="father_name" required value="Mehmet Yılmaz">
        </div>
        
        <div class="form-group">
            <label>Anne Adı *</label>
            <input type="text" name="mother_name" required value="Ayşe Yılmaz">
        </div>
        
        <div class="form-group">
            <label>Okul Bilgisi *</label>
            <input type="text" name="school_info" required value="Atatürk İlkokulu 4. Sınıf">
        </div>
        
        <div class="form-group">
            <label>Öğrenci Fotoğrafı * (JPG/PNG, max 5MB)</label>
            <input type="file" name="student_photo" accept="image/*" required>
        </div>
        
        <h2>Veli Bilgileri</h2>
        
        <div class="form-group">
            <label>Veli Adı Soyadı *</label>
            <input type="text" name="parent_name" required value="Mehmet Yılmaz">
        </div>
        
        <div class="form-group">
            <label>GSM Numarası *</label>
            <input type="tel" name="parent_phone" required maxlength="11" value="5551234567">
        </div>
        
        <div class="form-group">
            <label>İkametgah Adresi *</label>
            <textarea name="address" required rows="3">Atatürk Mahallesi Test Sokak No:5 Nilüfer/BURSA</textarea>
        </div>
        
        <div class="form-group">
            <label>E-posta Adresi *</label>
            <input type="email" name="email" required value="test@example.com">
        </div>
        
        <div class="form-group">
            <label>Baba Mesleği *</label>
            <input type="text" name="father_job" required value="Mühendis">
        </div>
        
        <div class="form-group">
            <label>Anne Mesleği *</label>
            <input type="text" name="mother_job" required value="Öğretmen">
        </div>
        
        <h2>Acil Durum Bilgileri</h2>
        
        <div class="form-group">
            <label>Acil Durumda Aranacak Kişi *</label>
            <input type="text" name="emergency_contact" required value="Ali Yılmaz">
        </div>
        
        <div class="form-group">
            <label>Yakınlık Derecesi *</label>
            <select name="emergency_relation" required>
                <option value="">Seçiniz</option>
                <option value="amca" selected>Amca</option>
                <option value="teyze">Teyze</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Acil Durum GSM *</label>
            <input type="tel" name="emergency_phone" required maxlength="11" value="5559876543">
        </div>
        
        <button type="submit">📝 Başvuruyu Gönder</button>
    </form>
    
    <hr style="margin: 30px 0;">
    <p><a href="/youth-registration">← Asıl Forma Dön</a> | <a href="/admin/youth-registrations">Admin Paneli →</a></p>
</body>
</html>
