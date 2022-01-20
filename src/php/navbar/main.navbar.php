<?php
$isLogin = "Login";
if (isset($_COOKIE['id'])) {
    $isLogin = "My Account";
}
?>
<nav class="navbar1 navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="text-capitalize" style="font-weight: 600;"><span id="phTime">Philippine Time:</span> <span id="phTime" class="mx-2" style="font-weight: 400;"></span> | <span class="ml-2" style="font-weight: 400;"><?php
                                                                                                                                                                                                                        $phToday = date(
                                                                                                                                                                                                                            "l F j, Y"
                                                                                                                                                                                                                        );
                                                                                                                                                                                                                        echo $phToday ?></span></a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item nav-link">
                    <a href="terms.page.php" style="color: #d4a94a">Terms and Condition</a>
                </li>
                <li class="nav-item nav-link">
                    <a href="privacy.page.php" style="color: #d4a94a">Privacy Policy</a>
                </li>
                <li class="nav-item nav-link">
                    <a href="faq.page.php" style="color: #d4a94a">FAQ</a>
                </li>


            </ul>
        </div>
    </div>
</nav>

<nav class="navbar2 navbar navbar-light navbar-expand-lg sticky-top padding">
    <div class="container">
        <a class="navbar-brand" href="#">
            E-HABLA
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars" style="color: #BF8C20"></i>
        </button>
        <div class="navbar-collapse collapse justify-content-end" id="navbarNavAltMarkup">
            <div class="nav navbar-nav">
                <a class="nav-item nav-link btnhover" href="home.page.php"><span class="">Home</span></a>
                <a class="nav-item nav-link btnhover" href="about.page.php"><span class="">About</span></a>
                <a class="nav-item nav-link btnhover" href="service.page.php"><span class="">Services</span></a>
                <a class="nav-item nav-link btnhover" href="contact-us.page.php"><span class="">Contact Us</span></a>
                <a class="nav-item nav-link btnhover" href="login.page.php"><?php echo $isLogin ?></a>
            </div>
        </div>

    </div>


</nav>