<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WELCOME</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>

<?php include('../header.php'); ?>

<div class="main-container">
    <div class="content-section">
        <h1>WELCOME, <?php echo htmlspecialchars($user); ?>!</h1>
        <p class="italic">Welcome back! Explore the site and see what's new.</p>
        <section class="about">
            <p>Check our store page to see any new merch or apparel you might be interested in! We appreciate the support. Or, play a game on our games page! Both pages can be accessed from the header.</p>
        </section>
    </div>
    <div class="image-section">
        <img src="../planets.png">
    </div>
</div>
  <footer>
    ©SPACE NETWORK, 2025
  </footer>
</body>
</html>
