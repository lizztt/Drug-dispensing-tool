<!DOCTYPE html>
<html>
<head>
    <title>Welcome, Pharmaceutical Company</title>
</head>
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
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .back-button:hover {
            background-color: #FF8C00;
        }
    </style>
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

        // Retrieve the company's first name and last name from the database
        $SSN = $_SESSION['name'];

        $query = "SELECT Fname, Lname FROM pharm_comp_admin WHERE SSN = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $SSN);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $Fname = $row['Fname'];
            $Lname = $row['Lname'];

            echo "<h2>Welcome,Pharmaceutical Company Admin, $Fname $Lname</h2>";
        } else {
            echo "<h2>Welcome, Pharmaceutical Company Admin</h2>";
        }

        $conn->close();
        ?>

        <h3>Actions:</h3>

        <form action="pharmcompadminview.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Company Admin Details">
        </form>


        <form action="pharmcompadmincontract.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Add/Update Contract Details">
        </form>

        <form action="viewcontractdetails.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Contract Details">
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
