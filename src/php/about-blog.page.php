<?php
$titleheader = "About";
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
    <link rel="stylesheet" type="text/css" href="../css/main-about.style.css">
</head>

<body>
    <?php include './navbar/main.navbar.php' ?>
    <section id="topBanner">
        <div class="container banner" data-aos="zoom-out" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <h2 class="st section-title-heading text-uppercase">About </h2>
                    <<h3 class="text-uppercase">Alamin kung <span class="accent">Sino</span> kami </h3>
                        <p class="text-capitalize">Know basic information everything about our website.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sideNavbar text-center" data-aos-offset="400" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                    <h5 class="text-uppercase mb-3">
                        Information Menu
                    </h5>
                    <a href="about.page.php" class="btn btn-lg btn-block text-capitalize">Magdalena <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                    <a href="about-dilg.page.php" class="btn btn-lg btn-block text-capitalize">DILG <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                    <a href="about-brgy.page.php" class="btn btn-lg btn-block text-capitalize">Barangay <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                    <a href="about-blog.page.php" class="btn btn-lg btn-block text-capitalize">Blog <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                    <a href="about-gallery.page.php" class="btn btn-lg btn-block text-capitalize">Gallery <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                </div>
                <div class="col-md-9 aboutContent p-5" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in" data-aos-once="true">
                    <h2 class="text-center font-italic">
                        <span class="accent text-uppercase">Magdalena</span> blog
                    </h2>
                    <!-- Section description -->
                    <p class="text-center w-responsive mx-auto mb-5">Alamin ang mga nangyayari sa Magdalena. Ang mga sumusunod ay ang mga blog o news tungkol sa mga event o pagpupulong na may kinalaman o kaugnay ang DILG. Lamang ang may alam.</p>
                    <div class="row">
                        <div class="col-md-12 startContent mt-4">
                            <section class="my-5">
                                <?php
                                $getArt = "SELECT * FROM article where d_existing = 'yes' ORDER BY id DESC";
                                $getArtQue = $con->prepare($getArt);
                                $getArtQue->execute();
                                $result = $getArtQue->rowCount();

                                $i = 0;
                                $getArtStmt = $con->query($getArt);
                                foreach ($getArtStmt as $row) {
                                    $aId = $row['id'];
                                    $aTitle = $row['d_title'];
                                    $aMesg = $row['d_message'];
                                    $aDate = $row['d_datesubmit'];
                                    $aPic = $row['d_pic'];
                                    $aFrom = $row['d_from'];



                                ?>

                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class=" view overlay rounded z-depth-2 mb-lg-0 mb-4">
                                                <img class="img-fluid" src="../assets/article/<?php
                                                                                                if ($aPic != "--") {
                                                                                                    echo $aPic;
                                                                                                } else {
                                                                                                    echo "nopic.png";
                                                                                                }
                                                                                                ?>" alt="Sample image">
                                            </div>
                                        </div>

                                        <div class="col-lg-7">

                                            <!-- Post title -->
                                            <h3 class="font-weight-bold mb-3"><strong><?php echo $aTitle ?></strong></h3>
                                            <!-- Excerpt -->
                                            <p><?php echo $aMesg ?></p>
                                            <!-- Post data -->
                                            <p>by <a><span style="color: #BF8C20"><strong><?php
                                                                                            $getInfo = "SELECT * FROM account where id = '$aFrom'";
                                                                                            $getInfoQue = $con->query($getInfo);
                                                                                            foreach ($getInfoQue as $row1) {
                                                                                                $fname = $row1['sec_lname'] . ", " . $row1['sec_fname'] . " " . $row1['sec_mname'];
                                                                                            }
                                                                                            echo $fname;
                                                                                            ?></strong></span></a>, <?php echo $aDate ?></p>

                                        </div>

                                    </div>


                                <?php
                                    if ($i != $result - 1) {
                                        echo '<hr class="my-5">';
                                    }
                                    $i++;
                                }
                                ?>
                            </section>
                            <!-- Section: Blog v.1 -->
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

</body>

</html>