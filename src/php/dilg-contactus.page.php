<?php
session_start();
require_once './database/config.php';
require_once './database/dilg-admin.check.php';
$titleHeader = "Feedback";
$confirm = "no";
$message = "";

if (isset($_POST['read'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE contactus SET is_read = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "1",
        ':id' => $id

    ])) {
        $confirm = "yes";
        $message = "You read the feedback";
    }
}


if (isset($_POST['unread'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE contactus SET is_read = :case_status WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':case_status' => "0",
        ':id' => $id

    ])) {
        $confirm = "yes";
        $message = "You unread the feedback";
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
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-paper-plane fa-2x mr-3 icon1"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $dsql = "SELECT * FROM contactus WHERE is_read = '0'";
                                        $dsqlq = $con->prepare($dsql);
                                        $dsqlq->execute();
                                        $dscount = $dsqlq->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount ?></h5>
                                        <small class="card-text">Unread Feedbacks</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-paper-plane fa-2x mr-3 icon2"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $dsql1 = "SELECT * FROM contactus WHERE is_read = '1'";
                                        $dsqlq1 = $con->prepare($dsql1);
                                        $dsqlq1->execute();
                                        $dscount1 = $dsqlq1->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount1 ?></h5>
                                        <small>Read Feedbacks</small>
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
                            <h1 class="mx-4 mt-3">List of Feedbacks</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <a id="addBtn" class="add1 btn mx-4 mt-3 text-capitalize hvr-icon-spin" href="https://mail.google.com/mail/u/0/?fs=1&su=<?php echo "Reply to feedback" ?>&tf=cm" target="_blank"><i class="fas fa-plus mr-2 hvr-icon"></i> Send Email</a>
                        </div>
                    </div>
                    <div class="row mt-3 ml-4">
                        <div class="com-md-12">
                            <nav id="navSort">
                                <div class="nav sort" id="nav-tab" role="tablist">
                                    <a class="nav-item btnSort nav-link active px-4 mr-1" id="nav-unread-tab" data-toggle="tab" href="#nav-unread" role="tab" aria-controls="nav-unread" aria-selected="true"><span class="sortTitle">Unread</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-read-tab" data-toggle="tab" href="#nav-read" role="tab" aria-controls="nav-read" aria-selected="false"><span class="sortTitle">Read</span></a>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div id="tableContent" class="px-4 mb-4 py-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <div class="tab-content" id="nav-tabContent">
                                <!-- TABLE UNREAD -->
                                <div class="tab-pane fade show active" id="nav-unread" role="tabpanel" aria-labelledby="nav-unread-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table12312312" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Message</th>
                                                <th scope="col">Date Submitted</th>
                                                <th scope="col">Read</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM contactus WHERE is_read = '0'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['first_name'];
                                                $lname = $row['last_name'];
                                                $emailadd = $row['user_email'];
                                                $mesg = $row['user_message'];
                                                $senddate = $row['send_date'];

                                            ?>

                                                <tr class="font-weight-bold">
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><?php echo $fname ?></a></td>
                                                        <td><?php echo $lname ?></td>
                                                        <td><a href="https://mail.google.com/mail/u/0/?fs=1&to=<?php echo $emailadd ?>&su=<?php echo "Reply to feedback" ?>&tf=cm" target="_blank"><?php echo $emailadd ?></a></td>
                                                        <td><?php echo $mesg ?></td>
                                                        <td><?php echo $senddate ?></td>
                                                        <td><button class="add btn hvr-pulse-grow" type="submit" name="read"><i class="fas fa-arrow-right"></i></button></td>
                                                    </form>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TABLE READ -->
                                <div class="tab-pane fade" id="nav-read" role="tabpanel" aria-labelledby="nav-read-tab">
                                    <table class="table table1 table-hover table-striped text-center" id="table12" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Message</th>
                                                <th scope="col">Date Submitted</th>
                                                <th scope="col">Unread</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showFeedBackSql = "SELECT * FROM contactus WHERE is_read = '1'";
                                            $showFeedBackquery = $con->query($showFeedBackSql);
                                            foreach ($showFeedBackquery as $row) {
                                                $id = $row['id'];
                                                $fname = $row['first_name'];
                                                $lname = $row['last_name'];
                                                $emailadd = $row['user_email'];
                                                $mesg = $row['user_message'];
                                                $senddate = $row['send_date'];

                                            ?>
                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /></td>
                                                        <td><?php echo $fname ?></a></td>
                                                        <td><?php echo $lname ?></td>
                                                        <td><a href="https://mail.google.com/mail/u/0/?fs=1&to=<?php echo $emailadd ?>&su=<?php echo "Reply to feedback" ?>&tf=cm" target="_blank"><?php echo $emailadd ?></a></td>
                                                        <td><?php echo $mesg ?></td>
                                                        <td><?php echo $senddate ?></td>
                                                        <td><button class="add btn hvr-pulse-grow" type="submit" name="unread"><i class="fas fa-arrow-left"></i></button></td>
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
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
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