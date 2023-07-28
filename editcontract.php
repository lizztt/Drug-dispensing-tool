<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "drug_dispensing";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $contract_ID = $_POST['contract_ID'];

    $query = "SELECT * FROM contract WHERE contract_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $contract_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Contract</title>
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
            <form action="updatecontract.php" method="POST">
                <input type="hidden" name="contract_ID" value="<?php echo $row['contract_ID']; ?>">
                <label for="pharm_comp_admin_SSN">Company Admin SSN:</label>
                <input type="text" name="pharm_comp_admin_SSN" value="<?php echo $row['pharm_comp_admin_SSN']; ?>"><br>
                <label for="supervisor_SSN">Supervisor SSN:</label>
                <input type="text" name="supervisor_SSN" value="<?php echo $row['supervisor_SSN']; ?>"><br>
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" value="<?php echo $row['start_date']; ?>"><br>
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" value="<?php echo $row['end_date']; ?>"><br>
                <input type="submit" value="Update">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "<div class='error-message'>Contract not found.</div>";
    }

    
    exit;
}
?>
