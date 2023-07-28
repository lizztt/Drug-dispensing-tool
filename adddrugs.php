<!DOCTYPE html>
<html>
<head>
    <title>Add Drugs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: orange;
            text-align: center;
        }

        .container {
            margin: 20px auto;
            width: 80%;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid orange;
            padding: 8px;
            color: orange;
        }

        th {
            background-color: orange;
            color: black;
        }

        .input-box {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
        }

        h2 {
            color: orange;
        }

        form {
            margin: 20px auto;
            width: 60%;
        }

        label {
            display: block;
            margin-bottom: 6px;
        }

        input[type="submit"],
        .back-button {
            background-color: orange;
            color: black;
            border: none;
            padding: 10px 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover,
        .back-button:hover {
            background-color: #FF8C00;
        }
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "drug_dispensing";

    // Create a new connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to fetch and display drugs from the database
    function displayDrugs($conn) {
        $query = "SELECT * FROM drugs";
        $result = $conn->query($query);

        // Display the drugs in an HTML table
        if ($result && $result->num_rows > 0) {
            echo "<div class='container'>";
            echo "<h2>Drugs Table</h2>";
            echo "<table>";
            echo "<tr><th>Drug ID</th><th>Drug Name</th><th>Manufacturer</th><th>Quantity</th><th>Price</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><input type='text' class='input-box' value='" . $row['drug_id'] . "' readonly></td>";
                echo "<td><input type='text' class='input-box' value='" . $row['drug_name'] . "' readonly></td>";
                echo "<td><input type='text' class='input-box' value='" . $row['manufacturer'] . "' readonly></td>";
                echo "<td><input type='text' class='input-box' value='" . $row['quantity'] . "' readonly></td>";
                echo "<td><input type='text' class='input-box' value='" . $row['price'] . "' readonly></td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "</div>";
        } else {
            echo "<p>No drugs found in the database.</p>";
        }
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $drug_id = $_POST["drug_id"];
        $drug_name = $_POST["drug_name"];
        $manufacturer = $_POST["manufacturer"];
        $quantity = $_POST["quantity"];
        $price = $_POST["price"];

        $query = "INSERT INTO drugs (drug_id, drug_name, manufacturer, quantity, price) 
                  VALUES ('$drug_id', '$drug_name', '$manufacturer', '$quantity', '$price')";

        if ($conn->query($query) === TRUE) {
            // Data inserted successfully, display updated table
            displayDrugs($conn);
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        // Display drugs table initially
        displayDrugs($conn);
    }

    // Close the database connection
    $conn->close();
    ?>

    <h2>Add Drugs</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="drug_id">Drug ID:</label>
        <input type="text" name="drug_id" class="input-box" required><br>
        <label for="drug_name">Drug Name:</label>
        <input type="text" name="drug_name" class="input-box" required><br>
        <label for="manufacturer">Manufacturer:</label>
        <input type="text" name="manufacturer" class="input-box" required><br>
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" class="input-box" required><br>
        <label for="price">Price:</label>
        <input type="text" name="price" class="input-box" required><br>
        <input type="submit" value="Add Drug">
    </form>

    <button class="back-button" onclick="goBack()">Back</button>

    <script>
        function goBack() {
            window.location.href = "pharmacist.php";
        }
    </script>
</body>
</html>
