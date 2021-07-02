<?php
session_start();
require_once 'database/config.php';
$confirm = "";
$message = "";

if (isset($_POST['submitComplaint'])) {
    $compFname = $_POST["compFname"];
    $compBrgy = $_POST["compBrgy"];
    $compHouseNo = $_POST["compHouseNo"];
    $compBday = $_POST["compBday"];


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
    $compOffice = $_POST['compOffice'];
    $compComplaint = $_POST["compComplaint"];
    $compDate = $_POST["compDate"];
    $compTime = $_POST["compTime"];
    $compWhere = $_POST["compWhere"];

    //CHECK IF USER IS EXISTING
    foreach ($compFname as $key => $value) {
        $checkCompQuery = "SELECT * FROM rbi WHERE full_name = :fname AND house_no = :houseno AND brgy = :brgy AND birth_date = :bday";
        $checkCompStmt = $con->prepare($checkCompQuery);
        $checkCompStmt->execute([
            'fname' => $value,
            'houseno' => $compHouseNo[$key],
            'brgy' => $compBrgy[$key],
            'bday' => $compBday[$key]
        ]);
        $countComp = $checkCompStmt->rowCount();
    }
    if ($countComp > 0) {
        //Check if defendant or complainant is a resident on Comp Office
        if (in_array($compOffice, $compBrgy) or in_array($compOffice, $defBrgy)) {

            foreach ($compFname as $key => $value) {
                $checkCompQuery = "SELECT * FROM rbi WHERE full_name = :fname AND house_no = :houseno AND brgy = :brgy AND birth_date = :bday";
                $checkCompStmt = $con->prepare($checkCompQuery);
                $checkCompStmt->execute([
                    'fname' => $value,
                    'houseno' => $compHouseNo[$key],
                    'brgy' => $compBrgy[$key],
                    'bday' => $compBday[$key]
                ]);
                $rbiResult = $checkCompStmt->fetchAll();
                //Get Complainant ID
                foreach ($rbiResult as $row) {
                    $cid = $row['id'];
                }
                //Insert complainant to complainant table
                $addToComplainant = "INSERT INTO complainant (case_ref_no, comp_id) VALUES ('$complainRefNumber', '$cid')";
                $con->exec($addToComplainant);
            }
            //insert defendant to defendant table
            foreach ($defFullName as $key => $value) {
                $addToDef = "INSERT INTO defendant (case_ref_no, full_name, def_address, barangay, position) VALUES ('$complainRefNumber', '$value', '$defAddress[$key]', '$defBrgy[$key]', '$defIdentity[$key]')";
                $con->exec($addToDef);
            }
            //Insert complaint information to complaint table
            $addToComp = "INSERT INTO complaint_case (case_ref_no, complaint, incident_date, incident_time, incident_place, incident_year, incident_month, incident_pic, case_status, date_submit, complaint_type, where_to) VALUES ('$complainRefNumber',:complaint,'$compDate','$compTime','$compWhere','$complaintYear','$complaintMonth','none','Pending','$complaintDate1','report', '$compOffice')";
            $addtoCompStmt = $con->prepare($addToComp);
            $addtoCompStmt->execute(array(
                ':complaint' => $compComplaint
            ));

            $confirm = 'yes';
            $message = 'Complaint Successfully Sent';
        } else {
            $confirm = "no";
            $message = "The complainant or defendant must be a resident on where you want file to complaint.";
        }
    } else {
        $confirm = "no";
        $message = "The complainant must be a resident in Magdalena.";
    }
}

//WITH PICCCCCCCCCCCCCCCCCCCCCCCCCTURE
if (isset($_POST['submitComplaintPic'])) {
    $compFname = $_POST["compFname"];
    $compBrgy = $_POST["compBrgy"];
    $compHouseNo = $_POST["compHouseNo"];
    $compBday = $_POST["compBday"];


    date_default_timezone_set("Asia/Manila");
    $complaintTime = date("His");
    $complaintDate = date("Ymd");
    $complaintDate1 = date("F d, Y");
    $complaintMonth = date("F");
    $complaintYear = date("Y");
    $complainRefNumber = "R" . $complaintDate . "" . $complaintTime;

    $compRBIid = "";
    $compOffice = $_POST['compOffice'];
    $compComplaint = $_POST["compComplaint"];
    $compDate = $_POST["compDate"];
    $compTime = $_POST["compTime"];
    $compWhere = $_POST["compWhere"];

    $profileImageName = time() . "_" . $_FILES['profileImage']['name'];
    $target = '../assets/' . $profileImageName;

    //CHECK IF USER IS EXISTING
    foreach ($compFname as $key => $value) {
        $checkCompQuery = "SELECT * FROM rbi WHERE full_name = :fname AND house_no = :houseno AND brgy = :brgy AND birth_date = :bday";
        $checkCompStmt = $con->prepare($checkCompQuery);
        $checkCompStmt->execute([
            'fname' => $value,
            'houseno' => $compHouseNo[$key],
            'brgy' => $compBrgy[$key],
            'bday' => $compBday[$key]
        ]);
        $countComp = $checkCompStmt->rowCount();
    }

    // NEWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW
    if ($countComp > 0) {
        //Check if defendant or complainant is a resident on Comp Office
        if (in_array($compOffice, $compBrgy)) {

            //Get Complainant ID
            foreach ($compFname as $key => $value) {
                $checkCompQuery = "SELECT * FROM rbi WHERE full_name = :fname AND house_no = :houseno AND brgy = :brgy AND birth_date = :bday";
                $checkCompStmt = $con->prepare($checkCompQuery);
                $checkCompStmt->execute([
                    'fname' => $value,
                    'houseno' => $compHouseNo[$key],
                    'brgy' => $compBrgy[$key],
                    'bday' => $compBday[$key]
                ]);
                $rbiResult = $checkCompStmt->fetchAll();

                foreach ($rbiResult as $row) {
                    $cid = $row['id'];
                }
                //Insert complainant to complainant table
                $addToComplainant = "INSERT INTO complainant (case_ref_no, comp_id) VALUES ('$complainRefNumber', '$cid')";
                $con->exec($addToComplainant);
            }
            if ($_FILES['profileImage']['name']) {
                if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target)) {
                    $addToComp = "INSERT INTO complaint_case (case_ref_no, complaint, incident_date, incident_time, incident_place, incident_year, incident_month, incident_pic, case_status, date_submit, complaint_type, where_to) VALUES ('$complainRefNumber',:complaint,'$compDate','$compTime','$compWhere','$complaintYear','$complaintMonth','$profileImageName','Pending','$complaintDate1','report', '$compOffice')";
                    $addtoCompStmt = $con->prepare($addToComp);
                    $addtoCompStmt->execute(array(
                        ':complaint' => $compComplaint
                    ));
                }
            } else {
                $addToComp = "INSERT INTO complaint_case (case_ref_no, complaint, incident_date, incident_time, incident_place, incident_year, incident_month, incident_pic, case_status, date_submit, complaint_type, where_to) VALUES ('$complainRefNumber',:complaint,'$compDate','$compTime','$compWhere','$complaintYear','$complaintMonth','none','Pending','$complaintDate1','report', '$compOffice')";
                $addtoCompStmt = $con->prepare($addToComp);
                $addtoCompStmt->execute(array(
                    ':complaint' => $compComplaint
                ));
            }


            $confirm = 'yes';
            $message = 'Complaint Successfully Sent';
        } else {
            $confirm = "no";
            $message = "The complainant must be a resident on where you want file to complaint.";
        }
    } else {
        $confirm = "no";
        $message = "The complainant must be a resident in Magdalena.";
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

    <link rel="stylesheet" type="text/css" href="../css/main-services.style.css">

    <title>Document</title>
</head>

<body>
    <?php include './navbar/main.navbar.php'; ?>
    <section id="topBanner">
        <div class="container banner">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <h2 class="st section-title-heading text-uppercase">Services</h2>
                    <h1 class="text-uppercase">Get to <span class="accent">know</span> us </h1>
                    <p class="text-uppercase">Don't waste your time. Be sure where you will go.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="servContent">
        <div class="container">
            <div class="sec-title text-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="./service.page.php">Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Complaint</li>
                    </ol>
                </nav>
                <h1 class="text-uppercase mt-3">complaint form</h1>

                <p class="mt-3"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto cumque id quod harum dicta laboriosam illum quo odit veniam dolorum fugit temporibus at earum nostrum, assumenda quia reiciendis corrupti libero! </p>
            </div>
            <div class="form-section mt-5">
                <form method="post" enctype="multipart/form-data">
                    <!-- COMPLAINANT PERSONAL INFORMATION -->
                    <div class="personalInfo cC">
                        <h4 class="titleComplaint">Personal Information</h4>
                        <div id="compInfo1-div">
                            <div id="wew">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6>Complainant 1</h6>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="fnameId">Full Name</label>
                                        <input type="text" class="form-control" id="fnameId" name="compFname[]" placeholder="Full Name" required />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="houseNumId">House Number</label>
                                        <input type="text" class="form-control" id="houseNumId" name="compHouseNo[]" placeholder="House Number" required />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="barangaySelect">Barangay</label>
                                        <select name="compBrgy[]" class="form-control barangaySelect">
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

                                    <div class="form-group col-md-4">
                                        <label for="bdayId">Birthday</label>
                                        <input class="form-control" id="bdayId" type="date" name="compBday[]" placeholder="Birthdate" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <button class="btn submit1" type="button" name="addComplainant" id="addComp">Add Complainant</button>


                            </div>

                        </div>
                    </div>


                    <div class="complaintContent cC">
                        <h4 class="titleComplaint">Complaint</h4>
                        <div class="form-group">
                            <label for="complaintOffice">Where do you want to file complaint?</label>
                            <select name="compOffice" class="form-control complaintOffice">
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
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inciDateId">Date of Incident</label>
                                <input class="form-control" id="inciDateId" type="date" name="compDate" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inciTimeId">Time of Incident</label>
                                <input class="form-control" id="inciTimeId" type="time" name="compTime" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inciAddress">Place of Incident</label>
                            <input class="form-control" id="inciAddress" type="text" name="compWhere" placeholder="Address" required />
                        </div>
                        <div class="form-group">
                            <label for="complaintId">Your Complaint</label>
                            <textarea class="form-control" id="complaintId" name="compComplaint" placeholder="Tell us what happened" rows="3" required></textarea>
                        </div>
                    </div>


                    <div class="defendantContent cC">
                        <h4 class="titleComplaint">Defendant Information</h4>
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
                                            <label for="defNameId">Defendant Full Name</label>
                                            <input type="text" class="form-control" id="defNameId" name="defFullname[]" placeholder="Fullname" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="resId">Type of Resident</label>
                                            <select name="defIdentity[]" class="form-control" id="resId">
                                                <option value="Resident">Resident</option>
                                                <option value="Official">Official</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
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
                                    <button class="btn submit1" type="button" name="addDefendant" id="addDef">Add Defendant</button>
                                    <button type="button" class="btn submit1" name="noDefInfo" value="defPic" id="noDefInfo" onclick="switchDiv(this.value)"> I Dont know any information about defendant </button>


                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <input class="btn submit1" type="submit" name="submitComplaint" value="Submit Complaint" />
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div id="defPic-div" style="display: none;">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="form-group ">
                                        <h6>Incident picture</h6>
                                        <label for="profileImage">Present the picture that have the face of the defendant</label>
                                        <input type="file" accept="image/png, image/jpeg" name="profileImage" id="profileImage" class="form-control-file transparent text-center" onChange="displayImage(this)" style="margin: auto;"><br>
                                        <img src="" style="max-width: 300px;" class="img-fluid transparent" id="profileDisplay" onclick="triggerClick()">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn submit1" name="noDefPicture" value="defInfo" id="noDefPicture" onclick="switchDiv(this.value)"> Back
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-right">
                                        <button type="submit" name="submitComplaintPic" class="btn submit1">Submit Complaint</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </section>

    <footer class="page-footer font-small blue footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 align-self-center">
                    <h6 class="text-uppercase"><span id="year">
                            <script>
                                document.getElementById('year').appendChild(document.createTextNode(new Date().getFullYear()))
                            </script>
                        </span>BestGroup</h6>
                </div>
                <div class="col-md-4 align-self-center">
                    <h1>Fourth</h1>
                </div>
                <div class="col-md-4 align-self-center">
                    <i class="fab fa-facebook fa-2x"></i>
                    <i class="fab fa-twitter fa-2x"></i>
                    <i class="fab fa-instagram fa-2x"></i>
                </div>
            </div>
        </div>
    </footer>
    <footer class="page-footer font-small text-center footer1">
        <div class="container">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h6 class="text-uppercase"><span id="year1">
                            Copyrights
                            <script>
                                document.getElementById('year1').appendChild(document.createTextNode(new Date().getFullYear()))
                            </script>
                        </span>BestGroup</h6>
                </div>
                <div class="col-md-6 align-self-center">
                    <h6 class="text-uppercase">Philippine Time: 16:00:01 am 2021 June 16</h6>
                </div>
            </div>
        </div>

    </footer>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            var x = 1;
            var max = 2;


            $("#addDef").click(function() {
                if (x <= max) {
                    var divAnotherDef = '<div id="waw"><div class="row"><div class="col-md-8"><h6>Defendant ' + (x + 1) + '</h6></div><div class="col-md-4"><div class="float-right"><input class="btn btn-danger" type="button" name="removeDefendant" value="X" id="removeDef" / ></div></div></div><div class="form-row"><div class="form-group col-md-4"><label for="defNameId">Defendant Full Name</label><input type="text" class="form-control" id="defNameId" name="defFullname[]" placeholder="Fullname" /></div><div class="form-group col-md-4"><label for="resId">Type of Resident</label><select name="defIdentity[]" class="form-control" id="resId"><option value="Resident">Resident</option><option value="Official">Official</option></select></div><div class="form-group col-md-4"><label for="brId">Barangay</label><select name="defBrgy[]" class="form-control" id="brId"><?php $barangayQuery = "SELECT DISTINCT barangay FROM account WHERE barangay != 'DILG' ORDER BY barangay";
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
        });

        $(document).ready(function() {

            var x1 = 1;
            var max1 = 2;
            $("#addComp").click(function() {
                if (x1 <= max1) {

                    var divAnotherDef1 = '<div id="wew"> <div class = "row" ><div class = "col-md-8" ><h6 > Complainant ' + (x1 + 1) + '</h6> </div><div class="col-md-4"><div class="float-right"><input class="btn btn-danger" type="button" name="removeDefendant" value="X" id="removeComp" / ></div> </div>  </div> <div class = "form-row" ><div class = "form-group col-md-12" ><label for = "fnameId" > Full Name </label> <input type = "text" class = "form-control" id = "fnameId" name = "compFname[]" placeholder = "Full Name" required / ></div> </div> <div class = "form-row" ><div class = "form-group col-md-4" ><label for = "houseNumId" > House Number </label> <input type = "text" class = "form-control" id = "houseNumId" name = "compHouseNo[]" placeholder = "House Number" required / ></div> <div class = "form-group col-md-4" ><label for = "barangaySelect" > Barangay </label> <select name = "compBrgy[]" class = "form-control barangaySelect" ><?php $barangayQuery = "SELECT DISTINCT barangay FROM account WHERE barangay != 'DILG' ORDER BY barangay";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $barangayStmt = $con->query($barangayQuery);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    foreach ($barangayStmt as $row) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $barangayRow = $row['barangay']; ?> <option value = "<?php echo $barangayRow ?>" > <?php echo $barangayRow ?> </option><?php } ?></select> </div> <div class = "form-group col-md-4" ><label for = "bdayId" > Birthday </label> <input class = "form-control" id = "bdayId" type = "date" name = "compBday[]" placeholder = "Birthdate"required / ></div> </div> </div>';


                    $("#compInfo1-div").append(divAnotherDef1);
                    x1++;
                }
            });

            $("#compInfo1-div").on('click', '#removeComp', function() {
                $(this).closest('#wew').remove();
                x1--;
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

        function triggerClick() {
            document.querySelector('#profileImage').click();
        }

        //DISPLAYING IMAGE TO THE IMG TAG
        function displayImage(e) {
            if (e.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
            }
        }

        function triggerClick1() {
            document.querySelector('#validImage').click();
        }

        //DISPLAYING IMAGE TO THE IMG TAG
        function displayImage1(e) {
            if (e.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('#validDisplay').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".barangaySelect").change(function() {
                var brgy = $(".barangaySelect").val().toLowerCase();
                $.ajax({
                    url: 'get-option.php',
                    method: 'post',
                    data: 'brgyPost=' + brgy
                }).done(function(purok) {
                    console.log(purok);
                    purok1 = JSON.parse(purok);
                    $('.compPurokSelect').empty();
                    purok1.forEach(function(puroks) {
                        $('.compPurokSelect').append('<option value=' + puroks.name + '>' + puroks.name + ' </option>')
                    })
                })
            })
        })
    </script>
    <script type="text/javascript">
        $(window).scroll(function() {
            $('.navbar').toggleClass('scrolled', $(this).scrollTop() > 600);
        });
        var lastScrollTop = 0;
        $(window).scroll(function() {
            var st = $(this).scrollTop();
            var banner = $('.navbar');
            setTimeout(function() {
                if (st > lastScrollTop) {
                    banner.addClass('hide');
                    banner.removeClass('transparent');
                } else {
                    banner.removeClass('hide');
                }
                lastScrollTop = st;
            }, 100);
        });
    </script>
</body>

</html>