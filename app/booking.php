<?php
require_once __DIR__ . "/../functions/sessionStart.php";
require_once __DIR__ . "/../functions/hotelFunctions.php";
require_once __DIR__ . "/../nav/header.html";

try {
    $db = new PDO('sqlite:../hotel.sqlite');

    $query = "SELECT * FROM rooms";

    // Execute the query
    $statement = $db->query($query);

    // Fetch all rows as an associative array
    $rooms = $statement->fetchAll();
} catch (PDOException $e) {
    echo "Erro fetching room data.";
    throw $e;
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
        <form method="post" action="">
            <input type="date" name="checkIn" min="2024-01-01" max="2024-01-31">
            <input type="date" name="checkOut" min="2024-01-01" max="2024-01-31">
            <button type="submit" name="searchAvailable">search</button>
        </form>
    </div>
    <form method="post" action="/../functions/resolveBooking.php">
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
        <label id="guestFirstName">Enter First Name:</label>
        <input type="text" name="guestFirstName" required>
        <label id="guestLastName">Enter Last Name:</label>
        <input type="text" name="guestFLastName" required>
        <button type="submit" name="bookRoom">Book Selected</button>
    </form>
</main>

<?php require_once __DIR__ . "/../nav/footer.html";
