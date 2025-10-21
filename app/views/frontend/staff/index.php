<?php
// Helper function to calculate age from birth date
function calculateAge($birthDate) {
    if (!$birthDate) return null;
    $birth = new DateTime($birthDate);
    $today = new DateTime();
    return $today->diff($birth)->y;
}

// Helper function to calculate years at club
function calculateYearsAtClub($joinedDate) {
    if (!$joinedDate) return null;
    $joined = new DateTime($joinedDate);
    $today = new DateTime();
    $diff = $today->diff($joined);
    if ($diff->y > 0) {
        return $diff->y . ' yıl';
    } elseif ($diff->m > 0) {
        return $diff->m . ' ay';
    } else {
        return $diff->d . ' gün';
    }
}

// Helper function to get default image
function getStaffImage($photo, $position) {
    // Default placeholder
    $defaultImage = BASE_URL . '/images/default-staff.svg';
    
    // If no photo provided, return default
    if (empty($photo) || $photo === 'NULL' || $photo === null) {
        return $defaultImage;
    }
    
    // If photo starts with http:// or https://, return as is (external URL)
    if (preg_match('/^https?:\/\//', $photo)) {
        return $photo;
    }
    
    // Clean the photo path
    $photo = trim($photo);
    $photo = ltrim($photo, '/');
    
    // If photo starts with 'uploads/', return it directly
    if (strpos($photo, 'uploads/') === 0) {
        return BASE_URL . '/' . $photo;
    }
    
    // If photo doesn't have uploads/ prefix, add it
    return BASE_URL . '/uploads/' . $photo;
}

$content = '
<!-- Technical Staff Stylesheet -->
<link rel="stylesheet" href="' . BASE_URL . '/css/technical-staff.css">

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">TEKNİK KADRO</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Teknik Kadro</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Head Coach Section -->
<section class="head-coach-section py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">BAŞ ANTRENÖR</h2>
        ' . (isset($head_coach) && $head_coach ? '
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="head-coach-profile">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-4">
                            <div class="coach-photo">
                                <img src="' . getStaffImage($head_coach['photo'] ?? null, $head_coach['position'] ?? '') . '" 
                                     alt="' . htmlspecialchars($head_coach['name'] ?? 'Baş Antrenör') . '" 
                                     class="img-fluid rounded-circle"
                                     style="width: 250px; height: 250px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="coach-info">
                                <h3 class="coach-name">' . htmlspecialchars($head_coach['name'] ?? '') . '</h3>
                                <p class="coach-title">' . htmlspecialchars($head_coach['position'] ?? 'Baş Antrenör') . '</p>
                                <div class="coach-details">
                                    ' . (isset($head_coach['birth_date']) && $head_coach['birth_date'] ? '
                                    <div class="detail-item">
                                        <strong>Yaş:</strong> ' . calculateAge($head_coach['birth_date']) . '
                                    </div>
                                    ' : '') . '
                                    ' . (isset($head_coach['experience_years']) && $head_coach['experience_years'] ? '
                                    <div class="detail-item">
                                        <strong>Deneyim:</strong> ' . $head_coach['experience_years'] . ' yıl
                                    </div>
                                    ' : '') . '
                                    ' . (isset($head_coach['license_type']) && $head_coach['license_type'] ? '
                                    <div class="detail-item">
                                        <strong>Lisans:</strong> ' . htmlspecialchars($head_coach['license_type']) . '
                                    </div>
                                    ' : '') . '
                                    ' . (isset($head_coach['joined_date']) && $head_coach['joined_date'] ? '
                                    <div class="detail-item">
                                        <strong>Kulüpteki Süresi:</strong> ' . calculateYearsAtClub($head_coach['joined_date']) . '
                                    </div>
                                    ' : '') . '
                                </div>
                                ' . (isset($head_coach['bio']) && $head_coach['bio'] ? '
                                <p class="coach-bio">
                                    ' . nl2br(htmlspecialchars($head_coach['bio'])) . '
                                </p>
                                ' : '') . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ' : '
        <div class="row">
            <div class="col-12 text-center">
                <p class="text-muted">Baş antrenör bilgisi bulunamadı.</p>
            </div>
        </div>
        ') . '
    </div>
</section>

<!-- Coaching Staff -->
<section class="coaching-staff py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">ANTRENÖR KADROSU</h2>
        
        <!-- Assistant Coaches -->
        ' . (isset($assistant_coaches) && !empty($assistant_coaches) ? '
        <div class="staff-category mb-5">
            <h3 class="category-title">
                <i class="fas fa-users text-primary"></i>
                Antrenörler
            </h3>
            <div class="row">
                ' . implode('', array_map(function($coach) {
                    return '
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <img src="' . getStaffImage($coach['photo'] ?? null, $coach['position'] ?? '') . '" 
                                 alt="' . htmlspecialchars($coach['name'] ?? '') . '" 
                                 class="img-fluid rounded"
                                 style="width: 100%; height: 250px; object-fit: cover;">
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">' . htmlspecialchars($coach['name'] ?? '') . '</h4>
                            <p class="staff-position">' . htmlspecialchars($coach['position'] ?? '') . '</p>
                            <div class="staff-details">
                                ' . (isset($coach['experience_years']) && $coach['experience_years'] ? '
                                <span class="experience"><i class="fas fa-briefcase"></i> Deneyim: ' . $coach['experience_years'] . ' yıl</span>
                                ' : '') . '
                                ' . (isset($coach['license_type']) && $coach['license_type'] ? '
                                <span class="license"><i class="fas fa-certificate"></i> ' . htmlspecialchars($coach['license_type']) . '</span>
                                ' : '') . '
                            </div>
                        </div>
                    </div>
                </div>';
                }, $assistant_coaches)) . '
            </div>
        </div>
        ' : '') . '

        <!-- Goalkeeping Coach -->
        ' . (isset($goalkeeping_coaches) && !empty($goalkeeping_coaches) ? '
        <div class="staff-category mb-5">
            <h3 class="category-title">
                <i class="fas fa-hand-paper text-warning"></i>
                Kaleci Antrenörleri
            </h3>
            <div class="row">
                ' . implode('', array_map(function($coach) {
                    return '
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <img src="' . getStaffImage($coach['photo'] ?? null, $coach['position'] ?? '') . '" 
                                 alt="' . htmlspecialchars($coach['name'] ?? '') . '" 
                                 class="img-fluid rounded"
                                 style="width: 100%; height: 250px; object-fit: cover;">
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">' . htmlspecialchars($coach['name'] ?? '') . '</h4>
                            <p class="staff-position">' . htmlspecialchars($coach['position'] ?? '') . '</p>
                            <div class="staff-details">
                                ' . (isset($coach['experience_years']) && $coach['experience_years'] ? '
                                <span class="experience"><i class="fas fa-briefcase"></i> Deneyim: ' . $coach['experience_years'] . ' yıl</span>
                                ' : '') . '
                                ' . (isset($coach['license_type']) && $coach['license_type'] ? '
                                <span class="license"><i class="fas fa-certificate"></i> ' . htmlspecialchars($coach['license_type']) . '</span>
                                ' : '') . '
                            </div>
                        </div>
                    </div>
                </div>';
                }, $goalkeeping_coaches)) . '
            </div>
        </div>
        ' : '') . '

        <!-- Fitness Coach -->
        ' . (isset($fitness_coaches) && !empty($fitness_coaches) ? '
        <div class="staff-category mb-5">
            <h3 class="category-title">
                <i class="fas fa-dumbbell text-success"></i>
                Kondisyon Antrenörleri
            </h3>
            <div class="row">
                ' . implode('', array_map(function($coach) {
                    return '
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <img src="' . getStaffImage($coach['photo'] ?? null, $coach['position'] ?? '') . '" 
                                 alt="' . htmlspecialchars($coach['name'] ?? '') . '" 
                                 class="img-fluid rounded"
                                 style="width: 100%; height: 250px; object-fit: cover;">
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">' . htmlspecialchars($coach['name'] ?? '') . '</h4>
                            <p class="staff-position">' . htmlspecialchars($coach['position'] ?? '') . '</p>
                            <div class="staff-details">
                                ' . (isset($coach['experience_years']) && $coach['experience_years'] ? '
                                <span class="experience"><i class="fas fa-briefcase"></i> Deneyim: ' . $coach['experience_years'] . ' yıl</span>
                                ' : '') . '
                                ' . (isset($coach['license_type']) && $coach['license_type'] ? '
                                <span class="license"><i class="fas fa-certificate"></i> ' . htmlspecialchars($coach['license_type']) . '</span>
                                ' : '') . '
                            </div>
                        </div>
                    </div>
                </div>';
                }, $fitness_coaches)) . '
            </div>
        </div>
        ' : '') . '

        <!-- Medical Staff -->
        ' . (isset($medical_staff) && !empty($medical_staff) ? '
        <div class="staff-category mb-5">
            <h3 class="category-title">
                <i class="fas fa-medkit text-danger"></i>
                Sağlık Ekibi
            </h3>
            <div class="row">
                ' . implode('', array_map(function($staff) {
                    return '
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <img src="' . getStaffImage($staff['photo'] ?? null, $staff['position'] ?? '') . '" 
                                 alt="' . htmlspecialchars($staff['name'] ?? '') . '" 
                                 class="img-fluid rounded"
                                 style="width: 100%; height: 250px; object-fit: cover;">
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">' . htmlspecialchars($staff['name'] ?? '') . '</h4>
                            <p class="staff-position">' . htmlspecialchars($staff['position'] ?? '') . '</p>
                            <div class="staff-details">
                                ' . (isset($staff['experience_years']) && $staff['experience_years'] ? '
                                <span class="experience"><i class="fas fa-briefcase"></i> Deneyim: ' . $staff['experience_years'] . ' yıl</span>
                                ' : '') . '
                                ' . (isset($staff['license_type']) && $staff['license_type'] ? '
                                <span class="license"><i class="fas fa-certificate"></i> ' . htmlspecialchars($staff['license_type']) . '</span>
                                ' : '') . '
                            </div>
                        </div>
                    </div>
                </div>';
                }, $medical_staff)) . '
            </div>
        </div>
        ' : '') . '

        <!-- Other Staff -->
        ' . (isset($other_staff) && !empty($other_staff) ? '
        <div class="staff-category mb-5">
            <h3 class="category-title">
                <i class="fas fa-user-friends text-info"></i>
                Diğer Personel
            </h3>
            <div class="row">
                ' . implode('', array_map(function($staff) {
                    return '
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <img src="' . getStaffImage($staff['photo'] ?? null, $staff['position'] ?? '') . '" 
                                 alt="' . htmlspecialchars($staff['name'] ?? '') . '" 
                                 class="img-fluid rounded"
                                 style="width: 100%; height: 250px; object-fit: cover;">
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">' . htmlspecialchars($staff['name'] ?? '') . '</h4>
                            <p class="staff-position">' . htmlspecialchars($staff['position'] ?? '') . '</p>
                            <div class="staff-details">
                                ' . (isset($staff['experience_years']) && $staff['experience_years'] ? '
                                <span class="experience"><i class="fas fa-briefcase"></i> Deneyim: ' . $staff['experience_years'] . ' yıl</span>
                                ' : '') . '
                                ' . (isset($staff['license_type']) && $staff['license_type'] ? '
                                <span class="license"><i class="fas fa-certificate"></i> ' . htmlspecialchars($staff['license_type']) . '</span>
                                ' : '') . '
                            </div>
                        </div>
                    </div>
                </div>';
                }, $other_staff)) . '
            </div>
        </div>
        ' : '') . '

    </div>
</section>

<!-- Philosophy Section -->
<section class="philosophy-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-title mb-4">ANTRENMAN FELSEFEMİZ</h2>
                <p class="lead mb-4">
                    Modern futbol anlayışını benimseyen teknik kadromuz, oyuncularımızın hem bireysel hem de takım halinde gelişimlerine odaklanır.
                </p>
                <div class="philosophy-points">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="philosophy-item">
                                <i class="fas fa-target text-primary"></i>
                                <h5>Hedef Odaklı</h5>
                                <p>Her oyuncumuz için bireysel hedefler belirler ve bu hedeflere ulaşmak için çalışırız.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="philosophy-item">
                                <i class="fas fa-brain text-warning"></i>
                                <h5>Mental Güçlendirme</h5>
                                <p>Fiziksel gelişimin yanı sıra mental dayanıklılığı da artırmaya odaklanırız.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="philosophy-item">
                                <i class="fas fa-hands-helping text-success"></i>
                                <h5>Takım Ruhu</h5>
                                <p>Bireysel yetenekleri takım başarısına dönüştüren antrenman metodları uygularız.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>