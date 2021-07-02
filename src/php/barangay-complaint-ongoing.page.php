<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$titleHeader = "Complaint";
$message = "";

if (isset($_GET['toCompletedBtn'])) {
    $id = $_GET['id'];
    $unreadsql = "UPDATE complaint_case SET case_status = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "Completed",
        ':id' => $id

    ])) {
        $message = "Updated";
    }
}

if (isset($_POST['addMeetingBtn'])) {
    $complaintRef = $_POST['complaintRef'];
    $meetDate = $_POST['meetDate'];
    $meetTime = $_POST['meetTime'];
    $meetRemarks = "--";
    $meetCount = "";
    if (!empty($_POST['meetRemarks'])) {
        $meetRemarks = $_POST['meetRemarks'];
    }

    $getMeeting = "SELECT * FROM meeting WHERE case_ref_no = '$complaintRef'";
    $getMeetingQuery = $con->query($getMeeting);
    $getMeetingQuery->execute();

    $getMeetingCount = $getMeetingQuery->rowCount();

    if ($getMeetingCount < 3) {
        $meetCount = $getMeetingCount + 1;
        // Insert meeting to the meeting table
        $setMeeting = "INSERT INTO meeting (case_ref_no, meeting_no, meet_date, time_start, remarks, time_ended, meet_status, meet_minutes) VALUES ('$complaintRef','$meetCount','$meetDate','$meetTime','$meetRemarks', '--', '--', '--')";
        if ($con->exec($setMeeting)) {
            $message = "Meeting is added";
        }
    } else {
        $message = "Tatlo na yung meeting";
    }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.css">
    <link rel="stylesheet" type="text/css" href="../css/barangay-admin.style.css">
    <title>Document</title>
</head>

<body>
    <?php include './navbar/barangay.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/barangay.navbar-top.php' ?>
        <div class="transition px-5">
            <section id="list-count" class="mb-4">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-clinic-medical fa-1x mr-3"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <h5 class="card-text">10</h5>
                                        <small class="card-text">Number of Rooms</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-sign-in-alt fa-1x mr-3"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <h5 class="card-text">20</h5>
                                        <small>Number of Acquire Patient</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-comments fa-1x mr-3"></i>
                                    </div>
                                    <div class="col-sm-8 text-right">
                                        <h5 class="card-text">30</h5>
                                        <small class="card-text">Number of Feedback</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="main mb-3">
                <div class="container1 mt-3 px-4 ">
                    <div class="glider-contain">
                        <div class="glider">

                            <?php
                            date_default_timezone_set("Asia/Manila");
                            $dateToday = date("Y-m-d H:i");
                            $getAllmeeting = "SELECT * FROM meeting ORDER BY meet_date, time_start";
                            $getAllMeetingQuery = $con->query($getAllmeeting);
                            foreach ($getAllMeetingQuery as $meetRow) {
                                $meetingRefNo = $meetRow['case_ref_no'];
                                $meetingNumber1 = $meetRow['meeting_no'];
                                $meetingDate1 = $meetRow['meet_date'];
                                $meetingTime1 = $meetRow['time_start'];
                                $meetingRemarks1 = $meetRow['remarks'];
                                $meetingTimeEnded1 = $meetRow['time_ended'];
                                $meetingStatus1 = $meetRow['meet_status'];
                                $meetingMinutes1 = $meetRow['meet_minutes'];

                                $meetingDateTime = $meetingDate1 . " " . $meetingTime1;

                                if (strtotime($meetingDateTime) >= strtotime($dateToday)) {

                                    $getCase = "SELECT * FROM complaint_case WHERE case_ref_no = '$meetingRefNo'";
                                    $getCaseQue = $con->query($getCase);
                                    foreach ($getCaseQue as $caseRow) {
                                        $whereTo = $caseRow['where_to'];
                                        if ($whereTo == $barangayName) {


                            ?>
                                            <div class="card mb-3 text-center">
                                                <div class="card-header font-weight-bold">Ref no: <?php echo $meetingRefNo; ?></div>
                                                <div class="card-body">
                                                    <h3 class="card-title mb-1">Meeting No. <?php echo $meetingNumber1; ?></h3>
                                                    <h6 class="card-title mb-0 font-weight-bold" style="color: #1F5493;"><?php
                                                                                                                            $date1 = DateTime::createFromFormat('Y-m-d', $meetingDate1);
                                                                                                                            $date11 = $date1->format('F j, Y');
                                                                                                                            echo $date11;
                                                                                                                            ?></h6>
                                                    <small class="card-subtitle text-muted"><?php
                                                                                            $time1 = DateTime::createFromFormat('H:i', $meetingTime1);
                                                                                            $time11 = $time1->format('g:i a');
                                                                                            echo $time11; ?></small>
                                                    <div class="mt-3" style="padding: 20px 0; background-color: #faf3e1;">
                                                        <p class="card-text"><span class="font-weight-bold">Complainant:</span>
                                                            <?php
                                                            $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$meetingRefNo'";
                                                            $getComplainantQuery = $con->query($getComplainant);
                                                            foreach ($getComplainantQuery as $row2) {
                                                                $compId = $row2['comp_id'];

                                                                $getComplainant1 = "SELECT * FROM rbi WHERE id = '$compId'";
                                                                $getComplainantQuery1 = $con->query($getComplainant1);
                                                                foreach ($getComplainantQuery1 as $row3) {
                                                                    $rbiFname = $row3['full_name'];


                                                            ?>
                                                                    <span class="text-capitalize"><?php echo strtolower($rbiFname) ?>.</span>


                                                            <?php }
                                                            } ?>
                                                        </p>
                                                        <p class="card-text"><span class="font-weight-bold">Respondent:</span>
                                                            <?php
                                                            $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$meetingRefNo'";
                                                            $getDefendantQuery = $con->query($getDefendant);
                                                            foreach ($getDefendantQuery as $row2) {
                                                                $defFullname = $row2['full_name'];

                                                            ?>
                                                                <span class="text-capitalize"><?php echo strtolower($defFullname) ?>.</span>
                                                            <?php } ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                            <?php

                                        }
                                    }
                                }
                            }
                            ?>


                        </div>
                        <span role="button" aria-label="Previous" class="glider-prev"><i class="fas fa-chevron-left"></i></span>
                        <span role="button" aria-label="Next" class="glider-next"><i class="fas fa-chevron-right"></i></span>
                        <span role="tablist" class="dots"></span>
                    </div>
                </div>
            </section>
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
            <section id="table-section">
                <div id="tableNavbar">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="mx-4 mt-4">List of Complaints</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <a id="addBtn" class="add btn mx-4 mt-4" href="./service-complaint.page.php" data-placement="left" title="Add Hospital"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="container">
                            <div class="card card-body transparent">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="container formm">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="First Name" name="ufirstname" id="fnamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Last Name" name="ulastname" id="lnamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" class="form-control transparent text-center" placeholder="Email" name="uemail" id="emaillbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Username" name="uname" id="unamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control transparent text-center" placeholder="Password" name="upass" name="upass" id="password" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Name" name="hospname" id="hospnamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Address" name="hospaddress" id="hospaddlbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Town" name="hosptown" id="hosptownlbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Website" name="uwebsite" id="hospweblbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="file" name="profileImage" id="profileImage" class="form-control-file transparent" onChange="displayImage(this)" required><br>
                                                    <img src="" style="max-width: 300px;" class="img-fluid transparent" id="profileDisplay" onclick="triggerClick()">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" name="submit" class="addhospbtn btn btn-block ">Add Hospital</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tableContent" class="table-responsive mt-3 px-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <form class="d-flex align-items-center sort">
                                <a href="./barangay-complaint.page.php" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">All</a>
                                <a href="./barangay-complaint-pending.page.php" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Pending</a>
                                <a href="./barangay-complaint-confirm.page.php" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Payment</a>
                                <a href="./barangay-complaint-ongoing.page.php" class="btn btn-dark btnSort px-4 mr-1 active" name="all" value="all">Ongoing</a>
                                <a href="./barangay-complaint-completed.page.php" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Completed</a>
                                <a href="./barangay-complaint-rejected.page.php" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Rejected</a>
                            </form>
                            <table class="table table-hover table-bordered mt-4 text-center" id="myTable" style="width: 100%">
                                <colgroup>
                                    <col span="1" style="width: 5%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 26%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 9%;">
                                    <col span="1" style="width: 4%;">
                                    <col span="1" style="width: 4%;">
                                </colgroup>
                                <thead class="">
                                    <tr>
                                        <th onclick="sortTable(0)">ID <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(1)" scope="col">Reference Numbers <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(2)" scope="col">Complainant <i class="fas fa-sort"></i></th>
                                        <th scope="col">Defendant</th>
                                        <th scope="col">Complaint</th>
                                        <th scope="col">Kind of Case</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Completed?</th>
                                        <th scope="col">Add Meeting</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint' AND case_status = 'Ongoing' AND where_to = '$barangayName'";
                                    $showComplaintQuery = $con->query($showComplaintSql);
                                    foreach ($showComplaintQuery as $row) {
                                        $complaintId = $row['id'];
                                        $complaintRefNo = $row['case_ref_no'];
                                        $complaint = $row['complaint'];
                                        $complaintStatus = $row['case_status'];
                                        $complaintPic = $row['incident_pic'];
                                        $complaintDateSubmit = $row['date_submit'];
                                        $complaintNod = $row['nod'];
                                    ?>
                                        <form method="get">
                                            <tr data-toggle="collapse" data-target="#accordion<?php echo $complaintId ?>" class="accordion-toggle clickable">
                                                <td><?php echo $complaintId ?><input type="hidden" name="id" value="<?php echo $complaintId ?>" /> </td>
                                                <td class="font-weight-bold"><?php echo $complaintRefNo ?></td>
                                                <td>
                                                    <?php
                                                    $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$complaintRefNo'";
                                                    $getComplainantQuery = $con->query($getComplainant);
                                                    foreach ($getComplainantQuery as $row2) {
                                                        $compId = $row2['comp_id'];

                                                        $getComplainant1 = "SELECT * FROM rbi WHERE id = '$compId'";
                                                        $getComplainantQuery1 = $con->query($getComplainant1);
                                                        foreach ($getComplainantQuery1 as $row3) {
                                                            $rbiFname = $row3['full_name'];
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
                                                            <a href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo $rbiFname ?> </a>
                                                            <br><small class='small'>(<?php echo $rbiBrgy ?>)</small>
                                                            <br>
                                                    <?php }
                                                    } ?>
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
                                                <td><?php
                                                    $getKp = "SELECT * FROM kplist WHERE id = '$complaintNod'";
                                                    $getKpQuery = $con->query($getKp);
                                                    foreach ($getKpQuery as $row) {
                                                        $kpName = $row['kp_name'];
                                                        $kpEngName = $row['kp_name_eng'];
                                                        $kpType = $row['kp_type'];
                                                    }

                                                    echo "<b>" . $kpType . " Case </b>- " . $kpName . " (" . $kpEngName . ")";
                                                    ?></td>
                                                <td><?php echo $complaintDateSubmit ?></td>
                                                <td><button class="add btn" type="submit" name="toCompletedBtn"><i class="fas fa-check"></i></button></td>
                                                <td><button class="add btn acceptBtn" type="button"><i class="fas fa-check"></i></button></td>
                                            </tr>
                                            <tr class="meeting" style="background-color: rgba(249, 251, 255, 1);">
                                                <td colspan="12" class="hiddenRow">
                                                    <div class="accordian-body collapse" id="accordion<?php echo $complaintId ?>">
                                                        <h5 class="text-center my-4">Meetings</h5>
                                                        <table class="table table-stripped">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Meeting</th>
                                                                    <th class="text-center">Date of meeting</th>
                                                                    <th class="text-center">Scheduled Time</th>
                                                                    <th class="text-center">Time Ended</th>
                                                                    <th class="text-center">Remarks</th>
                                                                    <th class="text-center">Status</th>
                                                                    <th class="text-center">Minutes of the meeting</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="text-center">
                                                                <?php
                                                                $getMeeting1 = "SELECT * FROM meeting WHERE case_ref_no = '$complaintRefNo'";
                                                                $getMeetingQuery1 = $con->query($getMeeting1);
                                                                $getMeetingQuery1->execute();

                                                                $getMeetingCount1 = $getMeetingQuery1->rowCount();

                                                                if ($getMeetingCount1 > 0) {
                                                                    foreach ($getMeetingQuery1 as $row) {
                                                                        $meetingNumber = $row['meeting_no'];
                                                                        $meetingDate = $row['meet_date'];
                                                                        $meetingTime = $row['time_start'];
                                                                        $meetingRemarks = $row['remarks'];
                                                                        $meetingTimeEnded = $row['time_ended'];
                                                                        $meetingStatus = $row['meet_status'];
                                                                        $meetingMinutes = $row['meet_minutes'];
                                                                ?>

                                                                        <tr>
                                                                            <td>Meeting <?php echo $meetingNumber; ?></td>
                                                                            <td><?php
                                                                                $date1 = DateTime::createFromFormat('Y-m-d', $meetingDate);
                                                                                $date11 = $date1->format('F j, Y');
                                                                                echo $date11;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $time1 = DateTime::createFromFormat('H:i', $meetingTime);
                                                                                $time11 = $time1->format('g:i a');
                                                                                echo $time11;
                                                                                ?></td>
                                                                            <td><?php echo $meetingTimeEnded; ?></td>
                                                                            <td><?php echo $meetingRemarks; ?></td>
                                                                            <td><?php echo $meetingStatus; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if ($meetingMinutes == "--") {
                                                                                    echo "--";
                                                                                } else {
                                                                                ?>
                                                                                    <a href="#">minutesofthemeeting.docs</a>

                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                <?php }
                                                                } else {
                                                                    echo "<tr><td colspan='12'><h6>There is no meeting here. </h6></td></tr>";
                                                                }
                                                                ?>
                                                            </tbody>

                                                        </table>

                                                    </div>
                                                </td>
                                            </tr>

                                        </form>

                                    <?php

                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModalLongTitle">Add Meeting</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <form method="post">
                                                <input type="hidden" id="complaintId" name="id" />
                                                <input type="text" id="complaintRef" name="complaintRef" />
                                                <p class="mt-3 mb-0"><span class="font-weight-bold">Reference Number:</span> <span id="refNumber"></span></p>
                                                <p class="font-weight-bold mb-0">Complaint: <span id="compComplaint" class="font-weight-light"></span></p>
                                                <div class="complaintDiv mt-2">
                                                    <h6 class="font-weight-bolder">Choose what kind of Katarungang Pambarangay this case belongs</h6>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="inciDateId">Scheduled date</label>
                                                            <input class="form-control" id="inciDateId" type="date" name="meetDate" required />
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="inciTimeId">Scheduled Time</label>
                                                            <input class="form-control" id="inciTimeId" type="time" name="meetTime" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="complaintId1">Remarks</label>
                                                        <textarea class="form-control" id="complaintId1" name="meetRemarks" placeholder="Leave a message..." rows="3"></textarea>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btnAccept" name="addMeetingBtn">Accept</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.js"></script>

    <script type="text/javascript">
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

    <script type="text/javascript">
        $('.clickable').click(function() {
            if ($(this).attr('aria-expanded') == "true") {
                $(this).children().css({
                    'background-color': 'white',
                    'color': 'initial'
                });
                $(".add", this).css({
                    'background-color': '#1F5493',
                    'color': 'white'
                });
                $("a", this).css('color', '#0371BC');
            } else {
                $(this).children().css({
                    'background-color': '#1F5493',
                    'color': 'white'
                });
                $(".add", this).css({
                    'background-color': '#FDB81D',
                    'color': 'black'
                });

                $("a", this).css('color', 'white');
            }
        });

        $(document).ready(function() {
            $('.acceptBtn').on('click', function() {
                $('#acceptModal').modal('show');

                $tr = $(this).closest('tr');

                var tddata = $tr.children("td").map(function() {
                    return $(this).text();

                }).get();

                $('#complaintId').val(tddata[0]);
                $('#complaintRef').val(tddata[1]);
                $('#refNumber').text(tddata[1]);
                $('#compComplaint').text(tddata[4]);


            });
        });


        new Glider(document.querySelector(".glider"), {
            slidesToShow: 2,
            slidesToScroll: 1,
            draggable: true,
            dots: ".dots",
            responsive: [{
                    // If Screen Size More than 768px
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        duration: 0.5,
                        arrows: {
                            prev: ".glider-prev",
                            next: ".glider-next"
                        }
                    }
                },
                {
                    // If Screen Size More than 1024px
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        duration: 0.5,
                        arrows: {
                            prev: ".glider-prev",
                            next: ".glider-next"
                        }
                    }
                }
            ]
        });
    </script>

    <script>
        $(function() {
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;

            // or instead:
            // var maxDate = dtToday.toISOString().substr(0, 10);
            $('#inciDateId').attr('min', maxDate);
        });
    </script>
</body>

</html>