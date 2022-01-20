<?php
session_start();
require_once 'database/config.php';

if (isset($_POST['actionTaken'])) {
    $asd = $_POST['actionTaken'];
    $query = "SELECT action_taken FROM actiontaken WHERE action_type = '$asd'";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $purok = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($purok);
}
