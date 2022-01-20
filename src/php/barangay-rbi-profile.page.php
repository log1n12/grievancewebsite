<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$titleHeader = "Records of Barangay Inhabitants";
$message = "";
$rbiId = "";

if (isset($_GET['rbiid'])) {
    $rbiId = $_GET['rbiid'];
    $showRBISql = "SELECT * FROM rbi WHERE id = '$rbiId'";
    $showRBIstmt = $con->prepare($showRBISql);
    $showRBIstmt->execute();
    $count = $showRBIstmt->rowCount();

    if ($count > 0) {
        $showRBIquery = $con->query($showRBISql);
        foreach ($showRBIquery as $row) {
            $rbiFirstname = $row['first_name'];
            $rbiLastname = $row['last_name'];
            $rbiMiddlename = $row['middle_name'];
            $rbiFname1 = $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'];
            $rbiHouseNo = $row['house_no'];
            $rbiBrgy = $row['brgy'];
            $rbiPurok = $row['purok'];
            $rbiAddress = $row['comp_address'];
            $rbiBday = $row['birth_date'];
            $rbiBplace = $row['birth_place'];
            $rbiGender = $row['gender'];
            $rbiCivStatus = $row['civil_status'];
            $rbiCitizenship = $row['citizenship'];
            $rbiOccup = $row['occupation'];
            $rbiRelToHead = $row['relationship'];
            $rbiContactNumber = $row['contact_no'];
            $rbiValidId = $row['valid_id'];
            $verify = $row['is_existing'];

            if ($rbiBrgy != $barangayName) {
                header("location:barangay-rbi.page.php");
            }
        }
    } else {
        header("location:barangay-rbi.page.php");
    }
} else {
    header("location:barangay-rbi.page.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/barangay-admin.style.css">

    <title>Document</title>
</head>

<body>
    <?php include './navbar/barangay.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/barangay.navbar-top.php' ?>
        <div class="transition px-5">
            <?php
            //SHOW ALERT MESSAGE 
            if ($message != "") {
                echo '<div class="alert alert-dismissible fade show" role="alert">
				<strong>Hey! </strong>' . $message .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>';
            }
            ?>
            <section id="table-section" class="mb-4 py-4">
                <div id="tableNavbar">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="./barangay-rbi.page.php" class="text-center mx-auto d-block  mt-5">Go back to the table</a>
                            <img src="../assets/<?php echo $rbiValidId; ?>" class="img-fluid mx-auto d-block mt-2" alt="Responsive image">
                            <h2 class="text-center text-capitalize"><?php echo strtolower($rbiFname1); ?></h2>
                            <h1 class="mx-auto d-block isVerify mb-5" style="background-color: <?php
                                                                                                if ($verify == 'yes') {
                                                                                                    echo '#49d97b;';
                                                                                                } elseif ($verify == 'pending') {
                                                                                                    echo '#fcb654;';
                                                                                                } else {
                                                                                                    echo '#ed7469;';
                                                                                                }
                                                                                                ?>"><?php
                                                                                                    if ($verify == 'yes') {
                                                                                                        echo 'Verified <i class="fas fa-check ml-2"></i>';
                                                                                                    } elseif ($verify == 'pending') {
                                                                                                        echo 'Pending <i class="fas fa-times ml-2"></i>';
                                                                                                    } else {
                                                                                                        echo 'Not Verified <i class="fas fa-times ml-2"></i>';
                                                                                                    }
                                                                                                    ?></h1>
                        </div>
                    </div>
                </div>
                <div id="tableContent" class="table-responsive px-4">
                    <div class="bio-graph-heading my-5">
                        Personal Information
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="bio-row">
                                <p class="text-capitalize"><span>Name </span>: <?php echo strtolower($rbiFname1); ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>House Number </span>: <?php echo $rbiHouseNo; ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Purok </span>: <?php echo $rbiPurok; ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Address </span>: <?php echo $rbiAddress; ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Birth Date</span>: <?php echo $rbiBday; ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Birth Place </span>: <?php echo $rbiBplace; ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Gender </span>: <?php echo $rbiGender; ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Civil Status </span>: <?php echo $rbiCivStatus; ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Citizenship </span>: <?php echo $rbiCitizenship; ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Occupation </span>: <?php echo $rbiOccup; ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Relationship to Head </span>: <?php echo $rbiRelToHead; ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Contact Number </span>: <?php echo $rbiContactNumber; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="complaintContent">
                        <div class="bio-graph-heading mt-5">
                            Complaint Records
                        </div>
                        <div class="row my-3 ml-4">
                            <div class="com-md-12">
                                <nav id="complaintNavSort">
                                    <div class="nav sort" id="nav-tab" role="tablist">
                                        <a class="nav-item btnSort nav-link active px-4 mr-1" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="true"><span class="sortTitle">Complainant</span></a>
                                        <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab" aria-controls="nav-pending" aria-selected="false"><span class="sortTitle">Respondent</span></a>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <!-- Complainant table for complaint records -->
                            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                                <table class="table table1 table-hover text-center" id="table12" style="width: 100%">

                                    <thead class="">
                                        <tr>
                                            <th>ID</th>
                                            <th scope="col">Reference Numbers</th>
                                            <th scope="col">Complainant</i></th>
                                            <th scope="col">Defendant</th>
                                            <th scope="col">Complaint</th>
                                            <th scope="col">Status</i></th>
                                            <th scope="col">Picture</th>
                                            <th scope="col">Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        //GET CASES OF USER TO COMPLAINANT TABLE
                                        //GET THE REF NUMBER
                                        //CHECK THE REF NUMBER AND COMPLAINT TYPE IN COMPLAINT CASE TABLE

                                        $getComplaintSql = "SELECT * FROM complainant WHERE comp_id = '$rbiId'";
                                        $getComplaintQuery = $con->query($getComplaintSql);
                                        foreach ($getComplaintQuery as $row) {
                                            $caseRefNo = $row['case_ref_no'];

                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE case_ref_no = '$caseRefNo' AND complaint_type = 'complaint'";
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
                                                        $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$caseRefNo'";
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


                                                        ?>
                                                                <?php
                                                                if ($rbiFname == $rbiFname1) {
                                                                    echo "<span class='font-weight-bold'> <u>" . $rbiFname . "</u></span>";
                                                                } else {
                                                                    echo $rbiFname;
                                                                }
                                                                ?>
                                                                <br><small class='small'>(<?php echo $rbiBrgy ?>)</small>
                                                                <br>
                                                        <?php }
                                                        } ?>
                                                    </td>

                                                    <td class="text-uppercase">
                                                        <?php
                                                        $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$caseRefNo'";
                                                        $getDefCountPrep = $con->prepare($getDefendant);
                                                        $getDefCountPrep->execute();
                                                        $getDefCount = $getDefCountPrep->rowCount();
                                                        if ($getDefCount > 0) {
                                                            $getDefendantQuery = $con->query($getDefendant);
                                                            foreach ($getDefendantQuery as $row2) {
                                                                $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                                                                $defPosition = $row2['position'];

                                                                echo $defFullname . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                        ?>
                                                                <br>
                                                        <?php }
                                                        } else {
                                                            echo "--";
                                                        } ?>

                                                    </td>
                                                    <td><?php echo $complaint ?></td>
                                                    <td><span style="font-size: 12px; font-weight: bolder; padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                                                    if ($complaintStatus == "Pending") {
                                                                                                                                                                        echo "#49d97b";
                                                                                                                                                                    } elseif ($complaintStatus == "Payment") {
                                                                                                                                                                        echo "#b693e2";
                                                                                                                                                                    } elseif ($complaintStatus == "Ongoing") {
                                                                                                                                                                        echo "#49d3d9";
                                                                                                                                                                    } elseif ($complaintStatus == "Completed") {
                                                                                                                                                                        echo "#fcb654";
                                                                                                                                                                    } elseif ($complaintStatus == "Rejected") {
                                                                                                                                                                        echo "#ed7469";
                                                                                                                                                                    }
                                                                                                                                                                    ?>"><?php echo $complaintStatus ?></span></td>
                                                    <td>
                                                        <?php
                                                        if ($complaintPic == "none") {
                                                            echo "--";
                                                        } else {
                                                            echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $complaintDateSubmit ?></td>

                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </tbody>


                                </table>
                            </div>
                            <!-- End of complainant table -->

                            <!-- Respondent table for complaint records -->
                            <div class="tab-pane fade" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                                <table class="table table1 table-hover text-center" id="table13" style="width: 100%">

                                    <thead class="">
                                        <tr>
                                            <th>ID</th>
                                            <th scope="col">Reference Numbers</th>
                                            <th scope="col">Complainant</i></th>
                                            <th scope="col">Defendant</th>
                                            <th scope="col">Complaint</th>
                                            <th scope="col">Status</i></th>
                                            <th scope="col">Picture</th>
                                            <th scope="col">Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //kunin yung pangalan sa defendant table
                                        //kunin yung case ref no
                                        //kunin yung complaint case
                                        //kunin yung complainant

                                        $getDefendantSql = "SELECT * FROM defendant WHERE first_name = '$rbiFirstname' AND last_name = '$rbiLastname' AND middle_name = '$rbiMiddlename'";
                                        $getDefendantQuery = $con->query($getDefendantSql);
                                        foreach ($getDefendantQuery as $row3) {
                                            $caseRefNo = $row3['case_ref_no'];

                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE case_ref_no = '$caseRefNo' AND complaint_type = 'complaint'";
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
                                                        $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$caseRefNo'";
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


                                                        ?>
                                                                <?php echo $rbiFname ?>
                                                                <br><small class='small'>(<?php echo $rbiBrgy ?>)</small>
                                                                <br>
                                                        <?php }
                                                        } ?>
                                                    </td>

                                                    <td class="text-uppercase">
                                                        <?php
                                                        $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$caseRefNo'";
                                                        $getDefCountPrep = $con->prepare($getDefendant);
                                                        $getDefCountPrep->execute();
                                                        $getDefCount = $getDefCountPrep->rowCount();
                                                        if ($getDefCount > 0) {
                                                            $getDefendantQuery = $con->query($getDefendant);
                                                            foreach ($getDefendantQuery as $row2) {
                                                                $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                                                                $defPosition = $row2['position'];


                                                                if (strtoupper($defFullname) == strtoupper($rbiFname1)) {
                                                                    echo "<span class='font-weight-bold'> <u>" . $defFullname . "</u></span>" . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                                } else {
                                                                    echo $defFullname . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                                }
                                                        ?>
                                                                <br>
                                                        <?php }
                                                        } else {
                                                            echo "--";
                                                        } ?>

                                                    </td>
                                                    <td><?php echo $complaint ?></td>
                                                    <td><span style="font-size: 12px; font-weight: bolder; padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                                                    if ($complaintStatus == "Pending") {
                                                                                                                                                                        echo "#49d97b";
                                                                                                                                                                    } elseif ($complaintStatus == "Payment") {
                                                                                                                                                                        echo "#b693e2";
                                                                                                                                                                    } elseif ($complaintStatus == "Ongoing") {
                                                                                                                                                                        echo "#49d3d9";
                                                                                                                                                                    } elseif ($complaintStatus == "Completed") {
                                                                                                                                                                        echo "#fcb654";
                                                                                                                                                                    } elseif ($complaintStatus == "Rejected") {
                                                                                                                                                                        echo "#ed7469";
                                                                                                                                                                    }
                                                                                                                                                                    ?>"><?php echo $complaintStatus ?></span></td>
                                                    <td>
                                                        <?php
                                                        if ($complaintPic == "none") {
                                                            echo "--";
                                                        } else {
                                                            echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $complaintDateSubmit ?></td>

                                                </tr>

                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- End of respodentn table -->
                        </div>

                        <!-- REPORT CONTENT -->

                        <div class="reportContent mb-5">
                            <div class="bio-graph-heading mt-5">
                                Report Records
                            </div>
                            <div class="row my-3 ml-4">
                                <div class="com-md-12">
                                    <nav id="reportNavSort">
                                        <div class="nav sort" id="nav-tab" role="tablist">
                                            <a class="nav-item btnSort nav-link active px-4 mr-1" id="nav-all-tab1" data-toggle="tab" href="#nav-all1" role="tab" aria-controls="nav-all1" aria-selected="true"><span class="sortTitle">Complainant</span></a>
                                            <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-pending-tab1" data-toggle="tab" href="#nav-pending1" role="tab" aria-controls="nav-pending1" aria-selected="false"><span class="sortTitle">Respondent</span></a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div class="tab-content" id="nav-tabContent">

                                <!-- REPORT COMPLAINANT TABLE -->
                                <div class="tab-pane fade show active" id="nav-all1" role="tabpanel" aria-labelledby="nav-all-tab1">
                                    <table class="table table1 table-hover text-center" id="table3" style="width: 100%">

                                        <thead class="">
                                            <tr>
                                                <th>ID</th>
                                                <th scope="col">Reference Numbers</th>
                                                <th scope="col">Complainant</i></th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Status</i></th>
                                                <th scope="col">Picture</th>
                                                <th scope="col">Date</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            //GET CASES OF USER TO COMPLAINANT TABLE
                                            //GET THE REF NUMBER
                                            //CHECK THE REF NUMBER AND COMPLAINT TYPE IN COMPLAINT CASE TABLE

                                            $getComplaintSql = "SELECT * FROM complainant WHERE comp_id = '$rbiId'";
                                            $getComplaintQuery = $con->query($getComplaintSql);
                                            foreach ($getComplaintQuery as $row) {
                                                $caseRefNo = $row['case_ref_no'];

                                                $showComplaintSql = "SELECT * FROM complaint_case WHERE case_ref_no = '$caseRefNo' AND complaint_type = 'report'";
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
                                                            $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$caseRefNo'";
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


                                                            ?>
                                                                    <?php
                                                                    if ($rbiFname == $rbiFname1) {
                                                                        echo "<span class='font-weight-bold'> <u>" . $rbiFname . "</u></span>";
                                                                    } else {
                                                                        echo $rbiFname;
                                                                    }
                                                                    ?>
                                                                    <br><small class='small'>(<?php echo $rbiBrgy ?>)</small>
                                                                    <br>
                                                            <?php }
                                                            } ?>
                                                        </td>

                                                        <td class="text-uppercase">
                                                            <?php
                                                            $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$caseRefNo'";
                                                            $getDefCountPrep = $con->prepare($getDefendant);
                                                            $getDefCountPrep->execute();
                                                            $getDefCount = $getDefCountPrep->rowCount();
                                                            if ($getDefCount > 0) {
                                                                $getDefendantQuery = $con->query($getDefendant);
                                                                foreach ($getDefendantQuery as $row2) {
                                                                    $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                                                                    $defPosition = $row2['position'];

                                                                    echo $defFullname . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                            ?>
                                                                    <br>
                                                            <?php }
                                                            } else {
                                                                echo "--";
                                                            } ?>

                                                        </td>
                                                        <td><?php echo $complaint ?></td>
                                                        <td><span style="font-size: 12px; font-weight: bolder; padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                                                        if ($complaintStatus == "Pending") {
                                                                                                                                                                            echo "#49d97b";
                                                                                                                                                                        } elseif ($complaintStatus == "Payment") {
                                                                                                                                                                            echo "#b693e2";
                                                                                                                                                                        } elseif ($complaintStatus == "Ongoing") {
                                                                                                                                                                            echo "#49d3d9";
                                                                                                                                                                        } elseif ($complaintStatus == "Completed") {
                                                                                                                                                                            echo "#fcb654";
                                                                                                                                                                        } elseif ($complaintStatus == "Rejected") {
                                                                                                                                                                            echo "#ed7469";
                                                                                                                                                                        }
                                                                                                                                                                        ?>"><?php echo $complaintStatus ?></span></td>
                                                        <td>
                                                            <?php
                                                            if ($complaintPic == "none") {
                                                                echo "--";
                                                            } else {
                                                                echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $complaintDateSubmit ?></td>

                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>

                                        </tbody>


                                    </table>
                                </div>
                                <!-- END OF REPORT COMPLAINANT TABLE -->

                                <!-- REPORT RESPONDENT TABLE -->
                                <div class="tab-pane fade" id="nav-pending1" role="tabpanel" aria-labelledby="nav-pending-tab1">
                                    <table class="table table1 table-hover text-center" id="table4" style="width: 100%">

                                        <thead class="">
                                            <tr>
                                                <th>ID</th>
                                                <th scope="col">Reference Numbers</th>
                                                <th scope="col">Complainant</i></th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Status</i></th>
                                                <th scope="col">Picture</th>
                                                <th scope="col">Date</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //kunin yung pangalan sa defendant table
                                            //kunin yung case ref no
                                            //kunin yung complaint case
                                            //kunin yung complainant

                                            $getDefendantSql = "SELECT * FROM defendant WHERE first_name = '$rbiFirstname' AND last_name = '$rbiLastname' AND middle_name = '$rbiMiddlename'";
                                            $getDefendantQuery = $con->query($getDefendantSql);
                                            foreach ($getDefendantQuery as $row3) {
                                                $caseRefNo = $row3['case_ref_no'];

                                                $showComplaintSql = "SELECT * FROM complaint_case WHERE case_ref_no = '$caseRefNo' AND complaint_type = 'report'";
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
                                                            $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$caseRefNo'";
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


                                                            ?>
                                                                    <?php echo $rbiFname ?>
                                                                    <br><small class='small'>(<?php echo $rbiBrgy ?>)</small>
                                                                    <br>
                                                            <?php }
                                                            } ?>
                                                        </td>

                                                        <td class="text-uppercase">
                                                            <?php
                                                            $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$caseRefNo'";
                                                            $getDefCountPrep = $con->prepare($getDefendant);
                                                            $getDefCountPrep->execute();
                                                            $getDefCount = $getDefCountPrep->rowCount();
                                                            if ($getDefCount > 0) {
                                                                $getDefendantQuery = $con->query($getDefendant);
                                                                foreach ($getDefendantQuery as $row2) {
                                                                    $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                                                                    $defPosition = $row2['position'];

                                                                    if (strtoupper($defFullname) == strtoupper($rbiFname1)) {
                                                                        echo "<span class='font-weight-bold'> <u>" . $defFullname . "</u></span>" . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                                    } else {
                                                                        echo $defFullname . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                                    }
                                                            ?>
                                                                    <br>
                                                            <?php }
                                                            } else {
                                                                echo "--";
                                                            } ?>

                                                        </td>
                                                        <td><?php echo $complaint ?></td>
                                                        <td><span style="font-size: 12px; font-weight: bolder; padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                                                        if ($complaintStatus == "Pending") {
                                                                                                                                                                            echo "#49d97b";
                                                                                                                                                                        } elseif ($complaintStatus == "Payment") {
                                                                                                                                                                            echo "#b693e2";
                                                                                                                                                                        } elseif ($complaintStatus == "Ongoing") {
                                                                                                                                                                            echo "#49d3d9";
                                                                                                                                                                        } elseif ($complaintStatus == "Completed") {
                                                                                                                                                                            echo "#fcb654";
                                                                                                                                                                        } elseif ($complaintStatus == "Rejected") {
                                                                                                                                                                            echo "#ed7469";
                                                                                                                                                                        }
                                                                                                                                                                        ?>"><?php echo $complaintStatus ?></span></td>
                                                        <td>
                                                            <?php
                                                            if ($complaintPic == "none") {
                                                                echo "--";
                                                            } else {
                                                                echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $complaintDateSubmit ?></td>

                                                    </tr>

                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END OF REPORT RESPONDENT TABLE -->
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

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('table.table1').DataTable({
                "scrollX": true,
                "columnDefs": [{
                        // DISABLE SORT
                        "targets": [2, 3, 4, 6, 7],
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