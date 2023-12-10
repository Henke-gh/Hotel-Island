<?php
require_once __DIR__ . "/sessionStart.php";

if (isset($_POST['bookRoom'], $_POST['selectedRoom'])) {
    $room = ucfirst($_POST['selectedRoom']);
    $_SESSION['roomConfirmed'] = "You have booked our " . $room . " room. Enjoy your stay!";
} else {
    $_SESSION['error'] = "Your booking failed to process. Please try again.";
    header('Location: /booking.php');
}

header('Location: /index.php');
exit();
