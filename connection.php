<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "school";

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo"success";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>               