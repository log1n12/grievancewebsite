<?php
if (isset($_POST['photoStore'])) {
    $file_path = "../assets/account_pic/";
    $encoded_data = $_POST['photoStore'];
    $binary_data = base64_decode($encoded_data);

    $photoname = uniqid() . '.jpeg';

    $result = file_put_contents($file_path . $photoname, $binary_data);

    if ($result) {
        echo 'success';
    } else {
        echo die('Could not save image! check file permission.');
    }
}