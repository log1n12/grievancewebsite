<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'griv';

$dbdsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
$con = new PDO($dbdsn, $user, $password);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
