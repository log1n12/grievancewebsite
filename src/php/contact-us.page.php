<!DOCTYPE html>
<html>

<head>
    <title></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- External CSS -->
    <link rel="stylesheet" type="text/css" href="../css/main-contact.style.css">
</head>

<body>
    <?php include './navbar/main.navbar.php' ?>
    <section id="topBanner">
        <div class="container banner">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <h2 class="st section-title-heading text-uppercase">Contact Us</h2>
                    <h1 class="text-uppercase">Keeping <span class="accent">us</span> Close</h1>
                    <p class="text-uppercase">Don't waste your time. Be sure where you will go.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="about">
        <div class="container">
            <div class="sec-title text-center">
                <h2 class="st section-title-heading text-uppercase">DILG Contact Information</h2>
                <h1 class="text-uppercase mt-3">Where can you contact us?</h1>

            </div>
            <div class="row justify-content-center text-center about">
                <div class="col-md-4 spabout" style="background-color: #102E51;">
                    <i class="fas fa-desktop fa-3x mb-4"></i>
                    <h3>Website</h3>
                    <p class="mx-5">www.fouthlaguna.gov.ph</p>
                </div>
                <div class="col-md-4 spabout" style="background-color: #1F5493;">
                    <i class=" fas fa-paper-plane fa-3x mb-4"></i>
                    <h3>E-Mail</h3>
                    <p class="mx-5">mr.carlvincent.bermundo@gmail.com<br> b.carlvincent@yahoo.com<br>crlv.brmndo@gmail.com</p>
                </div>
                <div class="col-md-4 spabout" style="background-color: #0371BC;">
                    <i class=" fas fa-map-marker-alt fa-3x mb-4"></i>
                    <h3>Address</h3>
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
                        <h1>If you got any questions or comments about us or on the hospital we're affiliated, feel free to leave a message.</h1>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
        <div class="formm mb-5">
            <form method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="form-group">

                                <input type="text" class="form-control transparent" name="fname" placeholder="First Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control transparent" name="lname" placeholder="Last Name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control transparent" name="emailadd" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control transparent" name="mesg" placeholder="Message" rows="3" required></textarea>
                            </div>
                            <button type="submit" name="addfeedbackbtn" class="btn btn-dark btn-block btnn">Send Message</button>
                        </div>
                        <div class="col-md-2"></div>

                    </div>
                </div>
            </form>

        </div>
    </section>

    <footer class="page-footer font-small blue footer">
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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