<?php

declare(strict_types=1);
require_once __DIR__ . "/sessionStart.php";
require_once __DIR__ . "/hotelFunctions.php";
require_once __DIR__ . "/arrays.php";
$db = connect('hotel.sqlite');

//if everything is OK and user has confirmed booking adds to database and outputs reponse.
if (isset($_POST['bookRoom'])) {
    $selectedRoomID = $_POST['selectedRoomID'];
    $guestName = trim(htmlspecialchars($_POST['guestName'], ENT_QUOTES));
    $totalCost = $_POST['roomTotalCost'];
    die(var_dump($totalCost));
    $arrivalDate = $_SESSION['checkIn'];
    $departureDate = $_SESSION['checkOut'];
    $extras = "none";

    insertBookingInformation();

    $_SESSION['roomConfirmed'] = "You have booked our " . $_SESSION['selectedRoom']['roomName'] . " room. Enjoy your stay!";
    $_SESSION['datesBooked'] = "Check in on: " . $_SESSION['checkIn'] . " with Check out: " . $_SESSION['checkOut'];
    $_SESSION['response'] = json_encode($response);
    header('Location: /../app/bookingConfirmed.php');
    exit();
} else {
    $_SESSION['error'] = "Your booking failed to process. Please try again.";
    header('Location: /../app/booking.php');
    exit();
}
