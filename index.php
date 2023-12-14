<?php
require_once __DIR__ . "/functions/sessionStart.php";
require_once __DIR__ . "/functions/hotelFunctions.php";
require_once __DIR__ . "/nav/header.html";

$db = connect('hotel.sqlite');
$rooms = selectAllRooms();
?>

<main>
    <h2>Welcome to Hotel Island</h2>
    <h3>BOOK YOUR STAY NOW!</h3>
    <form method="post" action="/app/booking.php">
        <input type="date" name="checkIn" min="2024-01-01" max="2024-01-31" required>
        <input type="date" name="checkOut" min="2024-01-01" max="2024-01-31" required>
        <button type="submit" name="searchAvailable">Search</button>
    </form>

    <div>Nice div containing preliminary room information, such rooms. Many rooms.
        The most rooms that ever roomed.
    </div>
    <!--     <form method="post" action="/app/booking.php">
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
    </form> -->
</main>

<?php require_once __DIR__ . "/nav/footer.html";
