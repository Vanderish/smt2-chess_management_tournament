<?php
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: views/login.php");
    exit();
}

require_once 'config/database.php';
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM rooms WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ChessTourney</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <main class="main-content">
        <div class="content-card">
            <h2 class="section-header">Dashboard Turnamen</h2>
            <p style="margin-bottom: 1.5rem; color: var(--text-muted);">
                Selamat datang di panel kendali utama. Anda dapat mengelola turnamen yang sedang berjalan atau membuat turnamen baru.
            </p>
            <a href="views/add_room.php" class="btn-primary">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                Buat Room Baru
            </a>
        </div>

        <div class="content-card">
            <h3 class="section-header">Daftar Turnamen (Room)</h3>
            
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Turnamen</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                        if (mysqli_num_rows($result) > 0) {
                            $no = 1;
                            // Melakukan perulangan untuk setiap baris data
                            while ($row = mysqli_fetch_assoc($result)) {
                                // format tanggal
                                $tanggal = date('d M Y', strtotime($row['created_at']));
                                
                                echo "<tr>";
                                echo "<td>{$no}</td>";
                                echo "<td><strong>{$row['nama_turnamen']}</strong></td>";
                                echo "<td>{$tanggal}</td>";
                                echo "<td>
                                        <a href='views/room.php?id={$row['id']}' class='btn-primary' style='padding: 0.4rem 0.8rem; font-size: 0.85rem;'>
                                            Kelola Room
                                        </a>
                                      </td>";
                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align: center; color: var(--text-muted);'>Belum ada turnamen yang dibuat.</td></tr>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>