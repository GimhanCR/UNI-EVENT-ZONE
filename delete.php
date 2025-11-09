<?php
$conn = new mysqli('localhost', 'root', '', 'event_manager');

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$e_id = $_POST['d_event_id'] ?? '';

if (empty($e_id) || !is_numeric($e_id)) {
    die("⚠️ Invalid or missing event ID.");
}

// ✅ Use prepared statement to prevent SQL injection
$sql = "DELETE FROM event_details WHERE event_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $e_id);

if ($stmt->execute()) {
    echo "<script>alert('✅ Event deleted successfully!'); window.location.href='admin_home.html';</script>";
} else {
    echo "❌ Error deleting event: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
