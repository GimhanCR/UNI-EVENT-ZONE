<?php
session_start();
require_once "db_connect.php"; // your database connection file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Prepare SQL safely
    $stmt = $conn->prepare("SELECT id, fullname, pass_word, admin_or_user FROM user_details WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // --- Check if email exists ---
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $fullname, $hashed_pass, $role);
        $stmt->fetch();

        // --- Verify password ---
        if (password_verify($password, $hashed_pass)) {
            // ✅ Login success — store session data
            $_SESSION['user_id'] = $id;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['role'] = $role;

            // --- Redirect based on role ---
            if ($role === 'admin') {
                echo "<script>
                        alert('✅ Welcome Admin $fullname!');
                        window.location.href = 'admin_home.html';
                      </script>";
            } elseif ($role === 'user') {
                echo "<script>
                        alert('✅ Welcome $fullname!');
                        window.location.href = 'user_login.html';
                      </script>";
            } else {
                echo "<script>
                        alert('⚠️ Unknown role in database.');
                        window.location.href = 'main.html';
                      </script>";
            }
        } else {
            // ❌ Wrong password
            echo "<script>
                    alert('❌ Incorrect password. Please try again.');
                    window.location.href = 'main.html';
                  </script>";
        }
    } else {
        // ❌ No account found for that email
        echo "<script>
                alert('⚠️ No user found with this email. Please sign up first.');
                window.location.href = 'main.html';
              </script>";
    }

    $stmt->close();
} else {
    // ❌ Invalid request
    echo "<script>
            alert('⚠️ Invalid request method.');
            window.location.href = 'main.html';
          </script>";
}
$conn->close();
?>
