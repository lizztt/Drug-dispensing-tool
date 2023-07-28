<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: orange;
        }
        h2 {
            margin-top: 20px;
            text-align: center;
        }

        center {
            margin-top: 50px;
        }

        form {
            margin-bottom: 10px;
        }

        form input[type="submit"] {
            background-color: orange;
            color: black;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        form input[type="submit"]:hover {
            background-color: #FF8C00;
        }

        .back-button {
            background-color: orange;
            color: black;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .back-button:hover {
            background-color: #FF8C00;
        }

        script {
            margin-top: 20px;
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

    // Retrieve the admin's first name and last name from the database
    $SSN = $_SESSION['name'];

    $query = "SELECT Fname, Lname FROM admin WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $SSN);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $firstName = $row['Fname'];
        $lastName = $row['Lname'];

        echo "<h2>Welcome, Admin $firstName $lastName</h2>";
    } else {
        echo "<h2>Welcome, Admin</h2>";
    }

    $conn->close();
    ?>

    <h3>Actions:</h3>

    <form action="viewpatients.php" method="GET">
        <input type="submit" value="View Patients">
    </form>

    <form action="viewdoctor.php" method="GET">
        <input type="submit" value="View Doctors">
    </form>

    <form action="viewdrugs.php" method="GET">
        <input type="submit" value="View Drugs">
    </form>

    <form action="viewpharmacists.php" method="GET">
        <input type="submit" value="View Pharmacists">
    </form>

    <form action="viewpharmaceuticalcompadmin.php" method="GET">
        <input type="submit" value="View Pharmaceutical Company Admin">
    </form>

    <form action="viewsupervisors.php" method="GET">
        <input type="submit" value="View Supervisors">
    </form>

    <form action="adminviewcontract.php" method="GET">
        <input type="submit" value="View Contracts">
    </form>

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