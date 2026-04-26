<?php
// Wajib start session untuk mengambil ID panitia yang sedang login
session_start();

require_once '../config/database.php';

// Cek keamanan tambahan
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil user_id dari session
    $user_id = $_SESSION['user_id'];
    
    // Menangkap input
    $nama_turnamen = mysqli_real_escape_string($conn, $_POST['nama_turnamen']);

    // Query untuk menyimpan data room baru DENGAN user_id
    $query = "INSERT INTO rooms (user_id, nama_turnamen) VALUES ('$user_id', '$nama_turnamen')";

    if (mysqli_query($conn, $query)) {
        $new_room_id = mysqli_insert_id($conn);
        header("Location: ../views/room.php?id=" . $new_room_id);
        exit();
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>