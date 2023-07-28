<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $SSN = $_POST['SSN'];
    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $password = $_POST['password'];

    $query = "UPDATE patients SET Fname = ?, Lname = ?, password = ? WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $Fname, $Lname, $password, $SSN);
    $stmt->execute();
 
    header("Location: viewpatients.php");
    exit;
}
?>
