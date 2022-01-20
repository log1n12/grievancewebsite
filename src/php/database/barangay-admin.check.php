<?php
//GETTING INFORMATION BASED ON USERNAME TO ACCOUNTS
if (isset($_COOKIE['id'])) {
    $cookieId = $_COOKIE["id"];
    $getInfoque = "SELECT * FROM account WHERE id = '$cookieId'";
    $data = $con->query($getInfoque);
    foreach ($data as $row) {
        $id = $row['id'];
        $barangayName = $row['barangay'];
        $userName = $row['username'];
        $userPassword = $row['user_password'];
        $userType = $row['user_type'];
        $fname = $row['sec_fname'];
        $mname = $row['sec_mname'];
        $lname = $row['sec_lname'];
        $secEmail = $row['sec_email'];
        $secSignature = $row['sec_signature'];
        $secPicture = $row['sec_picture'];
        $brgyCaptain = "";

        $fullname = $fname . " " . $mname . " " . $lname;

        $getBrgyCaptain = "SELECT * FROM account WHERE user_type = 'barangay_captain' AND barangay = '$barangayName'";
        $captData = $con->query($getBrgyCaptain);
        foreach ($captData as $row1) {
            $brgyCaptainF = $row1['sec_fname'];
            $brgyCaptainM = $row1['sec_mname'];
            $brgyCaptainL = $row1['sec_lname'];
            $brgyCaptSignature = $row1['sec_signature'];

            $brgyCaptain = $brgyCaptainF . " " . $brgyCaptainM . " " .  $brgyCaptainL;
        }
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
