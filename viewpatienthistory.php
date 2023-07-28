<!DOCTYPE html>
<html>
<head>
    <title>View Patient History</title>
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

        td form {
            display: inline-block;
            margin: 0;
        }

        td form input[type="submit"] {
            background-color: orange;
            color: black;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        td form input[type="submit"]:hover {
            background-color: #FF8C00;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            color: orange;
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color 0.3s;
            border-radius: 4px;
            margin-right: 5px;
        }

        .pagination a.active {
            background-color: orange;
            color: black;
        }

        .pagination a:hover:not(.active) {
            background-color: #FF8C00;
        }
        td form {
            display: inline-block;
            margin: 5px; 
        }
    </style>
</head>
<body>
    <h2>View Patient History</h2>
    <?php
    // Retrieve patient history and display it here
    // For example:
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "drug_dispensing";

    // Create a new connection
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $recordsPerPage = 5;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $recordsPerPage;

    // Fetch patient history from the database
    $getPatientHistoryQuery = "SELECT * FROM patients LIMIT $offset, $recordsPerPage";
    $result = $conn->query($getPatientHistoryQuery);

    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>SSN</th><th>First Name</th><th>Last Name</th><th>Actions</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['SSN'] . '</td>';
            echo '<td>' . $row['Fname'] . '</td>';
            echo '<td>' . $row['Lname'] . '</td>';
            echo '<td>';
            echo '<form action="createprescription.php" method="POST">';
            echo '<input type="hidden" name="SSN" value="' . $row['SSN'] . '">';
            echo '<input type="submit" value="Prescribe Medicine for Patient">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No patient records found.";
    }

    // Pagination
    $totalRecordsQuery = "SELECT COUNT(*) AS total FROM patients";
    $totalRecordsResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

    $totalPages = ceil($totalRecords / $recordsPerPage);

    if ($totalPages > 1) {
        echo '<div class="pagination">';
        if ($page > 1) {
            echo '<a href="?page=' . ($page - 1) . '">Previous</a>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                echo '<a href="?page=' . $i . '" class="active">' . $i . '</a>';
            } else {
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
        }

        if ($page < $totalPages) {
            echo '<a href="?page=' . ($page + 1) . '">Next</a>';
        }

        echo '</div>';
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
