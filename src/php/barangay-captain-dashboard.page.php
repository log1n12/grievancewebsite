<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-captain.check.php';
$titleHeader = "Dashboard";
$message = "";


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
    <link rel="stylesheet" type="text/css" href="../css/barangay-admin.style.css">
    <title>Document</title>
</head>



<body>
    <?php include './navbar/barangay-captain.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/barangay-captain.navbar-top.php' ?>
        <div class="transition px-4">

            <div class="row ttop">
                <div class="col-lg-9 col-sm-12">
                    <section id="topBanner" class="mt-0 mb-4">
                        <div style="color: #FCFDFF;">
                            <div class="row d-flex align-items-center" style="height: 30vh;">
                                <div class="col-lg-8 col-sm-12 px-5">
                                    <h2>Good Day, Barangay Captain of Barangay <?php echo $barangayName ?></h2>
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
                                            <a class="add1 btn text-capitalize" href="./barangay-captain-schedule.page.php">View schedules today</a>
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
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-clinic-medical fa-2x mr-3 icon1"></i></div>
                                    <div class="col-sm-8 text-right">


                                        <?php
                                        //get all meeting with month same with month today
                                        //get ref number
                                        //check ref number to complaintcase table
                                        //check if the barangay is same with the barangayName
                                        //if same, +1
                                        date_default_timezone_set("Asia/Manila");
                                        $counta = 0;
                                        $monthToday = date("m");
                                        $meetingGet = "SELECT * FROM meeting WHERE mont = '$monthToday'";
                                        $meetingGetQ = $con->query($meetingGet);
                                        foreach ($meetingGetQ as $row) {
                                            $cR = $row['case_ref_no'];

                                            $getCompCase = "SELECT * FROM complaint_case WHERE case_ref_no = '$cR'";
                                            $getCompCaseQ = $con->query($getCompCase);
                                            foreach ($getCompCaseQ as $roww) {
                                                $wT = $roww['where_to'];

                                                if ($wT == $barangayName) {
                                                    $counta += 1;
                                                }
                                            }
                                        }

                                        ?>
                                        <h5 class="card-text"><?php echo $counta ?></h5>
                                        <small class="card-text">Meeting for this month</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <small>Reports to be approved</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-signature fa-2x mr-3 icon3"></i></div>
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
                </div>
            </section>

            <section>
                <div class="row">
                    <div class="col-lg-12">
                        <canvas id="myChartbar" class="p-4" style="background-color: white;"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <script type="text/javascript">
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });
        });
    </script>

    <script type="text/javascript">
        //calendar
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
        // === include 'setup' then 'config' above ===
        $(document).ready(function() {

            <?php
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
            $getMeetingss = "SELECT * FROM meeting";
            $getMeetingssQ = $con->query($getMeetingss);
            foreach ($getMeetingssQ as $row) {
                $meetingMonth = $row['mont'];
                $compRefNo = $row['case_ref_no'];
                $checkBrgy = "SELECT * FROM complaint_case WHERE case_ref_no = '$compRefNo'";
                $checkBrgyQue = $con->query($checkBrgy);

                foreach ($checkBrgyQue as $row1) {
                    //get brgy
                    $brgy = $row1['where_to'];
                    if ($brgy == $barangayName) {
                        switch ($meetingMonth) {
                            case "01":
                                $jan += 1;
                                break;
                            case "02":
                                $feb += 1;
                                break;
                            case "03":
                                $mar += 1;
                                break;
                            case "04":
                                $apr += 1;
                                break;
                            case "05":
                                $may += 1;
                                break;
                            case "06":
                                $june += 1;
                                break;
                            case "07":
                                $july += 1;
                                break;
                            case "08":
                                $aug += 1;
                                break;
                            case "09":
                                $sept += 1;
                                break;
                            case "10":
                                $oct += 1;
                                break;
                            case "11":
                                $nov += 1;
                                break;
                            case "12":
                                $dec += 1;
                                break;
                        }
                    }
                }
            }



            ?>

            const labels = [
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
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Meeting Count',
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

            const config1 = {
                type: 'bar',
                data: data,
                options: {}
            };
            const myChartbar = new Chart(
                document.getElementById('myChartbar'),
                config1
            );
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