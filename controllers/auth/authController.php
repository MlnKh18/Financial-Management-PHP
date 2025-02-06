<?php
require_once(__DIR__ . '../../../configurations/connection.php');
require_once(__DIR__ . '../../../models/pegawai.php'); // Mengimpor PegawaiModel

class AuthController
{
    private $employeeModel;

    // Konstruktor untuk menginisialisasi PegawaiModel
    public function __construct()
    {
        $this->employeeModel = new PegawaiModel(); // Inisialisasi objek PegawaiModel
    }

    // Fungsi untuk menangani login
    public function handleLogin($email, $password)
    {
        // Panggil model untuk menangani login
        $response = $this->employeeModel->handleLogin($email, $password);
        return json_encode($response); // Mengembalikan response dalam format JSON
    }

    // Fungsi untuk menangani registrasi
    public function handleRegister($username, $email, $password)
    {
        // Panggil model untuk menangani registrasi
        $response = $this->employeeModel->handleRegister($username, $email, $password);
        return json_encode($response); // Mengembalikan response dalam format JSON
    }
}
?>
