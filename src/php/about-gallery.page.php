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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css" />

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
                    <h3 class="text-uppercase">Alamin kung <span class="accent">Sino</span> kami </h3>
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
                        dilg <span class="accent text-uppercase">Gallery</span>
                    </h2>
                    <p class="text-center w-responsive mx-auto mb-5">Tignan ang mga litrato mula sa DILG. Ang seksyon na ito ay para maihandog at maipakita ang mga litrato na kuha sa event o pagpupulong na may kaugnay sa DILG. Ipakita ang ganda ng Magdalena.</p>
                    <div class="row">
                        <div class="col-md-12 startContent mt-3 gallery-block cards-gallery">
                            <div class="card-columns">
                                <?php
                                $getPic = "SELECT * FROM gallery where img_status = 'yes' ORDER BY id DESC";
                                $getPicQue = $con->query($getPic);
                                foreach ($getPicQue as $row) {
                                    $imgFile = $row['img_file'];
                                    $imgTitle = $row['img_title'];
                                    $imgDescrip = $row['img_descri'];
                                    $imgDate = $row['img_date'];
                                ?>
                                    <div class="card border-0 transform-on-hover mt-2">
                                        <a class="lightbox" href="../assets/gallery/<?php echo $imgFile ?>">
                                            <img src="../assets/gallery/<?php echo $imgFile ?>" alt="Card Image" class="card-img-top">
                                        </a>
                                        <div class="card-body">
                                            <h6 class="mb-0 text-capitalize"><a href="#"><?php echo strtolower($imgTitle); ?></a></h6>
                                            <small class="text-muted mt-0"><?php echo $imgDate ?></small>
                                            <p class="text-muted card-text text-capitalize"><?php echo strtolower($imgDescrip); ?></p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script>
        baguetteBox.run('.cards-gallery', {
            animation: 'slideIn'
        });
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
            var x = document.getElementsByClassName("imgdescri");
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