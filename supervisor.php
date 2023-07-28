<!DOCTYPE html>
<html>
<head>
    <title>Welcome, Supervisor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: orange;
            text-align: center;
        }

        h2 {
            margin-top: 50px;
        }

        h3 {
            margin-top: 20px;
        }

        form {
            margin-top: 10px;
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
            cursor: pointer;
            border-radius: 4px;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #FF8C00;
        }
    </style>
</head>
<body>
    <center>
        <?php
        session_start(); 
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

    // Retrieve the supervisor's first name and last name from the database
    $SSN = $_SESSION['name'];

    $query = "SELECT Fname, Lname FROM supervisors WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $SSN);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $Fname = $row['Fname'];
        $Lname = $row['Lname'];

        echo "<h2>Welcome, Supervisor $Fname $Lname</h2>";
    } else {
        echo "<h2>Welcome, Supervisor</h2>";
    }

    $conn->close();
    ?>

    <h3>Actions:</h3>

    <form action="viewsupervisordetails.php" method="POST">
        <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
        <input type="submit" value="View Supervisor Details">
    </form>

    

    <form action="supervisorviewcontract.php" method="POST">
        <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
        <input type="submit" value="View Contract Details">
    </form>


    <form action="supervisorviewpharmaceuticalcompadmin.php" method="POST">
        <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
        <input type="submit" value="View Pharmaceutical Company Admin Details">
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
