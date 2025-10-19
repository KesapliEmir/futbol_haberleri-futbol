<?php
session_start();
require '../db.php'; // Veritabanı bağlantısı

if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}

// Düzenleme için mevcut yorum
$editYorum = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM gunun_yorumu WHERE id = ?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $result = $stmt->get_result();
    $editYorum = $result->fetch_assoc();
    $stmt->close();
}

// Yorum ekleme/güncelleme
if (isset($_POST['save'])) {
    $id = $_POST['id'] ?? 0;
    $takim_adi = trim($_POST['takim_adi']);
    $baslik = trim($_POST['baslik']);
    $yorum = trim($_POST['yorum']);

    $resimPath = $_POST['eski_resim'] ?? 'assets/img/default.jpg';
    if (isset($_FILES['resim']) && $_FILES['resim']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['resim']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (in_array($ext, $allowed)) {
            $uploadDir = '../assets/img/';
            if(!is_dir($uploadDir)) mkdir($uploadDir,0755,true);
            $filename = uniqid('yorum_').'.'.$ext;
            move_uploaded_file($_FILES['resim']['tmp_name'],$uploadDir.$filename);
            $resimPath = 'assets/img/'.$filename;
        }
    }

    if ($id > 0) {
        $stmt = $conn->prepare("UPDATE gunun_yorumu SET takim_adi=?, baslik=?, yorum=?, resim=? WHERE id=?");
        $stmt->bind_param('ssssi', $takim_adi, $baslik, $yorum, $resimPath, $id);
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO gunun_yorumu (takim_adi, baslik, yorum, resim) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $takim_adi, $baslik, $yorum, $resimPath);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: gunun-yorumu.php');
    exit;
}

// Yorum silme
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM gunun_yorumu WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: gunun-yorumu.php');
    exit;
}

// Tüm yorumları çek
$yorumlar = $conn->query("SELECT * FROM gunun_yorumu ORDER BY tarih DESC");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Paneli - Günün Yorumu</title>
<link rel="stylesheet" href="style.css">
<style>
td { max-width: 300px; white-space: normal; word-wrap: break-word; vertical-align: top; }
table { border-collapse: collapse; width: 100%; margin-top: 20px;}
th, td { border:1px solid #ccc; padding:8px; text-align:left;}
th { background:#f5f5f5;}
img { border-radius:5px;}
form { margin-bottom: 30px;}
form div { display: flex; gap: 10px; align-items: center; margin-top: 10px; }
a.btn { background: #007bff; color: #fff; padding: 6px 10px; text-decoration: none; border-radius: 5px; }
a.btn:hover { background: #0056b3; }
button { background: #28a745; color: #fff; padding: 6px 10px; border: none; border-radius: 5px; cursor: pointer; }
button:hover { background: #218838; }
</style>
</head>
<body>
<header class="topbar">
  <h1>Admin Paneli - Günün Yorumu</h1>
  <div class="right"><a href="logout.php">Çıkış</a></div>
</header>

<main class="container">

<!-- Yorum Ekle/Düzenle -->
<section class="card">
    <h2><?= $editYorum ? "Yorumu Düzenle (#{$editYorum['id']})" : "Yeni Yorum Ekle" ?></h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $editYorum['id'] ?? '' ?>">
        <input type="hidden" name="eski_resim" value="<?= $editYorum['resim'] ?? 'assets/img/default.jpg' ?>">
        
        <label>Takım Adı:</label><br>
        <input type="text" name="takim_adi" placeholder="Takım Adı" required value="<?= htmlspecialchars($editYorum['takim_adi'] ?? '') ?>"><br><br>
        
        <label>Başlık:</label><br>
        <input type="text" name="baslik" placeholder="Başlık" required value="<?= htmlspecialchars($editYorum['baslik'] ?? '') ?>"><br><br>
        
        <label>Yorum:</label><br>
        <textarea name="yorum" placeholder="Yorum" rows="5" required><?= htmlspecialchars($editYorum['yorum'] ?? '') ?></textarea><br><br>
        
        <label>Resim:</label><br>
        <input type="file" name="resim"><br>
        <?php if(!empty($editYorum['resim'])): ?>
            <p>Mevcut resim:<br><img src="../<?= $editYorum['resim'] ?>" width="120"></p>
        <?php endif; ?>
        
        <div>
            <button type="submit" name="save"><?= $editYorum ? "Güncelle" : "Ekle" ?></button>
            <a class="btn" href="admin-panel.php">← Geri</a>
        </div>
    </form>
</section>

<!-- Mevcut Yorumlar -->
<section class="card">
    <h2>Mevcut Yorumlar</h2>
    <table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Takım</th>
        <th>Başlık</th>
        <th>Yorum</th>
        <th>Resim</th>
        <th>Tarih</th>
        <th>İşlem</th>
    </tr>
    <?php while($y = $yorumlar->fetch_assoc()): ?>
    <tr>
        <td><?= $y['id'] ?></td>
        <td><?= htmlspecialchars($y['takim_adi']) ?></td>
        <td><?= htmlspecialchars($y['baslik']) ?></td>
        <td><?= nl2br(htmlspecialchars($y['yorum'])) ?></td>
        <td><?php if($y['resim']): ?><img src="../<?= $y['resim'] ?>" width="60"><?php endif; ?></td>
        <td><?= $y['tarih'] ?></td>
        <td>
            <a class="btn" href="gunun-yorumu.php?edit=<?= $y['id'] ?>">Düzenle</a> | 
            <a class="btn" href="gunun-yorumu.php?delete=<?= $y['id'] ?>" onclick="return confirm('Silinsin mi?')">Sil</a>
        </td>
    </tr>
    <?php endwhile; ?>
    </table>
</section>

</main>
</body>
</html>
