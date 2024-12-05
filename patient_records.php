<?php
// Database connection details
$host = "localhost";
$port = "5432";
$dbname = "doctors_office";
$user = "postgres";
$password = "12345";

// Create a connection string
$conn_str = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Connect to the database
$conn = pg_connect($conn_str);

// Check the connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Fetch medical records from the database
$query = "SELECT patient_name, diagnosis, treatment, date_of_visit, identity_number FROM medical_records";
$result = pg_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Error fetching records: " . pg_last_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #ffe5e5;
            color: #333;
            padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            border: 2px solid #ff0000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #ff0000;
            font-size: 28px;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ff0000;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #ff0000;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #ffe5e5;
        }

        .no-records {
            text-align: center;
            color: #ff0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Medical Records</h1>
        </div>

        <?php if (pg_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Diagnosis</th>
                        <th>Treatment</th>
                        <th>Date of Visit</th>
                        <th>Identity Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = pg_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['diagnosis']); ?></td>
                            <td><?php echo htmlspecialchars($row['treatment']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_of_visit']); ?></td>
                            <td><?php echo htmlspecialchars($row['identity_number']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-records">No medical records found.</p>
        <?php endif; ?>

        <?php pg_close($conn); // Close the database connection ?>
    </div>
</body>
</html>
