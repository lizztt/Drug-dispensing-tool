<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "drug_dispensing";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $drug_id = $_POST['drug_id'];
    $drug_name= $_POST['drug_name'];
    $manufacturer = $_POST['manufacturer'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

   
    $query = "UPDATE drugs SET drug_name = ?, manufacturer = ?, quantity = ?,price=? WHERE drug_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisi", $drug_name, $manufacturer, $quantity, $price, $drug_id);
    $stmt->execute();

    
    header("Location: viewdrugs.php");
    exit;

    
}
?>
