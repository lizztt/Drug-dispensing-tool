<!DOCTYPE html>
<html>
<head>
    <title>Prescription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: black;
            color: orange;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: black;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"],
        select,
        input[type="date"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            color: #000;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #FF9800;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .back-button {
            padding: 10px;
            background-color: #ccc;
            color: #000;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        /* Styling for the back button on hover */
        .back-button:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Prescription Form</h2>

        <?php
        // Start the session
        session_start();

        // Database connection details
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "drug_dispensing";

        // Create a new connection
        $conn = new mysqli($host, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $error_message = ""; // Initialize the error message variable

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $doctor_SSN = $_SESSION['name'];
            $patient_SSN = $_POST['patient_SSN'];
            $prescription_id = $_POST['prescription_id'];
            $drug_name = $_POST['drug_name'];
            $quantity = $_POST['quantity'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            // Check if the patient exists in the database
            $getPatientSSNQuery = "SELECT SSN FROM patients WHERE SSN = ?";
            $stmt = $conn->prepare($getPatientSSNQuery);
            $stmt->bind_param("s", $patient_SSN);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Insert prescription into the database
                $query = "INSERT INTO prescription (prescription_id, drug_name, quantity, patient_SSN, doctor_SSN, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("isiiiss", $prescription_id, $drug_name, $quantity, $patient_SSN, $doctor_SSN, $start_date, $end_date);

                if ($stmt->execute()) {
                    // Prescription added successfully
                    $stmt->close();
                    mysqli_close($conn);
                    header("Location: viewpatienthistory.php?success=true");
                    exit();
                } else {
                    // Failed to add the prescription
                    $error_message = "Failed to add the prescription. Please try again later.";
                    error_log("MySQL Error: " . $stmt->error);
                }
            } else {
                $error_message = "Patient with SSN '$patient_SSN' does not exist in the database.";
            }
        }

        // Fetch the list of drugs for the select dropdown
        $drugQuery = "SELECT drug_name FROM drugs";
        $drugResult = $conn->query($drugQuery);
        ?>

        <?php if (!empty($error_message)) : ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <?php if (isset($_GET['SSN'])) : ?>
                <label for="patient_SSN">Patient SSN:</label>
                <input type="text" name="patient_SSN" value="<?php echo $_GET['SSN']; ?>" readonly><br>
            <?php endif; ?>

            <label for="prescription_id">Prescription ID:</label>
            <input type="text" name="prescription_id" required><br>

            
                <label for="patient_SSN">Patient SSN:</label>
                <input type="text" name="patient_SSN" required><br>
            

            <label for="drug_name">Drug Name:</label>
            <select name="drug_name" required>
                <?php
                $drugResult->data_seek(0);
                while ($row = $drugResult->fetch_assoc()) : ?>
                    <option value="<?php echo $row['drug_name']; ?>"><?php echo $row['drug_name']; ?></option>
                <?php endwhile; ?>
            </select><br>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required><br>

            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" required><br>

            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" required><br>

            <input type="submit" name="submit" value="Give Prescription">
        </form>

        <button class="back-button" onclick="goBack()">Back</button>

        <script>
            function goBack() {
                window.location.href = "viewpatienthistory.php";
            }
        </script>
    </div>
</body>
</html>
