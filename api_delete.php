<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

include "koneksi.php";

// --- OTOMATISASI VARIABEL KONEKSI ---
if (isset($koneksi) && !isset($conn)) {
    $conn = $koneksi;
}
// ------------------------------------

// Mengambil ID yang dikirim dari Flutter
$id = $_POST['id_peminjaman'] ?? '';

if ($id == '') {
    echo json_encode([
        "status" => false,
        "message" => "ID tidak boleh kosong"
    ]);
    exit;
}

$query = "DELETE FROM peminjaman WHERE id_peminjaman = '$id'";
$eksekusi = mysqli_query($conn, $query);

if ($eksekusi) {
    // Memeriksa apakah ada baris data yang benar-benar terhapus di database
    if (mysqli_affected_rows($conn) > 0) {
        echo json_encode([
            "status" => true,
            "message" => "Data berhasil dihapus"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Gagal: Data dengan ID tersebut tidak ditemukan di database"
        ]);
    }
} else {
    echo json_encode([
        "status" => false,
        "message" => "Error Database: " . mysqli_error($conn)
    ]);
}
?>