<?php
session_start();
require_once './database/config.php';
require_once './database/dilg-admin.check.php';
$titleHeader = "Dashboard";
$message = "";

date_default_timezone_set("Asia/Manila");
if (isset($_POST['toAnnounce'])) {
    $title = $_POST['dTitle'];
    $dmessage = $_POST['dMessage'];
    $sendToAll = "";
    $sendTo = "";
    $sentToType = $_POST['dToType'];
    $dateToday = date("F j, Y, g:i a");

    if (isset($_POST['dAll'])) {
        //SEND TO ALL
        $sendToAll = $_POST['dAll'];

        $addToNotif = "INSERT INTO notification (d_title, d_message, d_datesubmit, d_to, d_totype, d_from, d_category) VALUES ('$title','$dmessage','$dateToday', '$sendToAll', '$sentToType','$id', 'announcement')";
        if ($con->exec($addToNotif)) {
            $message = "Announcement is added.";
        } else {
            $message = "Not added";
        }
    } else {
        if (isset($_POST['dTo'])) {
            //SEND TO SPECIFIC
            $sendTo = $_POST['dTo'];
            foreach ($sendTo as $key => $brgy) {
                $addToNotif = "INSERT INTO notification (d_title, d_message, d_datesubmit, d_to, d_totype, d_from, d_category) VALUES ('$title','$dmessage','$dateToday', '$brgy', '$sentToType','$id', 'announcement')";
                if ($con->exec($addToNotif)) {
                    $message = "Announcement is added.";
                } else {
                    $message = "Not added";
                }
            }
        } else {
            $message = "WALANG PINILING CHECKBOX";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/dilg-admin.style.css">
    <title>Document</title>
</head>

<body>
    <?php include './navbar/dilg.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/dilg.navbar-top.php' ?>
        <div class="transition px-4">
            <div class="row ttop">
                <div class="col-lg-9 col-sm-12">
                    <section id="topBanner" class="mt-0 mb-4">
                        <div style="color: #FCFDFF;">
                            <div class="row d-flex align-items-center" style="height: 30vh;">
                                <div class="col-lg-8 col-sm-12 px-5">
                                    <h2>Good Day, DILG of Magdalena</h2>
                                    <p class="mb-2">This dashboard page is designed to give you brief and important information about the data in your barangay. This also gives graphical information charts based on your data. If you have any inqueries or help in your accout please contact our support team.</p>
                                    <small class="mb-2"><b>If you encounter any problem,</b> message us at mr.carlvincent.bermundo@gmail.com</small><br>
                                    <button type="button" title="wwawa" class="add1 btn text-capitalize mx-0 mt-2" data-toggle="modal" data-target="#announcementModal">Add Announcement</button>
                                </div>
                                <div class="col-lg-4 d-flex justify-content-center removeSm">
                                    <img src="../assets/svg.png" class="img-fluid svg" alt="Responsive image">
                                </div>
                            </div>

                        </div>
                    </section>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <section class="ftco-section mt-0 mb-4">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="today">
                                    <div class="tp1 d-flex align-items-center justify-content-center">
                                        <div class="today-piece  top  day"></div>
                                    </div>

                                    <div class="tp2 mb-0 d-flex align-items-center justify-content-center text-center">
                                        <div>
                                            <div class="today-piece  middle  month m-0 p-0"></div>
                                            <div class="today-piece  middle  date m-0 p-0"></div>
                                        </div>
                                    </div>
                                    <div class="tp3 d-flex align-items-center justify-content-center">
                                        <div class="today-piece bottom year mt-0"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>

                </div>

            </div>
            <section id="list-count" class="mb-4">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-user-edit fa-2x mr-3 icon1"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $dsql = "SELECT * FROM complaint_case WHERE complaint_type = 'complaint'";
                                        $dsqlq = $con->prepare($dsql);
                                        $dsqlq->execute();
                                        $dscount = $dsqlq->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount ?></h5>
                                        <small class="card-text">Number of Complaints</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-sticky-note fa-2x mr-3 icon2"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $dsql1 = "SELECT * FROM complaint_case WHERE complaint_type = 'report'";
                                        $dsqlq1 = $con->prepare($dsql1);
                                        $dsqlq1->execute();
                                        $dscount1 = $dsqlq1->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount1 ?></h5>
                                        <small>Number of Reports</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-users fa-2x mr-3 icon3"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <?php
                                        $dsql2 = "SELECT * FROM rbi WHERE is_existing = 'yes'";
                                        $dsqlq2 = $con->prepare($dsql2);
                                        $dsqlq2->execute();
                                        $dscount2 = $dsqlq2->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $dscount2 ?></h5>
                                        <small class="card-text">Number of Barangay Inhabitants</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Modal for accept (PENDING TABLE) -->
            <div class="modal fade " id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content px-4 py-4">
                        <div class="modal-header">
                            <div>
                                <h4 class="modal-title" id="myModalLabel">Add Announcement</h4>
                                <p><span style="font-size: 13px; font-weight: 300;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, aspernatur odit<span></p>
                            </div>


                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <form method="post">
                            <div class="modal-body mx-5">

                                <div class="form-group">
                                    <label for="dTitle">Title</label>
                                    <input type="text" class="form-control" id="dTitle" name="dTitle" placeholder="Title" required>
                                </div>
                                <div class="form-group">
                                    <label for="dMessage">Message</label>
                                    <textarea class="form-control" id="dMessage" placeholder="Title" name="dMessage" rows="3" required></textarea>
                                </div>
                                <div class="complaintDiv mt-4">
                                    <h6 class="font-weight-bolder">Choose where to send</h6>
                                    <div class="form-group">
                                        <label for="barangaySelect">Account Type</label>
                                        <select name="dToType" class="form-control" id="barangaySelect">

                                            <option value="All">All</option>
                                            <option value="Barangay Captain">Barangay Captain</option>
                                            <option value="Barangay Secretary">Barangay Secretary</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="all1" name="dAll" value="all">
                                            <label class="form-check-label" for="all1">All</label>
                                        </div>
                                        <?php
                                        $barangayQuery = "SELECT DISTINCT barangay FROM account WHERE barangay != 'DILG' ORDER BY barangay";
                                        $barangayStmt = $con->query($barangayQuery);
                                        foreach ($barangayStmt as $row) {
                                            $barangayRow = $row['barangay'];

                                        ?>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input ccheckbox" type="checkbox" id="<?php echo $barangayRow ?>1" name="dTo[]" value="<?php echo $barangayRow ?>">
                                                <label class="form-check-label" for="<?php echo $barangayRow ?>1"><?php echo $barangayRow ?></label>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer flex-center">
                                <button type="submit" class="btn btnAccept text-capitalize" name="toAnnounce">Accept</button>

                                <button type="button" class="btn btn-danger text-capitalize" data-dismiss="modal">Close</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END OF MODAL -->

            <section>

                <div class="row mb-4">
                    <div class="col-lg-12">
                        <canvas id="myChartbar" class="p-4" style="background-color: white; height: 600px"></canvas>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-8 mb-4">
                        <canvas id="myChartLine" class="p-4" style="background-color: white;"></canvas>
                    </div>
                    <div class="col-lg-4">
                        <canvas id="myChartPie" class="p-4" style="background-color: white;"></canvas>

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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //chart bar
            <?php

            $getBarangay = "SELECT DISTINCT barangay FROM account WHERE barangay != 'DILG' ORDER BY barangay";
            $getBarangayque = $con->query($getBarangay);
            $label = [];
            $count = [];
            foreach ($getBarangayque as $row) {
                $label[] = $row['barangay'];
                $brgy = $row['barangay'];

                $roomcountsql = "SELECT * FROM complaint_case WHERE where_to = '$brgy' AND complaint_type = 'complaint'";
                $roomcountstmt = $con->prepare($roomcountsql);
                $roomcountstmt->execute();
                $roomcount = $roomcountstmt->rowCount();
                $count[] = $roomcount;
            }
            ?>

            const data = {


                labels: <?php echo json_encode($label); ?>,
                datasets: [{
                    label: 'Number of Complaints',
                    backgroundColor: 'rgb(17, 21, 128)',
                    hoverBackgroundColor: 'rgb(255,149,68)',
                    data: <?php echo json_encode($count); ?>,
                }]
            };

            const config = {
                type: 'bar',
                data,
                options: {
                    plugins: {
                        title: {
                            display: true,

                            color: "black",
                            text: 'Number of Complaints per Barangay in Magdalena',
                            padding: {
                                top: 10
                            },

                            font: {
                                size: 20,
                                family: "Roboto, sans-serif"
                            }
                        },
                        subtitle: {
                            display: true,
                            text: 'Custom Chart Subtitle'
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                },

            };

            var myChart = new Chart(
                document.getElementById('myChartbar'),
                config,
            );



            //chart line


            <?php
            $yeart = date('Y');
            $jan = 0;
            $feb = 0;
            $mar = 0;
            $apr = 0;
            $may = 0;
            $june = 0;
            $july = 0;
            $aug = 0;
            $sept = 0;
            $oct = 0;
            $nov = 0;
            $dec = 0;
            $getMeetingss = "SELECT * FROM complaint_case where complaint_type = 'complaint' AND incident_year = '$yeart'";
            $getMeetingssQ = $con->query($getMeetingss);
            foreach ($getMeetingssQ as $row) {
                $meetingMonth = $row['incident_month'];

                switch ($meetingMonth) {
                    case "January":
                        $jan += 1;
                        break;
                    case "February":
                        $feb += 1;
                        break;
                    case "March":
                        $mar += 1;
                        break;
                    case "April":
                        $apr += 1;
                        break;
                    case "May":
                        $may += 1;
                        break;
                    case "June":
                        $june += 1;
                        break;
                    case "July":
                        $july += 1;
                        break;
                    case "August":
                        $aug += 1;
                        break;
                    case "September":
                        $sept += 1;
                        break;
                    case "October":
                        $oct += 1;
                        break;
                    case "November":
                        $nov += 1;
                        break;
                    case "December":
                        $dec += 1;
                        break;
                }
            }


            ?>

            const labelsLine = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];

            const dataLine = {
                labels: labelsLine,
                datasets: [{
                    label: 'Complaints per Month',
                    backgroundColor: 'rgb(17, 21, 128)',
                    hoverBackgroundColor: 'rgb(255,149,68)',
                    borderColor: 'rgb(17, 21, 128)',
                    data: [
                        <?php echo (int)$jan; ?>,
                        <?php echo (int)$feb; ?>,
                        <?php echo (int)$mar; ?>,
                        <?php echo (int)$apr; ?>,
                        <?php echo (int)$may; ?>,
                        <?php echo (int)$june; ?>,
                        <?php echo (int)$july; ?>,
                        <?php echo (int)$aug; ?>,
                        <?php echo (int)$sept; ?>,
                        <?php echo (int)$oct; ?>,
                        <?php echo (int)$nov; ?>,
                        <?php echo (int)$dec; ?>
                    ],
                }]
            };

            const configLine = {
                type: 'bar',
                data: dataLine,
                options: {
                    indexAxis: 'y',
                    plugins: {
                        title: {
                            display: true,
                            text: 'Number of Complaints per Month in Year <?php echo $yeart ?>',
                            padding: {
                                top: 10,
                                bottom: 30
                            },
                            font: {
                                size: 20,
                            }
                        }
                    }
                }
            };

            var myChart = new Chart(
                document.getElementById('myChartLine'),
                configLine
            );


            // chart pie

            <?php
            $getGender = "SELECT * FROM rbi where is_existing = 'yes'";
            $female = 0;
            $male = 0;
            $getGenderQ = $con->query($getGender);
            foreach ($getGenderQ as $row123) {
                $genderG = $row123['gender'];

                if ($genderG == "Male") {
                    $male += 1;
                } elseif ($genderG == "Female") {
                    $female += 1;
                }
            }
            ?>

            const labelsPie = [
                "Female",
                "Male"
            ];

            const dataPie = {
                labels: labelsPie,
                datasets: [{
                    label: 'Inhabitants Gender',
                    backgroundColor: ["rgb(17, 21, 128)", "rgb(255,149,68)"],
                    data: [
                        <?php echo (int)$female; ?>,
                        <?php echo (int)$male; ?>,

                    ],
                }]
            }

            const configPie = {
                type: 'doughnut',
                data: dataPie,
                plugins: [ChartDataLabels],
                options: {
                    plugins: {
                        datalabels: {
                            color: 'white',
                            font: {
                                weight: 'bold',
                                size: 20
                            }
                        },
                        title: {
                            display: true,
                            text: 'Male and Female Inhabitatns',
                            padding: {
                                top: 10,
                                bottom: 30
                            },
                            font: {
                                size: 20,
                            }
                        }
                    }
                }
            };

            var ctx1 = document.getElementById('myChartPie'); // node
            const myChartpie = new Chart(ctx1, configPie);



            $('#all1').click(function(event) {
                if (this.checked) {
                    // Iterate each checkbox
                    $(':checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $(':checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });

            $('.ccheckbox').click(function() {
                if ($(this).prop("checked") == false) {
                    $('#all1').prop('checked', false);
                }
            });


        });
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });
        });

        (function($) {

            "use strict";

            /**
             * Credit where credit is due:
             *
             * Thanks, SpYk3HH for your sweet fiddlin'.
             * http://jsfiddle.net/SpYk3/rYzAY/
             */

            function DateTime() {
                function getDaySuffix(a) {
                    var b = "" + a,
                        c = b.length,
                        d = parseInt(b.substring(c - 2, c - 1)),
                        e = parseInt(b.substring(c - 1));
                    if (c == 2 && d == 1) return "th";
                    switch (e) {
                        case 1:
                            return "st";
                            break;
                        case 2:
                            return "nd";
                            break;
                        case 3:
                            return "rd";
                            break;
                        default:
                            return "th";
                            break;
                    };
                };

                this.getDoY = function(a) {
                    var b = new Date(a.getFullYear(), 0, 1);
                    return Math.ceil((a - b) / 86400000);
                }

                this.date = arguments.length == 0 ? new Date() : new Date(arguments);

                this.weekdays = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                this.months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                this.daySuf = new Array("st", "nd", "rd", "th");

                this.day = {
                    index: {
                        week: "0" + this.date.getDay(),
                        month: (this.date.getDate() < 10) ? "0" + this.date.getDate() : this.date.getDate()
                    },
                    name: this.weekdays[this.date.getDay()],
                    of: {
                        week: ((this.date.getDay() < 10) ? "0" + this.date.getDay() : this.date.getDay()) + getDaySuffix(this.date.getDay()),
                        month: ((this.date.getDate() < 10) ? "0" + this.date.getDate() : this.date.getDate()) + getDaySuffix(this.date.getDate())
                    }
                }

                this.month = {
                    index: (this.date.getMonth() + 1) < 10 ? "0" + (this.date.getMonth() + 1) : this.date.getMonth() + 1,
                    name: this.months[this.date.getMonth()]
                };

                this.year = this.date.getFullYear();

                this.sym = {
                    d: {
                        d: this.date.getDate(),
                        dd: (this.date.getDate() < 10) ? "0" + this.date.getDate() : this.date.getDate(),
                        ddd: this.weekdays[this.date.getDay()].substring(0, 3),
                        dddd: this.weekdays[this.date.getDay()],
                        ddddd: ((this.date.getDate() < 10) ? "0" + this.date.getDate() : this.date.getDate()) + getDaySuffix(this.date.getDate()),
                        m: this.date.getMonth() + 1,
                        mm: (this.date.getMonth() + 1) < 10 ? "0" + (this.date.getMonth() + 1) : this.date.getMonth() + 1,
                        mmm: this.months[this.date.getMonth()].substring(0, 3),
                        mmmm: this.months[this.date.getMonth()],
                        yy: ("" + this.date.getFullYear()).substr(2, 2),
                        yyyy: this.date.getFullYear()
                    }
                };

                this.formats = {
                    pretty: {
                        a: this.sym.d.dddd,
                        b: this.sym.d.ddddd,
                        c: this.sym.d.mmmm,
                        d: this.sym.d.yyyy
                    }
                };
            };



            var dt = new DateTime();
            $('.day').text(dt.formats.pretty.a);
            $('.date').text(dt.formats.pretty.b);
            $('.month').text(dt.formats.pretty.c);
            $('.year').text(dt.formats.pretty.d);

        })(jQuery);
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