<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "drug_dispensing";



$conn = mysqli_connect($servername,$username,$password,$database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user's SSN and updated information from the submitted form
    $contract_ID = $_POST['contract_ID'];
    $pharm_comp_admin_SSN= $_POST['pharm_comp_admin_SSN'];
    $supervisor_SSN = $_POST['supervisor_SSN'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    

    echo "Received data: contract_ID=$contract_ID, pharm_comp_admin_SSN= $pharm_comp_admin_SSN, supervisor_SSN=$$supervisor_SSN , start_date=$start_date, end_date=$end_date";


    // Update the user's information in the database
    $query = "UPDATE contract SET pharm_comp_admin_SSN= ?, supervisor_SSN = ?, start_date = ?, end_date = ? WHERE contract_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiss", $contract_ID, $pharm_comp_admin_SSN,  $supervisor_SSN, $start_date, $end_date);
    $stmt->execute();

    
    header("Location: viewcontractdetails.php");
    exit;
    
}
?>