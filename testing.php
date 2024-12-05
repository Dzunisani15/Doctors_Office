<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Popup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .error-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #ffdddd;
            border: 1px solid #f5c6cb;
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
            color: #f5c6cb;
        }
    </style>
</head>
<body>
    <div id="errorPopup" class="error-popup">
        <button class="close-btn" onclick="dismissErrorPopup()">×</button>
        <strong>Error!</strong> Invalid username or password.
    </div>

    <script>
        // Show the error popup with animation
        function showErrorPopup(message) {
            const popup = document.getElementById("errorPopup");
            popup.querySelector("strong").textContent = "Error!";
            popup.innerHTML = `<button class="close-btn" onclick="dismissErrorPopup()">×</button>` + message;
            popup.classList.add("visible");
        }

        // Dismiss the error popup
        function dismissErrorPopup() {
            const popup = document.getElementById("errorPopup");
            popup.classList.remove("visible");
        }

        // Example: Show the error popup on page load for demonstration
        setTimeout(() => {
            showErrorPopup("Invalid username or password.");
        }, 1000);
    </script>
</body>
</html>
