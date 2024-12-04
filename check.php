<?php
session_start();

if (isset($_SESSION['unique_id'])) {
    include_once("connect.php");

    // Check if POST variables are set
    if (!empty($_POST['out_id'])  && !empty($_POST['in_id']) && !empty($_POST['message'])) {


        $out_id = mysqli_real_escape_string($conn, $_POST["out_id"]);
        $in_id = mysqli_real_escape_string($conn, $_POST["in_id"]);
        $message = mysqli_real_escape_string($conn, $_POST["message"]);

        mysqli_set_charset($conn, "utf8mb4"); // Ensure UTF-8 encoding

        $output = "";
        // Use a prepared statement to avoid SQL injection
        $sql = "SELECT * FROM messages WHERE (out_msg_id='$out_id' AND in_msg_id='$in_id') 
            OR (out_msg_id='$in_id' AND in_msg_id='$out_id') ORDER BY msg_id";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {


                // Apply the function to the message

                // Get the message and escape any special characters
                $message = htmlspecialchars($row['msg'], ENT_QUOTES, 'UTF-8');

                // Check for sender or receiver and show message content
                if ($row['out_msg_id'] === $out_id) {
                    $output .= '<div class="message sender">' . $message . '</div>';
                } else {
                    $output .= '<div class="message receiver">' . $message . '</div>';
                }
                // error_log("Message from DB: " . $message); // Debugging log
                // echo '<div class="message sender">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</div>';
            }
            echo $output;
        }
    } else {
        echo "not available";
    }
} else {
    header("Location: ../login.php");
}




setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");

    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data)
                chatbox.innerHTML = data;
                // console.log(data);

            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}, 500);



<?php
while ($row = mysqli_fetch_assoc($sql)) {
    $sql2 = "SELECT * FROM messages WHERE (in_msg_id={$row['unique_id']} OR out_msg_id={$row['unique_id']} )AND (out_msg_id={$out_going_id} OR in_msg_id={$out_going_id})
    ORDER BY msg_id DESC LIMIT 1";
    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($query2);
    if (mysqli_num_rows($query2) > 0) {
        $result = $row2['msg'];
    } else {
        $result = "no message available";
    }

    (strlen($result) > 26) ? $msg = substr($result, 0, 26) . '...' : $msg = $result;
    ($out_going_id == $row2['out_msg_id']) ? $you = "you:" : $you = "";
    $output .= '<a href=chat.php?user_id=' . $row['unique_id'] . '>
    <div class="contact" >
            <img src="php/images/' . $row['img'] . '" alt="">
            <div class="contact-info">
                <div class="name">' . $row['fname'] . " " . $row['lname'] . '</div> </a>
                <div class="message">' . $you . $msg . '</div>
            </div>
            <div class="status"></div>
        </div>
       </a>
       
';
    $result = @mysqli_query($conn, $sql2); // Suppresses any warning that mysqli_query might throw

}


<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once("connect.php");
    $out_id = mysqli_escape_string($conn, $_POST["out_id"]);
    $in_id = mysqli_escape_string($conn, $_POST["in_id"]);
    $message = mysqli_escape_string($conn, $_POST["message"]);
    if (!empty($message)) {
        $sql = mysqli_query($conn, "INSERT INTO messages(in_msg_id,out_msg_id,msg) VALUES({$in_id},{$out_id},'{$message}')") or die();
    }
} else {
    header("../login.php");
}
// <!-- <script>
//         document.addEventListener("DOMContentLoaded", function() {
//             const form = document.querySelector('.typing-area');
//             form.addEventListener('submit', function(event) {
//                 const messageInput = document.getElementById('chatin');
//                 console.log("Message before submit:", messageInput.value); // Log the value

//                 // Optional: Check if the message is empty
//                 if (messageInput.value.trim() === "") {
//                     alert("Message cannot be empty.");
//                     event.preventDefault(); // Prevent form submission
//                 }
//             });
//         });
//     </script> -->











<?php

session_start();


if (isset($_SESSION['unique_id'])) {
    include_once("connect.php");



    $out_id = mysqli_real_escape_string($conn,$_POST["out_id"]);
    $in_id=mysqli_real_escape_string($conn,$_POST["in_id"]);

    $output = "";

    $sql = "SELECT * FROM messages WHERE (out_msg_id={$out_id} AND in_msg_id={$in_id}) 
                OR (out_msg_id={$in_id} AND in_msg_id={$out_id}) ORDER BY msg_id";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $message = htmlspecialchars($row['msg'], ENT_QUOTES, 'UTF-8');


            if ($row['out_msg_id'] === $out_id) {
                $output .= '<div class="message sender">' . $message . '</div>';
            } else {
                $output .= '<div class="message receiver">' . $message . '</div>';
            }

        }
    }
    echo $output;
} else {
    header("Location: ../login.php");


}
