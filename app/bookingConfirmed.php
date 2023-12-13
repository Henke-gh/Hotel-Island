<?php
require_once __DIR__ . "/../functions/sessionStart.php";
require_once __DIR__ . "/../nav/header.html";
?>

<main>
    <?php if (isset($_SESSION['roomConfirmed'])) : ?>
        <h3><?= $_SESSION['roomConfirmed']; ?></h3>
        <p>You have booked date(s) <?= $_SESSION['datesBooked']; ?></p>
    <?php endif;
    unset($_SESSION['roomConfirmed']);
    unset($_SESSION['datesBooked']); ?>

    <a href="/../index.php">Return to Front Page</a>
</main>

<?php require_once __DIR__ . "/../nav/footer.html";
