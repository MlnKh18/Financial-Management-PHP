<?php
require_once(__DIR__ . '/../../../configurations/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

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

    echo json_encode(handleLogin($email, $password));
} else {
    echo json_encode([
        'status' => 'error',
        'code' => 405,
        'message' => 'Method not allowed. Use POST.'
    ]);
}

function handleLogin($email, $password)
{
    global $conn;
    $response = [];

    if (!$conn) {
        return [
            'status' => 'error',
            'code' => 500,
            'message' => 'Database connection error'
        ];
    }

    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [
            'status' => 'error',
            'code' => 500,
            'message' => 'Failed to prepare SQL statement'
        ];
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

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

    return [
        'status' => 'ok',
        'message' => 'Login successful',
        'user' => [
            'id' => $user['user_id'],
            'username' => $user['username'],
            'email' => $user['email']
        ]
    ];
}

$conn->close();
