<?php
require_once __DIR__ . "/functions/sessionStart.php";
require_once __DIR__ . "/functions/hotelFunctions.php";
require_once __DIR__ . "/nav/header.html";

$db = connect('hotel.sqlite');
$rooms = selectAllRooms();
?>

<main>
    <h1>Welcome to Hotel Island</h1>
    <h2>Book your stay now!</h2>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="bookingErrorContainer">
            <p><?= $_SESSION['error']; ?></p>
        </div>
    <?php endif;
    unset($_SESSION['error']); ?>
    <p>- Search dates to see available rooms -</p>
    <form method="post" action="/app/booking.php">
        <div class="datesContainer">
            <input class="datePicker" type="date" name="checkIn" min="2024-01-01" max="2024-01-31" required>
            <input class="datePicker" type="date" name="checkOut" min="2024-01-01" max="2024-01-31" required>
            <button class="dateSelect" type="submit" name="searchAvailable">Search</button>
        </div>
    </form>

    <div class="specialOffer">
        <h2>Stay for three days or more and get 25% off! Available through January 2024!</h2>
    </div>

    <h2>Read up on our Rooms</h2>
    <div class="displayRooms">
        <div class="room">
            <h2><?= $rooms[0]['roomName']; ?></h2>
            <img src="/images/room_temp.png">
            <p><?= $rooms[0]['description']; ?></p>
            <p>Cost: <?= $rooms[0]['cost']; ?>$</p>
        </div>
        <div class="room">
            <h2><?= $rooms[1]['roomName']; ?></h2>
            <img src="/images/room_temp.png">
            <p><?= $rooms[1]['description']; ?></p>
            <p>Cost: <?= $rooms[1]['cost']; ?>$</p>
        </div>
        <div class="room">
            <h2><?= $rooms[2]['roomName']; ?></h2>
            <img src="/images/room_temp.png">
            <p><?= $rooms[2]['description']; ?></p>
            <p>Cost: <?= $rooms[2]['cost']; ?>$</p>
        </div>

    </div>
    <form method="post" action="/app/booking.php">
        <div class="datesContainer">
            <input class="datePicker" type="date" name="checkIn" min="2024-01-01" max="2024-01-31" required>
            <input class="datePicker" type="date" name="checkOut" min="2024-01-01" max="2024-01-31" required>
            <button class="dateSelect" type="submit" name="searchAvailable">Search</button>
        </div>
    </form>
</main>

<?php require_once __DIR__ . "/nav/footer.html";
