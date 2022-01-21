<?php
$host = 'remotemysql.com';
$user = 'CBmCmjt7U3';
$password = '80Xwk0MnXs';
$dbname = 'CBmCmjt7U3';

$dbdsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
$con = new PDO($dbdsn, $user, $password);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
