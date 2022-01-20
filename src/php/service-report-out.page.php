<?php
session_start();
require_once 'database/config.php';
$confirm = "";
$message = "";

if (isset($_POST['submitComplaint'])) {
    $compFname = $_POST["compFname"];
    $compLname = $_POST["compLname"];
    $compMname = $_POST["compMname"];
    $compAddress = $_POST["compAddress"];
    $compContact = $_POST["compContact"];



    date_default_timezone_set("Asia/Manila");
    $complaintTime = date("His");
    $complaintDate = date("Ymd");
    $complaintDate1 = date("F d, Y");
    $complaintMonth = date("F");
    $complaintYear = date("Y");
    $complainRefNumber = "R" . $complaintDate . "" . $complaintTime;

    $defFirstName = $_POST["defFirstname"];
    $defLastName = $_POST["defLastname"];
    $defMiddleName = $_POST["defMiddlename"];
    $defBrgy = $_POST["defBrgy"];
    $defAddress = $_POST["defAddress"];
    $defIdentity = $_POST["defIdentity"];

    $compRBIid = "";
    $compOffice = $_POST['compOffice'];
    $compComplaint = $_POST["compComplaint"];
    $compDate = $_POST["compDate"];
    $compTime = $_POST["compTime"];
    $compWhere = $_POST["compWhere"];

    //Check if defendant or complainant is a resident on Comp Office
    if (in_array($compOffice, $defBrgy)) {
        foreach ($compFname as $key => $value) {
            $addToRBI = "INSERT INTO rbi (first_name, last_name, middle_name, comp_address, contact_no, is_existing, valid_id) VALUES (:a,:b,:c,:d,:e, 'outsider', 'nopic.png')";
            $addToRBIprep = $con->prepare($addToRBI);
            $addToRBIprep->execute([
                ':a' => $value,
                ':b' => $compLname[$key],
                ':c' => $compMname[$key],
                ':d' => $compAddress[$key],
                ':e' => "+639" . $compContact[$key]
            ]);
            $cid = $con->lastInsertId();
            //Insert complainant to complainant table
            $addToComplainant = "INSERT INTO complainant (case_ref_no, comp_id) VALUES ('$complainRefNumber', '$cid')";
            $con->exec($addToComplainant);
        }
        //insert defendant to defendant table
        foreach ($defFirstName as $key => $value) {
            $addToDef = "INSERT INTO defendant (case_ref_no, first_name, last_name, middle_name, def_address, barangay, position) VALUES ('$complainRefNumber', '$value', '$defLastName[$key]', '$defMiddleName[$key]', '$defAddress[$key]', '$defBrgy[$key]', '$defIdentity[$key]')";
            $con->exec($addToDef);
        }
        //Insert complaint information to complaint table
        $addToComp = "INSERT INTO complaint_case (case_ref_no, complaint, incident_date, incident_time, incident_place, incident_year, incident_month, incident_pic, case_status, date_submit, complaint_type, where_to) VALUES ('$complainRefNumber',:complaint,'$compDate','$compTime','$compWhere','$complaintYear','$complaintMonth','none','Pending','$complaintDate1','report', '$compOffice')";
        $addtoCompStmt = $con->prepare($addToComp);
        $addtoCompStmt->execute(array(
            ':complaint' => $compComplaint
        ));

        $notifTitle = "New Report";
        $notifMesg = "Report was added to the pending table with the complaint reference number of: " . $complainRefNumber;
        $notifTo = $compOffice;
        $notifToType = "Barangay Secretary";
        $notifFrom = "00";

        require './get-notif.php';

        $confirm = 'yes';
        $message = 'Your report reference number is: <b>' . $complainRefNumber . '</b>';
    } else {
        $confirm = "no";
        $message = "The complainant or defendant must be a resident on where you want file to complaint.";
    }
}

//WITH PICCCCCCCCCCCCCCCCCCCCCCCCCTURE
if (isset($_POST['submitComplaintPic'])) {
    $compFname = $_POST["compFname"];
    $compLname = $_POST["compLname"];
    $compMname = $_POST["compMname"];
    $compAddress = $_POST["compAddress"];
    $compContact = $_POST["compContact"];


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


    //Get Complainant ID
    foreach ($compFname as $key => $value) {
        $addToRBI = "INSERT INTO rbi (first_name, last_name, middle_name, comp_address, contact_no, is_existing, valid_id) VALUES (:a,:b,:c,:d,:e, 'outsider', 'nopic.png')";
        $addToRBIprep = $con->prepare($addToRBI);
        $addToRBIprep->execute([
            ':a' => $value,
            ':b' => $compLname[$key],
            ':c' => $compMname[$key],
            ':d' => $compAddress[$key],
            ':e' => "+639" . $compContact[$key]
        ]);
        $cid = $con->lastInsertId();
        //Insert complainant to complainant table
        $addToComplainant = "INSERT INTO complainant (case_ref_no, comp_id) VALUES ('$complainRefNumber', '$cid')";
        $con->exec($addToComplainant);
    }
    //Insert complaint information to complaint table
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

    $notifTitle = "New Report";
    $notifMesg = "Report was added to the pending table with the complaint reference number of: " . $complainRefNumber;
    $notifTo = $compOffice;
    $notifToType = "Barangay Secretary";
    $notifFrom = "00";

    require './get-notif.php';

    $confirm = 'yes';
    $message = 'Your report reference number is: <b>' . $complainRefNumber . '</b>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/main-services.style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">


    <title>Document</title>
</head>

<body>
    <?php include './navbar/main.navbar.php'; ?>
    <section id="topBanner">
        <div class="container banner" data-aos="zoom-out" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <h2 class="st section-title-heading text-uppercase">Services</h2>
                    <h3 class="text-uppercase">File your <span class="accent">Report</span> </h3>
                    <p class="text-uppercase">Don't waste your time. Get the justice you deserve.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="servContent">
        <div class="container">
            <div class="sec-title text-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center transparent">
                        <li class="breadcrumb-item"><a href="./service.page.php">Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Complaint</li>
                    </ol>
                </nav>
                <h3 class="text-uppercase mt-3" data-aos-offset="200" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">blotter report form (outsider)</h3>
                <p class="mt-3" data-aos-offset="200" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true"> Ang blotter report form na ito ay maaring magamit ng mga taong hindi residente sa Magdalena pero may gustong ireklamong residente ng Magdalena. Upang makaapila ng complaint, sagutan lang ang mga form ng tamang impormasyon at maghintay ng text na mangagaling sa inyong Barangay upang ikompirma kung natanggap o hindi ang inyong reklamo.</p>
                <a href="./service-report.page.php" class="mt-0 pt-0 clickHere" data-aos-offset="200" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">Ikaw ba ay residente ng Magdalena? Subukan ang form na ito.</a>
            </div>
            <div class="form-section mt-5" data-aos-offset="350" data-aos="fade-up" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
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
                                    <div class="form-group col-md-4">
                                        <label for="fnameId">First Name</label>
                                        <input type="text" class="form-control" id="fnameId" name="compFname[]" placeholder="First Name" required />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="lnameId">Last Name</label>
                                        <input type="text" class="form-control" id="lnameId" name="compLname[]" placeholder="Last Name" required />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="mnameId">Middle Name</label>
                                        <input type="text" class="form-control" id="mnameId" name="compMname[]" placeholder="Middle Name" required />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label for="addressId">Address</label>
                                        <input type="text" class="form-control" id="addressId" name="compAddress[]" placeholder="Address" required />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="contactId">Contact Number</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">+639</span>
                                            <input type="text" class="form-control" id="contactId" name="compContact[]" placeholder="Contact Number" required />
                                        </div>
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
                            <label for="complaintOffice">Saang barangay gustong umapila? <b>Note: </b>Piliin ang iyong barangay o barangay ng inyong nirereklamo.</label>
                            <select name="compOffice" class="form-select complaintOffice">
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
                                <label for="inciDateId">Araw ng Insidente</label>
                                <input class="form-control" id="inciDateId" type="date" name="compDate" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inciTimeId">Oras ng Insidente</label>
                                <input class="form-control" id="inciTimeId" type="time" name="compTime" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inciAddress">Lugar ng Insidente <b>Note: </b>Maaaring landmark ang ibigay.</label>
                            <input class="form-control" id="inciAddress" type="text" name="compWhere" placeholder="Address" required />
                        </div>
                        <div class="form-group">
                            <label for="complaintId">Iyong Complaint</label>
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
                                            <label for="resId">Uri ng Residente</label>
                                            <select name="defIdentity[]" class="form-select" id="resId">
                                                <option value="Resident">Resident</option>
                                                <option value="Official">Official</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="brId">Barangay</label>
                                            <select name="defBrgy[]" class="form-select" id="brId">
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <button class="btn submit1" type="button" name="addDefendant" id="addDef">Add Defendant</button>
                                    <button type="button" class="btn submit2" name="noDefInfo" value="defPic" id="noDefInfo" onclick="switchDiv(this.value)">Paano pag di alam ang impormasyon ng nirereklamo? </button>


                                </div>

                            </div>

                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                            <label class="form-check-label" for="exampleCheck1">Nabasa at sumasangayon ako sa <a href="./terms.page.php" target="_blank"> Terms and Condition</a>.</label>
                                        </div>
                                        <input class="btn submit1 submitComp" type="submit" name="submitComplaint" value="Submit Complaint" />
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div id="defPic-div" style="display: none;">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="form-group ">
                                        <h6>Picture ng Inyong Nirereklamo</h6>
                                        <label for="profileImage">Kung hindi alam ang mga personal na impormasyon ng inyong nirereklamo, maaring magbigay ng picture ng defendant upang magamit ng barangay upang makilala kung sino ang inyong nirereklamo.</label>
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
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck11" required>
                                            <label class="form-check-label" for="exampleCheck11">Nabasa at sumasangayon ako sa <a href="./terms.page.php" target="_blank"> Terms and Condition</a>.</label>
                                        </div>
                                        <button type="submit" name="submitComplaintPic" class="btn submit1 submitComp">Submit Complaint</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </section>

    <?php include './navbar/main.footer.php' ?>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            <?php
            if ($message != "") {
                if ($confirm == "yes") {


            ?>
                    Swal.fire({

                            title: 'Complaint Submitted',
                            icon: 'success',
                            html: '<?php echo $message ?>. You can check the complaint status <a href="./service-status.page.php">here</a>. Thank you!'
                        }

                    )
                <?php
                } else {
                ?>
                    Swal.fire(
                        'Complaint Failed',
                        '<?php echo $message; ?>',
                        'error'
                    )
            <?php
                }
            }
            ?>

            var x = 1;
            var max = 2;


            $("#addDef").click(function() {
                if (x <= max) {
                    var divAnotherDef = '<div id="waw"><div class="row"><div class="col-md-8"><h6>Defendant ' + (x + 1) + '</h6></div><div class="col-md-4"><div class="float-right"><input class="btn btn-danger" type="button" name="removeDefendant" value="X" id="removeDef" / ></div></div></div><div class="form-row"><div class="form-group col-md-4"><label for="defFnameId">First Name</label><input type="text" class="form-control" id="defFnameId" name="defFirstname[]" placeholder="First Name" /></div><div class="form-group col-md-4"><label for="defLnameId">Last Name</label><input type="text" class="form-control" id="defLnameId" name="defLastname[]" placeholder="Last Name" /></div><div class="form-group col-md-4"><label for="defMnameId">Middle Name</label><input type="text" class="form-control" id="defMnameId" name="defMiddlename[]" placeholder="Middle Name" /></div></div><div class="form-row"><div class="form-group col-md-6"><label for="resId">Type of Resident</label><select name="defIdentity[]" class="form-select" id="resId"><option value="Resident">Resident</option><option value="Official">Official</option></select></div><div class="form-group col-md-6"><label for="brId">Barangay</label><select name="defBrgy[]" class="form-select" id="brId"><?php $barangayQuery = "SELECT DISTINCT barangay FROM account WHERE barangay != 'DILG' ORDER BY barangay";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $barangayStmt = $con->query($barangayQuery);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            foreach ($barangayStmt as $row) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $barangayRow = $row['barangay']; ?><option value="<?php echo $barangayRow ?>"><?php echo $barangayRow ?></option><?php } ?></select></div></div></div>';

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

                    var divAnotherDef1 = '<div id="wew"><div class="row"><div class="col-md-8"><h6>Complainant ' + (x1 + 1) + '</h6></div><div class="col-md-4"><div class="float-right"><input class="btn btn-danger" type="button" name="removeDefendant" value="X" id="removeComp" / ></div></div></div><div class="form-row"><div class="form-group col-md-4"><label for="fnameId">First Name</label><input type="text" class="form-control" id="fnameId" name="compFname[]" placeholder="First Name" required /></div><div class="form-group col-md-4"><label for="lnameId">Last Name</label><input type="text" class="form-control" id="lnameId" name="compLname[]" placeholder="Last Name" required /></div><div class="form-group col-md-4"><label for="mnameId">Middle Name</label><input type="text" class="form-control" id="mnameId" name="compMname[]" placeholder="Middle Name" required /></div></div><div class="form-row"><div class="form-group col-md-8"><label for="addressId">Address</label><input type="text" class="form-control" id="addressId" name="compAddress[]" placeholder="Address" required /></div><div class="form-group col-md-4"><label for="contactId">Contact Number</label><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">+639</span><input type="text" class="form-control" id="contactId" name="compContact[]" placeholder="Contact Number" required /></div></div></div></div>';


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
                document.querySelector('#exampleCheck1').required = false;
                document.querySelector('#exampleCheck11').required = true;

            } else if (divi == "defInfo") {

                document.getElementById('defPic-div').style.display = "none";
                document.querySelector('#exampleCheck11').required = false;
                document.querySelector('#exampleCheck1').required = true;

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
        $(window).scroll(function() {
            $('.navbar').toggleClass('scrolled', $(this).scrollTop() > 50);
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

        //GETTING DATE
        $(window).on('load', function() {

            displayClock();
        });
        var span = document.getElementById('phTime');

        function displayClock() {
            var display = new Date().toLocaleTimeString();
            span.innerHTML = display;
            setTimeout(displayClock, 1000);
        }
    </script>
</body>

</html>