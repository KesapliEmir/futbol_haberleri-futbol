<?php
session_start();
require '../db.php'; // db bağlantısı

// Admin kontrolü
if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}

// Aktif tab
$tab = $_GET['tab'] ?? 'yorumlar';

// Yorumları çek (uyarı: artık kullanıcı tablosu ile join yok)
$yorumlar = $conn->query("
    SELECT * 
    FROM yorumlar 
    ORDER BY tarih DESC
");

// Silme işlemi
if (isset($_GET['delete_yorum']) && is_numeric($_GET['delete_yorum'])) {
    $delId = (int)$_GET['delete_yorum'];
    $stmt = $conn->prepare("DELETE FROM yorumlar WHERE id=?");
    $stmt->bind_param("i", $delId);
    $stmt->execute();
    $stmt->close();
    header('Location: yorumlar.php?tab=yorumlar');
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Yorumlar - Admin Paneli</title>
<style>
body{font-family:Arial,sans-serif;background:#f5f6f7;margin:0;}
.container{padding:20px;}
.card{background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.1);margin-bottom:20px;}
table{width:100%;border-collapse:collapse;margin-top:15px;}
th,td{border:1px solid #ccc;padding:8px;text-align:left;vertical-align:top;}
th{background:#eee;}
.small-muted{font-size:12px;color:#666;}
.actions a{color:#007bff;text-decoration:none;}
.actions a:hover{text-decoration:underline;}

/* 🔹 Geri butonu stil */
.back-btn {
    display:inline-block;
    margin-bottom:15px;
    padding:8px 15px;
    background:#007bff;
    color:#fff;
    border:none;
    border-radius:5px;
    cursor:pointer;
    text-decoration:none;
    font-weight:600;
    transition:0.2s;
}
.back-btn:hover {
    background:#0056b3;
}
</style>
</head>
<body>
<div class="container">
    <!-- 🔹 Geri butonu -->
    <a href="admin-panel.php" class="back-btn">← Geri</a>

<?php if($tab == 'yorumlar'): ?>
<section class="card">
    <h2>Yorumlar</h2>
    <p class="small-muted">Buradan siteye bırakılan tüm yorumları, yorumu yapan kullanıcının bilgilerini ve hangi habere ait olduğunu görebilirsiniz.</p>

    <table>
      <tr>
        <th>#</th><th>Yorum ID</th><th>Haber ID</th><th>Haber Başlığı</th>
        <th>Kullanıcı ID</th><th>Kullanıcı Adı</th><th>Email</th>
        <th>Yorum</th><th>Tarih</th><th>İşlem</th>
      </tr>
      <?php if($yorumlar && $yorumlar->num_rows > 0): ?>
        <?php $i=1; while($y = $yorumlar->fetch_assoc()): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= (int)$y['id'] ?></td>
            <td><?= (int)$y['haber_id'] ?></td>
            <td><?= htmlspecialchars($y['haber_baslik'] ?? '—') ?></td>
            <td><?= (int)$y['uye_id'] ?></td>
            <td><?= htmlspecialchars($y['uye_isim'] ?? 'Üye') ?></td>
            <td><?= htmlspecialchars($y['email'] ?? '') ?></td>
            <td><?= nl2br(htmlspecialchars($y['yorum'])) ?></td>
            <td class="small-muted"><?= htmlspecialchars($y['tarih']) ?></td>
            <td class="actions">
              <a href="yorumlar.php?tab=yorumlar&delete_yorum=<?= (int)$y['id'] ?>" 
                 onclick="return confirm('Bu yorumu silmek istediğinize emin misiniz?')">Sil</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="10">Henüz yorum yok.</td></tr>
      <?php endif; ?>
    </table>
</section>
<?php endif; ?>
</div>
</body>
</html>
