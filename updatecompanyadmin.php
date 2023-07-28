<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "drug_dispensing";



$conn = mysqli_connect($servername,$username,$password,$database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user's SSN and updated information from the submitted form
    $SSN = $_POST['SSN'];
    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $email_address = $_POST['email_address'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];

    echo "Received data: SSN=$SSN, Fname=$Fname, Lname=$Lname, email_address=$email_address, phone_number=$phone_number, password=$password";


    // Update the user's information in the database
    $query = "UPDATE pharm_comp_admin SET Fname = ?, Lname = ?, email_address = ?, phone_number = ?, Password = ? WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssisi", $Fname, $Lname,  $email_address, $phone_number, $password, $SSN);
    $stmt->execute();

    
    header("Location: pharmcompadminview.php");
    exit;
    
}
?>