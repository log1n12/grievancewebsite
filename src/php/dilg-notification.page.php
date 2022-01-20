<?php
session_start();
require_once './database/config.php';
require_once './database/dilg-admin.check.php';
$titleHeader = "Notification";
$message = "";
$confirm = "no";

date_default_timezone_set("Asia/Manila");


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
                <div id="tableNavbar" class="mx-4 mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>List of Notifications</h1>
                        </div>
                    </div>
                </div>
                <div id="tableContent" class="px-4 mb-4 py-4">
                    <div class="row">

                        <div class="col col-md-12">
                            <div class="container">
                                <?php
                                $getNotif = "SELECT * FROM notification WHERE d_to = '$barangayName' ORDER BY id DESC";
                                $getNotifQ = $con->query($getNotif);
                                foreach ($getNotifQ as $row) {
                                    $nTitle = $row['d_title'];
                                    $nMessage = $row['d_message'];
                                    $nDate = $row['d_datesubmit'];
                                    $nFrom = $row['d_from'];
                                    $nCategory = $row['d_category'];

                                    if ($nFrom === "0") {
                                        $notifSubtitle = "Resident of Magdalena";
                                        $notifPicture = "resident.png";
                                    } elseif ($nFrom === "00") {
                                        $notifSubtitle = "Not Resident of Magdalena";
                                        $notifPicture = "outsider.png";
                                    } else {
                                        $getAccountInfo = "SELECT * FROM account WHERE id = '$nFrom'";
                                        $getAccountInfoQ = $con->query($getAccountInfo);
                                        foreach ($getAccountInfoQ as $row1) {
                                            $notifBarangay = $row1['barangay'];
                                            $notifPosition = $row1['user_type'];
                                            $notifPosition1 = "";
                                            $notifPicture = $row1['sec_picture'];

                                            if ($notifPosition == "barangay_captain") {
                                                $notifPosition1 = "Barangay Captain";
                                            } elseif ($notifPosition == "barangay_admin") {
                                                $notifPosition1 = "Barangay Secretary";
                                            }

                                            $notifSubtitle = $notifBarangay . " " . $notifPosition1;
                                        }
                                    }
                                ?>
                                    <div class="py-4">
                                        <div class="row">
                                            <div class="col-3 align-self-center">
                                                <img src="../assets/account_pic/<?php echo $notifPicture ?>" height="75" />
                                            </div>
                                            <div class="col-9">
                                                <h6 class="mb-0"><?php echo $nTitle ?></h6>
                                                <p class="mt-0 mb-1 text-muted notifAuthor"><?php echo $notifSubtitle ?></p>
                                                <p class="mt-0 notifMesg"><?php echo $nMessage ?></p>
                                                <small><?php echo $nDate ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <?php
                                }
                                ?>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    </script>

    <script type="text/javascript">
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