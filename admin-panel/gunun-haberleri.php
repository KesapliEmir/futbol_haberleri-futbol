<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}

// Düzenleme için mevcut haber
$editHaber = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM gunun_haberleri WHERE id = ?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $result = $stmt->get_result();
    $editHaber = $result->fetch_assoc();
    $stmt->close();
}

// Haber ekleme/güncelleme
if (isset($_POST['save'])) {
    $id = $_POST['id'] ?? 0;
    $baslik = $_POST['baslik'];
    $aciklama = $_POST['aciklama'];
    $detay = $_POST['detay'];

    $resimPath = null;
    if (isset($_FILES['resim']) && $_FILES['resim']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['resim']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (in_array($ext, $allowed)) {
            $uploadDir = '../assets/img/';
            if(!is_dir($uploadDir)) mkdir($uploadDir,0755,true);
            $filename = uniqid('haber_').'.'.$ext;
            move_uploaded_file($_FILES['resim']['tmp_name'],$uploadDir.$filename);
            $resimPath = 'assets/img/'.$filename;
        }
    }

    if ($id > 0) {
        if ($resimPath) {
            $stmt = $conn->prepare("UPDATE gunun_haberleri SET baslik=?, aciklama=?, detay=?, resim=? WHERE id=?");
            $stmt->bind_param('ssssi', $baslik, $aciklama, $detay, $resimPath, $id);
        } else {
            $stmt = $conn->prepare("UPDATE gunun_haberleri SET baslik=?, aciklama=?, detay=? WHERE id=?");
            $stmt->bind_param('sssi', $baslik, $aciklama, $detay, $id);
        }
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO gunun_haberleri (baslik, aciklama, detay, resim) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $baslik, $aciklama, $detay, $resimPath);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: gunun-haberleri.php');
    exit;
}

// Haber silme
if (isset($_GET['delete_haber'])) {
    $id = (int)$_GET['delete_haber'];
    $stmt = $conn->prepare('DELETE FROM gunun_haberleri WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: gunun-haberleri.php');
    exit;
}

// Haberleri çek
$haberler = $conn->query("SELECT * FROM gunun_haberleri ORDER BY tarih DESC");
if (!$haberler) {
    die("Haberler sorgusunda hata: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Paneli - Günün Haberleri</title>
<link rel="stylesheet" href="style.css">
<style>
td { max-width: 300px; white-space: normal; word-wrap: break-word; vertical-align: top; }
button, .btn { padding: 6px 12px; border: none; border-radius: 4px; text-decoration: none; color: #fff; cursor: pointer; }
button { background-color: #28a745; }
.btn { background-color: #6c757d; }
form div { display: flex; gap: 10px; margin-top: 10px; align-items: center; }
</style>
</head>
<body>

<header class="topbar">
  <h1>Admin Paneli - Günün Haberleri</h1>
</header>

<main class="container">

<!-- Haber Ekle/Düzenle -->
<section class="card">
    <h2><?= $editHaber ? "Haber Düzenle (#{$editHaber['id']})" : "Yeni Haber Ekle" ?></h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $editHaber['id'] ?? '' ?>">
        <input type="text" name="baslik" placeholder="Başlık" required value="<?= htmlspecialchars($editHaber['baslik'] ?? '') ?>">
        <input type="text" name="aciklama" placeholder="Kısa Açıklama" required value="<?= htmlspecialchars($editHaber['aciklama'] ?? '') ?>">
        <textarea name="detay" placeholder="Detay" required><?= htmlspecialchars($editHaber['detay'] ?? '') ?></textarea>
        <input type="file" name="resim" accept="image/*">
        <?php if (!empty($editHaber['resim'])): ?>
            <p>Mevcut resim:<br><img src="../<?= $editHaber['resim'] ?>" width="120"></p>
        <?php endif; ?>
        <div>
            <button type="submit" name="save"><?= $editHaber ? "Kaydet" : "Ekle" ?></button>
            <a href="admin-panel.php" class="btn">Geri</a>
        </div>
    </form>
</section>

<!-- Mevcut Haberler -->
<section class="card">
    <h2>Mevcut Günün Haberleri</h2>
    <table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Başlık</th>
        <th>Açıklama</th>
        <th>Detay</th>
        <th>Resim</th>
        <th>İşlem</th>
    </tr>
    <?php while($h = $haberler->fetch_assoc()): ?>
    <tr>
        <td><?= $h['id'] ?></td>
        <td><?= htmlspecialchars($h['baslik']) ?></td>
        <td><?= htmlspecialchars($h['aciklama']) ?></td>
        <td><?= nl2br(htmlspecialchars($h['detay'])) ?></td>
        <td><?php if($h['resim']): ?><img src="../<?= $h['resim'] ?>" width="60"><?php endif; ?></td>
        <td>
            <a href="gunun-haberleri.php?edit=<?= $h['id'] ?>">Düzenle</a> |
            <a href="gunun-haberleri.php?delete_haber=<?= $h['id'] ?>" onclick="return confirm('Silinsin mi?')">Sil</a>
        </td>
    </tr>
    <?php endwhile; ?>
    </table>
</section>

</main>
</body>
</html>
