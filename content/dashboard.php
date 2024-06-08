<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
<p>Email: <?php echo $_SESSION['email']; ?></p>
<a href="products.php">List Product</a>
<form action="logout.php" method="post">
    <input type="submit" name="logout" value="Logout">
</form>
