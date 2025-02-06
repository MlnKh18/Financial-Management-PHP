<?php
include(__DIR__ . '../../configurations/connection.php');

class PegawaiModel {
    private $conn;

    public function __construct() {
        global $conn; // Mengakses koneksi global
        $this->conn = $conn;
    }

    // Fungsi untuk login pegawai
    public function handleLogin($email, $password) {
        if (!$this->conn) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Database connection error'
            ];
        }

        // Query untuk mencari pegawai berdasarkan email
        $sql = "SELECT * FROM pegawai WHERE email_pegawai = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Failed to prepare SQL statement: ' . $this->conn->error
            ];
        }

        // Bind parameter untuk email
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika email tidak ditemukan
        if ($result->num_rows === 0) {
            return [
                'status' => 'error',
                'code' => 401,
                'message' => 'Email atau password salah'
            ];
        }

        $user = $result->fetch_assoc();

        // Memeriksa password yang telah di-hash
        if (!password_verify($password, $user['password'])) {
            return [
                'status' => 'error',
                'code' => 401,
                'message' => 'Email atau password salah'
            ];
        }

        return [
            'status' => 'ok',
            'message' => 'Login successful',
            'user' => [
                'id' => $user['id_pegawai'],
                'username' => $user['username_pegawai'],
                'email' => $user['email_pegawai'],
                'role' => $user['role_id']
            ]
        ];
    }

    // Fungsi untuk register pegawai
    public function handleRegister($username, $email, $password) {
        if (!$this->conn) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Database connection error'
            ];
        }

        // Periksa apakah email sudah terdaftar
        $sql = "SELECT * FROM pegawai WHERE email_pegawai = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Failed to prepare SQL statement: ' . $this->conn->error
            ];
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika email sudah terdaftar
        if ($result->num_rows > 0) {
            return [
                'status' => 'error',
                'code' => 409,
                'message' => 'Email already exists'
            ];
        }

        // Hash password sebelum disimpan
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert data pegawai baru dengan role_id = 2
        $sql = "INSERT INTO pegawai (username_pegawai, email_pegawai, password, role_id) VALUES (?, ?, ?, 2)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Failed to prepare SQL statement: ' . $this->conn->error
            ];
        }

        // Bind parameter untuk username, email, dan password
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Failed to register user'
            ];
        }

        // Mendapatkan ID pengguna yang baru saja dimasukkan
        $newUserId = $stmt->insert_id;
        $newUser = [
            'id' => $newUserId,
            'username' => $username,
            'email' => $email
        ];

        return [
            'status' => 'ok',
            'message' => 'Registration successful',
            'user' => $newUser
        ];
    }
}
?>
