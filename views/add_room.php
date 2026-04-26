<?php
// login check
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Room Baru - ChessTourney</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <?php include '../includes/header.php'; ?>

    <main class="main-content">
        <div class="content-card">
            <h2 class="section-header">Buat Room Turnamen Baru</h2>
            
            <form action="../actions/create_room.php" method="POST" class="chess-form">
                <div class="form-group">
                    <label for="nama_turnamen">Nama Turnamen</label>
                    <input type="text" id="nama_turnamen" name="nama_turnamen" placeholder="Contoh: Walikota Cup 2026" required>
                </div>
                
                <button type="submit" class="btn-primary">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Buat Room Sekarang
                </button>
            </form>
        </div>
    </main>

</body>
</html>