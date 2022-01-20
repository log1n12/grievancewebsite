<?php
header('Content-Type: application/json');

require_once './database/config.php';
$x = $_POST['id'];

$sqlQuery = "SELECT incident_month FROM meeting WHERE ";

$sqlStmt = $con->query($sqlQuery);

$data = array();
foreach ($sqlStmt as $row) {
    $data[] = $row;
}

echo json_encode($data);
