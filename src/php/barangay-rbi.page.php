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

    //CHECK IF USER IS EXISTING
    $checkCompQuery = "SELECT * FROM rbi WHERE full_name = :fname AND house_no = :houseno AND brgy = :brgy AND purok = :purok AND birth_date = :bday";
    $checkCompStmt = $con->prepare($checkCompQuery);
    $checkCompStmt->execute([
        'fname' => $compFname,
        'houseno' => $compHouseNo,
        'brgy' => $compBrgy,
        'purok' => $compPurok,
        'bday' => $compBday
    ]);
    $countComp = $checkCompStmt->rowCount();
    if ($countComp == 0) {
        if (move_uploaded_file($_FILES['validImage']['tmp_name'], $target1)) {
            $addToRBI = "INSERT INTO rbi (full_name,  brgy, purok, house_no, comp_address, birth_date, birth_place, gender, civil_status, citizenship, occupation, relationship, contact_no, valid_id, is_existing) VALUES ('$compFname','$compBrgy','$compPurok','$compHouseNo','$compAddress','$compBday','$compBplace','$compGender','$compCivStatus','$compCitizenship','$compOccup','$compRelToHead','$compNumber','$validImageName','pending')";
            $con->exec($addToRBI);
            $confirm = "yes";
            $message = "Wait for the confirmation of your request.";
        }
    } else {
        $confirm = "no";
        $message = "Inhabitant already exists";
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
        $message = "RBI Updated";
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
        $message = "Removed";
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
                                            <div class="form-group col-md-4">
                                                <label for="houseNumId">House Number</label>
                                                <input type="text" class="form-control" id="houseNumId" name="compHouseNo" placeholder="House Number" required />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="compPurokSelect">Purok</label>
                                                <select name="compPurok" class="form-control" id="compPurokSelect">
                                                    <?php
                                                    $barangayQuery = "SELECT name FROM purok WHERE $barangayName = '1'";
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
                                <a href="./barangay-rbi.page.php" class="btn btn-dark btnSort px-4 mr-1  active">Verified</a>
                                <a href="./barangay-rbi-pending.page.php" class="btn btn-dark btnSort px-4 mr-1">Pending</a>
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
                                        <th scope="col">Delete</th>
                                        <th scope="col">Edit</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $showRBISql = "SELECT * FROM rbi WHERE brgy = '$barangayName' AND is_existing = 'yes'";
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
                                                <td><button class="add btn" type="submit" onclick="return confirm('Do you want to delete this?')" name="toArchiveBtn"><i class="fas fa-trash"></i></button></td>
                                            </form>
                                            <td><button type="button" class="btn editBtn add"><i class="fas fa-ellipsis-h"></i></button></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <!-- MODAL FOR EDITING RBI INFORMATION -->
            <div class="modal fixed-left fade" id="editRBIModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-aside" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Room</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark btnsave" name="updateRbi">Save</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>

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
</body>

</html>