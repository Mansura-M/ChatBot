<?php
session_start();
include_once("connect.php");
$outgoing_id = $_SESSION['unique_id'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchterm']);
$sql = mysqli_query($conn, "SELECT* FROM users WHERE NOT unique_id={$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%' )");
$output = "";
if (mysqli_num_rows($sql) > 0) {
    include("data.php");
    // $output .= "found";
} else {
    $output .= "user not found";
}
echo $output;
