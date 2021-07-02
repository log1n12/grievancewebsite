<?php
if (isset($_COOKIE['id'])) :
    setcookie('id', '', time() - 7000000, '/');
    header("location:login.page.php");
endif;
?>