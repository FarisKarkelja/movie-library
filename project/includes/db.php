<?php
declare(strict_types=1);

$host = 'localhost';            // npr. 127.0.0.1 ili naziv hosta
$db   = 'movie_library_system'; // ime baze iz DBeaver-a
$user = 'root';      // zamijeni svojim MySQL userom
$pass = 'fare123';  // zamijeni svojom lozinkom
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // izuzeci na grešku
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch asoc. niz
    PDO::ATTR_EMULATE_PREPARES   => false,                  // native prepared stmts
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (Throwable $e) {
    http_response_code(500);
    echo "Database connection failed.";
    // Za debug (privremeno): echo $e->getMessage();
    exit;
}