<?php

session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "connect.php";
    $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
    // Check if logout_id is set in the URL
    if (isset($_GET['logout_id'])) {

        $status = "offline";

        // Prepare and execute the SQL query
        $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$_GET['logout_id']}'");

        // Check if the SQL query was successful
        if ($sql) {
            // Clear session data and destroy the session
            session_unset();
            session_destroy();
            header("location: ../login.php");
            exit(); // It's good practice to call exit after a header redirect
        } else {
            // Log the error or handle it accordingly
            echo "Error updating status: " . mysqli_error($conn);
        }
    } else {
        header("location: ../users.php");
        exit(); // Exit after redirect
    }
} else {
    header("location: ../login.php");
    exit(); // Exit after redirect
}
