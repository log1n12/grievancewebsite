<?php
session_start();
require_once './database/config.php';
require_once './database/dilg-admin.check.php';
$titleHeader = "Barangay";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/dilg-admin.style.css">
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
                                        $dsql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint'";
                                        $dsqlq = $con->prepare($dsql);
                                        $dsqlq->execute();
                                        $dscount = $dsqlq->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount ?></h5>
                                        <small class="card-text">Number of Complaints</small>
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
                                        $dsql1 = "SELECT * FROM complaint_case WHERE complaint_type = 'report'";
                                        $dsqlq1 = $con->prepare($dsql1);
                                        $dsqlq1->execute();
                                        $dscount1 = $dsqlq1->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount1 ?></h5>
                                        <small>Number of Reports</small>
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
                                        $dsql2 = "SELECT * FROM rbi WHERE is_existing = 'yes'";
                                        $dsqlq2 = $con->prepare($dsql2);
                                        $dsqlq2->execute();
                                        $dscount2 = $dsqlq2->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount2 ?></h5>
                                        <small class="card-text">Number of Barangay Inhabitants</small>
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
                            <h1 class="mx-4 mt-3">List of Barangay Records</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <select name="compBrgy" class="form-control float-right mx-4 mt-3" id="compBrgySelect" style="width: 200px;">
                                <option value="">All</option>
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
                    </div>
                    <div class="row mt-3 ml-4">
                        <div class="com-md-12">
                            <nav id="navSort">
                                <div class="nav sort" id="nav-tab" role="tablist">
                                    <a class="nav-item btnSort nav-link active px-4 mr-1" id="nav-comp-tab" data-toggle="tab" href="#nav-comp" role="tab" aria-controls="nav-comp" aria-selected="true"><span class="sortTitle">Complaint</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-repo-tab" data-toggle="tab" href="#nav-repo" role="tab" aria-controls="nav-repo" aria-selected="false"><span class="sortTitle">Report</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-rbi-tab" data-toggle="tab" href="#nav-rbi" role="tab" aria-controls="nav-rbi" aria-selected="false"><span class="sortTitle">RBI</span></a>
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
                                <div class="tab-pane fade show active" id="nav-comp" role="tabpanel" aria-labelledby="nav-comp-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table11" style="width: 100%">

                                        <thead class="">
                                            <tr>
                                                <th>ID</th>
                                                <th scope="col">Reference Numbers</th>
                                                <th scope="col">Complainant</i></th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Status</i></th>
                                                <th scope="col">Picture</th>
                                                <th scope="col">Date Submitted</th>
                                                <th scope="col">Barangay</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php

                                            //Get complaints
                                            //Get comp_rbi_no
                                            //Check the barangay 
                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint' ORDER BY id desc";
                                            $showComplaintQuery = $con->query($showComplaintSql);
                                            foreach ($showComplaintQuery as $row) {
                                                $complaintId = $row['id'];
                                                $complaintRefNo = $row['case_ref_no'];
                                                $complaint = $row['complaint'];
                                                $complaintStatus = $row['case_status'];
                                                $complaintPic = $row['incident_pic'];
                                                $complaintDateSubmit = $row['date_submit'];
                                                $complaintWhere = $row['where_to'];
                                                $complaintActionTaken = $row['action_taken'];
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

                                                                    <a class="text-capitalize" style="cursor: initial;"><?php echo strtolower($rbiFname) ?> </a>
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
                                                                    <a class="text-capitalize" style="cursor: initial;"><?php echo strtolower($rbiFname) ?></a>
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
                                                                                                                                                                        echo '#ed7469" tabindex="0" role="button" data-html="true" data-toggle="popover" title="Explanation" data-placement="top" data-trigger="hover" data-content="' . $complaintActionTaken;
                                                                                                                                                                    } elseif ($complaintStatus == "Document") {
                                                                                                                                                                        echo "#ed9969";
                                                                                                                                                                    }
                                                                                                                                                                    ?>"><?php echo $complaintStatus ?></span></td>
                                                    <td>
                                                        <?php
                                                        if ($complaintPic == "none") {
                                                            echo "--";
                                                        } else {
                                                            echo '<a href="../assets/' . $complaintPic . ' ?" target="_blank">View Picture</a>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $complaintDateSubmit ?></td>
                                                    <td><?php echo $complaintWhere ?></td>
                                                </tr>

                                            <?php

                                            }
                                            ?>
                                        </tbody>


                                    </table>
                                </div>

                                <!-- TABLE REPORT -->
                                <div class="tab-pane fade" id="nav-repo" role="tabpanel" aria-labelledby="nav-repo-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table2" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>ID</th>
                                                <th scope="col">Reference Numbers</th>
                                                <th scope="col">Complainant</th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Picture</th>
                                                <th scope="col">Date Submitted</th>
                                                <th scope="col">Barangay</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'report' ORDER BY id";
                                            $showComplaintQuery = $con->query($showComplaintSql);
                                            foreach ($showComplaintQuery as $row) {
                                                $complaintId = $row['id'];
                                                $complaintRefNo = $row['case_ref_no'];
                                                $complaint = $row['complaint'];
                                                $complaintStatus = $row['case_status'];
                                                $complaintPic = $row['incident_pic'];
                                                $complaintDateSubmit = $row['date_submit'];
                                                $complaintWhere = $row['where_to'];
                                                $complaintActionTaken = $row['action_taken'];


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

                                                                    <a class="text-capitalize" style="cursor: initial;"><?php echo strtolower($rbiFname) ?> </a>
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
                                                                    <a class="text-capitalize" style="cursor: initial;"><?php echo strtolower($rbiFname) ?></a>
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
                                                    <td><span style="font-size: 12px; font-weight: bolder; padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                                                    if ($complaintStatus == "Pending") {
                                                                                                                                                                        echo "#49d97b";
                                                                                                                                                                    } elseif ($complaintStatus == "Completed") {
                                                                                                                                                                        echo "#fcb654";
                                                                                                                                                                    } elseif ($complaintStatus == "Rejected") {
                                                                                                                                                                        echo '#ed7469" tabindex="0" role="button" data-html="true" data-toggle="popover" data-placement="top" title="Explanation" data-trigger="hover" data-content="' . $complaintActionTaken;
                                                                                                                                                                    } elseif ($complaintStatus == "Ongoing") {
                                                                                                                                                                        echo "#49d3d9";
                                                                                                                                                                    }
                                                                                                                                                                    ?>"><?php echo $complaintStatus ?></span></td>

                                                    <td>
                                                        <?php
                                                        if ($complaintPic == "none") {
                                                            echo "--";
                                                        } else {
                                                            echo '<a href="../assets/' . $complaintPic . ' ?" target="_blank">View Picture</a>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $complaintDateSubmit ?></td>
                                                    <td><?php echo $complaintWhere ?></td>
                                                </tr>
                                            <?php

                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE RBI -->
                                <div class="tab-pane fade" id="nav-rbi" role="tabpanel" aria-labelledby="nav-rbi-tab">
                                    <table class="table table222 table-hover table-striped text-center" id="table3" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">House Number</th>
                                                <th scope="col">Purok</th>
                                                <th scope="col">Complete Address</th>
                                                <th scope="col">Birthday</th>
                                                <th scope="col">Gender</th>
                                                <th scope="col">Civil Status</th>
                                                <th scope="col">Occupation</th>
                                                <th scope="col">Relationship to the Head</th>
                                                <th scope="col">Contact Number</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Barangay</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showRBISql = "SELECT * FROM rbi WHERE is_existing != 'outsider'";
                                            $showRBIquery = $con->query($showRBISql);
                                            foreach ($showRBIquery as $row) {
                                                $rbiId = $row['id'];
                                                $rbiFname = $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'];
                                                $rbiHouseNo = $row['house_no'];
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
                                                $rbiBrgy = $row['brgy'];
                                                $rbiValiId = $row['valid_id'];
                                                $rbiStatus = $row['is_existing'];
                                                $rbiStatusText = "";

                                                if ($rbiStatus == "pending") {
                                                    $rbiStatusText = "Pending";
                                                } elseif ($rbiStatus == "yes") {
                                                    $rbiStatusText = "Verified";
                                                } elseif ($rbiStatus == "no") {
                                                    $rbiStatusText = "Removed";
                                                }

                                                $rbiExisting = $rbiStatus;

                                            ?>
                                                <tr>
                                                    <td><?php echo $rbiId ?><input type="hidden" name="id" value="<?php echo $rbiId ?>" /></td>
                                                    <td>
                                                        <a class="text-capitalize" href="./dilg-rbi-profile.page.php?rbiid=<?= $rbiId ?>" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?> </a>


                                                    </td>
                                                    <td><?php echo $rbiHouseNo ?></td>
                                                    <td><?php echo $rbiPurok ?></td>
                                                    <td><?php echo $rbiAddress ?></td>
                                                    <td><?php echo $rbiBday ?></td>
                                                    <td><?php echo $rbiGender ?></td>
                                                    <td><?php echo $rbiCivStatus ?></td>
                                                    <td><?php echo $rbiOccup ?></td>
                                                    <td><?php echo $rbiRelToHead ?></td>
                                                    <td><?php echo $rbiContactNumber ?></td>
                                                    <td><span style="font-size: 12px; font-weight: bolder; padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                                                    if ($rbiStatus == "pending") {
                                                                                                                                                                        echo "#fcb654";
                                                                                                                                                                    } elseif ($rbiStatus == "yes") {
                                                                                                                                                                        echo "#49d97b";
                                                                                                                                                                    } elseif ($rbiStatus == "no") {
                                                                                                                                                                        echo "#ed7469";
                                                                                                                                                                    }
                                                                                                                                                                    ?>"><?php echo $rbiStatusText ?></span></td>
                                                    <td><?php echo $rbiBrgy ?></td>


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

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
    </script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js">
    </script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js">
    </script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#compBrgySelect').on('change', function() {

                var table11 = $('table.table1').DataTable();
                var brgyText = $('#compBrgySelect').val()

                table11.columns(8).search(brgyText).draw();

                var table112 = $('table.table222').DataTable();

                table112.columns(12).search(brgyText).draw();

            });
            var table = $('table.table1').DataTable({
                "scrollX": true,
                "lengthChange": false,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        title: 'Barangay Record Export'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Barangay Record Export'
                    },
                    {
                        extend: 'print',
                        title: 'Barangay Record Export'
                    }
                ]
            });




            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            table.$("[data-toggle=popover]").popover().hover(function(e) {
                e.preventDefault();
            });
        });
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
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