<?php
header("Content-Type: application/json");

// $dsn = "pgsql:host=pgdb;port=5432;dbname=testdb;";
// $user = "user";
// $pass = "password";

// try {
//     $pdo = new PDO($dsn, $user, $pass);
// } catch (PDOException $e) {
//     http_response_code(500);
//     echo json_encode(["error" => "DB Connection failed"]);
//     exit;
// }
// $pdo->exec("
//     CREATE TABLE IF NOT EXISTS users (
//         id SERIAL PRIMARY KEY,
//         name VARCHAR(100),
//         email VARCHAR(100)
//     );
// ");

// $pdo->exec("
//     INSERT INTO users (name, email) VALUES
//     ('Alice', 'alice@example.com'),
//     ('Bob', 'bob@example.com')
//     ON CONFLICT DO NOTHING;
// ");

$request = $_SERVER['REQUEST_URI'];

if ($request === '/api/users') {
    // $stmt = $pdo->query("SELECT * FROM users");
    // $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    doDummyStuff();

    $resp = file_get_contents('http://httpbin/ip');

    doSomeOtherDummyStuff();
    
    $ip = json_decode($resp, true)['origin'];
    // foreach ($users as &$user) {
    //     $user['ip'] = $ip;
    // }
    unset($user);
    echo json_encode($resp);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Not Found"]);
}


function doDummyStuff() {
    // Dummy logic: generate a random number and return a message
    $number = rand(1, 100);
    usleep(max(0, 30000 - (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) * 1000000));
    $start = microtime(true);
    $primes = [];
    $n = 2;
    while (microtime(true) - $start < 2) {
        $isPrime = true;
        for ($i = 2; $i <= sqrt($n); $i++) {
            if ($n % $i === 0) {
                $isPrime = false;
                break;
            }
        }
        if ($isPrime) {
            $primes[] = $n;
        }
        $n++;
    }
    return "Dummy stuff done! Random number: $number";

}


function doSomeOtherDummyStuff() {
    // Dummy logic: generate a random number and return a message
    $number = rand(1, 100);
    usleep(max(0, 50000 - (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) * 1000000));
    return "Dummy stuff done! Random number: $number";

}


?>