<?php
session_start();
require 'db.php';
if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Silme işlemleri (yorum silme) ---
if (isset($_GET['delete_yorum']) && is_numeric($_GET['delete_yorum'])) {
    $delId = (int)$_GET['delete_yorum'];
    $delStmt = $conn->prepare("DELETE FROM yorumlar WHERE id = ?");
    $delStmt->bind_param("i", $delId);
    $delStmt->execute();
    $delStmt->close();
    header('Location: admin-panel.php');
    exit;
}

// --- Veritabanı sorguları ---
$mesajlar = $conn->query("SELECT * FROM mesajlar ORDER BY tarih DESC");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Paneli</title>
<style>
body{font-family:Arial,sans-serif;background:#f5f6f7;margin:0;}
header{background:#2c3e50;color:#fff;padding:15px;display:flex;justify-content:space-between;align-items:center;}
.container{padding:20px;}
nav{display:flex;gap:10px;flex-wrap:wrap;justify-content:center;margin-bottom:20px;}
nav a{background:#007bff;color:#fff;padding:10px 18px;text-decoration:none;border-radius:6px;transition:0.2s;}
nav a:hover{background:#0056b3;}
nav a.active{background:#28a745;}
.card{background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.1);margin-bottom:20px;}
table{width:100%;border-collapse:collapse;margin-top:15px;}
th,td{border:1px solid #ccc;padding:8px;text-align:left;vertical-align:top;}
th{background:#eee;}
.actions a{margin-right:8px;color:#007bff;text-decoration:none;}
.actions a:hover{text-decoration:underline;}
.top-info{display:flex;gap:12px;align-items:center;}
.logout-form{display:inline;margin:0;padding:0;}
.btn-plain{background:none;border:none;color:#fff;cursor:pointer;padding:0;font:inherit;text-decoration:underline;}
.small-muted{font-size:12px;color:#666;}
</style>
</head>
<body>
<header>
  <h1>Admin Paneli</h1>
  <div class="top-info">
    <div>Hoşgeldin, <?= htmlspecialchars($_SESSION['admin']['username']) ?></div>
    <form method="post" action="/futbol_haberleri/logout.php" class="logout-form">
      <button type="submit" class="btn-plain">Çıkış Yap</button>
    </form>
  </div>
</header>

<div class="container">
  <!-- Sekmeler -->
<nav>
  <a href="ana-sayfa-haber-ekle.php">Ana Sayfa Haber Ekle</a>
  <a href="?tab=mesajlar">Mesajlar / Forum</a>
  <a href="yorumlar.php">Yorumlar</a>
  <a href="puan-tablosu.php">Puan Tablosu</a>
  <a href="haftanin-karsilasmalar.php">Haftanın Karşılaşmaları</a>
  <a href="gunun-haberleri.php">Günün Haberleri</a>
  <a href="son-dakika-haberleri.php">Son Dakika</a>
  <a href="gunun-yorumu.php">Günün Yorumu</a>
</nav>

  <!-- Mesajlar / Forum -->
  <section class="card">
    <h2>Mesajlar / Forum</h2>
    <table>
      <tr><th>ID</th><th>İsim</th><th>Email</th><th>Konu</th><th>Mesaj</th><th>Tarih</th><th>Sil</th></tr>
      <?php while($m = $mesajlar->fetch_assoc()): ?>
      <tr>
        <td><?= $m['id'] ?></td>
        <td><?= htmlspecialchars($m['isim']) ?></td>
        <td><?= htmlspecialchars($m['email']) ?></td>
        <td><?= htmlspecialchars($m['konu']) ?></td>
        <td><?= nl2br(htmlspecialchars($m['mesaj'])) ?></td>
        <td class="small-muted"><?= $m['tarih'] ?></td>
        <td><a href="mesajlar.php?delete=<?= $m['id'] ?>" onclick="return confirm('Silinsin mi?')">Sil</a></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </section>
</div>
</body>
</html>
