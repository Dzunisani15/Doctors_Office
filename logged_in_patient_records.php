<?php
// Simulated patient data (replace this with database query results in production)
// $patientData = [
//     "id" => "12345",
//     "name" => "John Doe",
//     "age" => 45,
//     "gender" => "Male",
//     "contact" => "+1-555-123-4567",
//     "address" => "123 Elm Street, Springfield",
//     "medicalHistory" => [
//         "Hypertension",
//         "Type 2 Diabetes",
//         "Seasonal Allergies"
//     ],
//     "currentMedications" => [
//         "Lisinopril - 10mg",
//         "Metformin - 500mg",
//         "Cetirizine - 10mg"
//     ]
// ];


// Database connection details
$host = "localhost";
$port = "5432";
$dbname = "doctors_office";
$user = "postgres";
$password = "12345";

$conn_str = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_str);

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Query to fetch all data from the database
$query = "SELECT name,gender,address,phonenumber,emailaddress,emergencycontactname,emergencycontactphone,emergencycontactrelationship,healthinsurancepolicynumber,healthinsuranceprovider,pastillnesses,pastsurgeries,chronicconditions,familymedicalhistory,allergies FROM personal_information";
$result = pg_query($conn, $query);

if (!$result) {
    die("Query failed: " . pg_last_error());
}

// Initialize the $patients array
$patientData = [];

while ($row = pg_fetch_assoc($result)) {
    $patientData[] = [
        // 'id' => (int)$row['id'],
        'name' => $row['name'],
        'gender' => (int)$row['gender'],
        'address' => $row['address'],
        'phonenumber' => $row['phonenumber'],
        'emailaddress' => $row['emailaddress'],
        'emergencycontactname' => $row['emergencycontactname'],
        'emergencycontactphone' => $row['emergencycontactphone'],
        'emergencycontactrelationship' => $row['emergencycontactrelationship'],
        'healthinsurancepolicynumber' => $row['healthinsurancepolicynumber'],
        'healthinsuranceprovider' => $row['healthinsuranceprovider'],
        'pastillnesses' => $row['pastillnesses'],
        'pastsurgeries' => $row['pastsurgeries'],
        'chronicconditions' => $row['chronicconditions'],
        'familymedicalhistory' => $row['familymedicalhistory'],
        'allergies' => $row['allergies'],
    ];
}





// Free the result resource
pg_free_result($result);
pg_close($conn);

// print_r($patientData);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Medical File</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Page Styling */
        body {
            font-family: Arial, Helvetica, sans-serif;
            /* background: linear-gradient(135deg, #f0f4f8, #d9e2ec); */
            background: linear-gradient(to bottom, #ffdddd, #ffffff);
            color: #333;
            line-height: 1.6;
        }

        header {
            background: #d32f2f;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            font-size: 24px;
            border-bottom: 4px solid #cc0000 ;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        /* Patient Info Section */
        .info-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .info-section div {
            margin-bottom: 8px;
        }

        /* Cards for sections */
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 10px 0;
        }

        .card h3 {
            margin-bottom: 10px;
            color: #d32f2f;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .info-container {
                flex-direction: column;
            }
        }


        /* Button for Interactivity */
        .button {
            display: inline-block;
            padding: 8px 15px;
            margin: 10px 0;
            text-decoration: none;
            background: #d32f2f;
            color: #fff;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        .button:hover {
            background: #cc0000;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        Patient Medical Record
    </header>

   
    <div class="container">
        <!-- Patient Info Section -->
        <?php foreach ($patientData as $patient): ?>

            <div class="card">
                <h3>Emergency Contacts</h3>
                <div><strong>Name:</strong> <?= htmlspecialchars($patient['name']); ?></div>
                <div><strong>Gender:</strong> <?= htmlspecialchars($patient['gender'] === 1 ? 'Male' : 'Female'); ?></div>
                <div><strong>Address:</strong> <?= htmlspecialchars($patient['address']); ?></div>
                <div><strong>Phone Number:</strong> <?= htmlspecialchars($patient['phonenumber']); ?></div>
                <div><strong>Email:</strong> <?= htmlspecialchars($patient['emailaddress']); ?></div>
            </div>
        
            <div class="card">
                <h3>Emergency Contacts</h3>
                <div><strong>Name:</strong> <?= htmlspecialchars($patient['emergencycontactname']); ?></div>
                <div><strong>Contact:</strong> <?= htmlspecialchars($patient['emergencycontactphone']); ?></div>
                <div><strong>Address:</strong> <?= htmlspecialchars($patient['emergencycontactrelationship']); ?></div>
                <div><strong>Insurance Number:</strong> <?= htmlspecialchars($patient['healthinsurancepolicynumber']); ?></div>
                <div><strong>Insurance Number:</strong> <?= htmlspecialchars($patient['healthinsuranceprovider']); ?></div>
            </div>

            <div class="card">
                <h3>Illness History</h3>
                <div><strong>Illnesses:</strong> <?= htmlspecialchars($patient['pastillnesses']); ?></div>
                <div><strong>Surgery:</strong> <<?= htmlspecialchars($patient['pastsurgeries']); ?></div>
                <div><strong>Chronic Conditions:</strong> <?= htmlspecialchars($patient['chronicconditions']); ?></div>
                <div><strong>Family Medical History:</strong> <<?= htmlspecialchars($patient['familymedicalhistory']); ?></div>
                <div><strong>Allergies:</strong> <?= htmlspecialchars($patient['allergies']); ?></div>
            </div>
            
        <?php endforeach; ?>

        <!-- Placeholder for Future Features -->
        <a href="#" class="button">Update Medical Records</a>
    </div>
</body>
</html>
