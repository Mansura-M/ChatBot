<?php
session_start();
include("connect.php");

$fname = mysqli_real_escape_string($conn, $_POST["firstName"]);
$lname = mysqli_real_escape_string($conn, $_POST["lastName"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);

// Ensure all fields are filled
if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // Check if email already exists
        $sql = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "{$email} already exists!!";
        } else {
            // Check if an image is uploaded
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];

                // Get image extension
                $img_explode = explode(".", $img_name);
                $img_ext = end($img_explode);

                // Allowed image extensions
                $extensions = ['png', 'jpeg', 'jpg'];
                if (in_array($img_ext, $extensions) === true) {

                    // Rename the image to avoid duplication
                    $time = time();  // Current time to rename image
                    $new_img_name = $time . $img_name;

                    // Move image to "images" folder
                    if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) {

                        // Encrypt password for security
                        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                        // Set the user's status and create a unique ID
                        $status = "Active now";
                        $random_id = rand(time(), 10000000);

                        // Insert user data into the database
                        $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status) 
                                                    VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$hashed_password}', '{$new_img_name}', '{$status}')");

                        if ($sql2) {
                            // Retrieve the newly inserted user data
                            $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
                            if (mysqli_num_rows($sql3) > 0) {
                                $row = mysqli_fetch_assoc($sql3);

                                // Set session for logged in user
                                $_SESSION['unique_id'] = $row['unique_id'];

                                // Return success message
                                echo "success";
                            }
                        } else {
                            echo "Something went wrong. Couldn't insert data.";
                        }
                    } else {
                        echo "Failed to upload image.";
                    }
                } else {
                    echo "Please select a valid image format - jpeg, png, jpg.";
                }
            } else {
                echo "Please upload an image.";
            }
        }
    } else {
        echo "{$email} is not a valid email address.";
    }
} else {
    echo "All input fields are required.";
}
