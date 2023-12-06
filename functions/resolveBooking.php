<?php
require_once __DIR__ . "/sessionStart.php";

if (isset($_POST['bookRoom'])) {
    $room = $_POST['bookRoom'];
    $_SESSION['roomConfirmed'] = "You have booked our " . $room . ". Enjoy your stay!";
} else {
    $_SESSION['error'] = "Your booking failed to process. Please try again.";
    header('Location: /booking.php');
}

header('Location: /index.php');
exit();
