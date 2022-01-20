<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    <?php include './navbar/main.navbar.php' ?>
    <section id="topBanner">
        <div class="container banner" data-aos="zoom-out" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <h2 class="st section-title-heading text-uppercase">Services</h2>
                    <h3 class="text-uppercase">Submong mo, <span class="accent">Aksyon</span> ko </h3>
                    <p class="text-capitalize">File your complaints and reports here.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="servContent">
        <div class="container">
            <div class="sec-title text-center">
                <h2 class="st section-title-heading text-uppercase">What we offer?</h2>
                <h3 class="text-uppercase mt-3" data-aos-offset="200" data-aos="fade-up" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">MGa Serbisyo ng E-Habla</h3>
                <p class="mt-3" data-aos-offset="200" data-aos="fade-up" data-aos-duration="1400" data-aos-easing="ease-in-out" data-aos-once="true">Mamili kung anong serbisyo ang iyong kailangan at pindutin ang button na nakapaloob sa box. Pagkatapos ay may lalabas at pindutin ang "oo" kung ikaw ay residente sa Magdalena na nakalista sa RBI at "Hindi" naman kung ikaw ay taga labas o wala sa RBI.</p>
                <a href="./service-status.page.php" class="clickHere" data-aos-offset="200" data-aos="fade-up" data-aos-duration="1800" data-aos-easing="ease-in-out" data-aos-once="true">Gusto mo bang i-check ang status ng iyong sumbong? Pindutin lamang ito.</a>
            </div>
            <div class="row justify-content-center text-center about" data-aos-offset="200" data-aos="zoom-out" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                <div class="col-md-4 spabout" style="background-color: #2D313A;">
                    <i class=" fas fa-paper-plane fa-3x mb-4 fafafa"></i>
                    <h3>Complaint</h3>
                    <p class="mx-5">Ang complaint ay isang pormal na paghahain o pagsasampa ng reklamo sa barangay kung saan ito ay dadaan sa pormal na prosesong alinsunod sa Katarungang Pambarangay na pamamahalaan ng Punong Barangay</p>
                    <a data-toggle="modal" data-target="#goToComplaint" type="button" class="btn btn-dark px-5 mt-3 submit"> Complaint <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span> </a>
                </div>
                <div class="col-md-4 spabout" style="background-color: #3c414A;">
                    <i class=" fas fa-paper-plane fa-3x mb-4 fafafa"></i>
                    <h3>Blotter Report</h3>
                    <p class="mx-5">Ang barangay blotter o blotter report ay ang pag-uulat o pagtatala sa barangay ng isang gawain o aktibidades na may kinalaman sa isang krimen o insidente at hindi ito ang mismong complaint o reklamo na pagmumulan ng kaso.</p>
                    <a data-toggle="modal" data-target="#goToReport" type="button" class="btn btn-dark px-5 mt-3 submit"> Report <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                </div>
                <div class="col-md-4 spabout" style="background-color: #4f545c;">
                    <i class=" fas fa-paper-plane fa-3x mb-4 fafafa"></i>
                    <h3>RBI</h3>
                    <p class="mx-5">Ang Registry of Barangay Inhabitants o mas kilala sa RBI ay ang tala ng mga residente ng Magdalena. Ang serbisyong ito ay ang pagrerequest ng mga residente sa Magdalena na hindi pa kabilang sa RBI o Registry of Barangay Inhabitants.</p>
                    <a href="./service-rbi.page.php" class="btn btn-dark px-5 mt-3 submit"> Register <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                </div>


            </div>


        </div>
    </section>

    <div class="modal fade " id="goToComplaint" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content px-4 py-4">
                <div class="modal-body mb-0 pb-0">
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="text-center">
                        <i class="fas fa-question-circle fa-5x mb-4" style=" color: #BF8C20;"></i>
                        <h3>Residente sa Magdalena?</h3>
                        <p class="text-muted mt-3">Kung ikaw ay nakalista sa RBI piliin ang "Yes", kung ikaw naman ay outsider o di pa nakalista sa RBI, piliin ang "No"</p>
                    </div>

                </div>
                <div class="modal-footer mt-0 pt-0">
                    <div class="col-md-12 text-center">
                        <a href="service-complaint.page.php" class="btn text-capitalize btn-dark  text-center px-5 py-2">Yes</a>

                        <a href="service-complaint-out.page.php" class="btn text-capitalize px-5 py-2">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="goToReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content px-4 py-4">
                <div class="modal-body mb-0 pb-0">
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="text-center">
                        <i class="fas fa-question-circle fa-5x mb-4" style=" color: #BF8C20;"></i>
                        <h3>Residente sa Magdalena?</h3>
                        <p class="text-muted mt-3">Kung ikaw ay nakalista sa RBI piliin ang "Yes", kung ikaw naman ay outsider o di pa nakalista sa RBI, piliin ang "No"</p>
                    </div>

                </div>
                <div class="modal-footer mt-0 pt-0">
                    <div class="col-md-12 text-center">
                        <a href="service-report.page.php" class="btn btn-dark text-capitalize text-center px-5 py-2">Yes</a>

                        <a href="service-report-out.page.php" class="btn  text-capitalize px-5 py-2">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include './navbar/main.footer.php' ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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


</body>

</html>