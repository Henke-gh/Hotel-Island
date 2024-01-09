<?php

use GuzzleHttp\Psr7\ServerRequest;

require_once __DIR__ . "/../functions/sessionStart.php";
require_once __DIR__ . "/../functions/hotelFunctions.php";
require_once __DIR__ . "/../functions/arrays.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    //if username or userpassword is unset, send user back to start page.
    if (!isset($_POST['adminUsername'], $_POST['adminPassword'])) {
        $_SESSION['error'] = "Enter Username and Password.";
        header('Location: /../index.php');
        exit();
    } else {
    }
}
