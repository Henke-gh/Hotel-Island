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

    getNumberOfDaysBooked();

    $rooms = selectAllRooms();
    $availableRooms = [];
    //checks which specific rooms are available, if any and puts them in the availableRooms array.
    foreach ($rooms as $room) {
        $bookings = checkRoomAvailability($room['id']);

        if (empty($bookings)) {
            $availableRooms[] = $room;
        }
    }
}

?>

<main>
    <h1>Book your stay</h1>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="bookingErrorContainer">
            <p><?= $_SESSION['error']; ?></p>
        </div>
    <?php endif;
    unset($_SESSION['error']); ?>
    <?php if (isset($_SESSION['dateReservation'])) : ?>
        <h3><?= $_SESSION['dateReservation']; ?></h3>
    <?php endif; ?>
    <div class="calendarView">
        <!-- <h3>January 2024</h3> -->
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
        <h1>Available Rooms</h1>
        <form method="post" action="/../functions/resolveBooking.php">
            <div class="displayRooms">
                <?php foreach ($availableRooms as $room) :
                    $totalCost = $numberOfDays * $room['cost'];
                    $totalCost = checkOfferValidity(); ?>
                    <div class="room">
                        <h2><?= $room['roomName']; ?></h2>
                        <img src="/images/room_temp.png">
                        <p><?= $room['description']; ?></p>
                        <p>Price per day: <?= $room['cost']; ?>$</p>
                        <p>Total cost: <?= $totalCost; ?>$</p>
                        <p>Available</p>
                        <input type="radio" name="selectedRoomID" value="<?= $room['id']; ?>">
                        <label name="selectedRoomID">Select Room</label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="addExtraPerksContainer">
                <h2>About our specials</h2>
                <div class="specialsInfoContainer">
                    <?php
                    $extras = selectAllExtras();
                    foreach ($extras as $extra) : ?>
                        <div class="specialsInfo">
                            <h3><?= $extra['featureName']; ?></h3>
                            <p><?= $extra['tagline']; ?></p>
                            <p><?= $extra['description']; ?></p>
                            <p><?= $extra['cost']; ?>$</p>
                            <div class="addExtraPerks">
                                <label for="extrasOption"><?= $extra['featureName']; ?></label>
                                <input type="checkbox" name="extrasOption[]" value="<?= $extra['id']; ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="bookStayWrapper">
                <div class="bookStay">
                    <h2>Enter Additional Booking Information</h2>
                    <label id="guestName">Enter Name:</label>
                    <input type="text" name="guestName" required>
                    <label id="guestTransferCode">Enter Transfer Code:</label>
                    <input type="text" name="guestTransferCode" required>
                    <button type="submit" name="bookRoom">Book Stay</button>
                    <div class="getTransferCode">
                        <a href="https://www.yrgopelag.se/centralbank/" target="_blank">Get Transfercode - Central Bank</a>
                        <p>(Opens in new tab)</p>
                    </div>
                </div>
            </div>
        </form>
    <?php else : ?>
        <h3>Sorry, no rooms available for your dates.</h3>
        <h3>Select other dates.</h3>
        <form method="post" action="/../app/booking.php">
            <div class="datesContainer">
                <input class="datePicker" type="date" name="checkIn" min="2024-01-01" max="2024-01-31" required>
                <input class="datePicker" type="date" name="checkOut" min="2024-01-01" max="2024-01-31" required>
                <button class="dateSelect" type="submit" name="searchAvailable">Search</button>
            </div>
        </form>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . "/../nav/footer.html";
