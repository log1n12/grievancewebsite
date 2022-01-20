<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$titleHeader = "KP Reports";
$buttonEnable = "0";
$confirm = "no";
$message = "";

date_default_timezone_set("Asia/Manila");
$monthPick = "";
$yearPick = "";

$civilCount = 0;
$criminalCount = 0;
$otherCount = 0;
$totalCount = 0;

$mediationCount = 0;
$conciliationCount = 0;
$arbitrationCount = 0;
$totalCount1 = 0;

$repudiatedCount = 0;
$withdrawnCount = 0;
$pendingCount = 0;
$dismissedCount = 0;
$certifiedCount = 0;
$rtcaCount = 0;
$totalCount2 = 0;

if (isset($_POST['generateKpReport'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];
    $monthPick = $month;
    $yearPick = $year;
    $buttonEnable = "1";

    $getKp = "SELECT * FROM complaint_case WHERE incident_year = '$year' AND incident_month = '$month' AND complaint_type = 'complaint' AND where_to = '$barangayName'";
    $getKpQuery = $con->query($getKp);
    foreach ($getKpQuery as $row) {
        $nod = $row['nod'];
        $actionTaken = $row['action_taken'];

        //Get the count for nature of disputes
        $compareKp = "SELECT * FROM kplist WHERE id = '$nod'";
        $compareKpQuery = $con->query($compareKp);
        foreach ($compareKpQuery as $row1) {
            $kptype = $row1['kp_type'];

            if ($kptype == "Civil") {
                $civilCount += 1;
            } elseif ($kptype == "Criminal") {
                $criminalCount += 1;
            } else {
                $otherCount += 1;
            }
        }

        //Get the count for settled cases
        $compareSc = "SELECT * FROM actiontaken WHERE id = '$actionTaken'";
        $compareScQuery = $con->query($compareSc);
        foreach ($compareScQuery as $row12) {
            $aTName = $row12['action_taken'];

            switch ($aTName) {
                case "mediation":
                    $mediationCount += 1;
                    break;
                case "conciliation":
                    $conciliationCount += 1;
                    break;
                case "arbitration":
                    $arbitrationCount += 1;
                    break;

                    //unsetlled case
                case "repudiated":
                    $repudiatedCount += 1;
                    break;
                case "withdrawn":
                    $withdrawnCount += 1;
                    break;
                case "dismissed":
                    $dismissedCount += 1;
                    break;
                case "certified":
                    $certifiedCount += 1;
                    break;
                case "referred to concerened agencies":
                    $rtcaCount += 1;
                    break;
            }
        }
    }

    $ongoingcountsql = "SELECT * FROM complaint_case WHERE incident_year = '$year' AND incident_month = '$month' AND where_to = '$barangayName' AND complaint_type = 'complaint' AND case_status = 'ongoing'";
    $ongoingcountstmt = $con->prepare($ongoingcountsql);
    $ongoingcountstmt->execute();
    $pendingCount = $ongoingcountstmt->rowCount();

    $totalCount = $civilCount + $criminalCount + $otherCount;
    $totalCount1 = $mediationCount + $conciliationCount + $arbitrationCount;
    $totalCount2 = $repudiatedCount + $withdrawnCount + $pendingCount + $dismissedCount + $certifiedCount + $rtcaCount;
} else {
    $monthToday = date('F');
    $yearToday = date('Y');
    $monthPick = $monthToday;
    $yearPick = $yearToday;
    $getKp = "SELECT * FROM complaint_case WHERE incident_year = '$yearToday' AND incident_month = '$monthToday' AND complaint_type = 'complaint' AND where_to = '$barangayName'";
    $getKpQuery = $con->query($getKp);
    foreach ($getKpQuery as $row) {
        $nod = $row['nod'];
        $actionTaken = $row['action_taken'];

        $compareKp = "SELECT * FROM kplist WHERE id = '$nod'";
        $compareKpQuery = $con->query($compareKp);
        foreach ($compareKpQuery as $row1) {
            $kptype = $row1['kp_type'];

            if ($kptype == "Civil") {
                $civilCount += 1;
            } elseif ($kptype == "Criminal") {
                $criminalCount += 1;
            } else {
                $otherCount += 1;
            }
        }

        //Get the count for settled cases
        $compareSc = "SELECT * FROM actiontaken WHERE id = '$actionTaken'";
        $compareScQuery = $con->query($compareSc);
        foreach ($compareScQuery as $row12) {
            $aTName = $row12['action_taken'];

            switch ($aTName) {
                case "mediation":
                    $mediationCount += 1;
                    break;
                case "conciliation":
                    $conciliationCount += 1;
                    break;
                case "arbitration":
                    $arbitrationCount += 1;
                    break;

                    //unsetlled case
                case "repudiated":
                    $repudiatedCount += 1;
                    break;
                case "withdrawn":
                    $withdrawnCount += 1;
                    break;
                case "dismissed":
                    $dismissedCount += 1;
                    break;
                case "certified":
                    $certifiedCount += 1;
                    break;
                case "referred to concerened agencies":
                    $rtcaCount += 1;
                    break;
            }
        }
    }

    $ongoingcountsql = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'complaint' AND case_status = 'ongoing'";
    $ongoingcountstmt = $con->prepare($ongoingcountsql);
    $ongoingcountstmt->execute();
    $pendingCount = $ongoingcountstmt->rowCount();


    $totalCount = $civilCount + $criminalCount + $otherCount;
    $totalCount1 = $mediationCount + $conciliationCount + $arbitrationCount;
    $totalCount2 = $repudiatedCount + $withdrawnCount + $pendingCount + $dismissedCount + $certifiedCount + $rtcaCount;
}

if (isset($_POST['submitKpReport'])) {
    $monthPick1 = $_POST['monthPick'];
    $yearPick1 = $_POST['yearPick'];

    $civilCount1 = $_POST['civilCount'];
    $criminalCount1 = $_POST['criminalCount'];
    $otherCount1 = $_POST['otherCount'];
    $totalCount14 = $_POST['totalCount'];

    $mediationCount1 = $_POST['mediationCount'];
    $conciliationCount1 = $_POST['conciliationCount'];
    $arbitrationCount1 = $_POST['arbitrationCount'];
    $totalCount11 = $_POST['totalCount1'];

    $repudiatedCount1 = $_POST['repudiatedCount'];
    $withdrawnCount1 = $_POST['withdrawnCount'];
    $pendingCount1 = $_POST['pendingCount'];
    $dismissedCount1 = $_POST['dismissedCount'];
    $certifiedCount1 = $_POST['certifiedCount'];
    $rtcaCount1 = $_POST['rtcaCount'];
    $totalCount21 = $_POST['totalCount2'];

    $checkKP = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_year = '$yearPick1' AND kp_month = '$monthPick1' AND kp_status = 'breject'";
    $checkKPstmt = $con->prepare($checkKP);
    $checkKPstmt->execute();
    $checkKPcount = $checkKPstmt->rowCount();

    if ($checkKPcount > 0) {
        // pag may breject check kung may bpending pag merong bpending bawal magsend na
        $checkKP1 = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_year = '$yearPick1' AND kp_month = '$monthPick1' AND kp_status = 'bpending' ";
        $checkKP1stmt = $con->prepare($checkKP1);
        $checkKP1stmt->execute();
        $checkKP1count = $checkKP1stmt->rowCount();

        if ($checkKP1count > 0) {
            $message = "You still have pending request for this month and year";
        } else {
            $checkKP11 = "SELECT * FROM kpreport WHERE (brgy = '$barangayName' AND kp_year = '$yearPick1' AND kp_month = '$monthPick1' AND kp_status = 'dpending') OR  (brgy = '$barangayName' AND kp_year = '$yearPick1' AND kp_month = '$monthPick1' AND kp_status = 'dreceived')";
            $checkKP11stmt = $con->prepare($checkKP11);
            $checkKP11stmt->execute();
            $checkKP11count = $checkKP11stmt->rowCount();
            if ($checkKP11count > 0) {
                $message = "You already submitted";
            } else {

                require_once __DIR__ . '/vendor/autoload.php';


                $html = '
<html><head>
<style>
table {
  border-collapse: collapse;
}
th {
  text-align: inherit;
}
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
  background-color: white;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
  text-align: center;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid red;
}

.table .table {
  background-color: #fff;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

</style>
</head>
<body style="background-color: white;">
<p style="font-size: 12px;">KP MONITORING FORM No. 2</p>
    <table style="width: 100%">
        <tbody>
            <tr>
                <td>
                    Province: <b>Laguna</b>
                </td>
                <td>
                    Reporting Month: <b>' . $monthPick1 . '</b>
                </td>
            </tr>
            <tr>
                <td>
                    City/ Municipality: <b>Magdalena</b>
                </td>
                <td>
                    Calendar Year: <b>' . $yearPick1 . '</b>
                </td>
            </tr>
            <tr>
                <td>
                    Barangay: <b>' . $barangayName . '</b>
                </td>
                <td>
                    
                </td>
            </tr>
        </tbody>
    </table>

    
        <table style="width: 100%; margin-bottom: 20px;">
        <tr>
        <td>
        <center>
<h4>CASES FILED AND ACTION TAKEN AND PROBLEMS ENCOUNTERED ON KP IMPLEMENTATION</h4>
        </center>
        </td>
        </tr>
        

        </table>
    
<table class="table table-bordered " style="width: 100%; margin-top: 20px;">
                                
                                
                                <tbody>
                                <tr>
<th colspan="15"><center> Actions Taken by the Lupong Tagapamayapa (2) </center> </th>
                                <tr>
                                    <tr>
                                        <th scope="col" colspan="3">Nature of Disputes (2a)</th>
                                        <th scope="col" rowspan="2">Total<br>(2a.4)</th>
                                        <th scope="col" colspan="3"><center>Settled Cases (2b)</center></th>
                                        <th scope="col" rowspan="2">Total<br>(2b.4)</th>
                                        <th scope="col" colspan="6">Unsettled Cases (2c)</th>
                                        <th scope="col" rowspan="2">Total<br>(2c.7)</th>
                                    </tr>
                                    <tr>
                                        <!-- Nature of disputes -->
                                        <td>Criminal (2a.1)</td>
                                        <td>Civil (2a.2)</td>
                                        <td>Others (2a.3)</td>

                                        <!-- Settled Cases -->
                                        <td>Mediation (2b.1)</td>
                                        <td>Conciliation (2b.2)</td>
                                        <td>Arbitration (2b.3)</td>

                                        <!-- Unsettled Cases -->
                                        <td>Repudiated (2c.1)</td>
                                        <td>Withdrawn (2c.2)</td>
                                        <td>Pending (2c.3)</td>
                                        <td>Dismissed (2c.4)</td>
                                        <td>Certified (2c.5)</td>
                                        <td>Referred to Concered Agencies (2c.6)</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $criminalCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $civilCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $otherCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount14 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $mediationCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $conciliationCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $arbitrationCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount11 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $repudiatedCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $withdrawnCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $pendingCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $dismissedCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $certifiedCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $rtcaCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount21 . '</td>
                                    </tr>

                                </tbody>
                            </table>

                            <table style="width:100%; margin-top: 30px; border-spacing: 50px;">
<tbody>
<tr>
<td><center>Prepared By:</center></td>
<td><center>Submitted By:</center></td>
</tr>
<tr>
<td><center><img src="../assets/signature/' . $secSignature . '" alt="Girl in a jacket" style="width: auto; height: 80px; margin-bottom: 0; padding-bottom: 0;"></center></td>
<td><center><img src="../assets/signature/' . $brgyCaptSignature . '" alt="Girl in a jacket" style="width: auto; height: 80px; margin-bottom: 0; padding-bottom: 0;"></center></td>
</tr>
<tr>
<td><center><b><span style="font-size: 15px;">' . $fullname . '</span></b></center><hr style="width: 50%; margin: 0; padding: 0; height: 2px; color: black;"><center>Barangay Secretary</center></td>
<td><center><b><span style="font-size: 15px;">' . $brgyCaptain . '</span></b></center><hr style="width: 50%; margin: 0; padding: 0; height: 2px; color: black;"><center>Barangay Captain</center></td>
</tr>
</tbody>
</table>

                            
</body>
</html>
';
                include("./vendor/mpdf/mpdf/src/Mpdf.php");
                $mpdf = new \Mpdf\Mpdf([
                    'orientation' => 'L'
                ]);

                $mpdf->SetDisplayMode('fullpage');
                $mpdf->list_indent_first_level = 0;


                $today = date("YmdHis");
                $filepath = "../assets/kpreport/";
                $filename = $today . "griv_" . $barangayName . "_" . $monthPick1 . $yearPick1 . ".pdf";

                // Write some HTML code:
                $mpdf->WriteHTML($html);

                $filee = $filepath . $filename;
                // Output a PDF file directly to the browser
                $mpdf->Output($filepath . $filename, \Mpdf\Output\Destination::FILE);

                $kpReportSql = "INSERT INTO kpreport (kp_filename, kp_year, kp_month, brgy, kp_status) VALUES ('$filename','$yearPick1','$monthPick1','$barangayName', 'bpending')";
                if ($con->exec($kpReportSql)) {
                    $notifTitle = "KP Report Generated";
                    $notifMesg = "KP Report for $monthPick1 $yearPick1 was successfully generate.";
                    $notifTo = $barangayName;
                    $notifToType = "Barangay Captain";
                    $notifFrom = $cookieId;
                    require './get-notif.php';

                    $confirm = "yes";
                    $message = "KP report for this is successfully submitted";
                } else {
                    $message = "Your feedback was not successfully sent. Please try again.";
                }
            }
        }
    } else {
        // pag may breject check kung may bpending pag merong bpending bawal magsend na
        $checkKP1 = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_year = '$yearPick1' AND kp_month = '$monthPick1' AND kp_status = 'bpending' ";
        $checkKP1stmt = $con->prepare($checkKP1);
        $checkKP1stmt->execute();
        $checkKP1count = $checkKP1stmt->rowCount();

        if ($checkKP1count > 0) {
            $message = "You still have pending request for this month and year";
        } else {
            $checkKP11 = "SELECT * FROM kpreport WHERE (brgy = '$barangayName' AND kp_year = '$yearPick1' AND kp_month = '$monthPick1' AND kp_status = 'dpending') OR  (brgy = '$barangayName' AND kp_year = '$yearPick1' AND kp_month = '$monthPick1' AND kp_status = 'dreceived')";
            $checkKP11stmt = $con->prepare($checkKP11);
            $checkKP11stmt->execute();
            $checkKP11count = $checkKP11stmt->rowCount();
            if ($checkKP11count > 0) {
                $message = "You already submitted";
            } else {

                require_once __DIR__ . '/vendor/autoload.php';


                $html = '
<html><head>
<style>
table {
  border-collapse: collapse;
}
th {
  text-align: inherit;
}

.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
  text-align: center;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid red;
}

.table .table {
  background-color: #fff;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

</style>
</head>
<body style="background-color: white;">
<p style="font-size: 12px;">KP MONITORING FORM No. 2</p>
    <table style="width: 100%">
        <tbody>
            <tr>
                <td>
                    Province: <b>Laguna</b>
                </td>
                <td>
                    Reporting Month: <b>' . $monthPick1 . '</b>
                </td>
            </tr>
            <tr>
                <td>
                    City/ Municipality: <b>Magdalena</b>
                </td>
                <td>
                    Calendar Year: <b>' . $yearPick1 . '</b>
                </td>
            </tr>
            <tr>
                <td>
                    Barangay: <b>' . $barangayName . '</b>
                </td>
                <td>
                    
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
        <td>
        <center>
<h4>CASES FILED AND ACTION TAKEN AND PROBLEMS ENCOUNTERED ON KP IMPLEMENTATION</h4>
        </center>
        </td>
        </tr>
        

        </table>
<table class="table table-bordered " style="width: 100%">
                                
                                
                                <tbody>
                                <tr>
<th colspan="15"><center> Actions Taken by the Lupong Tagapamayapa (2) </center> </th>
                                <tr>
                                    <tr>
                                        <th scope="col" colspan="3">Nature of Disputes (2a)</th>
                                        <th scope="col" rowspan="2">Total<br>(2a.4)</th>
                                        <th scope="col" colspan="3"><center>Settled Cases (2b)</center></th>
                                        <th scope="col" rowspan="2">Total<br>(2b.4)</th>
                                        <th scope="col" colspan="6">Unsettled Cases (2c)</th>
                                        <th scope="col" rowspan="2">Total<br>(2c.7)</th>
                                    </tr>
                                    <tr>
                                        <!-- Nature of disputes -->
                                        <td>Criminal (2a.1)</td>
                                        <td>Civil (2a.2)</td>
                                        <td>Others (2a.3)</td>

                                        <!-- Settled Cases -->
                                        <td>Mediation (2b.1)</td>
                                        <td>Conciliation (2b.2)</td>
                                        <td>Arbitration (2b.3)</td>

                                        <!-- Unsettled Cases -->
                                        <td>Repudiated (2c.1)</td>
                                        <td>Withdrawn (2c.2)</td>
                                        <td>Pending (2c.3)</td>
                                        <td>Dismissed (2c.4)</td>
                                        <td>Certified (2c.5)</td>
                                        <td>Referred to Concered Agencies (2c.6)</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $criminalCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $civilCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $otherCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount14 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $mediationCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $conciliationCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $arbitrationCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount11 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $repudiatedCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $withdrawnCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $pendingCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $dismissedCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $certifiedCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $rtcaCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount21 . '</td>
                                    </tr>

                                </tbody>
                            </table>

                            <table style="width:100%; margin-top: 30px; border-spacing: 50px;">
<tbody>
<tr>
<td><center>Prepared By:</center></td>
<td><center>Submitted By:</center></td>
</tr>
<tr>
<td><center><img src="../assets/signature/' . $secSignature . '" alt="Girl in a jacket" style="width: auto; height: 80px; margin-bottom: 0; padding-bottom: 0;"></center></td>
<td><center><img src="../assets/signature/' . $brgyCaptSignature . '" alt="Girl in a jacket" style="width: auto; height: 80px; margin-bottom: 0; padding-bottom: 0;"></center></td>
</tr>
<tr>
<td><center><b><span style="font-size: 15px;">' . $fullname . '</span></b></center><hr style="width: 50%; margin: 0; padding: 0; height: 2px; color: black;"><center>Barangay Secretary</center></td>
<td><center><b><span style="font-size: 15px;">' . $brgyCaptain . '</span></b></center><hr style="width: 50%; margin: 0; padding: 0; height: 2px; color: black;"><center>Barangay Captain</center></td>
</tr>
</tbody>
</table>

                            
</body>
</html>
';
                include("./vendor/mpdf/mpdf/src/Mpdf.php");
                $mpdf = new \Mpdf\Mpdf([
                    'orientation' => 'L'
                ]);

                $mpdf->SetDisplayMode('fullpage');
                $mpdf->list_indent_first_level = 0;


                $today = date("YmdHis");
                $filepath = "../assets/kpreport/";
                $filename = $today . "griv_" . $barangayName . "_" . $monthPick1 . $yearPick1 . ".pdf";

                // Write some HTML code:
                $mpdf->WriteHTML($html);

                $filee = $filepath . $filename;
                // Output a PDF file directly to the browser
                $mpdf->Output($filepath . $filename, \Mpdf\Output\Destination::FILE);

                $kpReportSql = "INSERT INTO kpreport (kp_filename, kp_year, kp_month, brgy, kp_status) VALUES ('$filename','$yearPick1','$monthPick1','$barangayName', 'bpending')";
                if ($con->exec($kpReportSql)) {
                    $notifTitle = "KP Report Generated";
                    $notifMesg = "KP Report for $monthPick1 $yearPick1 was successfully generate.";
                    $notifTo = $barangayName;
                    $notifToType = "Barangay Captain";
                    $notifFrom = $cookieId;
                    require './get-notif.php';
                    $confirm = "yes";
                    $message = "KP report for this is successfully submitted";
                } else {
                    $message = "Your feedback was not successfully sent. Please try again.";
                }
            }
        }
    }
}



if (isset($_POST['toGenerateReport'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $civilCount5 = 0;
    $criminalCount5 = 0;
    $otherCount5 = 0;
    $totalCount5 = 0;

    $mediationCount5 = 0;
    $conciliationCount5 = 0;
    $arbitrationCount5 = 0;
    $totalCount15 = 0;

    $repudiatedCount5 = 0;
    $withdrawnCount5 = 0;
    $pendingCount5 = 0;
    $dismissedCount5 = 0;
    $certifiedCount5 = 0;
    $rtcaCount5 = 0;
    $totalCount25 = 0;

    $dateStart = date('Y-m-d', strtotime($startDate));
    $dateEnd = date('Y-m-d', strtotime($endDate));

    $getComp = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint' AND where_to = '$barangayName'";
    $getCompQ = $con->query($getComp);
    foreach ($getCompQ as $row) {
        $dateSubmit = $row['date_submit'];
        $id = $row['id'];
        $nod = $row['nod'];
        $actionTaken = $row['action_taken'];

        $submitDate = date('Y-m-d', strtotime($dateSubmit));

        if (($submitDate >= $dateStart) && ($submitDate <= $dateEnd)) {
            //Get the count for nature of disputes
            $compareKp = "SELECT * FROM kplist WHERE id = '$nod'";
            $compareKpQuery = $con->query($compareKp);
            foreach ($compareKpQuery as $row1) {
                $kptype = $row1['kp_type'];

                if ($kptype == "Civil") {
                    $civilCount5 += 1;
                } elseif ($kptype == "Criminal") {
                    $criminalCount5 += 1;
                } else {
                    $otherCount5 += 1;
                }
            }

            //Get the count for settled cases
            $compareSc = "SELECT * FROM actiontaken WHERE id = '$actionTaken'";
            $compareScQuery = $con->query($compareSc);
            foreach ($compareScQuery as $row12) {
                $aTName = $row12['action_taken'];

                switch ($aTName) {
                    case "mediation":
                        $mediationCount5 += 1;
                        break;
                    case "conciliation":
                        $conciliationCount5 += 1;
                        break;
                    case "arbitration":
                        $arbitrationCount5 += 1;
                        break;

                        //unsetlled case
                    case "repudiated":
                        $repudiatedCount5 += 1;
                        break;
                    case "withdrawn":
                        $withdrawnCount5 += 1;
                        break;
                    case "dismissed":
                        $dismissedCount5 += 1;
                        break;
                    case "certified":
                        $certifiedCount5 += 1;
                        break;
                    case "referred to concerened agencies":
                        $rtcaCount5 += 1;
                        break;
                }
            }
        }
    }
    $ongoingcountsql = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'complaint' AND case_status = 'ongoing'";
    $ongoingcountque = $con->query($ongoingcountsql);
    foreach ($ongoingcountque as $row) {
        $dateesubmit = $row['date_submit'];
        $submitdatee = date('Y-m-d', strtotime($dateesubmit));

        if (($submitdatee >= $dateStart) && ($submitdatee <= $dateEnd)) {

            $pendingCount5 += 1;
        }
    }

    $totalCount5 = $civilCount5 + $criminalCount5 + $otherCount5;
    $totalCount15 = $mediationCount5 + $conciliationCount5 + $arbitrationCount5;
    $totalCount25 = $repudiatedCount5 + $withdrawnCount5 + $pendingCount5 + $dismissedCount5 + $certifiedCount5 + $rtcaCount5;

    require_once __DIR__ . '/vendor/autoload.php';


    $html = '
<html><head>
<style>
table {
  border-collapse: collapse;
}
th {
  text-align: inherit;
}

.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
  background-color: transparent;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
  text-align: center;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid red;
}

.table .table {
  background-color: #fff;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

</style>
</head>
<body style="background-color: white;">
<p style="font-size: 12px;">KP MONITORING FORM No. 2</p>
    <table style="width: 100%">
        <tbody>
            <tr>
                <td>
                    Province: <b>Laguna</b>
                </td>
                <td>
                    Reporting Date: <b>' . "$startDate - $endDate" . '</b>
                </td>
            </tr>
            <tr>
                <td>
                    City/ Municipality: <b>Magdalena</b>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    Barangay: <b>' . $barangayName . '</b>
                </td>
                <td>
                    
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
        <td>
        <center>
<h4>CASES FILED AND ACTION TAKEN AND PROBLEMS ENCOUNTERED ON KP IMPLEMENTATION</h4>
        </center>
        </td>
        </tr>
        

        </table>
<table class="table table-bordered " style="width: 100%">
                                
                                
                                <tbody>
                                <tr>
<th colspan="15"><center> Actions Taken by the Lupong Tagapamayapa (2) </center> </th>
                                <tr>
                                    <tr>
                                        <th scope="col" colspan="3">Nature of Disputes (2a)</th>
                                        <th scope="col" rowspan="2">Total<br>(2a.4)</th>
                                        <th scope="col" colspan="3"><center>Settled Cases (2b)</center></th>
                                        <th scope="col" rowspan="2">Total<br>(2b.4)</th>
                                        <th scope="col" colspan="6">Unsettled Cases (2c)</th>
                                        <th scope="col" rowspan="2">Total<br>(2c.7)</th>
                                    </tr>
                                    <tr>
                                        <!-- Nature of disputes -->
                                        <td>Criminal (2a.1)</td>
                                        <td>Civil (2a.2)</td>
                                        <td>Others (2a.3)</td>

                                        <!-- Settled Cases -->
                                        <td>Mediation (2b.1)</td>
                                        <td>Conciliation (2b.2)</td>
                                        <td>Arbitration (2b.3)</td>

                                        <!-- Unsettled Cases -->
                                        <td>Repudiated (2c.1)</td>
                                        <td>Withdrawn (2c.2)</td>
                                        <td>Pending (2c.3)</td>
                                        <td>Dismissed (2c.4)</td>
                                        <td>Certified (2c.5)</td>
                                        <td>Referred to Concered Agencies (2c.6)</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $criminalCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $civilCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $otherCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $mediationCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $conciliationCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $arbitrationCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount15 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $repudiatedCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $withdrawnCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $pendingCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $dismissedCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $certifiedCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $rtcaCount5 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount25 . '</td>
                                    </tr>

                                </tbody>
                            </table>

                            <table style="width:100%; margin-top: 30px; border-spacing: 50px;">
<tbody>
<tr>
<td><center>Prepared By:</center></td>
<td><center>Submitted By:</center></td>
</tr>
<tr>
<td><center><img src="../assets/signature/' . $secSignature . '" alt="Girl in a jacket" style="width: auto; height: 80px; margin-bottom: 0; padding-bottom: 0;"></center></td>
<td><center><img src="../assets/signature/' . $brgyCaptSignature . '" alt="Girl in a jacket" style="width: auto; height: 80px; margin-bottom: 0; padding-bottom: 0;"></center></td>
</tr>
<tr>
<td><center><b><span style="font-size: 15px;">' . $fullname . '</span></b></center><hr style="width: 50%; margin: 0; padding: 0; height: 2px; color: black;"><center>Barangay Secretary</center></td>
<td><center><b><span style="font-size: 15px;">' . $brgyCaptain . '</span></b></center><hr style="width: 50%; margin: 0; padding: 0; height: 2px; color: black;"><center>Barangay Captain</center></td>
</tr>
</tbody>
</table>

                            
</body>
</html>
';
    include("./vendor/mpdf/mpdf/src/Mpdf.php");
    $mpdf = new \Mpdf\Mpdf([
        'orientation' => 'L'
    ]);

    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;

    $today = date("YmdHis");
    $filepath = "../assets/kpreport/";
    $filename = $today . "griv_" . $barangayName . "_" . $startDate . "_" . $endDate . ".pdf";

    // Write some HTML code:
    $mpdf->WriteHTML($html);

    $filee = $filepath . $filename;
    // Output a PDF file directly to the browser
    $mpdf->Output($filepath . $filename, \Mpdf\Output\Destination::FILE);
    echo "
            <script type=\"text/javascript\">
             var oWindow = window.open('$filee');
            oWindow.print();
            </script>
        ";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/barangay-admin.style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
    <title>Document</title>
</head>

<body>
    <?php include './navbar/barangay.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/barangay.navbar-top.php' ?>
        <div class="transition px-4">

            <section id="table-section">
                <div id="tableNavbar">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="mx-4 mt-3">Generate KP Reports</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <button id="addBtn" class="add1 btn mx-4 mt-3 text-capitalize" data-toggle="modal" data-target="#generateReportModal"><i class="fas fa-plus mr-2"></i> Generate Report</button>
                        </div>
                    </div>
                    <div class="row mt-3">

                    </div>
                </div>


                <!-- Modal for generating report -->
                <div class="modal fade bd-example-modal-lg" id="generateReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content p-4">
                            <div class="modal-header">
                                <div>
                                    <h4 class="modal-title" id="myModalLabel">Generate Report</h4>
                                    <p><span style="font-size: 13px; font-weight: 300;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, aspernatur odit<span></p>
                                </div>


                                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body mx-5">
                                <form method="post">
                                    <h5 class="text-capitalize text-center"><i class="fas fa-info-circle fa-2x mr-2" style=" color: #111580;"></i>Brief information</h5>
                                    <hr>
                                    <p class="mt-3 mb-2"><span class="font-weight-bold">Province: </span> <span id="refNumber55">Laguna</span></p>
                                    <p class="font-weight-bold mb-2">City/ Municipality: <span id="compComplaint55" class="font-weight-light">Magdalena</span></p>
                                    <p class="font-weight-bold mb-2">Barangay: <span id="compComplaint55" class="font-weight-light"><?php echo $barangayName ?></span></p>
                                    <div class="complaintDiv mt-4">
                                        <h6 class="font-weight-bolder">Choose what is the action taken for this case</h6>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="date1">Start</label>
                                                <input type="date" class="form-control" id="date1" name="startDate" onchange="getDateFromFrom()" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="date2">End</label>
                                                <input type="date" class="form-control" name="endDate" id="date2" required>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btnAccept text-capitalize" name="toGenerateReport">Complete</button>
                                </form>
                                <button type="button" class="btn btn-danger text-capitalize" data-dismiss="modal">Close</button>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- END OF ADD MEETING MODAL -->
                <div id="tableContent" class="px-4 mb-4 py-3">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post">
                                        <div class="form-inline float-md-right">
                                            <div class="form-group">

                                                <select class="form-control mx-1 my-4" name="month" style="width: auto;">
                                                    <option value="January">January</option>
                                                    <option value="February">February</option>
                                                    <option value="March">March</option>
                                                    <option value="April">April</option>
                                                    <option value="May">May</option>
                                                    <option value="June">June</option>
                                                    <option value="July">July</option>
                                                    <option value="August">August</option>
                                                    <option value="September">September</option>
                                                    <option value="October">October</option>
                                                    <option value="November">November</option>
                                                    <option value="December">December</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control mx-1 my-4" name="year" style="width: auto;">
                                                    <?php
                                                    for ($i = date('Y'); $i >= 2000; $i--) {
                                                        echo "<option>$i</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn add mx-1 text-capitalize" name="generateKpReport">Show</button>
                                            <button type="submit" class="btn add ml-1 text-capitalize" name="showTodayReport" <?php if ($buttonEnable == "0") {
                                                                                                                                    echo "disabled";
                                                                                                                                } ?>>Today</button>

                                        </div>
                                    </form>
                                </div>
                            </div>

                            <form method="post">
                                <table class="table table-bordered table-dark text-center" id="table1231" style="width: 100%; background-color: white;">
                                    <input type="hidden" name="monthPick" value="<?php echo $monthPick ?>" />
                                    <input type="hidden" name="yearPick" value="<?php echo $yearPick ?>" />
                                    <thead>
                                        <tr>
                                            <th colspan="15"><?php echo "$monthPick $yearPick" ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th scope="col" colspan="3" style="background-color: rgba(251, 183, 177, 1);">Nature of Disputes (2a)</th>
                                            <th scope="col" rowspan="2" style="background-color: rgba(237, 116, 105, 1)">Total<br>(2a.4)</th>
                                            <th scope="col" colspan="3" style="background-color: rgba(252, 219, 173, 1);">Settled Cases (2b)</th>
                                            <th scope="col" rowspan="2" style="background-color: rgba(252, 182, 84, 1);">Total<br>(2b.4)</th>
                                            <th scope="col" colspan="6" style="background-color: rgb(154, 236, 184);">Unsettled Cases (2c)</th>
                                            <th scope="col" rowspan="2" style="background-color: rgb(75, 224, 127);">Total<br>(2c.7)</th>
                                        </tr>
                                        <tr>
                                            <!-- Nature of disputes -->
                                            <td>Criminal (2a.1)</td>
                                            <td>Civil (2a.2)</td>
                                            <td>Others (2a.3)</td>

                                            <!-- Settled Cases -->
                                            <td>Mediation (2b.1)</td>
                                            <td>Conciliation (2b.2)</td>
                                            <td>Arbitration (2b.3)</td>

                                            <!-- Unsettled Cases -->
                                            <td>Repudiated (2c.1)</td>
                                            <td>Withdrawn (2c.2)</td>
                                            <td>Pending (2c.3)</td>
                                            <td>Dismissed (2c.4)</td>
                                            <td>Certified (2c.5)</td>
                                            <td>Referred to Concered Agencies (2c.6)</td>
                                        </tr>
                                        <tr>
                                            <td class="py-5"><?php echo $criminalCount ?> <input type="hidden" name="criminalCount" value="<?php echo $criminalCount ?>" /> </td>
                                            <td class="py-5"><?php echo $civilCount ?> <input type="hidden" name="civilCount" value="<?php echo $civilCount ?>" /></td>
                                            <td class="py-5"><?php echo $otherCount ?> <input type="hidden" name="otherCount" value="<?php echo $otherCount ?>" /> </td>
                                            <td class="py-5" style="background-color: rgba(237, 116, 105, 1);"><?php echo $totalCount ?> <input type="hidden" name="totalCount" value="<?php echo $totalCount ?>" /> </td>
                                            <td class="py-5"><?php echo $mediationCount ?> <input type="hidden" name="mediationCount" value="<?php echo $mediationCount ?>" /> </td>
                                            <td class="py-5"><?php echo $conciliationCount ?> <input type="hidden" name="conciliationCount" value="<?php echo $conciliationCount ?>" /> </td>
                                            <td class="py-5"><?php echo $arbitrationCount ?> <input type="hidden" name="arbitrationCount" value="<?php echo $arbitrationCount ?>" /> </td>
                                            <td class="py-5" style="background-color: rgba(252, 182, 84, 1);"><?php echo $totalCount1 ?> <input type="hidden" name="totalCount1" value="<?php echo $totalCount1 ?>" /> </td>
                                            <td class="py-5"><?php echo $repudiatedCount ?> <input type="hidden" name="repudiatedCount" value="<?php echo $repudiatedCount ?>" /> </td>
                                            <td class="py-5"><?php echo $withdrawnCount ?> <input type="hidden" name="withdrawnCount" value="<?php echo $withdrawnCount ?>" /> </td>
                                            <td class="py-5"><?php echo $pendingCount ?> <input type="hidden" name="pendingCount" value="<?php echo $pendingCount ?>" /> </td>
                                            <td class="py-5"><?php echo $dismissedCount ?> <input type="hidden" name="dismissedCount" value="<?php echo $dismissedCount ?>" /> </td>
                                            <td class="py-5"><?php echo $certifiedCount ?> <input type="hidden" name="certifiedCount" value="<?php echo $certifiedCount ?>" /> </td>
                                            <td class="py-5"><?php echo $rtcaCount ?> <input type="hidden" name="rtcaCount" value="<?php echo $rtcaCount ?>" /> </td>
                                            <td class="py-5" style="background-color: rgb(75, 224, 127);"><?php echo $totalCount2 ?> <input type="hidden" name="totalCount2" value="<?php echo $totalCount2 ?>" /> </td>
                                        </tr>

                                    </tbody>
                                </table>

                                <button type="submit" class="btn mx-1 text-capitalize float-right add1" name="submitKpReport">Submit KP Report</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <section id="table-section" class="mt-3">
                <div id="tableNavbar">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="mx-4 mt-4">List of KP reports</h1>
                        </div>
                    </div>
                    <div class="row mt-3 ml-4">
                        <div class="com-md-12">
                            <nav id="navSort">
                                <div class="nav sort" id="nav-tab" role="tablist">
                                    <a class="nav-item btnSort nav-link active px-4 mr-1" id="nav-unread-tab" data-toggle="tab" href="#nav-unread" role="tab" aria-controls="nav-unread" aria-selected="true"><span class="sortTitle">Barangay Captain Pending</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-unread1-tab" data-toggle="tab" href="#nav-unread1" role="tab" aria-controls="nav-unread1" aria-selected="true"><span class="sortTitle">Barangay Captain Rejected</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-read-tab" data-toggle="tab" href="#nav-read" role="tab" aria-controls="nav-read" aria-selected="false"><span class="sortTitle">DILG Received</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-read1-tab" data-toggle="tab" href="#nav-read1" role="tab" aria-controls="nav-read1" aria-selected="false"><span class="sortTitle">DILG Rejected</span></a>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div id="tableContent" class="px-5 mb-4 py-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <div class="tab-content" id="nav-tabContent">
                                <!-- TABLE PENDING -->
                                <div class="tab-pane fade show active" id="nav-unread" role="tabpanel" aria-labelledby="nav-unread1-tab">
                                    <table class="table table1 table-hover text-center" id="table123123121" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Month</th>
                                                <th scope="col">Year</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_status = 'bpending'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['kp_filename'];
                                                $kpmonth = $row['kp_month'];

                                                $kpyear = $row['kp_year'];

                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><a href="../assets/kpreport/<?php echo $fname; ?>" target="_blank"><?php echo $fname ?></a></td>
                                                        <td class="text-capitalize"><?php echo $kpmonth ?></td>
                                                        <td><?php echo $kpyear ?></td>

                                                    </form>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE BARANGAY REJECT -->
                                <div class="tab-pane fade" id="nav-unread1" role="tabpanel" aria-labelledby="nav-unread-tab">
                                    <table class="table table1 table-hover text-center" id="table123123125" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Month</th>
                                                <th scope="col">Year</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_status = 'breject'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['kp_filename'];
                                                $kpmonth = $row['kp_month'];

                                                $kpyear = $row['kp_year'];

                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><a href="../assets/kpreport/<?php echo $fname; ?>" target="_blank"><?php echo $fname ?></a></td>
                                                        <td class="text-capitalize"><?php echo $kpmonth ?></td>
                                                        <td><?php echo $kpyear ?></td>

                                                    </form>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE DILG RECEIVED -->
                                <div class="tab-pane fade" id="nav-read" role="tabpanel" aria-labelledby="nav-read-tab">
                                    <table class="table table1 table-hover text-center" id="table12" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Month</th>
                                                <th scope="col">Year</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_status = 'dreceived'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['kp_filename'];
                                                $kpmonth = $row['kp_month'];

                                                $kpyear = $row['kp_year'];

                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><a href="../assets/kpreport/<?php echo $fname; ?>" target="_blank"><?php echo $fname ?></a></td>
                                                        <td class="text-capitalize"><?php echo $kpmonth ?></td>
                                                        <td><?php echo $kpyear ?></td>
                                                    </form>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE DILG REJECT -->
                                <div class="tab-pane fade" id="nav-read1" role="tabpanel" aria-labelledby="nav-read1-tab">
                                    <table class="table table1 table-hover text-center" id="table123" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Month</th>
                                                <th scope="col">Year</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_status = 'dreject'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['kp_filename'];
                                                $kpmonth = $row['kp_month'];

                                                $kpyear = $row['kp_year'];

                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><a href="../assets/kpreport/<?php echo $fname; ?>" target="_blank"><?php echo $fname ?></a></td>
                                                        <td class="text-capitalize"><?php echo $kpmonth ?></td>
                                                        <td><?php echo $kpyear ?></td>
                                                    </form>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            // ALERT 
            <?php
            if ($message != "") {
                if ($confirm == "yes") {


            ?>
                    Swal.fire({

                            title: 'Success',
                            icon: 'success',
                            html: '<?php echo $message ?>'
                        }

                    )
                <?php
                } else {
                ?>
                    Swal.fire(
                        'Error',
                        '<?php echo $message; ?>',
                        'error'
                    )
            <?php
                }
            }
            ?>
            $('table.table1').DataTable({
                "scrollX": true,
                "lengthChange": false
            });


            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
                setTimeout(function() {
                    $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust();
                }, 350);
            });
        });

        $(function() {
            // GET DATE TODAY
            var dtToday = new Date();


            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;

            //ID KUNG ANONG CALENDAR YUNG LALAGYAN MO NG MIN DATE
            $('#date1').attr('max', maxDate);
            $('#date2').attr('min', maxDate);



        });

        function getDateFromFrom() {
            var input = document.getElementById("date1").value;
            $('#date2').attr('min', input);
        }
    </script>

    <script>
        function myFunction(x) {
            var notifIcon = document.getElementById("navbarDropdownMenuLink151");
            if (x.matches) { // If media query matches
                $("#sidebar").addClass("active");
                $("#content").addClass("active");

                $('#sidebarCollapse').on('click', function() {
                    if (x.matches) {
                        $('#sidebar, #content').addClass('activity');
                    }

                });

                $('#sidebarClose').on('click', function() {
                    $("#sidebar").addClass("active");
                    $("#content").addClass("active");
                    $("#content").removeClass("activity");
                });



            } else {
                $("#sidebar").removeClass("active");
                $("#content").removeClass("active");
                $("#content").removeClass("activity");
            }
        }

        var x = window.matchMedia("(max-width: 500px)")

        x.addListener(myFunction) // Attach listener function on state changes
        myFunction(x) // Call listener function at run time
    </script>
</body>

</html>