<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$titleHeader = "Records of Barangay Inhabitants";
$message = "";

if (isset($_POST['addRBI'])) {
    $compFname = strtoupper($_POST["compFname"]);
    $compBrgy = $barangayName;
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
    $validImageName = time() . "_" . $_FILES['validImage']['name'];
    $target1 = '../assets/' . $validImageName;
    if (move_uploaded_file($_FILES['validImage']['tmp_name'], $target1)) {
        $addToRBI = "INSERT INTO rbi (full_name,  brgy, purok, house_no, comp_address, birth_date, birth_place, gender, civil_status, citizenship, occupation, relationship, contact_no, valid_id, is_existing) VALUES ('$compFname','$compBrgy','$compPurok','$compHouseNo','$compAddress','$compBday','$compBplace','$compGender','$compCivStatus','$compCitizenship','$compOccup','$compRelToHead','$compNumber','$validImageName','yes')";
        $con->exec($addToRBI);
    }
}

if (isset($_POST['toArchiveBtn'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE rbi SET is_existing = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "yes",
        ':id' => $id

    ])) {
        $message = "Verified";
    }
} elseif (isset($_POST['toArchiveBtn1'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE rbi SET is_existing = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "no",
        ':id' => $id

    ])) {
        $message = "Verified";
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
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-comments fa-1x mr-3"></i></div>
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
                            <h1 class="mx-4 mt-4">RBI</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <button id="addBtn" class="add btn mx-4 mt-4" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" data-placement="left" title="Add Hospital"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="container">
                            <div class="card card-body transparent">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="personalInfo cC">
                                        <h4 class="titleComplaint">Personal Information</h4>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="fnameId">Full Name</label>
                                                <input type="text" class="form-control" id="fnameId" name="compFname" placeholder="Full Name" required />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="houseNumId">House Number</label>
                                                <input type="text" class="form-control" id="houseNumId" name="compHouseNo" placeholder="House Number" required />
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="barangaySelect">Barangay</label>
                                                <select name="compBrgy" class="form-control" id="barangaySelect">
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
                                            <div class="form-group col-md-3">
                                                <label for="compPurokSelect">Purok</label>
                                                <select name="compPurok" class="form-control" id="compPurokSelect">
                                                    <?php
                                                    $barangayQuery = "SELECT name FROM purok WHERE alipit = '1'";
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
                                            <div class="form-group col-md-3">
                                                <label for="relToId">Relationship to the Head</label>
                                                <input type="text" class="form-control" id="relToId" name="compRelToHead" placeholder="e.g Brother, Husband ..." required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Address</label>
                                            <input type="text" class="form-control" id="inputAddress" name="compAddress" placeholder="Address" required />
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <legend class="col-form-label pt-0">Radios</legend>
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
                                                <input class="form-control" id="civId" type="text" name="compCivStatus" placeholder="Civil Status" required />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="citId">Citizenship</label>
                                                <input class="form-control" id="citId" type="text" name="compCitizenship" placeholder="Citizenship" required />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="occupId">Occupation</label>
                                                <input class="form-control" id="occupId" type="text" name="compOccup" placeholder="Occupation" required />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="conId">Contact Number</label>
                                                <input class="form-control" id="conId" type="text" name="compNumber" placeholder="Contact Number" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="validImage">Valid ID</label>
                                            <input type="file" name="validImage" id="validImage" class="form-control-file transparent text-center" onChange="displayImage1(this)" style="margin: auto;" required><br>
                                            <img src="" style="max-width: 300px;" class="img-fluid transparent" id="validDisplay" onclick="triggerClick1()">
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
                </div>
                <div id="tableContent" class="table-responsive px-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <form class="d-flex align-items-center sort">
                                <a href="./barangay-rbi.page.php" class="btn btn-dark btnSort px-4 mr-1">Verified</a>
                                <a href="./barangay-rbi-pending.page.php" class="btn btn-dark btnSort px-4 mr-1 active">Pending</a>
                                <a href="./barangay-rbi-removed.page.php" class="btn btn-dark btnSort px-4 mr-1">Removed</a>
                            </form>
                            <table class="table table-hover table-bordered mt-4 text-center" id="myTable" style="width: 100%">
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
                                        <th scope="col">Verify</th>
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $showRBISql = "SELECT * FROM rbi WHERE brgy = '$barangayName' AND is_existing = 'pending'";
                                    $showRBIquery = $con->query($showRBISql);
                                    foreach ($showRBIquery as $row) {
                                        $rbiId = $row['id'];
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

                                    ?>
                                        <tr>
                                            <form method="post">
                                                <td><?php echo $rbiId ?><input type="hidden" name="id" value="<?php echo $rbiId ?>" /></td>
                                                <td><a href="./barangay-rbi-profile.page.php?rbiid=<?= $rbiId ?>"><?php echo $rbiFname ?></a></td>
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
                                                <td><button class="add btn" type="submit" onclick="return confirm('Do you want to verify this?')" name="toArchiveBtn"><i class="fas fa-check"></i></button></td>
                                                <td><button class="add btn" type="submit" onclick="return confirm('Do you want to remove this?')" name="toArchiveBtn1"><i class="fas fa-check"></i></button></td>

                                            </form>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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

    <script type="text/javascript">
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
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
    </script>
</body>

</html>