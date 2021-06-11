<!-- Vertical navbar -->
<div class="vertical-nav" id="sidebar">
    <div class="container">
        <a href="hadmindash.php" class="brand container navbar-brand mt-4 mb-2 mx-auto">Fourth</a>
        <ul class="nav flex-column mb-5">
            <li class="nav-item">
                <small class="nav-link">Services</small>
            </li>
            <li class="nav-item">
                <a href="barangay-dashboard.page.php" class="nav-link active"><i class=" fas fa-chart-pie mr-3"></i><span class="navlink">Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a href="barangay-complaint.page.php" class="nav-link "><i class="fas fa-clinic-medical mr-3"></i><span class="navlink">Complaints</span></a>
            </li>
            <li class="nav-item">
                <a href="barangay-report.page.php" class="nav-link "><i class="far fa-hospital fas mr-3"></i></i><span class="navlink">Reports</span></a>
            </li>
            <li class="nav-item">
                <a href="barangay-archive.page.php" class="nav-link "><i class="fas fa-user mr-3"></i><span class="navlink">Archive</span></a>
            </li>
            <li class="nav-item mt-4">
                <small class="nav-link">Other</small>
            </li>
            <li class="nav-item">
                <a href="barangay-rbi.page.php" class="nav-link"><i class="fas fa-paper-plane mr-3"></i><span class="navlink">RBI</span></a>
            </li>
            <li class="nav-item">
                <a href="gotomain.php" class="nav-link" onclick="return confirm('Going to website will automatically logout your account? Do you want to proceed?')"><i class="fas fa-globe mr-3"></i><span class="navlink">Go to Website</span></a>
            </li>
        </ul>
    </div>
    <div class="sidebar-footer" id="copyright">
        &copy;<script>
            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
        </script>
        <p>BestGroup</p>
    </div>

</div>