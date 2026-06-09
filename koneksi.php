<?php
$host = "localhost";
$username = "u932375977_galang_404";
$password = "Hindia404";
$database = "u932375977_galang_db";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>