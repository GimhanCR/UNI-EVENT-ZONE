<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_manager";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Create DB if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Create user_details table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS user_details (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(50) NOT NULL,
    admin_or_user VARCHAR(10) NOT NULL DEFAULT 'user',
    position_or_field VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    uni_reg_num VARCHAR(8) NOT NULL,
    pass_word VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fName = $conn->real_escape_string($_POST['name']);
    $position = $conn->real_escape_string($_POST['field']);
    $email = $conn->real_escape_string($_POST['email']);
    $uni_reg = $conn->real_escape_string($_POST['id']);
    $pass = password_hash($_POST['pass1'], PASSWORD_DEFAULT); // ✅ secure password

    $stmt = $conn->prepare("INSERT INTO user_details (fullname, position_or_field, email, uni_reg_num, pass_word, admin_or_user)
                            VALUES (?, ?, ?, ?, ?, 'user')");
    $stmt->bind_param("sssss", $fName, $position, $email, $uni_reg, $pass);

    if ($stmt->execute()) {
        // redirect to user home page
        header("Location: user_login.html?signup=success");
        exit();
    } else {
        echo "❌ Registration failed: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
