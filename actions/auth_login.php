<?php
session_start();

require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Cari user berdasarkan username
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    // Pastikan username ditemukan (hanya ada 1 baris data)
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verifikasi kecocokan password input dengan hash di database
        if (password_verify($password, $user['password'])) {
            
            // Jika cocok, buat variabel session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['status'] = "login";
            
            // Arahkan panitia ke Dashboard utama
            header("Location: ../index.php");
            exit();
        } else {
            // Password salah
            echo "<script>
                    alert('Password salah!');
                    window.history.back();
                  </script>";
            exit();
        }
    } else {
        // Username tidak ditemukan
        echo "<script>
                alert('Username tidak ditemukan!');
                window.history.back();
              </script>";
        exit();
    }
}

mysqli_close($conn);
?>