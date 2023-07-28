<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "drug_dispensing";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $SSN = $_POST['SSN'];
    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $age = $_POST['age'];
    $email_address = $_POST['email_address'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];

    
    $query = "UPDATE pharmacists SET Fname = ?, Lname = ?, age = ?, email_address = ?, phone_number = ?, password = ? WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssisi", $Fname, $Lname, $age, $email_address, $phone_number, $password, $SSN);
    $stmt->execute();

   
    header("Location: viewpharmacists.php");
    exit;
}
?>
