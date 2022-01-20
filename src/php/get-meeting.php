<?php
session_start();
require_once 'database/config.php';

if (isset($_POST['brgy'])) {
    $data = array();
    $complainant = "";
    $defendant = "";
    $brgyGet = $_POST['brgy'];
    $query = "SELECT * FROM meeting ORDER by id";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $purok = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($purok as $row) { //for meeting
        $compRefNo = $row['case_ref_no'];
        $checkBrgy = "SELECT * FROM complaint_case WHERE case_ref_no = '$compRefNo'";
        $checkBrgyQue = $con->query($checkBrgy);

        foreach ($checkBrgyQue as $row1) { //get brgy
            $complaint = $row1['complaint'];
            $brgy = $row1['where_to'];

            //get complainant
            $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$compRefNo'";
            $getComplainantQuery = $con->query($getComplainant);
            foreach ($getComplainantQuery as $row2) {
                $compId = $row2['comp_id'];

                $getComplainant1 = "SELECT * FROM rbi WHERE id = '$compId'";
                $getComplainantQuery1 = $con->query($getComplainant1);
                foreach ($getComplainantQuery1 as $row3) {
                    $rbiFname = $row3['first_name'] . " " . $row3['middle_name'] . " " . $row3['last_name'];
                }
                $complainant = $complainant . $rbiFname . ". ";
            }

            //get defendant
            $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$compRefNo'";
            $getDefCountPrep = $con->prepare($getDefendant);
            $getDefCountPrep->execute();
            $getDefCount = $getDefCountPrep->rowCount();
            if ($getDefCount > 0) {
                $getDefendantQuery = $con->query($getDefendant);
                foreach ($getDefendantQuery as $row2) {
                    $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                    $defendant = $defendant . $defFullname . ". ";
                }
            } else {
                $defendant = "--";
            }

            if ($brgy == $brgyGet) { //checkbrgy

                //calendar data
                $meetingDate = $row['meet_date'];
                $meetingTime = $row['time_start'];
                $caseRefNo = $row['case_ref_no'];
                $meetingNo = "Meeting No. " . $row['meeting_no'];
                $start = $row['meet_date'] . " " . $row["time_start"] . ":00";
                $end = $row['meet_date'] . " " . "23:59:00";
                $complaint = $row1['complaint'];
                $data[] = array(
                    'id' => "meeting",
                    'title' => $caseRefNo,
                    'start' => $start,
                    'end' => $end,
                    'complainant' => $complainant,
                    'defendant' => $defendant,
                    'complaint' => $complaint,
                    'meeting' => $meetingNo,
                    'refNo' => $caseRefNo,
                    'datee' => $meetingDate,
                    'timee' => $meetingTime,
                );
            }
        }
        $complainant = "";
        $defendant = "";
    }
    echo json_encode($data);
}
