<!-- Vertical navbar -->
<div class="vertical-nav" id="sidebar">
    <a class="btn float-right closeNav" id="sidebarClose"><i class="fas fa-times fa-2x"></i></a>
    <div class="mx-0">
        <a href="#" class="brand container navbar-brand mt-4 mb-2 mx-auto">e-Habla <span class="text-muted" style="font-size: 15px;">brgy captain</span></a>
        <ul class="nav flex-column mb-5">
            <li class="nav-item">
                <small class="nav-link">Menu</small>
            </li>
            <li class="nav-item">
                <a href="barangay-captain-dashboard.page.php" class="nav-link <?php if ($titleHeader == "Dashboard") {
                                                                                    echo "active";
                                                                                } ?>"><i class=" fas fa-chart-pie mr-3"></i><span class="navlink">Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a href="barangay-captain-schedule.page.php" class="nav-link <?php if ($titleHeader == "Schedules") {
                                                                                    echo "active";
                                                                                } ?>"><i class="fas fa-calendar-alt mr-3"></i><span class="navlink">Schedules</span></a>
            </li>
            <li class="nav-item">
                <a href="barangay-captain-kpreport.page.php" class="nav-link <?php if ($titleHeader == "KP Report") {
                                                                                    echo "active";
                                                                                } ?>"><i class="far fa-file-pdf fas mr-3"></i></i><span class="navlink">Monthly Reports</span></a>
            </li>
            <li class="nav-item">
                <a href="barangay-captain-secretary.page.php" class="nav-link <?php if ($titleHeader == "Secretary") {
                                                                                    echo "active";
                                                                                } ?>"><i class="fas fa-user-tie mr-3"></i></i><span class="navlink">Secretary</span></a>
            </li>
            <li class="nav-item">
                <a href="home.page.php" class="nav-link"><i class="fas fa-globe mr-3"></i><span class="navlink">Go to Website</span></a>
            </li>
        </ul>
    </div>
    <div class="sidebar-footer text-white" id="copyright">
        &copy;<script>
            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
        </script>
        <p>BestGroup</p>
    </div>

</div>