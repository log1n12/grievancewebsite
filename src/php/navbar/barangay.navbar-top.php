<nav class="navbar navbar-expand-lg transparent topnav px-5 mt-5 mb-3">
    <!-- Toggle button -->
    <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm mr-4" data-toggle="tooltip" data-placement="top" title="Toggle Navbar"><i class="fa fa-bars"></i></button>
    <h1 class="page-title"><?php echo $titleHeader ?></h1>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <p class="nav-link name-link">Welcome Back, <span id="name" class="text-capitalize">Barangay <?php echo $barangayName ?></span> </p>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="barangay-profile.page.php"><i class="fas fa-cog"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php" onclick="return confirm('Do you want to logout?')"><i class="fas fa-sign-out-alt"></i></a>
            </li>
        </ul>

    </div>
</nav>