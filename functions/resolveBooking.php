<?php
require_once __DIR__ . "/sessionStart.php";

if (isset($_POST['bookRoom'], $_POST['checkIn'], $_POST['checkOut'])) {
    $room = ucfirst($_POST['selectedRoom']);
    $checkIn = $_POST['checkIn'];
    $checkOut = $_POST['checkOut'];
    $_SESSION['roomConfirmed'] = "You have booked our " . $room . " room. Enjoy your stay!";
    $_SESSION['datesBooked'] = $checkIn . " " . $checkOut;
} else {
    $_SESSION['error'] = "Your booking failed to process. Please try again.";
    header('Location: /booking.php');
}

header('Location: /bookingConfirmed.php');
exit();
