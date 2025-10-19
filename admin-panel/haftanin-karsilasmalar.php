<?php
session_start();
require 'db.php'; 

if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}

// Maç ekleme/güncelleme işlemi
if (isset($_POST['save'])) {
    $id = $_POST['id'] ?? 0;
    $takimlar = $_POST['takimlar'];
    $aciklama = $_POST['aciklama'];
    $tarih = $_POST['tarih'];
    $kanal = $_POST['kanal'];

    $resimPath = null;
    if (isset($_FILES['resim']) && $_FILES['resim']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['resim']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (in_array($ext, $allowed)) {
            $uploadDir = '../assets/img/';
            if(!is_dir($uploadDir)) mkdir($uploadDir,0755,true);
            $filename = uniqid('mac_').'.'.$ext;
            move_uploaded_file($_FILES['resim']['tmp_name'],$uploadDir.$filename);
            $resimPath = 'assets/img/'.$filename;
        }
    }

    if ($id > 0) {
        if ($resimPath) {
            $stmt = $conn->prepare("UPDATE maclar SET takimlar=?, aciklama=?, tarih=?, kanal=?, resim=? WHERE id=?");
            $stmt->bind_param('sssssi', $takimlar, $aciklama, $tarih, $kanal, $resimPath, $id);
        } else {
            $stmt = $conn->prepare("UPDATE maclar SET takimlar=?, aciklama=?, tarih=?, kanal=? WHERE id=?");
            $stmt->bind_param('ssssi', $takimlar, $aciklama, $tarih, $kanal, $id);
        }
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO maclar (takimlar, aciklama, tarih, kanal, resim) VALUES (?,?,?,?,?)");
        $stmt->bind_param('sssss', $takimlar, $aciklama, $tarih, $kanal, $resimPath);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: haftanin-karsilasmalar.php');
    exit;
}

// Maç silme işlemi
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM maclar WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: haftanin-karsilasmalar.php');
    exit;
}

// Mevcut karşılaşmaları çek
$maclar = $conn->query("SELECT * FROM maclar ORDER BY tarih DESC");

// Düzenleme işlemi için seçilen maçı al
$editMac = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM maclar WHERE id = ?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $result = $stmt->get_result();
    $editMac = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Haftanın Karşılaşmaları</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Maç Ekleme / Güncelleme Formu -->
<section>
    <h2><?= $editMac ? "Maç Düzenle (#{$editMac['id']})" : "Yeni Maç Ekle" ?></h2>
    <form method="post" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:10px; max-width:500px;">
        <input type="hidden" name="id" value="<?= $editMac['id'] ?? '' ?>">
        <input type="text" name="takimlar" placeholder="Takımlar" required value="<?= htmlspecialchars($editMac['takimlar'] ?? '') ?>">
        <textarea name="aciklama" placeholder="Açıklama" required><?= htmlspecialchars($editMac['aciklama'] ?? '') ?></textarea>
        <input type="datetime-local" name="tarih" value="<?= date('Y-m-d\TH:i', strtotime($editMac['tarih'] ?? '')) ?>" required>
        <input type="text" name="kanal" placeholder="Kanal" required value="<?= htmlspecialchars($editMac['kanal'] ?? '') ?>">
        <input type="file" name="resim" accept="image/*">
        <?php if (!empty($editMac['resim'])): ?>
            <p>Mevcut resim:<br><img src="../<?= $editMac['resim'] ?>" width="120"></p>
        <?php endif; ?>
        <div style="display:flex; gap:10px; align-items:center;">
            <button type="submit" name="save">Kaydet</button>
            <a href="admin-panel.php" style="padding:8px 12px;background:#6c757d;color:#fff;text-decoration:none;border-radius:4px;">Geri</a>
        </div>
    </form>
</section>

<!-- Mevcut Karşılaşmaların Listelenmesi -->
<section>
    <h2>Mevcut Karşılaşmalar</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Takımlar</th>
            <th>Açıklama</th>
            <th>Tarih</th>
            <th>Kanal</th>
            <th>Resim</th>
            <th>İşlem</th>
        </tr>
        <?php while($mac = $maclar->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($mac['takimlar']) ?></td>
            <td><?= htmlspecialchars($mac['aciklama']) ?></td>
            <td><?= date('d.m.Y H:i', strtotime($mac['tarih'])) ?></td>
            <td><?= htmlspecialchars($mac['kanal']) ?></td>
            <td><?php if($mac['resim']): ?><img src="../<?= $mac['resim'] ?>" width="100"><?php endif; ?></td>
            <td>
                <a href="haftanin-karsilasmalar.php?edit=<?= $mac['id'] ?>">Düzenle</a> |
                <a href="haftanin-karsilasmalar.php?delete=<?= $mac['id'] ?>" onclick="return confirm('Silinsin mi?')">Sil</a> |
                <a href="admin-panel.php" style="padding:4px 8px;background:#6c757d;color:#fff;text-decoration:none;border-radius:4px;">Geri</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</section>

</body>
</html>
