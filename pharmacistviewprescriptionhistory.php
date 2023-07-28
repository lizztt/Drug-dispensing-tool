<!DOCTYPE html>
<html>
<head>
    <title>Prescription History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: black;
            color: orange;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #FF9800;
            color: white;
        }

        td {
            padding-left: 15px;
            padding-right: 15px;
            border-right: 1px solid orange;
        }

        th, td {
            border-left: 1px solid orange;
        }

        /* Add left margin for the first column */
        td:first-child {
            padding-left: 0;
        }

        .container {
            max-width: 800px;
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

        .back-button {
            padding: 10px;
            background-color: #ccc;
            color: #000;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .back-button:hover {
            background-color: #ddd;
        }

        .view-history-button {
            padding: 10px;
            background-color: orange;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .view-history-button:hover {
            background-color: #FF8C00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Prescription History</h2>

        <?php
        session_start(); // Start the session

        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "drug_dispensing";

        $conn = new mysqli($host, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["patient_SSN"]) && !empty($_POST["patient_SSN"])) {
                $patientSSN = $_POST["patient_SSN"];

                // Retrieve the prescriptions of the specified patient
                $query = "SELECT * FROM prescription WHERE patient_SSN = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $patientSSN);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr>
                            <th>Prescription ID</th>
                            <th>Drug Name</th>
                            <th>Quantity</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                          </tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['prescription_ID'] . "</td>
                                <td>" . $row['drug_name'] . "</td>
                                <td>" . $row['quantity'] . "</td>
                                <td>" . $row['start_date'] . "</td>
                                <td>" . $row['end_date'] . "</td>
                              </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<h2>No Prescription History Found</h2>";
                }

                $stmt->close();
            }
        }

        $conn->close();
        ?>

        <br><br>
        <form action="pharmacistprescription.php" method="post">
            <label for="patient_SSN">Enter Patient SSN:</label>
            <input type="text" name="patient_SSN" id="patient_SSN" required>
            <input class="view-history-button" type="submit" value="View Prescription History">
        </form>
        <br>
        <button class="back-button" onclick="goBack()">Back</button>
    </div>

    <script>
        function goBack() {
            window.location.href = "pharmacist.php";
        }
    </script>
</body>
</html>
