<!-- Vertical navbar -->
<div class="vertical-nav" id="sidebar">
    <a class="btn float-right closeNav" id="sidebarClose"><i class="fas fa-times fa-2x"></i></a>
    <div class="container">

        <a href="#" class="brand container navbar-brand mb-2 mx-auto">e-Habla <span class="text-muted" style="font-size: 15px;">dilg</span></a>

        <ul class="nav flex-column mb-5">
            <li class="nav-item">
                <small class="nav-link smallnavlink">Menu</small>
            </li>
            <li class="nav-item">
                <a href="dilg-dashboard.page.php" class="nav-link <?php if ($titleHeader == "Dashboard") {
                                                                        echo "active";
                                                                    } ?>"><i class=" fas fa-chart-pie mr-3"></i><span class="navlink">Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a href="dilg-complaint.page.php" class="nav-link <?php if ($titleHeader == "Barangay") {
                                                                        echo "active";
                                                                    } ?>"><i class="fas fa-user-edit mr-3"></i><span class="navlink">Barangay</span></a>
            </li>
            <li class="nav-item">
                <a href="dilg-report.page.php" class="nav-link <?php if ($titleHeader == "DILG Report") {
                                                                    echo "active";
                                                                } ?>"><i class="fas fa-sticky-note mr-3"></i></i><span class="navlink">DILG Reports</span></a>
            </li>
            <li class="nav-item">
                <a href="dilg-contactus.page.php" class="nav-link <?php if ($titleHeader == "Feedback") {
                                                                        echo "active";
                                                                    } ?>"><i class="fas fa-paper-plane mr-3"></i><span class="navlink">Feedback</span></a>
            </li>
            <li class="nav-item">
                <a href="dilg-kpreport.page.php" class="nav-link <?php if ($titleHeader == "KP Report") {
                                                                        echo "active";
                                                                    } ?>"><i class="fas fa-file-alt mr-3"></i><span class="navlink">KP Reports</span></a>
            </li>
            <li class="nav-item">
                <a href="dilg-accounts.page.php" class="nav-link <?php if ($titleHeader == "Accounts") {
                                                                        echo "active";
                                                                    } ?>"><i class="fas fa-users-cog mr-3"></i><span class="navlink">Accounts</span></a>
            </li>

            <li class="nav-item mt-3">
                <small class="nav-link smallnavlink">Content Management</small>
            </li>

            <li class="nav-item">
                <a href="dilg-content.page.php" class="nav-link <?php if ($titleHeader == "Articles") {
                                                                    echo "active";
                                                                } ?>"><i class="fas fa-newspaper mr-3"></i><span class="navlink">Articles</span></a>
            </li>
            <li class="nav-item">
                <a href="dilg-gallery.page.php" class="nav-link <?php if ($titleHeader == "Gallery") {
                                                                    echo "active";
                                                                } ?>"><i class="fas fa-images mr-3"></i><span class="navlink">Gallery</span></a>
            </li>
            <li class="nav-item">
                <a href="dilg-faq.page.php" class="nav-link <?php if ($titleHeader == "Frequently Asked Questions") {
                                                                echo "active";
                                                            } ?>"><i class="fas fa-question-circle mr-3"></i><span class="navlink">FAQs</span></a>
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