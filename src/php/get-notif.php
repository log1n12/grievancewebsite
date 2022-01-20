<?php
date_default_timezone_set("Asia/Manila");

$addtitle = $notifTitle;
$addmessage = $notifMesg;
$adddate = date("F j, Y, g:i a");
$addto = $notifTo;
$addtotype = $notifToType;
$addfrom = $notifFrom;
$addcategory = "notification";
$addnotifsql = "INSERT INTO notification (d_title, d_message, d_datesubmit, d_to, d_totype, d_from, d_category) VALUES ('$addtitle','$addmessage','$adddate','$addto','$addtotype','$addfrom','$addcategory')";
$con->exec($addnotifsql);
