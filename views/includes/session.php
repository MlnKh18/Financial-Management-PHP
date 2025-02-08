<?php
session_start();

// Cek apakah user sudah login atau belum
function isUserLoggedIn() {
    return isset($_SESSION['id_pegawai']);
}
function checkAuth() {
    $allowedPages = ['./login', './register'];
    $currentPage = basename($_SERVER['PHP_SELF']);

    if (!isUserLoggedIn() && !in_array($currentPage, $allowedPages)) {
        header("Location: ./login");
        exit;
    }
}
?>
