<?php
$conn = new mysqli('localhost', 'root', '', 'event_manager');

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$name    = $_POST['ename'];
$date = $_POST['edate'];
$time    = $_POST['etime'];
$venue  = $_POST['evenue'];
$org = $_POST['eorganizer'];
$des  = $_POST['edes'];

$sql = "INSERT INTO event_details (event_name, venue, event_time, organizers, event_description, event_date)
        VALUES ('$name', '$venue', '$time', '$org', '$des', '$date')";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_home.html?signup=success");
    exit();
} else {
    echo "❌ Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>