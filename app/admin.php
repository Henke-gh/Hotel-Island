<?php
require_once __DIR__ . "/../functions/sessionStart.php";
if (!$_SESSION['adminLoggedIn']) {
    header('Location: /../index.php');
}
require_once __DIR__ . "/../functions/arrays.php";
require_once __DIR__ . "/../functions/hotelFunctions.php";
require_once __DIR__ . "/../nav/header.html";
$db = connect('hotel.sqlite');
?>

<main>
    <h2>Admin page for Featherby Hotel</h2>
    <div class="adminControls">
        <p>Do things here. Adjust room and extras cost. Remove bookings?</p>
    </div>
    <form method="post" action="/../functions/logoutVerify.php">
        <button type="submit" name="logout">Log out</button>
    </form>
</main>

<?php require_once __DIR__ . "/../nav/footer.html";
