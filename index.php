<?php
require_once(__DIR__ . '../../financial_management/backend/controllers/auth/authController.php');
require_once(__DIR__ . '../../financial_management/backend/controllers/pegawai/homeController.php');

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
