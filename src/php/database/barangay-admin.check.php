<?php
//GETTING INFORMATION BASED ON USERNAME TO ACCOUNTS
$cookieId = $_COOKIE["id"];
if (isset($_COOKIE['id'])) {
    $getInfoque = "SELECT * FROM account WHERE id = '$cookieId'";
    $data = $con->query($getInfoque);
    foreach ($data as $row) {
        $id = $row['id'];
        $barangayName = $row['barangay'];
        $userName = $row['username'];
        $userPassword = $row['user_password'];
        $userType = $row['user_type'];
        //CHECKING IF THE ACC IS HOSPITAL ADMIN
        if ($userType != "barangay_admin") {
            session_start();
            session_destroy();
            header("location:login.page.php");
        }
    }
} else {
    header("location:login.page.php");
}
