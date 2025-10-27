<?php
$content = '
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-2">A TAKIMI İSTATİSTİKLERİ</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '" class="text-warning">Ana Sayfa</a></li>
                        <li class="breadcrumb-item"><a href="' . BASE_URL . '/a-takimi" class="text-warning">A Takımı</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">İstatistikler</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Season Stats Overview -->
<section class="season-stats py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">2024-25 SEZON İSTATİSTİKLERİ</h2>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-futbol text-success"></i>
                    </div>
                    <h3 class="stat-number">32</h3>
                    <p class="stat-label">Atılan Gol</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-shield-alt text-primary"></i>
                    </div>
                    <h3 class="stat-number">8</h3>
                    <p class="stat-label">Yenilen Gol</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-trophy text-warning"></i>
                    </div>
                    <h3 class="stat-number">12</h3>
                    <p class="stat-label">Galibiyet</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-handshake text-info"></i>
                    </div>
                    <h3 class="stat-number">3</h3>
                    <p class="stat-label">Beraberlik</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Top Scorers -->
<section class="top-scorers py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">GOL KRALLARI</h2>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="scorers-table">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sıra</th>
                                    <th>Oyuncu</th>
                                    <th>Pozisyon</th>
                                    <th>Gol</th>
                                    <th>Asist</th>
                                    <th>Maç</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-warning text-dark">1</span></td>
                                    <td><strong>Mehmet YILMAZ</strong></td>
                                    <td>Forvet</td>
                                    <td><strong>12</strong></td>
                                    <td>5</td>
                                    <td>15</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-secondary">2</span></td>
                                    <td><strong>Ali KAYA</strong></td>
                                    <td>Orta Saha</td>
                                    <td><strong>8</strong></td>
                                    <td>7</td>
                                    <td>15</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-secondary">3</span></td>
                                    <td><strong>Fatih DEMİR</strong></td>
                                    <td>Forvet</td>
                                    <td><strong>6</strong></td>
                                    <td>3</td>
                                    <td>14</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Serkan ASLAN</td>
                                    <td>Defans</td>
                                    <td>3</td>
                                    <td>2</td>
                                    <td>15</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Emre ÖZKAN</td>
                                    <td>Orta Saha</td>
                                    <td>3</td>
                                    <td>8</td>
                                    <td>15</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Performance Stats -->
<section class="performance-stats py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">PERFORMANS ANALİZİ</h2>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="stats-card">
                    <h3 class="stats-title">
                        <i class="fas fa-chart-line text-success"></i>
                        Hücum İstatistikleri
                    </h3>
                    <div class="stats-list">
                        <div class="stat-item">
                            <span class="stat-label">Maç Başına Gol</span>
                            <span class="stat-value">2.1</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Toplam Şut</span>
                            <span class="stat-value">187</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">İsabet Oranı</span>
                            <span class="stat-value">%64</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Korner</span>
                            <span class="stat-value">45</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Ofsayt</span>
                            <span class="stat-value">23</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="stats-card">
                    <h3 class="stats-title">
                        <i class="fas fa-shield-alt text-primary"></i>
                        Savunma İstatistikleri
                    </h3>
                    <div class="stats-list">
                        <div class="stat-item">
                            <span class="stat-label">Maç Başına Yenilen</span>
                            <span class="stat-value">0.5</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Temiz Çıkış</span>
                            <span class="stat-value">9</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Top Kesme</span>
                            <span class="stat-value">156</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Hava Topu</span>
                            <span class="stat-value">78</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Kurtarış</span>
                            <span class="stat-value">34</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Match Form -->
<section class="match-form py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">SON 10 MAÇ FORMU</h2>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-display">
                    <div class="form-matches">
                        <div class="match-result win">G</div>
                        <div class="match-result win">G</div>
                        <div class="match-result draw">B</div>
                        <div class="match-result win">G</div>
                        <div class="match-result win">G</div>
                        <div class="match-result win">G</div>
                        <div class="match-result loss">M</div>
                        <div class="match-result win">G</div>
                        <div class="match-result draw">B</div>
                        <div class="match-result win">G</div>
                    </div>
                    <div class="form-summary">
                        <div class="form-stat">
                            <span class="label">Galibiyet:</span>
                            <span class="value">7</span>
                        </div>
                        <div class="form-stat">
                            <span class="label">Beraberlik:</span>
                            <span class="value">2</span>
                        </div>
                        <div class="form-stat">
                            <span class="label">Mağlubiyet:</span>
                            <span class="value">1</span>
                        </div>
                        <div class="form-stat">
                            <span class="label">Form:</span>
                            <span class="value text-success">%80</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- League Position -->
<section class="league-position py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">LİG DURUMU</h2>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="table-responsive">
                    <table class="table table-striped league-table">
                        <thead class="table-dark">
                            <tr>
                                <th>Sıra</th>
                                <th>Takım</th>
                                <th>O</th>
                                <th>G</th>
                                <th>B</th>
                                <th>M</th>
                                <th>A</th>
                                <th>Y</th>
                                <th>Av</th>
                                <th>P</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Lider Takım</td>
                                <td>15</td>
                                <td>13</td>
                                <td>2</td>
                                <td>0</td>
                                <td>35</td>
                                <td>5</td>
                                <td>+30</td>
                                <td>41</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>İkinci Takım</td>
                                <td>15</td>
                                <td>11</td>
                                <td>3</td>
                                <td>1</td>
                                <td>28</td>
                                <td>8</td>
                                <td>+20</td>
                                <td>36</td>
                            </tr>
                            <tr class="our-team">
                                <td><strong>3</strong></td>
                                <td><strong>Spor Kulübü</strong></td>
                                <td><strong>15</strong></td>
                                <td><strong>12</strong></td>
                                <td><strong>3</strong></td>
                                <td><strong>0</strong></td>
                                <td><strong>32</strong></td>
                                <td><strong>8</strong></td>
                                <td><strong>+24</strong></td>
                                <td><strong>39</strong></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Dördüncü Takım</td>
                                <td>15</td>
                                <td>9</td>
                                <td>4</td>
                                <td>2</td>
                                <td>25</td>
                                <td>12</td>
                                <td>+13</td>
                                <td>31</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Beşinci Takım</td>
                                <td>15</td>
                                <td>8</td>
                                <td>5</td>
                                <td>2</td>
                                <td>22</td>
                                <td>15</td>
                                <td>+7</td>
                                <td>29</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">O: Oynanan, G: Galibiyet, B: Beraberlik, M: Mağlubiyet, A: Atılan, Y: Yenilen, Av: Averaj, P: Puan</small>
                </div>
            </div>
        </div>
    </div>
</section>
';

include BASE_PATH . '/app/views/frontend/layout.php';
?>