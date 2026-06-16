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

// 1. Perbaikan penamaan variabel agar tidak tertimpa
$id_peminjaman = $_POST['id_peminjaman'] ?? '';
$nomor_induk   = $_POST['nomor_induk'] ?? '';
$nama_ruang    = $_POST['nama_ruang'] ?? '';
$durasi        = $_POST['durasi'] ?? '';
$status_pinjam = $_POST['status_pinjam'] ?? '';

// Memotong format tanggal agar sesuai dengan tipe DATE database
$waktu_raw     = $_POST['waktu_pinjam'] ?? ''; 
$waktu_pinjam  = substr($waktu_raw, 0, 10); 
if (empty($waktu_pinjam)) { 
    $waktu_pinjam = date('Y-m-d'); 
}

if ($id_peminjaman == '' || $nomor_induk == '' || $nama_ruang == '' || $durasi == '') {
    echo json_encode([
        "status" => false,
        "message" => "Semua data wajib diisi!"
    ]);
    exit;
}

$query = "UPDATE peminjaman SET 
            nomor_induk = '$nomor_induk', 
            nama_ruang = '$nama_ruang', 
            waktu_pinjam = '$waktu_pinjam', 
            durasi = '$durasi', 
            status_pinjam = '$status_pinjam' 
          WHERE id_peminjaman = '$id_peminjaman'";

$eksekusi = mysqli_query($conn, $query);

if ($eksekusi) {
    echo json_encode([
        "status" => true,
        "message" => "Data berhasil diupdate"
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "Error Database: " . mysqli_error($conn)
    ]);
}
?>