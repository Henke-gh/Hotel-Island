<?php
require_once __DIR__ . "/../functions/sessionStart.php";
if (isset($_SESSION['adminLoggedIn'])) {
    header('Location: /../app/admin.php');
    exit();
}
require_once __DIR__ . "/../nav/header.html";
?>

<main>
    <form method="post" action="/../functions/loginVerify.php">
        <div class="adminLoginContainer">
            <label>Username:</label>
            <input type="text" name="adminUsername" required>
            <label>Password:</label>
            <input type="password" name="adminPassword" required>
            <button type="submit" name="login">Login</button>
        </div>
    </form>

</main>

<?php
require_once __DIR__ . "/../nav/footer.html";
