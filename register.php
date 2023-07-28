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

$userType = $_POST['userType'];

if (empty($userType)) {
    echo "Invalid user type.";
    exit;
}

$SSN = $_POST['SSN'];
$Fname = $_POST['Fname'];
$Lname = $_POST['Lname'];
$dob = $_POST['dob'];
$email_address = $_POST['email_address'];
$phone_number = $_POST['phone_number'];
$password = $_POST['password'];
$confirmPassword = $_POST['Confirm_password'];


$today = new DateTime();
$birthDate = new DateTime($dob);
$ageInterval = $birthDate->diff($today);
$age = $ageInterval->y;

$tableName = "";
switch ($userType) {
    case "patient":
        $tableName = "patients";
        break;
    case "doctor":
        $tableName = "doctors";
        break;
    case "supervisor":
        $tableName = "supervisors";
        break;
    case "pharmacist":
        $tableName = "pharmacists";
        break;
    case "pharmaceuticalcompanyadmin":
        $tableName = "pharm_comp_admin";
        break;
    case"admin":
        $tableName="admin";
        break;   
    default:
        echo "Invalid user type.";
        exit;
}

$stmt = $conn->prepare("INSERT INTO $tableName (SSN, Fname, Lname, age, email_address, phone_number, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ississs", $SSN, $Fname, $Lname, $age, $email_address, $phone_number, $password);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Registration successful as $userType!";
    header("Location: login.html");
    exit;
} else {
    echo "Error occurred. Please try again.";
}

if ($stmt->error) {
    echo "Error: " . $stmt->error;
    exit;

   
}

$stmt->close();
$conn->close();
?>
