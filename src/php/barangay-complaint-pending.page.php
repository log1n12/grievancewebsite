<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$message = "";

if (isset($_GET['toPaymentBtn'])) {
    $id = $_GET['id'];
    $unreadsql = "UPDATE complaint_case SET case_status = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "Payment",
        ':id' => $id

    ])) {
        $message = "Updated";
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
                            <h1 class="mx-4 mt-4">List of Complaints</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <button id="addBtn" class="add btn mx-4 mt-4" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" data-placement="left" title="Add Hospital"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="container">
                            <div class="card card-body transparent">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="container formm">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="First Name" name="ufirstname" id="fnamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Last Name" name="ulastname" id="lnamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" class="form-control transparent text-center" placeholder="Email" name="uemail" id="emaillbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Username" name="uname" id="unamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control transparent text-center" placeholder="Password" name="upass" name="upass" id="password" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Name" name="hospname" id="hospnamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Address" name="hospaddress" id="hospaddlbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Town" name="hosptown" id="hosptownlbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Website" name="uwebsite" id="hospweblbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="file" name="profileImage" id="profileImage" class="form-control-file transparent" onChange="displayImage(this)" required><br>
                                                    <img src="" style="max-width: 300px;" class="img-fluid transparent" id="profileDisplay" onclick="triggerClick()">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" name="submit" class="addhospbtn btn btn-block ">Add Hospital</button>
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
                                <a href="./barangay-complaint.page.php" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">All</a>
                                <a href="./barangay-complaint-pending.page.php" class="btn btn-dark btnSort px-4 mr-1 active" name="all" value="all">Pending</a>
                                <a href="./barangay-complaint-confirm.page.php" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Payment</a>
                                <a href="./barangay-complaint-ongoing.page.php" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Ongoing</a>
                                <a href="./barangay-complaint-completed.page.php" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Completed</a>
                            </form>
                            <table class="table text-center mt-4" id="myTable" style="width: 100%">
                                <colgroup>
                                    <col span="1" style="width: 5%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 30%;">
                                    <col span="1" style="width: 8%;">
                                    <col span="1" style="width: 7%;">
                                    <col span="1" style="width: 7%;">
                                    <col span="1" style="width: 2%;">
                                    <col span="1" style="width: 2%;">
                                    <col span="1" style="width: 2%;">
                                </colgroup>
                                <thead class="">
                                    <tr>
                                        <th onclick="sortTable(0)">ID <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(1)" scope="col">Reference Numbers <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(2)" scope="col">Complainant <i class="fas fa-sort"></i></th>
                                        <th scope="col">Defendant</th>
                                        <th scope="col">Complaint</th>
                                        <th onclick="sortTable(3)" scope="col">Status</th>
                                        <th scope="col">Picture</th>
                                        <th scope="col">Date</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $showComplaintSql = "SELECT * FROM complaint_case WHERE defendant_type = 'Resident' AND case_status ='Pending'";
                                    $showComplaintQuery = $con->query($showComplaintSql);
                                    foreach ($showComplaintQuery as $row) {
                                        $complaintId = $row['id'];
                                        $complaintRefNo = $row['case_ref_no'];
                                        $complainantId = $row['comp_rbi_no'];
                                        $complaint = $row['complaint'];
                                        $complaintStatus = $row['case_status'];
                                        $complaintPic = $row['incident_pic'];
                                        $complaintDateSubmit = $row['date_submit'];

                                        $showComplainantBrgy = "SELECT * FROM rbi WHERE id = '$complainantId'";
                                        $showComplainantBrgyQue = $con->query($showComplainantBrgy);
                                        foreach ($showComplainantBrgyQue as $row1) {
                                            $complainantBrgy = $row1['brgy'];
                                            $complainantFullname = $row1['first_name'] . ' ' . $row1['middle_name'] . ' ' . $row1['last_name'];

                                            if ($complainantBrgy == $barangayName) {
                                    ?>
                                                <form method="get">
                                                    <tr>
                                                        <td><?php echo $complaintId ?><input type="hidden" name="id" value="<?php echo $complaintId ?>" /> </td>
                                                        <td><?php echo $complaintRefNo ?> </td>
                                                        <td><?php echo $complainantFullname ?> </td>
                                                        <td>
                                                            <?php
                                                            $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
                                                            $getDefendantQuery = $con->query($getDefendant);
                                                            foreach ($getDefendantQuery as $row2) {
                                                                $defFullname = $row2['full_name'];

                                                                echo $defFullname;

                                                            ?>
                                                                <br>
                                                            <?php } ?>

                                                        </td>
                                                        <td><?php echo $complaint ?></td>
                                                        <td><?php echo $complaintStatus ?></td>
                                                        <td><?php echo $complaintPic ?></td>
                                                        <td><?php echo $complaintDateSubmit ?></td>
                                                        <td><button type="submit" name="toPaymentBtn"><i class="fas fa-check"></i></button></td>
                                                        <td><button><i class="fas fa-trash"></i></button></td>
                                                        <td><button><i class="fas fa-ellipsis-h"></i></button></td>
                                                    </tr>
                                                </form>
                                    <?php
                                            }
                                        }
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
</body>

</html>