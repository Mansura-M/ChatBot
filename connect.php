<?php
$server = "localhost";
$name = "root";
$database = "chat";
$password = "";
$conn = mysqli_connect($server, $name, $password, $database, '3307');
if (!$conn) {
    die(mysqli_error($conn));
}
mysqli_set_charset($conn, "utf8mb4");
