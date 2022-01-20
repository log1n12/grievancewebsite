<!-- Vertical navbar -->
<div class="vertical-nav" id="sidebar">
    <a class="btn float-right closeNav" id="sidebarClose"><i class="fas fa-times fa-2x"></i></a>
    <div class="mx-0">
        <a href="#" class="brand container navbar-brand mt-4 mb-2 mx-auto">e-Habla <span class="text-muted" style="font-size: 15px;">secretary</span></a>
        <ul class="nav flex-column mb-5">
            <li class="nav-item">
                <small class="nav-link">Menu</small>
            </li>
            <li class="nav-item">
                <a href="barangay-dashboard.page.php" class="nav-link <?php if ($titleHeader == "Dashboard") {
                                                                            echo "active";
                                                                        } ?>"><i class=" fas fa-chart-pie mr-3"></i><span class="navlink">Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a href="barangay-complaint.page.php" class="nav-link <?php if ($titleHeader == "Complaint") {
                                                                            echo "active";
                                                                        } ?>"><i class="fas fa-user-edit mr-3"></i><span class="navlink">Complaints</span></a>
            </li>
            <li class="nav-item">
                <a href="barangay-report.page.php" class="nav-link <?php if ($titleHeader == "Report") {
                                                                        echo "active";
                                                                    } ?>"><i class="fas fa-sticky-note mr-3"></i></i><span class="navlink">Reports</span></a>
            </li>

            <li class="nav-item">
                <a href="barangay-rbi.page.php" class="nav-link <?php if ($titleHeader == "Records of Barangay Inhabitants") {
                                                                    echo "active";
                                                                } ?>"><i class="fas fa-users mr-3"></i><span class="navlink">RBI</span></a>
            </li>
            <li class="nav-item">
                <a href="barangay-kpreports.page.php" class="nav-link <?php if ($titleHeader == "KP Reports") {
                                                                            echo "active";
                                                                        } ?>"><i class="fas fa-file-pdf mr-3"></i></i><span class="navlink">KP Reports</span></a>
            </li>

            <li class="nav-item">
                <a href="barangay-schedules.page.php" class="nav-link <?php if ($titleHeader == "Schedules") {
                                                                            echo "active";
                                                                        } ?>"><i class="fas fa-calendar-alt mr-3"></i></i><span class="navlink">Calendar</span></a>
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