<?php
require_once __DIR__ . "/../functions/sessionStart.php";
require_once __DIR__ . "/../nav/header.html";
?>

<main>
    <?php if (isset($_SESSION['roomConfirmed'])) : ?>
        <h3><?= $_SESSION['roomConfirmed']; ?></h3>
        <p><?= $_SESSION['datesBooked']; ?></p>
        <a class="jsonResponseLink" href="/../app/jsonResponse.php" target="_blank">Click here for your JSON-response. (Opens in a new tab)</a>
    <?php endif;
    unset($_SESSION['roomConfirmed']);
    unset($_SESSION['datesBooked']); ?>

    <a class="linkBookingConfirmed" href="/../index.php">Return to Front Page</a>
</main>

<?php require_once __DIR__ . "/../nav/footer.html";
