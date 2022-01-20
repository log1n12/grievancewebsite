<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$titleHeader = "Records of Barangay Inhabitants";
$message = "";
$confirm = "no";
$tab = "all";

if (isset($_POST['addRBI'])) {
    if (!empty($_POST['photoStore'])) {
        $compFname = strtoupper($_POST["compFname"]);
        $compLname = strtoupper($_POST["compLname"]);
        $compMname = strtoupper($_POST["compMname"]);
        $compBrgy = $barangayName;
        $compPurok = $_POST["compPurok"];
        $compHouseNo = $_POST["compHouseNo"];
        $compAddress = "Magdalena, Laguna";
        $compBday = $_POST["compBday"];
        $compBplace = $_POST["compBplace"];
        $compGender = $_POST["compGender"];
        $compCivStatus = $_POST["compCivStatus"];
        $compCitizenship = $_POST["compCitizenship"];
        $compOccup = $_POST["compOccup"];
        $compRelToHead = $_POST["compRelToHead"];
        $compNumber = "+639" . $_POST["compNumber"];

        //CHECK IF USER IS EXISTING
        $checkCompQuery = "SELECT * FROM rbi WHERE first_name = :fname AND last_name = :lname AND middle_name = :mname AND house_no = :houseno AND brgy = :brgy AND birth_date = :bday";
        $checkCompStmt = $con->prepare($checkCompQuery);
        $checkCompStmt->execute([
            'fname' => $compFname,
            'lname' => $compLname,
            'mname' => $compMname,
            'houseno' => $compHouseNo,
            'brgy' => $compBrgy,
            'bday' => $compBday
        ]);
        $countComp = $checkCompStmt->rowCount();
        if ($countComp == 0) {

            $addTime = date("His");
            $addDate = date("Ymd");
            $file_namepic = $compFname . $compMname . $compLname . $addDate . $addTime;
            $file_path = "../assets/";
            $encoded_data = $_POST['photoStore'];
            $binary_data = base64_decode($encoded_data);

            $photoname = $file_namepic . '.jpeg';

            $result = file_put_contents($file_path . $photoname, $binary_data);
            if ($result) {
                $addToRBI = "INSERT INTO rbi (first_name, last_name, middle_name, brgy, purok, house_no, comp_address, birth_date, birth_place, gender, civil_status, citizenship, occupation, relationship, contact_no, valid_id, is_existing) VALUES ('$compFname','$compLname','$compMname','$compBrgy','$compPurok','$compHouseNo','$compAddress','$compBday','$compBplace','$compGender','$compCivStatus','$compCitizenship','$compOccup','$compRelToHead','$compNumber','$photoname','pending')";
                $con->exec($addToRBI);
                $confirm = "yes";
                $message = "The barangay inhabitant is successfully moved to pending table.";
            }
        } else {
            $message = "Inhabitant already exists";
        }
    } else {
        $message = "ERROR";
    }
}

if (isset($_POST['updateRbi'])) {
    $resInfo = $_POST['resInfo'];
    $resInfo2 = $_POST['resInfo2'];
    $resInfo3 = $_POST['resInfo3'];
    $resInfo4 = $_POST['resInfo4'];
    $resInfo8 = $_POST['resInfo8'];
    $resInfo10 = $_POST['resInfo10'];
    $resInfo12 = $_POST['resInfo12'];

    $updateRBIsql = "UPDATE rbi SET house_no = :resinfo2, purok = :resinfo3, comp_address = :resinfo4, civil_status = :resinfo8, occupation = :resinfo10, contact_no = :resinfo12 WHERE id = :id";
    $updateRBIstmt = $con->prepare($updateRBIsql);
    if ($updateRBIstmt->execute([
        ':resinfo2' => $resInfo2,
        ':resinfo3' => $resInfo3,
        ':resinfo4' => $resInfo4,
        ':resinfo8' => $resInfo8,
        ':resinfo10' => $resInfo10,
        ':resinfo12' => $resInfo12,
        ':id' => $resInfo

    ])) {
        $confirm = "yes";
        $message = "Barangay inhabitant information is successfully updated";
        $tab = "verify";
    }
}

if (isset($_POST['toArchiveBtn'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE rbi SET is_existing = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "no",
        ':id' => $id

    ])) {
        $notifTitle = "Barangay Inhabitant Archived";
        $notifMesg = "A barangay inhabitant was archived.";
        $notifTo = "DILG";
        $notifToType = "Barangay Secretary";
        $notifFrom = $cookieId;

        require './get-notif.php';
        $confirm = "yes";
        $message = "The barangay inhabitant is moved to removed table.";
        $tab = "remove";
    }
}

if (isset($_POST['toVerifiedBtn'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE rbi SET is_existing = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "yes",
        ':id' => $id

    ])) {
        $notifTitle = "Barangay Inhabitant Accepted";
        $notifMesg = "A barangay inhabitant was successfully verified.";
        $notifTo = "DILG";
        $notifToType = "Barangay Secretary";
        $notifFrom = $cookieId;

        require './get-notif.php';
        $confirm = "yes";
        $message = "The user is successfully moved to verified table.";
        $tab = "verify";
    }
}

if (isset($_POST['toPendingBtn'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE rbi SET is_existing = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "pending",
        ':id' => $id

    ])) {
        $confirm = "yes";
        $message = "The user is successfully moved to pending table.";
        $tab = "pending";
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
            <section id="list-count" class="mb-4">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-users fa-2x mr-3 icon1"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $pendingcountsql2 = "SELECT * FROM rbi WHERE brgy = '$barangayName'";
                                        $pendingcountstmt2 = $con->prepare($pendingcountsql2);
                                        $pendingcountstmt2->execute();
                                        $pendingcount2 = $pendingcountstmt2->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount2 ?></h5>
                                        <small class="card-text">All Inhabitants</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-users fa-2x mr-3 icon2"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $pendingcountsql = "SELECT * FROM rbi WHERE brgy = '$barangayName' AND is_existing = 'pending'";
                                        $pendingcountstmt = $con->prepare($pendingcountsql);
                                        $pendingcountstmt->execute();
                                        $pendingcount = $pendingcountstmt->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount ?></h5>
                                        <small>Pending Inhabitants</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-users fa-2x mr-3 icon5"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $pendingcountsql1 = "SELECT * FROM rbi WHERE brgy = '$barangayName' AND is_existing = 'yes'";
                                        $pendingcountstmt1 = $con->prepare($pendingcountsql1);
                                        $pendingcountstmt1->execute();
                                        $pendingcount1 = $pendingcountstmt1->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount1 ?></h5>
                                        <small class="card-text">Verifed Inhabitants</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-users fa-2x mr-3 icon3"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $pendingcountsql4 = "SELECT * FROM rbi WHERE brgy = '$barangayName' AND is_existing = 'no'";
                                        $pendingcountstmt4 = $con->prepare($pendingcountsql4);
                                        $pendingcountstmt4->execute();
                                        $pendingcount4 = $pendingcountstmt4->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount4 ?></h5>
                                        <small class="card-text">Removed Inhabitants</small>
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
                            <h1 class="mx-4 mt-3"><?php echo $titleHeader ?></h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <button id="addBtn" class="add1 btn mx-4 mt-3 text-capitalize" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" data-placement="left" title="Add Hospital"><i class="fas fa-plus mr-2"></i> Add New Inhabitant</button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="container">
                            <div class="card card-body transparent">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="personalInfo cC">
                                        <h4 class="titleComplaint">Personal Information</h4>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="fnameId">First Name</label>
                                                <input type="text" class="form-control" id="fnameId" name="compFname" placeholder="First Name" required />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="lnameId">Last Name</label>
                                                <input type="text" class="form-control" id="lnameId" name="compLname" placeholder="Last Name" required />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mnameId">Middle Name</label>
                                                <input type="text" class="form-control" id="mnameId" name="compMname" placeholder="Middle Name" required />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="houseNumId">House Number</label>
                                                <input type="text" class="form-control" id="houseNumId" name="compHouseNo" placeholder="House Number" required />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="compPurokSelect">Purok</label>
                                                <select name="compPurok" class="form-control" id="compPurokSelect">
                                                    <?php
                                                    $barangayNameLowerCase = strtolower(preg_replace('/\s+/', '_', $barangayName));
                                                    $barangayQuery = "SELECT name FROM purok WHERE $barangayNameLowerCase = '1'";
                                                    $barangayStmt = $con->query($barangayQuery);
                                                    foreach ($barangayStmt as $row) {
                                                        $barangayRow = $row['name'];

                                                    ?>
                                                        <option value="<?php echo $barangayRow ?>"><?php echo $barangayRow ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="relToId">Relationship to Head of Family</label>
                                                <input type="text" class="form-control" id="relToId" name="compRelToHead" placeholder="e.g Brother, Husband ..." required />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <legend class="col-form-label pt-0">Gender</legend>
                                                <label class="radio-inline">
                                                    <input type="radio" name="compGender" value="Male" checked>Male
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="compGender" value="Female">Female
                                                </label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="bdayId">Birthday</label>
                                                <input class="form-control" id="bdayId" type="date" name="compBday" placeholder="Birthdate" required />
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="bplaceId">Birthplace</label>
                                                <input class="form-control" id="bplaceId" type="text" name="compBplace" placeholder="Place of Birth" required />
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="civId">Civil Status</label>
                                                <select name="compCivStatus" class="form-control" id="civId">
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Divorced">Divorced</option>
                                                    <option value="Widowed">Widowed</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="citId">Citizenship</label>
                                                <select name="compCitizenship" class="form-control" id="citId">
                                                    <option value="Filipino">Filipino</option>
                                                    <option value="Foreigner">Foreigner</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="occupId">Occupation</label>
                                                <input class="form-control" id="occupId" type="text" name="compOccup" placeholder="Occupation" required />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="conId">Contact Number</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">+639</span>
                                                    </div>
                                                    <input class="form-control" id="conId" type="text" name="compNumber" placeholder="Contact Number" aria-describedby="basic-addon1" required />
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="accesscamera">Valid ID</label>
                                            <div id="results" class="d-none"></div>
                                            <input type="hidden" id="photoStore" name="photoStore" value="" />
                                            <button type="button" class="btn btn-warning text-white" id="accesscamera"> Capture Photo</button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="float-right">
                                                    <button type="submit" name="addRBI" class="btn submit1">Add RBI</button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Capture Photo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div>
                                        <div id="my_camera" class="d-block mx-auto rounded overflow-hidden"></div>
                                    </div>
                                    <div id="results1" class="d-none"></div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning mx-auto text-white" id="takephoto">Capture Photo</button>
                                    <button type="button" class="btn btn-warning mx-auto text-white d-none" id="retakephoto">Retake</button>
                                    <button type="button" class="btn btn-warning mx-auto text-white d-none" id="uploadphoto">Upload</button>

                                </div>
                            </div>
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
                                    <a class="nav-item btnSort nav-link <?php if ($tab == "verify") {
                                                                            echo "active";
                                                                        }  ?> px-4 mr-1" id="nav-verified-tab" data-toggle="tab" href="#nav-verified" role="tab" aria-controls="nav-verified" aria-selected="false"><span class="sortTitle">Verified</span></a>
                                    <a class="nav-item btnSort nav-link <?php if ($tab == "remove") {
                                                                            echo "active";
                                                                        }  ?> px-4 mr-1" id="nav-removed-tab" data-toggle="tab" href="#nav-removed" role="tab" aria-controls="nav-removed" aria-selected="false"><span class="sortTitle">Removed</span></a>

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
                                <div class="tab-pane fade  <?php if ($tab == "all") {
                                                                echo "show active";
                                                            }  ?>" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">

                                    <table class="table table1 table-hover table-striped  text-center" id="table1231" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">House Number</th>
                                                <th scope="col">Purok</th>
                                                <th scope="col">Age</th>
                                                <th scope="col">Gender</th>
                                                <th scope="col">Contact Number</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showRBISql = "SELECT * FROM rbi WHERE brgy = '$barangayName'";
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
                                                $rbiValiId = $row['valid_id'];
                                                $isExist = $row['is_existing'];
                                                $rbiStatus = "";
                                                if ($isExist == "pending") {
                                                    $rbiStatus = "Pending";
                                                } elseif ($isExist == "yes") {
                                                    $rbiStatus = "Verified";
                                                } elseif ($isExist == "no") {
                                                    $rbiStatus = "Removed";
                                                }
                                                date_default_timezone_set("Asia/Manila");
                                                $dateToday = new DateTime();
                                                $rbiBirthdateDate = new DateTime($rbiBday);
                                                $rbiAge = $rbiBirthdateDate->diff($dateToday)->y;

                                            ?>
                                                <tr>
                                                    <td><?php echo $rbiId ?><input type="hidden" name="id" value="<?php echo $rbiId ?>" /></td>
                                                    <td> <a class="text-capitalize" href="./barangay-rbi-profile.page.php?rbiid=<?= $rbiId ?>" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?> </a></td>
                                                    <td><?php echo $rbiHouseNo ?></td>
                                                    <td><?php echo $rbiPurok ?></td>
                                                    <td><?php echo $rbiAge ?></td>
                                                    <td><?php echo $rbiGender ?></td>
                                                    <td><?php echo $rbiContactNumber ?></td>
                                                    <td><span style="font-size: 12px; font-weight: bolder; padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                                                    if ($isExist == "pending") {
                                                                                                                                                                        echo "#fcb654";
                                                                                                                                                                    } elseif ($isExist == "yes") {
                                                                                                                                                                        echo "#49d97b";
                                                                                                                                                                    } elseif ($isExist == "no") {
                                                                                                                                                                        echo "#ed7469";
                                                                                                                                                                    }
                                                                                                                                                                    ?>"><?php echo $rbiStatus ?></span></td>



                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END OF TABLE ALL -->

                                <!-- TABLE PENDING -->
                                <div class="tab-pane fade <?php if ($tab == "pending") {
                                                                echo "show active";
                                                            }  ?>" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">

                                    <table class="table table1 table-hover table-striped text-center" id="table2" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">House Number</th>
                                                <th scope="col">Purok</th>
                                                <th scope="col">Complete Address</th>
                                                <th scope="col">Birthday</th>
                                                <th scope="col">Birthplace</th>
                                                <th scope="col">Gender</th>
                                                <th scope="col">Civil Status</th>
                                                <th scope="col">Citizenship</th>
                                                <th scope="col">Occupation</th>
                                                <th scope="col">Relationship to the Head</th>
                                                <th scope="col">Contact Number</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showRBISql = "SELECT * FROM rbi WHERE brgy = '$barangayName' AND is_existing = 'pending'";
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
                                                $rbiValiId = $row['valid_id'];

                                            ?>
                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $rbiId ?><input type="hidden" name="id" value="<?php echo $rbiId ?>" /></td>
                                                        <td> <a class="text-capitalize" href="./barangay-rbi-profile.page.php?rbiid=<?= $rbiId ?>" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?> </a></td>
                                                        <td><?php echo $rbiHouseNo ?></td>
                                                        <td><?php echo $rbiPurok ?></td>
                                                        <td><?php echo $rbiAddress ?></td>
                                                        <td><?php echo $rbiBday ?></td>
                                                        <td><?php echo $rbiBplace ?></td>
                                                        <td><?php echo $rbiGender ?></td>
                                                        <td><?php echo $rbiCivStatus ?></td>
                                                        <td><?php echo $rbiCitizenship ?></td>
                                                        <td><?php echo $rbiOccup ?></td>
                                                        <td><?php echo $rbiRelToHead ?></td>
                                                        <td><?php echo $rbiContactNumber ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button class="add btn hvr-pulse-grow" type="submit" onclick="return confirm('Do you want to verify this?')" name="toVerifiedBtn"><i class="fas fa-check"></i></button>
                                                                <button class="add btn btn-danger hvr-pulse-grow" type="submit" onclick="return confirm('Do you want to remove this?')" name="toArchiveBtn"><i class="fas fa-times"></i></button>
                                                            </div>
                                                        </td>

                                                    </form>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END OF TABLE PENDING -->

                                <!-- TABLE VERIFIED -->
                                <div class="tab-pane fade <?php if ($tab == "verify") {
                                                                echo "show active";
                                                            }  ?>" id="nav-verified" role="tabpanel" aria-labelledby="nav-verified-tab">

                                    <table class="table table1 table-hover table-striped text-center" id="table3" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">House Number</th>
                                                <th scope="col">Purok</th>
                                                <th scope="col">Complete Address</th>
                                                <th scope="col">Birthday</th>
                                                <th scope="col">Birthplace</th>
                                                <th scope="col">Gender</th>
                                                <th scope="col">Civil Status</th>
                                                <th scope="col">Citizenship</th>
                                                <th scope="col">Occupation</th>
                                                <th scope="col">Relationship to the Head</th>
                                                <th scope="col">Contact Number</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showRBISql = "SELECT * FROM rbi WHERE brgy = '$barangayName' AND is_existing = 'yes'";
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
                                                $rbiValiId = $row['valid_id'];

                                            ?>
                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $rbiId ?><input type="hidden" name="id" value="<?php echo $rbiId ?>" /></td>
                                                        <td> <a class="text-capitalize" href="./barangay-rbi-profile.page.php?rbiid=<?= $rbiId ?>" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?> </a></td>
                                                        <td><?php echo $rbiHouseNo ?></td>
                                                        <td><?php echo $rbiPurok ?></td>
                                                        <td><?php echo $rbiAddress ?></td>
                                                        <td><?php echo $rbiBday ?></td>
                                                        <td><?php echo $rbiBplace ?></td>
                                                        <td><?php echo $rbiGender ?></td>
                                                        <td><?php echo $rbiCivStatus ?></td>
                                                        <td><?php echo $rbiCitizenship ?></td>
                                                        <td><?php echo $rbiOccup ?></td>
                                                        <td><?php echo $rbiRelToHead ?></td>
                                                        <td><?php echo $rbiContactNumber ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group">

                                                                <button type="button" class="btn editBtn add hvr-pulse-grow"><i class="fas fa-ellipsis-h"></i></button>
                                                                <button class="add btn btn-danger hvr-pulse-grow " type="submit" onclick="return confirm('Do you want to delete this?')" name="toArchiveBtn"><i class="fas fa-times"></i></button>
                                                            </div>

                                                        </td>
                                                    </form>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END OF TABLE VERIFIED -->

                                <!-- TABLE REMOVED -->
                                <div class="tab-pane fade <?php if ($tab == "remove") {
                                                                echo "show active";
                                                            }  ?>" id="nav-removed" role="tabpanel" aria-labelledby="nav-removed-tab">

                                    <table class="table table1 table-hover table-striped text-center" id="table4" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">House Number</th>
                                                <th scope="col">Purok</th>
                                                <th scope="col">Complete Address</th>
                                                <th scope="col">Birthday</th>
                                                <th scope="col">Birthplace</th>
                                                <th scope="col">Gender</th>
                                                <th scope="col">Civil Status</th>
                                                <th scope="col">Citizenship</th>
                                                <th scope="col">Occupation</th>
                                                <th scope="col">Relationship to the Head</th>
                                                <th scope="col">Contact Number</th>
                                                <th scope="col">Return</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showRBISql = "SELECT * FROM rbi WHERE brgy = '$barangayName' AND is_existing = 'no'";
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
                                                $rbiValiId = $row['valid_id'];

                                            ?>
                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $rbiId ?><input type="hidden" name="id" value="<?php echo $rbiId ?>" /></td>
                                                        <td> <a class="text-capitalize" href="./barangay-rbi-profile.page.php?rbiid=<?= $rbiId ?>" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?> </a></td>
                                                        <td><?php echo $rbiHouseNo ?></td>
                                                        <td><?php echo $rbiPurok ?></td>
                                                        <td><?php echo $rbiAddress ?></td>
                                                        <td><?php echo $rbiBday ?></td>
                                                        <td><?php echo $rbiBplace ?></td>
                                                        <td><?php echo $rbiGender ?></td>
                                                        <td><?php echo $rbiCivStatus ?></td>
                                                        <td><?php echo $rbiCitizenship ?></td>
                                                        <td><?php echo $rbiOccup ?></td>
                                                        <td><?php echo $rbiRelToHead ?></td>
                                                        <td><?php echo $rbiContactNumber ?></td>
                                                        <td><button class="add btn hvr-pulse-grow" type="submit" onclick="return confirm('Do you want to bring this back to RBI?')" name="toPendingBtn"><i class="fas fa-check"></i></button></td>
                                                    </form>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END OF TABLE REMOVED -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- MODAL FOR EDITING RBI INFORMATION -->
            <div class="modal fixed-left fade" id="editRBIModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-aside" role="document">
                    <div class="modal-content p-4">
                        <div class="modal-header">
                            <div>
                                <h4 class="modal-title" id="myModalLabel">Edit Resident Profile</h4>
                                <p><span style="font-size: 13px; font-weight: 300;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, aspernatur odit<span></p>
                            </div>


                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <form method="post">
                                    <div class="form-group">
                                        <label for="resInfo">Resident ID</label>
                                        <input type="text" class="form-control transparent text-muted" name="resInfo" id="resInfo" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo1">Resident Name</label>
                                        <input type="text" class="form-control transparent text-muted" name="resInfo1" id="resInfo1" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo2">House Number</label>
                                        <input type="text" class="form-control transparent editable" name="resInfo2" id="resInfo2" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo3">Purok</label>
                                        <input type="text" class="form-control transparent editable" name="resInfo3" id="resInfo3" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo4">Complete Address</label>
                                        <input type="text" class="form-control transparent editable" name="resInfo4" id="resInfo4" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo5">Birth Date</label>
                                        <input type="text" class="form-control transparent text-muted" name="resInfo5" id="resInfo5" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo6">Birth Place</label>
                                        <input type="text" class="form-control transparent text-muted" name="resInfo6" id="resInfo6" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo7">Gender</label>
                                        <input type="text" class="form-control transparent text-muted" name="resInfo7" id="resInfo7" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo8">Civil Status</label>
                                        <input type="text" class="form-control transparent editable" name="resInfo8" id="resInfo8" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo9">Citizenship</label>
                                        <input type="text" class="form-control transparent text-muted" name="resInfo9" id="resInfo9" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo10">Occupation</label>
                                        <input type="text" class="form-control transparent editable" name="resInfo10" id="resInfo10" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo11">Relationship to the Head</label>
                                        <input type="text" class="form-control transparent text-muted" name="resInfo11" id="resInfo11" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo12">Contact Number</label>
                                        <input type="text" class="form-control transparent editable" name="resInfo12" id="resInfo12" required>
                                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btnsave" name="updateRbi">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


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

            $('table.table1').DataTable({
                "scrollX": true,
                "lengthChange": false
            });


            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

        $(function() {
            // Enables popover
            $("[data-toggle=popover]").popover();
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

        $(document).ready(function() {
            $('.editBtn').on('click', function() {
                $('#editRBIModal').modal('show');

                $tr = $(this).closest('tr');

                var tddata = $tr.children("td").map(function() {
                    return $(this).text();

                }).get();

                $('#resInfo').val(tddata[0]);
                $('#resInfo1').val(tddata[1]);
                $('#resInfo2').val(tddata[2]);
                $('#resInfo3').val(tddata[3]);
                $('#resInfo4').val(tddata[4]);
                $('#resInfo5').val(tddata[5]);
                $('#resInfo6').val(tddata[6]);
                $('#resInfo7').val(tddata[7]);
                $('#resInfo8').val(tddata[8]);
                $('#resInfo9').val(tddata[9]);
                $('#resInfo10').val(tddata[10]);
                $('#resInfo11').val(tddata[11]);
                $('#resInfo12').val(tddata[12]);


            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            Webcam.set({
                width: 320,
                height: 240,
                jpeg_quality: 90,
                flip_horiz: true
            });


            $('#accesscamera').on('click', function() {
                x = 0;
                Webcam.attach('#my_camera');
                Webcam.reset();
                Webcam.on('error', function() {

                    x = 1;
                    swal("HELLO WORLD");
                    $('#photoModal').modal('hide');
                });
                if (x == 0) {
                    $('#photoModal').modal('show');
                    Webcam.attach('#my_camera');
                } else {
                    swal("HELLO WORLD");
                }


            });

            $('#takephoto').on('click', take_snapshot);

            $('#retakephoto').on('click', function() {
                $('#my_camera').addClass('d-block');
                $('#my_camera').removeClass('d-none');
                $('#results').removeClass('d-none');
                $('#results1').addClass('d-none');

                $('#takephoto').addClass('d-block');
                $('#takephoto').removeClass('d-none');

                $('#retakephoto').addClass('d-none');
                $('#retakephoto').removeClass('d-block');

                $('#uploadphoto').addClass('d-none');
                $('#uploadphoto').removeClass('d-block');
            });

            $('#uploadphoto').on('click', function() {
                $('#photoModal').modal('hide');
            });

        })

        function take_snapshot() {
            //take snapshot and get image data
            Webcam.snap(function(data_uri) {
                //display result image
                $('#results').html('<img src="' + data_uri + '" class="d-block mx-auto rounded"/>');
                $('#results1').html('<img src="' + data_uri + '" class="d-block mx-auto rounded"/>');
                var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                $('#photoStore').val(raw_image_data);
            });

            $('#my_camera').removeClass('d-block');
            $('#my_camera').addClass('d-none');
            $('#results').removeClass('d-none');
            $('#results1').removeClass('d-none');

            $('#takephoto').removeClass('d-block');
            $('#takephoto').addClass('d-none');

            $('#retakephoto').removeClass('d-none');
            $('#retakephoto').addClass('d-block');

            $('#uploadphoto').removeClass('d-none');
            $('#uploadphoto').addClass('d-block');
        }
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