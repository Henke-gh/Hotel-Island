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
    global $guestName, $extras, $db, $selectedRoomID, $totalCost;
    try {
        $prepare = $db->prepare("INSERT into guests (roomID, guestName, arrival, departure, extras, cost)
        VALUES (:roomID, :guestName, :arrival, :departure, :extras, :cost)");

        $prepare->bindParam(':roomID', $selectedRoomID);
        $prepare->bindParam(':guestName', $guestName);
        $prepare->bindParam(':arrival', $_SESSION['checkIn']);
        $prepare->bindParam(':departure', $_SESSION['checkOut']);
        $prepare->bindParam(':extras', $extras);
        $prepare->bindParam(':cost', $totalCost);
        $prepare->execute();
    } catch (PDOException $e) {
        echo "Error fetching data.";
        throw $e;
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
