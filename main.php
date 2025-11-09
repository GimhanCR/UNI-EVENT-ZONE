<?php

// Step 1: Database connection details
$servername = "localhost";
$username   = "root"; // XAMPP default
$password   = "";
$dbname     = "event_manager";

// Step 2: Create connection (no DB yet)
$conn = new mysqli($servername, $username, $password);

// Step 3: Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Step 4: Create the database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "✅ Database '$dbname' created successfully.<br>";
} else {
    echo "❌ Error creating database: " . $conn->error . "<br>";
}

// Step 5: Select the new database
$conn->select_db($dbname);

// Step 6: Create user_details table
$sql = "CREATE TABLE IF NOT EXISTS user_details (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(50) NOT NULL,
    admin_or_user VARCHAR(10) NOT NULL,
    position_or_field VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    uni_reg_num VARCHAR(8) NOT NULL,
    pass_word VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "✅ Table 'user_details' created successfully.<br>";
} else {
    echo "❌ Error creating table user_details: " . $conn->error . "<br>";
}


// Step 7: Create event_details table (FIXED)
$sql = "CREATE TABLE event_details (
    event_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) NOT NULL,
    venue VARCHAR(100) NOT NULL,
    event_time TIME NOT NULL,
    event_date DATE NOT NULL,
    organizers VARCHAR(100) NOT NULL,
    event_description VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "✅ Table 'event_details' created successfully.<br>";
} else {
    echo "❌ Error creating table event_details: " . $conn->error . "<br>";
}

// Step 8: Create registration_details table
$sql = "CREATE TABLE registration_details (
    registration_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INT(6) UNSIGNED NOT NULL,
    user_id INT(6) UNSIGNED NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    contact_number INT(10) NOT NULL,
    FOREIGN KEY (event_id) REFERENCES event_details(event_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES user_details(id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) {
    echo "✅ Table 'registration_details' created successfully.<br>";
} else {
    echo "❌ Error creating table registration_details: " . $conn->error . "<br>";
}

// Step 9: Close connection
$conn->close();
?>
