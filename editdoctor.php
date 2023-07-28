<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "drug_dispensing";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $SSN = $_POST['SSN'];

    $query = "SELECT * FROM doctors WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $SSN);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Doctors</title>
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
            <form action="updatedoctors.php" method="POST">
                <input type="hidden" name="SSN" value="<?php echo $row['SSN']; ?>">
                <label for="Fname">First Name:</label>
                <input type="text" name="Fname" value="<?php echo $row['Fname']; ?>"><br>
                <label for="Lname">Last Name:</label>
                <input type="text" name="Lname" value="<?php echo $row['Lname']; ?>"><br>
                <label for="email_address">Email address:</label>
                <input type="email" name="email_address" value="<?php echo $row['email_address']; ?>"><br>
                <label for="phone_number">Phone:</label>
                <input type="text" name="phone_number" value="<?php echo $row['phone_number']; ?>"><br>
                <label for="password">Password:</label>
                <input type="password" name="password" value="<?php echo $row['password']; ?>"><br>
                <input type="submit" value="Update">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "<div class='error-message'>Doctor not found.</div>";
    }

    
    exit;
}
?>
