<?php
session_start();
// Redirect logged-in users to their respective dashboards
if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] === 'admin') {
        header('Location: admin_home.html');
        exit();
    } elseif ($_SESSION['user_role'] === 'user') {
        header('Location: user_home.html');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNI-EVENT-ZONE</title>
    <style>
        header {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 55px;
            font-weight: bold;
        }
        p {
            color: rgb(25, 11, 219);
            text-align: center;
            padding: 15px;
            font-size: 30px;
            font-family: 'Impact', sans-serif;
        }
        body {
            background: url('images/itum1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            display: flex;
            flex-direction: column;
        }
        .button-container {
            text-align: center;
            margin-top: 1px;
            color: rgb(233, 24, 17);
            font-weight: bold;
        }
        .signup-btn, .login-btn {
            width: 200px;
            height: 90px;
            background-size: cover;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        .signup-btn {
            background: url('images/signup.png');
        }
        .login-btn {
            background: url('images/Login.png');
        }
        .signup-btn:hover, .login-btn:hover {
            opacity: 0.8;
        }
        #roleSelectBox {
            display: none;
            margin-top: 15px;
            text-align: center;
            animation: fadeIn 0.4s ease;
        }
        select {
            width: 200px;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid #333;
            font-size: 16px;
            background: #fff;
            color: #000;
            cursor: pointer;
        }
        .continue-btn {
            display: block;
            margin: 15px auto;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .continue-btn:hover {
            background: #0056b3;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }
        .modal-content {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .modal input[type="email"], 
        .modal input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .modal button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 95%;
            font-weight: bold;
        }
        .modal button:hover {
            background-color: #1e7e34;
        }
        .close-btn {
            float: right;
            font-size: 22px;
            font-weight: bold;
            color: #000;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>UNI-EVENT-ZONE</header>
    <p>One click to campus vibes</p>

    <div class="button-container">
        <h3>Haven't registered yet?</h3>
        <button class="signup-btn" onclick="toggleSelectBox()"></button>
        
        <div id="roleSelectBox">
            <select id="roleSelect">
                <option value="">-- Select Role --</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <button class="continue-btn" onclick="continueSignup()">Continue</button>
        </div>

        <h3>Already registered?</h3>
        <button class="login-btn" onclick="openLoginModal()"></button>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeLoginModal()">&times;</span>
            <h3>Login</h3>
            <form action="login.php" method="POST">
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <script>
        function toggleSelectBox() {
            const box = document.getElementById('roleSelectBox');
            box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
        }

        function continueSignup() {
            const role = document.getElementById('roleSelect').value;
            if (role === '') {
                alert('Please select your role!');
            } else if (role === 'admin') {
                window.location.href = 'admin_signup.html';
            } else if (role === 'user') {
                window.location.href = 'user_signup.html';
            }
        }

        function openLoginModal() {
            document.getElementById('loginModal').style.display = 'flex';
        }

        function closeLoginModal() {
            document.getElementById('loginModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('loginModal');
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
