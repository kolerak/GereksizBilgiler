<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
 case '/bilgiler/gunluk':
 include 'gunluk.php';
 break;
 case '/bilgiler/random':
 include 'random.php';
 break;
 default:
 http_response_code(404);
 echo 'Not found';
 break;
}

?>