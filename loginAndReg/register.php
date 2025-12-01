<?php

// use the headers for html from head.php file
include "head.php";
// use try block to catch and report errors when creating the db

try {
    // Open a connection to the SQLite database
    // If the users.db doesn't exist, it will be created.

    // Use these 2 line when you run the php  live on i6 server  (the following two lines)
    $path= "/home/jsl10027/databases";
    $db = new SQLite3($path. '/users.db' );


    //Comment the above code if you are testing the code for local server code ( the line after these comments)

    // use this statemnt if testing from local server (and remove //). This will create a local users.db isnide the same folder as program
    //     $db = new SQLite3($path. '/users.db' );

    // report a message if all went fine for testing purposes
    echo "Successfully connected to the users.db <br>";
} 

    // report the error if we couldnt open the test2.db  for testing purposes

    catch (Exception $e) {
    echo "Error connecting to the database: " . $e->getMessage() . "<br>";

    exit();
}


// create a table inside the test2.db; 
//you can create as many tables as you need - for example you can create two tables for your final project: products and users



// construct a create table (called users) query; if exists then igonre
$sqlCreateTable = " CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user TEXT NOT NULL,
        password TEXT  NOT NULL
    );
";

// execute the line of code to create the table within try block to cath errors assoicated with executing this statemenet 

try {
    $db->exec($sqlCreateTable);
    echo "Table 'users' created successfully or already exists.<br>";
} 

// catch the errors associated with excuting the above statement


catch (Exception $e) {
    echo "Error creating table: " . $e->getMessage() . "<br>";
}

// get values from form to insert inside the users table
$user = $_POST['user'];
$password = $_POST['password'];

echo "<p> $user: $password (only for testing purposes)<p>";


// construct an insert query to store values inside table
$sqlInsert = "INSERT INTO users (user, password) VALUES (:user, :password)";


// use try block to construct an insert query  to store values into users.db

try {

    $stmt = $db->prepare($sqlInsert);
    $stmt->bindValue(':user', $user, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);
    
    // execute the statement 
    $stmt->execute();
    echo " Info iserted: $user and $password values inserted successfully.<br>";


} 

// catch and report errors associated with executing above statements
catch (Exception $e) {
    echo "Error inserting data: " . $e->getMessage() . "<br>";
}


// if we are done with the database we should close it
// this allows Apache to use it again quickly, rather than waiting for
// the database's natural timeout to occur

$db->close();
unset($db);


echo "Database connection closed.<br>";
?>



Using a complete  a SELECT Query with Try/catch block to catch errors and report it

This is a complete example to Search/lockup values using SELECT Query  for login php program

<?php


// use try block to catch and report errors when creating the db

try {
    // Open a connection to the SQLite database
    // If the users.db doesn't exist, it will be created.

    // Use these 2 line when you run the php  live on i6 server  (the following two lines)
    $path= "/home/sao1/databases";
    $db = new SQLite3($path. '/users.db' );


    //Comment the above code if you are testing the code for local server code ( the line after these comments)

    // use this statemnt if testing from local server (and remove //). This will create a local users.db isnide the same folder as program
    //     $db = new SQLite3($path. '/users.db' );

    // report a message if all went fine for testing purposes
    echo "Successfully connected to the users.db <br>";
} 

    // report the error if we couldnt open the test2.db  for testing purposes

    catch (Exception $e) {
    echo "Error connecting to the database: " . $e->getMessage() . "<br>";

    exit();
}


// create a table inside the test2.db; 
//you can create as many tables as you need - for example you can create two tables for your final project: products and users



// construct a create table (called users) query; if exists then igonre
$sqlCreateTable = " CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user TEXT NOT NULL,
        password TEXT  NOT NULL
    );
";

// execute the line of code to create the table within try block to cath errors assoicated with executing this statemenet 

try {
    $db->exec($sqlCreateTable);
    echo "Table 'users' created successfully or already exists.<br>";
} 

// catch the errors associated with excuting the above statement


catch (Exception $e) {
    echo "Error creating table: " . $e->getMessage() . "<br>";
}

// get values from form to insert inside the users table
$user = $_POST['user'];
$password = $_POST['password'];

echo "<p> $user: $password (only for testing purposes)<p>";


// construct an insert query to store values inside table
$sqlInsert = "INSERT INTO users (user, password) VALUES (:user, :password)";


// use try block to construct an insert query  to store values into users.db

try {

    $stmt = $db->prepare($sqlInsert);
    $stmt->bindValue(':user', $user, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);
    
    // execute the statement 
    $stmt->execute();
    echo " Info iserted: $user and $password values inserted successfully.<br>";


} 

// catch and report errors associated with executing above statements
catch (Exception $e) {
    echo "Error inserting data: " . $e->getMessage() . "<br>";
}


// if we are done with the database we should close it
// this allows Apache to use it again quickly, rather than waiting for
// the database's natural timeout to occur

$db->close();
unset($db);


echo "Database connection closed.<br>";

// include the footer php file which contains the ending of the html commands
include "footer.php";
?>