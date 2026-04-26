<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

if (isset($_GET['match_id']) && isset($_GET['win']) && isset($_GET['lose']) && isset($_GET['room_id'])) {
    
    $match_id = mysqli_real_escape_string($conn, $_GET['match_id']);
    $winner_id = mysqli_real_escape_string($conn, $_GET['win']);
    $loser_id = mysqli_real_escape_string($conn, $_GET['lose']);
    $room_id = mysqli_real_escape_string($conn, $_GET['room_id']);

    // 1. Catat pemenang di tabel pertandingan
    $q_update_match = "UPDATE pertandingan SET pemenang_id = '$winner_id' WHERE id = '$match_id'";
    mysqli_query($conn, $q_update_match);

    // 2. Ubah status peserta yang kalah menjadi gugur (0)
    // Jika loser_id = 0, berarti dia menang karena BYE, tidak ada yang perlu digugurkan
    if ($loser_id != 0) {
        $q_update_loser = "UPDATE peserta SET status_aktif = 0 WHERE id = '$loser_id'";
        mysqli_query($conn, $q_update_loser);
    }

    // Arahkan kembali ke halaman room
    header("Location: ../views/room.php?id=" . $room_id);
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>