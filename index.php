<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    header("location:users.php");
}
?>

<?php
include("header.php");
?>
<html>
<meta charset="UTF-8">

<body>

    <div class="container">
        <h1>Welcome to my ChatRoom</h1>

        <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">

            <div class="info">
                <div class="error"></div>
                <div class="name-fields">
                    <input type="text" name="firstName" placeholder="Enter your First Name" required>
                    <input type="text" name="lastName" placeholder="Enter your Last Name" required>
                </div>
                <input type="email" name="email" placeholder="Enter your Email" required>
                <div class="password-container">
                    <input type="password" name="password" placeholder="Enter your Password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <label class="s_img">Select image</label>
                <input type="file" name="image" required>
                <button type="submit">Let's go!</button>
                <p class="already">Aready signed up? <a href="login.php">Login now</a></p>
            </div>
        </form>

    </div>

</body>
<script src="show-hide.js">

</script>
<script src="signup.js"></script>

</html>