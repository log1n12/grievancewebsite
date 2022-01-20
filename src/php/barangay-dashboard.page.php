<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$titleHeader = "Dashboard";
$message = "";

date_default_timezone_set("Asia/Manila");
//get all meeting
//get caserefno
//check if caserefno in casereftable is from the barangay

//if from your barangay check the date kung nakalipas na
//increment $count
$countMeeting = 0;
$countMeeting1 = 0;
$dateNow = new DateTime(date('Y-m-d'));
$getMeetingss = "SELECT * FROM meeting WHERE meet_status = '--'";
$getMeetingssQ = $con->query($getMeetingss);
foreach ($getMeetingssQ as $row) {
    $meetingDate = $row['meet_date'];
    $dateMeeting = new DateTime($meetingDate);
    $compRefNo = $row['case_ref_no'];
    $checkBrgy = "SELECT * FROM complaint_case WHERE case_ref_no = '$compRefNo'";
    $checkBrgyQue = $con->query($checkBrgy);

    foreach ($checkBrgyQue as $row1) {
        //get brgy
        $brgy = $row1['where_to'];
        if ($brgy == $barangayName) {
            if ($dateMeeting < $dateNow) {
                $countMeeting += 1;
            } elseif ($dateMeeting == $dateNow) {
                $countMeeting1 += 1;
            }
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/barangay-admin.style.css">
    <title>Document</title>
</head>

<body>
    <?php include './navbar/barangay.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/barangay.navbar-top.php' ?>

        <div class="transition px-4">

            <?php
            //SHOW ALERT MESSAGE 
            if ($countMeeting > 0 or $countMeeting1 > 0) {
            ?>
                <div class="alert alert-dismissible alertMeeting fade show py-4" role="alert">
                    <div class="d-flex">
                        <div class="align-self-center mx-3">
                            <i class="fas fa-info-circle fa-3x"></i>
                        </div>
                        <div class="align-self-center">
                            <strong>Hey! <?php
                                            if ($countMeeting1 > 0) {
                                                echo "You have <b>$countMeeting1 meeting</b> today.";
                                            }
                                            if ($countMeeting > 0) {
                                                echo "You have <b>$countMeeting meeting</b> on the ongoing complaint that are not completed.";
                                            }
                                            ?>
                                Go to <u><b><a href="./barangay-complaint.page.php" id="alertHref" style="color:white">complaint</a></u></b> page.
                            </strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                </div>
            <?php
            }
            ?>

            <div class="row ttop">
                <div class="col-lg-9 col-sm-12">
                    <section id="topBanner" class="mt-0 mb-4">
                        <div style="color: #FCFDFF;">
                            <div class="row d-flex align-items-center" style="height: 30vh;">
                                <div class="col-lg-8 col-sm-12 px-5">
                                    <h2>Good Day, Secretary of Barangay <?php echo $barangayName ?></h2>
                                    <p class="mb-2">This dashboard page is designed to give you brief and important information about the data in your barangay. This also gives graphical information charts based on your data. If you have any inqueries or help in your accout please contact our support team.</p>
                                    <small class="mb-2"><b>If you encounter any problem,</b> message us at mr.carlvincent.bermundo@gmail.com</small><br>

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
                                            <a class="add1 btn text-capitalize" href="./barangay-schedules.page.php">View schedules today</a>
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
                                        $pendingcountsql = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'complaint'";
                                        $pendingcountstmt = $con->prepare($pendingcountsql);
                                        $pendingcountstmt->execute();
                                        $pendingcount = $pendingcountstmt->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount ?></h5>
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
                                        $pendingcountsql1 = "SELECT * FROM complaint_case WHERE where_to = '$barangayName' AND complaint_type = 'report'";
                                        $pendingcountstmt1 = $con->prepare($pendingcountsql1);
                                        $pendingcountstmt1->execute();
                                        $pendingcount1 = $pendingcountstmt1->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount1 ?></h5>
                                        <small class="card-text">Number of Reports</small>
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
                                        $pendingcountsql2 = "SELECT * FROM rbi WHERE brgy = '$barangayName' AND is_existing = 'yes'";
                                        $pendingcountstmt2 = $con->prepare($pendingcountsql2);
                                        $pendingcountstmt2->execute();
                                        $pendingcount2 = $pendingcountstmt2->rowCount();
                                        ?>
                                        <h5 class="card-text"><?php echo $pendingcount2 ?></h5>
                                        <small class="card-text">Number of Barangay Inhabitants</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {



            //chart bar


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
            $getMeetingss = "SELECT * FROM complaint_case where complaint_type = 'complaint' AND incident_year = '$yeart' AND where_to = '$barangayName'";
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

            const labelsBar = [
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

            const dataBar = {
                labels: labelsBar,
                datasets: [{
                    label: 'Complaints per Month',
                    backgroundColor: 'rgb(17, 21, 128)',
                    hoverBackgroundColor: 'rgb(255,149,68)',
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

            const configBar = {
                type: 'bar',
                data: dataBar,
                options: {
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
                document.getElementById('myChartbar'),
                configBar
            );



            //chart line
            <?php
            $yeart1 = date('Y');
            $jan1 = 0;
            $feb1 = 0;
            $mar1 = 0;
            $apr1 = 0;
            $may1 = 0;
            $june1 = 0;
            $july1 = 0;
            $aug1 = 0;
            $sept1 = 0;
            $oct1 = 0;
            $nov1 = 0;
            $dec1 = 0;
            $getMeetingss1 = "SELECT * FROM complaint_case where complaint_type = 'report' AND incident_year = '$yeart1' AND where_to = '$barangayName'";
            $getMeetingssQ1 = $con->query($getMeetingss1);
            foreach ($getMeetingssQ1 as $row1) {
                $meetingMonth1 = $row1['incident_month'];

                switch ($meetingMonth1) {
                    case "January":
                        $jan1 += 1;
                        break;
                    case "February":
                        $feb1 += 1;
                        break;
                    case "March":
                        $mar1 += 1;
                        break;
                    case "April":
                        $apr1 += 1;
                        break;
                    case "May":
                        $may1 += 1;
                        break;
                    case "June":
                        $june1 += 1;
                        break;
                    case "July":
                        $july1 += 1;
                        break;
                    case "August":
                        $aug1 += 1;
                        break;
                    case "September":
                        $sept1 += 1;
                        break;
                    case "October":
                        $oct1 += 1;
                        break;
                    case "November":
                        $nov1 += 1;
                        break;
                    case "December":
                        $dec1 += 1;
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
                    label: 'Reports per Month',
                    backgroundColor: 'rgb(255,149,68)',
                    hoverBackgroundColor: 'rgb(255,149,68)',
                    borderColor: 'rgb(17, 21, 128)',
                    data: [
                        <?php echo (int)$jan1; ?>,
                        <?php echo (int)$feb1; ?>,
                        <?php echo (int)$mar1; ?>,
                        <?php echo (int)$apr1; ?>,
                        <?php echo (int)$may1; ?>,
                        <?php echo (int)$june1; ?>,
                        <?php echo (int)$july1; ?>,
                        <?php echo (int)$aug1; ?>,
                        <?php echo (int)$sept1; ?>,
                        <?php echo (int)$oct1; ?>,
                        <?php echo (int)$nov1; ?>,
                        <?php echo (int)$dec1; ?>
                    ],
                }]
            };

            const configLine = {
                type: 'line',
                data: dataLine,
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Number of Reports per Month in Year <?php echo $yeart ?>',
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
            $getGender = "SELECT * FROM rbi where is_existing = 'yes' AND brgy = '$barangayName'";
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
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Male and Female Inhabitants',
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