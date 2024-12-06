<?php


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Splash screen styling */
        #splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background-color: white;  */
            background: linear-gradient(135deg, #edd8d9, #edccce);
            /* color: white; */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            z-index: 1000;
            opacity: 1; /* Fully visible */
            /*transition: opacity 2s ease-out;  Smooth fade-out effect */
        }

        #splash-screen img {
            width: 10%;
            height: 20%;
        }

        /* When hidden, the splash screen will fade out */
        #splash-screen.hidden {
            opacity: 0;
            pointer-events: none; /* Ensures no interaction after it's hidden */
        }

        /* Main content styling */
        #main-content {
            display: none; /* Hidden until splash screen disappears */
        }

        #main-content.show {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Splash screen -->
    <div id="splash-screen">
        <img src="resources/logo.png" alt="logo">
    </div>

    <script>
        // Wait for the page to load completely
        window.onload = function () {
            const splashScreen = document.getElementById('splash-screen');

            setTimeout(() => {
                splashScreen.style.display = 'none'; // Remove from view
                window.location.href = "login.php";
            }, 2000); // Matches the transition duration    
        };

    </script>
</body>
</html>