<?php
$conn = new mysqli('localhost', 'root', '', 'event_manager');

if ($conn->connect_error) {
    die("<div style='color:red; text-align:center; padding:10px;'>❌ Connection failed: " . $conn->connect_error . "</div>");
}

// Get all events
$sql = "SELECT * FROM event_details ORDER BY event_id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "
    <div style='
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        padding: 10px;
    '>
    ";

    while ($row = $result->fetch_assoc()) {
        $event_id = $row['event_id'];

        // 🔹 Get all registered users for this event
        $reg_sql = "
            SELECT u.fullname, u.email, r.contact_number 
            FROM registration_details r
            JOIN user_details u ON r.user_id = u.id
            WHERE r.event_id = $event_id
        ";
        $reg_result = $conn->query($reg_sql);

        // Build registration list
        $registrations_html = "";
        if ($reg_result->num_rows > 0) {
            $registrations_html .= "<ul style='list-style-type:none; padding-left:10px; margin:8px 0;'>";
            while ($reg = $reg_result->fetch_assoc()) {
                $registrations_html .= "
                    <li style='margin-bottom:5px;'>
                        👤 <strong>{$reg['fullname']}</strong><br>
                        📧 {$reg['email']}<br>
                        ☎️ {$reg['contact_number']}
                    </li>
                ";
            }
            $registrations_html .= "</ul>";
        } else {
            $registrations_html = "<p style='color:#ccc; font-size:13px;'>No users have registered yet.</p>";
        }

        // 🔹 Display each event block
        echo "
        <div style='
            background: rgba(255,255,255,0.08);
            border-left: 5px solid #ffcc00;
            border-radius: 10px;
            color: white;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.4);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        '
        onmouseover=\"this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.5)';\"
        onmouseout=\"this.style.transform='scale(1)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.4)';\">
            <h3 style='color:#ffcc00; margin:0 0 8px 0; font-size:16px;'>
                {$row['event_name']} <span style='color:#ccc;'>(ID: {$row['event_id']})</span>
            </h3>
            <p style='margin:4px 0; font-size:13px;'><strong>Date:</strong> {$row['event_date']}</p>
            <p style='margin:4px 0; font-size:13px;'><strong>Time:</strong> {$row['event_time']}</p>
            <p style='margin:4px 0; font-size:13px;'><strong>Venue:</strong> {$row['venue']}</p>
            <p style='margin:4px 0; font-size:13px;'><strong>Organizer(s):</strong> {$row['organizers']}</p>
            <p style='margin:4px 0; font-size:13px;'><strong>Description:</strong><br>{$row['event_description']}</p>
            <hr style='border:1px solid #444; margin:10px 0;'>
            <h4 style='color:#ffcc00; margin-bottom:5px;'>Registered Users:</h4>
            {$registrations_html}
        </div>
        ";
    }

    echo "</div>";
} else {
    echo "<p style='text-align:center; color:#ffcc00; padding: 20px;'>⚠️ No events found in the database.</p>";
}

$conn->close();
?>
