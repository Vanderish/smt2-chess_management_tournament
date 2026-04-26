<?php
session_start();
require_once '../config/database.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_id = mysqli_real_escape_string($conn, $_POST['room_id']);

    // 1. VALIDASI: Cek apakah ada pertandingan yang belum selesai di room ini
    $cek_blm_selesai = mysqli_query($conn, "SELECT id FROM pertandingan WHERE room_id = '$room_id' AND pemenang_id IS NULL");
    if (mysqli_num_rows($cek_blm_selesai) > 0) {
        echo "<script>
                alert('Gagal! Masih ada pertandingan yang belum selesai. Tentukan pemenang terlebih dahulu.');
                window.location.href = '../views/room.php?id=$room_id';
              </script>";
        exit();
    }

    // 2. AMBIL DATA PESERTA AKTIF
    $query_peserta = "SELECT id FROM peserta WHERE room_id = '$room_id' AND status_aktif = 1";
    $result_peserta = mysqli_query($conn, $query_peserta);
    
    $peserta_aktif = [];
    while ($row = mysqli_fetch_assoc($result_peserta)) {
        $peserta_aktif[] = $row['id'];
    }

    // Cek apakah sisa peserta kurang dari 2 (Turnamen sudah selesai)
    if (count($peserta_aktif) < 2) {
        echo "<script>
                alert('Peserta aktif kurang dari 2. Turnamen mungkin sudah selesai atau peserta belum cukup.');
                window.location.href = '../views/room.php?id=$room_id';
              </script>";
        exit();
    }

    // 3. TENTUKAN BABAK KE-BERAPA INI
    $query_babak = "SELECT MAX(babak) as babak_terakhir FROM pertandingan WHERE room_id = '$room_id'";
    $result_babak = mysqli_query($conn, $query_babak);
    $row_babak = mysqli_fetch_assoc($result_babak);
    $babak_baru = ($row_babak['babak_terakhir'] != null) ? $row_babak['babak_terakhir'] + 1 : 1;

    // 4. ACAK URUTAN PESERTA
    shuffle($peserta_aktif);

    // 5. PROSES PASANGKAN (PAIRING)
    $total_peserta = count($peserta_aktif);
    for ($i = 0; $i < $total_peserta; $i += 2) {
        $pemain1 = $peserta_aktif[$i];
        
        // Jika ada pasangan (genap)
        if (isset($peserta_aktif[$i + 1])) {
            $pemain2 = $peserta_aktif[$i + 1];
            $query_insert = "INSERT INTO pertandingan (room_id, babak, pemain1_id, pemain2_id) 
                             VALUES ('$room_id', '$babak_baru', '$pemain1', '$pemain2')";
        } else {
            // Jika ganjil (Sisa 1 orang sendirian), dapat 'Bye'
            // pemain2_id biarkan NULL, dan dia langsung jadi pemenang
            $query_insert = "INSERT INTO pertandingan (room_id, babak, pemain1_id, pemain2_id, pemenang_id) 
                             VALUES ('$room_id', '$babak_baru', '$pemain1', NULL, '$pemain1')";
        }
        mysqli_query($conn, $query_insert);
    }

    // Kembali ke halaman room
    header("Location: ../views/room.php?id=$room_id");
    exit();
}
?>