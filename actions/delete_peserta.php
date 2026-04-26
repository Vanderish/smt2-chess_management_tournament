<?php
// Memanggil koneksi database
require_once '../config/database.php';

// Mengecek apakah ada parameter id peserta dan room_id yang dikirim
if (isset($_GET['id']) && isset($_GET['room_id']) && !empty($_GET['id'])) {
    
    // Membersihkan input
    $peserta_id = mysqli_real_escape_string($conn, $_GET['id']);
    $room_id = mysqli_real_escape_string($conn, $_GET['room_id']);

    // Query untuk menghapus peserta berdasarkan ID-nya
    // Kita tambahkan AND room_id sebagai pengaman ekstra
    $query = "DELETE FROM peserta WHERE id = '$peserta_id' AND room_id = '$room_id'";

    if (mysqli_query($conn, $query)) {
        // Jika berhasil, arahkan kembali ke halaman detail room tersebut
        header("Location: ../views/room.php?id=" . $room_id);
        exit();
    } else {
        echo "Gagal menghapus peserta: " . mysqli_error($conn);
    }
} else {
    // Jika tidak ada ID, kembalikan ke Dashboard utama
    header("Location: ../index.php");
    exit();
}

// Menutup koneksi
mysqli_close($conn);
?>