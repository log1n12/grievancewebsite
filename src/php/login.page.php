<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link rel="stylesheet" type="text/css" href="../css/login.style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">

    <title>Document</title>
</head>

<body>
    <nav id="topNav" class="navbar fixed-top navbar-toggleable-sm navbar-inverse bg-inverse transparent">
        <a class="navbar-brand mx-auto" href="home.page.php">e-Habla</a>
    </nav>
    <section id="login" style="background: rgba(0,0,0,0.8)" data-aos="fade-down" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
        <div class="container-fluid banner">
            <div class="">
                <div class="row loginform">
                    <div class="col-md-1 removeSm">

                    </div>
                    <div class="col-md-6 align-self-center removeSm">
                        <div class="title pl-5" style="padding-right: 5rem; margin-bottom: 10rem;">
                            <div class="d-flex aff">
                                <img class="mr-2" src="../assets/dilg.png" />
                                <img class="mr-2" src="../assets/44.png" />
                                <img class="mr-2" src="../assets/55.png" />
                            </div>
                            <h1 class="mb-0 pb-0">E-<span class="high">HABLA</span></h1>
                            <p class="pp mt-0 pt-0 pb-2">A WEBSITE FOR GRIEVANCES OF RESIDENTS IN MAGDALENA, LAGUNA</p>
                            <p class="ppp font-italic">The objective of this study is to develop a grievance management system that can transform and enhance the process of managing grievance cases or complaints, blotter reports, registry of barangay inhabitants and generating of reports. </p>
                        </div>

                        <div class="text-white pl-5">
                            <h6 class="mb-0 pb-0">Contact Us</h6>
                            <p class="mb-0 pb-0" style="color:rgb(214, 214, 214)">mr.carlvincent.bermundo@gmail.com</p>
                            <p class="mb-0 pb-0" style="color:rgb(214, 214, 214)">09663140838</p>
                        </div>


                    </div>
                    <div class="col-md-4 col-sm-12 align-self-center loggin">
                        <div class="form text-center" style="background-color: white; padding: 8rem 5rem">
                            <h2 class="font-weight-bold">Login</h2>
                            <p class="text-muted">Welcome back, Please login to your account.</p>
                            <hr style="padding-bottom: 2rem;">
                            <form method="post" class="text-center align-items-center">
                                <div class="px-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control input" name="username" placeholder="Username">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-0">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="password" class="form-control input" name="password" placeholder="Password">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" name="loginButton" class="btn form-control submit">Submit <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></button>
                                            <a href="#" data-toggle="modal" class="forgotPass" data-target="#goToReport">Forgot Password?</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-1 removeSm">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade " id="goToReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content px-4 py-4">
                <form method="post">
                    <div class="modal-body mb-0 pb-0">
                        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <div class="text-center">
                            <i class="fas fa-question-circle fa-5x mb-4" style=" color: #BF8C20;"></i>
                            <h3>Forgot Password?</h3>
                            <p class="text-muted mt-3">Enter the following information</p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control transparent input" name="uname" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control transparent input" name="uemail" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <select name="ubrgy" class="form-control" id="barangaySelect">
                                <?php
                                $barangayQuery = "SELECT DISTINCT barangay FROM account WHERE barangay != 'DILG' ORDER BY barangay";
                                $barangayStmt = $con->query($barangayQuery);
                                foreach ($barangayStmt as $row) {
                                    $barangayRow = $row['barangay'];

                                ?>
                                    <option value="<?php echo $barangayRow ?>"><?php echo $barangayRow ?></option>
                                <?php
                                }
                                ?>

                            </select>

                        </div>
                    </div>
                    <div class="modal-footer mt-0 pt-0">
                        <div class="col-md-12 text-center">
                            <button type="submit" name="givePassword" class="btn btn-dark text-capitalize text-center px-5 py-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="fixed-bottom text-white" style="background-color: #BF8C20;">
        <div class="row py-4">
            <div class="col-md-12 text-center">
                © 2021 Copyright:
                <a href="#" style="color: black;"> AW10Twenty.com</a>
            </div>

        </div>

    </footer>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // ALERT 
            <?php
            if ($message != "") {
                if ($confirm == "yes") {


            ?>
                    Swal.fire({

                        title: 'Success',
                        icon: 'success',
                        html: "<?php echo $message ?>"
                    });
                <?php
                } else {
                ?>
                    Swal.fire(
                        'Error',
                        "<?php echo $message; ?>",
                        'error'
                    );
            <?php
                }
            }
            ?>
        });
    </script>
</body>

</html>