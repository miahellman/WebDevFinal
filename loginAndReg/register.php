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
    echo "<p style='color:red;'>That username already exists. Try another.</p>";
    echo "<a href='register.php'>Back</a>";
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
