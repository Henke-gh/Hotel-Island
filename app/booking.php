<?php
require_once __DIR__ . "/../functions/sessionStart.php";
require_once __DIR__ . "/../functions/hotelFunctions.php";
require_once __DIR__ . "/../nav/header.html";

if (isset($_POST['roomSelection'])) {
    $_SESSION['room'] = ucfirst($_POST['selectedRoom']);
    $room = $_SESSION['room'];

    try {
        $db = connect();
        $query = "SELECT * FROM rooms WHERE roomName = '$room'";

        $statement = $db->query($query);

        $selectedRoom = $statement->fetch();
        $_SESSION['selectedRoom'] = $selectedRoom;
    } catch (PDOException $e) {
        echo "Error fetching room data.";
        throw $e;
    }
}

?>

<main>
    <h2>Book your stay</h2>
    <?php if (isset($_SESSION['error'])) : ?>
        <p><?= $_SESSION['error']; ?></p>
    <?php endif;
    unset($_SESSION['error']); ?>
    <div class="calendarView">
        <h3>January 2024</h3>
        <table>
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
        </table>
        <form method="post" action="/../functions/resolveBooking.php">
            <input type="date" name="checkIn" min="2024-01-01" max="2024-01-31" required placeholder="2024-01-01">
            <input type="date" name="checkOut" min="2024-01-01" max="2024-01-31" required placeholder="2024-01-01">
            <button type="submit" name="searchAvailable">Search</button>
        </form>
        <?php if (isset($_SESSION['dateReservation'])) : ?>
            <h4>Your dates: <?= $_SESSION['dateReservation']; ?></h4>
        <?php endif; ?>
    </div>
    <form method="post" action="/../functions/resolveBooking.php">
        <div class="displayRooms">
            <h2>Your Room</h2>
            <div class="room">
                <h3><?= $_SESSION['selectedRoom']['roomName']; ?> Room</h3>
                <p>Cost: <?= $_SESSION['selectedRoom']['cost']; ?>$</p>
                <p>Available</p>
                <input type="hidden" name="selectedRoom" value="<?= $_SESSION['selectedRoom']['id']; ?>">
            </div>
        </div>
        <label id="guestName">Enter Name:</label>
        <input type="text" name="guestName" required>
        <button type="submit" name="bookRoom">Book Selected</button>
    </form>
</main>

<?php require_once __DIR__ . "/../nav/footer.html";
