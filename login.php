<?php

session_start(); // Start the session

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

// Retrieve form data
$userType = $_POST['userType'];
$SSN = $_POST['SSN'];
$password = $_POST['password'];

// Perform basic form validation
if (empty($userType) || empty($SSN) || empty($password)) {
    echo "All fields are required.";
    exit;
}

// Determine the appropriate table based on the selected user type
$tableName = "";
$redirectPage = ""; // Variable to store the user-specific page to redirect to

switch ($userType) {
    case "patient":
        $tableName = "patients";
        $redirectPage = "patient.php";
        break;
    case "doctor":
        $tableName = "doctors";
        $redirectPage = "doctor.php";
        break;
    case "supervisor":
        $tableName = "supervisors";
        $redirectPage = "supervisor.php";
        break;
    case "pharmacist":
        $tableName = "pharmacists";
        $redirectPage = "pharmacist.php";
        break;
    case "pharmaceuticalcompanyadmin":
        $tableName = "pharm_comp_admin";
        $redirectPage = "pharmaceuticalcompanyadmin.php";
        break;
    case "admin":
        $tableName="admin";
        $redirectPage="admin.php";
        break;

    default:
        echo "Invalid user type.";
        exit;
}

// Prepare and execute the SQL statement to check user credentials
$query = "SELECT * FROM $tableName WHERE SSN = ? AND password = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $SSN, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Login successful
    // Set session variables
    $_SESSION['userType'] = $userType;
    $_SESSION['name'] = $SSN; // You can modify this to store the actual name of the user from the database if available
    
    // Redirect to the user-specific page
    header("Location: $redirectPage");
    exit;
} else {
    // Login failed
    echo "Invalid SSN or password for $userType.";
}


?>