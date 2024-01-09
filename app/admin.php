<?php
require_once __DIR__ . "/../functions/sessionStart.php";
require_once __DIR__ . "/../functions/arrays.php";
require_once __DIR__ . "/../functions/hotelFunctions.php";
require_once __DIR__ . "/../nav/header.html";

$hashedPW = password_hash($newUserPW, PASSWORD_DEFAULT);

$prepare = $db->prepare('INSERT INTO users (username, password_Hash)
            VALUES (:userName, :userPW)');

$prepare->bindParam(':userName', $newUsername);
$prepare->bindParam(':userPW', $hashedPW);
$prepare->execute();
?>

<main>
    <h2>Admin page for Featherby Hotel</h2>

</main>

<?php require_once __DIR__ . "/../nav/footer.html";
