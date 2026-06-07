<?php
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: 3307;
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$database = getenv('DB_NAME') ?: 'startup_portal';

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

$conn->set_charset('utf8mb4');

// Set header for API responses
if (strpos($_SERVER['REQUEST_URI'] ?? '', '/api/') !== false) {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
}
?>
