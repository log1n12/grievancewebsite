<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$titleHeader = "Complaint";
$message = "";
$confirm = "no";
$tab = "all";

date_default_timezone_set("Asia/Manila");

$countMeeting0 = 0;
$countMeeting10 = 0;
$dateNow0 = new DateTime(date('Y-m-d'));
$getMeetingss0 = "SELECT * FROM meeting WHERE meet_status = '--'";
$getMeetingssQ0 = $con->query($getMeetingss0);
foreach ($getMeetingssQ0 as $row0) {
    $meetingDate0 = $row0['meet_date'];
    $dateMeeting0 = new DateTime($meetingDate0);
    $compRefNo0 = $row0['case_ref_no'];
    $checkBrgy0 = "SELECT * FROM complaint_case WHERE case_ref_no = '$compRefNo0'";
    $checkBrgyQue0 = $con->query($checkBrgy0);

    foreach ($checkBrgyQue0 as $row10) {
        //get brgy
        $brgy0 = $row10['where_to'];
        if ($brgy0 == $barangayName) {
            if ($dateMeeting0 < $dateNow0) {
                $countMeeting0 += 1;
            } elseif ($dateMeeting0 == $dateNow0) {
                $countMeeting10 += 1;
            }
        }
    }
}

if (isset($_POST['toPaymentBtn'])) {
    $id = $_POST['id'];
    $kp = $_POST['compKp'];
    $refNo = $_POST['compRefNo'];

    $getCountDef = "SELECT * FROM defendant WHERE case_ref_no = '$refNo'";
    $getCountDefQue = $con->prepare($getCountDef);
    $getCountDefQue->execute();

    $countDef = $getCountDefQue->rowCount();
    if ($countDef > 0) {
        $unreadsql = "UPDATE complaint_case SET case_status = :case_status, nod = :nod WHERE id = :id";
        $unreadstmt = $con->prepare($unreadsql);
        if ($unreadstmt->execute([
            ':case_status' => "Payment",
            'nod' => $kp,
            ':id' => $id

        ])) {

            $notifTitle = "Complaint Accepted";
            $notifMesg = "Complaint was successfully accepted. The complaint reference number is: " . $refNo;
            $notifTo = "DILG";
            $notifToType = "Barangay Secretary";
            $notifFrom = $cookieId;

            require './get-notif.php';
            $tab = "payment";
            $confirm = "yes";
            $message = "The case is successfully move to payment table";
        }
    } else {
        $tab = "pending";
        $message = "There is no defendant or respondent please try again";
    }
}

if (isset($_POST['toAddDefBtn'])) {
    $comRefNo = $_POST['compRefNoAddDef'];
    $defFirstName = $_POST["defFirstname"];
    $defLastName = $_POST["defLastname"];
    $defMiddleName = $_POST["defMiddlename"];
    $defBrgy = $_POST["defBrgy"];
    $defAddress = $_POST["defAddress"];
    $defIdentity = $_POST["defIdentity"];
    //insert defendant to defendant table
    foreach ($defFirstName as $key => $value) {
        $addToDef = "INSERT INTO defendant (case_ref_no, first_name, last_name, middle_name, def_address, barangay, position) VALUES ('$comRefNo', '$value', '$defLastName[$key]', '$defMiddleName[$key]', '$defAddress[$key]', '$defBrgy[$key]', '$defIdentity[$key]')";
        if ($con->exec($addToDef)) {
            $tab = "pending";
            $confirm = "yes";
            $message = "You successfully added defendant/s";
        } else {
            $message = "ERROR!!";
        }
    }
}

if (isset($_POST['toDocumentBtn'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE complaint_case SET case_status = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "Document",
        ':id' => $id

    ])) {
        $tab = "document";
        $confirm = "yes";
        $message = "The case is successfully move to Document table";
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
        $notifTitle = "Complaint Rejeceted";
        $notifMesg = "Complaint was rejected. The complaint reference number is: " . $refNo;
        $notifTo = "DILG";
        $notifToType = "Barangay Secretary";
        $notifFrom = $cookieId;

        require './get-notif.php';
        $tab = "reject";
        $confirm = "yes";
        $message = "The case is successfully move to rejected table";
    }
}

if (isset($_POST['addMeetingBtn'])) {
    $complaintId = $_POST['id'];
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
        $meetMonth = date("m", strtotime($meetDate));
        $setMeeting = "INSERT INTO meeting (case_ref_no, meeting_no, meet_date, time_start, remarks, time_ended, meet_status, meet_minutes, mont) VALUES ('$complaintRef','$meetCount','$meetDate','$meetTime','$meetRemarks', '--', '--', '--', '$meetMonth')";
        if ($con->exec($setMeeting)) {
            $unreadsql = "UPDATE complaint_case SET case_status = :case_status WHERE id = :id";
            $unreadstmt = $con->prepare($unreadsql);
            if ($unreadstmt->execute([
                ':case_status' => "Ongoing",
                ':id' => $complaintId

            ])) {
                $tab = "ongoing";
                $confirm = "yes";
                $message = "The case is successfully move to ongoing table";



                $getDocNo = "SELECT * FROM complaint_case WHERE id = '$complaintId'";
                $getDocNoq = $con->query($getDocNo);
                foreach ($getDocNoq as $row) {
                    $complaintDocNo = $row['docket_number'];
                    $complaintRefNo = $row['case_ref_no'];
                    $complaintNod = $row['nod'];
                }

                $endorseComplainant = "";
                $endorseDefendant = "";

                // get ukol sa

                $getKp = "SELECT * FROM kplist WHERE id = '$complaintNod'";
                $getKpQuery = $con->query($getKp);
                foreach ($getKpQuery as $row) {
                    $kpName = $row['kp_name'];
                    $kpEngName = $row['kp_name_eng'];
                    $kpType = $row['kp_type'];
                    $ukolSa = $kpName;
                }




                //getcomplainant
                $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$complaintRefNo'";
                $getComplainantQuery = $con->query($getComplainant);
                foreach ($getComplainantQuery as $row2) {
                    $compId = $row2['comp_id'];

                    $getComplainant1 = "SELECT * FROM rbi WHERE id = '$compId'";
                    $getComplainantQuery1 = $con->query($getComplainant1);
                    foreach ($getComplainantQuery1 as $row3) {
                        $rbiFname = $row3['first_name'] . " " . $row3['middle_name'] . " " . $row3['last_name'] . "<br>";

                        $endorseComplainant .= strtoupper($rbiFname);
                    }
                }

                //getdefendat
                $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
                $getDefendantQuery = $con->query($getDefendant);
                foreach ($getDefendantQuery as $row2) {
                    $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'] . "<br>";
                    $endorseDefendant .= strtoupper($defFullname);
                }


                $meetMonth11 = date("F", strtotime($meetDate));
                $meetDay11 = date("j", strtotime($meetDate));
                $meetYear11 = date("Y", strtotime($meetDate));


                require './barangay-complaint-document.print.php';
            }
        }
    } else {
        $message = "Meeting is only up to 3.";
    }
}

//get the ref number of case
//kukunin mo yung bilang ng meeting na may ganong ref number
//where case refno = AND meeting no = 
//kukunin mo yung timeended or meet_status
//check kung "--" yung timeended or meetstatus
//if hindi ganon insert

if (isset($_POST['addMeetingBtn1'])) {
    $complaintId = $_POST['id'];
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

        $checkMeetStatus = "SELECT * FROM meeting WHERE case_ref_no = '$complaintRef' AND meeting_no = '$getMeetingCount'";
        $checkMeetStatusQue = $con->query($checkMeetStatus);
        foreach ($checkMeetStatusQue as $rrow) {
            $meetStatus = $rrow['meet_status'];
            if ($meetStatus != '--') {
                // Insert meeting to the meeting table
                $meetMonth = date("m", strtotime($meetDate));
                $setMeeting = "INSERT INTO meeting (case_ref_no, meeting_no, meet_date, time_start, remarks, time_ended, meet_status, meet_minutes, mont) VALUES ('$complaintRef','$meetCount','$meetDate','$meetTime','$meetRemarks', '--', '--', '--', '$meetMonth')";
                if ($con->exec($setMeeting)) {
                    $tab = "ongoing";
                    $confirm = "yes";
                    $message = "Meeting is successfully added";
                }
            } else {
                $tab = "ongoing";
                $message = "Meeting " . $getMeetingCount . " is still ongoing";
            }
        }
    } else {
        $tab = "ongoing";
        $message = "Meeting is only up to 3.";
    }
}

if (isset($_POST['toEndMeetingBtn'])) {
    $meetingId = $_POST['id'];
    $refNo = $_POST['compRefNo'];
    $meetingStatus = $_POST['meetingStatus'];
    $minutesMeetingName = time() . "_" . $_FILES['minutesDocs']['name'];
    $minutesTarget = '../assets/minutes/' . $minutesMeetingName;


    $timeNow = date("g:i a");
    if (move_uploaded_file($_FILES['minutesDocs']['tmp_name'], $minutesTarget)) {
        $endMeetingSqul = "UPDATE meeting SET time_ended = :te, meet_status = :ms, meet_minutes = :mm WHERE id = :id";
        $unreadstmt = $con->prepare($endMeetingSqul);
        if ($unreadstmt->execute([
            ':te' => $timeNow,
            ':ms' => $meetingStatus,
            ':mm' => $minutesMeetingName,
            ':id' => $meetingId

        ])) {
            $tab = "ongoing";
            $confirm = "yes";
            $message = "Successfully ended the meeting";
        }
    } else {
        $tab = "ongoing";
        $message = "MOVE UPLOAD FAILED";
    }
}

if (isset($_POST['toCompletedBtn'])) {
    $id = $_POST['id'];
    $refNo = $_POST['compRefNo'];
    $actionTaken = $_POST['actionTaken'];
    $dateToday = date("F j, Y");



    $getMeeting = "SELECT * FROM meeting WHERE case_ref_no = '$refNo'";
    $getMeetingQuery = $con->query($getMeeting);
    $getMeetingQuery->execute();

    $getMeetingCount = $getMeetingQuery->rowCount();

    $checkMeetStatus = "SELECT * FROM meeting WHERE case_ref_no = '$refNo' AND meeting_no = '$getMeetingCount'";
    $checkMeetStatusQue = $con->query($checkMeetStatus);
    foreach ($checkMeetStatusQue as $rrow) {
        $meetStatus = $rrow['meet_status'];
        if ($meetStatus != '--') {

            $getActionTakenId = "SELECT * FROM actiontaken WHERE action_taken = '$actionTaken'";
            $getActionTakenIdq = $con->query($getActionTakenId);
            foreach ($getActionTakenIdq as $row123) {
                $atid = $row123['id'];
            }
            $unreadsql = "UPDATE complaint_case SET case_status = :case_status, action_taken = :action_taken, date_completed = :dc WHERE id = :id";
            $unreadstmt = $con->prepare($unreadsql);
            if ($unreadstmt->execute([
                ':case_status' => "Completed",
                ':action_taken' => $atid,
                ':dc' => $dateToday,
                ':id' => $id

            ])) {
                $tab = "completed";
                $confirm = "yes";
                $message = "The case is successfully moved up to Completed Table.";
            }
        } else {
            $tab = "ongoing";
            $message = "Meeting " . $getMeetingCount . " is still ongoing";
        }
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
        $message = "The case is successfully moved up to Pending Table.";
    }
}

if (isset($_POST['toEndorseBtn'])) {
    $id = $_POST['id'];
    $ukolSa = $_POST['ukolSa'];
    $dateToday = date("F j, Y");
    $unreadsql = "UPDATE complaint_case SET case_status = :case_status, action_taken = :att, nod = :nod, date_completed = :dc WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "Completed",
        ':att' => "9",
        ':nod' => "25",
        ':dc' => $dateToday,
        ':id' => $id

    ])) {
        $tab = "completed";
        $confirm = "yes";
        $message = "The case is successfully moved up to Completed Table.";

        $getDocNo = "SELECT * FROM complaint_case WHERE id = '$id'";
        $getDocNoq = $con->query($getDocNo);
        foreach ($getDocNoq as $row) {
            $complaintDocNo = $row['docket_number'];
            $complaintRefNo = $row['case_ref_no'];
            $complaintNod = $row['nod'];
        }

        $endorseComplainant = "";
        $endorseDefendant = "";


        //getcomplainant
        $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$complaintRefNo'";
        $getComplainantQuery = $con->query($getComplainant);
        foreach ($getComplainantQuery as $row2) {
            $compId = $row2['comp_id'];

            $getComplainant1 = "SELECT * FROM rbi WHERE id = '$compId'";
            $getComplainantQuery1 = $con->query($getComplainant1);
            foreach ($getComplainantQuery1 as $row3) {
                $rbiFname = $row3['first_name'] . " " . $row3['middle_name'] . " " . $row3['last_name'] . "<br>";

                $endorseComplainant .= strtoupper($rbiFname);
            }
        }

        //getdefendat
        $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
        $getDefendantQuery = $con->query($getDefendant);
        foreach ($getDefendantQuery as $row2) {
            $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'] . "<br>";
            $endorseDefendant .= strtoupper($defFullname);
        }



        require './barangay-complaint-endorse.print.php';
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
            <?php
            //SHOW ALERT MESSAGE 
            if ($countMeeting0 > 0 or $countMeeting10 > 0) {
            ?>
                <div class="alert alert-dismissible alertMeeting fade show py-4" role="alert">
                    <div class="d-flex">
                        <div class="align-self-center mx-3">
                            <i class="fas fa-info-circle fa-3x"></i>
                        </div>
                        <div class="align-self-center">
                            <strong>Hey! <?php
                                            if ($countMeeting10 > 0) {
                                                echo "You have <b>$countMeeting10 meeting</b> today.";
                                            }
                                            if ($countMeeting0 > 0) {
                                                echo "You have <b>$countMeeting0 meeting</b> on the ongoing complaint that are not completed.";
                                            }
                                            ?>
                            </strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                </div>
            <?php
            }
            ?>
            <section id="list-count" class="mb-4">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center "><i class="fas fa-user-edit fa-2x mr-3 icon5"></i></div>
                                    <?php
                                    $pendingcountsql = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'complaint' AND case_status = 'pending'";
                                    $pendingcountstmt = $con->prepare($pendingcountsql);
                                    $pendingcountstmt->execute();
                                    $pendingcount = $pendingcountstmt->rowCount();
                                    ?>
                                    <div class="col-sm-8 text-right">
                                        <h5 class="card-text"><?php echo $pendingcount ?></h5>
                                        <small class="card-text">Pending Complaints</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center "><i class="fas fa-user-edit fa-2x mr-3 icon3"></i></div>
                                    <?php
                                    $rejectcountsql = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'complaint' AND case_status = 'rejected'";
                                    $rejectcountstmt = $con->prepare($rejectcountsql);
                                    $rejectcountstmt->execute();
                                    $rejectcount = $rejectcountstmt->rowCount();
                                    ?>
                                    <div class="col-sm-8 text-right">
                                        <h5 class="card-text"><?php echo $rejectcount ?></h5>
                                        <small class="card-text">Rejected Complaints</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center "><i class="fas fa-user-edit fa-2x mr-3 icon4"></i></div>
                                    <?php
                                    $ongoingcountsql = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'complaint' AND case_status = 'ongoing'";
                                    $ongoingcountstmt = $con->prepare($ongoingcountsql);
                                    $ongoingcountstmt->execute();
                                    $ongoingcount = $ongoingcountstmt->rowCount();
                                    ?>
                                    <div class="col-sm-8 text-right">
                                        <h5 class="card-text"><?php echo $ongoingcount ?></h5>
                                        <small class="card-text">Ongoing Complaints</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center "><i class="fas fa-user-edit fa-2x mr-3 icon2"></i>
                                    </div>
                                    <?php
                                    $completedcountsql = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'complaint' AND case_status = 'completed'";
                                    $completedcountstmt = $con->prepare($completedcountsql);
                                    $completedcountstmt->execute();
                                    $completedcount = $completedcountstmt->rowCount();
                                    ?>
                                    <div class="col-sm-8 text-right">
                                        <h5 class="card-text"><?php echo $completedcount ?></h5>
                                        <small class="card-text">Completed Complaints</small>
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
                            <h1 class="mx-4 mt-3">List of Complaints</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <a id="addBtn" class="add1 btn text-capitalize mx-4 mt-3 hvr-icon-spin" href="./service-complaint.page.php"><i class="fas fa-plus hvr-icon mr-2"></i> Add New Complaint</a>
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
                                    <a class="nav-item btnSort nav-link <?php if ($tab == "payment") {
                                                                            echo "active";
                                                                        }  ?> px-4 mr-1" id="nav-payment-tab" data-toggle="tab" href="#nav-payment" role="tab" aria-controls="nav-payment" aria-selected="false"><span class="sortTitle">Payment</span></a>
                                    <a class="nav-item btnSort nav-link <?php if ($tab == "document") {
                                                                            echo "active";
                                                                        }  ?> px-4 mr-1" id="nav-document-tab" data-toggle="tab" href="#nav-document" role="tab" aria-controls="nav-document" aria-selected="false"><span class="sortTitle">Document</span></a>
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
                                    <form method="post">
                                        <table class="table table1 table-hover table-striped text-center" id="table1" style="width: 100%">
                                            <thead>
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

                                                //Get complaints
                                                //Get comp_rbi_no
                                                //Check the barangay 
                                                $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint' AND where_to = '$barangayName' ORDER BY id desc";
                                                $showComplaintQuery = $con->query($showComplaintSql);
                                                foreach ($showComplaintQuery as $row) {
                                                    $complaintId = $row['id'];
                                                    $complaintRefNo = $row['case_ref_no'];
                                                    $complaint = $row['complaint'];
                                                    $complaintStatus = $row['case_status'];
                                                    $complaintPic = $row['incident_pic'];
                                                    $complaintDateSubmit = $row['date_submit'];

                                                    // get the complainant
                                                    // check if the complainant lives in the barangay
                                                    // check if verified
                                                    // if verified show




                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $complaintId ?> </td>
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
                                                                                                                                                                        } elseif ($complaintStatus == "Document") {
                                                                                                                                                                            echo "#ed9969";
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
                                    </form>
                                </div>
                                <!-- END OF TABLE ALL -->

                                <!-- TABLE PENDING -->
                                <div class="tab-pane fade <?php if ($tab == "pending") {
                                                                echo "show active";
                                                            }  ?>" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                                    <table class="table table-hover table1 table-striped text-center" id="table2" style="width: 100%;">
                                        <thead>
                                            <tr class="text-center">
                                                <th>ID</th>
                                                <th scope="col">Reference Numbers </th>
                                                <th scope="col">Complainant </th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Picture</th>
                                                <th scope="col">Date of Submission</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint' AND case_status = 'Pending' AND where_to = '$barangayName'";
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
                                                        <td class="text-center"><?php echo $complaintId ?><input type="hidden" name="id" value="<?php echo $complaintId ?>" /> </td>
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

                                                                    echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>"
                                                            ?>
                                                                    <br>
                                                            <?php }
                                                            } else {
                                                                echo "--";
                                                            } ?>

                                                        </td>
                                                        <td><?php echo $complaint ?></td>
                                                        <td class="text-center"><?php
                                                                                if ($complaintPic == "none") {
                                                                                    echo "--";
                                                                                } else {
                                                                                    echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                                                }
                                                                                ?></td>
                                                        <td class="text-center"><?php echo $complaintDateSubmit ?></td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <button class="add btn acceptBtn hvr-pulse-grow" type="button"><i class="fas fa-check"></i></button>

                                                                <button class="add btn addDefBtn hvr-pulse-grow" type="button"><i class="fas fa-user-plus"></i></button>
                                                                <button class="add btn hvr-pulse-grow endorseBtn" type="button"><i class="fas fa-paper-plane"></i></button>
                                                                <button class="add btn btn-danger rejectBtn hvr-pulse-grow" type="button"><i class="fas fa-times"></i></button>
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

                                <!-- Modal for accept (PENDING TABLE) -->
                                <div class="modal fade " id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content px-4 py-4">
                                            <div class="modal-header">
                                                <div>
                                                    <h4 class="modal-title" id="myModalLabel">Katarungang Pambarangay</h4>
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
                                                    <input type="hidden" id="complaintId" name="id" />
                                                    <input type="hidden" id="compRefNo" name="compRefNo" />
                                                    <p class="mt-2 mb-1"><span class="font-weight-bold">Reference Number:</span> <span id="refNumber"></span></p>
                                                    <p class="font-weight-bold mb-2">Complaint: <span id="compComplaint" class="font-weight-light"></span></p>
                                                    <div class="complaintDiv mt-4">
                                                        <h6 class="font-weight-bolder">Choose what kind of Katarungang Pambarangay this case belongs</h6>
                                                        <select class="form-control" name="compKp">
                                                            <optgroup label="Civil Cases">
                                                                <?php
                                                                $getKP = "SELECT * FROM kplist WHERE kp_type = 'Civil'";
                                                                $getKPQuery = $con->query($getKP);
                                                                foreach ($getKPQuery as $row) {
                                                                    $kpId = $row['id'];
                                                                    $kpName = $row['kp_name'];
                                                                    $kpEngName = $row['kp_name_eng'];
                                                                    $kpType = $row['kp_type'];
                                                                ?>

                                                                    <option value="<?= $kpId ?>"><?php echo $kpName . "</span> (" . $kpEngName . ")"; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                                </optgroup">
                                                            <optgroup label="Criminal Cases">
                                                                <?php
                                                                $getKP = "SELECT * FROM kplist WHERE kp_type = 'Criminal'";
                                                                $getKPQuery = $con->query($getKP);
                                                                foreach ($getKPQuery as $row) {
                                                                    $kpId = $row['id'];
                                                                    $kpName = $row['kp_name'];
                                                                    $kpEngName = $row['kp_name_eng'];
                                                                    $kpType = $row['kp_type'];
                                                                ?>

                                                                    <option value="<?= $kpId ?>"><?php echo $kpName . "</span> (" . $kpEngName . ")"; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                                </optgroup">
                                                        </select>

                                                    </div>


                                            </div>
                                            <div class="modal-footer flex-center">
                                                <button type="submit" class="btn btnAccept text-capitalize" name="toPaymentBtn">Accept</button>
                                                </form>
                                                <button type="button" class="btn btn-danger text-capitalize" data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END OF MODAL -->

                                <!-- Modal for add defendant (PENDING TABLE) -->
                                <div class="modal fade bd-example-modal-lg" id="addDefModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content p-4">
                                            <div class="modal-header">
                                                <div>
                                                    <h4 class="modal-title" id="myModalLabel">Add Defendant</h4>
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
                                                    <input type="hidden" id="complaintId2" name="id2" />
                                                    <input type="hidden" id="compRefNo2" name="compRefNoAddDef" />
                                                    <p class="mt-3 mb-1"><span class="font-weight-bold">Reference Number:</span> <span id="refNumber2"></span></p>
                                                    <p class="font-weight-bold mb-2">Complaint: <span id="compComplaint2" class="font-weight-light"></span></p>
                                                    <div class="complaintDiv mt-4">
                                                        <h6 class="font-weight-bolder text-center mb-0 pb-0">Choose what kind of Katarungang Pambarangay this case belongs</h6>
                                                        <div class="defendantContent cC mt-3 py-3">
                                                            <h4 class="titleComplaint text-center">Defendant Information</h4>
                                                            <div id="defInfo-div">
                                                                <div id="defInfo1-div">
                                                                    <div id="waw">
                                                                        <div class="row">
                                                                            <div class="col-md-8">
                                                                                <h6>Defendant 1</h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-4">
                                                                                <label for="defFnameId">First Name</label>
                                                                                <input type="text" class="form-control" id="defFnameId" name="defFirstname[]" placeholder="First Name" />
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="defLnameId">Last Name</label>
                                                                                <input type="text" class="form-control" id="defLnameId" name="defLastname[]" placeholder="Last Name" />
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="defMnameId">Middle Name</label>
                                                                                <input type="text" class="form-control" id="defMnameId" name="defMiddlename[]" placeholder="Middle Name" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="resId">Type of Resident</label>
                                                                                <select name="defIdentity[]" class="form-control" id="resId">
                                                                                    <option value="Resident">Resident</option>
                                                                                    <option value="Official">Official</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="brId">Barangay</label>
                                                                                <select name="defBrgy[]" class="form-control" id="brId">
                                                                                    <?php
                                                                                    $barangayQuery = "SELECT DISTINCT barangay FROM account WHERE barangay != 'DILG' ORDER BY barangay";
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

                                                                        <div class="form-group">
                                                                            <label for="defAddress">Defendant Address</label>
                                                                            <input type="text" class="form-control" id="defAddress" name="defAddress[]" placeholder="Address" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <button class="btn submit1 text-capitalize" type="button" name="addDefendant" id="addDef">Add Defendant</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btnAccept text-capitalize" name="toAddDefBtn">Add Defendant/s</button>
                                                </form>
                                                <button type="button" class="btn btn-danger text-capitalize" data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END OF MODAL -->

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
                                                    <p class="mt-3 mb-1"><span class="font-weight-bold">Reference Number:</span> <span id="refNumber123"></span></p>
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


                                <!-- Modal for Endorse (PENDING TABLE) -->
                                <div class="modal fade bd-example-modal-lg" id="endorseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content p-4">
                                            <div class="modal-header">
                                                <div>
                                                    <h4 class="modal-title" id="myModalLabel">Endorse Complaint</h4>
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
                                                    <input type="hidden" id="complaintId1234" name="id" />
                                                    <input type="hidden" id="compRefNo1234" name="compRefNo" />
                                                    <p class="mt-3 mb-1"><span class="font-weight-bold">Reference Number:</span> <span id="refNumber1234"></span></p>
                                                    <p class="font-weight-bold mb-2">Complaint: <span id="compComplaint1234" class="font-weight-light"></span></p>
                                                    <div class="complaintDiv mt-4">
                                                        <h6 class="font-weight-bolder">Ang kasong ito ay ukol sa:</h6>
                                                        <textarea class="form-control" id="ukolSa" name="ukolSa" placeholder="Ukol sa" rows="3" required></textarea>

                                                    </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btnAccept text-capitalize" name="toEndorseBtn">Endorse</button>
                                                </form>
                                                <button type="button" class="btn btn-danger text-capitalize" data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END OF MODAL -->
                                <!-- END OF TABLE PENDING -->

                                <!-- TABLE PAYMENT -->
                                <div class="tab-pane fade <?php if ($tab == "payment") {
                                                                echo "show active";
                                                            }  ?>" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table3" style="width: 100%;">

                                        <thead class="">
                                            <tr class="text-center">
                                                <th>ID</th>
                                                <th scope="col">Reference Numbers</th>
                                                <th scope="col">Complainant</th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Kind of Case</th>
                                                <th scope="col">Date of Submission</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint' AND case_status = 'Payment' AND where_to = '$barangayName'";
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


                                                <tr>
                                                    <form method="post">
                                                        <td class="text-center"><?php echo $complaintId ?><input type="hidden" name="id" value="<?php echo $complaintId ?>" /> </td>
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

                                                                    echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>"
                                                            ?>
                                                                    <br>
                                                            <?php }
                                                            } else {
                                                                echo "--";
                                                            } ?>

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

                                                            if ($kpType == "Civil") {
                                                                echo  "$kpEngName ($kpName) " . '<br><span class="badge bg-primary" style="font-size: 11.5px;">Civil Case</span>';
                                                            } else {
                                                                echo  "$kpEngName ($kpName) " . '<br><span class="badge bg-danger" style="font-size: 11.5px;">Criminal Case</span>';
                                                            }
                                                            ?></td>
                                                        <td class="text-center"><?php echo $complaintDateSubmit ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button class="add btn hvr-pulse-grow" type="submit" name="toDocumentBtn"><i class="fas fa-check"></i></button>
                                                                <button class="add btn btn-danger hvr-pulse-grow rejectBtn" type="button"><i class="fas fa-times"></i></button>

                                                            </div>
                                                        </td>
                                                        <!-- <td><button class="add btn" type="submit" name="toDocumentBtn"><i class="fas fa-check"></i></button></td>
                                                        <td><button class="add btn rejectBtn" type="button"><i class="fas fa-trash"></i></button></td> -->
                                                    </form>
                                                </tr>

                                            <?php

                                            }
                                            ?>
                                        </tbody>


                                    </table>
                                </div>
                                <!-- END OF TABLE PAYMENT -->

                                <!-- TABLE DOCUMENT -->
                                <div class="tab-pane fade <?php if ($tab == "document") {
                                                                echo "show active";
                                                            }  ?>" id="nav-document" role="tabpanel" aria-labelledby="nav-document-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table4" style="width: 100%;">

                                        <thead class="">
                                            <tr class="text-center">
                                                <th>ID</th>
                                                <th scope="col">Reference Numbers</th>
                                                <th scope="col">Complainant</th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Kind of Case</th>
                                                <th scope="col">Date of Submission</th>
                                                <th scope="col">Accept</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint' AND case_status = 'Document' AND where_to = '$barangayName'";
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


                                                <tr>
                                                    <form method="post">
                                                        <td class="text-center"><?php echo $complaintId ?><input type="hidden" name="id" value="<?php echo $complaintId ?>" /> </td>
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

                                                                    echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>"
                                                            ?>
                                                                    <br>
                                                            <?php }
                                                            } else {
                                                                echo "--";
                                                            } ?>

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

                                                            if ($kpType == "Civil") {
                                                                echo  "$kpEngName ($kpName) " . '<br><span class="badge bg-primary" style="font-size: 11.5px;">Civil Case</span>';
                                                            } else {
                                                                echo  "$kpEngName ($kpName) " . '<br><span class="badge bg-danger" style="font-size: 11.5px;">Criminal Case</span>';
                                                            }
                                                            ?></td>
                                                        <td><?php echo $complaintDateSubmit ?></td>
                                                        <td><button class="add btn acceptBtn1 hvr-pulse-grow" type="button"><i class="fas fa-check"></i></button></td>
                                                    </form>
                                                </tr>

                                            <?php
                                            }
                                            ?>
                                        </tbody>


                                    </table>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade bd-example-modal-lg" id="acceptModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content p-4">
                                            <div class="modal-header">
                                                <div>
                                                    <h4 class="modal-title" id="myModalLabel">Schedule Meeting</h4>
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
                                                    <input type="hidden" id="complaintId1" name="id" />
                                                    <input type="hidden" id="complaintRef1" name="complaintRef" />
                                                    <p class="mt-3 mb-1"><span class="font-weight-bold">Reference Number:</span> <span id="refNumber1"></span></p>
                                                    <p class="font-weight-bold mb-2">Complaint: <span id="compComplaint1" class="font-weight-light"></span></p>
                                                    <div class="complaintDiv mt-4">
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
                                                            <textarea class="form-control" id="complaintId2" name="meetRemarks" placeholder="Leave a message..." rows="3"></textarea>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btnAccept text-capitalize" name="addMeetingBtn">Add Meeting</button>
                                                </form>
                                                <button type="button" class="btn btn-danger text-capitalize" data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END OF ADD MEETING MODAL -->
                                <!-- END OF TABLE DOCUMENT -->


                                <!-- TABLE ONGOING -->
                                <div class="tab-pane fade <?php if ($tab == "ongoing") {
                                                                echo "show active";
                                                            }  ?>" id="nav-ongoing" role="tabpanel" aria-labelledby="nav-ongoing-tab">
                                    <table class="table table-hover table-striped text-center" id="table44444" style="width: 100%;">

                                        <thead class="">
                                            <tr class="text-center">
                                                <th>ID </th>
                                                <th scope="col">Reference Numbers </th>
                                                <th scope="col">Complainant </th>
                                                <th scope="col">Defendant</th>
                                                <th scope="col">Complaint</th>
                                                <th scope="col">Kind of Case</th>
                                                <th scope="col">Date of Submission</th>
                                                <th scope="col">Action</th>
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

                                                <tr data-toggle="collapse" data-target="#accordion<?php echo $complaintId ?>" class="accordion-toggle clickable">
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

                                                                    echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>"
                                                            ?>
                                                                    <br>
                                                            <?php }
                                                            } else {
                                                                echo "--";
                                                            } ?>


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

                                                            if ($kpType == "Civil") {
                                                                echo  "$kpEngName ($kpName) " . '<br><span class="badge bg-primary" style="font-size: 11.5px;">Civil Case</span>';
                                                            } else {
                                                                echo  "$kpEngName ($kpName) " . '<br><span class="badge bg-danger" style="font-size: 11.5px;">Criminal Case</span>';
                                                            }
                                                            ?></td>
                                                        <td><?php echo $complaintDateSubmit ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button class="add btn toCompleteModalBtn hvr-pulse-grow" type="button"><i class="fas fa-check"></i></button>
                                                                <button class="add btn addMeetingOngoingBtn hvr-pulse-grow" type="button"><i class="fas fa-plus"></i></button>
                                                            </div>
                                                        </td>

                                                    </form>
                                                </tr>
                                                <tr class="meeting" style="background-color: rgba(249, 251, 255, 1);">
                                                    <td colspan="12" class="hiddenRow">
                                                        <div class="accordian-body collapse" id="accordion<?php echo $complaintId ?>">
                                                            <h5 class="text-center mt-4">Meetings</h5>

                                                            <table class="table table-stripped">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Meeting ID</th>
                                                                        <th class="text-center">Meeting No.</th>
                                                                        <th class="text-center">Date of meeting</th>
                                                                        <th class="text-center">Scheduled Time</th>
                                                                        <th class="text-center">Time Ended</th>
                                                                        <th class="text-center">Remarks</th>
                                                                        <th class="text-center">Meeting Status</th>
                                                                        <th class="text-center">Minutes of the meeting</th>
                                                                        <th class="text-center">End</th>
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
                                                                            $meetingId = $row['id'];
                                                                            $meetingNumber = $row['meeting_no'];
                                                                            $meetingDate = $row['meet_date'];
                                                                            $meetingTime = $row['time_start'];
                                                                            $meetingRemarks = $row['remarks'];
                                                                            $meetingTimeEnded = $row['time_ended'];
                                                                            $meetingStatus = $row['meet_status'];
                                                                            $meetingMinutes = $row['meet_minutes'];
                                                                    ?>

                                                                            <tr>
                                                                                <td><?php echo $meetingId; ?></td>
                                                                                <td style="display: none;"><?php echo $complaintRefNo; ?></td>
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
                                                                                        <a href="../assets/minutes/<?php echo $meetingMinutes ?>" target="_blank">minutesofthemeeting.docs</a>

                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td><button class="add btn endMeetingBtn hvr-pulse-grow" type="button" <?php
                                                                                                                                                        if ($meetingStatus != "--") {
                                                                                                                                                            echo "disabled";
                                                                                                                                                        }
                                                                                                                                                        $dateeToday = date('Y-m-d');
                                                                                                                                                        $dateMeeting = date('Y-m-d', strtotime($meetingDate));
                                                                                                                                                        if ($dateeToday < $dateMeeting) {
                                                                                                                                                            echo "disabled";
                                                                                                                                                        }
                                                                                                                                                        ?>><i class="fas fa-arrow-right"></i></button></td>
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


                                            <?php

                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal for add meeting (ONGOING TABLE) -->
                                <div class="modal fade bd-example-modal-lg" id="addMeetingOngoingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content p-4">
                                            <div class="modal-header">
                                                <div>
                                                    <h4 class="modal-title" id="myModalLabel">Schedule Meeting</h4>
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
                                                    <input type="hidden" id="complaintId14" name="id" />
                                                    <input type="hidden" id="complaintRef14" name="complaintRef" />
                                                    <p class="mt-3 mb-2"><span class="font-weight-bold">Reference Number:</span> <span id="refNumber14"></span></p>
                                                    <p class="font-weight-bold mb-2">Complaint: <span id="compComplaint14" class="font-weight-light"></span></p>
                                                    <div class="complaintDiv mt-4">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="inciDateId4">Scheduled date</label>
                                                                <input class="form-control" id="inciDateId4" type="date" name="meetDate" required />
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="inciTimeId4">Scheduled Time</label>
                                                                <input class="form-control" id="inciTimeId4" type="time" name="meetTime" required />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="complaintId1">Remarks</label>
                                                            <textarea class="form-control" id="complaintId4" name="meetRemarks" placeholder="Leave a message..." rows="3"></textarea>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btnAccept text-capitalize" name="addMeetingBtn1">Add Meeting</button>
                                                </form>
                                                <button type="button" class="btn btn-danger text-capitalize" data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END OF ADD MEETING MODAL -->

                                <!-- Modal for End Meeting (Ongoing TABle) -->
                                <div class="modal fade bd-example-modal-lg" id="endMeetingTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content p-4">
                                            <div class="modal-header">
                                                <div>
                                                    <h4 class="modal-title" id="myModalLabel">End Meeting</h4>
                                                    <p><span style="font-size: 13px; font-weight: 300;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, aspernatur odit<span></p>
                                                </div>


                                                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body mx-5">
                                                <form method="post" enctype="multipart/form-data">
                                                    <h5 class="text-capitalize text-center"><i class="fas fa-info-circle fa-2x mr-2" style=" color: #111580;"></i>Brief information</h5>
                                                    <hr>
                                                    <input type="hidden" id="complaintId22" name="id" />
                                                    <input type="hidden" id="compRefNo22" name="compRefNo" />

                                                    <p class="mt-3 mb-2"><span class="font-weight-bold">Reference Number:</span> <span id="refNumber22"></span></p>
                                                    <p class="font-weight-bold mb-2"><span id="compComplaint22"></span></p>
                                                    <div class="complaintDiv mt-4">
                                                        <h6 class="font-weight-bolder">Choose what is the status of the meeting</h6>
                                                        <select class="form-control" name="meetingStatus">
                                                            <optgroup label="Meeting Status">
                                                                <option value="Di pumunta">Hindi pumunta</option>
                                                                <option value="Nagkaayos">Nagkaayos</option>
                                                                <option value="Hindi nagkaayos">Hindi nagkaayos</option>
                                                                </optgroup">

                                                        </select>
                                                        <h6 class="font-weight-bolder mt-3">Add minutes of the meeting</h6>
                                                        <input type="file" name="minutesDocs" id="minutesDocs" class="form-control-file transparent text-center" style="margin: auto;" required><br>

                                                    </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btnAccept text-capitalize" name="toEndMeetingBtn">End Meeting</button>
                                                </form>
                                                <button type="button" class="btn btn-danger text-capitalize" data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END OF MODAL -->

                                <!-- Modal for completing the meeting (ONGOING TABLE) -->
                                <div class="modal fade bd-example-modal-lg" id="toCompleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content p-4">
                                            <div class="modal-header">
                                                <div>
                                                    <h4 class="modal-title" id="myModalLabel">Complete the Complaint</h4>
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
                                                    <input type="hidden" id="complaintId55" name="id" />
                                                    <input type="hidden" id="complaintRef55" name="compRefNo" />
                                                    <p class="mt-3 mb-2"><span class="font-weight-bold">Reference Number:</span> <span id="refNumber55"></span></p>
                                                    <p class="font-weight-bold mb-2">Complaint: <span id="compComplaint55" class="font-weight-light"></span></p>
                                                    <div class="complaintDiv mt-4">
                                                        <h6 class="font-weight-bolder">Choose what is the action taken for this case</h6>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <select id="actionTypeSelect" class="form-control" name="actionType">
                                                                    <optgroup label="Type of action taken">
                                                                        <option value="settled">Settled Case</option>
                                                                        <option value="unsettled">Unsettled</option>

                                                                        </optgroup">

                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <select id="actionTakenSelect" class="form-control" name="actionTaken">
                                                                    <?php
                                                                    $actionTakenQuery = "SELECT action_taken FROM actiontaken WHERE action_type = 'settled'";
                                                                    $actionTakenStmt = $con->query($actionTakenQuery);
                                                                    foreach ($actionTakenStmt as $row) {
                                                                        $actionTakenRow = $row['action_taken'];

                                                                    ?>


                                                                        <option class="text-capitalize" value="<?php echo $actionTakenRow ?>"><?php echo ucwords($actionTakenRow) ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btnAccept text-capitalize" name="toCompletedBtn">Complete</button>
                                                </form>
                                                <button type="button" class="btn btn-danger text-capitalize" data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END OF ADD MEETING MODAL -->
                                <!-- END OF TABLE ONGOING -->

                                <!-- TABLE COMPLETED -->
                                <div class="tab-pane fade <?php if ($tab == "completed") {
                                                                echo "show active";
                                                            }  ?>" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab">
                                    <form method="post">
                                        <table class="table table1 table-hover table-striped text-center" id="table12312312" style="width: 100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>ID</th>
                                                    <th scope="col">Reference Numbers</th>
                                                    <th scope="col">Complainant</th>
                                                    <th scope="col">Defendant</th>
                                                    <th scope="col">Complaint</th>
                                                    <th scope="col">Kind of Case</th>
                                                    <th scope="col">Action taken</th>
                                                    <th scope="col">Date Submitted</th>
                                                    <th scope="col">Date Finished</th>
                                                    <th scope="col">View Meeting</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php

                                                //Get complaints
                                                //Get comp_rbi_no
                                                //Check the barangay 
                                                $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint' AND case_status = 'Completed' AND where_to = '$barangayName'";
                                                $showComplaintQuery = $con->query($showComplaintSql);
                                                foreach ($showComplaintQuery as $row) {
                                                    $complaintId = $row['id'];
                                                    $complaintRefNo = $row['case_ref_no'];
                                                    $complaint = $row['complaint'];
                                                    $complaintDateSubmit = $row['date_submit'];
                                                    $complaintDateCompleted = $row['date_completed'];
                                                    $complaintNod = $row['nod'];
                                                    $complaintActionTaken = $row['action_taken'];

                                                    // get the complainant
                                                    // check if the complainant lives in the barangay
                                                    // check if verified
                                                    // if verified show
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

                                                                    echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>"
                                                            ?>
                                                                    <br>
                                                            <?php }
                                                            } else {
                                                                echo "--";
                                                            } ?>

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

                                                            if ($kpType == "Civil") {
                                                                echo  "$kpEngName ($kpName) " . '<br><span class="badge bg-primary" style="font-size: 11.5px;">Civil Case</span>';
                                                            } elseif ($kpType == "Criminal") {
                                                                echo  "$kpEngName ($kpName) " . '<br><span class="badge bg-danger" style="font-size: 11.5px;">Criminal Case</span>';
                                                            } else {
                                                                echo "--";
                                                            }
                                                            ?></td>
                                                        <td class="text-capitalize"><?php
                                                                                    $getCompAt = "SELECT * FROM actiontaken WHERE id = '$complaintActionTaken'";
                                                                                    $getCompAtQ = $con->query($getCompAt);
                                                                                    foreach ($getCompAtQ as $row21) {
                                                                                        $actionTakenName = $row21['action_taken'];
                                                                                        $actionTypeName = $row21['action_type'];
                                                                                    }
                                                                                    if ($actionTypeName == "settled") {
                                                                                        echo  "$actionTakenName" . '<br><span class="badge bg-info" style="font-size: 11.5px;">Settled</span>';
                                                                                    } else {
                                                                                        echo  "$actionTakenName" . '<br><span class="badge bg-warning" style="font-size: 11.5px;">Not Settled</span>';
                                                                                    }
                                                                                    ?></td>
                                                        <td class="text-center"><?php echo $complaintDateSubmit ?></td>
                                                        <td class="text-center"><?php echo $complaintDateCompleted ?></td>
                                                        <td class="text-center"><button class="add btn hvr-pulse-grow" type="button" data-toggle="modal" data-target="#meetingModal<?php echo $complaintRefNo ?>"><i class="far fa-eye"></i></button>
                                                            <?php include('./barangay-complaint-meeting.modal.php'); ?>
                                                        </td>

                                                    </tr>



                                                <?php

                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <!-- END OF TABLE COMPLETED -->

                                <!-- TABLE REJECT -->
                                <div class="tab-pane fade <?php if ($tab == "reject") {
                                                                echo "show active";
                                                            }  ?>" id="nav-reject" role="tabpanel" aria-labelledby="nav-reject-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table6123123" style="width: 100%;">

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
                                            $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint' AND case_status = 'Rejected' AND where_to = '$barangayName'";
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
                                                        <td><?php echo $complaintId ?><input type="hidden" name="id" value="<?php echo $complaintId ?>" /> </td>
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

                                                                    echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>"
                                                            ?>
                                                                    <br>
                                                            <?php }
                                                            } else {
                                                                echo "--";
                                                            } ?>

                                                        </td>
                                                        <td><?php echo $complaint ?></td>
                                                        <td><?php echo $complaintExp ?></td>
                                                        <td class="text-center"><?php
                                                                                if ($complaintPic == "none") {
                                                                                    echo "--";
                                                                                } else {
                                                                                    echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                                                }
                                                                                ?></td>
                                                        <td class="text-center"><?php echo $complaintDateSubmit ?></td>
                                                        <td class="text-center"><button class="add btn hvr-pulse-grow" type="submit" name="toPendingBtn" onclick="return confirm('Do you want to retrieve this case?')"><i class="fas fa-arrow-left"></i></button></td>
                                                    </form>
                                                </tr>

                                            <?php

                                            }
                                            ?>
                                        </tbody>


                                    </table>

                                </div>
                                <!-- END OF TABLE REJECT -->

                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                "order": [
                    [0, "desc"]
                ]
            });


            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            table.$("[data-toggle=popover]").popover().click(function(e) {
                e.preventDefault();
            });

            $('.acceptBtn').on('click', function() {
                $('#acceptModal').modal('show');

                $tr = $(this).closest('tr');

                var tddata = $tr.children("td").map(function() {
                    return $(this).text();

                }).get();

                $('#complaintId').val(tddata[0]);
                $('#compRefNo').val(tddata[1]);
                $('#refNumber').text(tddata[1]);
                $('#compComplaint').text(tddata[4]);
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

            $('.endorseBtn').on('click', function() {
                $('#endorseModal').modal('show');

                $tr = $(this).closest('tr');

                var tddata = $tr.children("td").map(function() {
                    return $(this).text();

                }).get();

                $('#complaintId1234').val(tddata[0]);
                $('#compRefNo1234').val(tddata[1]);
                $('#refNumber1234').text(tddata[1]);
                $('#compComplaint1234').text(tddata[4]);
            });

            $('.addDefBtn').on('click', function() {
                $('#addDefModal').modal('show');

                $tr = $(this).closest('tr');

                var tddata = $tr.children("td").map(function() {
                    return $(this).text();

                }).get();

                $('#complaintId2').val(tddata[0]);
                $('#compRefNo2').val(tddata[1]);
                $('#refNumber2').text(tddata[1]);
                $('#compComplaint2').text(tddata[4]);
            });

            //ADD MEETING PAYMENT TABLE

            $('.acceptBtn1').on('click', function() {
                $('#acceptModal1').modal('show');

                $tr = $(this).closest('tr');

                var tddata = $tr.children("td").map(function() {
                    return $(this).text();

                }).get();

                $('#complaintId1').val(tddata[0]);
                $('#complaintRef1').val(tddata[1]);
                $('#refNumber1').text(tddata[1]);
                $('#compComplaint1').text(tddata[4]);


            });


            // ADD MEETING ONGOING TABLE
            $('.addMeetingOngoingBtn').on('click', function() {
                $('#addMeetingOngoingModal').modal('show');

                $tr = $(this).closest('tr');

                var tddata = $tr.children("td").map(function() {
                    return $(this).text();

                }).get();

                $('#complaintId14').val(tddata[0]);
                $('#complaintRef14').val(tddata[1]);
                $('#refNumber14').text(tddata[1]);
                $('#compComplaint14').text(tddata[4]);


            });

            // END MEETING ONGOING TABLE
            $('.endMeetingBtn').on('click', function() {
                $('#endMeetingTable').modal('show');

                $tr = $(this).closest('tr');

                var tddata = $tr.children("td").map(function() {
                    return $(this).text();

                }).get();

                $('#complaintId22').val(tddata[0]);
                $('#compRefNo22').val(tddata[1]);
                $('#refNumber22').text(tddata[1]);
                $('#compComplaint22').text(tddata[2]);
            });

            // TO COMPLETE TABLE MODAL
            $('.toCompleteModalBtn').on('click', function() {
                $('#toCompleteModal').modal('show');

                $tr = $(this).closest('tr');

                var tddata = $tr.children("td").map(function() {
                    return $(this).text();

                }).get();

                $('#complaintId55').val(tddata[0]);
                $('#complaintRef55').val(tddata[1]);
                $('#refNumber55').text(tddata[1]);
                $('#compComplaint55').text(tddata[4]);


            });


            // ADD DEFENDANT
            var x = 1;
            var max = 2;


            $("#addDef").click(function() {
                if (x <= max) {
                    var divAnotherDef = '<div id="waw"><div class="row"><div class="col-md-8"><h6>Defendant ' + (x + 1) + '</h6></div><div class="col-md-4"><div class="float-right"><input class="btn btn-danger" type="button" name="removeDefendant" value="X" id="removeDef" / ></div></div></div><div class="form-row"><div class="form-group col-md-4"><label for="defFnameId">First Name</label><input type="text" class="form-control" id="defFnameId" name="defFirstname[]" placeholder="First Name" /></div><div class="form-group col-md-4"><label for="defLnameId">Last Name</label><input type="text" class="form-control" id="defLnameId" name="defLastname[]" placeholder="Last Name" /></div><div class="form-group col-md-4"><label for="defMnameId">Middle Name</label><input type="text" class="form-control" id="defMnameId" name="defMiddlename[]" placeholder="Middle Name" /></div></div><div class="form-row"><div class="form-group col-md-6"><label for="resId">Type of Resident</label><select name="defIdentity[]" class="form-control" id="resId"><option value="Resident">Resident</option><option value="Official">Official</option></select></div><div class="form-group col-md-6"><label for="brId">Barangay</label><select name="defBrgy[]" class="form-control" id="brId"><?php $barangayQuery = "SELECT DISTINCT barangay FROM account WHERE barangay != 'DILG' ORDER BY barangay";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $barangayStmt = $con->query($barangayQuery);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                foreach ($barangayStmt as $row) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $barangayRow = $row['barangay']; ?><option value="<?php echo $barangayRow ?>"><?php echo $barangayRow ?></option><?php } ?></select></div></div><div class="form-group"><label for="defAddress">Defendant Address</label><input type="text" class="form-control" id="defAddress" name="defAddress[]" placeholder="Address" /></div></div>';

                    $("#defInfo1-div").append(divAnotherDef);
                    x++;
                }
            });

            $("#defInfo1-div").on('click', '#removeDef', function() {
                $(this).closest('#waw').remove();
                x--;
            });



            $("#actionTypeSelect").change(function() {
                var actiontype = $("#actionTypeSelect").val();
                $.ajax({
                    url: 'get-actiontaken.php',
                    method: 'post',
                    data: 'actionTaken=' + actiontype
                }).done(function(purok) {
                    console.log(purok);
                    purok1 = JSON.parse(purok);
                    $('#actionTakenSelect').empty();
                    purok1.forEach(function(puroks) {
                        const toTitleCase = str => str.replace(/(^\w|\s\w)/g, m => m.toUpperCase());
                        $('#actionTakenSelect').append('<option class="text-capitalize" value="' + puroks.action_taken + '">' + toTitleCase(puroks.action_taken) + ' </option>')
                    })
                })
            })
        });

        $(function() {
            // Enables popover para doon sa parang facebook pag hinover
            $("[data-toggle=popover]").popover();
        });

        $('.clickable').click(function() {
            if ($(this).attr('aria-expanded') == "true") {
                $(this).children().css({
                    'background-color': 'white',
                    'color': 'initial'
                });

            } else {
                $(this).children().css({
                    'background-color': '#1F5493',
                    'color': 'white'
                });

            }
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