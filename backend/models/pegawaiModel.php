<?php
class PegawaiModel
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM pegawai WHERE email_pegawai = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function registerUser($username, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO pegawai (username_pegawai, email_pegawai, password, role_id) VALUES (?, ?, ?, 2)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        $stmt->execute();
        return $stmt->insert_id;
    }
    public function getAllUsers()
    {
        $sql = "SELECT * FROM pegawai";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getUserById($id)
    {
        $sql = "SELECT * FROM pegawai WHERE id_pegawai = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getSaldo()
    {
        $sql = "SELECT * FROM saldo where id_saldo = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function addTransactionPemasukan($id_pegawai, $total_transaksi, $deskripsi)
    {
        $sql = "INSERT INTO transaksi (id_pegawai, jenis_transaksi, tanggal_transaksi, total_transaksi, deskripsi) VALUES (?, 'pemasukan', NOW(), ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $id_pegawai, $total_transaksi, $deskripsi);
        $stmt->execute();
        return $stmt->insert_id;
    }
    public function getAllLogsSaldo($halaman = 1, $limit = 10)
    {
        $offset = ($halaman - 1) * $limit;
        $sql = "SELECT * FROM log_saldo ORDER BY created_at ASC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }
}
