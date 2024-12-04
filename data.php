<?php
while ($row = mysqli_fetch_assoc($sql)) {
    $sql2 = "SELECT * FROM messages WHERE (in_msg_id={$row['unique_id']} OR out_msg_id={$row['unique_id']}) AND (out_msg_id={$outgoing_id} OR in_msg_id={$outgoing_id})
    ORDER BY msg_id DESC LIMIT 1";

    $query2 = mysqli_query($conn, $sql2);

    // // Check if query executed successfully
    // if (!$query2) {
    //     // Handle the error (e.g., log it, show a message, etc.)
    //     continue; // Skip this iteration if there's an error
    // }

    $row2 = mysqli_fetch_array($query2);
    if (mysqli_num_rows($query2) > 0) {
        $result = $row2['msg'];
    } else {
        $result = "No messages available";
    }

    $msg = (strlen($result) > 26) ? substr($result, 0, 26) . '...' : $result;
    if (isset($row2['out_msg_id'])) {
        $you = ($outgoing_id == $row2['out_msg_id']) ? "You:" : "";
    } else {
        $you = ""; // Default value if out_msg_id is not found
        error_log("out_msg_id not found in row2");
    }
    $output .= '<style>

        .status.online {
            background-color: green; /* Color for online status */
        }
        .status.offline {
            background-color: lightgrey; /* Color for offline status */
        }
    </style>';
    if ($row["status"] != "Active now") {
        $offline = "offline";
    } else {
        $offline = "";
    }
    //echo 'User Status: ' . $row["status"];

    $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
    <div class="contact">
            <img src="php/images/' . $row['img'] . '" alt="">
            <div class="contact-info">
                <div class="name">' . htmlspecialchars($row['fname'] . " " . $row['lname']) . '</div>
                <div class="message">' . $you . ' ' . $msg . '</div>
            </div>
           
        </div>
       </a>';
}
