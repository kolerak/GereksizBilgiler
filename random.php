<?php

$language = basename($_GET['language'] ?? 'tr');
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$filename = "bilgiler_{$language}.json";
if (!file_exists($filename)) {
 http_response_code(404);
 echo json_encode([
 "error" => "404 Not Found",
 "message" => "Bu dil için bir gereksiz bilgi dosyası yok."
 ], JSON_UNESCAPED_UNICODE);
 exit;
}
$data = json_decode(file_get_contents($filename), true);

if ($id !== null) {
 $result = array_filter($data, function ($item) use ($id) {
 return $item['id'] == $id;
 });
 if (empty($result)) {
 http_response_code(404);
 echo json_encode([
 "error" => "404 Not Found",
 "message" => "Bu ID için bir gereksiz bilgi bulunamadı."
 ], JSON_UNESCAPED_UNICODE);
 exit;
 }
 $result = array_values($result)[0];
} else {
 $result = $data[array_rand($data)];
}

http_response_code(200);
if (isset($_SERVER['HTTP_ACCEPT']) && $_SERVER['HTTP_ACCEPT'] === 'text/plain') {
 header('Content-Type: text/plain');
 echo implode("\n", $result);
} else {
 header('Content-Type: application/json');
 echo json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

?>