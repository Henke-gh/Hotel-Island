<?php

declare(strict_types=1);

require_once __DIR__ . "/../functions/arrays.php";

use GuzzleHttp\Client;

//replace hotel.sqlite with the name of your database.
function connect(): object
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

        $statement = $db->query($query);

        $rooms = $statement->fetchAll();
    } catch (PDOException $e) {
        echo "Error fetching room data.";
        throw $e;
    }
    return $rooms;
}

function selectAllExtras()
{
    global $db;
    try {

        $query = "SELECT * FROM extras";

        $statement = $db->query($query);

        $extras = $statement->fetchAll();
    } catch (PDOException $e) {
        echo "Error fetching room data.";
        throw $e;
    }
    return $extras;
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

//updates Room Cost in Hotel-database
function updateRoomCost($roomID, $newRoomCost)
{
    global $db, $roomCost, $newRoomCost;
    try {
        $query = "UPDATE rooms SET cost = :newcost WHERE id = :roomID";

        $statement = $db->query($query);
        $statement->bindParam(':newcost', $newRoomCost);
        $statement->bindParam(':roomID', $roomID);
        $statement->execute();
    } catch (PDOException $e) {
        echo "Error fetching room data.";
        throw $e;
    }
}

//updates Extras (features) Cost in hotel-db.
function updateExtrasCost($extraID, $newExtraCost)
{
    global $db, $extraID, $newExtraCost;
    try {
        $query = "UPDATE extras SET cost = :newcost WHERE id = :extraID";

        $statement = $db->query($query);
        $statement->bindParam(':newcost', $newExtraCost);
        $statement->bindParam(':extraID', $extraID);
        $statement->execute();
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

//checks whether a users transfercode is valid and returns the amount-value. If it's not set then returns 0 as amount.
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
        $response = $transferResponse->getBody();
        $responseData = json_decode((string) $response, true);
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

//deposits the users transfercode into hotel-owners account
function depositFunds(string $transferCode)
{
    global $transferResponse;
    $client = new Client([
        'base_uri' => 'https://www.yrgopelag.se/centralbank',
    ]);

    try {
        $transferResponse = $client->post('https://www.yrgopelag.se/centralbank/deposit', [
            'form_params' => [
                'user' => 'Henrik',
                'transferCode' => $transferCode,
            ],
            'verify' => false,
        ]);
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

//checks if the user has chosen any extra features and if so adds up the cost of those and returns the sum as
//extraCost. Also adds chosen extras/feature-names and cost to the response-array that is presented as json upon
//booking completion. Used in resolveBooking.php.
function checkForExtras()
{
    global $db, $response, $insertExtras;
    $extraCost = 0;
    if (isset($_POST['extrasOption'])) {
        $response['features'] = [];
        foreach ($_POST['extrasOption'] as $option) {
            try {

                $query = "SELECT cost FROM extras WHERE id = '$option'";
                $queryName = "SELECT featureName FROM extras WHERE id = '$option'";

                $statement = $db->query($query);
                $stmntName = $db->query($queryName);

                $extras = $statement->fetch();
                $extrasName = $stmntName->fetch();
                $extraCost += $extras['cost'];
                $response['features'][] = [
                    'name' => $extrasName['featureName'],
                    'cost' => $extras['cost'],
                ];
                //A slightly roundabout way to include names of selected extras into the guest-table
                //Creates an array of selected extras which is later json encoded and put in the guest table.
                $insertExtras[] = [
                    $extrasName['featureName']
                ];
            } catch (PDOException $e) {
                echo "Error fetching extras data.";
                throw $e;
            }
        }
    }

    return $extraCost;
}

//gets hotel managers account balance from yrgopelag
function getAccountBalance(string $apikey, string $username)
{
    global $transferResponse;
    $client = new Client([
        'base_uri' => 'https://www.yrgopelag.se/centralbank',
    ]);

    try {
        $transferResponse = $client->post('https://www.yrgopelag.se/centralbank/accountInfo', [
            'form_params' => [
                'user' => $username,
                'api_key' => $apikey,
            ],
            'verify' => false,
        ]);

        $response = $transferResponse->getBody();
        $responseData = json_decode((string) $response, true);
        if (isset($responseData['credit'])) {
            return $responseData['credit'];
        } else {
            return 0;
        }
    } catch (GuzzleHttp\Exception\ClientException $e) {
        echo $e;
        return false;
    }
}
