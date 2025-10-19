<?php
session_start();
require 'db.php';

// Haber ID al
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// AJAX ile sonraki/önceki haber
if(isset($_GET['ajax_haber']) && in_array($_GET['ajax_haber'], ['next','prev'])) {
    $yon = $_GET['ajax_haber'];
    $stmt = $conn->prepare($yon === 'next' 
        ? "SELECT id FROM haberler WHERE id > ? ORDER BY id ASC LIMIT 1"
        : "SELECT id FROM haberler WHERE id < ? ORDER BY id DESC LIMIT 1"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if ($row) {
        echo $row['id'];
    } else {
        $res = $conn->query($yon === 'next' 
            ? "SELECT id FROM haberler ORDER BY id ASC LIMIT 1" 
            : "SELECT id FROM haberler ORDER BY id DESC LIMIT 1"
        );
        $row = $res->fetch_assoc();
        echo $row['id'] ?? 0;
    }
    exit;
}

// Haber çek
$stmt = $conn->prepare("SELECT * FROM haberler WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$haber = $res->fetch_assoc();
$stmt->close();

if (!$haber) {
    echo "Haber bulunamadı.";
    exit;
}

// --- Yorumlar çekme fonksiyonu ---
function yorumlariGetir($conn, $haber_id) {
    $stmt = $conn->prepare("SELECT * FROM yorumlar WHERE haber_id = ? ORDER BY tarih DESC");
    $stmt->bind_param("i", $haber_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $yorumlar = [];
    while($row = $result->fetch_assoc()){
        $yorumlar[] = $row;
    }
    $stmt->close();
    return $yorumlar;
}

$yorumlar = yorumlariGetir($conn, $id);

// --- AJAX ile yorum ekleme ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_ekle'])) {
    header('Content-Type: application/json; charset=utf-8');

    if (!isset($_SESSION['kullanici']['id'])) {
        echo json_encode(['error' => 'Yorum yapmak için giriş yapmanız gerekiyor.']);
        exit;
    }

    $yorum = trim($_POST['yorum'] ?? '');
    if ($yorum === '') {
        echo json_encode(['error' => 'Yorum boş olamaz.']);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO yorumlar (haber_id, haber_baslik, uye_id, uye_isim, email, yorum)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "isisss",
        $id,
        $haber['baslik'],
        $_SESSION['kullanici']['id'],
        $_SESSION['kullanici']['username'],
        $_SESSION['kullanici']['email'],
        $yorum
    );
    $stmt->execute();
    $stmt->close();

    $yorumlar = yorumlariGetir($conn, $id);

    $yorum_html = '';
    foreach ($yorumlar as $y) {
        $yorum_html .= '
        <div class="yorum">
            <i class="bi bi-person-circle"></i>
            <div>
                <strong>'.htmlspecialchars($y['uye_isim']).'</strong>
                <div class="yorum-email">'.htmlspecialchars($y['email']).'</div>
                <small>'.htmlspecialchars($y['tarih']).'</small>
                <p>'.nl2br(htmlspecialchars($y['yorum'])).'</p>
            </div>
        </div>';
    }

    echo json_encode(['success' => 'Yorum gönderildi.', 'yorum_html' => $yorum_html]);
    exit;
}
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<title><?= htmlspecialchars($haber['baslik']) ?></title>
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
/* 🔹 Arka plan resmi eklendi */
body { 
    background: url('assets/img/saha.png') no-repeat center center fixed; 
    background-size: cover;
    font-family: Arial, sans-serif; 
}
.header { display:flex; justify-content:space-between; align-items:center; padding:10px 20px; background:#fff; border-bottom:1px solid #ddd; }
.header .left button { background:#007bff; color:#fff; border:none; padding:5px 10px; border-radius:4px; cursor:pointer; }
.haber-container { max-width:900px; margin:20px auto; background: rgba(255,255,255,0.95); border-radius:8px; padding:20px; position:relative; }
.haber-nav { position:absolute; top:20px; right:20px; display:flex; gap:10px; }
.haber-nav i { font-size:28px; cursor:pointer; color:#007bff; transition:0.2s; }
.haber-nav i:hover { color:#0056b3; transform:scale(1.1); }

.yorum-formu textarea { width:100%; border:1px solid #ccc; border-radius:6px; padding:10px; resize:vertical; }
.yorum-formu button { margin-top:10px; background:#c80000; color:#fff; border:none; padding:10px 18px; border-radius:4px; }
.yorum { display:flex; align-items:flex-start; border-bottom:1px solid #eee; padding:15px 0; }
.yorum i { font-size:30px; color:#666; margin-right:12px; }
.yorum-email { font-size:12px; color:#555; }
.msg { margin-top:15px; padding:10px; border-radius:5px; display:none; }
</style>
</head>
<body>

<div class="header">
  <div class="left">
    <button onclick="window.location.href='index.php'"><i class="bi bi-arrow-left"></i> Geri</button>
    <strong>Futbol Haberleri</strong>
  </div>
  <div class="right">
    <?php if(isset($_SESSION['kullanici'])): ?>
      Hoşgeldin, <?= htmlspecialchars($_SESSION['kullanici']['username']) ?>
    <?php endif; ?>
  </div>
</div>

<div class="container haber-container">
  
  <!-- 🔹 Haber kaydırma ikonları -->
  <div class="haber-nav">
    <i class="bi bi-arrow-left-circle" id="prevHaber" title="Önceki Haber"></i>
    <i class="bi bi-arrow-right-circle" id="nextHaber" title="Sonraki Haber"></i>
  </div>

  <h1><?= htmlspecialchars($haber['baslik']) ?></h1>

  <?php if(!empty($haber['resim'])): ?>
    <img src="<?= htmlspecialchars($haber['resim']) ?>" alt="<?= htmlspecialchars($haber['baslik']) ?>" class="img-fluid rounded mb-3">
  <?php endif; ?>

  <?php if(!empty($haber['alt_baslik'])): ?>
    <h4><?= htmlspecialchars($haber['alt_baslik']) ?></h4>
  <?php endif; ?>

  <p><?= nl2br(htmlspecialchars($haber['icerik'])) ?></p>
  <hr>

  <!-- Yorum Bölümü -->
  <div class="msg" id="msgBox"></div>

  <?php if(isset($_SESSION['kullanici'])): ?>
    <form id="yorumForm" class="yorum-formu">
      <textarea name="yorum" rows="4" maxlength="500" placeholder="Yorumunuzu yazın..." required></textarea>
      <button type="submit">Gönder</button>
    </form>
  <?php else: ?>
    <p>
      Yorum yapmak için 
      <a href="login.php">giriş yapın</a> veya 
      <a href="register.php">kayıt olun</a>.
    </p>
  <?php endif; ?>

  <!-- 🔹 Yorumlar artık HERKESE görünüyor -->
  <h4 class="mt-4">Yorumlar (<?= count($yorumlar) ?>)</h4>
  <div id="yorumlarContainer">
      <?php if(count($yorumlar) > 0): ?>
          <?php foreach($yorumlar as $y): ?>
          <div class="yorum">
              <i class="bi bi-person-circle"></i>
              <div>
                  <strong><?= htmlspecialchars($y['uye_isim']) ?></strong>
                  <div class="yorum-email"><?= htmlspecialchars($y['email']) ?></div>
                  <small><?= htmlspecialchars($y['tarih']) ?></small>
                  <p><?= nl2br(htmlspecialchars($y['yorum'])) ?></p>
              </div>
          </div>
          <?php endforeach; ?>
      <?php else: ?>
          <p>Henüz yorum yapılmamış. İlk yorumu siz yazın!</p>
      <?php endif; ?>
  </div>
</div>

<script>
$(function(){
  // 🔹 Yorum gönderme işlemi
  $('#yorumForm').on('submit', function(e){
    e.preventDefault();
    $.post('haber-detay.php?id=<?= $id ?>', $(this).serialize() + '&ajax_ekle=1', function(res){
      if(res.error){
        $('#msgBox').text(res.error).css({'background':'#f8d7da','color':'#721c24'}).show();
      } else {
        $('#msgBox').text(res.success).css({'background':'#d4edda','color':'#155724'}).show();
        $('#yorumlarContainer').html(res.yorum_html);
        $('#yorumForm')[0].reset();
      }
    }, 'json');
  });

  // 🔹 Önceki / Sonraki haber
  $('#nextHaber, #prevHaber').on('click', function(){
    const yon = $(this).attr('id') === 'nextHaber' ? 'next' : 'prev';
    $.get('haber-detay.php?ajax_haber=' + yon + '&id=<?= $id ?>', function(yeniId){
      if(yeniId && yeniId != 0){
        window.location.href = 'haber-detay.php?id=' + yeniId;
      }
    });
  });
});
</script>
</body>
</html>
