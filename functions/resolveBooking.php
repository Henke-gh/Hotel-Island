<?php

declare(strict_types=1);
require_once __DIR__ . "/sessionStart.php";
require_once __DIR__ . "/hotelFunctions.php";

if (isset($_POST['searchAvailable'])) {
    $_SESSION['checkIn'] = $_POST['checkIn'];
    $_SESSION['checkOut'] = $_POST['checkOut'];
    $roomID = $_SESSION['selectedRoom']['id'];

    try {
        $db = connect();

        $arrivalDate = $_SESSION['checkIn'];
        $departureDate = $_SESSION['checkOut'];

        $query = "SELECT * FROM guests
          WHERE roomID = :roomID
          AND (arrival BETWEEN :arrival AND :departure
               OR departure BETWEEN :arrival AND :departure)";

        $statement = $db->prepare($query);
        $statement->bindParam(':roomID', $roomID);
        $statement->bindParam(':arrival', $arrivalDate);
        $statement->bindParam(':departure', $departureDate);
        $statement->execute();

        $bookings = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching room data.";
        throw $e;
    }

    if (empty($bookings)) {
        $_SESSION['dateReservation'] = $_SESSION['checkIn'] . " - " . $_SESSION['checkOut'];
        header('Location: /../app/booking.php');
        exit();
    } else {
        $_SESSION['error'] = "Sorry, dates not available.";
        unset($_SESSION['checkIn']);
        unset($_SESSION['checkOut']);
        header('Location: /../app/booking.php');
        exit();
    }
}
if (isset($_POST['bookRoom'])) {
    $room = ucfirst($_POST['selectedRoom']);
    $guestName = trim(htmlspecialchars($_POST['guestName'], ENT_QUOTES));
    $extras = "none";

    try {
        $db = connect();
        $query = "SELECT id FROM rooms WHERE roomName = '$room'";

        $statement = $db->query($query);

        $roomID = $statement->fetch();

        $prepare = $db->prepare("INSERT into guests (roomID, guestName, arrival, departure, extras)
        VALUES (:roomID, :arrival, :departure, :extras)");

        $prepare->bindParam(':roomID', $_SESSION['selectedRoom']['id']);
        $prepare->bindParam(':guestName', $guestName);
        $prepare->bindParam(':arrival', $_SESSION['checkIn']);
        $prepare->bindParam(':departure', $_SESSION['checkOut']);
        $prepare->bindParam(':extras', $extras);
        $prepare->execute();
    } catch (PDOException $e) {
        echo "Error fetching data.";
        throw $e;
    }

    $_SESSION['roomConfirmed'] = "You have booked our " . $_SESSION['selectedRoom']['roomName'] . " room. Enjoy your stay!";
    $_SESSION['datesBooked'] = "Check in on: " . $_SESSION['checkIn'] . " with Check out: " . $_SESSION['checkOut'];
    header('Location: /../app/bookingConfirmed.php');
    exit();
} else {
    $_SESSION['error'] = "Your booking failed to process. Please try again.";
    header('Location: /../app/booking.php');
    exit();
}
