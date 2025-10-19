<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "futbol_haberleri";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}
?>
