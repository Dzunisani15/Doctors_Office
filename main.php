<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit;
}

// Get the user type from the session
$userType = $_SESSION['user_type'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>

/*---------------------------------------------------------------------------------------------------------------------*/

        /* General Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* font-family: Arial, sans-serif; */
            margin: 0;
            /* background: whitesmoke; */
            background: linear-gradient(135deg, #edd8d9, #edccce);
            color: red;
        }

        /* Header Section */
        .header {
            background-color: red;
            /* background-color: #bf2424; */
            padding: 1px;
            /* text-align: center; */
            color: white;
            font-size: 15px;
            font-weight: bold;
            position: sticky;
            top: 0;
        }

        .header img {
            width: 50px;
            height: 50px;
            vertical-align: middle;
            margin-right: 10px;
        }

/*---------------------------------------------------------------------------------------------------------------------*/


/*---------------------------------------------------------------------------------------------------------------------*/

    
        /* Main Content */
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-height: calc(100vh - 80px);
            padding: 20px;
        }

        .main-content h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .main-content p {
            font-size: 18px;
            margin-bottom: 40px;
        }

        /* Option Cards */
        .options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1000px;
        }

        .option-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .option-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }

        .option-card img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }

        .option-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .option-card p {
            font-size: 14px;
            color: #6c757d;
        }

        /* Footer Section */
        .footer {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

/*---------------------------------------------------------------------------------------------------------------------*/

        /* Reset some default browser styles */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden; /* Prevent scrollbars */
        }

        /* General Video Background Styling */
        .video-background {
            position: fixed; /* Stays fixed on the screen */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1; /* Places it behind other elements */
        }

        .video-background video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%; /* Ensures it covers the entire width */
            min-height: 100%; /* Ensures it covers the entire height */
            width: auto;
            height: auto;
            transform: translate(-50%, -50%) scale(1); /* Centers the video */
            object-fit: cover; /* Ensures the video scales proportionally */
            transition: transform 5s ease-in-out; /* Smooth zoom-out effect */
            z-index: -1;
        }

        /* Zoom-out effect for different video layers */
        .video-layer1 video {
            animation: zoom-out 20s infinite alternate; /* Infinite zoom effect */
        }

        /* Keyframes for zoom-out effect */
        @keyframes zoom-out {
            0% {
                transform: translate(-50%, -50%) scale(1.2); /* Start zoomed-in */
            }
            100% {
                transform: translate(-50%, -50%) scale(1); /* Zoom out to normal size */
            }
        }

        /* Content Styling */
        .content {
            position: relative;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
            z-index: 1; /* Places content above the videos */
        }

        .content h1 {
            font-size: 3rem;
            margin-top: 20%;
        }

        .content p {
            font-size: 1.5rem;
        }

        /* Footer Section */
        .footer {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

    </style>
</head>
<body>
    
    <!-- Header Section -->
    <div class="header">

        <img src="resources\logo.png" alt="Clinic Logo">
        Dzunisani Clinic
    </div>

        <!-- it runs a video in the background -->
    <!-- <div class="video-background">
        <video autoplay muted loop playsinline>
            <source src="resources/doctor2.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div> -->

    <!-- Main Content Section -->
    <div class="main-content">
        <h1>Your Health, Our Priority</h1>
        <p>Select an option below to get started:</p>
        
        <!-- Options Section -->
        <div class="options">
            <?php if ($userType === 'admin') : ?>
                <div class="option-card" onclick="location.href='patient_profile.php'">
                    <img src="resources/appointment.png" alt="patient profile Icon">
                    <h3>Scheduled Appointments</h3>
                    <p>Shows scheduled appointments for today.</p>
                </div>
            <?php endif; ?>

            <?php if ($userType === 'admin') : ?>
                <div class="option-card" onclick="location.href='prescription_generator.php'">
                    <img src="resources/prescription2.jpg" alt="Services Icon">
                    <h3>Prescription Generator</h3>
                    <p>Generates a prescription and sends it to the patient.</p>
                </div>
            <?php endif; ?>

            <?php if ($userType === 'admin') : ?>
                <div class="option-card" onclick="location.href='patient_file.php'">
                    <img src="resources/medical_record.jpg" alt="Services Icon">
                    <h3>Medical Records</h3>
                    <p>Displays and edits a patients medical file.</p>
                </div>
            <?php endif; ?>

            <!-- For The Patient -->
            <?php if ($userType === 'user') : ?>
                <div class="option-card" onclick="location.href='appointment.php'">
                    <img src="resources/appointment.png" alt="patient profile Icon">
                    <h3>Appointment Scheduler</h3>
                    <p>schedules appointment for patient.</p>
                </div>
            <?php endif; ?>

            <?php if ($userType === 'user') : ?>
                <div class="option-card" onclick="location.href='patient_records.php'">
                    <img src="resources/medical_record.jpg" alt="Services Icon">
                    <h3>My Medical Records</h3>
                    <p>Displays the logged in patient.</p>
                </div>
            <?php endif; ?>

            </div>

    </div>
    <!-- Footer Section -->
    <div class="footer">
        © 2024 Dzunisani Clinic. All rights reserved.
    </div>
</body>
</html>
