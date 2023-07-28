<!DOCTYPE html>
<html>
<head>
    <title>View Doctors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: orange;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid orange;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid orange;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: orange;
            color: black;
        }

        tr:nth-child(even) {
            background-color: black(238, 233, 232);
        }

        .edit-button {
            background-color: orange;
            color: black;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .edit-button:hover {
            background-color: #FF8C00;
        }
    </style>
</head>
<body>
    <?php
    session_start(); // Start the session

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "drug_dispensing";

    // Create a new connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the logged-in doctor's SSN
    $loggedInSSN = $_SESSION['name'];

    // Retrieve the logged-in doctor's information
    $sql = "SELECT * FROM doctors WHERE SSN = '$loggedInSSN'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <table>
            <tr>
                <th>SSN</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Email Address</th>
                <th>Phone Number</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>

            <tr>
                <td><?php echo $row['SSN']; ?></td>
                <td><?php echo $row['Fname']; ?></td>
                <td><?php echo $row['Lname']; ?></td>
                <td><?php echo $row['age']; ?></td>
                <td><?php echo $row['email_address']; ?></td>
                <td><?php echo $row['phone_number']; ?></td>
                <td><?php echo $row['password']; ?></td>
                <td>
                    <form action="editdoctor.php" method="POST">
                        <input type="hidden" name="SSN" value="<?php echo $row['SSN']; ?>">
                        <input type="submit" value="Edit" class="edit-button">
                    </form>
                </td>
            </tr>
        </table>
        <?php
    } else {
        echo "<p>No doctor found.</p>";
    }
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
