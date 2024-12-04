<html>

<head>
    <meta charset="UTF-8">

</head>

</html>
<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "connect.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";
    $sql = "SELECT * FROM messages 
                WHERE (out_msg_id = {$outgoing_id} AND in_msg_id = {$incoming_id})
                OR (out_msg_id = {$incoming_id} AND in_msg_id = {$outgoing_id}) ORDER BY msg_id";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            if ($row['out_msg_id'] === $outgoing_id) {
                $output .= '<div class="message sender">' . $row['msg'] . '</div>';
            } else {
                $output .=  '<div class="message receiver">' . $row['msg'] . '</div>';
            }
        }
    } else {
        $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
    }
    echo $output;
} else {
    header("location: ../login.php");
}

?>