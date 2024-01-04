<?php

declare(strict_types=1);
require_once __DIR__ . "/../functions/sessionStart.php";
$response = isset($_SESSION['response']) ? $_SESSION['response'] : null;
header('Content-type: application/json');

echo json_encode(json_decode($response), JSON_PRETTY_PRINT);
