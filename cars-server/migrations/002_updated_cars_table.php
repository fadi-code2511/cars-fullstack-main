<?php
include("../connection/connection.php");

$sql = "ALTER TABLE ... ";
// $sql = "ALTER TABLE cars
// CHANGE new_name name VARCHAR(255) NOT NULL; ";

$query = $connection->prepare($sql);
$query->execute();

echo "Table(s) Updated!";

?>