<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$titleHeader = "Report";
$message = "";
$confirm = "no";
$tab = "all";

date_default_timezone_set("Asia/Manila");

if (isset($_POST['toOngoingBtn'])) {
    $id = $_POST['id'];
    $refNo = $_POST['compRefNo'];
    $unreadsql = "UPDATE complaint_case SET case_status = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "Ongoing",
        ':id' => $id

    ])) {
        $notifTitle = "Report Accepted";
        $notifMesg = "Report was successfully accepted. The report reference number is: " . $refNo;
        $notifTo = "DILG";
        $notifToType = "Barangay Secretary";
        $notifFrom = $cookieId;

        require './get-notif.php';
        $tab = "ongoing";
        $confirm = "yes";
        $message = "The report is successfully moved to the Ongoing table";
    }
}
if (isset($_POST['toRejectedBtn'])) {
    $id = $_POST['id'];
    $exp = $_POST['rejectExp'];
    $refNo = $_POST['compRefNo'];
    $unreadsql = "UPDATE complaint_case SET case_status = :case_status, action_taken = :action_taken WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "Rejected",
        ':action_taken' => $exp,
        ':id' => $id

    ])) {
        $notifTitle = "Report Rejected";
        $notifMesg = "Report was successfully rejected. The report reference number is: " . $refNo;
        $notifTo = "DILG";
        $notifToType = "Barangay Secretary";
        $notifFrom = $cookieId;

        require './get-notif.php';
        $tab = "reject";
        $confirm = "yes";
        $message = "The report is successfully move to rejected table";
    }
}

if (isset($_POST['toPendingBtn'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE complaint_case SET case_status = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "Pending",
        ':id' => $id

    ])) {
        $tab = "pending";
        $confirm = "yes";
        $message = "The report is successfully retrieved";
    }
}
if (isset($_POST['toCompletedBtn'])) {
    $id = $_POST['id'];
    $dateToday = date("F j, Y, g:i a");
    $unreadsql = "UPDATE complaint_case SET case_status = :case_status, date_completed = :dc WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "Completed",
        ':dc' => $dateToday,
        ':id' => $id

    ])) {
        $tab = "completed";
        $confirm = "yes";
        $message = "The report is successfully completed";
    }
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
            <section id="list-count" class="mb-4">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center "><i class="fas fa-sticky-note fa-2x mr-3 icon5"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $pendingcountsql = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'report' AND case_status = 'pending'";
                                        $pendingcountstmt = $con->prepare($pendingcountsql);
                                        $pendingcountstmt->execute();
                                        $pendingcount = $pendingcountstmt->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount ?></h5>
                                        <small class="card-text">Pending Reports</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center "><i class="fas fa-sticky-note fa-2x mr-3 icon4"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $pendingcountsql1 = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'report' AND case_status = 'ongoing'";
                                        $pendingcountstmt1 = $con->prepare($pendingcountsql1);
                                        $pendingcountstmt1->execute();
                                        $pendingcount1 = $pendingcountstmt1->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount1 ?></h5>
                                        <small class="card-text">Ongoing Reports</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center "><i class="fas fa-sticky-note fa-2x mr-3 icon2"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $pendingcountsql2 = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'report' AND case_status = 'completed'";
                                        $pendingcountstmt2 = $con->prepare($pendingcountsql2);
                                        $pendingcountstmt2->execute();
                                        $pendingcount2 = $pendingcountstmt2->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount2 ?></h5>
                                        <small class="card-text">Completed Reports</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center "><i class="fas fa-sticky-note fa-2x mr-3 icon3"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $pendingcountsql3 = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'report' AND case_status = 'rejected'";
                                        $pendingcountstmt3 = $con->prepare($pendingcountsql3);
                                        $pendingcountstmt3->execute();
                                        $pendingcount3 = $pendingcountstmt3->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount3 ?></h5>
                                        <small class="card-text">Rejected Reports</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="table-section" class="mt-3">
                <div id="tableNavbar">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="mx-4 mt-3">List of Reports</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <a id="addBtn" class="add1 btn mx-4 mt-3 text-capitalize hvr-icon-spin" href="./service-report.page.php"><i class="fas fa-plus mr-2 hvr-icon"></i> Add New Report</a>
                        </div>
                    </div>
                    <div class="row mt-3 ml-4">
                        <div class="com-md-12">
                            <nav id="navSort">
                                <div class="nav sort" id="nav-tab" role="tablist">
                                    <a class="nav-item btnSort nav-link <?php if ($tab == "all") {
                                                                            echo "active";
                                                                        }  ?> px-4 mr-1" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="true"><span class="sortTitle">All</span></a>
                                    <a class="nav-item btnSort nav-link <?php if ($tab == "pending") {
                                                                            echo "active";
                                                                        }  ?> px-4 mr-1" id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab" aria-controls="nav-pending" aria-selected="false"><span class="sortTitle">Pending</span></a>
                                    <a class="nav-item btnSort nav-link <?php if ($tab == "ongoing") {
                                                                            echo "active";
                                                                        }  ?> px-4 mr-1" id="nav-ongoing-tab" data-toggle="tab" href="#nav-ongoing" role="tab" aria-controls="nav-ongoing" aria-selected="false"><span class="sortTitle">Ongoing</span></a>
                                    <a class="nav-item btnSort nav-link <?php if ($tab == "completed") {
                                                                            echo "active";
                                                                        }  ?> px-4 mr-1" id="nav-completed-tab" data-toggle="tab" href="#nav-completed" role="tab" aria-controls="nav-completed" aria-selected="false"><span class="sortTitle">Completed</span></a>
                                    <a class="nav-item btnSort nav-link <?php if ($tab == "reject") {
                                                                            echo "active";
                                                                        }  ?> px-4 mr-1" id="nav-reject-tab" data-toggle="tab" href="#nav-reject" role="tab" aria-controls="nav-reject" aria-selected="false"><span class="sortTitle">Rejected</span></a>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div id="tableContent" class="px-4 mb-4 py-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <div class="tab-content" id="nav-tabContent">
                                <!-- TABLE ALL -->
                                <div class="tab-pane fade <?php if ($tab == "all") {
                                                                echo "show active";
                                                            }  ?>" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table12312312" style="width: 100%">
                                        <thead class="">
                                            <tr class="text-center">
                                                <th>ID</th>
                                                <th scope="col">Reference Numbers</th>
                                                <th scope="col">Complainant</th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Picture</th>
                                                <th scope="col">Date of Submission</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'report' AND where_to = '$barangayName'";
                                            $showComplaintQuery = $con->query($showComplaintSql);
                                            foreach ($showComplaintQuery as $row) {
                                                $complaintId = $row['id'];
                                                $complaintRefNo = $row['case_ref_no'];
                                                $complaint = $row['complaint'];
                                                $complaintStatus = $row['case_status'];
                                                $complaintPic = $row['incident_pic'];
                                                $complaintDateSubmit = $row['date_submit'];


                                            ?>
                                                <tr>
                                                    <td><?php echo $complaintId ?> </td>
                                                    <td class="font-weight-bold"><?php echo $complaintRefNo ?> </td>
                                                    <td>
                                                        <?php
                                                        $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$complaintRefNo'";
                                                        $getComplainantQuery = $con->query($getComplainant);
                                                        foreach ($getComplainantQuery as $row2) {
                                                            $compId = $row2['comp_id'];

                                                            $getComplainant1 = "SELECT * FROM rbi WHERE id = '$compId'";
                                                            $getComplainantQuery1 = $con->query($getComplainant1);
                                                            foreach ($getComplainantQuery1 as $row3) {
                                                                $rbiFname = $row3['first_name'] . " " . $row3['middle_name'] . " " . $row3['last_name'];
                                                                $rbiHouseNo = $row3['house_no'];
                                                                $rbiBrgy = $row3['brgy'];
                                                                $rbiPurok = $row3['purok'];
                                                                $rbiAddress = $row3['comp_address'];
                                                                $rbiBday = $row3['birth_date'];
                                                                $rbiBplace = $row3['birth_place'];
                                                                $rbiGender = $row3['gender'];
                                                                $rbiCivStatus = $row3['civil_status'];
                                                                $rbiCitizenship = $row3['citizenship'];
                                                                $rbiOccup = $row3['occupation'];
                                                                $rbiRelToHead = $row3['relationship'];
                                                                $rbiContactNumber = $row3['contact_no'];
                                                                $rbiValiId = $row3['valid_id'];
                                                                $rbiExisting = $row3['is_existing'];


                                                                if ($rbiExisting != "outsider") {
                                                        ?>

                                                                    <a class="text-capitalize" href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?> </a>
                                                                    <br><small class='small'>(<?php echo $rbiBrgy  ?>) <?php if ($rbiExisting == "yes") {
                                                                                                                            echo '<span class="badge bg-success" style="font-size: 10.5px;">Verified</span>';
                                                                                                                        } elseif ($rbiExisting == "pending") {
                                                                                                                            echo '<span class="badge bg-warning" style="font-size: 10.5px;">Pending</span>';
                                                                                                                        } else {
                                                                                                                            echo '<span class="badge bg-danger" style="font-size: 10.5px;">Removed</span>';
                                                                                                                        } ?></small>
                                                                    <br>
                                                                <?php } else {
                                                                ?>
                                                                    <a class="text-capitalize" href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?>111</h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?></a>
                                                                    <br><small class='small'><span class="badge bg-danger" style="font-size: 10.5px;">Outsider</span></small>
                                                                    <br>

                                                        <?php
                                                                }
                                                            }
                                                        } ?>
                                                    </td>
                                                    <td class="text-capitalize">
                                                        <?php
                                                        $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
                                                        $getDefCountPrep = $con->prepare($getDefendant);
                                                        $getDefCountPrep->execute();
                                                        $getDefCount = $getDefCountPrep->rowCount();
                                                        if ($getDefCount > 0) {
                                                            $getDefendantQuery = $con->query($getDefendant);
                                                            foreach ($getDefendantQuery as $row2) {
                                                                $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                                                                $defPosition = $row2['position'];

                                                                echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                        ?>
                                                                <br>
                                                        <?php }
                                                        } else {
                                                            echo "--";
                                                        } ?>


                                                    </td>
                                                    <td><?php echo $complaint ?></td>
                                                    <td class="text-center"><span style="font-size: 12px; font-weight: bolder; padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                                                                        if ($complaintStatus == "Pending") {
                                                                                                                                                                                            echo "#49d97b";
                                                                                                                                                                                        } elseif ($complaintStatus == "Completed") {
                                                                                                                                                                                            echo "#fcb654";
                                                                                                                                                                                        } elseif ($complaintStatus == "Rejected") {
                                                                                                                                                                                            echo "#ed7469";
                                                                                                                                                                                        } elseif ($complaintStatus == "Ongoing") {
                                                                                                                                                                                            echo "#49d3d9";
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>"><?php echo $complaintStatus ?></span></td>

                                                    <td class="text-center">
                                                        <?php
                                                        if ($complaintPic == "none") {
                                                            echo "--";
                                                        } else {
                                                            echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $complaintDateSubmit ?></td>

                                                </tr>
                                            <?php

                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END TABLE ALL -->

                                <!-- TABLE PENDING -->
                                <div class="tab-pane fade <?php if ($tab == "pending") {
                                                                echo "show active";
                                                            }  ?>" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table2" style="width: 100%">

                                        <thead class="">
                                            <tr class="text-center">
                                                <th>ID</th>
                                                <th scope="col">Reference Numbers</th>
                                                <th scope="col">Complainant</th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Picture</th>
                                                <th scope="col">Date of Submission</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'report' AND case_status = 'Pending' AND where_to = '$barangayName'";
                                            $showComplaintQuery = $con->query($showComplaintSql);
                                            foreach ($showComplaintQuery as $row) {
                                                $complaintId = $row['id'];
                                                $complaintRefNo = $row['case_ref_no'];
                                                $complaint = $row['complaint'];
                                                $complaintStatus = $row['case_status'];
                                                $complaintPic = $row['incident_pic'];
                                                $complaintDateSubmit = $row['date_submit'];


                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $complaintId ?><input type="hidden" name="id" value="<?php echo $complaintId ?>" /> </td>
                                                        <td class="font-weight-bold"><?php echo $complaintRefNo ?><input type="hidden" name="compRefNo" value="<?php echo $complaintRefNo ?>" /> </td>
                                                        <td>
                                                            <?php
                                                            $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$complaintRefNo'";
                                                            $getComplainantQuery = $con->query($getComplainant);
                                                            foreach ($getComplainantQuery as $row2) {
                                                                $compId = $row2['comp_id'];

                                                                $getComplainant1 = "SELECT * FROM rbi WHERE id = '$compId'";
                                                                $getComplainantQuery1 = $con->query($getComplainant1);
                                                                foreach ($getComplainantQuery1 as $row3) {
                                                                    $rbiFname = $row3['first_name'] . " " . $row3['middle_name'] . " " . $row3['last_name'];
                                                                    $rbiHouseNo = $row3['house_no'];
                                                                    $rbiBrgy = $row3['brgy'];
                                                                    $rbiPurok = $row3['purok'];
                                                                    $rbiAddress = $row3['comp_address'];
                                                                    $rbiBday = $row3['birth_date'];
                                                                    $rbiBplace = $row3['birth_place'];
                                                                    $rbiGender = $row3['gender'];
                                                                    $rbiCivStatus = $row3['civil_status'];
                                                                    $rbiCitizenship = $row3['citizenship'];
                                                                    $rbiOccup = $row3['occupation'];
                                                                    $rbiRelToHead = $row3['relationship'];
                                                                    $rbiContactNumber = $row3['contact_no'];
                                                                    $rbiValiId = $row3['valid_id'];
                                                                    $rbiExisting = $row3['is_existing'];


                                                                    if ($rbiExisting != "outsider") {
                                                            ?>

                                                                        <a class="text-capitalize" href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?> </a>
                                                                        <br><small class='small'>(<?php echo $rbiBrgy  ?>) <?php if ($rbiExisting == "yes") {
                                                                                                                                echo '<span class="badge bg-success" style="font-size: 10.5px;">Verified</span>';
                                                                                                                            } elseif ($rbiExisting == "pending") {
                                                                                                                                echo '<span class="badge bg-warning" style="font-size: 10.5px;">Pending</span>';
                                                                                                                            } else {
                                                                                                                                echo '<span class="badge bg-danger" style="font-size: 10.5px;">Removed</span>';
                                                                                                                            } ?></small>
                                                                        <br>
                                                                    <?php } else {
                                                                    ?>
                                                                        <a class="text-capitalize" href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?>111</h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?></a>
                                                                        <br><small class='small'><span class="badge bg-danger" style="font-size: 10.5px;">Outsider</span></small>
                                                                        <br>

                                                            <?php
                                                                    }
                                                                }
                                                            } ?>
                                                        </td>
                                                        <td class="text-capitalize">
                                                            <?php
                                                            $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
                                                            $getDefCountPrep = $con->prepare($getDefendant);
                                                            $getDefCountPrep->execute();
                                                            $getDefCount = $getDefCountPrep->rowCount();
                                                            if ($getDefCount > 0) {
                                                                $getDefendantQuery = $con->query($getDefendant);
                                                                foreach ($getDefendantQuery as $row2) {
                                                                    $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                                                                    $defPosition = $row2['position'];

                                                                    echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                            ?>
                                                                    <br>
                                                            <?php }
                                                            } else {
                                                                echo "--";
                                                            } ?>

                                                        </td>
                                                        <td><?php echo $complaint ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($complaintPic == "none") {
                                                                echo "--";
                                                            } else {
                                                                echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center"><?php echo $complaintDateSubmit ?></td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <button class="add btn hvr-pulse-grow" type="submit" name="toOngoingBtn"><i class="fas fa-check"></i></button>
                                                                <button class="add btn btn-danger rejectBtn hvr-pulse-grow" type="button" onclick="return confirm('Are you sure want to reject this report?')"><i class="fas fa-times"></i></button>
                                                            </div>

                                                        </td>
                                                    </form>
                                                </tr>

                                            <?php

                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal for reject (PENDING TABLE) -->
                                <div class="modal fade bd-example-modal-lg" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content p-4">
                                            <div class="modal-header">
                                                <div>
                                                    <h4 class="modal-title" id="myModalLabel">Reject Complaint</h4>
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
                                                    <input type="hidden" id="complaintId123" name="id" />
                                                    <input type="hidden" id="compRefNo123" name="compRefNo" />
                                                    <p class="mt-3 mb-2"><span class="font-weight-bold">Reference Number:</span> <span id="refNumber123"></span></p>
                                                    <p class="font-weight-bold mb-2">Complaint: <span id="compComplaint123" class="font-weight-light"></span></p>
                                                    <div class="complaintDiv mt-4">
                                                        <h6 class="font-weight-bolder">Give an explanation why this complaint is rejected</h6>
                                                        <textarea class="form-control" id="rejectExp" name="rejectExp" placeholder="Tell us what happened" rows="3" required></textarea>

                                                    </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btnAccept text-capitalize" name="toRejectedBtn">Reject</button>
                                                </form>
                                                <button type="button" class="btn btn-danger text-capitalize" data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END OF MODAL -->
                                <!-- END OF TABLE PENDING -->

                                <!-- TABLE ONGOING -->
                                <div class="tab-pane fade <?php if ($tab == "ongoing") {
                                                                echo "show active";
                                                            }  ?>" id="nav-ongoing" role="tabpanel" aria-labelledby="nav-ongoing-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table3" style="width: 100%">
                                        <thead class="">
                                            <tr class="text-center">
                                                <th>ID</th>
                                                <th scope="col">Reference Numbers</th>
                                                <th scope="col">Complainant</th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Picture</th>
                                                <th scope="col">Date of Submission</th>
                                                <th scope="col">Done</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'report' AND case_status = 'Ongoing' AND where_to = '$barangayName'";
                                            $showComplaintQuery = $con->query($showComplaintSql);
                                            foreach ($showComplaintQuery as $row) {
                                                $complaintId = $row['id'];
                                                $complaintRefNo = $row['case_ref_no'];
                                                $complaint = $row['complaint'];
                                                $complaintStatus = $row['case_status'];
                                                $complaintPic = $row['incident_pic'];
                                                $complaintDateSubmit = $row['date_submit'];


                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $complaintId ?><input type="hidden" name="id" value="<?php echo $complaintId ?>" /></td>
                                                        <td class="font-weight-bold"><?php echo $complaintRefNo ?> </td>
                                                        <td>
                                                            <?php
                                                            $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$complaintRefNo'";
                                                            $getComplainantQuery = $con->query($getComplainant);
                                                            foreach ($getComplainantQuery as $row2) {
                                                                $compId = $row2['comp_id'];

                                                                $getComplainant1 = "SELECT * FROM rbi WHERE id = '$compId'";
                                                                $getComplainantQuery1 = $con->query($getComplainant1);
                                                                foreach ($getComplainantQuery1 as $row3) {
                                                                    $rbiFname = $row3['first_name'] . " " . $row3['middle_name'] . " " . $row3['last_name'];
                                                                    $rbiHouseNo = $row3['house_no'];
                                                                    $rbiBrgy = $row3['brgy'];
                                                                    $rbiPurok = $row3['purok'];
                                                                    $rbiAddress = $row3['comp_address'];
                                                                    $rbiBday = $row3['birth_date'];
                                                                    $rbiBplace = $row3['birth_place'];
                                                                    $rbiGender = $row3['gender'];
                                                                    $rbiCivStatus = $row3['civil_status'];
                                                                    $rbiCitizenship = $row3['citizenship'];
                                                                    $rbiOccup = $row3['occupation'];
                                                                    $rbiRelToHead = $row3['relationship'];
                                                                    $rbiContactNumber = $row3['contact_no'];
                                                                    $rbiValiId = $row3['valid_id'];
                                                                    $rbiExisting = $row3['is_existing'];


                                                                    if ($rbiExisting != "outsider") {
                                                            ?>

                                                                        <a class="text-capitalize" href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?> </a>
                                                                        <br><small class='small'>(<?php echo $rbiBrgy  ?>) <?php if ($rbiExisting == "yes") {
                                                                                                                                echo '<span class="badge bg-success" style="font-size: 10.5px;">Verified</span>';
                                                                                                                            } elseif ($rbiExisting == "pending") {
                                                                                                                                echo '<span class="badge bg-warning" style="font-size: 10.5px;">Pending</span>';
                                                                                                                            } else {
                                                                                                                                echo '<span class="badge bg-danger" style="font-size: 10.5px;">Removed</span>';
                                                                                                                            } ?></small>
                                                                        <br>
                                                                    <?php } else {
                                                                    ?>
                                                                        <a class="text-capitalize" href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?>111</h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?></a>
                                                                        <br><small class='small'><span class="badge bg-danger" style="font-size: 10.5px;">Outsider</span></small>
                                                                        <br>

                                                            <?php
                                                                    }
                                                                }
                                                            } ?>
                                                        </td>
                                                        <td class="text-capitalize">
                                                            <?php
                                                            $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
                                                            $getDefCountPrep = $con->prepare($getDefendant);
                                                            $getDefCountPrep->execute();
                                                            $getDefCount = $getDefCountPrep->rowCount();
                                                            if ($getDefCount > 0) {
                                                                $getDefendantQuery = $con->query($getDefendant);
                                                                foreach ($getDefendantQuery as $row2) {
                                                                    $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                                                                    $defPosition = $row2['position'];

                                                                    echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                            ?>
                                                                    <br>
                                                            <?php }
                                                            } else {
                                                                echo "--";
                                                            } ?>

                                                        </td>
                                                        <td><?php echo $complaint ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($complaintPic == "none") {
                                                                echo "--";
                                                            } else {
                                                                echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center"><?php echo $complaintDateSubmit ?></td>
                                                        <td class="text-center"><button class="add btn hvr-pulse-grow" type="submit" name="toCompletedBtn" onclick="return confirm('Do you want to retrieve this report?')"><i class="fas fa-check"></i></button></td>
                                                    </form>
                                                </tr>

                                            <?php

                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END OF TABLE ONGOING -->

                                <!-- TABLE COMPLETED -->
                                <div class="tab-pane fade <?php if ($tab == "completed") {
                                                                echo "show active";
                                                            }  ?>" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table4" style="width: 100%">

                                        <thead class="">
                                            <tr class="text-center">
                                                <th>ID </th>
                                                <th scope="col">Reference Numbers </th>
                                                <th scope="col">Complainant </th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Picture</th>
                                                <th scope="col">Date Submitted</th>
                                                <th scope="col">Date Completed</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'report' AND case_status = 'Completed' AND where_to = '$barangayName'";
                                            $showComplaintQuery = $con->query($showComplaintSql);
                                            foreach ($showComplaintQuery as $row) {
                                                $complaintId = $row['id'];
                                                $complaintRefNo = $row['case_ref_no'];
                                                $complaint = $row['complaint'];
                                                $complaintStatus = $row['case_status'];
                                                $complaintPic = $row['incident_pic'];
                                                $complaintDateSubmit = $row['date_submit'];
                                                $complaintDateCompleted = $row['date_completed'];


                                            ?>
                                                <tr>
                                                    <td><?php echo $complaintId ?> </td>
                                                    <td class="font-weight-bold"><?php echo $complaintRefNo ?> </td>
                                                    <td>
                                                        <?php
                                                        $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$complaintRefNo'";
                                                        $getComplainantQuery = $con->query($getComplainant);
                                                        foreach ($getComplainantQuery as $row2) {
                                                            $compId = $row2['comp_id'];

                                                            $getComplainant1 = "SELECT * FROM rbi WHERE id = '$compId'";
                                                            $getComplainantQuery1 = $con->query($getComplainant1);
                                                            foreach ($getComplainantQuery1 as $row3) {
                                                                $rbiFname = $row3['first_name'] . " " . $row3['middle_name'] . " " . $row3['last_name'];
                                                                $rbiHouseNo = $row3['house_no'];
                                                                $rbiBrgy = $row3['brgy'];
                                                                $rbiPurok = $row3['purok'];
                                                                $rbiAddress = $row3['comp_address'];
                                                                $rbiBday = $row3['birth_date'];
                                                                $rbiBplace = $row3['birth_place'];
                                                                $rbiGender = $row3['gender'];
                                                                $rbiCivStatus = $row3['civil_status'];
                                                                $rbiCitizenship = $row3['citizenship'];
                                                                $rbiOccup = $row3['occupation'];
                                                                $rbiRelToHead = $row3['relationship'];
                                                                $rbiContactNumber = $row3['contact_no'];
                                                                $rbiValiId = $row3['valid_id'];
                                                                $rbiExisting = $row3['is_existing'];


                                                                if ($rbiExisting != "outsider") {
                                                        ?>

                                                                    <a class="text-capitalize" href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?> </a>
                                                                    <br><small class='small'>(<?php echo $rbiBrgy  ?>) <?php if ($rbiExisting == "yes") {
                                                                                                                            echo '<span class="badge bg-success" style="font-size: 10.5px;">Verified</span>';
                                                                                                                        } elseif ($rbiExisting == "pending") {
                                                                                                                            echo '<span class="badge bg-warning" style="font-size: 10.5px;">Pending</span>';
                                                                                                                        } else {
                                                                                                                            echo '<span class="badge bg-danger" style="font-size: 10.5px;">Removed</span>';
                                                                                                                        } ?></small>
                                                                    <br>
                                                                <?php } else {
                                                                ?>
                                                                    <a class="text-capitalize" href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?>111</h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?></a>
                                                                    <br><small class='small'><span class="badge bg-danger" style="font-size: 10.5px;">Outsider</span></small>
                                                                    <br>

                                                        <?php
                                                                }
                                                            }
                                                        } ?>
                                                    </td>
                                                    <td class="text-capitalize">
                                                        <?php
                                                        $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
                                                        $getDefCountPrep = $con->prepare($getDefendant);
                                                        $getDefCountPrep->execute();
                                                        $getDefCount = $getDefCountPrep->rowCount();
                                                        if ($getDefCount > 0) {
                                                            $getDefendantQuery = $con->query($getDefendant);
                                                            foreach ($getDefendantQuery as $row2) {
                                                                $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                                                                $defPosition = $row2['position'];

                                                                echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                        ?>
                                                                <br>
                                                        <?php }
                                                        } else {
                                                            echo "--";
                                                        } ?>

                                                    </td>
                                                    <td><?php echo $complaint ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        if ($complaintPic == "none") {
                                                            echo "--";
                                                        } else {
                                                            echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $complaintDateSubmit ?></td>
                                                    <td class="text-center"><?php echo $complaintDateCompleted ?></td>
                                                </tr>
                                            <?php

                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END OF TABLE COMPLETED -->

                                <!-- TABLE REJECT -->
                                <div class="tab-pane fade <?php if ($tab == "reject") {
                                                                echo "show active";
                                                            }  ?>" id="nav-reject" role="tabpanel" aria-labelledby="nav-reject-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table5" style="width: 100%">
                                        <thead class="">
                                            <tr class="text-center">
                                                <th>ID</th>
                                                <th scope="col">Reference Numbers</th>
                                                <th scope="col">Complainant</th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Explanation</th>
                                                <th scope="col">Picture</th>
                                                <th scope="col">Date of Submission</th>
                                                <th scope="col">Retrieve</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'report' AND case_status = 'Rejected' AND where_to = '$barangayName'";
                                            $showComplaintQuery = $con->query($showComplaintSql);
                                            foreach ($showComplaintQuery as $row) {
                                                $complaintId = $row['id'];
                                                $complaintRefNo = $row['case_ref_no'];
                                                $complaint = $row['complaint'];
                                                $complaintExp = $row['action_taken'];
                                                $complaintStatus = $row['case_status'];
                                                $complaintPic = $row['incident_pic'];
                                                $complaintDateSubmit = $row['date_submit'];



                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $complaintId ?><input type="hidden" name="id" value="<?php echo $complaintId ?>" /></td>
                                                        <td class="font-weight-bold"><?php echo $complaintRefNo ?> </td>
                                                        <td>
                                                            <?php
                                                            $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$complaintRefNo'";
                                                            $getComplainantQuery = $con->query($getComplainant);
                                                            foreach ($getComplainantQuery as $row2) {
                                                                $compId = $row2['comp_id'];

                                                                $getComplainant1 = "SELECT * FROM rbi WHERE id = '$compId'";
                                                                $getComplainantQuery1 = $con->query($getComplainant1);
                                                                foreach ($getComplainantQuery1 as $row3) {
                                                                    $rbiFname = $row3['first_name'] . " " . $row3['middle_name'] . " " . $row3['last_name'];
                                                                    $rbiHouseNo = $row3['house_no'];
                                                                    $rbiBrgy = $row3['brgy'];
                                                                    $rbiPurok = $row3['purok'];
                                                                    $rbiAddress = $row3['comp_address'];
                                                                    $rbiBday = $row3['birth_date'];
                                                                    $rbiBplace = $row3['birth_place'];
                                                                    $rbiGender = $row3['gender'];
                                                                    $rbiCivStatus = $row3['civil_status'];
                                                                    $rbiCitizenship = $row3['citizenship'];
                                                                    $rbiOccup = $row3['occupation'];
                                                                    $rbiRelToHead = $row3['relationship'];
                                                                    $rbiContactNumber = $row3['contact_no'];
                                                                    $rbiValiId = $row3['valid_id'];
                                                                    $rbiExisting = $row3['is_existing'];


                                                                    if ($rbiExisting != "outsider") {
                                                            ?>

                                                                        <a class="text-capitalize" href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?> </a>
                                                                        <br><small class='small'>(<?php echo $rbiBrgy  ?>) <?php if ($rbiExisting == "yes") {
                                                                                                                                echo '<span class="badge bg-success" style="font-size: 10.5px;">Verified</span>';
                                                                                                                            } elseif ($rbiExisting == "pending") {
                                                                                                                                echo '<span class="badge bg-warning" style="font-size: 10.5px;">Pending</span>';
                                                                                                                            } else {
                                                                                                                                echo '<span class="badge bg-danger" style="font-size: 10.5px;">Removed</span>';
                                                                                                                            } ?></small>
                                                                        <br>
                                                                    <?php } else {
                                                                    ?>
                                                                        <a class="text-capitalize" href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?>111</h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?></a>
                                                                        <br><small class='small'><span class="badge bg-danger" style="font-size: 10.5px;">Outsider</span></small>
                                                                        <br>

                                                            <?php
                                                                    }
                                                                }
                                                            } ?>
                                                        </td>
                                                        <td class="text-capitalize">
                                                            <?php
                                                            $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
                                                            $getDefCountPrep = $con->prepare($getDefendant);
                                                            $getDefCountPrep->execute();
                                                            $getDefCount = $getDefCountPrep->rowCount();
                                                            if ($getDefCount > 0) {
                                                                $getDefendantQuery = $con->query($getDefendant);
                                                                foreach ($getDefendantQuery as $row2) {
                                                                    $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                                                                    $defPosition = $row2['position'];

                                                                    echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                            ?>
                                                                    <br>
                                                            <?php }
                                                            } else {
                                                                echo "--";
                                                            } ?>

                                                        </td>
                                                        <td><?php echo $complaint ?></td>
                                                        <td><?php echo $complaintExp ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($complaintPic == "none") {
                                                                echo "--";
                                                            } else {
                                                                echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center"><?php echo $complaintDateSubmit ?></td>
                                                        <td class="text-center"><button class="add btn hvr-pulse-grow" type="submit" name="toPendingBtn" onclick="return confirm('Do you want to retrieve this report?')"><i class="fas fa-arrow-left"></i></button></td>
                                                    </form>
                                                </tr>

                                            <?php

                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END OF TABLE REJECTED -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
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
                "lengthChange": false,
                "columnDefs": [{
                        // DISABLE SORT
                        "targets": [2, 3],
                        "orderable": false
                    },
                    {
                        // DISABLE SEARCH
                        "searchable": false,
                        "targets": [0, 4, 5, 6, 7]
                    }
                ]
            });


            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            table.$("[data-toggle=popover]").popover().click(function(e) {
                e.preventDefault();
            });


            $('.rejectBtn').on('click', function() {
                $('#rejectModal').modal('show');

                $tr = $(this).closest('tr');

                var tddata = $tr.children("td").map(function() {
                    return $(this).text();

                }).get();

                $('#complaintId123').val(tddata[0]);
                $('#compRefNo123').val(tddata[1]);
                $('#refNumber123').text(tddata[1]);
                $('#compComplaint123').text(tddata[4]);
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
            // Enables popover
            $("[data-toggle=popover]").popover();
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