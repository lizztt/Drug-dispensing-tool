<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $SSN = $_POST['SSN'];

    
    $query = "DELETE FROM patients WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $SSN);
    $stmt->execute();

    
    header("Location: viewpatients.php");
    exit;
}
?>
