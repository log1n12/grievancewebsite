<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';

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
                echo "wawawa";


               



            }
        }
    }
}
