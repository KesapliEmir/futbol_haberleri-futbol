<?php
session_start();
require '../db.php'; // db.php içinde $conn tanımlı olmalı

if (!isset($_SESSION['admin'])) {
    die('Yetkisiz erişim.');
}

$mesaj = '';
$baslik = $icerik = '';
$editHaber = null;

// Düzenleme için
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM haberler WHERE id=?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $result = $stmt->get_result();
    $editHaber = $result->fetch_assoc();
    $stmt->close();

    if ($editHaber) {
        $baslik = $editHaber['baslik'];
        $icerik = $editHaber['icerik'];
    }
}

// Haber ekleme/güncelleme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? 0;
    $baslik = trim($_POST['baslik'] ?? '');
    $icerik = trim($_POST['icerik'] ?? '');
    $resimPath = $editHaber['resim'] ?? '';

    // Resim yükleme
    if (!empty($_FILES['resim']['name'])) {
        $ext = strtolower(pathinfo($_FILES['resim']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];

        if (!in_array($ext, $allowed)) {
            $mesaj = "❌ Yalnızca JPG, JPEG, PNG, GIF veya WEBP formatları yüklenebilir.";
        } else {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir,0755,true);

            $fileName = uniqid('haber_') . '.' . $ext;
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['resim']['tmp_name'], $filePath)) {
                $resimPath = 'uploads/' . $fileName;
            } else {
                $mesaj = "❌ Resim yüklenirken bir hata oluştu.";
            }
        }
    }

    // Veritabanı işlemi
    if (!$mesaj) {
        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE haberler SET baslik=?, icerik=?, resim=? WHERE id=?");
            $stmt->bind_param("sssi", $baslik, $icerik, $resimPath, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO haberler (baslik, icerik, resim, tarih) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $baslik, $icerik, $resimPath);
        }

        if ($stmt->execute()) {
            $mesaj = "✅ Haber başarıyla kaydedildi.";
            $baslik = $icerik = '';
        } else {
            $mesaj = "❌ Veritabanı hatası: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Haber silme
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM haberler WHERE id=?");
    $stmt->bind_param("i", $delId);
    $stmt->execute();
    $stmt->close();
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}

// Mevcut haberleri çek
$haberler = $conn->query("SELECT * FROM haberler ORDER BY tarih DESC");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Paneli - Haberler</title>
<style>
body { font-family: Arial; background:#f5f5f5; padding:20px; }
.container { background:#fff; padding:20px; max-width:900px; margin:auto; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1);}
h2 { text-align:center; margin-bottom:20px; }
input[type=text], textarea { width:100%; padding:10px; margin:6px 0 12px; border:1px solid #ccc; border-radius:4px; }
button, .btn { padding:6px 12px; border:none; border-radius:4px; text-decoration:none; color:#fff; cursor:pointer; }
button { background-color:#28a745; }
.btn { background-color:#6c757d; }
button:hover { opacity:0.9; }
table { width:100%; border-collapse:collapse; margin-top:20px; }
th, td { border:1px solid #ccc; padding:8px; text-align:left; vertical-align:top; }
td img { max-width:80px; }
.msg { padding:10px; margin-bottom:12px; border-radius:4px; font-weight:bold; }
.msg.success { background:#d4edda; color:#155724; border:1px solid #c3e6cb; }
.msg.error { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }
</style>
</head>
<body>
<div class="container">
    <h2><?= $editHaber ? "Haber Düzenle (#{$editHaber['id']})" : "Yeni Haber Ekle" ?></h2>

    <?php if($mesaj): ?>
        <div class="msg <?= str_contains($mesaj,'✅') ? 'success' : 'error' ?>">
            <?= htmlspecialchars($mesaj) ?>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $editHaber['id'] ?? '' ?>">

        <label>Başlık</label>
        <input type="text" name="baslik" required value="<?= htmlspecialchars($baslik) ?>">

        <label>İçerik</label>
        <textarea name="icerik" rows="5" required><?= htmlspecialchars($icerik) ?></textarea>

        <label>Resim</label>
        <input type="file" name="resim" accept="image/*">
        <?php if(!empty($editHaber['resim'])): ?>
            <p>Mevcut resim:<br><img src="../<?= $editHaber['resim'] ?>"></p>
        <?php endif; ?>

        <div style="margin-top:10px;">
            <button type="submit"><?= $editHaber ? "Güncelle" : "Kaydet" ?></button>
        </div>
    </form>

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
            <td><?php if($h['resim']): ?><img src="../<?= $h['resim'] ?>"><?php endif; ?></td>
            <td>
                <a href="?edit=<?= $h['id'] ?>" class="btn">Düzenle</a>
                <a href="?delete=<?= $h['id'] ?>" class="btn" onclick="return confirm('Silinsin mi?')">Sil</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
