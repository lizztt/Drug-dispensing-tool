<!DOCTYPE html>
<html>
<head>
    <title>View Prescriptions</title>
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

        // Get the patient SSN from the session
        $patientSSN = $_SESSION['name'];

        // Retrieve the prescriptions of the logged-in patient
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
        $conn->close();
        ?>

        <br><br>
        <button class="back-button" onclick="goBack()">Back</button>
    </div>

    <script>
        function goBack() {
            //window.history.back();
            window.location.href = "patient.php";
        }
    </script>
</body>
</html>
