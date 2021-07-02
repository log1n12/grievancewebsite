<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../css/main-services.style.css">

    <title>Document</title>
</head>

<body>
    <?php include './navbar/main.navbar.php' ?>
    <section id="topBanner">
        <div class="container banner">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <h2 class="st section-title-heading text-uppercase">Services</h2>
                    <h1 class="text-uppercase">Get to <span class="accent">know</span> us </h1>
                    <p class="text-uppercase">Don't waste your time. Be sure where you will go.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="servContent">
        <div class="container">
            <div class="sec-title text-center">
                <h2 class="st section-title-heading text-uppercase">Services of Griv </h2>
                <h1 class="text-uppercase mt-3">We listen to your complaints</h1>
                <p class="mt-3"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto cumque id quod harum dicta laboriosam illum quo odit veniam dolorum fugit temporibus at earum nostrum, assumenda quia reiciendis corrupti libero! </p>
            </div>
            <div class="row justify-content-center text-center about">
                <div class="col-md-4 spabout" style="background-color: #102E51;">
                    <i class="fas fa-desktop fa-3x mb-4"></i>
                    <h3>Complaint</h3>
                    <p class="mx-5">www.fouthlaguna.gov.ph</p>
                    <a href="./service-complaint.page.php" class="btn btn-dark px-5 mt-3 submit"> Complaint <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span> </a>
                </div>
                <div class="col-md-4 spabout" style="background-color: #1F5493;">
                    <i class=" fas fa-paper-plane fa-3x mb-4"></i>
                    <h3>Report</h3>
                    <p class="mx-5">mr.carlvincent.bermundo@gmail.com</p>
                    <a href="./service-report.page.php" class="btn btn-dark px-5 mt-3 submit"> Report <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                </div>
                <div class="col-md-4 spabout" style="background-color: #0371BC;">
                    <i class=" fas fa-paper-plane fa-3x mb-4"></i>
                    <h3>RBI Number</h3>
                    <p class="mx-5">mr.carlvincent.bermundo@gmail.com</p>
                    <a href="./service-report.page.php" class="btn btn-dark px-5 mt-3 submit"> Report <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></a>
                </div>


            </div>


        </div>
    </section>
    <footer class="page-footer font-small blue footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 align-self-center">
                    <h6 class="text-uppercase"><span id="year">
                            <script>
                                document.getElementById('year').appendChild(document.createTextNode(new Date().getFullYear()))
                            </script>
                        </span>BestGroup</h6>
                </div>
                <div class="col-md-4 align-self-center">
                    <h1>Fourth</h1>
                </div>
                <div class="col-md-4 align-self-center">
                    <i class="fab fa-facebook fa-2x"></i>
                    <i class="fab fa-twitter fa-2x"></i>
                    <i class="fab fa-instagram fa-2x"></i>
                </div>
            </div>
        </div>
    </footer>
    <footer class="page-footer font-small text-center footer1">
        <div class="container">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h6 class="text-uppercase"><span id="year1">
                            Copyrights
                            <script>
                                document.getElementById('year1').appendChild(document.createTextNode(new Date().getFullYear()))
                            </script>
                        </span>BestGroup</h6>
                </div>
                <div class="col-md-6 align-self-center">
                    <h6 class="text-uppercase">Philippine Time: 16:00:01 am 2021 June 16</h6>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        $(window).scroll(function() {
            $('nav').toggleClass('scrolled', $(this).scrollTop() > 600);
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
    </script>
</body>

</html>