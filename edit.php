<?php
// edit.php
$conn = new mysqli('localhost', 'root', '', 'event_manager');

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// collect POST safely
$id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;
$field = isset($_POST['field']) ? trim($_POST['field']) : '';
$value = isset($_POST['new_value']) ? trim($_POST['new_value']) : '';

if ($id <= 0) {
    die("⚠️ Invalid event ID.");
}

// whitelist allowed fields
$allowed_fields = ['event_name', 'event_date', 'event_time', 'venue', 'organizers', 'event_description'];

if (!in_array($field, $allowed_fields)) {
    die("❌ Invalid field selected.");
}

// optional: basic validation for date/time types
if ($field === 'event_date') {
    // try to validate YYYY-MM-DD
    $d = date_create_from_format('Y-m-d', $value);
    if (!$d || $d->format('Y-m-d') !== $value) {
        die("⚠️ Invalid date format. Use YYYY-MM-DD.");
    }
}
if ($field === 'event_time') {
    // try to validate HH:MM (or HH:MM:SS)
    if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $value)) {
        die("⚠️ Invalid time format. Use HH:MM or HH:MM:SS.");
    }
}

// Build query dynamically but safely: column name inserted after whitelist check.
$sql = "UPDATE event_details SET {$field} = ? WHERE event_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("❌ Prepare failed: " . $conn->error);
}

// Determine type for binding: date/time/text -> string, event_id -> integer
$stmt->bind_param("si", $value, $id);

if ($stmt->execute()) {
    echo "<script>alert('✅ Event updated successfully!'); window.location.href='admin_home.html';</script>";
} else {
    echo "❌ Error updating record: " . htmlspecialchars($stmt->error);
}

$stmt->close();
$conn->close();
exit;
?>
