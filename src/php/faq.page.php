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
    <link rel="stylesheet" type="text/css" href="../css/main-services.style.css">
</head>

<body>
    <?php include './navbar/main.navbar.php' ?>
    <section id="topBanner">
        <div class="container banner" data-aos="zoom-out" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <h2 class="st section-title-heading text-uppercase">FAQs</h2>
                    <h3 class="text-uppercase">Have any <span class="accent">question?</span></h3>
                    <p class="text-capitalize">Get the answer for the most asked questions here.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="servContent">
        <div class="container">
            <div class="sec-title text-center">
                <h2 class="st section-title-heading text-uppercase">Faq</h2>
                <h3 class="text-uppercase mt-3" data-aos-offset="200" data-aos="fade-up" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">Frequently Asked Questions</h3>
                <p class="mt-3" data-aos-offset="200" data-aos="fade-up" data-aos-duration="1400" data-aos-easing="ease-in-out" data-aos-once="true"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto cumque id quod harum dicta laboriosam illum quo odit veniam dolorum fugit temporibus at earum nostrum, assumenda quia reiciendis corrupti libero! </p>
            </div>
            <div class="row justify-content-center text-center about" data-aos-offset="200" data-aos="zoom-out" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                <div class="accordion" id="accordionExample">

                    <?php
                    $getFaq = "SELECT * FROM faq where is_existing = 'yes'";
                    $getFaqQ = $con->query($getFaq);
                    $idArr = array();
                    foreach ($getFaqQ as $row) {
                        $faqid = $row['id'];
                        $quest = $row['quest'];
                        $answer = $row['answer'];
                        array_push($idArr, $faqid);

                        $minId = min($idArr);

                    ?>
                        <div class="card">
                            <div class="card-header" id="heading<?php echo $faqid ?>">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-capitalize" style="color: #BF8C20;" type="button" data-toggle="collapse" data-target="#collapse<?php echo $faqid ?>" aria-expanded="true" aria-controls="collapseOne">
                                        <?php echo $quest ?>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse<?php echo $faqid ?>" class="collapse <?php if ($faqid == $minId) {
                                                                                        echo "show";
                                                                                    } ?>" aria-labelledby="heading<?php echo $faqid ?>" data-parent="#accordionExample">
                                <div class="card-body">
                                    <b>Answer:</b> <?php echo $answer ?>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
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