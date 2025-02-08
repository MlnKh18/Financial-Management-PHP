<?php
require_once(__DIR__ . '../../models/pegawaiModel.php');

class HomeService
{
    private $pegawaiModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
    }

    public function getSaldo()
    {
        $result = $this->pegawaiModel->getSaldo();

        if (!$result) {
            error_log("Query getSaldo() gagal dieksekusi.");
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Database error'
            ];
        }

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            if (!isset($data['jumlah_saldo'])) {
                error_log("Key 'jumlah_saldo' tidak ditemukan dalam hasil query.");
                return [
                    'status' => 'error',
                    'code' => 500,
                    'message' => 'Invalid data format'
                ];
            }

            return [
                'status' => 'ok',
                'message' => 'Get saldo successful',
                'data' => [
                    'saldo' => $data['jumlah_saldo']
                ]
            ];
        }

        return [
            'status' => 'error',
            'code' => 404,
            'message' => 'Saldo not found'
        ];
    }

    public function getAllLogsSaldo()
    {
        $result = $this->pegawaiModel->getAllLogsSaldo();

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
