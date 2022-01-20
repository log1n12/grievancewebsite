<?php
session_start();
require_once 'database/config.php';

if (isset($_POST['brgyPost'])) {
    $asd = $_POST['brgyPost'];
    $barangayNameLowerCase = strtolower(preg_replace('/\s+/', '_', $asd));
    $query = "SELECT name FROM purok WHERE $barangayNameLowerCase = '1'";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $purok = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($purok);
}
