<?php
require_once __DIR__ . "/sessionStart.php";

if (isset($_POST['bookRoom'], $_POST['selectedRoom'])) {
    $room = ucfirst($_POST['selectedRoom']);
    $dates = $_POST['dates'];
    $_SESSION['roomConfirmed'] = "You have booked our " . $room . " room. Enjoy your stay!";
    $_SESSION['datesBooked'] = $dates;
} else {
    $_SESSION['error'] = "Your booking failed to process. Please try again.";
    header('Location: /booking.php');
}

header('Location: /bookingConfirmed.php');
exit();
