<?php

declare(strict_types=1);
require_once __DIR__ . "/../functions/sessionStart.php";
require_once __DIR__ . "/../functions/hotelFunctions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    //if username or userpassword is unset, send user back to start page.
    if (!isset($_POST['adminUsername'], $_POST['adminPassword'])) {
        $_SESSION['error'] = "Enter Username and Password.";
        header('Location: /../index.php');
        exit();
    } else {
        $username = trim(htmlspecialchars($_POST['adminUsername'], ENT_QUOTES));
        $password = trim(htmlspecialchars($_POST['adminPassword'], ENT_QUOTES));
        unset($_POST['adminPassword']);
        $db = connect('hotel.sqlite');

        $statment = $db->prepare("SELECT * FROM 'admin'
        WHERE username = :username");

        $statment->bindParam(':username', $username);
        $statment->execute();

        $user = $statment->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['adminLoggedIn'] = true;
            header('Location: /../app/admin.php');
            exit();
        } else {
            $_SESSION['error'] = "Incorrect credentials. Are you sure you're supposed to have access?";
            header('Location: /../index.php');
            exit();
        }
    }
}
