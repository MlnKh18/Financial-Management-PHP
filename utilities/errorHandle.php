<?php

// Fungsi untuk mengirimkan response error dengan status code dan pesan
function sendErrorResponse($statusCode, $message)
{
    // Set header untuk status code yang sesuai
    http_response_code($statusCode);
    // Mengirimkan response dalam format JSON
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit(); // Menghentikan eksekusi lebih lanjut setelah error
}
