<?php
$isLogin = "Login";
if (isset($_COOKIE['id'])) {
    $isLogin = "My Account";
}
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top padding transparent">
    <div class="container">
        <a class="brand navbar-brand" href="main.php">Fourth</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link btnhover" href="home.page.php"><span class="">Home</span></a>
                <a class="nav-item nav-link btnhover" href="about.page.php"><span class="">About</span></a>
                <a class="nav-item nav-link btnhover" href="service.page.php"><span class="">Services</span></a>
                <a class="nav-item nav-link btnhover" href="contact-us.page.php"><span class="">Contact Us</span></a>
                <a class="nav-item nav-link btnhover" href="login.page.php"><?php echo $isLogin ?></a>
            </div>
        </div>
    </div>
</nav>