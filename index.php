<?php
require_once __DIR__ . "/functions/sessionStart.php";
require_once __DIR__ . "/functions/hotelFunctions.php";
require_once __DIR__ . "/nav/header.html";

$db = connect();
$rooms = selectAllRooms();
?>

<main>
    <section class="welcome">
        <div class="welcomeMsg">
            <h1>Welcome to the Featherby Hotel</h1>
            <h2> &#9734; &#9734; &#9734;</h2>
            <h2>Book your stay now!</h2>
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="bookingErrorContainer">
                    <p><?= $_SESSION['error']; ?></p>
                </div>
            <?php endif;
            unset($_SESSION['error']); ?>
            <p>- Search dates to see available rooms -</p>
        </div>
        <form method="post" action="/app/booking.php">
            <div class="datesContainer">
                <input class="datePicker" type="date" name="checkIn" min="2024-01-01" max="2024-01-31" required>
                <input class="datePicker" type="date" name="checkOut" min="2024-01-01" max="2024-01-31" required>
                <button class="dateSelect" type="submit" name="searchAvailable">Search
                    <img class="searchImg" src="/images/search.svg"></button>
            </div>
        </form>
    </section>
    <h2>Our Rooms</h2>
    <div class="displayRooms">
        <div class="room">
            <section>
                <img src="/<?= $rooms[0]['imageURL']; ?>">
            </section>
            <h2><?= $rooms[0]['roomName']; ?></h2>
            <p><?= $rooms[0]['description']; ?></p>
            <p>Cost: <?= $rooms[0]['cost']; ?>$/ per night.</p>
        </div>
        <div class="room">
            <section>
                <img src="/<?= $rooms[1]['imageURL']; ?>">
            </section>
            <h2><?= $rooms[1]['roomName']; ?></h2>
            <p><?= $rooms[1]['description']; ?></p>
            <p>Cost: <?= $rooms[1]['cost']; ?>$/ per night.</p>
        </div>
        <div class="room">
            <section>
                <img src="/<?= $rooms[2]['imageURL']; ?>">
            </section>
            <h2><?= $rooms[2]['roomName']; ?></h2>
            <p><?= $rooms[2]['description']; ?></p>
            <p>Cost: <?= $rooms[2]['cost']; ?>$/ per night.</p>
        </div>

    </div>
    <p>- Search dates to see available rooms -</p>
    <form method="post" action="/app/booking.php">
        <div class="datesContainer">
            <input class="datePicker" type="date" name="checkIn" min="2024-01-01" max="2024-01-31" required>
            <input class="datePicker" type="date" name="checkOut" min="2024-01-01" max="2024-01-31" required>
            <button class="dateSelect" type="submit" name="searchAvailable">Search
                <img class="searchImg" src="/images/search.svg"></button>
        </div>
    </form>
</main>

<?php require_once __DIR__ . "/nav/footer.html";
