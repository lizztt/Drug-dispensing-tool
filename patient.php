<!DOCTYPE html>
<html>
<head>
    <title>Welcome, Patient</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: orange;
        }
        
        h2 {
            text-align: center;
        }
        
        h3 {
            margin-top: 20px;
        }
        
        /* Add a new CSS style for the container div */
        .action-container {
            margin-bottom: 10px; /* Add some bottom margin to create the rows */
        }
        
        form {
            display: inline-block;
            margin-right: 10px;
        }
        
        input[type="submit"] {
            background-color: orange;
            color: black;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        
        input[type="submit"]:hover {
            background-color: #FF8C00;
        }

        .back-button {
            background-color: orange;
            color: black;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .back-button:hover {
            background-color: #FF8C00;
        }

        .container {
            text-align: center;
        }
    </style>
</head>
<body>
    <center>
        <?php
        session_start(); // Start the session

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

        // Retrieve the patient's first name and last name from the database
        $SSN = $_SESSION['name'];

        $query = "SELECT Fname, Lname FROM patients WHERE SSN = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $SSN);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $Fname = $row['Fname'];
            $Lname = $row['Lname'];

            echo "<h2>Welcome, Patient $Fname $Lname</h2>";
        } else {
            echo "<h2>Welcome, Patient</h2>";
        }

        $conn->close();
        ?>

        <h3>Actions:</h3>


        <div class="action-container">
            <form action="viewpatientinfo.php" method="POST">
                <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
                <input type="submit" value="View Patient Information">
            </form>
        </div>

        <div class="action-container">
            <form action="patientviewprescription.php" method="POST">
                <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
                <input type="submit" value="View Prescription History">
            </form>
        </div>
        <button class="back-button" onclick="goBack()">Logout</button>
    </div>

    <script>
        function goBack() {
            window.location.href = "login.html";
        }
    </script>

    
    </center>
</body>
</html>
