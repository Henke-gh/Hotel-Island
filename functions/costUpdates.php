<?php

declare(strict_types=1);
require_once __DIR__ . "/../functions/sessionStart.php";
require_once __DIR__ . "/../functions/hotelFunctions.php";

$db = connect();

if (isset($_POST['updateRoomCost'], $_POST['newRoomCost'])) {
    $newRoomCost = intval(htmlspecialchars($_POST['newRoomCost'], ENT_QUOTES));
    $roomID = intval($_POST['updateRoomCost']);
    updateRoomCost($roomID, $newRoomCost);
    header('Location: /../app/admin.php');
    exit();
} elseif (isset($_POST['updateExtraCost'], $_POST['newExtraCost'])) {
    $newExtraCost = intval(htmlspecialchars($_POST['newExtraCost'], ENT_QUOTES));
    $extraID = intval($_POST['updateExtraCost']);
    updateExtrasCost($extraID, $newExtraCost);
    header('Location: /../app/admin.php');
    exit();
} else {
    header('Location: /../app/admin.php');
    exit();
}
