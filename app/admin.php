<?php
require_once __DIR__ . "/../functions/sessionStart.php";
if (!$_SESSION['adminLoggedIn']) {
    header('Location: /../index.php');
}
require_once __DIR__ . "/../functions/arrays.php";
require_once __DIR__ . "/../functions/hotelFunctions.php";
require_once __DIR__ . "/../nav/header.html";
$db = connect();
$funds = getAccountBalance();
$rooms = selectAllRooms();
$extras = selectAllExtras();

if (isset($_POST['updateRoomCost'], $_POST['newRoomCost'])) {
    echo $_POST['updateRoomCost'] . " Room ID";
    $newRoomCost = intval($_POST['newRoomCost']);
    echo $newRoomCost . " New Room Cost";
}

if (isset($_POST['updateExtraCost'], $_POST['newExtraCost'])) {
    echo "Extra ID: " . $_POST['updateExtraCost'];
    $newExtraCost = intval($_POST['newExtraCost']);
    echo "New Extra Cost: " . $newExtraCost;
    var_dump($_POST['updateExtraCost']);
    var_dump($newExtraCost);
}
?>

<main>
    <h2>Admin page for Featherby Hotel</h2>
    <div class="adminAccountInfo">
        <h2>Hotel Account Balance</h2>
        <p>Manager: Name</p>
        <p>Funds: $$$</p>
    </div>
    <div class="adminControls">
        <h2>Adjust Room Cost</h2>
        <?php foreach ($rooms as $room) : ?>
            <form method="post" action="admin.php">
                <div class="costControl">
                    <p><?= "ID: " . $room['id'] . " - " . $room['roomName'] . ": " . $room['cost'] . "$"; ?></p>
                    <input type="number" name="newRoomCost">
                    <button type="submit" name="updateRoomCost" value="<?= $room['id']; ?>">Update Cost</button>
                </div>
            </form>
        <?php endforeach; ?>
        <h2>Adjust Extras Cost</h2>
        <?php foreach ($extras as $extra) : ?>
            <form method="post" action="admin.php">
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
