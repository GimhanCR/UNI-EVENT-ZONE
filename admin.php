<?php
$conn = new mysqli('localhost', 'root', '', 'event_manager');

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$fName    = $_POST['name'];
$position = $_POST['position'];
$email    = $_POST['email'];
$uni_reg  = $_POST['id'];
$pass = password_hash($_POST['pass1'], PASSWORD_DEFAULT);

$sql = "INSERT INTO user_details (fullname, position_or_field, email, pass_word, admin_or_user, uni_reg_num)
        VALUES ('$fName', '$position', '$email', '$pass', 'admin', '$uni_reg')";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_home.html?signup=success");
    exit();
} else {
    echo "❌ Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
