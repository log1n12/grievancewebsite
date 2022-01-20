<?php
session_start();
require_once 'database/config.php';
$confirm = "no";
$message = "";

if (isset($_POST['addfeedbackbtn'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['emailadd'];
    $mesg = $_POST['mesg'];

    $addContactUs = "INSERT INTO contactus (first_name, last_name, user_email, user_message, is_read) VALUES ('$fname','$lname','$email','$mesg', '0')";
    if ($con->exec($addContactUs)) {

        $notifTitle = "Feedback Added";
        $notifMesg = "Feedback was added to the contact us table. The sender name is: " . "$fname $lname";
        $notifTo = "DILG";
        $notifToType = "Barangay Secretary";
        $notifFrom = "0";

        require './get-notif.php';
        $message = "Thank you for leaving us a comment. We are going to review it as soon as possible.";
        $confirm = 'yes';
    } else {
        $message = "Your feedback was not successfully sent. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- External CSS -->
    <link rel="stylesheet" type="text/css" href="../css/main-contact.style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">

</head>

<body>
    <?php include './navbar/main.navbar.php' ?>
    <section id="topBanner">
        <div class="container banner" data-aos="zoom-out" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <h2 class="st section-title-heading text-uppercase">Contact Us</h2>
                    <h3 class="text-uppercase">Keeping <span class="accent">us</span> Close</h3>
                    <p class="text-capitalize">Leave your queries and comments here.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <div class="sec-title text-center">
                <h2 class="st section-title-heading text-uppercase">DILG Contact Information</h2>
                <h3 class="text-uppercase mt-3" data-aos-offset="200" data-aos="fade-up" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">Ano nga ba ang aming contact information?</h3>
                <p class="mt-3" data-aos-offset="200" data-aos="fade-up" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true"> Upang maiwasan ang panloloko gamit ang aming pangalan, makipagunayan lamang samin gamit ang website, e-mail address, at sa address na nakalagay sa ibaba. Wag magpalinlang sa iba na hindi nakalagay sa ibaba upang maiwasan ang mga scam.</p>

            </div>
            <div class="row justify-content-center text-center about" data-aos-offset="200" data-aos="zoom-out" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                <div class="col-md-4 spabout" style="background-color:#2D313A ;">
                    <i class="fas fa-desktop fa-3x mb-4"></i>
                    <h3 class="ttitle">Website</h3>
                    <p class="mx-5">www.fouthlaguna.gov.ph</p>
                </div>
                <div class="col-md-4 spabout" style="background-color: #3c414A;">
                    <i class=" fas fa-paper-plane fa-3x mb-4"></i>
                    <h3 class="ttitle">E-Mail</h3>
                    <p class="mx-5">mr.carlvincent.bermundo@gmail.com<br> b.carlvincent@yahoo.com<br>crlv.brmndo@gmail.com</p>
                </div>
                <div class="col-md-4 spabout" style="background-color: #4f545c;">
                    <i class=" fas fa-map-marker-alt fa-3x mb-4"></i>
                    <h3 class="ttitle">Address</h3>
                    <p class="mx-5">Crisostomo St. Brgy. Poblacion Uno, Pagsanjan, Laguna. PH</p>
                </div>

            </div>
        </div>
    </section>
    <section id="meg" class="mt-5">
        <div class="navss">
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 text-center">
                        <h2 data-aos-offset="200" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">Kung ikaw ay may mga tanong, comment, suggestion, at may gustong sabihin tungkol sa amin, sagutan ang form sa ibaba. Ang iyong opinyon ay mahalaga.</h2>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
        <div class="formm mb-5" data-aos-offset="200" data-aos="fade-down" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
            <form method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="form-floating mb-3">

                                <input type="text" class="form-control transparent" id="floatingFname" name="fname" required>
                                <label for="floatingFname">First Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control transparent" id="floatingLname" name="lname" required>
                                <label for="floatingLname">Last Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control transparent" id="floatingEmail" name="emailadd" required>
                                <label for="floatingEmail">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control transparent" name="mesg" id="floatingMesg" style="height: 100px" required></textarea>
                                <label for="floatingMesg">Message/Feedback/Comment</label>
                            </div>
                            <button type="submit" name="addfeedbackbtn" class="btn btn-dark btn-block btnn">Send Message</button>
                        </div>
                        <div class="col-md-2"></div>

                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php include './navbar/main.footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script type="text/javascript">
        $(window).scroll(function() {
            $('nav').toggleClass('scrolled', $(this).scrollTop() > 50);
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
    <script type="text/javascript">
        $(document).ready(function() {
            <?php
            if ($message != "") {
                if ($confirm == "yes") {


            ?>
                    Swal.fire({

                            title: 'Feedback Submitted',
                            icon: 'success',
                            html: '<?php echo $message ?>'
                        }

                    )
                <?php
                } else {
                ?>
                    Swal.fire(
                        'Complaint Failed',
                        '<?php echo $message; ?>',
                        'error'
                    )
            <?php
                }
            }
            ?>
        });
    </script>
</body>

</html>