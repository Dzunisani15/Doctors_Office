<?php
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
$query = "SELECT patient_name, contact_number, email, appointment_date, appointment_time, symptoms FROM appointments";
$result = pg_query($conn, $query);

if (!$result) {
    die("Query failed: " . pg_last_error());
}

// Initialize the $patients array
$patients = [];

while ($row = pg_fetch_assoc($result)) {
    $patients[] = [
        // 'id' => (int)$row['id'],
        'name' => $row['patient_name'],
        'contact' => (int)$row['contact_number'],
        'email' => $row['email'],
        'appointment_date' => $row['appointment_date'],
        'appointment_time' => $row['appointment_time'],
        'symptoms' => $row['symptoms']
        // 'medical_record' => $row['medical_record']
    ];
}





// Free the result resource
pg_free_result($result);
pg_close($conn);

// // Example to display the array
// print_r($patients);


// Function to filter patients based on search
function searchPatients($query, $patients)
{
    $result = [];
    foreach ($patients as $patient) {
        if (stripos($patient['name'], $query) !== false || stripos($patient['id'], $query) !== false) {
            $result[] = $patient;
        }
    }
    return $result;
}

// Handle search functionality
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$filteredPatients = $searchQuery ? searchPatients($searchQuery, $patients) : $patients;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Today's Appointments</title>
    <style>
        body {
            /* font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333; */
            
            font-family: Arial, sans-serif;
            /* background: linear-gradient(135deg, #edd8d9, #edccce); */
            background: linear-gradient(to bottom, #ffdddd, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .container {
            /* padding: 20px; */
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }

        .appointments, .search {
            margin-bottom: 20px;
        }

        h2 {
            color: #d32f2f;
        }

        .appointment-list {
            list-style: none;
            padding: 0;
        }

        .appointment-list li {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #d32f2f;
            border-radius: 8px;
            cursor: pointer;
            background-color: #ffe5e5;
            transition: background-color 0.3s ease;
        }

        .appointment-list li:hover {
            background-color: #ffc0c0;
        }

        .search input[type="text"] {
            width: 80%;
            padding: 10px;
            border: 1px solid #d32f2f;
            border-radius: 8px;
        }

        .search button {
            padding: 10px 20px;
            background-color: #d32f2f;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .search button:hover {
            background-color: #cc0000;
        }

        .medical-record {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #d32f2f;
            border-radius: 8px;
            background-color: #ffe5e5;
        }

        .medical-record h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Scheduled Patients -->
        <div class="appointments">
            <!-- <h2>Scheduled Patients</h2> -->
             <h2>Today's Appointments</h2>
            <ul class="appointment-list" id="patientList">
                <?php foreach ($filteredPatients as $patient): ?>
                    <li data-id="<?= $patient['appointment_time'] ?>" data-record="<?= htmlspecialchars($patient['symptoms']) ?>">
                        <?= htmlspecialchars($patient['name']) ?> - <?= htmlspecialchars($patient['appointment_time']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Search -->
        <div class="search">
            <h2>Search Patients</h2>
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by name or ID" value="<?= htmlspecialchars($searchQuery) ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Medical Record Display -->
        <div class="medical-record" id="medicalRecord" style="display: none;">
            <h3>Medical Record</h3>
            <p id="recordContent"></p>
        </div>
    </div>

    <script>
        // JavaScript for displaying medical records
        document.querySelectorAll('.appointment-list li').forEach(item => {
            item.addEventListener('click', () => {
                const recordContent = item.getAttribute('data-record');
                const recordSection = document.getElementById('medicalRecord');
                document.getElementById('recordContent').innerText = recordContent;
                recordSection.style.display = 'block';
            });
        });
    </script>
</body>
</html>
