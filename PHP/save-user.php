<?php
require_once 'secret.php';

header('Content-Type: application/json');

// รับข้อมูล JSON จาก JavaScript
$data = json_decode(file_get_contents("php://input"), true);

$username = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');
$menu     = $data['menu'] ?? [];

if (!$username || !$password || empty($menu)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Missing fields"]);
    exit;
}

$filePath = __DIR__ . "/users.json";
$users = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

$peppered = hash_hmac("sha256", $password, PEPPER);
$hashed = password_hash($peppered, PASSWORD_DEFAULT);

$updated = false;

// วนลูปดูว่า user นี้มีอยู่แล้วหรือไม่
foreach ($users as &$user) {
    if ($user['username'] === $username) {
        // 👇 อัปเดตข้อมูล
        $user['password'] = $hashed;
        $user['menu'] = $menu;
        $updated = true;
        break;
    }
}

// ถ้าไม่พบ user เดิม ให้เพิ่มใหม่
if (!$updated) {
    $users[] = [
        "username" => $username,
        "password" => $hashed,
        "team"     => "default",
        "menu"     => $menu
    ];
}

file_put_contents($filePath, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode([
    "status" => "success",
    "message" => $updated ? "User updated successfully" : "User created successfully"
]);
