<?php
//PHP HERE
// step 1: we need to identify the full file path of where our
// databases are stored on the server.
$path = '/your/file/path/goes/here';

// step 2: connect to our database, making sure to use the full
// file path when specifying the database file location
$db = new SQLite3($path.'/users.db');
?>