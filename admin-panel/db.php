<?php
// admin-panel/db.php - fallback DB connection if admin runs independently.
// If your main site already has db.php in the parent folder, admin files use require '../db.php' by default.
// Edit these credentials if needed.
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "futbol_haberleri";

$conn = new mysqli($host, $user, $pass, $dbname);
if($conn->connect_error){
    die("Veritabanı bağlantısı hatası: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>