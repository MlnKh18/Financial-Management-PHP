<?php
class AdminModel
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Ambil semua data pegawai
    public function getAllUsers()
    {
        try {
            $sql = "SELECT * FROM pegawai";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // Mengembalikan hasil sebagai array asosiatif
        } catch (Exception $e) {
            // Menangani error dan mengembalikan pesan kesalahan
            return ['error' => $e->getMessage()];
        }
    }

    // Ambil semua data transaksi
    public function getAllDataTransaction()
    {
        try {
            $sql = "SELECT 
                        t.id_transaksi,
                        t.id_pegawai,
                        t.jenis_transaksi,
                        t.tanggal_transaksi,
                        t.total_transaksi,
                        t.deskripsi,
                        t.created_at AS transaksi_created_at,
                        t.updated_at AS transaksi_updated_at,
                        dt.id_detailsTransaksi,
                        dt.id_kategori,
                        dt.nama_item,
                        dt.jumlah,
                        dt.harga_per_item,
                        dt.subtotal,
                        dt.created_at AS details_created_at,
                        dt.updated_at AS details_updated_at,
                        p.username_pegawai,
                        p.email_pegawai,
                        p.created_at AS pegawai_created_at,
                        p.updated_at AS pegawai_updated_at
                    FROM 
                        Transaksi t
                    JOIN 
                        DetailsTransaksi dt ON t.id_transaksi = dt.id_transaksi
                    JOIN 
                        Pegawai p ON t.id_pegawai = p.id_pegawai";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // Mengembalikan hasil sebagai array asosiatif
        } catch (Exception $e) {
            // Menangani error dan mengembalikan pesan kesalahan
            return ['error' => $e->getMessage()];
        }
    }
}
