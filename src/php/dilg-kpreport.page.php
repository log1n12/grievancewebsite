<?php
session_start();
require_once './database/config.php';
require_once './database/dilg-admin.check.php';
$titleHeader = "KP Report";
$confirm = "no";
$message = "";

date_default_timezone_set("Asia/Manila");


if (isset($_POST['kpapprove'])) {
    $id = $_POST['id'];
    $todayNow = date("F j, Y, g:i a");
    $unreadsql = "UPDATE kpreport SET kp_status = :case_status, date_received = :ds WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "dreceived",
        ':ds' => $todayNow,
        ':id' => $id

    ])) {
        $confirm = "yes";
        $message = "You accepted the KP Report";
    }
}

if (isset($_POST['kpreject'])) {
    $id = $_POST['id'];
    $todayNow = date("F j, Y, g:i a");
    $unreadsql = "UPDATE kpreport SET kp_status = :case_status, date_received = :ds WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "dreject",
        ':ds' => $todayNow,
        ':id' => $id

    ])) {
        $confirm = "yes";
        $message = "You rejected the KP Report";
    }
}

if (isset($_POST['printkpreport'])) {
    $kpfile = $_POST['kpfilename'];
    echo "
            <script type=\"text/javascript\">
             var oWindow = window.open('../assets/kpreport/$kpfile');
            oWindow.print();
            </script>
        ";
}

if (isset($_POST['toGenerateReport'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $kpBarangay = $_POST['kpBrgy'];

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

    $getComp = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint' AND where_to = '$kpBarangay'";
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
    $ongoingcountsql = "SELECT * FROM complaint_case WHERE where_to = '$kpBarangay' AND complaint_type = 'complaint' AND case_status = 'ongoing'";
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
                    Barangay: <b>' . $kpBarangay . '</b>
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
</tr>
<tr>
<td><center><img src="../assets/signature/' . $secSignature . '" alt="Girl in a jacket" style="width: auto; height: 80px; margin-bottom: 0; padding-bottom: 0;"></center></td>

</tr>
<tr>
<td><center><b><span style="font-size: 15px;">' . $fullname . '</span></b></center><hr style="width: 50%; margin: 0; padding: 0; height: 2px; color: black;"><center>DILG Staff</center></td>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css" integrity="sha512-csw0Ma4oXCAgd/d4nTcpoEoz4nYvvnk21a8VA2h2dzhPAvjbUIK6V3si7/g/HehwdunqqW18RwCJKpD7rL67Xg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/dilg-admin.style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
    <title>Document</title>
</head>

<body>
    <?php include './navbar/dilg.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/dilg.navbar-top.php' ?>
        <div class="transition px-4">
            <section id="list-count" class="mb-4">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-user-edit fa-2x mr-3 icon1"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $dsql = "SELECT * FROM kpreport WHERE kp_status = 'dpending'";
                                        $dsqlq = $con->prepare($dsql);
                                        $dsqlq->execute();
                                        $dscount = $dsqlq->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount ?></h5>
                                        <small class="card-text">Pending KP reports</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-sticky-note fa-2x mr-3 icon2"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $dsql1 = "SELECT * FROM kpreport WHERE kp_status = 'dreceived'";
                                        $dsqlq1 = $con->prepare($dsql1);
                                        $dsqlq1->execute();
                                        $dscount1 = $dsqlq1->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount1 ?></h5>
                                        <small>Received KP Reports</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-users fa-2x mr-3 icon3"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $dsql2 = "SELECT * FROM kpreport WHERE kp_status = 'dreject'";
                                        $dsqlq2 = $con->prepare($dsql2);
                                        $dsqlq2->execute();
                                        $dscount2 = $dsqlq2->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount2 ?></h5>
                                        <small class="card-text">Rejected KP Reports</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="table-section">
                <div id="tableNavbar">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="mx-4 mt-3">List of KP reports</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <button id="addBtn" class="add1 btn mx-4 mt-3 text-capitalize hvr-icon-spin" data-toggle="modal" data-target="#generateReportModal"><i class="fas fa-plus mr-2 hvr-icon"></i> Generate Report</button>
                        </div>
                    </div>
                    <div class="row mt-3 ml-4">
                        <div class="com-md-12">
                            <nav id="navSort">
                                <div class="nav sort" id="nav-tab" role="tablist">
                                    <a class="nav-item btnSort nav-link active px-4 mr-1" id="nav-unread-tab" data-toggle="tab" href="#nav-unread" role="tab" aria-controls="nav-unread" aria-selected="true"><span class="sortTitle">Pending</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-read-tab" data-toggle="tab" href="#nav-read" role="tab" aria-controls="nav-read" aria-selected="false"><span class="sortTitle">Submitted</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-read1-tab" data-toggle="tab" href="#nav-read1" role="tab" aria-controls="nav-read1" aria-selected="false"><span class="sortTitle">Rejected</span></a>
                                </div>
                            </nav>
                        </div>
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
                                    <div class="complaintDiv mt-4">
                                        <h6 class="font-weight-bolder">Choose what is the action taken for this case</h6>
                                        <div class="form-row mb-3">
                                            <label for="compBrgySelect">Barangay</label>
                                            <select name="kpBrgy" class="form-control" id="compBrgySelect">
                                                <?php
                                                $barangayQuery = "SELECT DISTINCT barangay FROM account WHERE barangay != 'DILG'";
                                                $barangayStmt = $con->query($barangayQuery);
                                                foreach ($barangayStmt as $row) {
                                                    $barangayRow = $row['barangay'];

                                                ?>
                                                    <option value="<?php echo $barangayRow ?>"><?php echo $barangayRow ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
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
                <div id="tableContent" class="px-4 mb-4 py-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <div class="tab-content" id="nav-tabContent">
                                <!-- TABLE PENDING -->
                                <div class="tab-pane fade show active" id="nav-unread" role="tabpanel" aria-labelledby="nav-unread-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table12312312" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Month</th>
                                                <th scope="col">Year</th>
                                                <th scope="col">Barangay</th>
                                                <th scope="col">Date Submitted</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM kpreport WHERE is_dilg = '1' AND kp_status = 'dpending'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['kp_filename'];
                                                $kpmonth = $row['kp_month'];
                                                $kpyear = $row['kp_year'];
                                                $kpbrgy = $row['brgy'];
                                                $kpsubmit = $row['date_submitted'];

                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><a href="../assets/kpreport/<?php echo $fname; ?>" target="_blank"><?php echo $fname ?></a></td>
                                                        <td class="text-capitalize"><?php echo $kpmonth ?></td>
                                                        <td><?php echo $kpyear ?></td>
                                                        <td class="text-capitalize"><?php echo $kpbrgy ?></td>
                                                        <td><?php echo $kpsubmit ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button class="add btn m-0 hvr-pulse-grow" type="submit" name="kpapprove"><i class="fas fa-check"></i></button>
                                                                <button class="add btn btn-danger m-0 hvr-pulse-grow" type="submit" name="kpreject"><i class="fas fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </form>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE submitted -->
                                <div class="tab-pane fade" id="nav-read" role="tabpanel" aria-labelledby="nav-read-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table12" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Month</th>
                                                <th scope="col">Year</th>
                                                <th scope="col">Barangay</th>
                                                <th scope="col">Date Submitted</th>
                                                <th scope="col">Date Received</th>
                                                <th scope="col">Print</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM kpreport WHERE is_dilg = '1' AND kp_status = 'dreceived'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['kp_filename'];
                                                $kpmonth = $row['kp_month'];
                                                $kpyear = $row['kp_year'];
                                                $kpbrgy = $row['brgy'];
                                                $kpsubmit = $row['date_submitted'];
                                                $kpreceive = $row['date_received'];

                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><a href="../assets/kpreport/<?php echo $fname; ?>" target="_blank"><input type="hidden" name="kpfilename" value="<?php echo $fname; ?>" /><?php echo $fname ?></a></td>
                                                        <td class="text-capitalize"><?php echo $kpmonth ?></td>
                                                        <td><?php echo $kpyear ?></td>
                                                        <td class="text-capitalize"><?php echo $kpbrgy ?></td>
                                                        <td><?php echo $kpsubmit ?></td>
                                                        <td><?php echo $kpreceive ?></td>
                                                        <td><button class="add btn m-0 hvr-pulse-grow" type="submit" name="printkpreport"><i class="fas fa-print"></i></button></td>

                                                    </form>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>


                                <!-- TABLE REJECT -->
                                <div class="tab-pane fade" id="nav-read1" role="tabpanel" aria-labelledby="nav-read1-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table125555555" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Month</th>
                                                <th scope="col">Year</th>
                                                <th scope="col">Barangay</th>
                                                <th scope="col">Date Submitted</th>
                                                <th scope="col">Date Rejected</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM kpreport WHERE is_dilg = '1' AND kp_status = 'dreject'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['kp_filename'];
                                                $kpmonth = $row['kp_month'];
                                                $kpyear = $row['kp_year'];
                                                $kpbrgy = $row['brgy'];
                                                $kpsubmit = $row['date_submitted'];
                                                $kpreceive = $row['date_received'];

                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><a href="../assets/kpreport/<?php echo $fname; ?>" target="_blank"><?php echo $fname ?></a></td>
                                                        <td class="text-capitalize"><?php echo $kpmonth ?></td>
                                                        <td><?php echo $kpyear ?></td>
                                                        <td class="text-capitalize"><?php echo $kpbrgy ?></td>
                                                        <td><?php echo $kpsubmit ?></td>
                                                        <td><?php echo $kpreceive ?></td>

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

            var table = $('table.table1').DataTable({
                "scrollX": true,
                "lengthChange": false
            });


            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            table.$("[data-toggle=popover]").popover().click(function(e) {
                e.preventDefault();
            });
        });
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });
        });
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