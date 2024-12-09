<?php

// Database connection details
$host = "localhost";
$port = "5432";
$dbname = "doctors_office";
$user = "postgres";
$password = "12345";

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input from form
    $userType = $_POST['user_type'] ?? '';
    $inputUsername = $_POST['username'] ?? '';
    $inputPassword = $_POST['password'] ?? '';

    try {
        // Connect to PostgreSQL
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    } catch (PDOException $e) {
        // Handle database connection errors
        die("Database connection failed: " . $e->getMessage());
    }

    // Set the user type in session
    $_SESSION['user_type'] = $userType;

    if ($userType === 'admin') {
        // Prepare query for Doctor login credentials
        $stmt = $pdo->prepare("SELECT * FROM login_credentials_doctor WHERE username = :username AND password = :password");
    } else {
        // Prepare query for Patient login credentials
        $stmt = $pdo->prepare("SELECT * FROM login_credentials_patient WHERE username = :username AND password = :password");
    }

    try {
        // Bind parameters and execute the query
        $stmt->bindParam(':username', $inputUsername);
        $stmt->bindParam(':password', $inputPassword);
        $stmt->execute();

        // Check if user exists
        if ($stmt->rowCount() > 0) {
            // Fetch the user's data if needed
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set session variables for the logged-in user
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to the next page (e.g., main.php)
            header("Location: main.php");
            exit;
        } else {
            $errorMessage = "Invalid username or password.";
        }
    } catch (PDOException $e) {
        // Handle SQL errors
        die("Query failed: " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff0000, #ffe5e5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .login-container {
            background-color: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #ff0000;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ff0000;
            border-radius: 25px;
            outline: none;
            font-size: 16px;
            transition: 0.3s;
        }

        .input-field:focus {
            border-color: #ff7373;
        }

        .password-container {
            position: relative;
        }

        .password-container button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            font-size: 16px;
            color: #ff0000;
        }

        .password-container button:hover {
            color: #ff7373;
        }

        .login-btn {
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-btn:hover {
            background-color: #ff7373;
        }

        .error-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #ffdddd;
            border: 1px solid #ff0000;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            color: #721c24;
            font-size: 16px;
            max-width: 300px;
            z-index: 1000;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .error-popup.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .error-popup .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 16px;
            color: #721c24;
            cursor: pointer;
        }

        .error-popup .close-btn:hover {
            color: #ff0000;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <!-- User Type -->
            <select name="user_type" class="input-field">
                <option value="admin">Doctor</option>
                <option value="user">Patient</option>
            </select>
            
            <!-- Username -->
            <input type="text" name="username" class="input-field" placeholder="Identification Number" required>
            
            <!-- Password -->
            <div class="password-container">
                <input type="password" name="password" class="input-field" id="password" placeholder="Password" required>
                <button type="button" onclick="togglePasswordVisibility()">👁️</button>
            </div>

            <!-- Login Button -->
            <!-- <button type="submit" class="login-btn">Login</button> -->
            <button onclick="location.href='main.php'" class="login-btn">Login</button>
        </form>
    </div>

    <!-- Error Popup -->
    <?php if (!empty($errorMessage)): ?>
        <div id="errorPopup" class="error-popup visible">
            <button class="close-btn" onclick="dismissErrorPopup()">×</button>
            <strong>Error!</strong> <?= htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
        }

        // function dismissErrorPopup() {
        //     const popup = document.getElementById('errorPopup');
        //     popup.classList.remove('visible');
        // }

         // Function to show the modal
        function showModal() {
            const modal = document.getElementById('errorModal');
            modal.style.display = 'block';
        }

        // Function to close the modal
        function closeModal() {
            const modal = document.getElementById('errorModal');
            modal.style.display = 'none';
        }

        // Show modal if there's an error
        <?php if (!empty($errorMessage)): ?>
        showModal();
        <?php endif; ?>
    </script>
</body>
</html>
