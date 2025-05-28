<?php
//Connection String
$conn = mysqli_connect("localhost", "root", "", "php_act");
//Host name, Username, Password :NO

//Test connection to database
if (!$conn) {
    die('Could not connect: ' . mysqli_error()); // If not connected
} else {
    echo "<br><br>"; //If connected
}
?>