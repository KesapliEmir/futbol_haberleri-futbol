<?php
session_start();
require 'db.php';

$error = '';

if (isset($_POST['login'])) {
    $mail = trim($_POST['mail']);
    $sifre = trim($_POST['sifre']);

    // Kullanıcıyı mail ile çek
    $stmt = $conn->prepare("SELECT id, isim, mail, sifre FROM uye WHERE mail = ?");
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $isim, $email_db, $sifre_db);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();

        // Düz metin şifre kontrolü (istersen ileride password_hash'e geçebiliriz)
        if ($sifre === $sifre_db) {

            // ✅ Kullanıcıyı dizi şeklinde session'a kaydediyoruz
            $_SESSION['kullanici'] = [
                'id' => $id,
                'username' => $isim,
                'email' => $email_db
            ];

            header("Location: index.php");
            exit;

        } else {
            $error = "Email veya şifre yanlış.";
        }
    } else {
        $error = "Email veya şifre yanlış.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Giriş Yap</title>
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f8f9fa;
}
.card {
    width: 350px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
</style>
</head>
<body>
<div class="card p-4">
    <h3 class="mb-3 text-center">Giriş Yap</h3>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-2">
            <input type="email" name="mail" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" name="sifre" class="form-control" placeholder="Şifre" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">Giriş Yap</button>
    </form>

    <p class="mt-3 text-center">
        Hesabın yok mu? <a href="register.php">Kayıt Ol</a>
    </p>
</div>
</body>
</html>
