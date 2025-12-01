<?php


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


// get values from form to to lokup in table and see if there is a match 
$user = $_POST['user'];
$password = $_POST['password'];

// print only for testing purposes and then remove later
echo "<p> user entered value from form is $user and passowrd value entered from form is $password <p>";



// create a line of code to lockup info from table users (was created inside the regSQL.php registration program)


// not needed for this login example- you can remove
// this is to demo how you get all info (all records or row from table)

$sqlSelect = "SELECT id, user, password FROM users";


// use try block to execute the query to query all fields from table users

try {
    $results = $db->query($sqlSelect);


    // create formatted html output to print as output of query to user
    // Agin, this is not needed for this example
    // this is to demo how to print all rows from table
    
    echo "<h2>Users List looked up (search query) from Users table:</h2>";
    echo "<ul>";


    $flag = 0;
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        echo "<li> ID: " . $row['id'] . ", user: " . $row['user'] . ", password: " . $row['password'] . "</li>";
    }
 

} 

// report errors based on executing above statement

catch (Exception $e) {
    echo "<p>Error querying data: " . $e->getMessage() . "<br>";
}


// find a match with user name and password from db and form values

// create a line of code to lockup info from table users (was created inside the regSQL.php registration program)

$sqlSelect2 = "SELECT id, user, password FROM users WHERE user='$user' and password='$password' ";


// use try block to execute the query; 
// See if you find a match

try {

    $results2 = $db->query($sqlSelect2);

    if ($results2 === false) 
    {
        echo "<p>Error querying data: " . $db->lastErrorMsg() . "<br>";
    } 

    else 
    {
        // Try to fetch one row
        $row = $results2->fetchArray(SQLITE3_ASSOC);

        // if a it returns a row (a match found)
        if ($row) 
        {
            // Match found
            echo "<p>match found- Congrats!
                <p> You are able to login.  Welcome to our website, $user!<br></p>";
        } 

        // no match found
        else 
        {
            // No match
            echo "<p>You can't access our website:<br>Wrong username or password. 
                  <a href='login.html'>Try again</a></p>";
        }
    
    }

} 


// report errors based on executing above statement

catch (Exception $e) 
{
    echo "<p>Error querying data: " . $e->getMessage() . "<br>";
}



// close db

$db->close();


?>