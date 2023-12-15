<?php
require_once __DIR__ . "/../functions/sessionStart.php";
require_once __DIR__ . "/../functions/hotelFunctions.php";
require_once __DIR__ . "/../nav/header.html";
$db = connect('hotel.sqlite');


//checks whether selected dates (from index.php) are available for booking.
if (isset($_POST['searchAvailable'])) {
    $_SESSION['checkIn'] = $_POST['checkIn'];
    $_SESSION['checkOut'] = $_POST['checkOut'];
    $_SESSION['dateReservation'] = "Your dates: " . $_SESSION['checkIn'] . " - " . $_SESSION['checkOut'];

    $rooms = selectAllRooms();
    $availableRooms = [];

    foreach ($rooms as $room) {
        $bookings = checkRoomAvailability($room['id']);

        if (empty($bookings)) {
            $availableRooms[] = $room;
        }
    }
    //header('Location: /../app/booking.php');
    //exit();

    /* if (empty($bookings)) {
    } else {
        $_SESSION['error'] = "Sorry, no rooms available on selected dates.";
        unset($_SESSION['checkIn']);
        unset($_SESSION['checkOut']);
        header('Location: /../app/booking.php');
        exit();
    } */
}

//does maybe fuck all? 14/12-23
if (isset($_POST['roomSelection'])) {
    $_SESSION['room'] = ucfirst($_POST['selectedRoom']);
    $room = $_SESSION['room'];

    getSpecificRoom($room);
}

?>

<main>
    <h2>Book your stay</h2>
    <?php if (isset($_SESSION['error'])) : ?>
        <p><?= $_SESSION['error']; ?></p>
    <?php endif;
    unset($_SESSION['error']); ?>
    <?php if (isset($_SESSION['dateReservation'])) : ?>
        <h3><?= $_SESSION['dateReservation']; ?></h3>
    <?php endif; ?>
    <div class="calendarView">
        <h3>January 2024</h3>
        <!-- <table>
            <thead>
                <tr>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                    <th>Sun</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $d = 1; // Initialize the day-counter
                while ($d <= 31) : ?>
                    <tr>
                        <?php for ($w = 0; $w < 7; $w++) : ?>

                            <td class="calendar-day" data-day="<?= ($d <= 31) ? $d : ''; ?>">
                                <?php if ($d > 0) : ?>
                                <?php endif; ?>
                                <?= ($d <= 31) ? $d : ''; ?>
                            </td>
                            <?php $d++; ?>
                        <?php endfor; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table> -->
        <!-- <form method="post" action="">
            <input type="date" name="checkIn" min="2024-01-01" max="2024-01-31" required placeholder="2024-01-01">
            <input type="date" name="checkOut" min="2024-01-01" max="2024-01-31" required placeholder="2024-01-01">
            <button type="submit" name="searchAvailable">Search</button>
        </form> -->
    </div>
    <?php if (!empty($availableRooms)) : ?>
        <form method="post" action="/../functions/resolveBooking.php">
            <div class="displayRooms">
                <h2>Available Rooms</h2>
                <?php foreach ($availableRooms as $room) : ?>
                    <div class="room">
                        <h3><?= $room['roomName']; ?> Room</h3>
                        <p>Cost: <?= $room['cost']; ?>$</p>
                        <p>Available</p>
                        <input type="hidden" name="selectedRoom" value="<?= $room['id']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <label id="guestName">Enter Name:</label>
            <input type="text" name="guestName" required>
            <button type="submit" name="bookRoom">Book Selected</button>
        </form>
    <?php else : ?>
        <h3>Sorry, no rooms available for your dates.</h3>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . "/../nav/footer.html";
