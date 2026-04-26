<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panitia - ChessTourney</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <?php include '../includes/header.php'; ?>

    <main class="main-content auth-container">
        <div class="content-card auth-card">
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="var(--accent-peach)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 48px; height: 48px; margin-bottom: 10px;">
                    <path d="M18 3v5h-2v-5z"></path>
                    <path d="M8 3v5H6v-5z"></path>
                    <path d="M13 3v5h-2v-5z"></path>
                    <path d="M4 8h16v4h-4v8H8v-8H4z"></path>
                    <path d="M6 21h12"></path>
                </svg>
                <h2 style="color: var(--accent-peach);">Login Panitia</h2>
            </div>
            
            <form action="../actions/auth_login.php" method="POST" class="chess-form" style="max-width: 100%;">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username..." required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password..." required>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem;">
                    Masuk
                </button>
            </form>

            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-muted);">
                Belum punya akun? <a href="register.php" style="color: var(--accent-peach);">Daftar sekarang</a>
            </p>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>

</body>
</html>