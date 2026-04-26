<?php
// Cukup panggil file logic-nya di baris paling atas!
require_once '../controllers/room_controller.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Room - ChessTourney</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <?php include '../includes/header.php'; ?>

    <main class="main-content">
        
        <div class="content-card">
            
            <div style="position: relative; text-align: center; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); margin-bottom: 1.5rem;">
                <a href="../actions/delete_room.php?id=<?php echo $room_id; ?>" onclick="return confirm('PERINGATAN: Yakin hapus turnamen ini?');" class="btn-primary" style="position: absolute; right: 0; top: 0; background-color: #ff5555; color: white; font-size: 0.85rem; padding: 0.5rem 1rem;">
                    Hapus Room
                </a>
                <h2 style="color: var(--accent-peach); font-size: 1.8rem; margin-bottom: 0.5rem; padding: 0 120px;">
                    <?php echo htmlspecialchars($room['nama_turnamen']); ?>
                </h2>
            </div>

            <?php if (!$is_started): ?>
                <h3 class="section-header">Manajemen Peserta</h3>
                <form action="../actions/add_peserta.php" method="POST" class="chess-form" style="flex-direction: row; align-items: flex-end; max-width: 100%; margin-bottom: 2rem;">
                    <div class="form-group" style="flex-grow: 1;">
                        <label for="nama_peserta">Nama Lengkap Peserta</label>
                        <input type="text" id="nama_peserta" name="nama_peserta" placeholder="Masukkan nama peserta..." required>
                    </div>
                    <input type="hidden" name="room_id" value="<?php echo $room_id; ?>"> 
                    <button type="submit" class="btn-primary">Tambah Peserta</button>
                </form>

                <?php if ($total_peserta >= 2): ?>
                    <form action="../actions/generate_pairing.php" method="POST" style="text-align: center; margin-bottom: 2rem;">
                        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                        <button type="submit" class="btn-primary" onclick="return confirm('Mulai turnamen? Form pendaftaran akan ditutup otomatis.');" style="padding: 0.8rem 2rem; font-size: 1rem;">
                            Acak & Mulai Babak 1
                        </button>
                    </form>
                <?php else: ?>
                    <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem;">Minimal butuh 2 peserta untuk memulai turnamen.</p>
                <?php endif; ?>

            <?php else: ?>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 class="section-header" style="margin: 0;">Jadwal & Hasil Pertandingan</h3>
                    
                    <?php if ($is_tournament_finished): ?>
                        <span class="badge-peach" style="background-color: var(--accent-peach); color: white; border: none; padding: 0.5rem 1rem; font-weight: bold; font-size: 0.9rem;">🏆 Turnamen Selesai</span>
                    <?php elseif ($all_finished): ?>
                        <form action="../actions/generate_pairing.php" method="POST">
                            <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                            <button type="submit" class="btn-primary" style="font-size: 0.85rem;" onclick="return confirm('Lanjut ke babak selanjutnya?');">Generate Babak Selanjutnya</button>
                        </form>
                    <?php else: ?>
                        <span class="badge-peach" style="background-color: transparent; border: 1px solid var(--text-muted); color: var(--text-muted);">Babak Sedang Berlangsung</span>
                    <?php endif; ?>
                </div>

                <div class="pairing-board">
                    <?php foreach ($matches_by_round as $babak => $matches): ?>
                        <h4 style="margin-bottom: 1rem; color: var(--text-muted);">
                            <?php 
                            if ($is_tournament_finished && $babak == $max_babak) echo "Babak Final";
                            else if ($is_tournament_finished && $babak == ($max_babak - 1)) echo "Babak Semi-Final";
                            else echo "Babak " . $babak; 
                            ?>
                        </h4>
                        
                        <?php foreach ($matches as $m): ?>
                            <div class="match-box">
                                <div class="player-side">
                                    <strong><?php echo htmlspecialchars($m['p1_nama']); ?></strong><br>
                                    <?php if (is_null($m['pemenang_id'])): ?>
                                        <a href="../actions/set_winner.php?match_id=<?php echo $m['id']; ?>&win=<?php echo $m['pemain1_id']; ?>&lose=<?php echo $m['pemain2_id'] ?? '0'; ?>&room_id=<?php echo $room_id; ?>" class="btn-win" onclick="return confirm('Pilih sebagai pemenang?');">Menang</a>
                                    <?php elseif ($m['pemenang_id'] == $m['pemain1_id']): ?>
                                        <span class="winner-text">👑 Menang</span>
                                    <?php else: ?>
                                        <span style="color: #ff5555; font-size: 0.8rem; display: block; margin-top: 0.5rem;">Kalah</span>
                                    <?php endif; ?>
                                </div>

                                <div class="vs-side">VS</div>

                                <div class="player-side">
                                    <?php if ($m['pemain2_id']): ?>
                                        <strong><?php echo htmlspecialchars($m['p2_nama']); ?></strong><br>
                                        <?php if (is_null($m['pemenang_id'])): ?>
                                            <a href="../actions/set_winner.php?match_id=<?php echo $m['id']; ?>&win=<?php echo $m['pemain2_id']; ?>&lose=<?php echo $m['pemain1_id']; ?>&room_id=<?php echo $room_id; ?>" class="btn-win" onclick="return confirm('Pilih sebagai pemenang?');">Menang</a>
                                        <?php elseif ($m['pemenang_id'] == $m['pemain2_id']): ?>
                                            <span class="winner-text">👑 Menang</span>
                                        <?php else: ?>
                                            <span style="color: #ff5555; font-size: 0.8rem; display: block; margin-top: 0.5rem;">Kalah</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <strong style="color: var(--text-muted);">(BYE)</strong><br>
                                        <span style="color: var(--text-muted); font-size: 0.8rem; display: block; margin-top: 0.5rem;">Lolos Otomatis</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <hr style="border: 0; border-top: 1px dashed var(--border-color); margin: 1.5rem 0;">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <h3 class="section-header" style="margin-top: 2rem;">Daftar Peserta</h3>
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th><th>Nama Peserta</th><th style="width: 15%;">Status</th>
                            <?php if (!$is_started): ?><th style="width: 10%;">Aksi</th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($total_peserta > 0) {
                            $no = 1;
                            foreach ($peserta_list as $peserta) {
                                $status_text = ($peserta['status_aktif'] == 1) ? 'Bertahan' : 'Gugur';
                                $status_color = ($peserta['status_aktif'] == 1) ? 'var(--accent-peach)' : '#ff5555';
                                
                                echo "<tr>";
                                echo "<td>{$no}</td>";
                                echo "<td>" . htmlspecialchars($peserta['nama_peserta']) . "</td>";
                                echo "<td><span class='badge-peach' style='background-color: transparent; border: 1px solid {$status_color}; color: {$status_color};'>{$status_text}</span></td>";
                                
                                if (!$is_started) {
                                    echo "<td><a href='../actions/delete_peserta.php?id={$peserta['id']}&room_id={$room_id}' style='color: #ff5555; font-size: 0.85rem;' onclick=\"return confirm('Hapus peserta ini?');\">Hapus</a></td>";
                                }
                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align: center; color: var(--text-muted);'>Belum ada peserta yang mendaftar.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="content-card">
            <h3 class="section-header">🏆 Leaderboard Turnamen</h3>
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr><th>Peringkat / Keterangan</th><th>Nama Peserta</th><th>Status Terakhir</th></tr>
                    </thead>
                    <tbody>
                        <?php if ($is_tournament_finished): ?>
                            <?php 
                            $medali = [1 => '🥇 Juara 1', 2 => '🥈 Juara 2', 3 => '🥉 Juara 3', 4 => '🏅 Juara 4'];
                            foreach ($juara as $posisi => $id_peserta) {
                                if (isset($peserta_dict[$id_peserta])) {
                                    echo "<tr>";
                                    echo "<td><strong>" . $medali[$posisi] . "</strong></td>";
                                    echo "<td><strong>" . htmlspecialchars($peserta_dict[$id_peserta]) . "</strong></td>";
                                    if ($posisi == 1) {
                                        echo "<td><span style='color: #4CAF50; font-weight: bold;'>🏆 Pemenang Utama</span></td>";
                                    } else {
                                        echo "<td><span style='color: var(--text-muted);'>Selesai</span></td>";
                                    }
                                    echo "</tr>";
                                }
                            }
                            ?>
                        <?php elseif ($is_started): ?>
                            <?php 
                            foreach ($peserta_list as $peserta) {
                                if ($peserta['status_aktif'] == 1) {
                                    echo "<tr>";
                                    echo "<td>-</td>";
                                    echo "<td><strong>" . htmlspecialchars($peserta['nama_peserta']) . "</strong></td>";
                                    echo "<td><span style='color: var(--accent-peach); font-weight: bold;'>Bertahan di Kompetisi</span></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        <?php else: ?>
                            <tr><td colspan="3" style="text-align: center; color: var(--text-muted); padding: 2rem 0;">Belum ada data peringkat. Pertandingan belum dimulai.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <?php include '../includes/footer.php'; ?>

</body>
</html>