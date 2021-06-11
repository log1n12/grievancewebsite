<?php
session_start();
require_once 'database/config.php';
$message = "";

if (isset($_POST['submitComplaint'])) {
    $compFname = $_POST["compFname"];
    $compLname = $_POST["compLname"];
    $compMname = $_POST["compMname"];
    $compBrgy = $_POST["compBrgy"];
    $compPurok = $_POST["compPurok"];
    $compHouseNo = $_POST["compHouseNo"];
    $compAddress = $_POST["compAddress"];
    $compBday = $_POST["compBday"];
    $compBplace = $_POST["compBplace"];
    $compGender = $_POST["compGender"];
    $compCivStatus = $_POST["compCivStatus"];
    $compCitizenship = $_POST["compCitizenship"];
    $compOccup = $_POST["compOccup"];
    $compRelToHead = $_POST["compRelToHead"];
    $compNumber = $_POST["compNumber"];


    date_default_timezone_set("Asia/Manila");
    $complaintTime = date("His");
    $complaintDate = date("Ymd");
    $complaintDate1 = date("F d, Y");
    $complaintMonth = date("F");
    $complaintYear = date("Y");
    $complainRefNumber = "R" . $complaintDate . "" . $complaintTime;

    $defFullName = $_POST["defFullname"];
    $defBrgy = $_POST["defBrgy"];
    $defAddress = $_POST["defAddress"];
    $defIdentity = $_POST["defIdentity"];

    $compRBIid = "";
    $compComplaint = $_POST["compComplaint"];
    $compDate = $_POST["compDate"];
    $compTime = $_POST["compTime"];
    $compWhere = $_POST["compWhere"];

    //CHECK IF USER IS EXISTING

    $checkCompQuery = "SELECT * FROM rbi WHERE first_name = :fname AND middle_name = :mname AND last_name = :lname AND house_no = :houseno AND brgy = :brgy AND purok = :purok";
    $checkCompStmt = $con->prepare($checkCompQuery);
    $checkCompStmt->execute([
        'fname' => $compFname,
        'mname' => $compMname,
        'lname' => $compLname,
        'houseno' => $compHouseNo,
        'brgy' => $compBrgy,
        'purok' => $compPurok
    ]);
    $countComp = $checkCompStmt->rowCount();
    $getCompQuery = "SELECT * FROM rbi WHERE first_name = '$compFname' AND middle_name = '$compMname' AND last_name = '$compLname' AND house_no = '$compHouseNo' AND brgy = '$compBrgy' AND purok = '$compPurok'";
    if ($countComp > 0) {
        foreach ($defFullName as $key => $value) {
            $addToDef = "INSERT INTO defendant (case_ref_no, full_name, def_address, barangay, position) VALUES ('$complainRefNumber', '$value', '$defAddress[$key]', '$defBrgy[$key]', '$defIdentity[$key]')";
            $con->exec($addToDef);
        }

        //GET THE ID IN RBI TABLE OF COMPLAINANT
        $getCompId = $con->query($getCompQuery);
        foreach ($getCompId as $row) {
            $compRBIid = $row['id'];
        }

        //INSERT THE COMPLAINT TO COMPLAINT_CASE TABLE
        $addToComp = "INSERT INTO complaint_case (case_ref_no, comp_rbi_no, complaint, incident_date, incident_time, incident_place, incident_year, incident_month, incident_pic, case_status, date_submit, complaint_type) VALUES ('$complainRefNumber','$compRBIid',:complaint,'$compDate','$compTime','$compWhere','$complaintYear','$complaintMonth','none','Pending','$complaintDate1','report')";
        $addtoCompStmt = $con->prepare($addToComp);
        $addtoCompStmt->execute(array(
            ':complaint' => $compComplaint
        ));
    } else {
        //INSERT DATA TO RBI TABLE
        $addToRBI = "INSERT INTO rbi (first_name, middle_name, last_name,  brgy, purok, house_no, comp_address, birth_date, birth_place, gender, civil_status, citizenship, occupation, relationship, contact_no) VALUES ('$compFname','$compMname','$compLname','$compBrgy','$compPurok','$compHouseNo','$compAddress','$compBday','$compBplace','$compGender','$compCivStatus','$compCitizenship','$compOccup','$compRelToHead','$compNumber')";
        $con->exec($addToRBI);

        foreach ($defFullName as $key => $value) {
            $addToDef = "INSERT INTO defendant (case_ref_no, full_name, def_address, barangay, position) VALUES ('$complainRefNumber', '$value', '$defAddress[$key]', '$defBrgy[$key]', '$defIdentity[$key]')";
            $con->exec($addToDef);
        }

        //GET THE CONTACT NUMBER OF HOUSEHOLD HEAD AND MESSAGE

        //GET THE ID IN RBI TABLE OF COMPLAINANT
        $getCompId = $con->query($getCompQuery);
        foreach ($getCompId as $row) {
            $compRBIid = $row['id'];
        }
        //INSERT THE COMPLAINT TO COMPLAINT_CASE TABLE
        $addToComp = "INSERT INTO complaint_case (case_ref_no, comp_rbi_no, complaint, incident_date, incident_time, incident_place, incident_year, incident_month, incident_pic, case_status, date_submit, complaint_type) VALUES ('$complainRefNumber','$compRBIid',:complaint,'$compDate','$compTime','$compWhere','$complaintYear','$complaintMonth','none','Pending','$complaintDate1','report')";
        $addtoCompStmt = $con->prepare($addToComp);
        $addtoCompStmt->execute(array(
            ':complaint' => $compComplaint
        ));
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

    <link rel="stylesheet" type="text/css" href="../css/main.style.css">

    <title>Document</title>
</head>

<body>
    <?php include './navbar/main.navbar.php'; ?>
    <section id="banner-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./service.page.php">Services</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Complaint</li>
                </ol>
            </nav>
            <h1>Complaint</h1>
        </div>
    </section>

    <section id="form-section">
        <div class="container">
            <form method="post">
                <!-- COMPLAINANT PERSONAL INFORMATION -->
                <h4>Personal Information</h4>
                <h3><?php echo $message; ?></h3>
                <input type="text" name="compFname" placeholder="First Name" />
                <input type="text" name="compLname" placeholder="Last Name" />
                <input type="text" name="compMname" placeholder="Middle Name" />

                <select name="compBrgy">
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
                <select name="compPurok">
                    <option value="Purok 1">Purok 1</option>
                    <option value="Purok 2">Purok 2</option>
                    <option value="Purok 3">Purok 3</option>
                </select>
                <input type="text" name="compHouseNo" placeholder="House No." />
                <input type="text" name="compAddress" placeholder="Address" />
                <input type="date" name="compBday" placeholder="Birthdate" />
                <input type="text" name="compBplace" placeholder="Place of Birth" />
                <input type="radio" name="compGender" value="Male" checked />Male
                <input type="radio" name="compGender" value="Female" />Female
                <input type="text" name="compCivStatus" placeholder="Civil Status" />
                <input type="text" name="compCitizenship" placeholder="Citizenship" />
                <input type="text" name="compOccup" placeholder="Occupation" />
                <input type="text" name="compRelToHead" placeholder="Relationship to Household Head" />
                <input type="text" name="compNumber" placeholder="Contact Number" />

                <h4>Complain</h4>
                <div id="compComplaint-div">
                    <input type="text" name="compComplaint" placeholder="Complaint" />
                    <input type="date" name="compDate" placeholder="Date" />
                    <input type="time" name="compTime" placeholder="Time" />
                    <input type="text" name="compWhere" placeholder="Where" />
                </div>
                <h4>Defendant Information</h4>
                <div id="defInfo-div">
                    <div id="defInfo1-div">
                        <input type="button" name="addDefendant" value="Add Another Defendant" id="addDef" />
                        <button type="button" name="noDefInfo" value="defPic" id="noDefInfo" onclick="switchDiv(this.value)"> I Dont know any information about defendant </button>
                        <div>
                            <input type="text" name="defFullname[]" placeholder="Fullname" />
                            <select name="defBrgy[]">
                                <option value="Poblacion Uno">Poblacion Uno</option>
                                <option value="Poblacion Dos">Poblacion Dos</option>
                                <option value="Poblacion Tres">Poblacion Tres</option>
                            </select>
                            <input type="text" name="defAddress[]" placeholder="Address" />
                            <select name="defIdentity[]">
                                <option value="Resident">Resident</option>
                                <option value="Official">Official</option>
                            </select>
                        </div>


                    </div>
                    <input type="submit" name="submitComplaint" value="Submit Complaint" />
                </div>

                <div id="defPic-div" style="display: none;">
                    Enter Picture
                    <button type="button" name="noDefPicture" value="defInfo" id="noDefPicture" onclick="switchDiv(this.value)"> Back </button>

                </div>

            </form>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var divAnotherDef = '<div> <input type="text" name ="defFullname[]" placeholder="Fullname" /><select name="defBrgy[]"><option value = "Poblacion Uno" > Poblacion Uno </option> <option value = "Poblacion Dos" > Poblacion Dos </option> <option value = "Poblacion Tres" > Poblacion Tres </option> </select> <input type = "text" name = "defAddress[]"placeholder = "Address" / ><select name="defIdentity[]"> <option value = "Resident" > Resident </option> <option value = "Official" > Official </option> </select> <input type="button" name="removeDefendant" value="X" id="removeDef" / > ';

            var x = 1;
            var max = 4;

            $("#addDef").click(function() {
                if (x <= max) {
                    $("#defInfo1-div").append(divAnotherDef);
                    x++;
                }
            });

            $("#defInfo1-div").on('click', '#removeDef', function() {
                $(this).closest('div').remove();
                x--;
            });
        });

        function switchDiv(divi) {

            document.getElementById(divi + '-div').style.display = "block";

            if (divi == "defPic") { // hide the div that is not selected

                document.getElementById('defInfo-div').style.display = "none";

            } else if (divi == "defInfo") {

                document.getElementById('defPic-div').style.display = "none";

            }

        }
    </script>
</body>

</html>