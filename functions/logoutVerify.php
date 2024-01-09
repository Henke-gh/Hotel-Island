<?php
require_once __DIR__ . "/../functions/sessionStart.php";

if (!$_SESSION['adminLoggedIn']) {
    header('Location: /../index.php');
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
        unset($_SESSION['adminLoggedIn']);
        header('Location: /../index.php');
        exit();
    }
}
