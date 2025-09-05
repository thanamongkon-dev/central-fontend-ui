<?php
// รับ JSON
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// ตรวจสอบ JSON
if ($data === null) {
    http_response_code(400);
    echo "Invalid JSON.";
    exit;
}

// เขียนลงไฟล์
if (file_put_contents("brands.json", json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo "✅ Data saved successfully.";
} else {
    http_response_code(500);
    echo "❌ Failed to save data.";
}
?>
