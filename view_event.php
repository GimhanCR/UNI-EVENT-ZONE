<?php
$conn = new mysqli('localhost', 'root', '', 'event_manager');

if ($conn->connect_error) {
    die("<p style='color:red;'>❌ Connection failed: " . $conn->connect_error . "</p>");
}

$sql = "SELECT * FROM event_details ORDER BY event_id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' cellspacing='0' cellpadding='8' style='width:100%; border-collapse:collapse; text-align:left;'>";
    echo "<tr style='background-color:#f2f2f2;'>
            <th>ID</th>
            <th>Name</th>
            <th>Venue</th>
            <th>Time</th>
            <th>Date</th>
            <th>Organizers</th>
            <th>Description</th>
            <th>Created At</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['event_id']}</td>
                <td>{$row['event_name']}</td>
                <td>{$row['venue']}</td>
                <td>{$row['event_time']}</td>
                <td>{$row['event_date']}</td>
                <td>{$row['organizers']}</td>
                <td>{$row['event_description']}</td>
                <td>{$row['created_at']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No events found in the database.</p>";
}

$conn->close();
?>
