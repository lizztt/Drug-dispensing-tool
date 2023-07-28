<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "drug_dispensing";

$conn = mysqli_connect($servername, $username, $password, $database);

// Pagination variables
$recordsPerPage = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Retrieve total number of records
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM contract";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

// Calculate total number of pages
$totalPages = ceil($totalRecords / $recordsPerPage);

// Retrieve limited records for the current page
$sql = "SELECT * FROM contract LIMIT $offset, $recordsPerPage";
$result = $conn->query($sql);



?>

<!DOCTYPE html>
<html>
<head>
    <title>View Contracts</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: black;
        color: orange;
        text-align: center;
    }

    .container {
        margin-top: 50px;
    }

    table {
        border-collapse: collapse;
        width: 80%;
        margin: 0 auto;
        border: 1px solid orange;
    }

    th, td {
        border: 1px solid orange;
        padding: 8px;
        text-align: center;
        background-color: black; /* Set the background color for both th and td elements */
        color: orange;
    }

    th {
        background-color: orange;
        color: black;
        font-weight: bold;
    }

    th.title-header {
        background-color: black;
        color: black;
        font-weight: bold;
    }

    tr:nth-child(even) td {
        background-color: black; /* Set the background color for even rows */
    }

    tr:nth-child(odd) td {
        background-color: black; /* Set the background color for odd rows */
    }

    .pagination {
        margin-top: 20px;
    }

    .pagination a, .pagination span {
        padding: 5px 10px;
        margin: 5px;
        text-decoration: none;
        color: white;
        background-color: orange;
        border-radius: 4px;
    }

    .pagination a:hover {
        background-color: #FF8C00;
    }

    .pagination span {
        background-color: #FF8C00;
    }

    .back-button {
        background-color: orange;
        color: black;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 4px;
        margin-top: 20px;
    }

    .back-button:hover {
        background-color: #FF8C00;
    }
</style>




</head>
<body>
    <table>
        <tr>
            <th>Contract ID</th>
            <th>Pharmcomp Admin SSN</th>
            <th 
            >Supervisor SSN</th>
            <th>Start Date</th>
            <th >End Date</th>
           </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td ><?php echo $row['contract_ID']; ?></td>
                <td><?php echo $row['pharm_comp_admin_SSN']; ?></td>
                <td ><?php echo $row['supervisor_SSN']; ?></td>
                <td><?php echo $row['start_date']; ?></td>
                <td ><?php echo $row['end_date']; ?></td>
                  

            </tr>
        <?php endwhile; ?>
    </table>
   

    <!-- Pagination section -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>">Previous</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo ($page + 1); ?>">Next</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <button class="back-button" onclick="goBack()">Back</button>

    <script>
        function goBack() {
            window.location.href = "supervisor.php";
        }
    </script>
</body>
</html>
