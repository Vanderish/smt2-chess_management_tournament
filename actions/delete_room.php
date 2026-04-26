<?php
// Memanggil koneksi database
require_once '../config/database.php';

// Mengecek apakah ada parameter id yang dikirim
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    // Membersihkan input id
    $room_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Query untuk menghapus room
    // Karena kita memakai ON DELETE CASCADE di database, 
    // semua data peserta di room ini akan otomatis ikut terhapus.
    $query = "DELETE FROM rooms WHERE id = '$room_id'";

    if (mysqli_query($conn, $query)) {
        // Jika berhasil dihapus, arahkan kembali ke Dashboard utama
        header("Location: ../index.php");
        exit();
    } else {
        echo "Gagal menghapus room: " . mysqli_error($conn);
    }
} else {
    // Jika tidak ada parameter ID, kembalikan ke Dashboard
    header("Location: ../index.php");
    exit();
}

// Menutup koneksi
mysqli_close($conn);
?>