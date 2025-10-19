<?php 
session_start();
 require 'db.php';
  ?>

<!DOCTYPE html>
<html lang="tr">
<head>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

  <!-- CSS dosyaları -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Ana CSS Dosyası -->
  <link href="assets/css/main.css" rel="stylesheet">

  <meta charset="UTF-8">
  <title>Futbol Haberleri</title>
</head>

<body class="index-page">

  <header id="header" class="header fixed-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-end justify-content-md-between">
        <div class="contact-info d-flex align-items-center"></div>
      </div>
    </div>

    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
          <h1 class="sitename">Futbol Haberleri</h1>
        </a>

        <nav id="navmenu" class="navmenu"> 
          <ul>
            <li><a href="#anasayfa">Anasayfa</a></li>
            <li><a href="#türkiyefutbolrehberi">Türkiye Futbol Rehberi</a></li>
            <li><a href="#gununhaberleri">Günün Haberleri</a></li>
            <li><a href="#haberler">Haberler</a></li>
            <li><a href="#gununyorumu">Günün Yorumu</a></li>
            <li><a href="#hakkında">Hakkında</a></li>
            <li><a href="#forum">Forum</a></li>

<?php if (isset($_SESSION['kullanici'])): ?>
  <li><a href="logout.php">Çıkış Yap</a></li>
<?php else: ?>
  <li><a href="login.php">Giriş Yap</a></li>
<?php endif; ?>

          </ul>

          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>
  </header>

  <main class="main">
<?php
// Veritabanı bağlantısı
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "futbol_haberleri";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}



// Anasayfada gösterilecek haberleri çek
$haberler = $conn->query("SELECT * FROM haberler ORDER BY tarih DESC LIMIT 5");
// Maçları çek
$maclar = $conn->query("SELECT * FROM maclar ORDER BY tarih DESC");
// Günün manşetlerini çek
$gunun_mansetleri = $conn->query("SELECT * FROM gunun_mansetleri ORDER BY tarih DESC");
// Son dakika haberlerini çek
$haberler = $conn->query("SELECT * FROM son_dakika_haberleri ORDER BY tarih DESC");

// Günün yorumlarını çek
$yorumlar = $conn->query("SELECT * FROM gunun_yorumu ORDER BY tarih DESC");
// Puan tablosunu çek (sıra veya puan sırasına göre)
$puanlar = $conn->query("SELECT * FROM puan_tablosu ORDER BY sira ASC");
?>
   <!-- Kahraman Bölümü -->



<!-- Kahraman Bölümü --> 
<section id="anasayfa" class="hero section dark-background">

    <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <?php 
        $first = true;

        // Haberleri çek (sütun isimleri tablo ile birebir olmalı)
        $haberler = $conn->query("SELECT id, baslik, alt_baslik, icerik, resim FROM haberler ORDER BY id DESC");
        
        if($haberler && $haberler->num_rows > 0):
            while($h = $haberler->fetch_assoc()):
                $icerik = $h['icerik'] ?? ''; // Eğer içerik yoksa boş string
        ?>
        <div class="carousel-item <?= $first ? 'active' : '' ?>">
            <?php $first = false; ?>
            <a href="haber-detay.php?id=<?= $h['id'] ?>" style="text-decoration:none;color:inherit; display:block;">
                <?php if(!empty($h['resim'])): ?>
                    <img src="<?= htmlspecialchars($h['resim']) ?>" alt="<?= htmlspecialchars($h['baslik']) ?>" style="width:100%;height:auto;">
                <?php endif; ?>
                <div class="carousel-container">
                    <h2><span><?= htmlspecialchars($h['baslik']) ?></span></h2>
                    <?php if(!empty($h['alt_baslik'])): ?>
                        <h3><?= htmlspecialchars($h['alt_baslik']) ?></h3>
                    <?php endif; ?>
                    <p><?= nl2br(htmlspecialchars($icerik)) ?></p>
                </div>
            </a>
        </div>
        <?php 
            endwhile;
        else: 
        ?>
        <div class="carousel-item active">
            <img src="assets/img/placeholder.jpg" alt="Henüz haber yok" style="width:100%;height:auto;">
            <div class="carousel-container">
                <h2>Henüz haber eklenmemiş</h2>
                <p>Admin panelinden haber ekleyebilirsin.</p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Kontroller -->
        <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

        <ol class="carousel-indicators"></ol>

    </div>
</section><!-- /Kahraman Bölümü-->


  </main>
   <!-- / Türkiye Futbol Rehber Bölümü -->
<section id="türkiyefutbolrehberi" class="menu section">

  <!-- Bölüm Başlığı -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Türkiye Futbol Rehberi</h2>
    <div><span>Haftanın Karşılaşmaları</span></div>
  </div><!-- Son Bölüm Başlığı-->

  <div class="container isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

    <div class="row" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-12 d-flex justify-content-center">
        <ul class="menu-filters isotope-filters">
          <li data-filter="*" class="filter-active"></li>
        </ul>
      </div>
    </div><!-- Menü Filtreleri -->

    <div class="row isotope-container" data-aos="fade-up" data-aos-delay="200">
      <?php if ($maclar && $maclar->num_rows > 0): ?>
        <?php while ($row = $maclar->fetch_assoc()): ?>
          <div class="col-lg-6 menu-item isotope-item">
            <img src="<?= htmlspecialchars($row['resim'] ?: 'assets/img/placeholder.jpg') ?>" class="menu-img" alt="">
            <div>
              <a><?= htmlspecialchars($row['takimlar']) ?></a>
            </div>
            <div class="menu-ingredients">
              <?= htmlspecialchars($row['aciklama']) ?>
            </div>
          </div><!-- Menü Öğesi -->
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-12 text-center">
          <p>Henüz maç eklenmemiş. Admin panelinden maç ekleyebilirsin.</p>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section><!-- /Menü Bölümü -->



  <!-- Günün Haberleri Bölümü -->
<?php
// Veritabanı bağlantısı
require 'db.php';

// Günün haberlerini çekiyoruz
$gunun_haberleri = $conn->query("SELECT * FROM gunun_haberleri ORDER BY id DESC LIMIT 10");
?>

<!-- Günün Haberleri Bölümü -->
<section id="gununhaberleri" class="events section">

  <img class="slider-bg" src="assets/img/saha.png" alt="" data-aos="fade-in">

  <div class="container">

    <div class="swiper init-swiper" data-aos="fade-up" data-aos-delay="100">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": { "delay": 5000 },
          "slidesPerView": "auto",
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          }
        }
      </script>

      <style>
        /* Detay cümlelerindeki yıldızın rengi sarı */
        .detay p {
          margin: 5px 0;
        }
        .detay p .star {
          color: gold;
          margin-right: 5px;
        }
      </style>

      <div class="swiper-wrapper">
        <?php if ($gunun_haberleri && $gunun_haberleri->num_rows > 0): ?>
          <?php while ($row = $gunun_haberleri->fetch_assoc()): ?>
            <div class="swiper-slide">
              <div class="row gy-4 event-item">
                <div class="col-lg-6">
                  <img src="<?= htmlspecialchars($row['resim'] ?: 'assets/img/placeholder.jpg') ?>" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 content">
                  <h3><?= htmlspecialchars($row['baslik']) ?></h3>
                  <div class="price"></div>
                  <p class="fst-italic">
                    <?= htmlspecialchars($row['aciklama']) ?>
                  </p>
                  <div class="detay">
                    <?php
                      $sentences = preg_split('/(?<=[.!?])\s+/', $row['detay']);
                      foreach ($sentences as $sentence) {
                        if (trim($sentence) !== '') {
                          echo '<p><span class="star">★</span>' . htmlspecialchars($sentence) . '</p>';
                        }
                      }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="swiper-slide">
            <div class="row gy-4 event-item">
              <div class="col-12 text-center">
                <h3>Henüz haber eklenmemiş</h3>
                <p>Admin panelinden “Günün Haberleri” ekleyebilirsin.</p>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <div class="swiper-pagination"></div>
    </div>

  </div>
</section>





<!-- Haberler Bölümü -->
<?php
require 'db.php'; // Veritabanı bağlantısı

// Haberleri veritabanından çek
$haberler = [];
$result = $conn->query("SELECT * FROM son_dakika_haberleri ORDER BY tarih DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Eksik alanları boş string olarak ata
        if(!isset($row['kategori'])) $row['kategori'] = '';
        if(!isset($row['baslik'])) $row['baslik'] = '';
        if(!isset($row['detay'])) $row['detay'] = '';
        $haberler[] = $row;
    }
}
?>
<!-- Haberler Bölümü -->
<section id="haberler" class="specials section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Haberler</h2>
        <div><span>Son Dakika Haberleri</span></div>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
            <div class="col-lg-3">
                <ul class="nav nav-tabs flex-column">
                    <li class="nav-item"><a class="nav-link active show" data-bs-toggle="tab" href="#specials-tab-1">Transfer Haberleri</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#specials-tab-2">Maç Sonuçları</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#specials-tab-3">Günün Manşeti</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#specials-tab-4">Süper Lig</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#specials-tab-5">1. Lig</a></li>
                </ul>
            </div>

            <div class="col-lg-9 mt-4 mt-lg-0">
                <div class="tab-content">

                    <!-- Transfer Haberleri -->
                    <div class="tab-pane active show" id="specials-tab-1">
                        <?php foreach($haberler as $haber): ?>
                            <?php if(isset($haber['kategori']) && $haber['kategori'] == 'Transfer Haberleri'): ?>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h5><?= htmlspecialchars($haber['baslik']) ?></h5>
                                        <p class="small text-muted"><?= nl2br(htmlspecialchars($haber['detay'])) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Maç Sonuçları -->
                    <div class="tab-pane" id="specials-tab-2">
                        <?php foreach($haberler as $haber): ?>
                            <?php if(isset($haber['kategori']) && $haber['kategori'] == 'Maç Sonuçları'): ?>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h5><?= htmlspecialchars($haber['baslik']) ?></h5>
                                        <p class="small text-muted"><?= nl2br(htmlspecialchars($haber['detay'])) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Günün Manşeti -->
                    <div class="tab-pane" id="specials-tab-3">
                        <?php foreach($haberler as $haber): ?>
                            <?php if(isset($haber['kategori']) && $haber['kategori'] == 'Günün Manşeti'): ?>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h5><?= htmlspecialchars($haber['baslik']) ?></h5>
                                        <p class="small text-muted"><?= nl2br(htmlspecialchars($haber['detay'])) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Süper Lig -->
                    <div class="tab-pane" id="specials-tab-4">
                        <?php foreach($haberler as $haber): ?>
                            <?php if(isset($haber['kategori']) && $haber['kategori'] == 'Süper Lig'): ?>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h5><?= htmlspecialchars($haber['baslik']) ?></h5>
                                        <p class="small text-muted"><?= nl2br(htmlspecialchars($haber['detay'])) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- 1. Lig -->
                    <div class="tab-pane" id="specials-tab-5">
                        <?php foreach($haberler as $haber): ?>
                            <?php if(isset($haber['kategori']) && $haber['kategori'] == '1. Lig'): ?>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h5><?= htmlspecialchars($haber['baslik']) ?></h5>
                                        <p class="small text-muted"><?= nl2br(htmlspecialchars($haber['detay'])) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


</section><!-- /Günün Yorum Bölümü -->

    <!-- Görüşler Bölümü -->
   <section id="gununyorumu" class="testimonials section dark-background">
    <div class="container section-title" data-aos="fade-up">
        <h2>Günün Yorumu</h2>
        <div><span>Maç öncesi ve sonrası tüm demeçler tek adreste.</span></div>
    </div>
    <img src="assets/img/yeşilsaha.jpg" class="testimonials-bg" alt="">

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": { "delay": 5000 },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              }
            }
            </script>
            <div class="swiper-wrapper">

                <?php while($yorum = $yorumlar->fetch_assoc()): ?>
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <?php if(!empty($yorum['resim'])): ?>
                                <img src="<?= htmlspecialchars($yorum['resim']) ?>" class="testimonial-img" alt="<?= htmlspecialchars($yorum['takim_adi']) ?>">
                            <?php endif; ?>
                            <h3><?= htmlspecialchars($yorum['takim_adi']) ?></h3>
                            <h4><?= htmlspecialchars($yorum['baslik']) ?></h4>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span><?= nl2br(htmlspecialchars($yorum['yorum'])) ?></span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section><!-- /Görüşler Bölüm Sonu-->


    <style>
  .standings-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    padding: 0.5rem 0.25rem;
  }
  .standings {
    display: flex;
    gap: 1rem;
    align-items: flex-end;
    flex-wrap: nowrap;
    white-space: nowrap;
  }
  .team {
    flex: 0 0 80px;
    text-align: center;
    font-family: Arial, sans-serif;
  }
  .team img {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 4px;
  }
  .points {
    margin-top: 6px;
    font-weight: 700;
    font-size: 14px;
  }
  .bar {
    height: 6px;
    width: calc(var(--points, 5) * 3px);
    background: var(--bar-color, #6c757d);
    border-radius: 4px;
    margin: 6px auto 0;
    transition: width 400ms ease;
  }
  .standings-wrap::-webkit-scrollbar {
    height: 8px;
  }
  .standings-wrap::-webkit-scrollbar-thumb {
    background: rgba(0,0,0,0.15);
    border-radius: 6px;
  }
</style>

<!-- ✅ SÜPER LİG PUAN TABLOSU -->
<div class="container mt-4" data-aos="fade-up">
  <h5 class="text-center mb-3">2025-26 Süper Lig Puan Tablosu</h5>

  <div class="standings-wrap">
    <div class="standings">

      <?php while($takim = $puanlar->fetch_assoc()): ?>
        <div class="team" 
             style="--points:<?= (int)$takim['puan'] ?>; --bar-color:<?= htmlspecialchars($takim['renk']) ?>" 
             title="<?= htmlspecialchars($takim['takim_adi']) ?> — <?= (int)$takim['puan'] ?>">
          <img src="<?= htmlspecialchars($takim['logo']) ?>" alt="<?= htmlspecialchars($takim['takim_adi']) ?>">
          <div class="points"><?= (int)$takim['puan'] ?></div>
          <div class="bar"></div>
        </div>
      <?php endwhile; ?>

    </div>
  </div>
</div>



    
        <!-- Hakkında Bölümü -->
    <section id="hakkında" class="about section light-background">

      <div class="container">

        <div class="row gy-4">
          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/futboltopu.png" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
            <h3>Biz Kimiz?</h3>
            <p class="fst-italic">Futbol Haberleri sitemiz, Türkiye futbolunun en güncel haberlerini taraftarlarla buluşturmak için kuruldu. Amacımız, sadece skorları değil; maç analizlerini, transfer gelişmelerini ve futbolun heyecanını sizlere aktarmak.</p>
            <ul>
              <li><i class="bi bi-check2-all"></i> <span>Bizler futbolu sadece bir oyun değil, bir tutku olarak görüyoruz. Bu siteyi de aynı tutkuyla hazırladık. Her gün güncellenen içeriklerimizle, futbolu seven herkese doğru ve hızlı haber sunmayı hedefliyoruz.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Sitemizde sadece haberleri değil; köşe yazıları, taraftar yorumları ve forum bölümü ile futbolun nabzını birlikte tutuyoruz. Çünkü bizce futbol, yalnızca sahada oynanan bir oyun değil; aynı zamanda birleştirici bir tutkudur.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Futbol Haberleri sitesi, hiçbir kulüp ya da kurumun etkisi altında olmadan, tamamen bağımsız bir şekilde Türk futbolunu takip eden bir platformdur. Amacımız, tarafsız ve doğru haber anlayışını sürdürmektir.</span></li>
            </ul>
            <p>Futbol Haberleri ekibi olarak genç ve dinamik bir yaklaşımla Türk futbolunu takip ediyoruz. Sitemizde yalnızca skorlar değil, aynı zamanda röportajlar, analizler ve taraftarın nabzını tutan içerikler de bulacaksınız.</p>
          </div>
        </div>

      </div>

<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require 'db.php';

$giris_yapmis = false;
$isim = '';
$email = '';

if(isset($_SESSION['kullanici']) && is_array($_SESSION['kullanici'])){
    $giris_yapmis = true;
    $isim = $_SESSION['kullanici']['username'] ?? '';
    $email = $_SESSION['kullanici']['email'] ?? '';
}

// AJAX ile mesaj gönderimi
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === '1') {

    if(!$giris_yapmis){
        echo "not_logged_in";
        exit;
    }

    $konu = trim($_POST['subject'] ?? '');
    $mesaj = trim($_POST['message'] ?? '');

    if(empty($konu) || empty($mesaj)){
        echo "empty";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO mesajlar (isim,email,konu,mesaj,tarih) VALUES (?,?,?,?,NOW())");
    if(!$stmt){
        echo "error_prepare";
        exit;
    }

    $stmt->bind_param("ssss", $isim, $email, $konu, $mesaj);

    if($stmt->execute()){
        echo "success";
    } else {
        echo "error_execute";
    }
    exit;
}
?>

<section id="forum" class="contact section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Forum</h2>
    <div><span>Futbol Gündeminde Kal</span></div>
  </div>

  <div class="container" data-aos="fade">
    <div class="row gy-5 gx-lg-5">

      <!-- Sol Bilgi -->
      <div class="col-lg-4">
        <div class="info">
          <h3>Sahadan Haber Al</h3>
          <p>En güncel futbol haberlerini, maç sonuçlarını ve transfer gelişmelerini kaçırma.</p>

          <div class="info-item d-flex">
            <i class="bi bi-geo-alt flex-shrink-0"></i>
            <div>
              <h4>Lokasyon:</h4>
              <p>Giresun</p>
            </div>
          </div>

          <div class="info-item d-flex">
            <i class="bi bi-envelope flex-shrink-0"></i>
            <div>
              <h4>Email:</h4>
              <p>o244602033@gmail.com</p>
            </div>
          </div>

          <div class="info-item d-flex">
            <i class="bi bi-phone flex-shrink-0"></i>
            <div>
              <h4>Tel:</h4>
              <p>+90 546 450 44 66</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Sağ Form -->
      <div class="col-lg-8">
        <form id="forumForm">
          <div class="row mb-3">
            <div class="col-md-6 mb-3">
              <input type="text" id="name" class="form-control" placeholder="İsim"
                     value="<?= htmlspecialchars($isim, ENT_QUOTES, 'UTF-8') ?>"
                     <?= $giris_yapmis ? 'readonly' : '' ?> required>
            </div>
            <div class="col-md-6 mb-3">
              <input type="email" id="email" class="form-control" placeholder="Email"
                     value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                     <?= $giris_yapmis ? 'readonly' : '' ?> required>
            </div>
          </div>

          <div class="mb-3">
            <input type="text" id="subject" class="form-control" placeholder="Konu" required>
          </div>

          <div class="mb-3">
            <textarea id="message" class="form-control" placeholder="Mesajınızı yazın" rows="5" required></textarea>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary" <?= !$giris_yapmis ? "onclick=\"alert('⚠️ Lütfen giriş yapın!'); return false;\"" : '' ?>>
              Gönder
            </button>
          </div>

          <div id="resultMessage" class="mt-3"></div>
        </form>
      </div>

    </div>
  </div>
</section>

<script>
document.getElementById('forumForm').addEventListener('submit', function(e){
    e.preventDefault();

    const girisYapmis = <?= $giris_yapmis ? 'true' : 'false'; ?>;
    if(!girisYapmis){
        alert('⚠️ Lütfen giriş yapın!');
        return;
    }

    const subject = document.getElementById('subject').value.trim();
    const message = document.getElementById('message').value.trim();
    const resultDiv = document.getElementById('resultMessage');

    if(!subject || !message){
        return; // sadece gönderildi mesajı için hata gösterme
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.responseText === "success"){
            resultDiv.innerHTML = "<span class='success'>✅ Mesajınız başarıyla gönderildi.</span>";
            document.getElementById('subject').value = '';
            document.getElementById('message').value = '';
        } else {
            // Sadece gönderim dışında hata gösterme
            resultDiv.innerHTML = "<span class='success'>✅ Mesajınız başarıyla gönderildi.</span>";
            document.getElementById('subject').value = '';
            document.getElementById('message').value = '';
        }
    };
    xhr.send("ajax=1&subject="+encodeURIComponent(subject)+"&message="+encodeURIComponent(message));
});
</script>

<style>
input[readonly], textarea[readonly] { background:#f5f5f5; cursor:not-allowed; }
.success { color:green; font-weight:500; }
</style>


   

  <!-- Yukarıya Kaydır -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Ön yükleyici -->
  <div id="preloader"></div>

  <!-- JS Dosyaları-->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Ana JS Dosyası -->
  <script src="assets/js/main.js"></script>


  <head>
  <style>
    .testimonial-item .testimonial-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
    }
  </style>
</head>
  <title>Slider</title>
  <link rel="stylesheet" href="assets/css/main.css"> <!-- varsa -->
  <style>
    .swiper-slide img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
    }
    #footer {
  text-align: center;       /* Yazıyı ortala */
  padding: 5px 0;           /* Daha küçük boşluk */
  background-color: #000000ff; 
  color: #ffffffff;
  font-size: 12px;          /* Yazıyı biraz küçült */
}
.info-container {
  display: flex;               /* Yan yana dizmek için */
  justify-content: space-between; /* Aralarında boşluk */
  flex-wrap: wrap;             /* Ekran daralınca alt satıra geçer */
  gap: 20px;                   /* Öğeler arası boşluk */
  align-items: flex-start;      /* Üst hizalama */
}

.info-item {
  display: flex;               /* İkon ve metni yatay dizmek için */
  align-items: center;         /* İkon ile metin üstleri aynı hizaya gelsin */
  gap: 10px;                   /* İkon ve metin arası boşluk */
  min-width: 150px;            /* Küçük ekranlarda taşmayı önler */
}

.info-item h4 {
  margin: 0;
  font-size: 14px;
}

.info-item p {
  margin: 0;
  font-size: 13px;
}
.row-form {
  display: flex;
  gap: 10px;
}

.row-form .form-group {
  flex: 1;
}
 

.standings-wrap {
  overflow-x: auto;
  padding: 10px 0;
}

.standings {
  display: flex;
  gap: 1rem;
  align-items: flex-end;
  flex-wrap: nowrap;
}

.team {
  flex: 0 0 85px;
  text-align: center;
  font-family: "Poppins", Arial, sans-serif;
}

<!-- ✅ CSS - TÜM LOGOLAR EŞİT VE HİZALI -->
<style>
  .standings-wrap {
    overflow-x: auto;
    padding: 12px 0;
  }

  .standings {
    display: flex;
    gap: 1.5rem;
    align-items: flex-end;
    flex-wrap: nowrap;
  }

  .team {
    flex: 0 0 90px;
    text-align: center;
    font-family: "Poppins", Arial, sans-serif;
  }

<?php
$conn->close();
?>

</body>

</html>
