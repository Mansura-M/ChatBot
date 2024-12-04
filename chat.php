<?php
session_start();
include("header.php");
if (!isset($_SESSION['unique_id'])) {
    header("location:login.php");
}

?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="chat-container">
        <?php
        include_once "php/connect.php";
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id='{$user_id}'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
        }
        ?>
        <div class="header">
            <div class="back-btn">
                <a href="users.php"> <i class="fas fa-arrow-left" style="color: #333;"></i></a>
            </div>
            <img src="php/images/<?php echo $row['img']; ?>" alt="Profile Picture">
            <div class="user-info">
                <div class="name"><?php echo $row['fname'] . " " . $row['lname'];
                                    ?></div>
                <div class="status-text"><?php echo $row['status'];
                                            ?></div>
            </div>
        </div>

        <!-- Chat Screen -->
        <div class="chat-screen" style="height: 400px;
    /* Set a height to enable scrolling */
    overflow-y: scroll;
    /* Enable vertical scrolling */
    direction: rtl;
    /* Right-to-left direction to move the scrollbar to the left */
    text-align: left;
    /* Re-align the text to the left */
    padding-right: 10px;
    /* Add some padding to avoid overlap */
    box-sizing: border-box;
    /* Include padding in the element's total width/height */;">


        </div>

        <!-- Message Input -->
        <form action="#" class="typing-area">
            <div class="message-input">

                <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                <button><i class="fas fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
    <script src="chat.js"></script>



</body>



</html>