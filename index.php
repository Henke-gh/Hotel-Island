<?php
require_once __DIR__ . "/functions/sessionStart.php";
require_once __DIR__ . "/functions/hotelFunctions.php";
require_once __DIR__ . "/nav/header.html";
try {
    $db = new PDO('sqlite:hotel.sqlite');

    $query = "SELECT * FROM rooms";

    // Execute the query
    $statement = $db->query($query);

    // Fetch all rows as an associative array
    $rooms = $statement->fetchAll();
} catch (PDOException $e) {
    echo "Error fetching room data.";
    throw $e;
}
?>

<main>
    <h2>Welcome to Hotel Island</h2>
    <p>Here's some real sleazy info about our fabulous hotel.</p>

    <form method="post" action="/app/booking.php">
        <div class="displayRooms">
            <div class="room">
                <h3>Budget Room</h3>
                <p>Cost: <?= $rooms[0]['cost']; ?>$</p>
                <p>Available</p>
                <input type="radio" name="selectedRoom" value="budget">
            </div>
            <div class="room">
                <h3>Standard Room</h3>
                <p>Cost: <?= $rooms[1]['cost']; ?>$</p>
                <p>Available</p>
                <input type="radio" name="selectedRoom" value="standard">
            </div>
            <div class="room">
                <h3>Luxury Room</h3>
                <p>Cost: <?= $rooms[2]['cost']; ?>$</p>
                <p>Available</p>
                <input type="radio" name="selectedRoom" value="luxury">
            </div>
        </div>
        <button type="submit" name="roomSelection">Proceed to booking</button>
    </form>
</main>

<?php require_once __DIR__ . "/nav/footer.html";
