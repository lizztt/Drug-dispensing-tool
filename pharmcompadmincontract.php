<!DOCTYPE html>
<html>
<head>
    <title>Contract</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: black; color: orange; text-align: center;">

    <div class="container" style="margin-top: 50px;">
        <h2 style="margin-bottom: 20px;">Pharmcom Contract</h2>

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

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $pharmcomp_admin_SSN = $_SESSION['name'];
            $contract_ID=$_POST['contract_ID'];
            $supervisor_SSN = $_POST['supervisor_SSN'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            
            $query = "INSERT INTO contract (contract_ID, pharm_comp_admin_SSN, supervisor_SSN, start_date, end_date) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiiss",$contract_ID, $pharmcomp_admin_SSN, $supervisor_SSN, $start_date, $end_date);

            if ($stmt->execute()) {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                header("Location: pharmaceuticalcompanyadmin.php?success=true");
                exit();
            } else {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                header("Location: pharmaceuticalcompanyadmin.php?success=false&error=" . urlencode("Failed to add the prescription. Please try again later."));
                exit();
            }

            $stmt->close();
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" style="margin: 0 auto; width: 400px;">
            <label for="contract_ID" style="margin-bottom: 10px;">Contract ID:</label><br>
            <input type="text" name="contract_ID" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid orange; border-radius: 4px;"><br>

            <label for="supervisor_SSN" style="margin-bottom: 10px;">Supervisor SSN:</label><br>
            <input type="text" name="supervisor_SSN" id="supervisor_SSN" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid orange; border-radius: 4px;"><br>

            <label for="start_date" style="margin-bottom: 10px;">Start Date:</label><br>
            <input type="date" name="start_date" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid orange; border-radius: 4px;"><br>

            <label for="end_date" style="margin-bottom: 10px;">End Date:</label><br>
            <input type="date" name="end_date" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid orange; border-radius: 4px;"><br>

            <input type="submit" name="submit" value="Create Contract" style="background-color: orange; color: black; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px;"><br>
        </form>

        <button class="back-button" onclick="goBack()" style="background-color: orange; color: black; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; margin-top: 20px;">Back</button>

        <script>
            function goBack() {
                window.location.href = "pharmaceuticalcompanyadmin.php";
            }
        </script>
    </div>
</body>
</html>
