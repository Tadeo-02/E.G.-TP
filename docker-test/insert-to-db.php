<?php
$servername = "172.17.0.3";
$username = "root";
$password = "pw";
$dbname = "tp entornos";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//SQL to insert new rows
$sql = "INSERT INTO dockerTable (first_name, last_name) VALUES ('John', 'Doe'), ('Jane', 'Doe')";

if($conn->query($sql) === TRUE){
    echo "New record created successfully";
}else{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close conection
$conn->close();



?>