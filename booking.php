<?php
require_once __DIR__ . "/functions/sessionStart.php";
require_once __DIR__ . "/nav/header.html";
?>

<main>
    <h1>Hotel Island</h1>
    <?php if (isset($_SESSION['error'])) : ?>
        <p><?= $_SESSION['error']; ?></p>
    <?php endif;
    unset($_SESSION['error']); ?>
    <form method="post" action="/functions/resolveBooking.php">
        <div class="displayRooms">
            <div class="room">
                <h3>Budget Room</h3>
                <p>Available</p>
                <input type="checkbox" value="budget">
            </div>
            <div class="room">
                <h3>Standard Room</h3>
                <p>Available</p>
                <input type="checkbox" value="standard">
            </div>
            <div class="room">
                <h3>Luxury Room</h3>
                <p>Available</p>
                <input type="checkbox" value="luxury">
            </div>
        </div>
        <button type="submit" name="bookRoom">Book Selected</button>
    </form>
</main>

<?php require_once __DIR__ . "/nav/footer.html";
