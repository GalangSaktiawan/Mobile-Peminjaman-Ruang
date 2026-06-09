<?php
header("Content-Type: application/json");
include 'koneksi.php';

$data = array();

$query = mysqli_query($conn, "SELECT * FROM peminjaman");

while($row = mysqli_fetch_assoc($query)){
    $data[] = $row;
}

echo json_encode($data, JSON_PRETTY_PRINT);
?>