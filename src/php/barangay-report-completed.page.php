<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$titleHeader = "Report";
$message = "";


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
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-comments fa-1x mr-3"></i>
                                    </div>
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
                            <h1 class="mx-4 mt-4">List of Reports</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <a id="addBtn" class="add btn mx-4 mt-4" href="./service-report.page.php" data-placement="left" title="Add Hospital"><i class="fas fa-plus"></i></a>
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
                        </div>
                    </div>
                </div>
                <div id="tableContent" class="table-responsive mt-3 px-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <form class="d-flex align-items-center sort">
                                <a href="./barangay-report.page.php" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">All</a>
                                <a href="./barangay-report-pending.page.php" class="btn btn-dark btnSort px-4 mr-1 " name="all" value="all">Pending</a>
                                <a href="./barangay-report-completed.page.php" class="btn btn-dark btnSort px-4 mr-1 active" name="all" value="all">Completed</a>
                                <a href="./barangay-report-rejected.page.php" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Archive</a>

                            </form>
                            <table class="table table-hover table-bordered mt-4 text-center" id="myTable" style="width: 100%">
                                <colgroup>
                                    <col span="1" style="width: 5%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 30%;">
                                    <col span="1" style="width: 9%;">
                                    <col span="1" style="width: 10%;">
                                    <col span="1" style="width: 9%;">
                                </colgroup>
                                <thead class="">
                                    <tr>
                                        <th onclick="sortTable(0)">ID <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(1)" scope="col">Reference Numbers <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(2)" scope="col">Complainant <i class="fas fa-sort"></i></th>
                                        <th scope="col">Defendant</th>
                                        <th scope="col">Complaint</th>
                                        <th scope="col">Picture</th>
                                        <th scope="col">Date Submitted</th>
                                        <th scope="col">Date Completed</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $showComplaintSql = "SELECT * FROM complaint_case WHERE complaint_type = 'report' AND case_status = 'Completed' AND where_to = '$barangayName'";
                                    $showComplaintQuery = $con->query($showComplaintSql);
                                    foreach ($showComplaintQuery as $row) {
                                        $complaintId = $row['id'];
                                        $complaintRefNo = $row['case_ref_no'];
                                        $complaint = $row['complaint'];
                                        $complaintStatus = $row['case_status'];
                                        $complaintPic = $row['incident_pic'];
                                        $complaintDateSubmit = $row['date_submit'];


                                    ?>
                                        <tr>
                                            <td><?php echo $complaintId ?> </td>
                                            <td class="font-weight-bold"><?php echo $complaintRefNo ?> </td>
                                            <td>
                                                <?php
                                                $getComplainant = "SELECT * FROM complainant WHERE case_ref_no = '$complaintRefNo'";
                                                $getComplainantQuery = $con->query($getComplainant);
                                                foreach ($getComplainantQuery as $row2) {
                                                    $compId = $row2['comp_id'];

                                                    $getComplainant1 = "SELECT * FROM rbi WHERE id = '$compId'";
                                                    $getComplainantQuery1 = $con->query($getComplainant1);
                                                    foreach ($getComplainantQuery1 as $row3) {
                                                        $rbiFname = $row3['full_name'];
                                                        $rbiHouseNo = $row3['house_no'];
                                                        $rbiBrgy = $row3['brgy'];
                                                        $rbiPurok = $row3['purok'];
                                                        $rbiAddress = $row3['comp_address'];
                                                        $rbiBday = $row3['birth_date'];
                                                        $rbiBplace = $row3['birth_place'];
                                                        $rbiGender = $row3['gender'];
                                                        $rbiCivStatus = $row3['civil_status'];
                                                        $rbiCitizenship = $row3['citizenship'];
                                                        $rbiOccup = $row3['occupation'];
                                                        $rbiRelToHead = $row3['relationship'];
                                                        $rbiContactNumber = $row3['contact_no'];
                                                        $rbiValiId = $row3['valid_id'];


                                                ?>
                                                        <a href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo $rbiFname ?> </a>
                                                        <br><small class='small'>(<?php echo $rbiBrgy ?>)</small>
                                                        <br>
                                                <?php }
                                                } ?>
                                            </td>
                                            <td>
                                                <?php

                                                $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
                                                $getDefCountPrep = $con->prepare($getDefendant);
                                                $getDefCountPrep->execute();
                                                $getDefCount = $getDefCountPrep->rowCount();
                                                if ($getDefCount > 0) {
                                                    $getDefendantQuery = $con->query($getDefendant);
                                                    foreach ($getDefendantQuery as $row2) {
                                                        $defFullname = $row2['full_name'];
                                                        echo $defFullname;



                                                ?>
                                                        <br>
                                                <?php }
                                                } else {
                                                    echo "--";
                                                } ?>

                                            </td>
                                            <td><?php echo $complaint ?></td>
                                            <td>
                                                <?php
                                                if ($complaintPic == "none") {
                                                    echo "--";
                                                } else {
                                                    echo '<a href="../assets/' . $complaintPic . ' ?>" target="_blank">View Picture</a>';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $complaintDateSubmit ?></td>
                                            <td>December 20, 2021</td>
                                        </tr>
                                    <?php

                                    }
                                    ?>
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

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            // Set the sorting direction to ascending:
            dir = "asc";
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /* Loop through all table rows (except the
                first, which contains table headers): */
                for (i = 1; i < (rows.length - 1); i++) {
                    // Start by saying there should be no switching:
                    shouldSwitch = false;
                    /* Get the two elements you want to compare,
                    one from current row and one from the next: */
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /* Check if the two rows should switch place,
                    based on the direction, asc or desc: */
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /* If a switch has been marked, make the switch
                    and mark that a switch has been done: */
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    // Each time a switch is done, increase this count by 1:
                    switchcount++;
                } else {
                    /* If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again. */
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
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