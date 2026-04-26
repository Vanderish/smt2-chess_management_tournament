<?php
// Memulai session (opsional di sini, tapi kebiasaan baik untuk auth)
session_start();

// Memanggil koneksi database
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Bersihkan username dari potensi SQL Injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    // Password tidak perlu di-escape sebelum di-hash
    $password = $_POST['password']; 

    // Cek apakah username sudah ada di database
    $cek_query = "SELECT id FROM users WHERE username = '$username'";
    $cek_result = mysqli_query($conn, $cek_query);

    if (mysqli_num_rows($cek_result) > 0) {
        // Jika sudah ada, hentikan dan kembalikan user
        echo "<script>
                alert('Username sudah terpakai! Silakan gunakan yang lain.');
                window.history.back();
              </script>";
        exit();
    }

    // Hash password menggunakan algoritma BCRYPT
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Simpan data user baru ke database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

    if (mysqli_query($conn, $query)) {
        // Jika sukses, arahkan ke halaman login
        echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location.href='../views/login.php';
              </script>";
        exit();
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>