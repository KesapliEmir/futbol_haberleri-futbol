<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}

$editTakim = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM puan_tablosu WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editTakim = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if (isset($_POST['save'])) {
    $id = $_POST['id'] ?? 0;
    $takim_adi = trim($_POST['takim_adi']);
    $puan = (int)$_POST['puan'];
    $renk = trim($_POST['renk']);
    $logoPath = $_POST['eski_logo'] ?? null;

    if (isset($_FILES['logo']) && $_FILES['logo']['error']===0) {
        $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (in_array($ext, $allowed)) {
            $uploadDir = '../assets/img/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $filename = uniqid('logo_').'.'.$ext;
            move_uploaded_file($_FILES['logo']['tmp_name'], $uploadDir.$filename);
            $logoPath = 'assets/img/'.$filename;
        }
    }

    if ($id > 0) {
        $stmt = $conn->prepare("UPDATE puan_tablosu SET takim_adi=?, puan=?, renk=?, logo=? WHERE id=?");
        $stmt->bind_param("sissi", $takim_adi, $puan, $renk, $logoPath, $id);
        $stmt->execute();
        $stmt->close();
    } else {
        $maxSira = $conn->query("SELECT MAX(sira) as maxsira FROM puan_tablosu")->fetch_assoc()['maxsira'] ?? 0;
        $sira = $maxSira + 1;
        $stmt = $conn->prepare("INSERT INTO puan_tablosu (takim_adi, puan, renk, logo, sira) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sisii", $takim_adi, $puan, $renk, $logoPath, $sira);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: puan-tablosu.php");
    exit;
}

if (isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];
    $sira = $conn->query("SELECT sira FROM puan_tablosu WHERE id=$id")->fetch_assoc()['sira'];
    $stmt = $conn->prepare("DELETE FROM puan_tablosu WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    $conn->query("UPDATE puan_tablosu SET sira = sira - 1 WHERE sira > $sira");
    header("Location: puan-tablosu.php");
    exit;
}

if (isset($_POST['move_id']) && isset($_POST['move'])) {
    $id = (int)$_POST['move_id'];
    $direction = $_POST['move'];
    $current = $conn->query("SELECT * FROM puan_tablosu WHERE id=$id")->fetch_assoc();
    if ($current) {
        $currentSira = $current['sira'];
        if ($direction==='up') {
            $swap = $conn->query("SELECT * FROM puan_tablosu WHERE sira < $currentSira ORDER BY sira DESC LIMIT 1")->fetch_assoc();
        } else {
            $swap = $conn->query("SELECT * FROM puan_tablosu WHERE sira > $currentSira ORDER BY sira ASC LIMIT 1")->fetch_assoc();
        }
        if ($swap) {
            $conn->query("UPDATE puan_tablosu SET sira={$swap['sira']} WHERE id={$current['id']}");
            $conn->query("UPDATE puan_tablosu SET sira={$currentSira} WHERE id={$swap['id']}");
        }
    }
    header("Location: puan-tablosu.php");
    exit;
}

$takimlar = $conn->query("SELECT * FROM puan_tablosu ORDER BY sira ASC");
$maxSira = $conn->query("SELECT MAX(sira) as maxsira FROM puan_tablosu")->fetch_assoc()['maxsira'] ?? 0;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Paneli - Puan Tablosu</title>
<style>
body { font-family: Arial; margin:0; background:#f0f2f5; }
header { background:#343a40; color:#fff; padding:15px 20px; display:flex; justify-content:space-between; align-items:center; }
header a { color:#fff; text-decoration:none; font-weight:bold; }
main { max-width:1100px; margin:20px auto; }
.card { background:#fff; padding:20px; border-radius:8px; margin-bottom:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1); }
input, select { width:100%; padding:6px; margin:6px 0; border:1px solid #ccc; border-radius:4px; }
button { cursor:pointer; border:none; border-radius:4px; padding:6px 10px; color:#fff; margin-right:4px; }
button.save { background:#28a745; }
button.delete { background:#dc3545; }
button.move { background:#17a2b8; }
.form-inline { display:inline-block; margin:0; }
table { width:100%; border-collapse:collapse; margin-top:15px; }
th, td { border:1px solid #ddd; padding:10px; text-align:center; }
th { background:#007bff; color:#fff; }
img.logo { width:50px; height:50px; border-radius:50%; object-fit:cover; transition:0.3s; }
.color-bar { height:24px; border-radius:4px; color:#fff; font-weight:bold; display:flex; align-items:center; justify-content:center; }
input[type=file] { padding:3px; }
@media(max-width:768px){ table, thead, tbody, th, td, tr { display:block; } th { display:none; } td { display:flex; justify-content:space-between; padding:8px; margin-bottom:10px; border:none; border-radius:6px; background:#fff; } }
</style>
</head>
<body>
<header>
<h1>Admin Paneli</h1>
<a href="logout.php">Çıkış</a>
</header>
<main>

<div class="card">
<h2><?= $editTakim ? "Takımı Düzenle (#{$editTakim['id']})" : "Yeni Takım Ekle" ?></h2>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $editTakim['id'] ?? '' ?>">
<input type="hidden" name="eski_logo" value="<?= $editTakim['logo'] ?? '' ?>">
<label>Takım Adı:</label>
<input type="text" name="takim_adi" required value="<?= htmlspecialchars($editTakim['takim_adi'] ?? '') ?>">
<label>Puan:</label>
<input type="number" name="puan" required value="<?= $editTakim['puan'] ?? 0 ?>">
<label>Renk (hex veya isim):</label>
<input type="text" name="renk" id="renk" placeholder="#FF0000" value="<?= htmlspecialchars($editTakim['renk'] ?? '') ?>">
<label>Logo:</label>
<input type="file" name="logo" id="logoInput" accept="image/*">
<?php if(!empty($editTakim['logo'])): ?>
<p>Mevcut logo:</p>
<img src="../<?= htmlspecialchars($editTakim['logo']) ?>" class="logo" id="logoPreview">
<?php else: ?>
<img class="logo" id="logoPreview" style="display:none;">
<?php endif; ?>
<div style="margin-top:10px;">
<button type="submit" name="save" class="save"><?= $editTakim ? "Güncelle" : "Ekle" ?></button>
</div>
</form>
</div>

<div class="card">
<h2>Mevcut Takımlar</h2>
<table>
<tr>
<th>Sıra</th><th>Takım</th><th>Logo</th><th>Puan</th><th>Renk</th><th>İşlem</th>
</tr>
<?php while($t = $takimlar->fetch_assoc()): ?>
<tr>
<td><?= $t['sira'] ?></td>
<td><?= htmlspecialchars($t['takim_adi']) ?></td>
<td><?php if($t['logo']): ?><img src="../<?= htmlspecialchars($t['logo']) ?>" class="logo"><?php endif; ?></td>
<td><?= $t['puan'] ?></td>
<td><div class="color-bar" style="background:<?= htmlspecialchars($t['renk']) ?>"><?= htmlspecialchars($t['renk']) ?></div></td>
<td>
<a href="?edit=<?= $t['id'] ?>"><button class="save">Düzenle</button></a>
<form method="post" class="form-inline" onsubmit="return confirm('Silinsin mi?')">
<input type="hidden" name="delete_id" value="<?= $t['id'] ?>">
<button type="submit" class="delete">Sil</button>
</form>
<form method="post" class="form-inline">
<input type="hidden" name="move_id" value="<?= $t['id'] ?>">
<?php if($t['sira']>1): ?><button type="submit" name="move" value="up" class="move">↑</button><?php endif; ?>
<?php if($t['sira']<$maxSira): ?><button type="submit" name="move" value="down" class="move">↓</button><?php endif; ?>
</form>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>

<script>
// Logo önizleme
const logoInput = document.getElementById('logoInput');
const logoPreview = document.getElementById('logoPreview');

logoInput.addEventListener('change', e => {
    const file = e.target.files[0];
    if(file) {
        const reader = new FileReader();
        reader.onload = function(evt){
            logoPreview.src = evt.target.result;
            logoPreview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>

</main>
</body>
</html>
