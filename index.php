<?php
require_once(__DIR__ . '../../financial_management/backend/controllers/auth/authController.php');
require_once(__DIR__ . '../../financial_management/backend/controllers/pegawai/homeController.php');
require_once(__DIR__ . '../../financial_management/backend/controllers/transactions/pemasukanController.php');
require_once(__DIR__ . '../../financial_management/configurations/connection.php');

// Pastikan hanya menerima method POST untuk login dan registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Mendapatkan parameter 'page' yang diteruskan oleh URL
    $page = isset($_GET['page']) ? $_GET['page'] : '';

    // Menangani login
    if ($page === 'backend/login') {
        // Mengambil data dari body request
        $inputData = json_decode(file_get_contents('php://input'), true);
        $email = isset($inputData['email']) ? trim($inputData['email']) : '';
        $password = isset($inputData['password']) ? $inputData['password'] : '';

        // Validasi input
        if (empty($email) || empty($password)) {
            echo json_encode([
                'status' => 'error',
                'code' => 400,
                'message' => 'Email dan password tidak boleh kosong'
            ]);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                'status' => 'error',
                'code' => 400,
                'message' => 'Format email tidak valid'
            ]);
            exit;
        }

        // Menangani login menggunakan AuthController
        $authController = new AuthController();
        echo $authController->handleLogin($email, $password);
    }

    // Menangani registrasi
    if ($page === 'backend/register') {
        // Mengambil data dari body request
        $inputData = json_decode(file_get_contents('php://input'), true);
        $username = isset($inputData['username']) ? $inputData['username'] : '';
        $email = isset($inputData['email']) ? $inputData['email'] : '';
        $password = isset($inputData['password']) ? $inputData['password'] : '';

        // Validasi input
        if (empty($username) || empty($email) || empty($password)) {
            echo json_encode([
                'status' => 'error',
                'code' => 400,
                'message' => 'Username, email, dan password tidak boleh kosong'
            ]);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                'status' => 'error',
                'code' => 400,
                'message' => 'Format email tidak valid'
            ]);
            exit;
        }

        // Menangani registrasi menggunakan AuthController
        $authController = new AuthController();
        echo $authController->handleRegister($username, $email, $password);
    }
    if ($page === 'backend/addPemasukan') {
        $inputData = json_decode(file_get_contents('php://input'), true);
        $id_pegawai = isset($inputData['id_pegawai']) ? $inputData['id_pegawai'] : '';
        if (empty($id_pegawai)) {
            echo json_encode([
                'status' => 'error',
                'code' => 400,
                'message' => 'ID pegawai tidak boleh kosong'
            ]);
            exit;
        }

        $total_transaksi = isset($inputData['total_transaksi']) ? $inputData['total_transaksi'] : '';
        $deskripsi = isset($inputData['deskripsi']) ? $inputData['deskripsi'] : '';
        if (empty($total_transaksi) || !is_numeric($total_transaksi)) {
            echo json_encode([
                'status' => 'error',
                'code' => 400,
                'message' => 'Total transaksi harus berupa angka dan tidak boleh kosong'
            ]);
            exit;
        }

        $deskripsi = isset($inputData['deskripsi']) ? $inputData['deskripsi'] : '';
        if (empty($deskripsi)) {
            echo json_encode([
                'status' => 'error',
                'code' => 400,
                'message' => 'Deskripsi tidak boleh kosong'
            ]);
            exit;
        }

        $pemasukanController = new PemasukanController();
        echo $pemasukanController->handleAddPemasukan($id_pegawai, $total_transaksi, $deskripsi);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $page = isset($_GET['page']) ? trim($_GET['page']) : '';

    // Pastikan hanya menangani request yang benar
    if ($page === 'backend/home-GetSaldo') {
        $homeController = new HomeController();
        $response = $homeController->handleGetSaldo();

        echo json_encode($response);
        exit;
    } elseif ($page === 'backend/home-GetAllLogsSaldo') {
        $homeController = new HomeController();
        $response = $homeController->handleGetAllLogsSaldo();


        echo json_encode($response);
        exit;
    } elseif ($page === 'backend/pemasukan-GetAllDataLogsSaldo') {
        $pemasukanController = new PemasukanController();
        $pemasukanController->handleGetAllDataLogsSaldo();
        exit;
    }
} else {
    echo json_encode([
        'status' => 'error',
        'code' => 405,
        'message' => 'Method not allowed. Use POST.'
    ]);
}

// Menutup koneksi jika sudah tidak digunakan
if (isset($conn)) {
    $conn->close();
}
