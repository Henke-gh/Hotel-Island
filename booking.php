<?php
require_once __DIR__ . "/functions/sessionStart.php";
require_once __DIR__ . "/nav/header.html";
?>

<main>
    <h2>Book your stay</h2>
    <?php if (isset($_SESSION['error'])) : ?>
        <p><?= $_SESSION['error']; ?></p>
    <?php endif;
    unset($_SESSION['error']); ?>
    <form method="post" action="/functions/resolveBooking.php">
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
                <form method="post" action="/functions/resolveBooking.php">
                    <tbody>
                        <?php
                        $d = 1; // Initialize the day-counter
                        while ($d <= 31) : ?>
                            <tr>
                                <?php for ($w = 0; $w < 7; $w++) : ?>

                                    <td>
                                        <input type="checkbox" name="selectedDays[]" value="<?= ($d <= 31) ? $d : ''; ?>">
                                        class="calendar-day" data-day="<?= ($d <= 31) ? $d : ''; ?>">
                                        <?= ($d <= 31) ? $d : ''; ?>
                                    </td>
                                    <?php $d++; ?>
                                <?php endfor; ?>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </form>
            </table>
        </div>
        <div class="displayRooms">
            <div class="room">
                <h3>Budget Room</h3>
                <p>Available</p>
                <input type="radio" name="selectedRoom" value="budget">
            </div>
            <div class="room">
                <h3>Standard Room</h3>
                <p>Available</p>
                <input type="radio" name="selectedRoom" value="standard">
            </div>
            <div class="room">
                <h3>Luxury Room</h3>
                <p>Available</p>
                <input type="radio" name="selectedRoom" value="luxury">
            </div>
        </div>
        <button type="submit" name="bookRoom">Book Selected</button>
    </form>
</main>

<?php require_once __DIR__ . "/nav/footer.html";
