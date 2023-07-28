<!DOCTYPE html>
<html>
<head>
    <title>Edit Drugs</title>
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
        input[type="password"] {
            padding: 8px;
            border: 1px solid orange;
            border-radius: 4px;
            background-color: black;
            color: orange;
            margin-bottom: 10px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: orange;
            color: black;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
            width: auto;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #FF8C00;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

       
    </style>
</head>
<body>
    <div class="container">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "drug_dispensing";

        $conn = mysqli_connect($servername, $username, $password, $database);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $drug_id = $_POST['drug_id'];

            $query = "SELECT * FROM drugs WHERE drug_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $drug_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                ?>
                <form action="updatedrug.php" method="POST">
                    <input type="hidden" name="drug_id" value="<?php echo $row['drug_id']; ?>">
                    <label for="drug_name">Drug Name:</label>
                    <input type="text" name="drug_name" value="<?php echo $row['drug_name']; ?>"><br>
                    <label for="manufacturer">Manufacturer:</label>
                    <input type="text" name="manufacturer" value="<?php echo $row['manufacturer']; ?>"><br>
                    <label for="quantity">Quantity:</label>
                    <input type="text" name="quantity" value="<?php echo $row['quantity']; ?>"><br>
                    <label for="price">Price:</label>
                    <input type="text" name="price" value="<?php echo $row['price']; ?>"><br>
                    <input type="submit" value="Update">
                </form>
                <?php
            } else {
                echo "Drug not found.";
            }
        }
        ?>
    </div> 
</body>
</html>
