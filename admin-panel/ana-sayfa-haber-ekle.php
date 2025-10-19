<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}

// Haber ekleme / güncelleme
if (isset($_POST['save'])) {
    $id = $_POST['id'] ?? 0;
    $baslik = $_POST['baslik'];
    $icerik = $_POST['icerik'];
    $resimPath = null;

    if (isset($_FILES['resim']) && $_FILES['resim']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['resim']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (in_array($ext, $allowed)) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $filename = uniqid('haber_') . '.' . $ext;
            move_uploaded_file($_FILES['resim']['tmp_name'], $uploadDir . $filename);
            $resimPath = 'uploads/' . $filename;
        }
    }

    if ($id > 0) {
        if ($resimPath) {
            $stmt = $conn->prepare("UPDATE haberler SET baslik=?, icerik=?, resim=? WHERE id=?");
            $stmt->bind_param("sssi", $baslik, $icerik, $resimPath, $id);
        } else {
            $stmt = $conn->prepare("UPDATE haberler SET baslik=?, icerik=? WHERE id=?");
            $stmt->bind_param("ssi", $baslik, $icerik, $id);
        }
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO haberler (baslik, icerik, resim, tarih) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $baslik, $icerik, $resimPath);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: ana-sayfa-haber-ekle.php');
    exit;
}

// Haber silme
if (isset($_POST['delete'])) {
    $id = intval($_POST['delete']);
    $stmt = $conn->prepare("DELETE FROM haberler WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: ana-sayfa-haber-ekle.php');
    exit;
}

// Mevcut haberleri çek
$haberler = $conn->query("SELECT * FROM haberler ORDER BY tarih DESC");

// Düzenlenecek haber
$editHaber = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editHaber = $conn->query("SELECT * FROM haberler WHERE id=$id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Haberler</title>
<style>
body{font-family:Arial,sans-serif;background:#f5f6f7;margin:0;padding:20px;}
.card{background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.1);max-width:900px;margin:auto;margin-bottom:20px;}
input[type=text], textarea{width:100%;padding:10px;margin:6px 0 12px;border:1px solid #ccc;border-radius:4px;}
button, .btn{padding:6px 12px;border:none;border-radius:4px;color:#fff;text-decoration:none;cursor:pointer;}
button{background-color:#28a745;}
.btn{background-color:#6c757d;}
.btn-delete{background-color:#dc3545;}
img.thumb{max-width:120px;max-height:80px;border-radius:4px;margin-top:8px;}
td{max-width:300px;word-wrap:break-word;vertical-align:top;}
table{width:100%;border-collapse:collapse;}
th, td{padding:8px;border:1px solid #ddd;text-align:left;}
form div{display:flex;gap:10px;margin-top:10px;align-items:center;}
form.delete-form{display:inline;}
</style>
</head>
<body>

<section class="card">
  <h2 id="form-title"><?= $editHaber ? "Haberi Düzenle (#".$editHaber['id'].")" : "Yeni Haber Ekle" ?></h2>
  <form id="haber-form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="haber-id" value="<?= $editHaber['id'] ?? '' ?>">
    <label>Başlık</label>
    <input type="text" name="baslik" id="haber-baslik" required value="<?= htmlspecialchars($editHaber['baslik'] ?? '') ?>">
    <label>İçerik</label>
    <textarea name="icerik" id="haber-icerik" rows="6" required><?= htmlspecialchars($editHaber['icerik'] ?? '') ?></textarea>
    <label>Resim</label>
    <input type="file" name="resim" accept="image/*">
    <?php if (!empty($editHaber['resim'])): ?>
        <p>Mevcut resim:<br><img src="../<?= $editHaber['resim'] ?>" width="120"></p>
    <?php endif; ?>
    <div>
        <button type="submit" name="save"><?= $editHaber ? "Güncelle" : "Kaydet" ?></button>
        <a href="admin-panel.php" class="btn">Geri</a>
    </div>
  </form>
</section>

<section class="card">
  <h2>Mevcut Haberler</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Başlık</th>
      <th>İçerik</th>
      <th>Resim</th>
      <th>İşlem</th>
    </tr>
    <?php while($h = $haberler->fetch_assoc()): ?>
    <tr>
      <td><?= $h['id'] ?></td>
      <td><?= htmlspecialchars($h['baslik']) ?></td>
      <td><?= nl2br(htmlspecialchars($h['icerik'])) ?></td>
      <td><?php if($h['resim']): ?><img src="../<?= $h['resim'] ?>" width="60"><?php endif; ?></td>
      <td>
        <a class="btn" href="?edit=<?= $h['id'] ?>">Düzenle</a>
        <form method="post" class="delete-form" onsubmit="return confirm('Bu haberi silmek istediğinizden emin misiniz?')">
            <input type="hidden" name="delete" value="<?= $h['id'] ?>">
            <button type="submit" class="btn-delete">Sil</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</section>

</body>
</html>
