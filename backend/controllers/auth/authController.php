<?php
require_once(__DIR__ . '../../../../configurations/connection.php');
require_once(__DIR__ . '../../../services/authService.php'); // Mengimpor PegawaiService

class AuthController
{
    private $pegawaiService;
    public function __construct()
    {
        $this->pegawaiService = new AuthService();
    }
    public function handleLogin($email, $password)
    {
        $response = $this->pegawaiService->handleLogin($email, $password);
        return json_encode($response);
    }
    public function handleRegister($username, $email, $password)
    {
        $response = $this->pegawaiService->handleRegister($username, $email, $password);
        return json_encode($response);
    }
}
