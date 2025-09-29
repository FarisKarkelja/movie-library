<?php
header("Content-Type: application/json; charset=utf-8");

$host = "localhost";
$db   = "movie_library_system";   
$user = "root";     
$pass = "";         

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "DB connection failed", "details" => $e->getMessage()]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['action'] === 'add') {
    $title = trim($_POST['title'] ?? '');
    $img = trim($_POST['img'] ?? '');
    $listType = $_POST['listType'] ?? 'watched';

    if ($title === '') {
        echo json_encode(["error" => "Title is required"]);
        exit;
    }

    if ($img === '') {
        $img = "./images/card-img.jpg";
    }

    $stmt = $pdo->prepare("INSERT INTO library (title, img, list_type) VALUES (?, ?, ?)");
    $stmt->execute([$title, $img, $listType]);

    echo json_encode(["success" => true, "id" => $pdo->lastInsertId()]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['action'] === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM library WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Invalid ID"]);
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && ($_GET['action'] ?? '') === 'list') {
    $listType = $_GET['listType'] ?? 'watched';
    $stmt = $pdo->prepare("SELECT * FROM library WHERE list_type = ? ORDER BY id DESC");
    $stmt->execute([$listType]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
    exit;
}

echo json_encode(["error" => "Invalid request"]);
