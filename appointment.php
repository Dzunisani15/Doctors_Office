<?php
$timeout = 5000;

// Database connection details
$host = "localhost";
$port = "5432";
$dbname = "doctors_office";
$user = "postgres";
$password = "12345";

$patient_name = $contact_number = $email = $appointment_date = $appointment_time = $symptoms= "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = $_POST['patient_name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $symptoms = $_POST['symptoms'];

    $conn_str = "host=$host port=$port dbname=$dbname user=$user password=$password";
    $conn = pg_connect($conn_str);

    if (!$conn) {
        die("Connection failed: " . pg_last_error());
    }

    $query = "INSERT INTO appointments (patient_name, contact_number, email, appointment_date, appointment_time, symptoms) VALUES ($1, $2, $3, $4, $5, $6)";
    $result = pg_query_params($conn, $query, array($patient_name, $contact_number, $email, $appointment_date, $appointment_time, $symptoms));
    pg_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dzunisani Clinic - Patient Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: linear-gradient(to bottom, #ffdddd, #ffffff);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #d32f2f;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .logo img {
            width: 50px;
            height: 50px;
        }

        .container h2 {
            margin-bottom: 20px;
            color: #d32f2f;
        }

        input, button {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        input:focus {
            outline: none;
            border-color: #d32f2f;
            box-shadow: 0 0 5px rgba(211, 47, 47, 0.5);
        }

        button {
            background-color: #d32f2f;
            color: white;
            border: none;
            cursor: pointer;
            /* font-weight: bold; */
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <div class="logo">
                <!-- <img src="../resources/logo.png" alt="Clinic Logo">
                <span>Dzunisani Clinic</span> -->
            </div>
            <h2>Appointment Booker</h2>
            <input type="text" id="patient_name" name="patient_name" placeholder="Patient Name" value="<?php echo htmlspecialchars($patient_name); ?>" required>
            <input type="text" id="contact_number" name="contact_number" placeholder="Contact Number" value="<?php echo htmlspecialchars($contact_number); ?>" required>
            <input type="email" id="email_address" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($email); ?>" required>
            <input type="date" id="appointment_date" name="appointment_date" value="<?php echo htmlspecialchars($appointment_date); ?>" required>
            <input type="time" id="appointment_time" name="appointment_time" value="<?php echo htmlspecialchars($appointment_time); ?>" required>
            <input type="text" id="symptoms" name="symptoms" placeholder="Symptoms" value="<?php echo htmlspecialchars($symptoms); ?>" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
