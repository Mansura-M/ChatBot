<?php
session_start();
include('connect.php'); // Database connection file

// Get the email and password from the form submission
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($email) && !empty($password)) {
    // Query the database to check if the email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];
        $status = "Active now";
        $sql2 = mysqli_query($conn, "UPDATE users SET status='{$status}' WHERE unique_id={$row['unique_id']}");
        // The hashed password from the database

        // Verify the entered password against the hashed password

        if (password_verify($password, $hashedPassword)) {
            $status = "Active now";
            $sql2 = mysqli_query($conn, "UPDATE users SET status='{$status}' WHERE unique_id={$row['unique_id']}");
            if ($sql2) {

                // Password is correct, so log the user in
                $_SESSION['unique_id'] = $row['unique_id'];
                echo "success";
                // Redirect to users.php or any other page

            } else {
                echo "Something went wrong. Please try again!";
            }
        } else {
            echo "Email or Password is Incorrect!";
        }
    } else {
        echo "$email - This email not Exist!";
    }
} else {
    echo "All input fields are required!";
}
