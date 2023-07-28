<?php

$servername="localhost";
$username= "root";
$password="";
$dbname="drug_dispensing";

$conn=new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error){
    die("Connection failed:" .$conn->connect_error);
}
echo "Updated successfully";

?>