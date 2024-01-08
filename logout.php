<?php
session_start(); // Inisialisasi session

if(session_destroy()) {
    header("Location: login.php"); // Arahkan ke halaman login setelah logout
} else {
    echo "Logout gagal"; // Tambahkan penanganan kesalahan jika diperlukan
}
?>