<?php
header("Content-Type: application/json");

$dsn = "pgsql:host=pgdb;port=5432;dbname=testdb;";
$user = "user";
$pass = "password";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "DB Connection failed"]);
    exit;
}

$request = $_SERVER['REQUEST_URI'];

if ($request === '/api/users') {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $ip = file_get_contents('http://httpbin/ip');
    foreach ($users as &$user) {
        $user['ip'] = $ip;
    }
    unset($user);
    echo json_encode($users);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Not Found"]);
}


