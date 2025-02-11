<?php
require_once(__DIR__ . '../../models/pegawaiModel.php');

class PemasukanService
{
    private $pegawaiModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
    }

    public function addPemasukan($id_pegawai, $total_transaksi, $deskripsi)
    {
        // Pastikan parameter yang diterima valid
        if (empty($id_pegawai) || empty($total_transaksi) || empty($deskripsi)) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Semua field harus diisi'
            ];
        }

        // Cek apakah pegawai ada di database
        $resultPegawaiById = $this->pegawaiModel->getUserById($id_pegawai);

        if (!$resultPegawaiById) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Pegawai tidak ditemukan'
            ];
        }

        // Proses penambahan transaksi pemasukan
        $result = $this->pegawaiModel->addTransactionPemasukan($id_pegawai, $total_transaksi, $deskripsi);

        if ($result) {
            return [
                'status' => 'ok',
                'code' => 201,
                'message' => 'Pemasukan berhasil ditambahkan'
            ];
        } else {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Pemasukan gagal ditambahkan, coba lagi'
            ];
        }
    }

    public function getAllDataLogsSaldo($halaman)
    {
        $result = $this->pegawaiModel->getAllLogsSaldo($halaman);

        if (!$result) {
            error_log("Query getAllLogsSaldo() gagal dieksekusi.");
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Database error'
            ];
        }

        if ($result->num_rows === 0) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'No logs found'
            ];
        }

        // Ambil semua data dalam bentuk array asosiatif
        $logs = $result->fetch_all(MYSQLI_ASSOC);

        if (!$logs) {
            error_log("fetch_all(MYSQLI_ASSOC) gagal dieksekusi.");
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Failed to fetch logs'
            ];
        }

        return [
            'status' => 'ok',
            'message' => 'Get all logs successful',
            'data' => $logs
        ];
    }
}
