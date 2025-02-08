<?php
require_once(__DIR__ . '../../models/pegawaiModel.php');
class AuthService
{
    private $pegawaiModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
    }

    public function handleLogin($email, $password)
    {
        $result = $this->pegawaiModel->getUserByEmail($email);

        if ($result->num_rows === 0) {
            return [
                'status' => 'error',
                'code' => 401,
                'message' => 'Email atau password salah'
            ];
        }

        $user = $result->fetch_assoc();
        if (!password_verify($password, $user['password'])) {
            return [
                'status' => 'error',
                'code' => 401,
                'message' => 'Email atau password salah'
            ];
        }
        
        session_start();
        $_SESSION['id_pegawai'] = $user['id_pegawai'];
        $_SESSION['username_pegawai'] = $user['username_pegawai'];
        $_SESSION['email_pegawai'] = $user['email_pegawai'];
        $_SESSION['role_id'] = $user['role_id'];

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

    public function handleRegister($username, $email, $password)
    {
        $result = $this->pegawaiModel->getUserByEmail($email);

        if ($result->num_rows > 0) {
            return [
                'status' => 'error',
                'code' => 409,
                'message' => 'Email already exists'
            ];
        }

        $newUserId = $this->pegawaiModel->registerUser($username, $email, $password);
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
