<?php 
include "head.php";

try {
    //use this when running live on server
    $path= "/home/jsl10027/databases";
    $db = new SQLite3($path . '/users.db');

} catch (Exception $e) {
    echo "Error connecting to database: " . $e->getMessage();
    exit();
}

//create users table if not exists
$sqlCreateTable = "
CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
);
";

try {
    $db->exec($sqlCreateTable);
} catch (Exception $e) {
    echo "Error creating table: " . $e->getMessage();
}

$user = trim($_POST['user']);
$password = trim($_POST['password']);

if ($user === "" || $password === "") {
    echo "<p style='color:red;'>Please fill out all fields.</p>";
    echo "<a href='register.php'>Back</a>";
    exit();
}

//prevent duplicate usernames (using SELECT)
$sqlSelect = "SELECT * FROM users WHERE user = :user";
$stmtSelect = $db->prepare($sqlSelect);
$stmtSelect->bindValue(':user', $user, SQLITE3_TEXT);
$result = $stmtSelect->execute();

$row = $result->fetchArray(SQLITE3_ASSOC);

if ($row) {
$errorMsg = "This user already exists. Login or try another username.";

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REGISTRATION FAILED</title>
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
            <h2>REGISTRATION FAILED</h2>
            <p class="italic"><?php echo htmlspecialchars($errorMsg); ?></p>
            <a href="register.html" class="cta-btn" style="text-decoration:none;">try again?</a>
        </div>
    </div>
</div>

</body>
</html>
<?php
exit();

}

//insert new user
$sqlInsert = "INSERT INTO users (user, password) VALUES (:user, :password)";

try {
    $stmt = $db->prepare($sqlInsert);
    $stmt->bindValue(':user', $user, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);
    $stmt->execute();
} catch (Exception $e) {
    echo "Error inserting data: " . $e->getMessage();
}

$db->close();
unset($db);

//redirect to login after success
header("Location: login.html");
exit();
?>
