<?php
// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Autoload classes using Composer
require 'vendor/autoload.php'; // Use the path where Composer installed PHPMailer

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $patientName = htmlspecialchars($_POST['patient_name']);
    $patientEmail = htmlspecialchars($_POST['patient_email']);
    $prescriptionDetails = htmlspecialchars($_POST['prescription_details']);

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'the senders email here'; 
        // $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->Password = 'the emails app password here';    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and Recipient
        $mail->setFrom('the senders email here', 'the name of the sender here');
        $mail->addAddress($patientEmail, $patientName);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Prescription';
        $mail->Body = "
            <h2>Prescription</h2>
            <p><strong>Patient Name:</strong> $patientName</p>
            <p><strong>Prescription Details:</strong></p>
            <p>$prescriptionDetails</p>
        ";

        // Send email
        $mail->send();
        $message = "Prescription successfully sent to $patientEmail.";
        $messageType = "success";
    } catch (Exception $e) {
        $message = "Failed to send the prescription. Error: {$mail->ErrorInfo}";
        $messageType = "error";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Generator</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            /* background-color: #fff; */
            background: linear-gradient(135deg, #edd8d9, #edccce);
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            color: #333;
        }

        /* header {
            background-color: #ff0000;
            color: white;
            padding: 15px;
            text-align: center;
        } */

        .container {
            margin: 20px auto;
            max-width: 600px;
            padding: 20px;
            border: 1px solid #ff0000;
            border-radius: 8px;
            background-color: white;
        }

        h1 {
            text-align: center;
            color: #ff0000;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ff0000;
            border-radius: 8px;
        }

        textarea {
            resize: none;
        }

        button {
            padding: 10px;
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #cc0000;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <h1>Prescription Generator</h1>
    </header>

    <div class="container">
        <h1>Generate Prescription</h1>
        <form class="send_prescriptions "method="POST" action="">
            <label for="patient_name">Patient Name</label>
            <input class="name" type="text" id="patient_name" name="patient_name" required>

            <label for="patient_email">Patient Email</label>
            <input class="email" type="email" id="patient_email" name="patient_email" required>

            <label for="prescription_details">Prescription Details</label>
            <textarea id="prescription_details" name="prescription_details" rows="6" required></textarea>

            <button type="submit">Send Prescription</button>
        </form>

        <?php if (isset($message)): ?>
            <div class="<?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
