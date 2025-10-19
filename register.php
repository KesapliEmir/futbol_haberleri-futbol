<?php
session_start();
require 'db.php';

$error = '';
$success = '';

if(isset($_POST['register'])) {
    $isim = trim($_POST['isim']);
    $mail_input = trim($_POST['mail']);
    $sifre = trim($_POST['sifre']);
    $sifre_tekrar = trim($_POST['sifre_tekrar']);

    // Maili otomatik olarak @gmail.com ekle
    $mail = $mail_input . "@gmail.com";

    // Şifre kontrolü: en az bir '.' veya '_' olmalı
    if(empty($isim) || empty($mail_input) || empty($sifre) || empty($sifre_tekrar)){
        $error = "Lütfen tüm alanları doldurun.";
    } elseif($sifre !== $sifre_tekrar){
        $error = "Şifreler eşleşmiyor.";
    } elseif(!preg_match('/[._]/', $sifre)){
        $error = "Şifreniz en az bir nokta (.) veya alt çizgi (_) içermelidir.";
    } else {
        // Kullanıcı var mı kontrol et
        $stmt = $conn->prepare("SELECT id FROM uye WHERE mail = ?");
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){
            $error = "Bu email zaten kayıtlı.";
        } else {
            // Kayıt işlemi (düz metin şifre)
            $stmt = $conn->prepare("INSERT INTO uye (isim, mail, sifre) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $isim, $mail, $sifre);
            if($stmt->execute()){
                $success = "Kayıt başarılı! Şimdi giriş yapabilirsiniz.";
            } else {
                $error = "Kayıt sırasında bir hata oluştu.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Kayıt Ol</title>
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="height:100vh;">
<div class="card p-4" style="width: 350px;">
    <h3 class="mb-3 text-center">Kayıt Ol</h3>
    <?php 
        if($error) echo '<div class="alert alert-danger">'.$error.'</div>'; 
        if($success) echo '<div class="alert alert-success">'.$success.'</div>';
    ?>
    <form action="" method="post">
        <div class="mb-2">
            <input type="text" name="isim" class="form-control" placeholder="Kullanıcı Adı" required>
        </div>
        <div class="mb-2 input-group">
            <input type="text" name="mail" class="form-control" placeholder="Email (sadece baş kısmı)" required>
            <span class="input-group-text">@gmail.com</span>
        </div>
        <div class="mb-2">
            <!-- Şifre input gizli olacak -->
            <input type="password" name="sifre" class="form-control" placeholder="Şifre (en az bir . veya _)" required>
        </div>
        <div class="mb-3">
            <input type="password" name="sifre_tekrar" class="form-control" placeholder="Şifre Tekrar" required>
        </div>
        <button type="submit" name="register" class="btn btn-primary w-100">Kayıt Ol</button>
    </form>
    <p class="mt-3 text-center">Zaten üye misin? <a href="login.php">Giriş Yap</a></p>
</div>
</body>
</html>
