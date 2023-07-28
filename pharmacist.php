<!DOCTYPE html>
<html>
<head>
    <title>Welcome, Pharmacist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: orange;
        }
        
        h2 {
            text-align: center;
            color: orange;
        }
        
        h3 {
            margin-top: 20px;
            color: orange;
        }
        
        center {
            margin-top: 20px;
        }
        
        form {
            display: block; /* Change display to block to make them appear in rows */
            margin-bottom: 10px; /* Add margin between rows */
        }
        
        input[type="submit"] {
            background-color: orange;
            color: black;
            border: none;
            padding: 10px 20px;
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
            cursor: pointer;
            border-radius: 4px;
        }
        
        .back-button:hover {
            background-color: #FF8C00;
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

        // Retrieve the pharmacist's first name and last name from the database
        $SSN = $_SESSION['name'];

        $query = "SELECT Fname, Lname FROM pharmacists WHERE SSN = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $SSN);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $Fname = $row['Fname'];
            $Lname = $row['Lname'];

            echo "<h2>Welcome, Pharmacist $Fname $Lname</h2>";
        } else {
            echo "<h2>Welcome, Pharmacist</h2>";
        }

        $conn->close();
        ?>

        <h3>Actions:</h3>

    <form action="pharmacistview.php" method="POST">
        <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
        <input type="submit" value="View Pharmacist Information">
    </form>

        <form action="pharmacistviewdrugs.php" method="GET">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Drug Details">
        </form>

        <form action="adddrugs.php" method="GET">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Add Drugs">
        </form>

        <form action="viewprescription.php" method="GET">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Prescriptions">
        </form>

        <form action="pharmacistviewprescriptionhistory.php" method="POST">
        <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
        <input type="submit" value="View Prescription History">
    </form>

    <form action="viewdrugsdispensed.php" method="GET">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Drugs Dispensed">
        </form>

        <button class="back-button" onclick="goBack()">Logout</button>
    </div>

    <script>
        function goBack() {
            window.location.href = "login.html";
        }
    </script>

</body>
</html>
