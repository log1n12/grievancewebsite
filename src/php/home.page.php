<?php
session_start();
require_once 'database/config.php';

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
    <link rel="stylesheet" type="text/css" href="../css/main.style.css">
</head>

<body>
    <?php include './navbar/main.navbar.php' ?>
    <section id="topBanner">
        <div class="container banner" data-aos-offset="400" data-aos="zoom-out" data-aos-duration="1000" data-aos-once="true">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <p class="text-capitalize font-italic">Sumbong mo, Aksyon ko.</p>
                    <h2 class="text-uppercase">Huwag matakot <span class="accent"> magsumbong</span> </h2>
                    <p class="">Pindutin ang dropdown at mamili kung anong serbisyo ang iyong nais gawin o puntahan.</p>
                    <div class="d-md-flex d-sm-inline-flex flex-row justify-content-center chooseSelect">
                        <div class="row">
                            <div class="col-md-3 align-self-center">
                                <h5 class="m-0 p-0 text-white">
                                    Paano ba ako...
                                </h5>
                            </div>
                            <div class="col-md-9 align-self-center">
                                <select class="form-select form-select-lg m-0" id="serviceSelect" aria-label=".form-select-lg example">
                                    <option value="" selected>mamili ng isa sa mga sumusunod</option>
                                    <option value="./service-complaint.page.php">makakapag hain ng complaint</option>
                                    <option value="./service-report.page.php">makakapag hain ng blotter report</option>
                                    <option value="./service-rbi.page.php">makakapag request na mapasama sa RBI ng aming barangay</option>
                                    <option value="./service-status.page.php">makakapag check ng status ng aking complaint o blotter report</option>
                                    <option value="./contact-us.page.php">makakapag iwan ng comment o feedback</option>
                                </select>

                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <div class="sec-title text-center" data-aos="fade-up" data-aos-duration="500" data-aos-easing="ease-in-out" data-aos-once="true">
                <h2 class="st section-title-heading text-uppercase">Serbisyo ng e-habla </h2>
                <h1 class="text-uppercase mt-3">Nakikinig kami sa inyong mga sumbong</h1>
                <p class="mt-3">Itong ang mga sumusunod na serbisyo ng E-Habla. Sa pamamagitan ng aming website kayang makapag hain ng complaint, blotter report, at makapag request na mapasama sa RBI ng kanilang barangay ang mga residente ng magdalena.</p>
            </div>
            <div class="row justify-content-center text-center about" data-aos="fade-up" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                <div class="col-md-4 spabout">
                    <i class="fas fa-user-edit fa-3x mb-4"></i>
                    <h3>Complaint</h3>
                    <p class="mx-5">Ang complaint ay isang pormal na paghahain o pagsasampa ng reklamo sa barangay kung saan ito ay dadaan sa pormal na prosesong alinsunod sa Katarungang Pambarangay na pamamahalaan ng Punong Barangay o Lupong Tagapamayapa.</p>
                    <a class="btn btn-dark px-5 mt-3 submit" href="./service-complaint.page.php">Complaint Now <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                </div>
                <div class="col-md-4 spabout">
                    <i class="fas fa-sticky-note fa-3x mb-4"></i>
                    <h3>Blotter Report</h3>
                    <p class="mx-5">Ang barangay blotter o blotter report ay ang pag-uulat o pagtatala sa barangay ng isang gawain o aktibidades na may kinalaman sa isang krimen o insidente at hindi ito ang mismong complaint o reklamo na pagmumulan ng kaso.</p>
                    <a class="btn btn-dark px-5 mt-3 submit" href="./service-report.page.php">Report Now <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                </div>
                <div class="col-md-4 spabout">
                    <i class="fas fa-users fa-3x mb-4"></i>
                    <h3>Request sa RBI </h3>
                    <p class="mx-5">Ang Registry of Barangay Inhabitants o mas kilala sa RBI ay ang tala ng mga residente ng Magdalena. Ang serbisyong ito ay ang pagrerequest ng mga residente sa Magdalena na hindi pa kabilang sa RBI o Registry of Barangay Inhabitants.</p>
                    <a class="btn btn-dark px-5 mt-3 submit" href="./service-rbi.page.php">Register Now<span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                </div>
            </div>
        </div>
    </section>
    <section id="videopage">
        <div class="vid-cont">
            <video class="vid" autoplay loop playsinline muted>
                <source src="../assets/magdalena.mp4" type="video/mp4" />
            </video>
            <div class="overlay-desc" data-aos-offset="400" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                <div class="sec-title text-center container">
                    <h2 class="st section-title-heading text-uppercase">Contact Us</h2>
                    <h1 class="text-uppercase mt-3">Mahalaga ang iyong opinyon</h1>
                    <p class="mt-3"> Magiwan ng comment, opinion o feedback upang kami ay matulungan. Maaring sabihin ang iyong mga naranasan o naexperience habang ginagamit ang aming website upang malaman namin kung ano pa ang maaari naming mabago. Pindutin lamang ang button sa ibaba.</p>
                </div>
                <a href="./contact-us.page.php" class="btn btn-dark px-5 submit mt-5">Contact Us <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
            </div>
        </div>
    </section>

    <section id="fourthpage">
        <div class="container-fluid">
            <div class="row secondrow">
                <div class="col-md-6 align-self-center text-center pic">
                    <img src="../assets/wawa.png" class="sppic" data-aos-offset="400" data-aos="zoom-in" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                </div>
                <div class="col-md-6 align-self-center spcontent sec-title" data-aos-offset="400" data-aos="fade-down" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                    <h2 class="st section-title-heading text-uppercase">Ano ba ang e-habla?</h2>
                    <h1 class="text-uppercase mt-3">Layunin ng e-Habla</h1>
                    <p class="mt-3">Ang e-Habla ay naglalayong magbigay sa mga residente ng isang alternatibo at mabilis na paraan ng paghahain ng reklamo o blotter sa barangay at makatulong na mapabilis ang ibang proseso sa Katarungang Pambarangay.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="locationlog">
        <div class="container">
            <div class="cl-content text-center sec-title" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-offset="400" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                <h2 class="st section-title-heading text-uppercase">Barangay sa magdalena</h2>
                <h1 class="text-uppercase mt-3">Barangay na sakop ng E-habla</h1>
                <p class="mt-3"><?php

                                $barangayQuery = "SELECT DISTINCT barangay FROM account WHERE barangay != 'DILG' ORDER BY barangay";
                                $barangayStmt = $con->query($barangayQuery);
                                foreach ($barangayStmt as $row) {
                                    $barangayRow = $row['barangay'];
                                    echo "<span>$barangayRow. </span>";
                                }
                                ?> </p>

            </div>
        </div>
    </section>

    <section id="fifthpage">
        <div class="row scrollp">
            <div class="col-md-6 fpleft sec-title ">
                <div class="text-right" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                    <h2 class="st section-title-heading text-uppercase">About Us</h2>
                    <h1 class="text-uppercase mt-3">Sino nga ba kami?</h1>
                    <p class="mt-3"> Kilalanin ang mga tao at departmento na kabilang sa e-Habla. Alamin ang mga impormasyon tungkol sa Magdalena, DILG, at sa mga barangay ng Magdalena.</p>

                </div>

            </div>
            <div class="col-md-6 fpright">

                <div class="fp fprightc1 text-center sec-title1" style="background-image: linear-gradient(to left, rgba(0, 0, 0, 0.2), rgba(45,49,58,1)),url('../assets/yeye.jpg');
					background-size: cover;
					background-repeat: no-repeat;
					background-position: center center;">
                    <div>
                        <h2 class="st section-title-heading text-uppercase">Who are we?</h2>
                        <h1 class="text-uppercase mt-0">magdalena</h1>
                        <p class="mt-1"> Alamin ang mga history at iba pang impormasyon na may kinalaman sa bayan ng Magdalena, Laguna. </p>
                        <a href="./about.page.php" class="btn btn-dark submit px-4 py-2 text-uppercase mt-3">View Magdalena <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                    </div>
                </div>
                <div class="fp fprightc1 text-center sec-title1" style="background-image: linear-gradient(to left, rgba(0, 0, 0, 0.2), rgba(45,49,58,1)),url('../assets/yeye.jpg');
					background-size: cover;
					background-repeat: no-repeat;
					background-position: center center;">
                    <div>
                        <h2 class="st section-title-heading text-uppercase">Who are we?</h2>
                        <h1 class="text-uppercase mt-0">DILG</h1>
                        <p class="mt-1"> Alamin ang mga layunin, kung paano na itatag at iba pang impormasyon tungkol sa DILG. </p>

                        <a href="./about-dilg.page.php" class="btn btn-dark submit px-4 py-2 text-uppercase mt-3">View DILG <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                    </div>
                </div>
                <div class="fp fprightc1 text-center sec-title1" style="background-image: linear-gradient(to left, rgba(0, 0, 0, 0.2), rgba(45,49,58,1)),url('../assets/yeye.jpg');
					background-size: cover;
					background-repeat: no-repeat;
					background-position: center center;">
                    <div>
                        <h2 class="st section-title-heading text-uppercase">Who are we?</h2>
                        <h1 class="text-uppercase mt-0">BARANGAY</h1>
                        <p class="mt-1"> Dito sa sekyon na ito ay makikita ang mga barangay na kabilang sa bayan ng Magdalena, Laguna. </p>

                        <a href="./about-brgy.page.php" class="btn btn-dark submit px-4 py-2 text-uppercase mt-3">View Barangay <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="sixthpage" class="py-5">
        <div class="container">
            <div class="sec-title text-center container" data-aos="fade-down" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                <h2 class="st section-title-heading text-uppercase">Paano ba?</h2>
                <h1 class="text-uppercase mt-3">Steps para makapag hain ng complaint</h1>
                <p class="mt-3"> Ito ang mga hakbang para makapag hain ng complaint gamit ang aming website. Sundin lamang ang mga sumusunod upang matagumpay na makapag complaint.</p>
            </div>

            <div class="row sxp-cont" data-aos-offset="300" data-aos="fade-up" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                <div class="col-md-6">
                    <div class="feature-block">
                        <div class="steps">
                            <h3 class="ca text-center wdown">1</h3>
                            <h3 class="ca text-center text-uppercase wup"><span style="color: #FDB81D;">Step </span> 1</h3>
                        </div>
                        <p class="mx-5">Maghain ng complaint gamit ang aming website. Siguraduhing tama ang mga impormasyon.</p>
                    </div>
                    <div class="feature-block my-5 pt-5">
                        <div class="steps">
                            <h3 class="ca text-center wdown">2</h3>
                            <h3 class="ca text-center text-uppercase wup"><span style="color: #FDB81D;">Step</span> 2</h3>
                        </div>
                        <p class="mx-5">Maghintay ng text na manggagaling sa secretary ng barangay na nagsasabi kung tinanggap o hindi.</p>
                    </div>
                </div>
                <div class="col-md-6 secondBlock">
                    <div class="feature-block">
                        <div class="steps">
                            <h3 class="ca text-center wdown">3</h3>
                            <h3 class="ca text-center text-uppercase wup"><span style="color: #FDB81D;">Step</span> 3</h3>
                        </div>
                        <p class="mx-5">Kung tinanggap ano iyong complaint, magtungo sa barangay upang bayaran ang complaint fee.</p>
                    </div>
                    <div class="feature-block mt-5 pt-5">
                        <div class="steps">
                            <h3 class="ca text-center wdown">4</h3>
                            <h3 class="ca text-center text-uppercase wup"><span style="color: #FDB81D;">Step</span> 4</h3>
                        </div>
                        <p class="mx-5">Hintayin ang text at document na kailangan para sa proceedings.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

    <script>
        $(function() {
            // bind change event to select
            $('#serviceSelect').on('change', function() {
                var url = $(this).val(); // get selected value
                if (url) { // require a URL
                    window.location = url; // redirect
                }
                return false;
            });
        });
    </script>
</body>

</html>