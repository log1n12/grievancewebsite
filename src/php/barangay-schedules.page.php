<?php
session_start();
require_once './database/config.php';
require_once './database/barangay-admin.check.php';
$titleHeader = "Schedules";
$getAllmeeting = "";

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css" integrity="sha256-FjyLCG3re1j4KofUTQQXmaWJw13Jdb7LQvXlkFxTDJI=" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/barangay-admin.style.css">

    <style>
        .navbar {
            -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        }
    </style>

    <title>Document</title>
</head>

<body>
    <?php include './navbar/barangay.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/barangay.navbar-top.php' ?>
        <div class="transition px-4">


            <section id="table-section">
                <div id="tableNavbar" class="mx-4 mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>Upcoming Case Schedules</h1>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        var calendar = $('#calendar').fullCalendar();
                    });
                </script>

                <div id="tableContent" class="px-4 mb-4 py-4">
                    <div class=" row">
                        <div class="col-md-12 align-self-center">
                            <div id="calendar" class="my-3"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Modal for completing the meeting (ONGOING TABLE) -->
            <div class="modal fade bd-example-modal-lg" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content p-4">
                        <div class="modal-header">
                            <div>
                                <h4 class="modal-title" id="myModalLabel">Meeting Information</h4>
                                <p><span style="font-size: 13px; font-weight: 300;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, aspernatur odit<span></p>
                            </div>


                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body mx-5">
                            <h5 class="text-capitalize text-center"><i class="fas fa-info-circle fa-2x mr-2" style=" color: #111580;"></i>Brief information</h5>
                            <hr>
                            <p class="font-weight-bold mt-3 mb-1"><span id="calendarMeeting"></span></p>
                            <p class="mb-1"><span class="font-weight-bold">Reference Number:</span> <span id="calendarRefNo"></span></p>
                            <p class="font-weight-bold mb-1">Date: <span id="calendarDate" class="font-weight-light"></span></p>
                            <p class="font-weight-bold mb-1">Time: <span id="calendarTime" class="font-weight-light"></span></p>
                            <div class="complaintDiv mt-4">
                                <h6 class="font-weight-bolder mb-4">Complaint Case Information</h6>
                                <h6><span class="font-weight-bold">Complainant: </span><span id="calendarComplainant">ASDASDASDSADASDSA</span></h6>
                                <h6><span class="font-weight-bold">Defendant: </span><span id="calendarDefendant">ASDASDASDAS</span></h6>
                                <h6><span class="font-weight-bold">Complaint: </span><span id="calendarComplaint">ZXCZXCZXCZXCZXCZXCZXC</span></h6>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btnAccept" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js" integrity="sha256-8nl2O4lMNahIAmUnxZprMxJIBiPv+SzhMuYwEuinVM0=" crossorigin="anonymous"></script>



    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'listDay',
                headerToolbar: {
                    left: 'prev,today,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listDay',
                },
                bootstrapFontAwesome: {
                    prev: 'fas fa-caret-left fa-1x',
                    next: 'fas fa-caret-right fa-1x'

                },
                themeSystem: 'bootstrap',
                nowIndicator: true,
                aspectRatio: 2,
                contentHeight: "auto",
                expandRows: true,
                dayMaxEvents: true, // allow "more" link when too many events
                moreLinkContent: function(args) {
                    return '+' + args.num + ' More Meetings';
                },
                navLinks: true,
                eventBackgroundColor: "orange",
                eventBorderColor: "orange",
                noEventsContent: "No upcoming meetings to display",
                eventDisplay: "block",
                timeZone: 'Asia/Manila',

                eventSources: [{
                    url: './get-meeting.php',
                    method: 'POST',
                    extraParams: {
                        brgy: '<?php echo $barangayName ?>'
                    },
                    failure: function() {
                        alert('there was an error while fetching events!');
                    }
                }],
                eventClick: function(info) {
                    $('#calendarModal').modal('show');
                    $('#calendarTitle').text("Schedule for meeting");
                    $('#calendarMeeting').text(info.event.extendedProps.meeting);
                    $('#calendarRefNo').text(info.event.extendedProps.refNo);
                    $('#calendarDate').text(info.event.extendedProps.datee);
                    $('#calendarTime').text(info.event.extendedProps.timee);

                    //Modal Body
                    $('#calendarComplainant').text(info.event.extendedProps.complainant);
                    $('#calendarDefendant').text(info.event.extendedProps.defendant);
                    $('#calendarComplaint').text(info.event.extendedProps.complaint);


                    // change the border color just for fun
                    info.el.style.borderColor = 'red';
                }


            });
            calendar.render();
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