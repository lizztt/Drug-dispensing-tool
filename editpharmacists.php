<!DOCTYPE html>
<html>
<head>
    <title>Edit Pharmacists</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: orange;
            margin: 20px;
        }

        label {
            color: orange;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 6px 10px;
            border: 1px solid orange;
            border-radius: 4px;
            color: orange;
            background-color: black;
            margin-bottom: 10px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: orange;
            color: black;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 4px;
            width: auto;
        }

        input[type="submit"]:hover {
            background-color: #FF8C00;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "drug_dispensing";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $SSN = $_POST['SSN'];

        $query = "SELECT * FROM pharmacists WHERE SSN = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $SSN);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            ?>
            <form action="updatepharmacists.php" method="POST">
                <input type="hidden" name="SSN" value="<?php echo $row['SSN']; ?>">
                <label for="Fname">First Name:</label>
                <input type="text" name="Fname" value="<?php echo $row['Fname']; ?>"><br>
                <label for="Lname">Last Name:</label>
                <input type="text" name="Lname" value="<?php echo $row['Lname']; ?>"><br>
                <label for="age">Age:</label>
                <input type="text" name="age" value="<?php echo $row['age']; ?>"><br>
                <label for="email_address">Email Address:</label>
                <input type="email" name="email_address" value="<?php echo $row['email_address']; ?>"><br>
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" value="<?php echo $row['phone_number']; ?>"><br>
                <label for="password">Password:</label>
                <input type="password" name="password" value="<?php echo $row['password']; ?>"><br>
                <input type="submit" value="Update">
            </form>
            <?php
        } else {
            echo "<div class='error-message'>Pharmacist not found.</div>";
        }
    }
    ?>
</body>
</html>
