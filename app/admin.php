<?php
require_once __DIR__ . "/../functions/sessionStart.php";
if (!$_SESSION['adminLoggedIn']) {
    header('Location: /../index.php');
}
require_once __DIR__ . "/../functions/arrays.php";
require_once __DIR__ . "/../functions/hotelFunctions.php";
require_once __DIR__ . "/../nav/header.html";

//connect to the .env-file to get APIKEY and Username.
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');

$dotenv->load();

$db = connect();
$funds = getAccountBalance($_ENV['API_KEY'], $_ENV['USER_NAME']);
$rooms = selectAllRooms();
$extras = selectAllExtras();
?>

<main>
    <h2>Admin page for Featherby Hotel</h2>
    <div class="adminAccountInfo">
        <h2>Hotel Account Balance</h2>
        <p>Manager: <?= $_ENV['USER_NAME']; ?></p>
        <p>Funds: <?= $funds; ?>$</p>
    </div>
    <div class="adminControls">
        <h2>Adjust Room Cost</h2>
        <?php foreach ($rooms as $room) : ?>
            <form method="post" action="/../functions/costUpdates.php">
                <div class="costControl">
                    <p><?= $room['roomName'] . ": " . $room['cost'] . "$"; ?></p>
                    <input type="number" name="newRoomCost">
                    <button type="submit" name="updateRoomCost" value="<?= $room['id']; ?>">Update Cost</button>
                </div>
            </form>
        <?php endforeach; ?>
        <h2>Adjust Extras Cost</h2>
        <?php foreach ($extras as $extra) : ?>
            <form method="post" action="/../functions/costUpdates.php">
                <div class="costControl">
                    <p><?= $extra['featureName'] . ": " . $extra['cost'] . "$"; ?></p>
                    <input type="number" name="newExtraCost">
                    <button type="submit" name="updateExtraCost" value="<?= $extra['id']; ?>">Update Cost</button>
                </div>
            </form>
        <?php endforeach; ?>
    </div>

    <div class="adminLogout">
        <form method="post" action="/../functions/logoutVerify.php">
            <button type="submit" name="logout">Log out</button>
        </form>
    </div>
</main>

<?php require_once __DIR__ . "/../nav/footer.html";
