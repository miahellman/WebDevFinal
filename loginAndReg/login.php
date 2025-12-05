<?php
session_start();

try {
    $path = "/home/jsl10027/databases";
    $db = new SQLite3($path . '/users.db');
} 
catch (Exception $e) {
    echo "<p style='color:red;'>Error connecting to the database: " . $e->getMessage() . "</p>";
    exit();
}

$user = trim($_POST['user'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($user === "" || $password === "") {
    echo "<p style='color:red;'>Please fill out all fields.</p>";
    echo "<a href='login.html'>Back</a>";
    exit();
}

$sqlSelect2 = "SELECT id, user, password FROM users WHERE user = :user AND password = :password";
$stmt = $db->prepare($sqlSelect2);
$stmt->bindValue(':user', $user, SQLITE3_TEXT);
$stmt->bindValue(':password', $password, SQLITE3_TEXT);

try {
    $results2 = $stmt->execute();

    if ($results2 === false) {
        echo "<p style='color:red;'>Error querying data: " . $db->lastErrorMsg() . "</p>";
    } else {
        $row = $results2->fetchArray(SQLITE3_ASSOC);

        if ($row) {
            $_SESSION['user'] = $user;
            header("Location: welcome.php");
            exit();
        } else {
            echo "<h2 style='color:red;'>Login Failed</h2>";
            echo "<p style='color:red;'>Incorrect username or password.</p>";
            echo "<a href='login.html'>Try again</a>";
        }
    }
} 
catch (Exception $e) {
    echo "<p style='color:red;'>Error querying data: " . $e->getMessage() . "</p>";
}

$db->close();
?>
