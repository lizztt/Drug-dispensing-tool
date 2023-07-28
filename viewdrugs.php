<?php
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

$recordsPerPage = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

$totalRecordsQuery = "SELECT COUNT(*) AS total FROM drugs";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

$totalPages = ceil($totalRecords / $recordsPerPage);

$sql = "SELECT * FROM drugs LIMIT $offset, $recordsPerPage";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Drugs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: orange;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
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
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Drug ID</th>
            <th>Drug Name</th>
            <th>Manufacturer</th>
            <th>Quantity</th>
            <th>Price</th>
            
        </tr>

        <?php if ($result && $result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['drug_id']; ?></td>
                    <td><?php echo $row['drug_name']; ?></td>
                    <td><?php echo $row['manufacturer']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    
                </tr>
            <?php endwhile; ?>
        <?php else : ?>
            <tr>
                <td colspan="6">No drugs found.</td>
            </tr>
        <?php endif; ?>
    </table>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <a href="?page=<?php echo $i; ?>" class="active"><?php echo $i; ?></a>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo ($page + 1); ?>">Next</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php $conn->close(); ?>
    
    <button class="back-button" onclick="goBack()">Back</button>
    </div>

    <script>
        function goBack() {
            window.location.href = "pharmacist.php";
        }
    </script>

    
</body>
</html>
