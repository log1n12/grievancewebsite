<?php
session_start();
require_once './database/config.php';
require_once './database/dilg-admin.check.php';
$titleHeader = "Accounts";
$message = "";
$confirm = "no";

if (isset($_POST['addAcc'])) {
    if (!empty($_POST['photoStore']) && !empty($_POST['signature'])) {
        if ($_POST['compPass1'] == $_POST['compPass2']) {
            $newFname = $_POST['compFname'];
            $newMname = $_POST['compMname'];
            $newLname = $_POST['compLname'];
            $newBrgy = $_POST['compBrgy'];
            $newEmail = $_POST['compEmail'];
            $newUname = $_POST['compUname'];
            $newBday = $_POST['compBday'];
            $newPassword = $_POST['compPass1'];

            $checkUname = "SELECT * from account WHERE username = '$newUname'";
            $checkUnameQ = $con->query($checkUname);
            $checkUnameQ->execute();
            $countUname = $checkUnameQ->rowCount();

            if ($countUname > 0) {
                $message = "Username already exist";
            } else {
                $checkBrgyCapt = "SELECT * FROM account WHERE barangay = '$newBrgy' AND user_type = 'barangay_captain' AND acc_isActive = 'yes'";
                $checkBrgyCaptStmt = $con->prepare($checkBrgyCapt);
                $checkBrgyCaptStmt->execute();

                $checkBrgyCaptCount = $checkBrgyCaptStmt->rowCount();
                if ($checkBrgyCaptCount > 0) {
                    //pag meron na
                    $message = "There is an existing account for that barangay. Please try again";
                } else {
                    //pag wala pang brgy captain sa brgy na yon


                    $addTime = date("His");
                    $addDate = date("Ymd");
                    $file_namepic = $newFname . $newMname . $newLname . $addDate . $addTime;
                    $file_path = "../assets/account_pic/";
                    $encoded_data = $_POST['photoStore'];
                    $binary_data = base64_decode($encoded_data);

                    $photoname = $file_namepic . '.jpeg';

                    $result = file_put_contents($file_path . $photoname, $binary_data);

                    if ($result) {
                        $signature = $_POST['signature'];
                        $folderPath = "../assets/signature/";
                        $image_parts = explode(";base64,", $signature);
                        $image_base64 = base64_decode($image_parts[1]);
                        $filenamesig = $newFname . $newMname . $newLname . "signature" . $addDate . $addTime . '.png';
                        $file = $folderPath . $filenamesig;
                        if (file_put_contents($file, $image_base64)) {
                            $addAcc = "INSERT INTO account (barangay, username, user_password, user_type, sec_fname, sec_mname, sec_lname, sec_email, sec_bday, sec_picture, sec_signature, acc_isActive) 
            VALUES ('$newBrgy','$newUname','$newPassword','barangay_captain','$newFname','$newMname','$newLname','$newEmail','$newBday','$photoname','$filenamesig','yes')";
                            $con->exec($addAcc);
                            $confirm = "yes";
                            $message = "The account is successfully added";
                        } else {
                            $message = "error";
                        }
                    } else {
                        $message = "Not uploaded pls try again";
                    }
                }
            }
        } else {
            $message = "Password doesn't matched";
        }
    } else {
        $message = "ERROR";
    }
}

if (isset($_POST['archiveCaptBtn'])) {
    $brgyCaptId = $_POST['brgyCaptId'];
    $unreadsql = "UPDATE account SET acc_isActive = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "no",
        ':id' => $brgyCaptId

    ])) {
        $confirm = "yes";
        $message = "The case is successfully move to Document table";
    }
}

if (isset($_POST['retrieveCaptBtn'])) {
    $brgyCaptId = $_POST['brgyCaptId'];
    $unreadsql = "UPDATE account SET acc_isActive = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "yes",
        ':id' => $brgyCaptId

    ])) {
        $confirm = "yes";
        $message = "The case is successfully move to Document table";
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

    <!-- SIGNATURE -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/jquery.signature.css">
    <style>
        .kbw-signature {
            width: 400px;
            height: 200px;
            background-color: transparent;
        }
    </style>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/dilg-admin.style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
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
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-users-cog fa-2x mr-3 icon1"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $dsql = "SELECT * FROM account WHERE acc_isActive = 'yes' AND user_type = 'barangay_captain'";
                                        $dsqlq = $con->prepare($dsql);
                                        $dsqlq->execute();
                                        $dscount = $dsqlq->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount ?></h5>
                                        <small class="card-text">Barangay Captain</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-users-cog fa-2x mr-3 icon2"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $dsql1 = "SELECT * FROM account WHERE acc_isActive = 'yes' AND user_type = 'barangay_admin'";
                                        $dsqlq1 = $con->prepare($dsql1);
                                        $dsqlq1->execute();
                                        $dscount1 = $dsqlq1->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount1 ?></h5>
                                        <small>Barangay Secretary</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <section id="table-section">
                <div id="tableNavbar">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="mx-4 mt-3">List of Accounts</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <button id="addBtn" class="add1 btn mx-4 mt-3 text-capitalize hvr-icon-spin" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-plus mr-2 hvr-icon"></i> Add Account</button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="container">
                            <div class="card card-body transparent">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="personalInfo cC">
                                        <h4 class="titleComplaint">Account Information</h4>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="fnameId">First Name</label>
                                                <input type="text" class="form-control" id="fnameId" name="compFname" placeholder="First name" required />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mnameId">Middle Name</label>
                                                <input type="text" class="form-control" id="mnameId" name="compMname" placeholder="Middle Name" required />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="lnameId">Last Name</label>
                                                <input type="text" class="form-control" id="lnameId" name="compLname" placeholder="Last Name" required />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="bdayId">Birthday</label>
                                                <input class="form-control" id="bdayId" type="date" name="compBday" placeholder="Birthdate" required />
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="compBrgySelect">Barangay</label>
                                                <select name="compBrgy" class="form-control" id="compBrgySelect">
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
                                            <div class="form-group col-md-3">
                                                <label for="emailId">Email</label>
                                                <input type="email" class="form-control" id="emailId" name="compEmail" placeholder="email123@gmail.com" required />
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputUname">Username</label>
                                                <input type="text" class="form-control" id="inputUname" name="compUname" placeholder="Username" required />
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="passId1">Password</label>
                                                <input class="form-control" id="passId1" type="password" name="compPass1" placeholder="Password" required />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="passId2">Confirm Password</label>
                                                <input class="form-control" id="passId2" type="password" name="compPass2" placeholder="Confirm Password" required />
                                            </div>

                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <div id="sig"></div>
                                                <textarea id="txtSignature" name="signature" style="display: none; background-color: black;" value=""></textarea>


                                                <button id="clear" type="button">Clear</button>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <div id="results" class="d-none"></div>
                                                <input type="hidden" id="photoStore" name="photoStore" value="" />
                                                <button type="button" class="btn btn-warning text-white" id="accesscamera"> Capture Photo</button>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="float-right">
                                                    <button type="submit" name="addAcc" class="btn submit1">Submit</button>
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
                                    <a class="nav-item btnSort nav-link active px-4 mr-1" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="true"><span class="sortTitle">All</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-capt-tab" data-toggle="tab" href="#nav-capt" role="tab" aria-controls="nav-capt" aria-selected="false"><span class="sortTitle">Barangay Captain</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-capt-tab1" data-toggle="tab" href="#nav-capt1" role="tab" aria-controls="nav-capt1" aria-selected="false"><span class="sortTitle">Ex-Barangay Captain</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-sect-tab" data-toggle="tab" href="#nav-sect" role="tab" aria-controls="nav-sect" aria-selected="false"><span class="sortTitle">Barangay Secretary</span></a>
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
                                <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                                    <table class="table table1 table-hover text-center" id="table12312312" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Middle Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Usertype</th>
                                                <th scope="col">Barangay</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showAccountSql = "SELECT * FROM account WHERE user_type != 'dilg_admin' AND acc_isActive = 'yes'";
                                            $showAccountquery = $con->query($showAccountSql);
                                            foreach ($showAccountquery as $row) {
                                                $accId = $row['id'];
                                                $accBrgy = $row['barangay'];
                                                $accUname = $row['username'];
                                                $accUtype = $row['user_type'];
                                                $accFname = $row['sec_fname'];
                                                $accMname = $row['sec_mname'];
                                                $accLname = $row['sec_lname'];
                                                $accEmail = $row['sec_email'];

                                            ?>
                                                <tr>
                                                    <td><?php echo $accId ?></td>
                                                    <td><?php echo $accFname ?></td>
                                                    <td><?php echo $accMname ?></td>
                                                    <td><?php echo $accLname ?></td>
                                                    <td><?php echo $accUname ?></td>
                                                    <td><?php echo $accEmail ?></td>
                                                    <td><span style="font-size: 12px; font-weight: bolder; padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                                                    if ($accUtype == "barangay_admin") {
                                                                                                                                                                        echo "#49d97b";
                                                                                                                                                                    } elseif ($accUtype == "barangay_captain") {
                                                                                                                                                                        echo "#fcb654";
                                                                                                                                                                    }
                                                                                                                                                                    ?>"><?php
                                                                                                                                                                        if ($accUtype == 'barangay_admin') {
                                                                                                                                                                            echo 'Barangay Secretary';
                                                                                                                                                                        } elseif ($accUtype == 'barangay_captain') {
                                                                                                                                                                            echo 'Barangay Captain';
                                                                                                                                                                        }
                                                                                                                                                                        ?></span></td>
                                                    <td><?php echo $accBrgy ?></td>


                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE BRGY CAPTAIN -->
                                <div class="tab-pane fade" id="nav-capt" role="tabpanel" aria-labelledby="nav-capt-tab">
                                    <table class="table table1 table-hover text-center" id="table2" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Middle Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Barangay</th>
                                                <th scope="col">Archive</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showAccountSql = "SELECT * FROM account WHERE user_type = 'barangay_captain' AND acc_isActive = 'yes'";
                                            $showAccountquery = $con->query($showAccountSql);
                                            foreach ($showAccountquery as $row) {
                                                $accId = $row['id'];
                                                $accBrgy = $row['barangay'];
                                                $accUname = $row['username'];
                                                $accUtype = $row['user_type'];
                                                $accFname = $row['sec_fname'];
                                                $accMname = $row['sec_mname'];
                                                $accLname = $row['sec_lname'];
                                                $accEmail = $row['sec_email'];

                                            ?>
                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $accId ?><input type="hidden" name="brgyCaptId" value="<?php echo $accId; ?>"></td>
                                                        <td><?php echo $accFname ?></td>
                                                        <td><?php echo $accMname ?></td>
                                                        <td><?php echo $accLname ?></td>
                                                        <td><?php echo $accUname ?></td>
                                                        <td><?php echo $accEmail ?></td>
                                                        <td><?php echo $accBrgy ?></td>
                                                        <td><button class="add btn hvr-pulse-grow" type="submit" name="archiveCaptBtn" onclick="return confirm('Are you sure you want to archive this account?')"><i class="fas fa-check"></i></button></td>
                                                    </form>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE BRGY CAPTAIN -->
                                <div class="tab-pane fade" id="nav-capt1" role="tabpanel" aria-labelledby="nav-capt-tab1">
                                    <table class="table table1 table-hover text-center" id="table212312312" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Middle Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Barangay</th>
                                                <th scope="col">Retrieve</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showAccountSql = "SELECT * FROM account WHERE user_type = 'barangay_captain' AND acc_isActive = 'no'";
                                            $showAccountquery = $con->query($showAccountSql);
                                            foreach ($showAccountquery as $row) {
                                                $accId = $row['id'];
                                                $accBrgy = $row['barangay'];
                                                $accUname = $row['username'];
                                                $accUtype = $row['user_type'];
                                                $accFname = $row['sec_fname'];
                                                $accMname = $row['sec_mname'];
                                                $accLname = $row['sec_lname'];
                                                $accEmail = $row['sec_email'];

                                            ?>
                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $accId ?><input type="hidden" name="brgyCaptId" value="<?php echo $accId; ?>"></td>
                                                        <td><?php echo $accFname ?></td>
                                                        <td><?php echo $accMname ?></td>
                                                        <td><?php echo $accLname ?></td>
                                                        <td><?php echo $accUname ?></td>
                                                        <td><?php echo $accEmail ?></td>
                                                        <td><?php echo $accBrgy ?></td>
                                                        <td><button class="add btn hvr-pulse-grow" type="submit" name="retrieveCaptBtn" onclick="return confirm('Are you sure you to retrieve this account?')"><i class="fas fa-check"></i></button></td>
                                                    </form>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE BRGY SECRETARY -->
                                <div class="tab-pane fade" id="nav-sect" role="tabpanel" aria-labelledby="nav-sect-tab">
                                    <table class="table table1 table-hover text-center" id="table3" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Middle Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Barangay</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showAccountSql = "SELECT * FROM account WHERE user_type = 'barangay_admin' AND acc_isActive = 'yes'";
                                            $showAccountquery = $con->query($showAccountSql);
                                            foreach ($showAccountquery as $row) {
                                                $accId = $row['id'];
                                                $accBrgy = $row['barangay'];
                                                $accUname = $row['username'];
                                                $accUtype = $row['user_type'];
                                                $accFname = $row['sec_fname'];
                                                $accMname = $row['sec_mname'];
                                                $accLname = $row['sec_lname'];
                                                $accEmail = $row['sec_email'];

                                            ?>
                                                <tr>
                                                    <td><?php echo $accId ?></td>
                                                    <td><?php echo $accFname ?></td>
                                                    <td><?php echo $accMname ?></td>
                                                    <td><?php echo $accLname ?></td>
                                                    <td><?php echo $accUname ?></td>
                                                    <td><?php echo $accEmail ?></td>
                                                    <td><?php echo $accBrgy ?></td>



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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
    </script>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../js/jquery.signature.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <script type="text/javascript">
        $(document).ready(function() {
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
                    "lengthChange": false
                });


                $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                    $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust();
                });

                table.$("[data-toggle=popover]").popover().click(function(e) {
                    e.preventDefault();
                });
            });
        });
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });
        });
    </script>

    <script>
        $(function() {
            var sig = $('#sig').signature({
                syncField: '#txtSignature',
                syncFormat: 'PNG',
                background: 'rgba(0, 0, 0, 0)'
            });
            $('#clear').click(function(e) {
                e.preventDefault();
                sig.signature('clear');
                $("#txtSignature").val('');
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            Webcam.set({
                width: 480,
                height: 270,
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