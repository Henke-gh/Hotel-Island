<?php
require_once __DIR__ . "/functions/sessionStart.php";
require_once __DIR__ . "/functions/hotelFunctions.php";
require_once __DIR__ . "/nav/header.html";

$db = connect('hotel.sqlite');
$rooms = selectAllRooms();
?>

<main>
    <h2>Welcome to Hotel Island</h2>
    <h3>Book your stay now!</h3>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="bookingErrorContainer">
            <p><?= $_SESSION['error']; ?></p>
        </div>
    <?php endif;
    unset($_SESSION['error']); ?>
    <p>- Search dates to see available rooms -</p>
    <form method="post" action="/app/booking.php">
        <input type="date" name="checkIn" min="2024-01-01" max="2024-01-31" required>
        <input type="date" name="checkOut" min="2024-01-01" max="2024-01-31" required>
        <button type="submit" name="searchAvailable">Search</button>
    </form>

    <div class="specialOffer">
        <h2>Stay for three days or more and get 25% off! Available through January 2024!</h2>
    </div>

    <div>
        <form method="post" action="/app/booking.php">
            <div class="displayRooms">
                <div class="room">
                    <h3>Budget Room</h3>
                    <img src="/images/room_temp.png">
                    <p>Description:</p>
                    <p>Cost: <?= $rooms[0]['cost']; ?>$</p>
                </div>
                <div class="room">
                    <h3>Standard Room</h3>
                    <img src="/images/room_temp.png">
                    <p>Description:</p>
                    <p>Cost: <?= $rooms[1]['cost']; ?>$</p>
                </div>
                <div class="room">
                    <h3>Luxury Room</h3>
                    <img src="/images/room_temp.png">
                    <p>Description:</p>
                    <p>Cost: <?= $rooms[2]['cost']; ?>$</p>
                </div>

            </div>
            <div>
                <input type="date" name="checkIn" min="2024-01-01" max="2024-01-31" required>
                <input type="date" name="checkOut" min="2024-01-01" max="2024-01-31" required>
                <button type="submit" name="searchAvailable">Search</button>
            </div>
        </form>
    </div>
</main>

<?php require_once __DIR__ . "/nav/footer.html";
