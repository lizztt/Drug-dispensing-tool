<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: orange;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 20px auto;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid orange;
            border-radius: 4px;
            background-color: black;
            color: orange;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: orange;
            color: black;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #FF8C00;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        require_once("connect.php");

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $SSN = $_POST['SSN'];

            $query = "SELECT * FROM patients WHERE SSN = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $SSN);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                ?>
                <form action="updateuser.php" method="POST">
                    <input type="hidden" name="SSN" value="<?php echo $row['SSN']; ?>">
                    <label for="Fname">First Name:</label>
                    <input type="text" name="Fname" value="<?php echo $row['Fname']; ?>"><br>
                    <label for="Lname">Last Name:</label>
                    <input type="text" name="Lname" value="<?php echo $row['Lname']; ?>"><br>
                    <label for="password">Password:</label>
                    <input type="password" name="password" value="<?php echo $row['password']; ?>"><br>
                    <input type="submit" value="Update">
                </form>

                <form action="deleteuser.php" method="POST" onsubmit="return confirm('Are you sure you want to disable your account?');">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Disable Account">
        </form>

                <?php
            } else {
                echo "User not found.";
            }
        }
        ?>
    </div>
</body>
</html>
