<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$message = "";

if (isset($_POST['addRBI'])) {
    $compFname = $_POST["compFname"];
    $compLname = $_POST["compLname"];
    $compMname = $_POST["compMname"];
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

    $addToRBI = "INSERT INTO rbi (first_name, middle_name, last_name,  brgy, purok, house_no, comp_address, birth_date, birth_place, gender, civil_status, citizenship, occupation, relationship, contact_no) VALUES ('$compFname','$compMname','$compLname','$compBrgy','$compPurok','$compHouseNo','$compAddress','$compBday','$compBplace','$compGender','$compCivStatus','$compCitizenship','$compOccup','$compRelToHead','$compNumber')";
    $con->exec($addToRBI);
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
                                <form method="post">
                                    <!-- COMPLAINANT PERSONAL INFORMATION -->
                                    <h4>Personal Information</h4>
                                    <h3><?php echo $message; ?></h3>
                                    <input type="text" name="compFname" placeholder="First Name" />
                                    <input type="text" name="compLname" placeholder="Last Name" />
                                    <input type="text" name="compMname" placeholder="Middle Name" />
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

                                    <input type="submit" name="addRBI" value="Add" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tableContent" class="table-responsive px-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <table class="table text-center mt-4">
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
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $showRBISql = "SELECT * FROM rbi WHERE brgy = '$barangayName'";
                                    $showRBIquery = $con->query($showRBISql);
                                    foreach ($showRBIquery as $row) {
                                        $rbiId = $row['id'];
                                        $rbiFname = $row['first_name'];
                                        $rbiMname = $row['middle_name'];
                                        $rbiLname = $row['last_name'];
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
                                            <td><?php echo $rbiId ?></td>
                                            <td><?php echo $rbiFname . " " . $rbiMname . " " . $rbiLname ?></td>
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
                                            <td><button><i class="fas fa-ellipsis-h"></i></button></td>
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
    </script>
</body>

</html>