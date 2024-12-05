<?php
// Mock data for demonstration purposes
$patients = [
    ['id' => 1, 'name' => 'John Doe', 'appointment_time' => '10:00 AM', 'medical_record' => 'Diagnosed with flu, prescribed medication X.'],
    ['id' => 2, 'name' => 'Jane Smith', 'appointment_time' => '11:30 AM', 'medical_record' => 'Annual checkup, no issues found.'],
    ['id' => 3, 'name' => 'Sam Wilson', 'appointment_time' => '2:00 PM', 'medical_record' => 'Sprained ankle, undergoing physiotherapy.'],
];

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
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        header {
            background-color: #ff0000;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }

        .container {
            padding: 20px;
        }

        .appointments, .search {
            margin-bottom: 20px;
        }

        h2 {
            color: #ff0000;
        }

        .appointment-list {
            list-style: none;
            padding: 0;
        }

        .appointment-list li {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ff0000;
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
            border: 1px solid #ff0000;
            border-radius: 8px;
        }

        .search button {
            padding: 10px 20px;
            background-color: #ff0000;
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
            border: 1px solid #ff0000;
            border-radius: 8px;
            background-color: #ffe5e5;
        }

        .medical-record h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Today's Appointments</h1>
    </header>

    <div class="container">
        <!-- Scheduled Patients -->
        <div class="appointments">
            <h2>Scheduled Patients</h2>
            <ul class="appointment-list" id="patientList">
                <?php foreach ($filteredPatients as $patient): ?>
                    <li data-id="<?= $patient['id'] ?>" data-record="<?= htmlspecialchars($patient['medical_record']) ?>">
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
