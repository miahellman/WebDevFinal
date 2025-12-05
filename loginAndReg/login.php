<?php
session_start();

try {
    $path = "/home/jsl10027/databases";
    $db = new SQLite3($path . '/users.db');
} 
catch (Exception $e) {
    $errorMsg = "Error connecting to the database: " . $e->getMessage();
}

$user = trim($_POST['user'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($user === "" || $password === "") {
    $errorMsg = "PLEASE FILL OUT ALL FIELDS!";
}

$sqlSelect2 = "SELECT id, user, password FROM users WHERE user = :user AND password = :password";
$stmt = $db->prepare($sqlSelect2);
$stmt->bindValue(':user', $user, SQLITE3_TEXT);
$stmt->bindValue(':password', $password, SQLITE3_TEXT);

try {
    $results2 = $stmt->execute();

    if ($results2 === false) {
        $errorMsg = "Error querying data: " . $db->lastErrorMsg();
    } else {
        $row = $results2->fetchArray(SQLITE3_ASSOC);

        if ($row) {
            $_SESSION['user'] = $user;
            header("Location: welcome.php");
            exit();
        } else {
            $errorMsg = "incorrect username or password!";
        }
    }
} 
catch (Exception $e) {
    $errorMsg = "Error querying data: " . $e->getMessage();
}

$db->close();

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Failed</title>
  <link rel="stylesheet" href="../styles.css">
  <style>
    .error-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 70vh;
    }
    .content-section {
        text-align: center;
    }
  </style>
</head>
<body>

<?php include('header.php'); ?>

<div class="error-container">
    <div class="main-container">
        <div class="content-section">
            <h2>LOGIN FAILED</h2>
            <p class="italic"><?php echo htmlspecialchars($errorMsg); ?></p>
            <a href="login.html" class="cta-btn" style="text-decoration:none;">try again?</a>
        </div>
    </div>
</div>

</body>
</html>
