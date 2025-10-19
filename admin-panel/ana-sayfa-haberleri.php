<?php
session_start();
require 'db.php'; 
if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}
// Düzenleme işlemi için mevcut haberin verilerini çek
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
    // ... resim yükleme kodu ...
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
    header('Location: admin-panel.php');
    exit;
}

// Haber silme işlemi
if (isset($_GET['delete_haber'])) {
    $id = (int)$_GET['delete_haber'];
    $stmt = $conn->prepare('DELETE FROM gunun_haberleri WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: admin-panel.php');
    exit;
}

// Günün haberlerini çek
$haberler = $conn->query("SELECT * FROM gunun_haberleri ORDER BY tarih DESC");


// Düzenleme işlemi için mevcut haberin verilerini çek
$editHaber = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM haberler WHERE id = ?");
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
    $icerik = $_POST['icerik'];

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
            $stmt = $conn->prepare("UPDATE haberler SET baslik=?, icerik=?, resim=? WHERE id=?");
            $stmt->bind_param('sssi', $baslik, $icerik, $resimPath, $id);
        } else {
            $stmt = $conn->prepare("UPDATE haberler SET baslik=?, icerik=? WHERE id=?");
            $stmt->bind_param('ssi', $baslik, $icerik, $id);
        }
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO haberler (baslik, icerik, resim) VALUES (?,?,?)");
        $stmt->bind_param('sss', $baslik, $icerik, $resimPath);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: admin-panel.php');
    exit;
}

// Haber silme işlemi
if (isset($_GET['delete_haber'])) {
    $id = (int)$_GET['delete_haber'];
    $stmt = $conn->prepare('DELETE FROM haberler WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: admin-panel.php');
    exit;
}

// Haberleri çek
$haberler = $conn->query("SELECT * FROM haberler ORDER BY tarih DESC");

// Mesajları çek
$mesajlar = $conn->query('SELECT * FROM mesajlar ORDER BY tarih DESC');
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Paneli - Haberler</title>
<link rel="stylesheet" href="style.css">

<!-- 🔹 Uzun yazıların tam görünmesi için CSS -->
<style>
td {
  max-width: 300px;
  white-space: normal;
  word-wrap: break-word;
  vertical-align: top;
}
</style>
</head>
<body>
<header class="topbar">
  <h1>Admin Paneli</h1>
  <div class="right">Hoşgeldin, <?php echo htmlspecialchars($_SESSION['admin']['username']); ?> | <a href="logout.php">Çıkış</a></div>
</header>

<main class="container">

  <!-- Haber Ekle/Düzenle -->
  <section class="card">
    <h2><?= $editHaber ? "Haber Düzenle (#{$editHaber['id']})" : "Yeni Haber Ekle" ?></h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $editHaber['id'] ?? '' ?>">
        <input type="text" name="baslik" placeholder="Başlık" required value="<?= htmlspecialchars($editHaber['baslik'] ?? '') ?>">
        <textarea name="icerik" placeholder="Haber içeriği" required><?= htmlspecialchars($editHaber['icerik'] ?? '') ?></textarea>
        <input type="file" name="resim" accept="image/*">
        <?php if (!empty($editHaber['resim'])): ?>
            <p>Mevcut resim:<br><img src="../<?= $editHaber['resim'] ?>" width="120"></p>
        <?php endif; ?>
        <button type="submit" name="save">Kaydet</button>
    </form>
  </section>

  <!-- Mevcut Haberler -->
  <section class="card">
    <h2>Mevcut Haberler</h2>
    <table border="1" cellpadding="5">
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
        <td><?= htmlspecialchars($h['icerik']) ?></td>
        <td><?php if($h['resim']): ?><img src="../<?= $h['resim'] ?>" width="60"><?php endif; ?></td>
        <td>
            <a href="admin-panel.php?edit=<?= $h['id'] ?>">Düzenle</a>
            <a href="admin-panel.php?delete_haber=<?= $h['id'] ?>" onclick="return confirm('Silinsin mi?')">Sil</a>
        </td>
    </tr>
    <?php endwhile; ?>
    </table>
  </section>

  <!-- SON DAKİKA HABERLERİ -->
<?php if (isset($_GET['page']) && $_GET['page'] == 'son-dakika-haberleri'): ?>
<h2>🕒 Son Dakika Haberleri</h2>

<?php
// Ekleme işlemi
if (isset($_POST['ekle'])) {
    $baslik = $conn->real_escape_string($_POST['baslik']);
    $aciklama = $conn->real_escape_string($_POST['aciklama']);
    $detay = $conn->real_escape_string($_POST['detay']);
    $resim = $conn->real_escape_string($_POST['resim']);

    $sql = "INSERT INTO son_dakika_haberleri (baslik, aciklama, detay, resim)
            VALUES ('$baslik', '$aciklama', '$detay', '$resim')";
    if ($conn->query($sql)) {
        echo "<p style='color:green;'>✅ Haber başarıyla eklendi!</p>";
    } else {
        echo "<p style='color:red;'>❌ Hata: " . $conn->error . "</p>";
    }
}

// Silme işlemi
if (isset($_GET['sil'])) {
    $id = intval($_GET['sil']);
    $conn->query("DELETE FROM son_dakika_haberleri WHERE id=$id");
    echo "<p style='color:red;'>🗑️ Haber silindi!</p>";
}

// Güncelleme işlemi
if (isset($_POST['guncelle'])) {
    $id = intval($_POST['id']);
    $baslik = $conn->real_escape_string($_POST['baslik']);
    $aciklama = $conn->real_escape_string($_POST['aciklama']);
    $detay = $conn->real_escape_string($_POST['detay']);
    $resim = $conn->real_escape_string($_POST['resim']);

    $conn->query("UPDATE son_dakika_haberleri 
                  SET baslik='$baslik', aciklama='$aciklama', detay='$detay', resim='$resim' 
                  WHERE id=$id");
    echo "<p style='color:blue;'>✏️ Haber güncellendi!</p>";
}
?>
