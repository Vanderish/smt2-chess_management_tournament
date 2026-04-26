<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Panitia - ChessTourney</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <?php include '../includes/header.php'; ?>

    <main class="main-content auth-container">
        <div class="content-card auth-card">
            <h2 class="section-header" style="text-align: center;">Daftar Akun</h2>
            
            <form action="../actions/auth_register.php" method="POST" class="chess-form" style="max-width: 100%;">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Buat username..." required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Buat password..." required>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem;">
                    Daftar Sekarang
                </button>
            </form>

            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-muted);">
                Sudah punya akun? <a href="login.php" style="color: var(--accent-peach);">Login di sini</a>
            </p>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>

</body>
</html>