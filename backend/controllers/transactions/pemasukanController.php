<?php
require_once(__DIR__ . '../../../../configurations/connection.php');
require_once(__DIR__ . '../../../services/pemasukanService.php');

class PemasukanController
{
    private $pemasukanService;

    public function __construct()
    {
        $this->pemasukanService = new PemasukanService();
    }

    public function handleAddPemasukan($id_pegawai, $total_transaksi, $deskripsi)
    {
        $response = $this->pemasukanService->addPemasukan($id_pegawai, $total_transaksi, $deskripsi);
        echo json_encode($response);
    }
    public function handleGetAllDataLogsSaldo()
    {
        // Ambil halaman dari parameter GET, default ke halaman 1 jika tidak ada
        $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : "";
        
        // Panggil Service dengan parameter $halaman
        $response = $this->pemasukanService->getAllDataLogsSaldo($halaman);
    
        // Set header JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
}
