<?php
session_start();
require '../db.php'; // Veritabanı bağlantısı

// Eğer tablo boşsa, başlangıç haberlerini ekle
$haberKontrol = $conn->query("SELECT COUNT(*) as sayi FROM son_dakika_haberleri");
$hCount = $haberKontrol->fetch_assoc()['sayi'];

if ($hCount == 0) { // Tablo boşsa ekle
    $conn->query("
    INSERT INTO `son_dakika_haberleri` (`kategori`, `baslik`, `detay`, `resim`, `tarih`) VALUES
    ('Transfer Haberleri', 'Fenerbahçe İsmail Yüksek ile Anlaşmadı', 'Fenerbahçe, 2025 Eylül ayında İsmail Yüksek ile sözleşme yenileme kararı almadı.', NULL, '2025-09-10 12:00:00'),
    ('Transfer Haberleri', 'Galatasaray Genç Oyuncuyu Kadrosuna Kattı', 'Galatasaray, altyapıdan gelecek vaadedeni kadrosuna kattı. Genç oyuncu 3 yıllık sözleşmeye imza attı.', NULL, '2025-09-15 15:30:00'),
    ('Transfer Haberleri', 'Beşiktaş Yabancı Forvet Arayışında', 'Beşiktaş yönetimi, yabancı bir forvet ile anlaşma yapabilmek için girişimlerini hızlandırdı.', NULL, '2025-10-01 10:45:00'),
    ('Maç Sonuçları', 'Fenerbahçe – Antalyaspor: 2-0', 'Fenerbahçe, 28 Eylül 2025’teki maçta Antalyaspor’u 2-0 mağlup etti ve kritik 3 puanı aldı.', NULL, '2025-09-28 20:00:00'),
    ('Maç Sonuçları', 'Karagümrük – Beşiktaş: 1-1 Berabere', 'Karagümrük deplasmanda Beşiktaş ile 1-1 berabere kaldı. Her iki takım da puan kaybetti.', NULL, '2025-10-05 17:00:00'),
    ('Maç Sonuçları', 'Galatasaray Evinde Fark Attı', 'Galatasaray, 5 Ekim 2025’te evinde oynadığı maçta rakibini 3-1 mağlup etti.', NULL, '2025-10-05 20:00:00'),
    ('Günün Manşeti', 'Süper Lig’de Avantaj Galatasaray’da', '2025 Ekim başı itibarıyla lider Galatasaray oldu. Rakipleriyle puan farkını artırmayı hedefliyor.', NULL, '2025-10-02 09:00:00'),
    ('Günün Manşeti', 'VAR Kararları Tartışılıyor', 'Haftanın maçlarında verilen VAR kararları geniş tartışmalara neden oldu. Futbol kamuoyu bu konuda ikiye bölündü.', NULL, '2025-10-06 13:00:00'),
    ('Günün Manşeti', 'Genç Oyuncular Öne Çıkıyor', '2025 sezonunun ilk aylarında birçok genç futbolcu performanslarıyla dikkat çekti.', NULL, '2025-10-07 11:00:00'),
    ('Süper Lig', 'Trabzonspor Son Dakika Golüyle Kazandı', 'Trabzonspor, 12 Ekim 2025’te deplasmanda attığı golle maçtan galip ayrıldı.', NULL, '2025-10-12 18:30:00'),
    ('Süper Lig', 'Sivasspor 1. Lig’de Önemli Galibiyet Aldı', 'Sivasspor 10 Ekim’de 1. Lig’de deplasmanda rakibini 2-1 mağlup ederek önemli bir galibiyet aldı.', NULL, '2025-10-10 16:00:00'),
    ('Süper Lig', 'Beşiktaş Evinde Mağlup Oldu', 'Beşiktaş, 11 Ekim 2025’te evinde oynadığı maçta sürpriz bir mağlubiyet aldı.', NULL, '2025-10-11 20:00:00'),
    ('Süper Lig', 'Kocaelispor Maçtan Galip Ayrıldı', 'Kocaelispor, 30 Eylül 2025’te oynadığı maçta rakibini mağlup etti.', NULL, '2025-09-30 14:00:00'),
    ('Süper Lig', 'Göztepe Deplasmanda 3 Puan Aldı', 'Göztepe, 3 Ekim 2025’te deplasmanda oynadığı maçta 3 puanı aldı.', NULL, '2025-10-03 19:00:00'),
    ('Süper Lig', 'Samsunspor Evinde Galip Geldi', 'Samsunspor, 8 Ekim 2025’te evinde oynadığı maçta galip geldi.', NULL, '2025-10-08 17:30:00'),
    ('1. Lig', 'Manisa FK Kritik Maçtan Galip Ayrıldı', 'Manisa FK, 9 Ekim 2025’te oynadığı kritik maçta rakibini 2-0 mağlup ederek önemli 3 puanı aldı.', NULL, '2025-10-09 18:00:00'),
    ('1. Lig', 'Bandırmaspor Evinde Farklı Kazandı', 'Bandırmaspor, 12 Ekim 2025’te evinde oynadığı maçta rakibini 4-1 mağlup etti ve taraftarlarını sevindirdi.', NULL, '2025-10-12 20:00:00');
    ");
}

// Düzenleme işlemi
if (isset($_POST['duzenle'])) {
    $id = intval($_POST['id']);
    $kategori = trim($_POST['kategori']);
    $baslik = trim($_POST['baslik']);
    $detay = trim($_POST['detay']);

    $stmt = $conn->prepare("UPDATE son_dakika_haberleri SET kategori=?, baslik=?, detay=? WHERE id=?");
    $stmt->bind_param("sssi", $kategori, $baslik, $detay, $id);
    $stmt->execute();
    header("Location: son-dakika-haberleri.php");
    exit;
}

// Ekleme işlemi
if (isset($_POST['ekle'])) {
    $kategori = trim($_POST['kategori']);
    $baslik = trim($_POST['baslik']);
    $detay = trim($_POST['detay']);

    $stmt = $conn->prepare("INSERT INTO son_dakika_haberleri (kategori, baslik, detay) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $kategori, $baslik, $detay);
    $stmt->execute();
    header("Location: son-dakika-haberleri.php");
    exit;
}

// Silme işlemi
if (isset($_GET['sil'])) {
    $id = intval($_GET['sil']);
    $conn->query("DELETE FROM son_dakika_haberleri WHERE id=$id");
    header("Location: son-dakika-haberleri.php");
    exit;
}

// Düzenlenecek haberi çek
$editHaber = null;
if (isset($_GET['duzenle'])) {
    $id = intval($_GET['duzenle']);
    $result = $conn->query("SELECT * FROM son_dakika_haberleri WHERE id=$id");
    $editHaber = $result->fetch_assoc();
}

// Verileri çek
$haberler = $conn->query("SELECT * FROM son_dakika_haberleri ORDER BY tarih DESC");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Son Dakika Haberleri Yönetimi</title>
<style>
body { font-family: Arial; padding: 20px; background: #f2f2f2; }
form { background: #fff; padding: 15px; border-radius: 10px; margin-bottom: 20px; }
input, textarea, select { width: 100%; margin-bottom: 10px; padding: 8px; }
table { width: 100%; background: #fff; border-collapse: collapse; }
th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
a.btn { background: #007bff; color: #fff; padding: 6px 10px; text-decoration: none; border-radius: 5px; }
a.btn:hover { background: #0056b3; }
button { background: #28a745; color: #fff; padding: 6px 10px; border: none; border-radius: 5px; cursor: pointer; }
button:hover { background: #218838; }
form div { display: flex; gap: 10px; align-items: center; margin-top: 10px; }
</style>
</head>
<body>

<h2>Son Dakika Haberleri Yönetimi</h2>

<form method="post">
  <input type="hidden" name="id" value="<?= $editHaber['id'] ?? '' ?>">

  <label>Kategori</label>
  <select name="kategori" required>
    <?php
      $kategoriler = ["Transfer Haberleri","Maç Sonuçları","Günün Manşeti","Süper Lig","1. Lig"];
      foreach($kategoriler as $k):
        $selected = ($editHaber['kategori'] ?? '') === $k ? 'selected' : '';
        echo "<option value='$k' $selected>$k</option>";
      endforeach;
    ?>
  </select>

  <label>Başlık</label>
  <input type="text" name="baslik" required value="<?= htmlspecialchars($editHaber['baslik'] ?? '') ?>">

  <label>Detay</label>
  <textarea name="detay" rows="5" required><?= htmlspecialchars($editHaber['detay'] ?? '') ?></textarea>

  <div>
    <?php if ($editHaber): ?>
        <button type="submit" name="duzenle">Haberi Güncelle</button>
    <?php else: ?>
        <button type="submit" name="ekle">Haberi Ekle</button>
    <?php endif; ?>
    <a class="btn" href="admin-panel.php">← Geri</a>
  </div>
</form>

<table>
  <tr>
    <th>ID</th>
    <th>Kategori</th>
    <th>Başlık</th>
    <th>Tarih</th>
    <th>Düzenle</th>
    <th>Sil</th>
  </tr>
  <?php while($h = $haberler->fetch_assoc()): ?>
  <tr>
    <td><?= $h['id'] ?></td>
    <td><?= htmlspecialchars($h['kategori']) ?></td>
    <td><?= htmlspecialchars($h['baslik']) ?></td>
    <td><?= $h['tarih'] ?></td>
    <td><a class="btn" href="?duzenle=<?= $h['id'] ?>">Düzenle</a></td>
    <td><a class="btn" href="?sil=<?= $h['id'] ?>" onclick="return confirm('Silmek istiyor musun?')">Sil</a></td>
  </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
