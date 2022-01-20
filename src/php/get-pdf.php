<?php
$barangay = $_POST['barangay'];
$barangaySec = $_POST['barangaySec'];
$barangayCapt = $_POST['barangayCapt'];

$monthPick = $_POST['monthPick'];
$yearPick = $_POST['yearPick'];

$civilCount = $_POST['civilCount'];
$criminalCount = $_POST['criminalCount'];
$otherCount = $_POST['otherCount'];
$totalCount = $_POST['totalCount'];

$mediationCount = $_POST['mediationCount'];
$conciliationCount = $_POST['conciliationCount'];
$arbitrationCount = $_POST['arbitrationCount'];
$totalCount1 = $_POST['totalCount1'];

$repudiatedCount = $_POST['repudiatedCount'];
$withdrawnCount = $_POST['withdrawnCount'];
$pendingCount = $_POST['pendingCount'];
$dismissedCount = $_POST['dismissedCount'];
$certifiedCount = $_POST['certifiedCount'];
$rtcaCount = $_POST['rtcaCount'];
$totalCount2 = $_POST['totalCount2'];

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
<body>
<h1>Barangay ' . $barangay . '</h1>
<table class="table table-bordered " style="width: 100%">
                                
                                
                                <tbody>
                                <tr>
<th colspan="15"><center> KP REPORTS FOR ' . "$monthPick $yearPick" . ' </center> </th>
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
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $criminalCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $civilCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $otherCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $mediationCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $conciliationCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $arbitrationCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount1 . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $repudiatedCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $withdrawnCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $pendingCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $dismissedCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $certifiedCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $rtcaCount . '</td>
                                        <td style="padding-top: 100px; padding-bottom: 100px;">' . $totalCount2 . '</td>
                                    </tr>

                                </tbody>
                            </table>

                            <table style="width:100%; margin-top: 70px; border-spacing: 50px;">
<tbody>
<tr>
<td><center>Prepared By:</center></td>
<td><center>Submitted By:</center></td>
</tr>
<tr>
<td><center><img src="../assets/my-signature.png" alt="Girl in a jacket" style="width: auto; height: 80px; margin-bottom: 0; padding-bottom: 0;"></center></td>
<td><center><img src="../assets/my-signature.png" alt="Girl in a jacket" style="width: auto; height: 80px; margin-bottom: 0; padding-bottom: 0;"></center></td>
</tr>
<tr>
<td><center><b><span style="font-size: 20px;">' . $barangaySec . '</span></b></center><hr style="width: 50%; margin: 0; padding: 0; height: 2px; color: black;"><center>Barangay Secretary</center></td>
<td><center><b><span style="font-size: 20px;">' . $barangayCapt . '</span></b></center><hr style="width: 50%; margin: 0; padding: 0; height: 2px; color: black;"><center>Barangay Captain</center></td>
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

$stylesheet = file_get_contents('../css/barangay-admin.style.css');
$mpdf->WriteHTML($stylesheet, 1);

$today = date("YmdHis");
$filepath = "../assets/kpreport/";
$filename = $today . "griv_" . $barangay . "_" . $monthPick . $yearPick . ".pdf";

// Write some HTML code:
$mpdf->WriteHTML($html);


// Output a PDF file directly to the browser
$mpdf->Output($filepath . $filename, \Mpdf\Output\Destination::FILE);

$kpReportSql = "INSERT INTO kpreport (kp_filename, kp_year, kp_month, brgy, kp_status) VALUES ('$filename','$yearPick','$monthPick','$barangay', 'bpending')";
if ($con->exec($addContactUs)) {
  $message = "Thank you for leaving us a comment. We are going to review it as soon as possible.";
} else {
  $message = "Your feedback was not successfully sent. Please try again.";
}
header('Location: barangay-captain-dashboard.page.php');
//$mpdf->Output(); pwede ring IFRAME pero wag na mag <a> tag nalang tayo
