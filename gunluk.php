<?php

$language = $_GET['language'] ?? 'tr';
$filename = "bilgiler_{$language}.json";
if (!file_exists($filename)) {
 http_response_code(404);
 echo json_encode([
 "error" => "404 Not Found",
 "message" => "Geçersiz dil girildi. Language is not supported yet."
 ], JSON_UNESCAPED_UNICODE);
 exit;
}
$data = json_decode(file_get_contents($filename), true);

$index = date('z') % count($data);
$result = $data[$index];

http_response_code(200);
if (isset($_SERVER['HTTP_ACCEPT']) && $_SERVER['HTTP_ACCEPT'] === 'text/plain') {
 header('Content-Type: text/plain');
 echo implode("\n", $result);
} else {
 header('Content-Type: application/json');
 echo json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

?>