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
        <div class="calendar">
            <table class="calendar">
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
                    $year = 2024;
                    $month = 1;
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $firstDayOfMonth = date('N', strtotime("$year-$month-01"));
                    $currentDay = 1;
                    for ($i = 0; $i < 6; $i++) : ?>
                        <tr>
                            <?php for ($d = 1; $d <= 7; $d++) : ?>
                                <td class="day" id="day">
                                    <?php
                                    if ($i === 0 && $d < $firstDayOfMonth) :
                                        echo "";
                                    else :
                                        echo $currentDay <= $daysInMonth ? $currentDay++ : ""; ?>
                                        <input type="hidden" value="<?= $currentDay ?>" name="selectedDays[]">
                                    <?php endif;
                                    ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
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
