<?php
require_once __DIR__ . "/functions/sessionStart.php";
require_once __DIR__ . "/nav/header.html";
?>

<main>
    <h1>Hotel Island</h1>
    <p>Here's some real sleazy info about our fabulous hotel.</p>
    <?php if (isset($_SESSION['roomConfirmed'])) : ?>
        <h3><?= $_SESSION['roomConfirmed']; ?></h3>
    <?php endif;
    unset($_SESSION['roomConfirmed']); ?>
</main>

<?php require_once __DIR__ . "/nav/footer.html";
