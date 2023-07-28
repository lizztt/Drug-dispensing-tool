<!DOCTYPE html>
<html>
<head>
    <title>Sale of Drugs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: black;
            color: orange;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: black;
            color: orange;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: orange;
        }

        p {
            color: orange;
        }

        .success-message {
            color: green;
            font-weight: bold;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }

        .form-button {
            padding: 10px;
            background-color: orange;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-button.cancel {
            background-color: #FF8C00;
        }

        .form-button:hover {
            background-color: #FF8C00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Drug dispensing</h1>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "drug_dispensing";

        $conn = mysqli_connect($servername, $username, $password, $database);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $prescription_ID = $_POST["prescription_ID"];
            $drugID = $_POST["drug_id"];
            $drugName = $_POST["drug_name"];
            $quantity = $_POST["quantity"];
            $patient_SSN = $_POST["patientSSN"]; // Corrected variable name
            $doctor_SSN = $_POST["doctorSSN"]; // Corrected variable name
            $start_date = $_POST["start_date"];
            $end_date = $_POST["end_date"];

            // Check if the price is set
            if (isset($_POST["price"])) {
                $price = $_POST["price"];
            } else {
                // Fetch the drug price from the "drugs" table based on the drug name
                $fetchPriceQuery = "SELECT price FROM drugs WHERE drug_name = ?";
                $fetchPriceStmt = mysqli_prepare($conn, $fetchPriceQuery);
                mysqli_stmt_bind_param($fetchPriceStmt, "s", $drugName);
                mysqli_stmt_execute($fetchPriceStmt);
                $priceResult = mysqli_stmt_get_result($fetchPriceStmt);

                if ($priceResult && $priceResult->num_rows > 0) {
                    $priceRow = $priceResult->fetch_assoc();
                    $price = $priceRow['price'];
                } else {
                    // If the drug name is not found in the "drugs" table, set the price to 0 or any default value
                    $price = 0;
                }
            }
            

            if (isset($_POST["confirm"]) && $_POST["confirm"] === "true") {
                $moveQuery = "INSERT INTO drugdispensed (prescription_ID,  drug_name, quantity, price, patient_SSN, doctor_SSN, start_date, end_date) SELECT prescription_ID,  drug_name, quantity, ?, patient_SSN, doctor_SSN, start_date, end_date FROM prescription WHERE prescription_ID = ?";
                $moveStmt = mysqli_prepare($conn, $moveQuery);
                mysqli_stmt_bind_param($moveStmt, "di", $price, $prescription_ID);

                // Execute the queries within a transaction
                mysqli_begin_transaction($conn);

                try {
                    // Move prescription to tbl_prescription_sold
                    mysqli_stmt_execute($moveStmt);

                    // Commit the transaction
                    mysqli_commit($conn);

                    $deleteQuery = "DELETE FROM prescription WHERE prescription_ID = ?";
                    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
                    mysqli_stmt_bind_param($deleteStmt, "i", $prescription_ID);
                    mysqli_stmt_execute($deleteStmt);
                    echo '<p class="success-message">Drugs dispensed successfully.</p>';
                    echo '<p>Price: ' . $price . '</p>';
                    echo '<br><button class="form-button cancel" onclick="goBack()">Back</button>';
                } catch (Exception $e) {
                    mysqli_rollback($conn);
                    echo '<p class="error-message">Error: ' . $e->getMessage() . '</p>';
                    echo '<br><button class="form-button cancel" onclick="goBack()">Back</button>';
                }

                mysqli_stmt_close($moveStmt);
                mysqli_stmt_close($deleteStmt);
            } else {
                // Ask the user to confirm the sale
                echo '<p>Please confirm the sale with the following details:</p>';
                echo '<p>Prescription ID: ' . $prescription_ID . '</p>';
                echo '<p>Drug Name: ' . $drugName . '</p>';
                echo '<p>Quantity: ' . $quantity . '</p>';
                echo '<p>Total Price: ' . $price . '</p>';
                echo '<form action="dispensedrugs.php" method="POST">';
                echo '<input type="hidden" name="prescription_ID" value="' . $prescription_ID . '">';
                echo '<input type="hidden" name="drug_id" value="' . $drugID . '">';
                echo '<input type="hidden" name="drug_name" value="' . $drugName . '">';
                echo '<input type="hidden" name="quantity" value="' . $quantity . '">';
                echo '<input type="hidden" name="patientSSN" value="' . $patient_SSN . '">';
                echo '<input type="hidden" name="doctorSSN" value="' . $doctor_SSN . '">';
                echo '<input type="hidden" name="start_date" value="' . $start_date . '">';
                echo '<input type="hidden" name="end_date" value="' . $end_date . '">';

                echo '<input type="hidden" name="confirm" value="true">';
                echo '<input class="form-button" type="submit" value="Confirm Dispense">';
                echo '</form>';
                echo '<br><button class="form-button cancel"  onclick="goBack()">Cancel</button>';
            }
        }

        mysqli_close($conn);
        ?>

        <script>
            function goBack() {
                window.location.href = "viewprescription.php";
            }
        </script>
    </div>
</body>
</html>
