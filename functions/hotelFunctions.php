<?php

/*
Here's something to start your career as a hotel manager.

One function to connect to the database you want (it will return a PDO object which you then can use.)
    For instance: $db = connect('hotel.db');
                  $db->prepare("SELECT * FROM bookings");

one function to create a guid,
and one function to control if a guid is valid.
*/

use GuzzleHttp\RetryMiddleware;
use GuzzleHttp\Client;

function connect(string $dbName): object
{
    $dbPath = __DIR__ . '/../' . 'hotel.sqlite';
    $db = "sqlite:$dbPath";

    // Open the database file and catch the exception if it fails.
    try {
        $db = new PDO($db);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Failed to connect to the database";
        throw $e;
    }
    return $db;
}

//Select all from table rooms in hotel.sqlite db.
function selectAllRooms()
{
    global $db;
    try {

        $query = "SELECT * FROM rooms";

        // Execute the query
        $statement = $db->query($query);

        // Fetch all rows as an associative array
        $rooms = $statement->fetchAll();
    } catch (PDOException $e) {
        echo "Error fetching room data.";
        throw $e;
    }
    return $rooms;
}

function getSpecificRoom($room)
{
    global $db;
    try {
        $query = "SELECT * FROM rooms WHERE roomName = '$room'";

        $statement = $db->query($query);

        $selectedRoom = $statement->fetch();
        $_SESSION['selectedRoom'] = $selectedRoom;
    } catch (PDOException $e) {
        echo "Error fetching room data.";
        throw $e;
    }
}

function getRoomCost($roomID)
{
    global $db, $roomCost;
    try {
        $query = "SELECT cost FROM rooms WHERE id = '$roomID'";

        $statement = $db->query($query);

        $selectedRoom = $statement->fetch();
        $roomCost = $selectedRoom['cost'];
    } catch (PDOException $e) {
        echo "Error fetching room data.";
        throw $e;
    }
    return $roomCost;
}

//Checks room availability in hotel.sqlite
function checkRoomAvailability($roomID)
{
    global $db;
    try {

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
    return $bookings;
}

function insertBookingInformation()
{
    global $guestName, $extras, $db, $selectedRoomID, $totalCost, $guestTransferCode;
    try {
        $prepare = $db->prepare("INSERT into guests (roomID, guestName, arrival, departure, extras, cost, transferCode)
        VALUES (:roomID, :guestName, :arrival, :departure, :extras, :cost, :transferCode)");

        $prepare->bindParam(':roomID', $selectedRoomID);
        $prepare->bindParam(':guestName', $guestName);
        $prepare->bindParam(':arrival', $_SESSION['checkIn']);
        $prepare->bindParam(':departure', $_SESSION['checkOut']);
        $prepare->bindParam(':extras', $extras);
        $prepare->bindParam(':cost', $totalCost);
        $prepare->bindParam(':transferCode', $guestTransferCode);
        $prepare->execute();
    } catch (PDOException $e) {
        echo "Error fetching data.";
        throw $e;
    }
}

function getNumberOfDaysBooked()
{
    global $numberOfDays;
    //string to DateTime conversion to get number of days booked, used to calculate total price.
    $arrivalDate = new DateTime($_SESSION['checkIn']);
    $departureDate = new DateTime($_SESSION['checkOut']);
    $interval = $arrivalDate->diff($departureDate);
    $numberOfDays = $interval->days;

    return $numberOfDays;
}

//checks if guest stay is longer than 3 days. If so, applies 25%-off to total cost.
function checkOfferValidity()
{
    global $totalCost, $numberOfDays;

    if ($numberOfDays > 2) {
        $totalCost = (int) ceil($totalCost * 0.75);
    }

    return $totalCost;
}

function checkTransferCode(string $transferCode, int $totalCost)
{
    global $transferResponse;
    $client = new Client([
        'base_uri' => 'https://www.yrgopelag.se/centralbank',
    ]);

    try {
        $transferResponse = $client->post('https://www.yrgopelag.se/centralbank/transferCode', [
            'form_params' => [
                'transferCode' => $transferCode,
                'totalcost' => $totalCost,
            ],
            'verify' => false,
        ]);

        //$statusCode = $transferResponse->getStatusCode();
        $responseData = json_decode($transferResponse->getBody(), true);
        if (isset($responseData['amount'])) {
            return $responseData['amount'];
        } else {
            return 0;
        }
    } catch (GuzzleHttp\Exception\ClientException $e) {
        echo $e;
        return false;
    }
}

function guidv4(string $data = null): string
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function isValidUuid(string $uuid): bool
{
    if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
        return false;
    }
    return true;
}
