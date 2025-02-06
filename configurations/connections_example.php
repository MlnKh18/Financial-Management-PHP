<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: header");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'your_database_name';

$conn = mysqli_connect($server, $username, $password, $database);
$response = [];
if (!$conn) {
    $response['status'] = 'error';
    $response['message'] = 'Connection Failed: ' . mysqli_connect_error();
}
?>