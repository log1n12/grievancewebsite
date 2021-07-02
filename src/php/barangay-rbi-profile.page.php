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
    $showRBIquery = $con->query($showRBISql);
    foreach ($showRBIquery as $row) {
        $rbiFname = $row['full_name'];
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
        $verify = $row['is_existing'];
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
            <section id="table-section" class="pb-3">
                <div id="tableNavbar">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="../assets/1623767188_165936023_280641500315628_7725995120757854408_n.jpg" class="img-fluid mx-auto d-block mt-5" alt="Responsive image">
                            <h2 class="text-center text-capitalize"><?php echo strtolower($rbiFname); ?></h2>
                            <h1 class="mx-auto d-block isVerify" style="background-color: #FDB81D;"><?php
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
                                <p class="text-capitalize"><span>Name </span>: <?php echo strtolower($rbiFname); ?></p>
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
                    <div class="bio-graph-heading mt-5">
                        Complaint Records
                    </div>
                    <table class="table table-hover mt-4" id="myTable" style="width: 100%">
                        <colgroup>
                            <col span="1" style="width: 3%;">
                            <col span="1" style="width: 12%;">
                            <col span="1" style="width: 14%;">
                            <col span="1" style="width: 14%;">
                            <col span="1" style="width: 30%;">
                            <col span="1" style="width: 8%;">
                            <col span="1" style="width: 10%;">
                            <col span="1" style="width: 10%;">

                        </colgroup>
                        <thead class="">
                            <tr>
                                <th onclick="sortTable(0)">ID</th>
                                <th onclick="sortTable(1)" scope="col">Reference Numbers</th>
                                <th onclick="sortTable(2)" scope="col">Complainant</i></th>
                                <th scope="col">Defendant</th>
                                <th scope="col">Complaint</th>
                                <th class="text-center" onclick="sortTable(3)" scope="col">Status</i></th>
                                <th class="text-center" scope="col">Picture</th>
                                <th class="text-center" scope="col">Date</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            //Get complaints
                            //Get comp_rbi_no
                            //Check the barangay 
                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint'";
                            $showComplaintQuery = $con->query($showComplaintSql);
                            foreach ($showComplaintQuery as $row) {
                                $complaintId = $row['id'];
                                $complaintRefNo = $row['case_ref_no'];
                                $complainantId = $row['comp_rbi_no'];
                                $complaint = $row['complaint'];
                                $complaintStatus = $row['case_status'];
                                $complaintPic = $row['incident_pic'];
                                $complaintDateSubmit = $row['date_submit'];

                                $showComplainantBrgy = "SELECT * FROM rbi WHERE id = '$complainantId'";
                                $showComplainantBrgyQue = $con->query($showComplainantBrgy);
                                foreach ($showComplainantBrgyQue as $row1) {
                                    $complainantBrgy = $row1['brgy'];
                                    $complainantFullname = $row1['first_name'] . ' ' . $row1['middle_name'] . ' ' . $row1['last_name'];

                                    $rbiFname = $row1['first_name'];
                                    $rbiMname = $row1['middle_name'];
                                    $rbiLname = $row1['last_name'];
                                    $rbiHouseNo = $row1['house_no'];
                                    $rbiPurok = $row1['purok'];
                                    $rbiAddress = $row1['comp_address'];
                                    $rbiBday = $row1['birth_date'];
                                    $rbiBplace = $row1['birth_place'];
                                    $rbiGender = $row1['gender'];
                                    $rbiCivStatus = $row1['civil_status'];
                                    $rbiCitizenship = $row1['citizenship'];
                                    $rbiOccup = $row1['occupation'];
                                    $rbiRelToHead = $row1['relationship'];
                                    $rbiContactNumber = $row1['contact_no'];
                                    $rbiValiId = $row1['valid_id'];

                                    if ($complainantBrgy == $barangayName) {
                            ?>
                                        <tr>
                                            <td><?php echo $complaintId ?> </td>
                                            <td><?php echo $complaintRefNo ?> </td>
                                            <td>
                                                <a href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $complainantFullname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo $complainantFullname ?> </a>
                                            </td>

                                            <td>
                                                <?php
                                                $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
                                                $getDefendantQuery = $con->query($getDefendant);
                                                foreach ($getDefendantQuery as $row2) {
                                                    $defFullname = $row2['full_name'];
                                                    $defPosition = $row2['position'];

                                                    echo $defFullname . " <br><small class='small'>(" . $defPosition . ")</small>";
                                                ?>
                                                    <br>
                                                <?php } ?>

                                            </td>
                                            <td><?php echo $complaint ?></td>
                                            <td class="text-center"><span style="padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                            if ($complaintStatus == "Pending") {
                                                                                                                                                echo "#bdffc3";
                                                                                                                                            } elseif ($complaintStatus == "Payment") {
                                                                                                                                                echo "#bde5ff";
                                                                                                                                            } elseif ($complaintStatus == "Ongoing") {
                                                                                                                                                echo "#fcffbd";
                                                                                                                                            } elseif ($complaintStatus == "Completed") {
                                                                                                                                                echo "#ffe1bd";
                                                                                                                                            } elseif ($complaintStatus == "Rejected") {
                                                                                                                                                echo "#ffbdbd";
                                                                                                                                            }
                                                                                                                                            ?>"><?php echo $complaintStatus ?></span></td>
                                            <td class="text-center">
                                                <?php
                                                if ($complaintPic == "none") {
                                                    echo "none";
                                                } else {
                                                    echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center"><?php echo $complaintDateSubmit ?></td>

                                        </tr>

                            <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>


                    </table>
                    <div class="bio-graph-heading mt-5">
                        Report Records
                    </div>
                    <table class="table table-hover mt-4" id="myTable" style="width: 100%">
                        <colgroup>
                            <col span="1" style="width: 3%;">
                            <col span="1" style="width: 12%;">
                            <col span="1" style="width: 14%;">
                            <col span="1" style="width: 14%;">
                            <col span="1" style="width: 30%;">
                            <col span="1" style="width: 8%;">
                            <col span="1" style="width: 10%;">
                            <col span="1" style="width: 10%;">

                        </colgroup>
                        <thead class="">
                            <tr>
                                <th onclick="sortTable(0)">ID</th>
                                <th onclick="sortTable(1)" scope="col">Reference Numbers</th>
                                <th onclick="sortTable(2)" scope="col">Complainant</i></th>
                                <th scope="col">Defendant</th>
                                <th scope="col">Complaint</th>
                                <th class="text-center" onclick="sortTable(3)" scope="col">Status</i></th>
                                <th class="text-center" scope="col">Picture</th>
                                <th class="text-center" scope="col">Date</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            //Get complaints
                            //Get comp_rbi_no
                            //Check the barangay 
                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint'";
                            $showComplaintQuery = $con->query($showComplaintSql);
                            foreach ($showComplaintQuery as $row) {
                                $complaintId = $row['id'];
                                $complaintRefNo = $row['case_ref_no'];
                                $complainantId = $row['comp_rbi_no'];
                                $complaint = $row['complaint'];
                                $complaintStatus = $row['case_status'];
                                $complaintPic = $row['incident_pic'];
                                $complaintDateSubmit = $row['date_submit'];

                                $showComplainantBrgy = "SELECT * FROM rbi WHERE id = '$complainantId'";
                                $showComplainantBrgyQue = $con->query($showComplainantBrgy);
                                foreach ($showComplainantBrgyQue as $row1) {
                                    $complainantBrgy = $row1['brgy'];
                                    $complainantFullname = $row1['first_name'] . ' ' . $row1['middle_name'] . ' ' . $row1['last_name'];

                                    $rbiFname = $row1['first_name'];
                                    $rbiMname = $row1['middle_name'];
                                    $rbiLname = $row1['last_name'];
                                    $rbiHouseNo = $row1['house_no'];
                                    $rbiPurok = $row1['purok'];
                                    $rbiAddress = $row1['comp_address'];
                                    $rbiBday = $row1['birth_date'];
                                    $rbiBplace = $row1['birth_place'];
                                    $rbiGender = $row1['gender'];
                                    $rbiCivStatus = $row1['civil_status'];
                                    $rbiCitizenship = $row1['citizenship'];
                                    $rbiOccup = $row1['occupation'];
                                    $rbiRelToHead = $row1['relationship'];
                                    $rbiContactNumber = $row1['contact_no'];
                                    $rbiValiId = $row1['valid_id'];

                                    if ($complainantBrgy == $barangayName) {
                            ?>
                                        <tr>
                                            <td><?php echo $complaintId ?> </td>
                                            <td><?php echo $complaintRefNo ?> </td>
                                            <td>
                                                <a href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $complainantFullname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo $complainantFullname ?> </a>
                                            </td>

                                            <td>
                                                <?php
                                                $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
                                                $getDefendantQuery = $con->query($getDefendant);
                                                foreach ($getDefendantQuery as $row2) {
                                                    $defFullname = $row2['full_name'];
                                                    $defPosition = $row2['position'];

                                                    echo $defFullname . " <br><small class='small'>(" . $defPosition . ")</small>";
                                                ?>
                                                    <br>
                                                <?php } ?>

                                            </td>
                                            <td><?php echo $complaint ?></td>
                                            <td class="text-center"><span style="padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                            if ($complaintStatus == "Pending") {
                                                                                                                                                echo "#bdffc3";
                                                                                                                                            } elseif ($complaintStatus == "Payment") {
                                                                                                                                                echo "#bde5ff";
                                                                                                                                            } elseif ($complaintStatus == "Ongoing") {
                                                                                                                                                echo "#fcffbd";
                                                                                                                                            } elseif ($complaintStatus == "Completed") {
                                                                                                                                                echo "#ffe1bd";
                                                                                                                                            } elseif ($complaintStatus == "Rejected") {
                                                                                                                                                echo "#ffbdbd";
                                                                                                                                            }
                                                                                                                                            ?>"><?php echo $complaintStatus ?></span></td>
                                            <td class="text-center">
                                                <?php
                                                if ($complaintPic == "none") {
                                                    echo "none";
                                                } else {
                                                    echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center"><?php echo $complaintDateSubmit ?></td>

                                        </tr>

                            <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>


                    </table>

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

    <script type="text/javascript">
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });
        });
    </script>
</body>

</html>