<?php
$conn = new mysqli('localhost', 'root', '', 'event_manager');

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM event_details ORDER BY event_date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='event-card'>
            <h3>{$row['event_name']}</h3>
            <p><strong>Date:</strong> {$row['event_date']}</p>
            <p><strong>Time:</strong> {$row['event_time']}</p>
            <p><strong>Venue:</strong> {$row['venue']}</p>
            <p><strong>Organizers:</strong> {$row['organizers']}</p>
            <p>{$row['event_description']}</p>
            <button class='register-btn' onclick='openModal({$row['event_id']})'>Register</button>
        </div>";
    }
} else {
    echo "<p style='color:white;text-align:center;'>No upcoming events found.</p>";
}

$conn->close();
?>
