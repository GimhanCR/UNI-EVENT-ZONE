<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'event_manager');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('❌ Please log in first.');
            window.location.href = 'user_login.html';
          </script>";
    exit();
}

$event_id = $_POST['event_id'];
$user_id = $_SESSION['user_id']; // get user id from session
$contact_number = $_POST['contact_number'];

// Insert registration
$sql = "INSERT INTO registration_details (event_id, user_id, contact_number)
        VALUES ('$event_id', '$user_id', '$contact_number')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('✅ Registration successful!');
            window.location.href = 'user_login.html';
          </script>";
} else {
    echo "<script>
            alert('❌ Error: " . $conn->error . "');
            window.location.href = 'user_login.html';
          </script>";
}

$conn->close();
?>
