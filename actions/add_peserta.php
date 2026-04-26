<?php
// Memanggil koneksi database
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Menangkap input
    $room_id = mysqli_real_escape_string($conn, $_POST['room_id']);
    $nama_peserta = mysqli_real_escape_string($conn, $_POST['nama_peserta']);

    // Query untuk menyimpan peserta ke room spesifik
    // Kolom status_aktif otomatis bernilai 1 (sesuai default di database)
    $query = "INSERT INTO peserta (room_id, nama_peserta) VALUES ('$room_id', '$nama_peserta')";

    if (mysqli_query($conn, $query)) {
        // Mengarahkan kembali ke halaman room tempat panitia berada
        header("Location: ../views/room.php?id=" . $room_id);
        exit();
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>