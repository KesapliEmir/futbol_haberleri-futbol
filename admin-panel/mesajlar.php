<?php
session_start();
require 'db.php';
if (!isset($_SESSION['admin'])) { header('Location: admin-login.php'); exit; }

if (isset($_GET['delete'])) {
    $del = (int)$_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM mesajlar WHERE id = ?');
    $stmt->bind_param('i', $del);
    $stmt->execute();
    $stmt->close();
    header('Location: mesajlar.php');
    exit;
}

$res = $conn->query('SELECT * FROM mesajlar ORDER BY tarih DESC');
?>
<!doctype html>
<html lang="tr">
<head><meta charset="utf-8"><title>Mesajlar</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
  <h2>Mesajlar</h2>
  <table class="list">
    <thead><tr><th>ID</th><th>İsim</th><th>Email</th><th>Konu</th><th>Mesaj</th><th>Tarih</th><th>Sil</th></tr></thead>
    <tbody>
    <?php while($m = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo $m['id']; ?></td>
        <td><?php echo htmlspecialchars($m['isim']); ?></td>
        <td><?php echo htmlspecialchars($m['email']); ?></td>
        <td><?php echo htmlspecialchars($m['konu']); ?></td>
        <td><?php echo nl2br(htmlspecialchars($m['mesaj'])); ?></td>
        <td><?php echo $m['tarih']; ?></td>
        <td><a class="btn red" href="mesajlar.php?delete=<?php echo $m['id']; ?>" onclick="return confirm('Silinsin mi?')">Sil</a></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
  <p><a href="admin-panel.php">Geri</a></p>
</div>
</body>
</html>
