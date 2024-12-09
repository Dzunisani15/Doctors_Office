<?php
// Mock data for demonstration purposes
$patients = [
    ['id' => 1, 'name' => 'John Doe', 'age' => 34, 'email' => 'john.doe@example.com', 'phone' => '123-456-7890', 'address' => '123 Elm Street', 'medical_history' => 'Diabetes, Hypertension', 'current_medications' => 'Metformin, Lisinopril', 'allergies' => 'Penicillin', 'last_visit' => '2024-11-15'],
    ['id' => 2, 'name' => 'Jane Smith', 'age' => 29, 'email' => 'jane.smith@example.com', 'phone' => '987-654-3210', 'address' => '456 Maple Avenue', 'medical_history' => 'Asthma', 'current_medications' => 'Albuterol', 'allergies' => 'None', 'last_visit' => '2024-11-12'],
    ['id' => 3, 'name' => 'Sam Wilson', 'age' => 40, 'email' => 'sam.wilson@example.com', 'phone' => '555-789-1234', 'address' => '789 Oak Lane', 'medical_history' => 'Chronic Back Pain', 'current_medications' => 'Ibuprofen', 'allergies' => 'Latex', 'last_visit' => '2024-11-10'],
];

// Handle search functionality
$searchQuery = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$selectedPatientId = isset($_GET['patient_id']) ? intval($_GET['patient_id']) : null;

// Filter patients based on search query
$filteredPatients = [];
if ($searchQuery) {
    foreach ($patients as $patient) {
        if (stripos($patient['name'], $searchQuery) !== false || stripos((string) $patient['id'], $searchQuery) !== false) {
            $filteredPatients[] = $patient;
        }
    }
} else {
    $filteredPatients = $patients;
}

// Find selected patient
$selectedPatient = null;
if ($selectedPatientId) {
    foreach ($patients as $patient) {
        if ($patient['id'] === $selectedPatientId) {
            $selectedPatient = $patient;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile</title>
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

        /* header {
            background-color: #ff0000;
            color: white;
            padding: 15px;
            text-align: center;
        } */

        .container {
            /* margin: 20px auto;
            max-width: 800px;
            padding: 20px; */

            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }

        .search {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .search input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #d32f2f ;
            border-radius: 8px;
        }

        .search button {
            padding: 10px 20px;
            background-color: #d32f2f;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .search button:hover {
            background-color: #cc0000;
        }

        .patient-list {
            list-style: none;
            padding: 0;
        }

        .patient-list li {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #d32f2f;
            border-radius: 8px;
            background-color: #ffe5e5;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .patient-list li:hover {
            background-color: #ffc0c0;
        }

        .profile {
            border: 1px solid #d32f2f;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffe5e5;
        }

        .profile h2 {
            margin-top: 0;
            color: #d32f2f;
        }

        .profile p {
            margin: 5px 0;
        }

        h2 {
            margin-bottom: 20px;
            color: #d32f2f;
        }
    </style>
</head>
<body>
    <!-- <header>
        <h2>Patient Medical Profile</h2>
    </header> -->

    <div class="container">
        <h2>Patient Medical Profile</h2>
        <!-- Search Bar -->
        <form class="search" method="GET" action="">
            <input type="text" name="search" placeholder="Search by name or ID" value="<?= htmlspecialchars($searchQuery) ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Patient List -->
        <?php if (!$selectedPatient): ?>
            <ul class="patient-list">
                <?php foreach ($filteredPatients as $patient): ?>
                    <li onclick="location.href='?patient_id=<?= $patient['id'] ?>&search=<?= urlencode($searchQuery) ?>'">
                        <?= htmlspecialchars($patient['name']) ?> (ID: <?= $patient['id'] ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Patient Profile -->
        <?php if ($selectedPatient): ?>
            <div class="profile">
                <!-- <h2>Medical Profile</h2> -->
                <p><strong>Name:</strong> <?= htmlspecialchars($selectedPatient['name']) ?></p>
                <p><strong>Age:</strong> <?= htmlspecialchars($selectedPatient['age']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($selectedPatient['email']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($selectedPatient['phone']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($selectedPatient['address']) ?></p>
                <p><strong>Medical History:</strong> <?= htmlspecialchars($selectedPatient['medical_history']) ?></p>
                <p><strong>Current Medications:</strong> <?= htmlspecialchars($selectedPatient['current_medications']) ?></p>
                <p><strong>Allergies:</strong> <?= htmlspecialchars($selectedPatient['allergies']) ?></p>
                <p><strong>Last Visit:</strong> <?= htmlspecialchars($selectedPatient['last_visit']) ?></p>
                <button onclick="location.href='?search=<?= urlencode($searchQuery) ?>'" style="background-color: #ff0000; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">Back to Search</button>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
