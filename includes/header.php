<?php
session_start();
$base_url = 'http://' . $_SERVER['HTTP_HOST'];
?>
<header class="site-header">
    <div class="site-title">
        <svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 3v5h-2v-5z"></path>
            <path d="M8 3v5H6v-5z"></path>
            <path d="M13 3v5h-2v-5z"></path>
            <path d="M4 8h16v4h-4v8H8v-8H4z"></path>
            <path d="M6 21h12"></path>
        </svg>
        ChessTourney
    </div>
    
    <nav>
        <ul class="main-nav">
            <?php if (isset($_SESSION['status']) && $_SESSION['status'] == "login"): ?>
                <li>
                    <a href="<?php echo $base_url; ?>/index.php">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/views/add_room.php">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        Buat Room
                    </a>
                </li>
                <li>
                    <a class="logout" href="<?php echo $base_url; ?>/actions/logout.php" onclick="return confirm('Yakin ingin keluar dari akun?');">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        Logout
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo $base_url; ?>/views/login.php">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                        Login
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/views/register.php" class="btn-primary" style="padding: 0.4rem 0.8rem; margin-left: 0.5rem;">
                        Register
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>