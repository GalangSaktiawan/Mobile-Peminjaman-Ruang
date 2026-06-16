<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

include "koneksi.php"; 

// --- OTOMATISASI VARIABEL KONEKSI ---
// Jika di koneksi.php Anda memakai nama $koneksi, kita samakan ke $conn agar tidak error 500
if (isset($koneksi) && !isset($conn)) {
    $conn = $koneksi;
}
// ------------------------------------

$id_peminjaman   = $_POST['$id_peminjaman'] ?? '';
$nomor_induk   = $_POST['nomor_induk'] ?? '';
$nama_ruang    = $_POST['nama_ruang'] ?? '';
$durasi        = $_POST['durasi'] ?? '';
$status_pinjam = $_POST['status_pinjam'] ?? 'Pending';

$waktu_raw     = $_POST['waktu_pinjam'] ?? ''; 
$waktu_pinjam  = substr($waktu_raw, 0, 10); 
if (empty($waktu_pinjam)) { 
    $waktu_pinjam = date('Y-m-d'); 
}

if ($nomor_induk == '' || $nama_ruang == '') {
    echo json_encode(["status" => false, "message" => "Nomor induk dan nama ruang wajib diisi"]);
    exit;
}

// Query langsung, pastikan nama kolom ini ada di phpMyAdmin Anda
$query = "INSERT INTO peminjaman (nomor_induk, nama_ruang, waktu_pinjam, durasi, status_pinjam) 
          VALUES ('$id_peminjaman $nomor_induk', '$nama_ruang', '$waktu_pinjam', '$durasi', '$status_pinjam')";

$eksekusi = mysqli_query($conn, $query);

if ($eksekusi) {
    echo json_encode(["status" => true, "message" => "Data berhasil disimpan"]);
} else {
    // Jika gagal karena nama kolom salah, dia akan mengembalikan JSON pesan error database, bukan HTML crash!
    echo json_encode(["status" => false, "message" => "Error Database: " . mysqli_error($conn)]);
}
?>