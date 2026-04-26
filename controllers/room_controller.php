<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: ../views/login.php");
    exit();
}
require_once '../config/database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}
$room_id = mysqli_real_escape_string($conn, $_GET['id']);

// 3. Ambil Data Room
$query_room = "SELECT * FROM rooms WHERE id = '$room_id'";
$result_room = mysqli_query($conn, $query_room);

if (mysqli_num_rows($result_room) == 0) {
    die("Room tidak ditemukan.");
}
$room = mysqli_fetch_assoc($result_room);

// 4. Ambil Data Peserta & Ubah ke Array PHP
$query_peserta = "SELECT * FROM peserta WHERE room_id = '$room_id' ORDER BY status_aktif DESC, id ASC";
$result_peserta = mysqli_query($conn, $query_peserta);

$peserta_list = [];
$peserta_dict = [];
$jumlah_aktif = 0;

while ($p = mysqli_fetch_assoc($result_peserta)) {
    $peserta_list[] = $p; // Simpan ke array agar mudah di-loop di HTML
    $peserta_dict[$p['id']] = $p['nama_peserta']; // Kamus ID ke Nama
    
    if ($p['status_aktif'] == 1) {
        $jumlah_aktif++;
    }
}
$total_peserta = count($peserta_list);

// 5. Ambil Data Jadwal & Pertandingan
$query_matches = "SELECT p.*, p1.nama_peserta as p1_nama, p2.nama_peserta as p2_nama 
                  FROM pertandingan p 
                  LEFT JOIN peserta p1 ON p.pemain1_id = p1.id 
                  LEFT JOIN peserta p2 ON p.pemain2_id = p2.id 
                  WHERE p.room_id = '$room_id' 
                  ORDER BY p.babak DESC, p.id ASC";
$result_matches = mysqli_query($conn, $query_matches);

$matches_by_round = [];
$all_finished = true; 

if (mysqli_num_rows($result_matches) > 0) {
    while ($match = mysqli_fetch_assoc($result_matches)) {
        $matches_by_round[$match['babak']][] = $match;
        if (is_null($match['pemenang_id'])) {
            $all_finished = false; 
        }
    }
}

// 6. Penentuan Status Turnamen
$is_started = count($matches_by_round) > 0;
$is_tournament_finished = ($is_started && $jumlah_aktif == 1);

// 7. Kalkulasi Juara 1-4 (Jika turnamen selesai)
$juara = [];
$max_babak = 0;

if ($is_tournament_finished) {
    $max_babak = max(array_keys($matches_by_round)); // Babak Final
    
    // Juara 1 & 2
    $final_match = $matches_by_round[$max_babak][0];
    $juara[1] = $final_match['pemenang_id'];
    $juara[2] = ($final_match['pemain1_id'] == $juara[1]) ? $final_match['pemain2_id'] : $final_match['pemain1_id'];
    
    // Juara 3 & 4 (Dari Semi-Final)
    if (isset($matches_by_round[$max_babak - 1])) {
        $idx = 3;
        foreach ($matches_by_round[$max_babak - 1] as $semi_match) {
            $loser = ($semi_match['pemain1_id'] == $semi_match['pemenang_id']) ? $semi_match['pemain2_id'] : $semi_match['pemain1_id'];
            if ($loser != 0 && !is_null($loser)) {
                $juara[$idx] = $loser;
                $idx++;
            }
        }
    }
}
?>