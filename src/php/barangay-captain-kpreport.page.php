<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-captain.check.php';
$titleHeader = "KP Report";
$message = "";
$confirm = "no";

date_default_timezone_set("Asia/Manila");

if (isset($_POST['kpreject'])) {
    $id = $_POST['id'];
    $monthkp = $_POST['monthkp'];
    $yearkp = $_POST['yearkp'];
    $unreadsql = "UPDATE kpreport SET kp_status = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "breject",
        ':id' => $id

    ])) {
        $notifTitle = "KP Report Rejected";
        $notifMesg = "KP Report for $monthkp $yearkp was rejected";
        $notifTo = "DILG";
        $notifToType = "Barangay Secretary";
        $notifFrom = $cookieId;

        require './get-notif.php';
        $confirm = "yes";
        $message = "Kp Rejected";
    }
}

if (isset($_POST['kpapprove'])) {
    $id = $_POST['id'];
    $monthkp = $_POST['monthkp'];
    $yearkp = $_POST['yearkp'];
    $todayNow = date("F j, Y, g:i a");
    $unreadsql = "UPDATE kpreport SET kp_status = :case_status, is_dilg = :isd, date_submitted = :ds WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "dpending",
        ':isd' => "1",
        ':ds' => $todayNow,
        ':id' => $id

    ])) {
        $notifTitle = "KP Report Accepted";
        $notifMesg = "KP Report for $monthkp $yearkp was successfully accepted";
        $notifTo = "DILG";
        $notifToType = "Barangay Secretary";
        $notifFrom = $cookieId;

        require './get-notif.php';
        $confirm = "yes";
        $message = "Kp Accepted";
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
    <?php include './navbar/barangay-captain.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/barangay-captain.navbar-top.php' ?>
        <div class="transition px-4">
            <section id="list-count" class="mb-4">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-sign-in-alt fa-2x mr-3 icon2"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $pendingcountsql = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_status = 'bpending'";
                                        $pendingcountstmt = $con->prepare($pendingcountsql);
                                        $pendingcountstmt->execute();
                                        $pendingcount = $pendingcountstmt->rowCount();

                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount ?></h5>
                                        <small class="card-text">Reports to be approved</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-signature fa-2x mr-3 icon4"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $pendingcountsql2 = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_status = 'dreceived'";
                                        $pendingcountstmt2 = $con->prepare($pendingcountsql2);
                                        $pendingcountstmt2->execute();
                                        $pendingcount2 = $pendingcountstmt2->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount2 ?></h5>
                                        <small>Reports Submitted</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-backspace fa-2x mr-3 icon3"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $pendingcountsql3 = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_status = 'dreject'";
                                        $pendingcountstmt3 = $con->prepare($pendingcountsql3);
                                        $pendingcountstmt3->execute();
                                        $pendingcount3 = $pendingcountstmt3->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount3 ?></h5>
                                        <small class="card-text">Reports Rejected</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="table-section" class="mt-3">
                <div id="tableNavbar" class="mx-4 mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>KP reports</h1>
                        </div>
                    </div>
                    <div class="row mt-3 ml-4 navholder">
                        <div class="com-md-12">
                            <nav id="navSort">
                                <div class="nav sort" id="nav-tab" role="tablist">
                                    <a class="nav-item btnSort nav-link active px-4 mr-1" id="nav-unread-tab" data-toggle="tab" href="#nav-unread" role="tab" aria-controls="nav-unread" aria-selected="true"><span class="sortTitle">Secretary Pending</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-read-tab" data-toggle="tab" href="#nav-read" role="tab" aria-controls="nav-read" aria-selected="false"><span class="sortTitle">Submitted to DILG</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-read1-tab" data-toggle="tab" href="#nav-read1" role="tab" aria-controls="nav-read1" aria-selected="false"><span class="sortTitle">DILG Received</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-read-tab2" data-toggle="tab" href="#nav-read2" role="tab" aria-controls="nav-read2" aria-selected="false"><span class="sortTitle">DILG Rejected</span></a>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div id="tableContent" class="px-4 mb-4 py-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <div class="tab-content" id="nav-tabContent">
                                <!-- TABLE PENDING -->
                                <div class="tab-pane fade show active" id="nav-unread" role="tabpanel" aria-labelledby="nav-unread-tab">
                                    <table class="table table1 table-hover text-center" id="table12312312" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Month</th>
                                                <th scope="col">Year</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_status = 'bpending'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['kp_filename'];
                                                $kpmonth = $row['kp_month'];

                                                $kpyear = $row['kp_year'];

                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><a href="../assets/kpreport/<?php echo $fname; ?>" target="_blank"><?php echo $fname ?></a></td>
                                                        <td class="text-capitalize"><?php echo $kpmonth ?><input type="hidden" name="monthkp" value="<?php echo $kpmonth ?>" /></td>
                                                        <td><?php echo $kpyear ?><input type="hidden" name="yearkp" value="<?php echo $kpyear ?>" /></td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button class="add btn hvr-pulse-grow" type="submit" name="kpapprove"><i class="fas fa-check"></i></button>
                                                                <button class="add btn btn-danger hvr-pulse-grow" type="submit" name="kpreject"><i class="fas fa-times"></i></button>
                                                            </div>


                                                        </td>
                                                    </form>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE REJECT -->
                                <div class="tab-pane fade" id="nav-read" role="tabpanel" aria-labelledby="nav-read-tab">
                                    <table class="table table1 table-hover text-center" id="table12" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Month</th>
                                                <th scope="col">Year</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_status = 'dpending'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['kp_filename'];
                                                $kpmonth = $row['kp_month'];

                                                $kpyear = $row['kp_year'];

                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><a href="../assets/kpreport/<?php echo $fname; ?>" target="_blank"><?php echo $fname ?></a></td>
                                                        <td class="text-capitalize"><?php echo $kpmonth ?></td>
                                                        <td><?php echo $kpyear ?></td>
                                                    </form>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE REJECT -->
                                <div class="tab-pane fade" id="nav-read1" role="tabpanel" aria-labelledby="nav-read1-tab">
                                    <table class="table table1 table-hover text-center" id="table123" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Month</th>
                                                <th scope="col">Year</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_status = 'dreceived'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['kp_filename'];
                                                $kpmonth = $row['kp_month'];

                                                $kpyear = $row['kp_year'];

                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><a href="../assets/kpreport/<?php echo $fname; ?>" target="_blank"><?php echo $fname ?></a></td>
                                                        <td class="text-capitalize"><?php echo $kpmonth ?></td>
                                                        <td><?php echo $kpyear ?></td>
                                                    </form>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE REJECT -->
                                <div class="tab-pane fade" id="nav-read2" role="tabpanel" aria-labelledby="nav-read2-tab">
                                    <table class="table table1 table-hover text-center" id="table1234" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Month</th>
                                                <th scope="col">Year</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM kpreport WHERE brgy = '$barangayName' AND kp_status = 'dreject'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['kp_filename'];
                                                $kpmonth = $row['kp_month'];

                                                $kpyear = $row['kp_year'];

                                            ?>

                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><a href="../assets/kpreport/<?php echo $fname; ?>" target="_blank"><?php echo $fname ?></a></td>
                                                        <td class="text-capitalize"><?php echo $kpmonth ?></td>
                                                        <td><?php echo $kpyear ?></td>
                                                    </form>
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

    <script type="text/javascript">
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });
        });

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