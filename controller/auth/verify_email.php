<?php
include(__DIR__ . '../../../config/connections.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Cek token verifikasi di database
    $stmt = $conn->prepare("SELECT id_pegawai FROM pegawai WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE pegawai SET is_verified = 1, verification_token = NULL WHERE verification_token = ?");
        $stmt->bind_param("s", $token);
        if ($stmt->execute()) {
            echo "Akun Anda telah diverifikasi. Anda sekarang dapat login.";
        } else {
            echo "Gagal memverifikasi akun.";
        }
    } else {
        echo "Token tidak valid atau sudah digunakan.";
    }
}
?>
