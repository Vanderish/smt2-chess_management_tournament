<?php
$host     = "localhost";
$username = "fedora";
$password = "123";
$database = "chess_tournament";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}