<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    // Retrieve the drug ID from the form
    $drugId = $_POST['drug_id'];

    // Delete the drug from the database
    $query = "DELETE FROM drugs WHERE drug_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $drugId);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        echo "<h2>Drug deleted successfully!</h2>";
    } else {
        echo "<h2>Failed to delete the drug.</h2>";
    }

    $conn->close();
}
?>
