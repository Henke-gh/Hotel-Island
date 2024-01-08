<?php

declare(strict_types=1);
require_once __DIR__ . "/sessionStart.php";
require_once __DIR__ . "/hotelFunctions.php";
require_once __DIR__ . "/arrays.php";
$db = connect('hotel.sqlite');

//if everything is OK and user has confirmed booking adds to database and outputs reponse.
if (isset($_POST['bookRoom'])) {
    $selectedRoomID = $_POST['selectedRoomID'];
    $guestTransferCode = trim(htmlspecialchars($_POST['guestTransferCode'], ENT_QUOTES));
    $guestName = trim(htmlspecialchars($_POST['guestName'], ENT_QUOTES));
    $arrivalDate = $_SESSION['checkIn'];
    $departureDate = $_SESSION['checkOut'];
    $extras = "none";

    if (isValidUuid($guestTransferCode)) {
        getNumberOfDaysBooked();
        getRoomCost($selectedRoomID);
        $totalCost = $numberOfDays * $roomCost;
        $totalCost = checkOfferValidity();
        $extraCost = checkForExtras();
        $totalCost += $extraCost;
        die(var_dump($extraCost));
        $totalcostFromAPI = checkTransferCode($guestTransferCode, $totalCost);
        if ($totalcostFromAPI === $totalCost) {
            $response['arrival_date'] = $arrivalDate;
            $response['departure_date'] = $departureDate;
            $response['total_cost'] = $totalCost;
            insertBookingInformation();
            depositFunds($guestTransferCode);
            $_SESSION['roomConfirmed'] = "Thank you for staying with us!";
            $_SESSION['datesBooked'] = "Check in on: " . $_SESSION['checkIn'] . " with Check out: " . $_SESSION['checkOut'];
            $_SESSION['response'] = json_encode($response);
            header('Location: /../app/bookingConfirmed.php');
            exit();
        } else {
            $_SESSION['error'] = "Sorry, funds to be transfered does not match your Total Cost. Booking cancelled.";

            header('Location: /../index.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Transfercode not valid. Could not complete booking request.";

        header('Location: /../index.php');
        exit();
    }
} else {
    $_SESSION['error'] = "Your booking failed to process. Please try again.";
    header('Location: /../app/booking.php');
    exit();
}
