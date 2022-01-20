<?php
session_start();
require_once 'database/config.php';
$x = "";
$message = "";

if (isset($_POST['casebtn'])) {
    $refNo = $_POST['caserefno'];
    $x = "1";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/main-services.style.css">


    <title>Document</title>
</head>

<body>
    <?php include './navbar/main.navbar.php'; ?>
    <section id="topBanner">
        <div class="container banner" data-aos="zoom-out" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <h2 class="st section-title-heading text-uppercase">Services</h2>
                    <h3 class="text-uppercase">Check <span class="accent">Status</span> </h3>
                    <p class="text-uppercase">Alamin ang status ng inyong complaint o report. </p>
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
    <section id="servContent">
        <div class="container">
            <div class="sec-title text-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center transparent">
                        <li class="breadcrumb-item"><a href="./service.page.php">Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Status</li>
                    </ol>
                </nav>
                <h3 class="text-uppercase mt-3" data-aos-offset="200" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">Check Status</h3>

                <p class="mt-3" data-aos-offset="200" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">Ilagay ang reference number ng inyong complaint o report na ibinigay pagkatapos isumita sa pamamagitan ng text. Siguraduhing tama ang ilalagay na reference number at pindutin ang 'Submit' button.</p>
            </div>
            <div class="form-section mt-5 pb-5" data-aos-offset="150" data-aos="fade-up" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                <form method="post">
                    <div class="form-row justify-content-center">
                        <div class="col-md-1">

                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control trackCase" name="caserefno" value="<?php
                                                                                                        if ($x != "") {
                                                                                                            echo $refNo;
                                                                                                        }
                                                                                                        ?>" placeholder="Enter the Case Reference Number" required>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" name="casebtn" class="btn trackBtn text-capitalize">Submit</button>
                        </div>
                        <div class="col-md-1">

                        </div>
                    </div>
                </form>
            </div>

            <?php
            //SHOW ALERT MESSAGE 
            if ($x != "") {
                $caseRefNo = $refNo;
                //Get complaints
                //Get comp_rbi_no
                //Check the barangay 
                $showComplaintSql = "SELECT * FROM complaint_case WHERE case_ref_no = '$caseRefNo'";
                $completedcountstmt = $con->prepare($showComplaintSql);
                $completedcountstmt->execute();
                $completedcount = $completedcountstmt->rowCount();
                if ($completedcount > 0) {

            ?>
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <table class="table table1 text-center" id="table11" style="width: 100%">

                                <thead class="">
                                    <tr>
                                        <th>ID</th>
                                        <th scope="col">Reference Numbers</th>
                                        <th scope="col">Complainant</i></th>
                                        <th scope="col">Defendant</th>
                                        <th scope="col">Complaint</th>
                                        <th scope="col">Status</i></th>
                                        <th scope="col">Picture</th>
                                        <th scope="col">Submit Date</th>
                                        <th scope="col">Barangay</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php


                                    $showComplaintQuery = $con->query($showComplaintSql);
                                    foreach ($showComplaintQuery as $row) {
                                        $complaintId = $row['id'];
                                        $complaintRefNo = $row['case_ref_no'];
                                        $complaint = $row['complaint'];
                                        $complaintStatus = $row['case_status'];
                                        $complaintPic = $row['incident_pic'];
                                        $complaintDateSubmit = $row['date_submit'];
                                        $complaintWhere = $row['where_to'];
                                        $complaintActionTaken = $row['action_taken'];
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
                                                        $rbiFname = $row3['first_name'] . " " . $row3['middle_name'] . " " . $row3['last_name'];
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
                                                        $rbiExisting = $row3['is_existing'];


                                                ?>
                                                        <a class="text-capitalize" href="#" tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-content='<div class="popoverContent"></div><div class="row"><div class="col-md-4"><img src="../assets/<?php echo $rbiValiId ?>" alt="..." class="float-left img-fluid"></div><div class="col-md-8"><h5><?php echo $rbiFname ?></h5><p><?php echo $rbiAddress ?></p><p><?php echo $rbiBday ?></p><p><?php echo $rbiBplace ?></p><p><?php echo $rbiGender ?></p><p><?php echo $rbiContactNumber ?></p></div></div>'><?php echo strtolower($rbiFname) ?> </a>
                                                        <br><small class='small'>(<?php echo $rbiBrgy  ?>) <?php if ($rbiExisting == "yes") {
                                                                                                                echo '<span class="badge bg-success" style="font-size: 10.5px;">Verified</span>';
                                                                                                            } elseif ($rbiExisting == "pending") {
                                                                                                                echo '<span class="badge bg-warning" style="font-size: 10.5px;">Pending</span>';
                                                                                                            } else {
                                                                                                                echo '<span class="badge bg-danger" style="font-size: 10.5px;">Removed</span>';
                                                                                                            } ?></small>
                                                        <br>
                                                <?php }
                                                } ?>
                                            </td>

                                            <td class="text-capitalize">
                                                <?php
                                                $getDefendant = "SELECT * FROM defendant WHERE case_ref_no = '$complaintRefNo'";
                                                $getDefCountPrep = $con->prepare($getDefendant);
                                                $getDefCountPrep->execute();
                                                $getDefCount = $getDefCountPrep->rowCount();
                                                if ($getDefCount > 0) {
                                                    $getDefendantQuery = $con->query($getDefendant);
                                                    foreach ($getDefendantQuery as $row2) {
                                                        $defFullname = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                                                        $defPosition = $row2['position'];

                                                        echo  strtolower($defFullname) . " <br><small class='small text-capitalize'>(" . $defPosition . ")</small>";
                                                ?>
                                                        <br>
                                                <?php }
                                                } else {
                                                    echo "--";
                                                } ?>

                                            </td>
                                            <td><?php echo $complaint ?></td>
                                            <td><span style="font-size: 12px; font-weight: bolder; padding: 10px 10px; border-radius:4px; background-color: <?php
                                                                                                                                                            if ($complaintStatus == "Pending") {
                                                                                                                                                                echo "#49d97b";
                                                                                                                                                            } elseif ($complaintStatus == "Payment") {
                                                                                                                                                                echo "#b693e2";
                                                                                                                                                            } elseif ($complaintStatus == "Ongoing") {
                                                                                                                                                                echo "#49d3d9";
                                                                                                                                                            } elseif ($complaintStatus == "Completed") {
                                                                                                                                                                echo "#fcb654";
                                                                                                                                                            } elseif ($complaintStatus == "Rejected") {
                                                                                                                                                                echo '#ed7469" tabindex="0" role="button" data-html="true" data-toggle="popover" title="Explanation" data-placement="top" data-trigger="hover" data-content="' . $complaintActionTaken;
                                                                                                                                                            } elseif ($complaintStatus == "Document") {
                                                                                                                                                                echo "#ed9969";
                                                                                                                                                            }
                                                                                                                                                            ?>"><?php echo $complaintStatus ?></span></td>
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
                                            <td><?php echo $complaintWhere ?></td>
                                        </tr>

                                    <?php

                                    }
                                    ?>
                                </tbody>


                            </table>
                        </div>
                    </div>

            <?php
                } else {
                    echo "<h4 class='text-center'> Complaint Reference Number is not exisiting. Please try again! </h4>";
                }
            }
            ?>

        </div>
    </section>

    <?php include './navbar/main.footer.php' ?>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
    </script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js">
    </script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table11').DataTable({
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                responsive: true,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 5
                    },
                    {
                        responsivePriority: 10001,
                        targets: 4
                    }
                ]
            });
        });


        <?php
        if ($x != "") {
        ?>
            $(document).ready(function() {
                var elmnt = document.getElementById('servContent');
                elmnt.scrollIntoView();

            });
        <?php
        }
        ?>
        $(window).scroll(function() {
            $('.navbar').toggleClass('scrolled', $(this).scrollTop() > 50);
        });
        var lastScrollTop = 0;
        $(window).scroll(function() {
            var st = $(this).scrollTop();
            var banner = $('.navbar');
            setTimeout(function() {
                if (st > lastScrollTop) {
                    banner.addClass('hide');
                    banner.removeClass('transparent');
                } else {
                    banner.removeClass('hide');
                }
                lastScrollTop = st;
            }, 100);
        });

        //GETTING DATE
        $(window).on('load', function() {

            displayClock();
        });
        var span = document.getElementById('phTime');

        function displayClock() {
            var display = new Date().toLocaleTimeString();
            span.innerHTML = display;
            setTimeout(displayClock, 1000);
        }
    </script>
</body>

</html>