<?php
include(__DIR__ . '../../../config/connections.php');
require(__DIR__ . '../../../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function register_pegawai($username, $email, $password)
{
    global $conn;
    $email_count = 0;


    // Cek koneksi database
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Email yang dimasukkan tidak valid. Silakan coba lagi.";
    }
    $check_sql = "SELECT COUNT(*) FROM pegawai WHERE email_pegawai = ?";

    // Periksa apakah email sudah terdaftar
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($email_count);
    $stmt->fetch();
    $stmt->close();

    if ($email_count > 0) {
        return "Email sudah terdaftar. Silakan gunakan email lain.";
    }

    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate token verifikasi
    $verification_token = bin2hex(random_bytes(16));

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO pegawai (username_pegawai, email_pegawai, role_id, password_pegawai, verification_token) VALUES (?, ?, ?, ?, ?)");
    $role_id = 2; // Default role pengguna
    $stmt->bind_param("ssiss", $username, $email, $role_id, $hashed_password, $verification_token);

    if ($stmt->execute()) {
        // Kirim email verifikasi
        $email_result = send_verification_email($username, $email, $verification_token);
        if ($email_result !== true) {
            return "Registrasi berhasil, tetapi email gagal dikirim: " . $email_result;
        }
        return "Registrasi berhasil! Cek email Anda untuk konfirmasi.";
    } else {
        return "Gagal mendaftar: " . $stmt->error;
    }
}

// Fungsi mengirim email verifikasi
function send_verification_email($username, $email, $verification_token)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'maulngedevweb18@gmail.com';
        $mail->Password = 'idhz jnwa hmpg mjhh';
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = 2;  // 0 = tidak ada debug, 1 = error, 2 = semua komunikasi SMTP
        $mail->Debugoutput = 'html';
        $mail->Port = 587;

        // Cek email sebelum dikirim
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Format email salah.";
        }

        $mail->setFrom('maulngodingjs@gmail.com', 'Admin');
        $mail->addAddress(trim($email), trim($username));

        $mail->Subject = 'Verifikasi Email';
        $mail->Body = "Halo $username,\n\nKlik link berikut untuk memverifikasi akun Anda:\n\n" .
            "http://localhost:8080/financial_management/backend/controller/auth/verify_email.php?token=$verification_token";

        if (!$mail->send()) {
            return "Gagal mengirim email: " . $mail->ErrorInfo;
        }

        return true;  // Email berhasil dikirim
    } catch (Exception $e) {
        return "Gagal mengirim email: {$mail->ErrorInfo}";
    }
}

// Proses registrasi jika ada request POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    echo register_pegawai($username, $email, $password);
}
